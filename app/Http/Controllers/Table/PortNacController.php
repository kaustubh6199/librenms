<?php
/**
 * PortNacController.php
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
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Table;

use App\Models\Port;
use App\Models\PortsNac;
use LibreNMS\Util\Mac;
use LibreNMS\Util\Url;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PortNacController extends TableController
{
    public function rules()
    {
        return [
            'device_id' => 'nullable|integer',
            'searchby' => 'in:mac,vlan,ip,port,description,first_seen,last_seen,vendor',
        ];
    }

    public function searchFields($request)
    {
        return ['username', 'ip_address', 'mac_address'];
    }

    protected function sortFields($request)
    {
        return [
            'device_id',
            'port_id',
            'mac_address',
            'mac_oui',
            'ip_address',
            'vlan',
            'domain',
            'host_mode',
            'username',
            'authz_by',
            'timeout',
            'time_elapsed',
            'time_left',
            'authc_status',
            'authz_status',
            'method',
        ];
    }

    /**
     * Defines the base query for this resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function baseQuery($request)
    {
        return PortsNac::select('device_id', 'port_id', 'mac_address', 'ip_address', 'vlan', 'domain', 'host_mode', 'username', 'authz_by', 'timeout', 'time_elapsed', 'time_left', 'authc_status', 'authz_status', 'method')
            ->when($request->device_id, fn ($q, $id) => $q->where('device_id', $id))
            ->hasAccess($request->user())
            ->with('port')
            ->with('device');
    }

    /**
     * @param  string  $search
     * @param  Builder  $query
     * @param  array  $fields
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    protected function search($search, $query, $fields = [])
    {
        if ($search = trim(\Request::get('searchPhrase') ?? '')) {
            $mac_search = '%' . str_replace([':', ' ', '-', '.', '0x'], '', $search) . '%';

            switch (\Request::get('searchby') ?? '') {
                case 'mac':
                    return $query->where('ports_nac.mac_address', 'like', $search);
                case 'vlan':
                    return $query->whereIntegerInRaw('ports_nac.vlan', $this->findVlans($search));
                case 'ip':
                    return $query->whereIn('ports_nac.ip_address', $search);
                case 'description':
                    return $query->whereIntegerInRaw('ports_nac.port_id', $this->findPorts($search));
                case 'vendor':
                    $vendor_ouis = $this->ouisFromVendor($search);

                    return $this->findPortsByOui($vendor_ouis, $query);
                default:
                    return $query->where(function ($query) use ($search, $mac_search) {
                        $vendor_ouis = $this->ouisFromVendor($search);
                        
                        $this->findPortsByOui($vendor_ouis, $query)
                            ->orWhereIntegerInRaw('ports_nac.port_id', $this->findPorts($search))
                            ->orWhere('ports_nac.vlan', 'like', '%' . $search . '%')
                            ->orWhere('ports_nac.mac_address', 'like', $mac_search)
                            ->orWhere('ports_nac.username', 'like', '%' . $search . '%')
                            ;
                    });
            }
        }

        return $query;
    }

    /**
     * @param  PortsNac  $nac
     */
    public function formatItem($nac)
    {
        $item = $nac->toArray();
        $mac = Mac::parse($item['mac_address']);
        $item['port_id'] = Url::portLink($nac->port, $nac->port->getShortLabel());
        $item['mac_oui'] = $mac->vendor();
        $item['mac_address'] = $mac->readable();
        $item['port'] = null; //free some unused data to be sent to the browser
        $item['device_id'] = Url::deviceLink($nac->device);

        return $item;
    }

    /**
     * @param  string  $ifAlias
     * @return Collection
     */
    protected function findPorts($ifAlias): Collection
    {
        $port_id = \Request::get('port_id');
        $device_id = \Request::get('device_id');

        return Port::where('ifAlias', 'like', "%$ifAlias%")
            ->when($device_id, function ($query) use ($device_id) {
                return $query->where('device_id', $device_id);
            })
            ->when($port_id, function ($query) use ($port_id) {
                return $query->where('port_id', $port_id);
            })
            ->pluck('port_id');
    }

    /**
     * Get the OUI list for a specific vendor
     *
     * @param  string  $vendor
     * @return array
     */
    protected function ouisFromVendor(string $vendor): array
    {
        return DB::table('vendor_ouis')
            ->where('vendor', 'LIKE', '%' . $vendor . '%')
            ->pluck('oui')
            ->toArray();
    }

    /**
     * Get all port ids from vendor OUIs
     */
    protected function findPortsByOui(array $vendor_ouis, Builder $query): Builder
    {
        $query->where(function (Builder $query) use ($vendor_ouis) {
            foreach ($vendor_ouis as $oui) {
                $query->orWhere('ports_nac.mac_address', 'LIKE', "$oui%");
            }
        });

        return $query; // Return the query builder instance
    }
}
