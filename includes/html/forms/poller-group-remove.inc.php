<?php

/*
 * LibreNMS
 *
 * Copyright (c) 2014 Neil Lathwood <https://github.com/laf/ http://www.lathwood.co.uk/fa>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

header('Content-type: text/plain');

if (!Auth::user()->hasGlobalAdmin()) {
    die('ERROR: You need to be admin');
}

if (!is_numeric($_POST['group_id'])) {
    echo 'error with data';
    exit;
} else {
    if ($_POST['confirm'] == 'yes') {
        $delete = dbDelete('poller_groups', '`id` = ?', array($_POST['group_id']));
        if ($delete > '0') {
            $default_poller_id = Config::get('distributed_poller_group');
            dbUpdate(array('poller_group' => $default_poller_id), 'devices', 'poller_group = ?', array($_POST['group_id']));
            echo 'Poller group has been removed';
            exit;
        } else {
            echo 'An error occurred removing the Poller group';
            exit;
        }
    }
}
