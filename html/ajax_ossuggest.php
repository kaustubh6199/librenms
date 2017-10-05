<?php
/*
 * Copyright (C) 2017 Oscar Ekeroth <zmegolaz@gmail.com>
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
 */

session_start();
if (!isset($_SESSION['authenticated'])) {
    die('Unauthorized.');
}

$init_modules = array('web');
require realpath(__DIR__ . '/..') . '/includes/init.php';

set_debug($_REQUEST['debug']);

/**
 * Levenshtein Sort
 * @param string $base Comparison basis
 * @param array  $obj  Object to sort
 * @return array
 */
function levsortos($base, $obj, $keys)
{
    $ret = array();
    foreach ($obj as $elem) {
        $lev = false;
        foreach ($keys as $key) {
            $levnew = levenshtein(strtolower($base), strtolower($elem[$key]), 1, 10, 10);
            if ($lev === false || $levnew < $lev) {
                $lev = $levnew;
            }
        }
        while (isset($ret["$lev"])) {
            $lev += 0.1;
        }

        $ret["$lev"] = $elem;
    }

    ksort($ret);
    return $ret;
}

header('Content-type: application/json');
if (isset($_GET['term'])) {
    $_GET['term'] = mres($_GET['term']);
    $sortos = levsortos($_GET['term'], $config['os'], array("text", "os"));
    $sortos = array_chunk($sortos, 20, true);
    $sortos = $sortos[0];
    foreach ($sortos as $lev => $os) {
        $ret[$lev] = array_intersect_key($os, array('os' => true, 'text' => true));
    }
}
if (!isset($ret)) {
    $ret = array(array('Error: No suggestions found.'));
}

die(json_encode($ret));
