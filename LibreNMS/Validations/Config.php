<?php
/**
 * Config.php
 *
 * Checks various config settings are correct.
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

use LibreNMS\Config as Configuration;
use LibreNMS\Interfaces\ValidationGroup;
use LibreNMS\Validator;

class Config implements ValidationGroup
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
                'You have no timezone set for php.'
            );
        } elseif ($sh_tz !== $php_tz) {
            $validator->fail("You have a different system timezone ($sh_tz) specified to the php configured timezone ($php_tz), please correct this.");
        }

        // Test transports
        if (Configuration::get('alerts.email.enable') == true) {
            $validator->warn('You have the old alerting system enabled - this is to be deprecated on the 1st of June 2015: https://groups.google.com/forum/#!topic/librenms-project/1llxos4m0p4');
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
