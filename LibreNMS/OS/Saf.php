<?php
/**
 * Saf.php
 *
 * Saf Tehnika wireless radios
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

namespace LibreNMS\OS;

use App\Models\WirelessSensor;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessFrequencyDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessMseDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessPowerDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessRateDiscovery;
use LibreNMS\Modules\Wireless;
use LibreNMS\OS;

class Saf extends OS implements
    WirelessFrequencyDiscovery,
    WirelessMseDiscovery,
    WirelessPowerDiscovery,
    WirelessRateDiscovery
{
    /**
     * Discover wireless frequency.  This is in MHz. Type is frequency.
     * Returns an array of LibreNMS\Device\Sensor objects that have been discovered
     *
     * @return array Sensors
     */
    public function discoverWirelessFrequency()
    {
        return array(
            // SAF-IPRADIO::radioTxFrequency.local
            Wireless::discover(
                'frequency',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.10.1.9.1',
                'saf-tx',
                1,
                'Tx Frequency',
                null,
                1,
                1000
            ),
            // SAF-IPRADIO::radioRxFrequency.local
            Wireless::discover(
                'frequency',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.10.1.10.1',
                'saf-rx',
                1,
                'Rx Frequency',
                null,
                1,
                1000
            ),
        );
    }

    /**
     * Discover wireless MSE. Mean square error value *10 in dB.
     * Returns an array of LibreNMS\Device\Sensor objects that have been discovered
     *
     * @return array Sensors
     */
    public function discoverWirelessMse()
    {
        return array(
            // SAF-IPRADIO::modemRadialMSE.local
            Wireless::discover(
                'mse',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.12.1.10.1',
                'saf-radial',
                1,
                'Radial MSE',
                null,
                1,
                10
            ),
        );
    }

    /**
     * Discover wireless tx or rx power. This is in dBm. Type is power.
     * Returns an array of LibreNMS\Device\Sensor objects that have been discovered
     *
     * @return array
     */
    public function discoverWirelessPower()
    {
        return array(
            // SAF-IPRADIO::radioRxLevel.local
            Wireless::discover(
                'power',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.10.1.5.1',
                'saf-rx',
                1,
                'Rx Power'
            ),
            // SAF-IPRADIO::radioTxPower.local
            Wireless::discover(
                'power',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.10.1.4.1',
                'saf-tx',
                1,
                'Tx Power'
            ),
        );
    }

    /**
     * Discover wireless rate. This is in bps. Type is rate.
     * Returns an array of LibreNMS\Device\Sensor objects that have been discovered
     *
     * @return array
     */
    public function discoverWirelessRate()
    {
        return array(
            // SAF-IPRADIO::modemACMtotalCapacity.local
            Wireless::discover(
                'rate',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.12.1.18.1',
                'saf-acm',
                1,
                'ACM Capacity',
                null,
                1000
            ),
            // SAF-IPRADIO::modemTotalCapacity.local
            Wireless::discover(
                'rate',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.7571.100.1.1.5.1.1.1.12.1.6.1',
                'saf-total',
                1,
                'Total Capacity',
                null,
                1000
            ),
        );
    }
}
