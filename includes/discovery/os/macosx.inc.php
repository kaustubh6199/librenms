<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2015 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

if (starts_with($sysObjectId, '.1.3.6.1.4.1.8072.3.2.16') && str_contains($sysObjectId, array('Darwin Kernel Version 15', 'Darwin Kernel Version 16'))) {
    $os = 'macosx';
}
