<?php
namespace LibreNMS\OS;

use App\Models\WirelessSensor;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessClientsDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessApCountDiscovery;
use LibreNMS\Modules\Wireless;
use LibreNMS\OS;

class Ruckuswireless extends OS implements
    WirelessClientsDiscovery,
    WirelessApCountDiscovery
{
    public function discoverWirelessClients()
    {
        $oid = '.1.3.6.1.4.1.25053.1.2.1.1.1.15.2.0'; //RUCKUS-ZD-SYSTEM-MIB::ruckusZDSystemStatsNumSta.0
        return array(
            Wireless::discover('clients', $this->getDeviceId(), $oid, 'ruckuswireless', 1, 'Clients: Total')
        );
    }
    public function discoverWirelessApCount()
    {
        $oid = '.1.3.6.1.4.1.25053.1.2.1.1.1.15.1.0'; //RUCKUS-ZD-SYSTEM-MIB:: ruckusZDSystemStatsNumAP.0
        return array(
            Wireless::discover('ap-count', $this->getDeviceId(), $oid, 'ruckuswireless', 1, 'Connected APs')
        );
    }
}
