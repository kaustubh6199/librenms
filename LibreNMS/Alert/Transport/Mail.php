<?php
/* Copyright (C) 2014 Daniel Preussker <f0o@devilcode.org>
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. */

/**
 * Mail Transport
 * @author f0o <f0o@devilcode.org>
 * @copyright 2014 f0o, LibreNMS
 * @license GPL
 * @package LibreNMS
 * @subpackage Alerts
 */
namespace LibreNMS\Alert\Transport;

use LibreNMS\Interfaces\Alert\Transport;

class Mail implements Transport
{
    public function deliverAlert($obj, $opts)
    {
        global $config;
        if ($opts['alert']['notDefault'] == true) {
            $sql = "SELECT `transport_config` FROM `alert_transports` WHERE `transport_id`=?";
            $details = json_decode(dbFetchCell($sql, [$opts['alert']['transport_id']]), true);
            if ($details['email']) {
                // Check if query successfull
                $obj['contacts'] = $details['email'];
            } else {
                echo("Transport not successful, using default transport.\r\n");
            }
        }

        return send_mail($obj['contacts'], $obj['title'], $obj['msg'], ($config['email_html'] == 'true') ? true : false);
    }

    public static function configTemplate()
    {
        return [
            [
                'title' => 'Email',
                'name' => 'email',
                'descr' => 'Email address of contact',
                'type'  => 'text',
                'required' => true,
                'pattern' => '[a-zA-Z0-9_\-\.\+]+@\[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,18}'
            ]
        ];
    }
}
