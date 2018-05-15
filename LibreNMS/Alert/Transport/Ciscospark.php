<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2017 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */
namespace LibreNMS\Alert\Transport;

use LibreNMS\Interfaces\Alert\Transport;

class Ciscospark implements Transport
{
    public function deliverAlert($obj, $opts)
    {
        $tryDefault = true;

        if ($opts['alert']['notDefault'] == true) {
            $sql = "SELECT `config_name`, `config_value` FROM `alert_configs` WHERE `contact_id`=?";
            $details = dbFetchKeyValue($sql, [$opts['alert']['contact_id']]);
            $text = strip_tags($obj['msg']);
            $data = array (
                'roomId' => $details['room-id'],
                'text' => $text
            );
            $token = $details['api-token'];
            if ($this->sendCurl($token, $data)) {
                $tryDefault = false;
            } else {
                echo("Transport not successful, reverting back to default transport\r\n");
            }
        }
        if ($tryDefault) {
            $token  = $opts['token'];
            $roomId = $opts['roomid'];
            $text   = strip_tags($obj['msg']);
            $data   = array(
                'roomId' => $roomId,
                'text' => $text
            );

            return $this->sendCurl($token, $data);
        }
        return true;
    }

    public function sendCurl($token, $data)
    {
        $curl   = curl_init();
        set_curl_proxy($curl);
        curl_setopt($curl, CURLOPT_URL, 'https://api.ciscospark.com/v1/messages');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-type' => 'application/json',
            'Expect:',
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $ret  = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($code != 200) {
            echo("Cisco Spark returned Error, retry later\r\n");
            return false;
        }
        return true;
    }
}
