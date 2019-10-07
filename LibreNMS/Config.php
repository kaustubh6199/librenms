<?php
/**
 * Config.php
 *
 * Config convenience class to access and set config variables.
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
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS;

use App\Models\GraphType;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use LibreNMS\DB\Eloquent;
use LibreNMS\Util\Version;

class Config
{
    private static $config;

    /**
     * Load the config, if the database connected, pull in database settings.
     *
     * return &array
     */
    public static function load()
    {
        if (!is_null(self::$config)) {
            return self::$config;
        }

        $config = self::loadFiles();
        $def_config = self::loadDefaults();
        $db_config = Eloquent::isConnected() ? self::loadDB() : [];

        // merge all config sources together config.php > db config > config_definitions.json
        $config = array_replace_recursive($def_config, $db_config, $config);

        // final cleanups and validations
        self::processConfig();

        // set to global for legacy/external things
        global $config;
        $config = self::$config;

        return self::$config;
    }

    /**
     * Reload the config from files/db
     * @return mixed
     */
    public static function reload()
    {
        self::$config = null;
        return self::load();
    }

    /**
     * Get the config setting definitions
     *
     * @return array
     */
    public static function getDefinitions()
    {
        return json_decode(file_get_contents(self::get('install_dir') . '/misc/config_definitions.json'), true)['config'];
    }

    private static function loadDefaults()
    {
        $def_config = [];
        $definitions = self::getDefinitions();

        foreach ($definitions as $path => $def) {
            if (isset($def['default'])) {
                Arr::set($def_config, $path, $def['default']);
            }
        }

        // load macros from json
        $macros = json_decode(file_get_contents(self::get('install_dir') . '/misc/macros.json'), true);
        Arr::set($def_config, 'alert.macros.rule', $macros);

        self::processDefaults($def_config);

        return $def_config;
    }

    /**
     * Load the user config from config.php, defaults.inc.php and definitions.inc.php, etc.
     * Erases existing config.
     *
     * @return array
     */
    private static function loadFiles()
    {
        $config = []; // start fresh

        $install_dir = realpath(__DIR__ . '/../');
        $config['install_dir'] = $install_dir;

        // Load user config
        @include $install_dir . '/config.php';

        // set it
        self::$config = $config;

        return self::$config;
    }


    /**
     * Get a config value, if non existent null (or default if set) will be returned
     *
     * @param string $key period separated config variable name
     * @param mixed $default optional value to return if the setting is not set
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }

        if (!str_contains($key, '.')) {
            return $default;
        }

        return Arr::get(self::$config, $key, $default);
    }

    /**
     * Unset a config setting
     * or multiple
     *
     * @param string|array $key
     */
    public static function forget($key)
    {
        Arr::forget(self::$config, $key);
    }

    /**
     * Get a setting from a device, if that is not set,
     * fall back to the global config setting prefixed by $global_prefix
     * The key must be the same for the global setting and the device setting.
     *
     * @param array $device Device array
     * @param string $key Name of setting to fetch
     * @param string $global_prefix specify where the global setting lives in the global config
     * @param mixed $default will be returned if the setting is not set on the device or globally
     * @return mixed
     */
    public static function getDeviceSetting($device, $key, $global_prefix = null, $default = null)
    {
        if (isset($device[$key])) {
            return $device[$key];
        }

        if (isset($global_prefix)) {
            $key = "$global_prefix.$key";
        }

        return self::get($key, $default);
    }

    /**
     * Get a setting from the $config['os'] array using the os of the given device
     * If that is not set, fallback to the same global config key
     *
     * @param string $os The os name
     * @param string $key period separated config variable name
     * @param mixed $default optional value to return if the setting is not set
     * @return mixed
     */
    public static function getOsSetting($os, $key, $default = null)
    {
        if ($os) {
            if (isset(self::$config['os'][$os][$key])) {
                return self::$config['os'][$os][$key];
            }

            if (!str_contains($key, '.')) {
                return self::get($key, $default);
            }

            $os_key = "os.$os.$key";
            if (self::has($os_key)) {
                return self::get($os_key);
            }
        }

        return self::get($key, $default);
    }

    /**
     * Get the merged array from the global and os settings for the specified key.
     * Removes any duplicates.
     * When the arrays have keys, os settings take precedence over global settings
     *
     * @param string $os The os name
     * @param string $key period separated config variable name
     * @param array $default optional array to return if the setting is not set
     * @return array
     */
    public static function getCombined($os, $key, $default = array())
    {
        if (!self::has($key)) {
            return self::get("os.$os.$key", $default);
        }

        if (!isset(self::$config['os'][$os][$key])) {
            if (!str_contains($key, '.')) {
                return self::get($key, $default);
            }
            if (!self::has("os.$os.$key")) {
                return self::get($key, $default);
            }
        }

        return array_unique(array_merge(
            (array)self::get($key, $default),
            (array)self::getOsSetting($os, $key, $default)
        ));
    }

    /**
     * Set a variable in the global config
     *
     * @param mixed $key period separated config variable name
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        Arr::set(self::$config, $key, $value);
    }

    /**
     * Save setting to persistent storage.
     *
     * @param mixed $key period separated config variable name
     * @param mixed $value
     * @return bool if the save was successful
     */
    public static function persist($key, $value)
    {
        try {
            // flatten an array if sent one as value
            $values = is_array($value) ? Arr::dot($value, "$key.") : [$key => $value];
            foreach ($values as $key => $value) {
                \App\Models\Config::updateOrCreate(['config_name' => $key], [
                    'config_name' => $key,
                    'config_value' => $value,
                ]);
                Arr::set(self::$config, $key, $value);
            }
            return true;
        } catch (QueryException $e) {
            if (class_exists(\Log::class)) {
                \Log::error($e);
            }
            global $debug;
            if ($debug) {
                echo $e;
            }
            return false;
        }
    }

    /**
     * Check if a setting is set
     *
     * @param string $key period separated config variable name
     * @return bool
     */
    public static function has($key)
    {
        if (isset(self::$config[$key])) {
            return true;
        }

        if (!str_contains($key, '.')) {
            return false;
        }

        return Arr::has(self::$config, $key);
    }

    /**
     * Serialise the whole configuration to json for use in external processes.
     *
     * @return string
     */
    public static function toJson()
    {
        return json_encode(self::$config);
    }

    /**
     * Get the full configuration array
     * @return array
     */
    public static function getAll()
    {
        return self::$config;
    }

    /**
     * merge the database config with the global config
     * Global config overrides db
     */
    private static function loadDB()
    {
        $db_config = [];

        try {
            \App\Models\Config::get(['config_name', 'config_value'])
                ->each(function ($item) use (&$db_config) {
                    Arr::set($db_config, $item->config_name, $item->config_value);
                });
        } catch (QueryException $e) {
            // possibly table config doesn't exist yet
        }

        // load graph types from the database
        self::loadGraphsFromDb($db_config);

        return $db_config;
    }

    private static function loadGraphsFromDb(&$config)
    {
        try {
            $graph_types = GraphType::all()->toArray();
        } catch (QueryException $e) {
            // possibly table config doesn't exist yet
            $graph_types = [];
        }

        // load graph types from the database
        foreach ($graph_types as $graph) {
            $g = [];
            foreach ($graph as $k => $v) {
                if (strpos($k, 'graph_') == 0) {
                    // remove leading 'graph_' from column name
                    $key = str_replace('graph_', '', $k);
                } else {
                    $key = $k;
                }
                $g[$key] = $v;
            }

            $config['graph_types'][$g['type']][$g['subtype']] = $g;
        }
    }

    /**
     * Handle defaults that are set programmatically
     *
     * @param array $def_config
     * @return array
     */
    private static function processDefaults(&$def_config)
    {
        Arr::set($def_config, 'log_dir', self::get('install_dir') . '/logs');
        Arr::set($def_config, 'distributed_poller_name', php_uname('n'));

         // set base_url from access URL
        if (isset($_SERVER['SERVER_NAME']) && isset($_SERVER['SERVER_PORT'])) {
            if (str_contains($_SERVER['SERVER_NAME'], ':')) {
                // Literal IPv6
                $base_url = 'http://['.$_SERVER['SERVER_NAME'].']'.($_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '').'/';
            } else {
                $base_url = 'http://'.$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '').'/';
            }
            Arr::set($def_config, 'base_url', $base_url);
        }

        // graph color copying
        Arr::set($def_config, 'graph_colours.mega', array_merge(
            (array)Arr::get($def_config, 'graph_colours.psychedelic', []),
            (array)Arr::get($def_config, 'graph_colours.manycolours', []),
            (array)Arr::get($def_config, 'graph_colours.default', []),
            (array)Arr::get($def_config, 'graph_colours.mixed', [])
        ));

        return $def_config;
    }

    /**
     * Process the config after it has been loaded.
     * Make sure certain variables have been set properly and
     *
     */
    private static function processConfig()
    {
        // If we're on SSL, let's properly detect it
        if (isset($_SERVER['HTTPS'])) {
            self::set('base_url', preg_replace('/^http:/', 'https:', self::get('base_url')));
            self::set('secure_cookies', true);
        }

        // If we're on SSL, let's properly detect it
        if (isset($_SERVER['HTTPS'])) {
            self::set('base_url', preg_replace('/^http:/', 'https:', self::get('base_url')));
        }

        if (self::get('secure_cookies')) {
            ini_set('session.cookie_secure', 1);
        }

        if (!self::get('email_from')) {
            self::set('email_from', '"' . self::get('project_name') . '" <' . self::get('email_user') . '@' . php_uname('n') . '>');
        }

            // Define some variables if they aren't set by user definition in config_definitions.json
        self::setDefault('html_dir', '%s/html', ['install_dir']);
        self::setDefault('rrd_dir', '%s/rrd', ['install_dir']);
        self::setDefault('mib_dir', '%s/mibs', ['install_dir']);
        self::setDefault('log_dir', '%s/logs', ['install_dir']);
        self::setDefault('log_file', '%s/%s.log', ['log_dir', 'project_id']);
        self::setDefault('plugin_dir', '%s/plugins', ['html_dir']);
        self::setDefault('temp_dir', sys_get_temp_dir() ?: '/tmp');
        self::setDefault('irc_nick', '%s', ['project_name']);
        self::setDefault('irc_chan.0', '##%s', ['project_id']);
        self::setDefault('page_title_suffix', '%s', ['project_name']);
//        self::setDefault('email_from', '"%s" <%s@' . php_uname('n') . '>', ['project_name', 'email_user']);  // FIXME email_from set because alerting config

        // deprecated variables
        self::deprecatedVariable('rrdgraph_real_95th', 'rrdgraph_real_percentile');
        self::deprecatedVariable('fping_options.millisec', 'fping_options.interval');
        self::deprecatedVariable('discovery_modules.cisco-vrf', 'discovery_modules.vrf');
        self::deprecatedVariable('oxidized.group', 'oxidized.maps.group');

        $persist = Eloquent::isConnected();
        // make sure we have full path to binaries in case PATH isn't set
        foreach (array('fping', 'fping6', 'snmpgetnext', 'rrdtool', 'traceroute', 'traceroute6') as $bin) {
            if (!is_executable(self::get($bin))) {
                if ($persist) {
                    self::persist($bin, self::locateBinary($bin));
                } else {
                    self::set($bin, self::locateBinary($bin));
                }
            }
        }
    }

    /**
     * Set default values for defaults that depend on other settings, if they are not already loaded
     *
     * @param string $key
     * @param string $value value to set to key or vsprintf() format string for values below
     * @param array $format_values array of keys to send to vsprintf()
     */
    private static function setDefault($key, $value, $format_values = [])
    {
        if (!self::has($key)) {
            if (is_string($value)) {
                $format_values = array_map('self::get', $format_values);
                self::set($key, vsprintf($value, $format_values));
            } else {
                self::set($key, $value);
            }
        }
    }

    /**
     * Copy data from old variables to new ones.
     *
     * @param $old
     * @param $new
     */
    private static function deprecatedVariable($old, $new)
    {
        if (self::has($old)) {
            global $debug;
            if ($debug) {
                echo "Copied deprecated config $old to $new\n";
            }
            self::set($new, self::get($old));
        }
    }

    /**
     * Get just the database connection settings from config.php
     *
     * @return array (keys: db_host, db_port, db_name, db_user, db_pass, db_socket)
     */
    public static function getDatabaseSettings()
    {
        // Do not access global $config in this function!

        $keys = $config = [
            'db_host' => '',
            'db_port' => '',
            'db_name' => '',
            'db_user' => '',
            'db_pass' => '',
            'db_socket' => '',
        ];

        if (is_file(__DIR__ . '/../config.php')) {
            include __DIR__ . '/../config.php';
        }

        // Check for testing database
        if (isset($config['test_db_name'])) {
            putenv('DB_TEST_DATABASE=' . $config['test_db_name']);
        }
        if (isset($config['test_db_user'])) {
            putenv('DB_TEST_USERNAME=' . $config['test_db_user']);
        }
        if (isset($config['test_db_pass'])) {
            putenv('DB_TEST_PASSWORD=' . $config['test_db_pass']);
        }

        return array_intersect_key($config, $keys); // return only the db settings
    }

    /**
     * Locate the actual path of a binary
     *
     * @param $binary
     * @return mixed
     */
    public static function locateBinary($binary)
    {
        if (!str_contains($binary, '/')) {
            $output = `whereis -b $binary`;
            $list = trim(substr($output, strpos($output, ':') + 1));
            $targets = explode(' ', $list);
            foreach ($targets as $target) {
                if (is_executable($target)) {
                    return $target;
                }
            }
        }
        return $binary;
    }
}
