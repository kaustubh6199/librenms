<?php
/*
 * BaseGraph.php
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

namespace App\Graphing;

use App\Http\Controllers\Controller;

abstract class BaseGraph extends Controller
{
    public $group;
    public $name;

//    abstract public function data(): array;

    public static function __set_state(array $properties)
    {
        $class = new static();

        // hardcoded vars for route
        $class->group = $properties['group'];
        $class->name = $properties['name'];

        return $class;
    }
}
