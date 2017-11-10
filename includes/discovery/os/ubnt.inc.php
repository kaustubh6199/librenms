<?php

if (starts_with($sysDescr, 'Linux') || starts_with($sysObjectId, '.1.3.6.1.4.1.8072.3.2.10')) {
    if (starts_with($sysObjectId, array('.1.3.6.1.4.1.10002.1', '.1.3.6.1.4.1.41112.1.4'))
        || str_contains(snmp_getnext($device, 'dot11manufacturerName', '-Osqnv', 'IEEE802dot11-MIB'), 'Ubiquiti')
    ) {
        $os = 'airos';
        if (str_contains(snmp_getnext($device, 'dot11manufacturerProductName', '-Osqnv', 'IEEE802dot11-MIB'), 'UAP')) {
            $os = 'unifi';
        } elseif (snmp_get($device, 'fwVersion.1', '-Osqnv', 'UBNT-AirFIBER-MIB', 'ubnt') !== false) {
            $os = 'airos-af';
        }
    }
}
