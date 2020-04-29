<?php

namespace LibreNMS\OS;

use LibreNMS\Device\WirelessSensor;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessFrequencyDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessMseDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessRateDiscovery;
use LibreNMS\Interfaces\Discovery\Sensors\WirelessRssiDiscovery;
use LibreNMS\OS;

class SmOs extends OS implements
    WirelessRateDiscovery,
    WirelessRssiDiscovery,
    WirelessFrequencyDiscovery,
    WirelessMseDiscovery
{
    private $radioLabels;
    private $linkLabels;

    public function discoverWirelessRate()
    {
        $oids = snmpwalk_group($this->getDevice(), 'linkTxETHCapacity', 'SIAE-RADIO-SYSTEM-MIB', 2);
        $oids = snmpwalk_group($this->getDevice(), 'linkRxETHCapacity', 'SIAE-RADIO-SYSTEM-MIB', 2, $oids);
        $sensors = [];

        foreach ($oids as $link => $radioEntry) {
            $totalOids = ['rx' => [], 'tx' => []];

            foreach ($radioEntry as $radio => $entry) {
                $index = "$link.$radio";
                if (isset($entry['linkTxETHCapacity'])) {
                    $txOid = '.1.3.6.1.4.1.3373.1103.80.17.1.10.' . $index;
                    $totalOids['tx'][] = $txOid;
                    $sensors[] = new WirelessSensor(
                        'rate',
                        $this->getDeviceId(),
                        $txOid,
                        'tx',
                        $index,
                        $this->getLinkLabel($link) . ' Tx ' . $this->getRadioLabel($radio),
                        $entry['linkTxETHCapacity'],
                        1000
                    );
                }

                if (isset($entry['linkRxETHCapacity'])) {
                    $rxOid = '.1.3.6.1.4.1.3373.1103.80.17.1.11.' . $index;
                    $totalOids['rx'][] = $rxOid;
                    $sensors[] = new WirelessSensor(
                        'rate',
                        $this->getDeviceId(),
                        $rxOid,
                        'rx',
                        $index,
                        $this->getLinkLabel($link) . ' Rx ' . $this->getRadioLabel($radio),
                        $entry['linkRxETHCapacity'],
                        1000
                    );
                }
            }

            if (!empty($totalOids['rx'])) {
                $sensors[] = new WirelessSensor(
                    'rate',
                    $this->getDeviceId(),
                    $totalOids['rx'],
                    'total-rx',
                    $index,
                    $this->getLinkLabel($link) . ' Total Rx',
                    array_sum(array_column($radioEntry, 'linkRxETHCapacity')),
                    1000
                );
            }

            if (!empty($totalOids['tx'])) {
                $sensors[] = new WirelessSensor(
                    'rate',
                    $this->getDeviceId(),
                    $totalOids['tx'],
                    'total-tx',
                    $index,
                    $this->getLinkLabel($link) . ' Total Tx',
                    array_sum(array_column($radioEntry, 'linkTxETHCapacity')),
                    1000
                );
            }
        }

        return $sensors;
    }

    public function discoverWirelessRssi()
    {
        $oids = snmpwalk_cache_oid($this->getDevice(), 'radioPrx', array(), 'SIAE-RADIO-SYSTEM-MIB');
        $sensors = array();

        foreach ($oids as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'rssi',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.3373.1103.80.12.1.3.' . $index,
                'sm-os',
                $index,
                $this->getRadioLabel($index),
                $entry['radioPrx']
            );
        }
        return $sensors;
    }

    public function discoverWirelessFrequency()
    {
        $oids = snmpwalk_cache_oid($this->getDevice(), 'radioTxFrequency', array(), 'SIAE-RADIO-SYSTEM-MIB');
        $sensors = array();

        foreach ($oids as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'frequency',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.3373.1103.80.9.1.4.' . $index,
                'sm-os',
                $index,
                'Tx ' . $this->getRadioLabel($index),
                $entry['radioTxFrequency'],
                1,
                1000
            );
        }
        return $sensors;
    }

    public function discoverWirelessMse()
    {
        $oids = snmpwalk_cache_oid($this->getDevice(), 'radioNormalizedMse', array(), 'SIAE-RADIO-SYSTEM-MIB');
        $sensors = array();

        foreach ($oids as $index => $entry) {
            $sensors[] = new WirelessSensor(
                'mse',
                $this->getDeviceId(),
                '.1.3.6.1.4.1.3373.1103.80.12.1.5.' . $index,
                'sm-os',
                $index,
                $this->getRadioLabel($index),
                $entry['radioNormalizedMse']
            );
        }
        return $sensors;
    }

    public function getRadioLabel($index)
    {
        if (is_null($this->radioLabels)) {
            $this->radioLabels = snmpwalk_group($this->getDevice(), 'radioLabel', 'SIAE-RADIO-SYSTEM-MIB');
        }

        return $this->radioLabels[$index]['radioLabel'] ?? $index;
    }

    public function getLinkLabel($index)
    {
        if (is_null($this->linkLabels)) {
            $this->linkLabels = snmpwalk_group($this->getDevice(), 'linkLabel', 'SIAE-RADIO-SYSTEM-MIB');
        }

        return $this->linkLabels[$index]['linkLabel'] ?? $index;
    }
}
