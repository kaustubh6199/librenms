<?php
/* Copyright (C) 2020 Raphael Dannecker <rdannecker@gmail.com>
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>. */

/**
 * UKFastPSS Transport
 * @author Lee Spottiswood (github.com/0x4c6565)
 * @copyright 2021, LibreNMS
 * @license GPL
 */

namespace LibreNMS\Alert\Transport;

use LibreNMS\Alert\Transport;

class Ukfastpss extends Transport
{
    public function deliverAlert($obj, $opts)
    {
        $apiKey = $this->config['api-key'];
        $author = $this->config['author'];
        $secure = $this->config['secure'];
        $priority = $this->config['priority'];

        $body = [
            'author' => [
                'id' => $author
            ],
            'secure' => ($secure == "on"),
            'subject' => $obj['title'],
            'details' => $obj['msg'],
            'priority' => $priority
        ];

        $request_opts = [];
        $request_heads = [];


        $request_heads['Authorization'] = $apiKey;
        $request_heads['Content-Type'] = 'application/json';
        $request_heads['Accept'] = 'application/json';

        $client = new \GuzzleHttp\Client();
        $request_opts['proxy'] = get_guzzle_proxy();
        $request_opts['headers'] = $request_heads;
        $request_opts['body'] = json_encode($body);
        $request_opts['verify'] = false;

        $res = $client->request('POST', "https://kong-01.rnd.ukfast/pss/v1/requests", $request_opts);

        $code = $res->getStatusCode();
        if ($code != 200) {
            var_dump("UKFast PSS API returned Error");
            var_dump('Params:');
            var_dump('Response headers:');
            var_dump($res->getHeaders());
            var_dump('Return: ' . $res->getReasonPhrase());

            return 'HTTP Status code ' . $code;
        }

        return true;
    }

    public static function configTemplate()
    {
        return [
            'config' => [
                [
                    'title' => 'API Key',
                    'name' => 'api-key',
                    'descr' => 'API key to use for authentication',
                    'type' => 'text',
                ],
                [
                    'title' => 'Author',
                    'name' => 'author',
                    'descr' => 'Author ID for new PSS request',
                    'type' => 'text',
                ],
                [
                    'title' => 'Priority',
                    'name' => 'priority',
                    'descr' => 'Priority of request. Defaults to "Normal"',
                    'type' => 'select',
                    'options' => [
                        'Normal' => 'Normal',
                        'High' => 'High',
                        'Critical' => 'Critical',
                    ],
                    'default' => 'Normal',
                ],
                [
                    'title' => 'Secure',
                    'name' => 'secure',
                    'descr' => 'Specifies whether created request should be secure',
                    'type'  => 'checkbox',
                    'default' => true,
                ],
            ],
            'validation' => [
                'api-key' => 'required',
                'author' => 'required',
            ],
        ];
    }
}
