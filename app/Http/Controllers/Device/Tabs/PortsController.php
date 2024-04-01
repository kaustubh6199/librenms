<?php
/**
 * PortsController.php
 *
 * -Description-
 *
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
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Device\Tabs;

use App\Models\Device;
use App\Models\Link;
use App\Models\Port;
use App\Models\Pseudowire;
use LibreNMS\Interfaces\UI\DeviceTab;

class PortsController implements DeviceTab
{
    public function visible(Device $device): bool
    {
        return $device->ports()->exists();
    }

    public function slug(): string
    {
        return 'ports';
    }

    public function icon(): string
    {
        return 'fa-link';
    }

    public function name(): string
    {
        return __('Ports');
    }

    public function data(Device $device): array
    {
        $tab = \Request::segment(4);
        $data = match($tab) {
            'links' => $this->linksData($device),
            'xdsl' => $this->xdslData($device),
            default => $this->portData($device, $tab == 'detail'),
        };

        return array_merge([
            'tab' => $tab,
            'details' => empty($tab) || $tab == 'detail',
            'submenu' => [
                $this->getTabs($device),
                'Graphs' => [
                    ['name' => 'Bits', 'url' => 'bits'],
                    ['name' => 'Unicast Packets', 'url' => 'upkts'],
                    ['name' => 'Non-Unicast Packets', 'url' => 'nupkts'],
                    ['name' => 'Errors', 'url' => 'errors'],
                ],
            ],
        ], $data);
    }

    private function portData(Device $device, bool $detail): array
    {
        $relationships = ['groups', 'ipv4', 'ipv6', 'vlans', 'adsl', 'vdsl'];

        if ($detail && Config::get('enable_port_relationship')) {
            $relationships[] = 'pseudowires.endpoints';
            $relationships[] = 'links';
            $relationships[] = 'ipv4Networks';
            $relationships[] = 'ipv4Networks.ipv4';
        }


        return [
            'ports' => $device->ports()->isUp()->with($relationships)->get(), // TODO paginate
            'graphs' => [
                'bits' => [['type' => 'port_bits', 'title' => trans('Traffic'), 'vars' => [['from' => '-1d'], ['from' => '-7d'], ['from' => '-30d'], ['from' => '-1y']]]],
                'upkts' => [['type' => 'port_upkts', 'title' => trans('Packets (Unicast)'), 'vars' => [['from' => '-1d'], ['from' => '-7d'], ['from' => '-30d'], ['from' => '-1y']]]],
                'errors' => [['type' => 'port_errors', 'title' => trans('Errors'), 'vars' => [['from' => '-1d'], ['from' => '-7d'], ['from' => '-30d'], ['from' => '-1y']]]],
            ],
            'findPortNeighbors' => fn(Port $port) => $this->findPortNeighbors($port),
        ];
    }

    public function findPortNeighbors(Port $port): array
    {
        // if Loopback, skip
        if (str_contains(strtolower($port->getLabel()), 'loopback')) {
            return [];
        }

        $neighbors = [];

        // Links always included
        // fa-plus black portlink on devicelink
        foreach ($port->links as $link) {
            /** @var Link $link */
            if ($link->remote_port_id) {
                $neighbors[$link->remote_port_id] = [
                    'type' => 'link',
                    'port_id' => $link->remote_port_id,
                    'device_id' => $link->remote_device_id,
                ];
            }
        }

        // IPv4 + IPv6 subnet if detailed
        // fa-arrow-right green portlink on devicelink
        if ($port->ipv4Networks->isNotEmpty()) {
            $ids = $port->ipv4Networks->map(fn($net) => $net->ipv4->pluck('port_id'))->flatten();
            foreach ($ids as $port_id) {
                if ($port_id == $port->port_id) {
                    continue;
                }

                $neighbors[$port_id] = [
                    'type' => 'ipv4_network',
                    'port_id' => $port_id,
                ];
            }
        }

        // pseudowires
        // fa-cube green portlink on devicelink: cpwVcID
        /** @var Pseudowire $pseudowire */
        foreach ($port->pseudowires as $pseudowire) {
//            $pws = Pseudowire::where('cpwVcID', $pseudowire->cpwVcID)
//                ->whereNot('port_id', $port->port_id)->get();
            foreach ($pseudowire->endpoints as $endpoint) {
                if ($endpoint->port_id == $port->port_id) {
                    continue;
                }

                $neighbors[$endpoint->port_id] = [
                    'type' => 'pseudowire',
                    'port_id' => $endpoint->port_id,
                    'device_id' => $endpoint->device_id,
                ];
            }
        }

        // PAGP members/parent
        // fa-cube portlink: pagpGroupIfIndex = ifIndex parent
        // fa-cube portlink: if (not parent, pagpGroupIfIndex != ifIndex) ifIndex = pagpGroupIfIndex member

        // port stack
        // fa-expand portlink: local is low port
        // fa-compress portlink: local is high port

        return $neighbors;
    }

    private function xdslData(Device $device): array
    {
        $device->portsAdsl->load('port');
        $device->portsVdsl->load('port');

        return [
            'adsl' => $device->portsAdsl->sortBy('port.ifIndex'),
            'vdsl' => $device->portsVdsl->sortBy('port.ifIndex'),
        ];
    }

    private function linksData(Device $device): array
    {
        $device->links->load(['port', 'remotePort', 'remoteDevice']);

        return ['links' => $device->links];
    }


    private function getTabs(Device $device): array
    {
        $tabs = [
            ['name' => 'Basic', 'url' => 'basic'],
            ['name' => 'Detail', 'url' => ''],
        ];

        if ($device->macs()->exists()) {
            $tabs[] = ['name' => 'ARP Table', 'url' => 'arp'];
        }

        if ($device->portsFdb()->exists()) {
            $tabs[] = ['name' => 'FDB Table', 'url' => 'fdb'];
        }

        if ($device->links()->exists()) {
            $tabs[] = ['name' => 'Neighbors', 'url' => 'links'];
        }

        if ($device->portsAdsl()->exists() || $device->portsVdsl()->exists()) {
            $tabs[] = ['name' => 'xDSL', 'url' => 'xdsl'];
        }

        return $tabs;
    }
}
