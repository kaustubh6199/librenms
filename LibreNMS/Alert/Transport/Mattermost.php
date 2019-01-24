<?php
/* Copyright (C) 2018 George Pantazis <gpant@eservices-greece.com>
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
 * Mattermost API Transport
 * @author George Pantazis <gpant@eservices-greece.com>
 * @copyright 2019 George Pantazis, LibreNMS
 * @license GPL
 * @package LibreNMS
 * @subpackage Alerts
 */
namespace LibreNMS\Alert\Transport;

use LibreNMS\Alert\Transport;

class Mattermost extends Transport
{
    public function deliverAlert($obj, $opts)
    {
        if (empty($this->config)) {
            return $this->deliverAlertOld($obj, $opts);
        }
        
        $mattermost_opts = [];
        $mattermost_opts['url'] = $this->config['mattermost-url'];
        $mattermost_opts['username'] = $this->config['mattermost-username'];
        $mattermost_opts['icon'] = $this->config['mattermost-icon'];
        $mattermost_opts['channel'] = $this->config['mattermost-channel'];
        
        return $this->contactMattermost($obj, $mattermost_opts);
    }

    public function deliverAlertOld($obj, $opts)
    {
        foreach ($opts as $tmp_api) {
            $this->contactMattermost($obj, $tmp_api);
        }
        return true;
    }

    public static function contactMattermost($obj, $api)
    {
        $host = $api['url'];
        $curl = curl_init();
        $mattermost_msg = strip_tags($obj['msg']);
        $color = ($obj['state'] == 0 ? '#00FF00' : '#FF0000');
        $data = [
            'attachments' => [
                0 => [
                    'fallback' => $mattermost_msg,
                    'color' => $color,
                    'title' => $obj['title'],
                    'text' => $obj['msg'],
                    'mrkdwn_in' => ['text', 'fallback'],
                    'author_name' => $obj['hostname'],
                ],
            ],
            'channel' => $api['channel'],
            'username' => $api['username'],
            'icon_url' => $api['icon'],
        ];

        $device = device_by_id_cache($obj['device_id']);

        set_curl_proxy($curl);

        $httpheaders = array('Accept: application/json', 'Content-Type: application/json');
        $alert_payload = json_encode($data);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheaders);
        curl_setopt($curl, CURLOPT_URL, $host);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $alert_payload);

        $ret = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            d_echo("Mattermost Connection Error: " . $ret);
            return false;
        } else {
            d_echo("Mattermost message sent for " . $device);
            return true;
        }
    }

    public static function configTemplate()
    {
        return [
            'config' => [
                [
                    'title' => 'Webhook URL',
                    'name' => 'mattermost-url',
                    'descr' => 'Mattermost Webhook URL',
                    'type' => 'text',
                ],
                [
                    'title' => 'Channel',
                    'name' => 'mattermost-channel',
                    'descr' => 'Mattermost Channel',
                    'type' => 'text',
                ],
                [
                    'title' => 'Username',
                    'name' => 'mattermost-username',
                    'descr' => 'Mattermost Username',
                    'type' => 'text',
                ],
                [
                    'title' => 'Icon',
                    'name' => 'mattermost-icon',
                    'descr' => 'Icon URL',
                    'type' => 'text',
                ],
            ],
            'validation' => [
                'mattermost-url' => 'required|url',
                'mattermost-icon' => 'url',
            ],
        ];
    }
}
