<?php

namespace App\Http\Controllers\Api\Device;

use App\Models\Device;
use App\Models\Port;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class DevicePortAddressController extends ApiController
{
    /**
     * @api {get} /api/v1/devices/:id/ports/:port_id/addresses Get device port addresses
     * @apiName Get_Device_Port_Addresses
     * @apiGroup Device Ports
     * @apiVersion  1.0.0
     *
     * @apiUse DeviceParam
     * @apiParam {Number} port_id ID of the port
     *
     * @apiExample {curl} Example usage:
     *     curl -H 'X-Auth-Token: YOURAPITOKENHERE' -H "Content-Type:application/json" -i http://example.org/api/v1/devices/1/ports/23/addresses
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "data":
     *          {
     *              "ipv4": [
     *                  {
     *                         "ipv4_address_id": 28,
     *                         "ipv4_address": "10.51.100.52",
     *                         "ipv4_prefixlen": "24",
     *                         "ipv4_network_id": "10",
     *                         "port_id": "23",
     *                         "context_name": ""
     *                  }
     *              ],
     *              "ipv6": []
     *          }
     *     }
     *
     * @apiUse NotFoundError
     */
    public function index(Port $port)
    {
        return $this->objectResponse(['ipv4' => $port->ipv4()->get(), 'ipv6' => $port->ipv6()->get()]);
    }
}
