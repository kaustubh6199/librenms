<?php
/**
 * ServiceCheck.php
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
 * @copyright  2022 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Interfaces;

use App\Models\Device;
use App\Models\Service;

interface ServiceCheck
{
    public function __construct(Service $service);

    /**
     * Build command for poller to check this service check
     *
     * @param  \App\Models\Device  $device
     * @return array
     */
    public function buildCommand(Device $device): array;

    /**
     * Get data sets to be used for graphing.
     * If you don't want to graph all metrics or perhaps want to add synthetic graphs, you can do so here.
     *
     * @return array
     */
    public function serviceDataSets(): array;

    /**
     * Creates the rrdtool commandline for graphing the given data set.
     * See DefaultServiceCheck for base implementation.
     *
     * @param  string  $rrd_filename
     * @param  string  $ds
     * @return string
     */
    public function graphRrdCommands(string $rrd_filename, string $ds): string;

    /**
     * Get the available check parameters.
     *
     * @return \LibreNMS\Services\CheckParameter[]
     */
    public function availableParameters(): array;
}
