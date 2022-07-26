<?php
/*
 * MssqlCheck.php
 *
 * check_mssql_health
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
 * @copyright  2022 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Services\Checks;

use Illuminate\Support\Collection;

class MssqlHealth extends \LibreNMS\Services\DefaultServiceCheck
{
    public function availableParameters(): Collection
    {
        $parameters = parent::availableParameters();

        $parameters->get('--server')->setHasDefault();

        return $parameters;
    }

    public function getDefault(string $flag): string
    {
        if ($flag == '--server') {
            return $this->service->service_ip ?? $this->service->device->overwrite_ip ?? $this->service->device->hostname;
        }

        return parent::getDefault($flag);
    }
}
