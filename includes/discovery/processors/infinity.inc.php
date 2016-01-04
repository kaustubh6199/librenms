<?php
/*
 * LibreNMS LigoWave Infinity CPU information module
 *
 * Copyright (c) 2015 Mike Rostermund <mike@kollegienet.dk>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if ($device['os'] == 'infinity') {
    echo 'LigoWave Infinity: ';

    $descr = 'CPU';
    $usage = snmp_get($device, '.1.3.6.1.4.1.10002.1.1.1.4.2.1.3.2', '-Ovqn');

    if (is_numeric($usage)) {
        discover_processor($valid['processor'], $device, '.1.3.6.1.4.1.10002.1.1.1.4.2.1.3.2', '0', 'infinity', $descr, '1', $usage, null, null);
    }
}

unset($processors_array);
