<?php

namespace App\Jobs;

use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use LibreNMS\Config;

class DispatchPollJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @param  int  $verbosity
     * @param  bool|null  $enabled
     * @param  int|null  $find_time
     */
    public function __construct(
        public int $verbosity = -1,
        public bool|null $enabled = null,
        public int|null $find_time = null,
    ) {
        if (is_null($find_time)) {
            $this->find_time = Config::get('service_poller_frequency', Config::get('rrd.step', 300)) - 1;
        }

        if (is_null($enabled)) {
            //$this->enabled = (Config::get('polling_method') == 'scheduler');
            // Temporary until the config option above exists
            $this->enabled = (! Config::get('service_poller_enabled'));
        }
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Make sure this polling methos is enabled
        if (! $this->enabled) {
            Log::debug('You need to set polling_method to scheduler in your config ');
            return;
        }

        // Make sure we have configured job queueing
        if (\config('queue.default') == 'sync') {
            Log::error('You need to configure a QUEUE_CONNECTION driver before you can queue tasks');
            return;
        }

        $devices = DB::table('devices')
            ->select(['device_id', 'poller_group'])
            ->where('disabled', 0)
            ->where(function (Builder $query) {
                $query->whereNull('last_polled')
                    ->orWhereRaw('`last_polled` <= DATE_ADD(DATE_ADD(NOW(), INTERVAL -? SECOND), INTERVAL COALESCE(`last_polled_timetaken`, 0) SECOND)', [$this->find_time]);
            })
            ->orderBy('last_polled_timetaken', 'desc')
            ->get();

        foreach ($devices as $device) {
            // Lock this device for 30 seconds to avoid scheduling too frequently when the device is offline
            $lock = Cache::lock('device:poll:' . $device['device_id'], $this->lock_time);
            if ($lock->get()) {
                Log::debug('Submitted work for device ID ' . $device['device_id'] . ' to queue poller-' . $device['poller_group']);
                PollDevice::dispatch($device['device_id'], verbosity: $this->verbosity)->onQueue('poller-' . $device['poller_group']);
            } else {
                Log::warning('Device ID ' . $device['device_id'] . ' needs to wait more time before it can be queued again');
            }
        }
        Log::debug('Submitted work for ' . $devices->count() . ' devices');
    }
}
