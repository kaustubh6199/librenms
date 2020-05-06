<?php
/**
 * MibController.php
 *
 * -Description-
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
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Device\Tabs;

use App\Models\Device;
use LibreNMS\Config;
use LibreNMS\Interfaces\UI\DeviceTab;

class MibController implements DeviceTab
{
    public function visible(Device $device): bool
    {
        return Config::get("poller_modules.mib") && $device->getAttrib('poll_mib');
    }

    public function slug(): string
    {
        return 'mib';
    }

    public function icon(): string
    {
        return 'fa-file-text-o';
    }

    public function name(): string
    {
        return __('MIB');
    }

    public function data(Device $device): array
    {
        return [];
    }
}
