<?php
/**
 * DeviceTest.php
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
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Tests\Unit;

use App\Models\Device;
use App\Models\Ipv4Address;
use App\Models\Port;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use LibreNMS\Tests\LaravelTestCase;

class DeviceTest extends LaravelTestCase
{
    use DatabaseTransactions;

    public function testFindByHostname()
    {
        $device = factory(Device::class)->create();

        $found = Device::findByHostname($device->hostname);
        $this->assertNotNull($found);
        $this->assertEquals($device->device_id, $found->device_id, "Did not find the correct device");
    }

    public function testFindByIp()
    {
        $device = factory(Device::class)->create();

        $found = Device::findByHostname($device->hostname);
        $this->assertNotNull($found);
        $this->assertEquals($device->device_id, $found->device_id, "Did not find the correct device");
    }

    public function testFindByIpHostname()
    {
        $ip = '192.168.234.32';
        $device = factory(Device::class)->create(['hostname' => $ip]);

        $found = Device::findByHostname($device->hostname);
        $this->assertNotNull($found);
        $this->assertEquals($device->device_id, $found->device_id, "Did not find the correct device");
    }

    public function testFindByIpThroughPort()
    {
        $device = factory(Device::class)->create();
        $port = factory(Port::class)->make();
        $device->ports()->save($port);
        $ipv4 = factory(Ipv4Address::class)->make(); // test ipv4 lookup of device
        $port->ipv4()->save($ipv4);

        $found = Device::findByHostname($device->hostname);
        $this->assertNotNull($found);
        $this->assertEquals($device->device_id, $found->device_id, "Did not find the correct device");
    }
}
