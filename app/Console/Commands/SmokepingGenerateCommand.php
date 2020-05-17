<?php
/**
 * SmokepingGenerateCommand.php
 *
 * CLI command to generate a smokeping configuration.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2020 Adam Bishop
 * @author     Adam Bishop <adam@omega.org.uk>
 */

namespace App\Console\Commands;

use App\Console\LnmsCommand;
use App\Models\Device;
use LibreNMS\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SmokepingGenerateCommand extends LnmsCommand
{
    protected $name = 'smokeping:generate';
    private $ip4count = 0;
    private $ip6count = 0;
    private $warnings = [];

    const IP4PROBE = 'lnmsFPing-';
    const IP6PROBE = 'lnmsFPing6-';

    // These entries are solely used to appease the smokeping config parser and serve no function
    const DEFAULTIP4PROBE = 'lnmsFPing';
    const DEFAULTIP6PROBE = 'lnmsFPing6';
    const DEFAULTPROBE = self::DEFAULTIP4PROBE;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDescription(__('commands.smokeping:generate.description'));

        $this->addOption('probes', null, InputOption::VALUE_NONE);
        $this->addOption('targets', null, InputOption::VALUE_NONE);
        $this->addOption('no-header', null, InputOption::VALUE_NONE);
        $this->addOption('single-process', null, InputOption::VALUE_NONE);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!Config::has('smokeping.probes') ||
            !Config::has('fping') ||
            !Config::has('fping6')
        ) {
            $this->error(__('commands.smokeping:generate.config-insufficient'));
            return 1;
        }

        if ($this->option('probes') xor $this->option('targets')) {
            $this->error(__('commands.smokeping:generate.args-nonsense'));
            return 2;
        }

        $devices = Device::isNotDisabled()->orderBy('type')->get();

        if (sizeof($devices) <= 0) {
            $this->error(__('commands.smokeping:generate.no-devices'));
            return 3;
        }

        return run($devices);       
    }

    /**
     * Build and output the configuration
     *
     * @param array $devices List of device objects
     *
     * @return int
     */
    private function run($devices)
    {
        if ($this->option('probes')) {
            $probes = $this->assembleProbes();
            $header = $this->buildHeader();

            $this->render($header, $probes);
            return 0;
        } elseif ($this->option('targets')) {
            // Take the devices array and build it into a hierarchical list
            foreach ($devices as $device) {
                $smokelist[$device->type][$device->hostname] = ['transport' => $device->transport];
            }

            $targets = $this->buildTargets($smokelist);
            $header = $this->buildHeader();

            $this->render($header, $targets);
            return 0;
        }

        return 4;
    }

    /**
     * Take config lines and output them to stdout
     *
     * @param array ...$blocks Blocks of smokeping configuration arranged in arrays of strings
     *
     * @return array
     */
    private function render(...$blocks)
    {
        foreach (array_merge(...$blocks) as $line) {
            $this->line($line);
        }
    }

    /**
     * Generate a header to append to the smokeping configuration file
     *
     * @return array
     */
    private function buildHeader()
    {
        if (!$this->option('no-header')) {
            $lines[] = sprintf('# %s', __('commands.smokeping:generate.header-first'));
            $lines[] = sprintf('# %s', __('commands.smokeping:generate.header-second'));
            $lines[] = sprintf('# %s', __('commands.smokeping:generate.header-third'));
 
            return array_merge($lines, $this->warnings, ['']);
        }

        return [''];
    }

    /**
     * Bring together the probe lists
     *
     * @return array
     */
    private function assembleProbes()
    {
        return array_merge($lines, $this->buildprobes4(), $this->buildprobes6());
    }

    /**
     * Build a list of IPv4 probes
     *
     * @return array
     */
    private function buildprobes4()
    {
        return $this->buildProbes('FPing', self::DEFAULTIP4PROBE, self::IP4PROBE, Config::get('fping'));
    }

    /**
     * Build a list of IPv6 probes
     *
     * @return array
     */
    private function buildprobes6()
    {
        return $this->buildProbes('FPing6', self::DEFAULTIP6PROBE, self::IP6PROBE, Config::get('fping6'));
    }

    /**
     * Determine if a list of probes is needed, and write one if so
     *
     * @param array $module The smokeping module to use for this probe (FPing or FPing6, typically)
     * @param array $defaultProbe A default probe, needed by the smokeping configuration parser
     * @param array $probe The first part of the probe name, e.g. 'lnmsFPing' or 'lnmsFPing6'
     * @param array $binary Path to the relevant probe binary (i.e. the output of `which fping` or `which fping6`)
     *
     * @return array
     */
    private function buildProbes($module, $defaultProbe, $probe, $binary)
    {
        $lines[] = sprintf('+ %s', $module);
        $lines[] = sprintf('  binary = %s', $binary);
        $lines[] = '  blazemode = true';
        $lines[] = sprintf('++ %s', $defaultProbe);

        for ($i = 0; $i < Config::get('smokeping.probes'); $i++) {
            $lines[] = sprintf('++ %s%s', $probe, $i);
        }

        $lines[] = '';

        return $lines;
    }

    /**
     * Determine if a list of targets is needed, and write one if so
     *
     * @param array $smokelist A hierarchy of devices and groups to create a target list for
     *
     * @return array
     */
    private function buildTargets($smokelist)
    {
        foreach ($smokelist as $type => $devices) {
            $lines[] = sprintf('+ %s', $this->buildMenuEntry($type));
            $lines[] = sprintf('  menu = %s', $type);
            $lines[] = sprintf('  title = %s', $type);

            $lines[] = '';

            $lines = array_merge($lines, $this->buildDevices($devices));
        }

        return $lines;
    }

    /**
     * Build the configuration for a set of devices inside a type block
     *
     * @param array $devices A list of devices to create a a config block for
     *
     * @return array
     */
    private function buildDevices($devices)
    {
        $lines = [];

        foreach ($devices as $hostname => $config) {
            if ($this->deviceIsResolvable($hostname)) {
                $lines[] = sprintf('++ %s', $this->buildMenuEntry($hostname));
                $lines[] = sprintf('   menu = %s', $hostname);
                $lines[] = sprintf('   title = %s', $hostname);

                if (!$this->option('single-process')) {
                    $lines[] = sprintf('   probe = %s', $this->balanceProbes($config['transport']));
                }

                $lines[] = sprintf('   host = %s', $hostname);
                $lines[] = '';
            }
        }

        return $lines;
    }

    /**
     * Smokeping refuses to load if it has an unresolvable host, so check for this
     *
     * @param string $hostname Hostname to be checked
     *
     * @return bool
     */
    private function deviceIsResolvable($hostname)
    {
        // First we check for IP literals, then for a dns entry, finally for a hosts entry due to a PHP/libc limitation
        // We look for the hosts entry last (and separately) as this only works for v4 - v6 host entries won't be found
        if (filter_var($hostname, FILTER_VALIDATE_IP) || checkdnsrr($hostname, 'ANY') || is_array(gethostbynamel($hostname))) {
            return true;
        }

        $this->warnings[] = sprintf('# "%s" %s', $hostname, __('commands.smokeping:generate.dns-fail'));
        return false;
    }

    /**
     * Rewrite menu entries to a format that smokeping finds acceptable
     *
     * @param string $entry The LibreNMS device hostname to rewrite
     *
     * @return string
     */
    private function buildMenuEntry($entry)
    {
        return str_replace(['.', ' '], '_', $entry);
    }

    /**
     * Select a probe to use deterministically.
     *
     * @param string $transport The transport (udp or udp6) as per the device database entry
     *
     * @return string
     */
    private function balanceProbes($transport)
    {
        if ($transport === 'udp') {
            if ((Config::get('smokeping.probes')) === $this->ip4count) {
                $this->ip4count = 0;
            }

            return sprintf('%s%s', self::IP4PROBE, $this->ip4count++);
        }

        if ((Config::get('smokeping.probes')) === $this->ip6count) {
            $this->ip6count = 0;
        }

        return sprintf('%s%s', self::IP6PROBE, $this->ip6count++);
    }
}
