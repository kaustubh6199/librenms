<?php
/*
 * SettingsHook.php
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

namespace App\Plugins\Hooks;

use App\Models\User;

abstract class SettingsHook
{
    public $view = 'resources.views.settings';

    public function authorize(User $user, array $settings): bool
    {
        return true;
    }

    public function data(array $settings): array
    {
        return [
            'title' => __CLASS__,
            'settings' => $settings,
        ];
    }

    final public function handle(string $plugin, array $settings): mixed
    {
        // only if this is the selected plugin
        if ($plugin !== \PluginManager::getPluginName($this)) {
            return null;
        }

        \View::addLocation(\PluginManager::pluginPath($this));

        return view($this->view, $this->data($settings));
    }
}
