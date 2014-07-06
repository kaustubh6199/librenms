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

include_once("../includes/defaults.inc.php");
include_once("../config.php");
include_once("../includes/definitions.inc.php");
include_once("../includes/common.php");
include_once("../includes/console_colour.php");
include_once("../includes/dbFacile.php");
include_once("../includes/rewrites.php");
include_once("includes/functions.inc.php");
include_once("../includes/rrdtool.inc.php");
require 'includes/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
require_once("../includes/api_functions.inc.php");
$app->setName('api');

$app->group('/get', function() use ($app) {
  $app->group('/port', function() use ($app) {
    $app->group('/graph', function() use ($app) {
      $app->get('/id/:id(/:type)(/:width)(/:height)(/:from)(/:to)/:key(/)', 'authToken', 'get_graph_by_id');//api.php/get/port/graph/id/$port_id/$key
      $app->get('/device/:id/:port(/:type)(/:width)(/:height)(/:from)(/:to)/:key(/)', 'authToken', 'get_graph_by_port');//api.php/get/port/graph/device/$device_id/$ifName/$key
    });
    $app->group('/stats', function() use ($app) {
      $app->get('/id/:id/:key(/)', 'authToken', 'get_port_stats_by_id');//api.php/get/port/stats/id/$port_id/$key
      $app->get('/device/:id/:port/:key(/)', 'authToken', 'get_port_stats_by_port');//api.php/get/port/stats/device/$device_id/$ifName/$key
    });
  });
});

$app->run();

?>
