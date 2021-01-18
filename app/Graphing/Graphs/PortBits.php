<?php
/*
 * PortBits.php
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2021 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Graphing\Graphs;

use App\Facades\Rrd;
use App\Graphing\BaseGraph;
use App\Models\Port;
use Illuminate\Http\Request;

class PortBits extends BaseGraph
{
    public function data(Request $request): array
    {
        $this->init($request);
        $this->renderer->setLabels(['In', 'Out'], 'bps');
        return $this->renderer->formatRrdData($this->fetchData(2));
    }

    private function fetchData($id)
    {
        $port = Port::with('device')->find($id);

        $rrd_file = Rrd::name($port->device->hostname, Rrd::portName($id));
        $defs = [
            "DEF:outoctets$id=$rrd_file:OUTOCTETS:AVERAGE",
            "DEF:inoctets$id=$rrd_file:INOCTETS:AVERAGE",
            "CDEF:doutoctets$id=outoctets$id,-1,*",
            "CDEF:doutbits$id=doutoctets$id,8,*",
            "CDEF:inbits$id=inoctets$id,8,*",
            "XPORT:inbits$id:'In'",
            "XPORT:doutbits$id:'Out'",
        ];

        return Rrd::xport($defs, $this->start->timestamp, $this->end->timestamp);
    }
}
