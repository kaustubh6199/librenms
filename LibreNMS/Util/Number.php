<?php
/*
 * Number.php
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
 * @copyright  2020 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Util;

class Number
{
    public static function formatBase($value, $base = 1000, $round = 2, $sf = 3, $suffix = 'B')
    {
        return $base == 1000
            ? self::formatSi($value, $round, $sf, $suffix)
            : self::formatBi($value, $round, $sf, $suffix);
    }

    public static function formatSi($value, $round = 2, $sf = 3, $suffix = 'B')
    {
        $neg = $value < 0;
        if ($neg) {
            $value = $value * -1;
        }

        if ($value >= '0.1') {
            $sizes = ['', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];
            $ext = $sizes[0];
            for ($i = 1; (($i < count($sizes)) && ($value >= 1000)); $i++) {
                $value = $value / 1000;
                $ext = $sizes[$i];
            }
        } else {
            $sizes = ['', 'm', 'u', 'n', 'p'];
            $ext = $sizes[0];
            for ($i = 1; (($i < count($sizes)) && ($value != 0) && ($value <= 0.1)); $i++) {
                $value = $value * 1000;
                $ext = $sizes[$i];
            }
        }

        if ($neg) {
            $value = $value * -1;
        }

        return (number_format(round($value, $round), $sf, '.', '') + 0) . " $ext$suffix";
    }

    public static function formatBi($value, $round = 2, $sf = 3, $suffix = 'B')
    {
        $neg = $value < 0;
        if ($neg) {
            $value = $value * -1;
        }
        $sizes = ['', 'Ki', 'Mi', 'Gi', 'Ti', 'Pi', 'Ei', 'Zi', 'Yi'];
        $ext = $sizes[0];
        for ($i = 1; (($i < count($sizes)) && ($value >= 1024)); $i++) {
            $value = $value / 1024;
            $ext = $sizes[$i];
        }

        if ($neg) {
            $value = $value * -1;
        }

        return (number_format(round($value, $round), $sf, '.', '') + 0) . " $ext$suffix";
    }
}
