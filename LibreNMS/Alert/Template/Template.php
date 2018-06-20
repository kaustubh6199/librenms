<?php
/**
 * Template.php
 *
 * Base Template class
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
 * @copyright  2018 Neil Lathwood
 * @author     Neil Lathwood <gh+n@laf.io>
 */

namespace LibreNMS\Alert\Template;

use App\Models\AlertTemplate;

class Template
{
    public $template;

    /**
     *
     * Get the template details
     *
     * @param null $obj
     * @return mixed
     */
    public function getTemplate($obj = null)
    {
        if ($this->template) {
            // Return the cached template information.
            return $this->template;
        }
        $this->template = AlertTemplate::whereHas('map', function ($query) use ($obj) {
            $query->where('alert_rule_id', '=', $obj['rule_id']);
        })->first();
        if (!$this->template) {
            $this->template = AlertTemplate::where('name', '=', 'Default Alert Template')->first();
        }
        return $this->template;
    }
}
