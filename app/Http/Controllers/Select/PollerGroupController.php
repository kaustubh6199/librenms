<?php
/*
 * PollerGroupController.php
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

namespace App\Http\Controllers\Select;

use App\Models\PollerGroup;
use Illuminate\Support\Str;

class PollerGroupController extends SelectController
{
    protected function searchFields($request)
    {
        return ['group_name', 'descr'];
    }

    protected function baseQuery($request)
    {
        return PollerGroup::query()->select(['id', 'group_name']);
    }

    protected function formatResponse($paginator)
    {
        // prepend the default group, unless filtered out
        if ($this->includeGeneral()) {
            $general = new PollerGroup;
            $general->id = 0;
            $general->group_name = 'General';
            $paginator->prepend($general);
        }

        return parent::formatResponse($paginator);
    }

    private function includeGeneral()
    {
        if (request()->has('id') && request('id') !== 0) {
            return false;
        } elseif (request()->has('term') && ! Str::contains('general', strtolower(request('term')))) {
            return false;
        }

        return true;
    }
}
