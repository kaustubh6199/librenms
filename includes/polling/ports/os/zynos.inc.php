<?php
/*
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 * @author     LukeKelsall <l.kelsall@b4rn.org.uk>
 */

//loop through ports
foreach ($port_stats as $index => $port) {
    //Logically convert swp ports to human readable
    //only convert swp ports
    if (substr($port['ifName'], 0, 3) === 'swp') {
        $portNum = preg_replace('/[a-z]+/', '', $port['ifName']);
        if ($portNum < 50) {
            $portNum++;
            //Leading 0 for single digits
            if ($portNum < 10) {
                $ifDescr = '1/0' . $portNum;
            } else {
                $ifDescr = '1/' . $portNum;
            }
        }
        if ($portNum > 63 && $portNum < 128) {
            $portNum = $portNum - 63;
            //Leading 0 for single digits
            if ($portNum < 10) {
                $ifDescr = '2/0' . $portNum;
            } else {
                $ifDescr = '2/' . $portNum;
            }
        }
        if ($portNum > 127 && $portNum < 192) {
            $portNum = $portNum - 127;
            //Leading 0 for single digits
            if ($portNum < 10) {
                $ifDescr = '3/0' . $portNum;
            } else {
                $ifDescr = '3/' . $portNum;
            }
        }
        if ($portNum > 191) {
            $portNum = $portNum - 191;
            //Leading 0 for single digits
            if ($portNum < 10) {
                $ifDescr = '4/0' . $portNum;
            } else {
                $ifDescr = '4/' . $portNum;
            }
        }
    } else {
        //Set port number to match current
        $ifDescr = $port['ifName'];
    }
    //set the libre ifDescr value to new port name
    $port_stats[$index]['ifDescr'] = $ifDescr;
    $port_stats[$index]['ifName'] = $ifDescr;
}
