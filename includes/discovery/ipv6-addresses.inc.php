<?php
/**
 * added Jetstream OS IPv6 address discovery
 *
 * @author     Peca Nesovanovic <peca.nesovanovic@sattrakt.com>
 */
foreach (DeviceCache::getPrimary()->getVrfContexts() as $context_name) {
    $device['context_name'] = $context_name;

    if ($device['os'] == 'jetstream') {
        $oids = snmp_walk($device, 'ipv6ParaConfigAddrTable', ['-OsQ', '-Ln', '-Cc'], 'TPLINK-IPV6ADDR-MIB');
        $oids = trim($oids);
        $v6data = [];
        foreach (explode("\n", $oids) as $data) {
            $param = explode('.', $data)[0];
            $index = explode('.', $data)[1]; //if index
            $atype = explode('.', $data)[3];
            $erase = $param . '.' . $index . '.ipv6.' . $atype . '.'; //this will be erased from line
            $link = trim(explode('=', str_replace($erase, '', $data))[0]);
            $value = trim(explode('=', $data)[1]);
            if ($param == 'ipv6ParaConfigAddress') {
                $v6data[$link]['index'] = $index;
                $split = str_split(str_replace(' ', '', strtolower($value)), 4); //convert space delimited hex IPv6 address to array, every forth char
                $v6data[$link]['addr'] = implode(':', $split); //assemble array in 0000:1111 format
                $v6data[$link]['origin'] = ($atype == 'autoIp' ? 'linklayer' : 'manual'); //address type
            }
            if ($param == 'ipv6ParaConfigPrefixLength') {
                $prefixlen = intval($value);
                discover_process_ipv6($valid, $v6data[$link]['index'], $v6data[$link]['addr'], $prefixlen, $v6data[$link]['origin'], $device['context_name']);
            }
        } //end foreach
    } else {
        $oids = snmp_walk($device, 'ipAddressIfIndex.ipv6', ['-Osq', '-Ln'], 'IP-MIB');
        $oids = str_replace('ipAddressIfIndex.ipv6.', '', $oids);
        $oids = str_replace('"', '', $oids);
        $oids = str_replace('IP-MIB::', '', $oids);
        $oids = trim($oids);

        foreach (explode("\n", $oids) as $data) {
            if ($data) {
                $data = trim($data);
                [$ipv6addr,$ifIndex] = explode(' ', $data);
                $oid = '';
                $sep = '';
                $adsep = '';
                unset($ipv6_address);
                $do = '0';
                foreach (explode(':', $ipv6addr) as $part) {
                    $n = hexdec($part);
                    $oid = "$oid" . "$sep" . "$n";
                    $sep = '.';
                    $ipv6_address = $ipv6_address . "$adsep" . $part;
                    $do++;
                    if ($do == 2) {
                        $adsep = ':';
                        $do = '0';
                    } else {
                        $adsep = '';
                    }
                }

                $ipv6_prefixlen = snmp_get($device, ".1.3.6.1.2.1.4.34.1.5.2.16.$oid", '', 'IP-MIB');
                $ipv6_prefixlen = explode('.', $ipv6_prefixlen);
                $ipv6_prefixlen = str_replace('"', '', end($ipv6_prefixlen));

                if (Str::contains($ipv6_prefixlen, 'SNMPv2-SMI::zeroDotZero')) {
                    d_echo('Incomplete IPv6 data in IF-MIB');
                    $oids = trim(Str::replaceFirst($data, '', $oids));
                }

                $ipv6_origin = snmp_get($device, ".1.3.6.1.2.1.4.34.1.6.2.16.$oid", '-Ovq', 'IP-MIB');

                discover_process_ipv6($valid, $ifIndex, $ipv6_address, $ipv6_prefixlen, $ipv6_origin, $device['context_name']);
            } //end if
        } //end foreach
    } //end 'else'

    if (empty($oids)) {
        $oids = snmp_walk($device, 'ipv6AddrPfxLength', ['-OsqnU', '-Ln'], 'IPV6-MIB');
        $oids = str_replace('.1.3.6.1.2.1.55.1.8.1.2.', '', $oids);
        $oids = str_replace('"', '', $oids);
        $oids = trim($oids);

        foreach (explode("\n", $oids) as $data) {
            if ($data) {
                $data = trim($data);
                [$if_ipv6addr,$ipv6_prefixlen] = explode(' ', $data);
                [$ifIndex,$ipv6addr] = explode('.', $if_ipv6addr, 2);
                $ipv6_address = snmp2ipv6($ipv6addr);
                $ipv6_origin = snmp_get($device, "IPV6-MIB::ipv6AddrType.$if_ipv6addr", '-Ovq', 'IPV6-MIB');
                discover_process_ipv6($valid, $ifIndex, $ipv6_address, $ipv6_prefixlen, $ipv6_origin, $device['context_name']);
            } //end if
        } //end foreach
    } //end if

    $sql = 'SELECT `ipv6_addresses`.*, `ports`.`device_id`, `ports`.`ifIndex` FROM `ipv6_addresses`';
    $sql .= ' LEFT JOIN `ports` ON `ipv6_addresses`.`port_id` = `ports`.`port_id`';
    $sql .= ' WHERE `ports`.device_id = ? OR `ports`.`device_id` IS NULL';
    foreach (dbFetchRows($sql, [$device['device_id']]) as $row) {
        $full_address = $row['ipv6_address'] . '/' . $row['ipv6_prefixlen'];
        $port_id = $row['port_id'];
        $valid_address = $full_address . '-' . $port_id;
        if (! $valid['ipv6'][$valid_address]) {
            echo '-';
            $query = dbDelete('ipv6_addresses', '`ipv6_address_id` = ?', [$row['ipv6_address_id']]);
            if (! dbFetchCell('SELECT COUNT(*) FROM `ipv6_addresses` WHERE `ipv6_network_id` = ?', [$row['ipv6_network_id']])) {
                $query = dbDelete('ipv6_networks', '`ipv6_network_id` = ?', [$row['ipv6_network_id']]);
            }
        }
    }

    echo "\n";
    unset($device['context_name']);
}
unset($vrfs_c);
