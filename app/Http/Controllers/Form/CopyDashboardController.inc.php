<?php
/**
 * CopyDashboardController.php
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
 * @copyright  2020 Thomas Berberich
 * @author     Thomas Berberich <sourcehhdoctor@gmail.com>
 */

namespace App\Http\Controllers\Form;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\UserWidget;
use Illuminate\Http\Request;

class CopyDashboardController extends Controller
{
    public function store(Request $request)
    {
        $target_user_id = $request->get('target_user_id');
        $dashboard_id = $request->get('dashboard_id');

        $dashboard = Dashboard::where(['dashboard_id' => $dashboard_id, 'user_id' => Auth::id()])->first()->toArray();

        $success = true;

        if ((empty($dashboard)) || (empty($target_user_id))) {
            $success = false;
        }

        if ($success) {
            unset($dashboard['dashboard_id']);
            $dashboard['user_id'] = $target_user_id;
            $dashboard['dashboard_name'] .= '_' . Auth::user()->username;

            $dashboard_copy = new Dashboard();
            $dashboard_copy->fill($dashboard);
            $success &= $dashboard_copy->save();
        }

        if ($success) {
            $widgets = UserWidget::where(['dashboard_id' => $dashboard_id, 'user_id' => Auth::id()])->get()->toArray();

            foreach ($widgets as $widget) {
                $widget['user_id'] = $target_user_id;
                $widget['dashboard_id'] = $dashboard_copy->dashboard_id;

                $widget_copy = new UserWidget();
                $widget_copy->fill($widget);
                $success &= $widget_copy->save();
            }
        }

        if ($success) {
            $status  = 'ok';
            $message = 'Dashboard copied';
        } else {
            $status  = 'error';
            $message = 'ERROR: Could not copy Dashboard';
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
}
