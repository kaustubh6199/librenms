<?php

require 'includes/html/graphs/common.inc.php';

$print_format = ! isset($print_format) ? '%8.0lf%s' : $print_format;

if (isset($lower_limit)) {
    $rrd_options .= ' --lower-limit ' . $lower_limit . ' ';
}

if (isset($upper_limit)) {
    $rrd_options .= ' --upper-limit ' . $upper_limit . ' ';
}

if ($width > '500') {
    $descr_len = $bigdescrlen;
} else {
    $descr_len = $smalldescrlen;
}

if ($printtotal === 1) {
    $descr_len += '2';
    $unitlen += '2';
}

$unit_text = str_pad(truncate($unit_text, $unitlen), $unitlen);

if ($width > '500') {
    $rrd_options .= " COMMENT:'" . substr(str_pad($unit_text, ($descr_len + 10)), 0, ($descr_len + 10)) . "Now         Min         Max        Avg\l'";
    if ($printtotal === 1) {
        $rrd_options .= " COMMENT:'Total      '";
    }
    $rrd_options .= " COMMENT:'\l'";
} else {
    $rrd_options .= " COMMENT:'" . substr(str_pad($unit_text, ($descr_len + 10)), 0, ($descr_len + 10)) . "Now         Min         Max        Avg\l'";
}

foreach ($rrd_list as $rrd) {
    if ($rrd['colour']) {
        $colour = $rrd['colour'];
    } else {
        if (! \LibreNMS\Config::get("graph_colours.$colours.$colour_iter")) {
            $colour_iter = 0;
        }

        $colour = \LibreNMS\Config::get("graph_colours.$colours.$colour_iter");
        $colour_iter++;
    }
    $i++;
    $ds = $rrd['ds'];
    $filename = $rrd['filename'];

    $descr = \LibreNMS\Data\Store\Rrd::fixedSafeDescr($rrd['descr'], $descr_len);
    $id = 'ds' . $i;

    $rrd_options .= ' DEF:' . $rrd['ds'] . $i . '=' . $rrd['filename'] . ':' . $rrd['ds'] . ':AVERAGE ';

    if ($simple_rrd) {
        $rrd_options .= ' CDEF:' . $rrd['ds'] . $i . 'min=' . $rrd['ds'] . $i . ' ';
        $rrd_options .= ' CDEF:' . $rrd['ds'] . $i . 'max=' . $rrd['ds'] . $i . ' ';
    } else {
        $rrd_options .= ' DEF:' . $rrd['ds'] . $i . 'min=' . $rrd['filename'] . ':' . $rrd['ds'] . ':MIN ';
        $rrd_options .= ' DEF:' . $rrd['ds'] . $i . 'max=' . $rrd['filename'] . ':' . $rrd['ds'] . ':MAX ';
    }

    if ($graph_params->visible('previous')) {
        $rrd_options .= ' DEF:' . $i . 'X=' . $rrd['filename'] . ':' . $rrd['ds'] . ':AVERAGE:start=' . $prev_from . ':end=' . $from;
        $rrd_options .= ' SHIFT:' . $i . "X:$period";
        $thingX .= $seperatorX . $i . 'X,UN,0,' . $i . 'X,IF';
        $plusesX .= $plusX;
        $seperatorX = ',';
        $plusX = ',+';
    }

    if ($printtotal === 1) {
        $rrd_options .= ' VDEF:tot' . $rrd['ds'] . $i . '=' . $rrd['ds'] . $i . ',TOTAL';
    }

    $g_defname = $rrd['ds'];

    $f_multiplier = null;
    if (isset($rrd['multiplier']) && is_numeric($rrd['multiplier'])) {
        $f_multiplier = $rrd['multiplier'];
    } elseif (is_numeric($multiplier)) {
        $f_multiplier = $multiplier;
    }

    $f_divider = null;
    if (isset($rrd['divider']) && is_numeric($rrd['divider'])) {
        $f_divider = $rrd['divider'];
    } elseif (is_numeric($divider)) {
        $f_divider = $divider;
    }

    if (! is_null($f_multiplier) || ! is_null($f_divider)) {
        $g_defname = $rrd['ds'] . '_cdef';

        if ($f_multiplier) {
            $rrd_options .= ' CDEF:' . $g_defname . $i . '=' . $rrd['ds'] . $i . ',' . $f_multiplier . ',*';
            $rrd_options .= ' CDEF:' . $g_defname . $i . 'min=' . $rrd['ds'] . $i . ',' . $f_multiplier . ',*';
            $rrd_options .= ' CDEF:' . $g_defname . $i . 'max=' . $rrd['ds'] . $i . ',' . $f_multiplier . ',*';
        } elseif ($f_divider) {
            $rrd_options .= ' CDEF:' . $g_defname . $i . '=' . $rrd['ds'] . $i . ',' . $f_divider . ',/';
            $rrd_options .= ' CDEF:' . $g_defname . $i . 'min=' . $rrd['ds'] . $i . ',' . $f_divider . ',/';
            $rrd_options .= ' CDEF:' . $g_defname . $i . 'max=' . $rrd['ds'] . $i . ',' . $f_divider . ',/';
        }
    }

    if (isset($text_orig) && $text_orig) {
        $t_defname = $rrd['ds'];
    } else {
        $t_defname = $g_defname;
    }

    if ($i && ($dostack === 1)) {
        $stack = ':STACK';
    }

    $rrd_options .= ' LINE2:' . $g_defname . $i . '#' . $colour . ":'" . $descr . "'$stack";
    $rrd_options .= ' GPRINT:' . $t_defname . $i . ':LAST:' . $print_format . ' GPRINT:' . $t_defname . $i . 'min:MIN:' . $print_format;
    $rrd_options .= ' GPRINT:' . $t_defname . $i . 'max:MAX:' . $print_format . ' GPRINT:' . $t_defname . $i . ':AVERAGE:' . $print_format . "'\\n'";

    if ($printtotal === 1) {
        $rrd_options .= ' GPRINT:tot' . $rrd['ds'] . $i . ":%6.2lf%s'" . Rrd::safeDescr($total_units) . "'";
    }

    $rrd_options .= " COMMENT:'\\n'";
}//end foreach

if ($graph_params->visible('previous')) {
    $rrd_options .= ' CDEF:X=' . $thingX . $plusesX;

    if ($f_multiplier) {
        $rrd_options .= ',' . $f_multiplier . ',*';
    } elseif ($f_divider) {
        $rrd_options .= ',' . $rrd['divider'] . ',/';
    }

    $rrd_options .= ' HRULE:0#555555';
}
