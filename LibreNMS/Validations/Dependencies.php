<?php
/**
 * Dependencies.php
 *
 * Checks libraries
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
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Validations;

use LibreNMS\ValidationResult;
use LibreNMS\Validator;

class Dependencies extends BaseValidation
{
    /**
     * Validate this module.
     * To return ValidationResults, call ok, warn, fail, or result methods on the $validator
     *
     * @param Validator $validator
     */
    public function validate(Validator $validator)
    {
        $composer_output = trim(shell_exec($validator->getBaseDir() . '/scripts/composer_wrapper.php --version'));
        $found = preg_match('/Composer (version )?([.0-9]+)/', $composer_output, $matches);

        if (!$found) {
            $validator->fail("No composer available, please install composer", "https://getcomposer.org/");
            return;
        } else {
            $validator->ok("Composer Version: " . $matches[2]);
        }

        $dep_check = shell_exec($validator->getBaseDir() . '/scripts/composer_wrapper.php install --no-dev --dry-run');
        preg_match_all('/Installing ([^ ]+\/[^ ]+) \(/', $dep_check, $dep_missing);
        if (!empty($dep_missing[0])) {
            $result = ValidationResult::fail("Missing dependencies!", "composer install --no-dev");
            $result->setList("Dependencies", $dep_missing[1]);
            $validator->result($result);
        }
        preg_match_all('/Updating ([^ ]+\/[^ ]+) \(/', $dep_check, $dep_outdated);
        if (!empty($dep_outdated[0])) {
            $result = ValidationResult::fail("Outdated dependencies", "composer install --no-dev");
            $result->setList("Dependencies", $dep_outdated[1]);
        }

        if (empty($dep_missing[0]) && empty($dep_outdated[0])) {
            $validator->ok("Dependencies up-to-date.");
        }
    }
}
