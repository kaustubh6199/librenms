<?php
/*
 * LibreNMS
 *
 * Copyright (c) 2016 Søren Friis Rosiak <sorenrosiak@gmail.com>
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */
namespace LibreNMS\Alert\Transport;

use LibreNMS\Alert\Transport;

class Kayako extends Transport
{
    public function deliverAlert($obj, $opts)
    {
        if (!empty($this->config)) {
            $opts['url'] = $this->config['kayako-url'];
            $opts['key'] = $this->config['kayako-key'];
            $opts['secret'] = $this->config['kayako-secret'];
            $opts['user'] = $this->config['kayako-user'];
            $opts['department'] = $this->config['kayako-department'];
        }
        return $this->contactKayako($obj, $opts);
    }

    public function contactKayako($obj, $opts)
    {
        $url   = $opts['url']."/Tickets/Ticket";
        $key = $opts['key'];
        $secret = $opts['secret'];
        $user = $opts['user'];
        $department = $opts['department'];
        $ticket_type= 1;
        $ticket_status = 1;
        $ticket_prio = 1;
        $salt = mt_rand();
        $signature = base64_encode(hash_hmac('sha256', $salt, $secret, true));

        $protocol = array(
            'subject' => ($obj['name'] ? $obj['name'] . ' on ' . $obj['hostname'] : $obj['title']),
            'fullname' => 'LibreNMS Alert',
            'email' => $user,
            'contents' => strip_tags($obj['msg']),
            'departmentid' => $department,
            'ticketstatusid' => $ticket_status,
            'ticketpriorityid' => $ticket_prio,
            'tickettypeid' => $ticket_type,
            'autouserid' => 1,
            'ignoreautoresponder' => true,
            'apikey' => $key,
            'salt' => $salt,
            'signature' => $signature
        );
        $post_data = http_build_query($protocol, '', '&');
        
        $curl     = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        $ret  = curl_exec($curl);
        
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        var_dump($code);

	if ($code != 200) {
	var_dump("Kayako returned Error, retry later");
	return false;
        }
        
        return true;
    }
    
    public static function configTemplate()
    {
        return [
            'config' => [
                [
                    'title' => 'Kayako URL',
                    'name' => 'kayako-url',
                    'descr' => 'ServiceDesk API URL',
                    'type' => 'text'
                ],
                [
                    'title' => 'Kayako API Key',
                    'name' => 'kayako-key',
                    'descr' => 'ServiceDesk API Key',
                    'type' => 'text'
                ],
                [
                    'title' => 'Kayako API Secret',
                    'name' => 'kayako-secret',
                    'descr' => 'ServiceDesk API Secret Key',
                    'type' => 'text'
                ],
                [
                    'title' => 'Kayako User',
                    'name' => 'kayako-user',
                    'descr' => 'ServiceDesk API User',
                    'type' => 'text'
                ],
                [
                    'title' => 'Kayako Department',
                    'name' => 'kayako-department',
                    'descr' => 'Department to post a ticket',
                    'type' => 'text'
                ]
            ],
            'validation' => [
                'kayako-url' => 'required|url',
                'kayako-key' => 'required|string',
                'kayako-secret' => 'required|string',
                'kayako-user' => 'required|string',
                'kayako-department' => 'required|string'
            ]
        ];
    }
}
