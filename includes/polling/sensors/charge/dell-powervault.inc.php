<?php

$connUnitSensorMessage = explode(':', $sensor_value);
preg_match('/^ ([0-9]+)%$/', array_pop($connUnitSensorMessage), $matches);
$sensor_value = $matches[1];

unset($matches,
    $connUnitSensorMessage
);
