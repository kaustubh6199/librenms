<?php

namespace App\Console\Commands;

use App\Console\LnmsCommand;
use App\Events\DevicePolled;
use App\Jobs\PollDevice;
use App\Models\Device;
use App\Polling\Measure\MeasurementManager;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use LibreNMS\Config;
use LibreNMS\Polling\Result;
use LibreNMS\Util\Module;
use LibreNMS\Util\Version;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DevicePoll extends LnmsCommand
{
    protected $name = 'device:poll';
    private ?int $current_device_id = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->addArgument('device spec', InputArgument::REQUIRED);
        $this->addOption('modules', 'm', InputOption::VALUE_REQUIRED);
        $this->addOption('no-data', 'x', InputOption::VALUE_NONE);
        $this->addOption('dispatch', 'd', InputOption::VALUE_NONE);
    }

    public function handle(MeasurementManager $measurements): int
    {
        if ($this->argument('device spec') == '-') {
            $stdin = fopen('php://stdin', 'r');
            $job_args = [];
	    $temp_ags = array_filter($this->options());
            array_walk(array_filter($temp_args, function ($val, $opt) use (&$job_args) {
                if ($opt !== 'verbose') {
                    $job_args["--$opt"] = $val;
                }
            });

            $verbosity = $this->getOutput()->getVerbosity();
            if ($verbosity >= 256) {
                $job_args['-vvv'] = true;
            } elseif ($verbosity >= 128) {
                $job_args['-vv'] = true;
            } elseif ($verbosity >= 64) {
                $job_args['-v'] = true;
            }

            while ($line = trim(fgets($stdin))) {
                $job_args['device spec'] = $line;
                Artisan::call('device:poll', $job_args);
            }

            fclose($stdin);

            return 0;
        }

        $this->configureOutputOptions();

        if ($this->option('dispatch')) {
            return $this->dispatchWork();
        }

        if ($this->option('no-data')) {
            Config::set('rrd.enable', false);
            Config::set('influxdb.enable', false);
            Config::set('influxdbv2.enable', false);
            Config::set('prometheus.enable', false);
            Config::set('graphite.enable', false);
        }

        try {
            if ($this->getOutput()->isVerbose()) {
                Log::debug(Version::get()->header());
                \LibreNMS\Util\OS::updateCache(true); // Force update of OS Cache
            }

            $module_overrides = Module::parseUserOverrides(explode(',', $this->option('modules') ?? ''));
            $this->printModules($module_overrides);

            $result = new Result;

            $this->line("Starting polling run:\n");

            // listen for the device polled events to mark the device completed
            Event::listen(function (DevicePolled $event) use ($result) {
                if ($event->device->device_id == $this->current_device_id) {
                    $result->markCompleted($event->device->status);
                }
            });

            foreach (Device::whereDeviceSpec($this->argument('device spec'))->pluck('device_id') as $device_id) {
                $this->current_device_id = $device_id;
                $result->markAttempted();
                PollDevice::dispatchSync($device_id, $module_overrides);
            }

            if ($result->hasAnyCompleted()) {
                if (! $this->output->isQuiet()) {
                    if ($result->hasMultipleCompleted()) {
                        $this->output->newLine();
                        $time_spent = sprintf('%0.3fs', $measurements->getCategory('device')->getSummary('poll')->getDuration());
                        $this->line(trans('commands.device:poll.polled', ['count' => $result->getCompleted(), 'time' => $time_spent]));
                    }
                    $this->output->newLine();
                    $measurements->printStats();
                }

                return 0;
            }

            // polled 0 devices, maybe there were none to poll
            if ($result->hasNoAttempts()) {
                $this->error(trans('commands.device:poll.errors.no_devices'));

                return 1;
            }

            // attempted some devices, but none were up.
            if ($result->hasNoCompleted()) {
                $this->line('<fg=red>' . trans_choice('commands.device:poll.errors.none_up', $result->getAttempted()) . '</>');

                return 6;
            }
        } catch (QueryException $e) {
            if ($e->getCode() == 2002) {
                $this->error(trans('commands.device:poll.errors.db_connect'));

                return 1;
            } elseif ($e->getCode() == 1045) {
                // auth failed, don't need to include the query
                $this->error(trans('commands.device:poll.errors.db_auth', ['error' => $e->getPrevious()->getMessage()]));

                return 1;
            }

            $this->error($e->getMessage());

            return 1;
        }

        $this->error(trans('commands.device:poll.errors.none_polled'));

        return 1; // failed to poll
    }

    private function dispatchWork()
    {
        $module_overrides = Module::parseUserOverrides(explode(',', $this->option('modules') ?? ''));
        $devices = Device::whereDeviceSpec($this->argument('device spec'))->select('device_id', 'poller_group')->get();

        if (\config('queue.default') == 'sync') {
            $this->error('Queue driver is sync, work will run in process.');
            sleep(1);
        }

        foreach ($devices as $device) {
            Log::debug('Submitted work for device ID ' . $device['device_id'] . ' to queue poller-' . $device['poller_group']);
            PollDevice::dispatch($device['device_id'], $module_overrides)->onQueue('poller-' . $device['poller_group']);
        }

        $this->line('Submitted work for ' . $devices->count() . ' devices');

        return 0;
    }

    private function printModules(array $module_overrides): void
    {
        if (! empty($module_overrides)) {
            $modules = array_map(function ($module, $status) {
                return $module . (is_array($status) ? '(' . implode(',', $status) . ')' : '');
            }, array_keys($module_overrides), array_values($module_overrides));

            Log::debug('Override poller modules: ' . implode(', ', $modules));
        }
    }
}
