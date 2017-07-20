<?php
/**
 * FunctionsTest.php
 *
 * tests functions in includes/functions.php
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

namespace LibreNMS\Tests;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testMacCleanToReadable()
    {
        $this->assertEquals('de:ad:be:ef:a0:c3', mac_clean_to_readable('deadbeefa0c3'));
    }

    public function testHex2Str()
    {
        $this->assertEquals('Big 10 UP', hex2str('426967203130205550'));
    }

    public function testSnmpHexstring()
    {
        $input = '4c 61 72 70 69 6e 67 20 34 20 55 00 0a';
        $this->assertEquals("Larping 4 U\n", snmp_hexstring($input));
    }

    public function testIsHexString()
    {
        $this->assertTrue(isHexString('af 28 02'));
        $this->assertTrue(isHexString('aF 28 02 CE'));
        $this->assertFalse(isHexString('a5 fj 53'));
        $this->assertFalse(isHexString('a5fe53'));
    }

    public function testHexToIp()
    {
        $this->assertSame("192.168.1.254", hex_to_ip("c0 a8 01 fe"));
        $this->assertSame("192.168.1.254", hex_to_ip("c0a801fe"));
        $this->assertSame("192.168.1.254", hex_to_ip("c0 a8 01 fe "));
        $this->assertNotSame("192.168.1.1.254", hex_to_ip("c0 a8 01 01 fe"));
        $this->assertSame("192.168.1.254", hex_to_ip("\"c0 a8 01 fe\""));
        $this->assertSame("192.168.1.254", hex_to_ip("192.168.1.254"));

        $this->assertSame('2001:db8:0:0:0:0:2:1', hex_to_ip('2001:db8:0:0:0:0:2:1'));
        $this->assertSame('2001:db8:0:0:0:0:2:1', hex_to_ip('20 01 0d b8 00 00 00 00 00 00 00 00 00 02 00 01'));
        $this->assertSame('2001:db8:0:0:0:0:2:1', hex_to_ip('20010db8000000000000000000020001'));
        $this->assertNotSame(
            '2001:db8:0:0:0:0:2:0:1',
            hex_to_ip('20 01 0d b8 00 00 00 00 00 00 00 00 00 02 00 00 00 01')
        );
    }
}
