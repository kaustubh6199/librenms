<?php

namespace LibreNMS\OS;

use LibreNMS\Device\WirelessSensor;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessDistanceDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessFrequencyDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessPowerDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessRateDiscovery;
use LibreNMS\OS;

class AirosAfLtu extends OS implements
    WirelessDistanceDiscovery,
    WirelessFrequencyDiscovery,
    WirelessPowerDiscovery,
    WirelessRateDiscovery
{
    /**
     * Discover wireless frequency.  This is in Hz. Type is frequency.
     * Returns an array of LibreNMS\Device\Sensor objects that have been discovered
     *
     * @return array Sensors
     */
    public function discoverWirelessFrequency()
    {
        $oid = '.1.3.6.1.4.1.41112.1.10.1.2.2.0'; //UBNT-AFLTU-MIB::afLTUFrequency.1
        return array(
            new WirelessSensor('frequency', $this->getDeviceId(), $oid, 'airos-af-ltu', 1, 'Radio Frequency'),
        );
    }

    /**
     * Discover wireless distance.  This is in kilometers. Type is distance.
     * Returns an array of LibreNMS\Device\Sensor objects that have been discovered
     *
     * @return array Sensors
     */
    public function discoverWirelessDistance()
    {
        $oid = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.23', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaRemoteDistance
        $oid = explode('=', $oid, 2);
        $oid = trim($oid[0]);

        return array(
            new WirelessSensor('distance', $this->getDeviceId(), $oid, 'airos-af-ltu', 1, 'Distance', null, 1, 1000),
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
        $oids = array();
        $oids['rx_power0'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.5', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaRxPower0
        $oids['rx_power1'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.6', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaRxPower1
        $oids['rx_ideal_power0'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.7', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaIdealRxPower0
        $oids['rx_ideal_power1'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.8', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaIdealRxPower1
        $oids['rx_power0_level'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.9', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaRxPowerLevel0
        $oids['rx_power1_level'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.10', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaRxPowerLevel1

        $tx_eirp_oid = '.1.3.6.1.4.1.41112.1.10.1.2.6.0'; //UBNT-AFLTU-MIB::afLTUTxEIRP

        foreach($oids as $index => $item) {
            list($oid) = explode('=', $item, 2);
            $oids[$index] = trim($oid);
        }

        return array(
            new WirelessSensor('power', $this->getDeviceId(), $oids['rx_power0'], 'airos-af-ltu-rx-chain-0', 1, 'RX Power Chain 0'),
            new WirelessSensor('power', $this->getDeviceId(), $oids['rx_power1'], 'airos-af-ltu-rx-chain-1', 1, 'RX Power Chain 1'),
            new WirelessSensor('power', $this->getDeviceId(), $oids['rx_ideal_power0'], 'airos-af-ltu-ideal-rx-chain-0', 1, 'RX Ideal Power Chain 0'),
            new WirelessSensor('power', $this->getDeviceId(), $oids['rx_ideal_power1'], 'airos-af-ltu-ideal-rx-chain-1', 1, 'RX Ideal Power Chain 1'),
            new WirelessSensor('quality', $this->getDeviceId(), $oids['rx_power0_level'], 'airos-af-ltu-level-rx-chain-0', 1, 'Signal Level Chain 0'),
            new WirelessSensor('quality', $this->getDeviceId(), $oids['rx_power1_level'], 'airos-af-ltu-level-rx-chain-1', 1, 'Signal Level Chain 1'),
            new WirelessSensor('power', $this->getDeviceId(), $tx_eirp_oid, 'airos-af-ltu-tx-eirp', 1, 'TX EIRP'),
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
        $oids['tx'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.3', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaTxCapacity
        $oids['rx'] = snmp_getnext($this->getDevice(), '.1.3.6.1.4.1.41112.1.10.1.4.1.4', '-OnQ'); //UBNT-AFLTU-MIB::afLTUStaRxCapacity

        foreach($oids as $index => $item) {
            list($oid) = explode('=', $item, 2);
            $oids[$index] = trim($oid);
        }

        return array(
            new WirelessSensor('rate', $this->getDeviceId(), $oids['tx'], 'airos-af-ltu-tx', 1, 'TX Rate', null, 1000),
            new WirelessSensor('rate', $this->getDeviceId(), $oids['rx'], 'airos-af-ltu-rx', 1, 'RX Rate', null, 1000),
        );
    }
}
