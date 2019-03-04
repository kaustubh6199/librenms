<?php
/*
 * LibreNMS
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 *
 * @package    LibreNMS
 * @subpackage webui
 * @link       http://librenms.org
 * @copyright  2019 LibreNMS
 * @author     LibreNMS Contributors
*/

global $config;
$graphs = [
    'fail2ban_banned' => 'Total Banned',
];

include "app.bootstrap.inc.php";

$jails = get_fail2ban_jails($device['device_id']);
include "app.fail2ban.bootstrap.inc.php";
