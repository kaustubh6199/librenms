<?php
/**
 * CustomMap.php
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
 * @copyright  2023 Steven Wilton
 * @author     Steven Wilton <swilton@fluentit.com.au>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomMap extends BaseModel
{
    protected $primaryKey = 'custom_map_id';
    protected $fillable = ['name','width','height','background_suffix','background_version','options','newnodeconfig','newedgeconfig'];
    protected $casts = [
        'background_version'  => 'integer',
        'options'             => 'json',
        'newnodeconfig'       => 'json',
        'newedgeconfig'       => 'json',
    ];
    public $timestamps = false;

    public function scopeHasAccess($query, User $user)
    {
        if ($user->hasGlobalRead()) {
            return $query;
        }

        // Allow only if the user has access to all devices on the map
        return $query->withCount([
                'nodes as device_nodes_count' => function(Builder $q) use ($user) {
                    $q->whereNotNull('device_id');
                },
                'nodes as device_nodes_allowed_count' => function(Builder $q) use ($user) {
                    $this->hasDeviceAccess($q, $user, 'custom_map_nodes');
                },
            ])
            ->having('device_nodes_count', '=', 'device_nodes_allowed_count')
            ->having('device_nodes_count', '>', 0);
    }

    public function nodes(): HasMany
    {
        return $this->hasMany(CustomMapNode::class, 'custom_map_id');
    }

    public function edges(): HasMany
    {
        return $this->hasMany(CustomMapEdge::class, 'custom_map_id');
    }

    public function background(): HasOne
    {
        return $this->hasOne(CustomMapBackground::class, 'custom_map_id');
    }
}
