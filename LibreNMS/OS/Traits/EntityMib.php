<?php
/**
 * EntityMib.php
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
 * @copyright  2024 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\OS\Traits;

use App\Models\EntPhysical;
use Illuminate\Support\Collection;

trait EntityMib
{
    protected ?string $entityVendorTypeMib = null;

    public function discoverEntityPhysical(): Collection
    {
        $snmpQuery = \SnmpQuery::hideMib()->enumStrings();
        if (isset($this->entityVendorTypeMib)) {
            $snmpQuery = $snmpQuery->mibs([$this->entityVendorTypeMib]);
        }
        $data = $snmpQuery->walk('ENTITY-MIB::entPhysicalTable');

        if (! $data->isValid()) {
            return new Collection;
        }

        $mapping = \SnmpQuery::walk('ENTITY-MIB::entAliasMappingIdentifier')->table(2);

        return $data->mapTable(function ($data, $entityPhysicalIndex) use ($mapping) {
            $entityPhysical = new EntPhysical($data);
            $entityPhysical->entPhysicalIndex = $entityPhysicalIndex;

            // fill ifIndex
            if (isset($mapping[$entityPhysicalIndex][0]['ENTITY-MIB::entAliasMappingIdentifier'])) {
                if (preg_match('/IF-MIB::ifIndex\[(\d+)]/', $mapping[$entityPhysicalIndex][0]['ENTITY-MIB::entAliasMappingIdentifier'], $matches)) {
                    $entityPhysical->ifIndex = $matches[1];
                }
            }

            return $entityPhysical;
        });
    }
}
