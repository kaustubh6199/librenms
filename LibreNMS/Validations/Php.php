<?php
/**
 * Php.php
 *
 * Check that various PHP modules and functions exist.
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

namespace LibreNMS\Validations;

use LibreNMS\Interfaces\ValidationGroup;
use LibreNMS\Validator;

class Php implements ValidationGroup
{
    /**
     * Validate this module.
     * To return ValidationResults, call ok, warn, fail, or result methods on the $validator
     *
     * @param Validator $validator
     */
    public function validate(Validator $validator)
    {
        $ini_tz = ini_get('date.timezone');
        $sh_tz = rtrim(shell_exec('date +%Z'));
        $php_tz = date('T');
        if (empty($ini_tz)) {
            $validator->fail(
                'You have no timezone set for php.',
                'http://php.net/manual/en/datetime.configuration.php#ini.date.timezone'
            );
        } elseif ($sh_tz !== $php_tz) {
            $validator->fail("You have a different system timezone ($sh_tz) specified to the php configured timezone ($php_tz), please correct this.");
        }

        $required_modules = array('gd','mysqli','mcrypt');
        foreach ($required_modules as $extension) {
            if (!extension_loaded($extension)) {
                $validator->fail("Missing PHP extension: $extension", "Please install $extension");
            }
        }

        $disabled_functions = explode(',', ini_get('disable_functions'));
        $required_functions = array(
            'exec',
            'passthru',
            'shell_exec',
            'escapeshellarg',
            'escapeshellcmd',
            'proc_close',
            'proc_open',
            'popen'
        );

        foreach ($required_functions as $function) {
            if (in_array($function, $disabled_functions)) {
                $validator->fail("$function is disabled in php.ini");
            }
        }

        if (!function_exists('openssl_random_pseudo_bytes')) {
            $validator->warn("openssl_random_pseudo_bytes is not being used for user password hashing. This is a recommended function (https://secure.php.net/openssl_random_pseudo_bytes)");
            if (!is_readable('/dev/urandom')) {
                $validator->warn("It also looks like we can't use /dev/urandom for user password hashing. We will fall back to generating our own hash - be warned");
            }
        }
    }

    /**
     * Returns if this test should be run by default or not.
     *
     * @return bool
     */
    public function isDefault()
    {
        return true;
    }
}
