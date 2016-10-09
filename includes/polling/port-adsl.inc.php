<?php

// Example snmpwalk with units
// "Interval" oids have been filtered out
// adslLineCoding.1 = dmt
// adslLineType.1 = fastOrInterleaved
// adslLineSpecific.1 = zeroDotZero
// adslLineConfProfile.1 = "qwer"
// adslAtucInvSerialNumber.1 = "IES-1000 AAM1008-61"
// adslAtucInvVendorID.1 = "4"
// adslAtucInvVersionNumber.1 = "0"
// adslAtucCurrSnrMgn.1 = 150 tenth dB
// adslAtucCurrAtn.1 = 20 tenth dB
// adslAtucCurrStatus.1 = "00 00 "
// adslAtucCurrOutputPwr.1 = 100 tenth dBm
// adslAtucCurrAttainableRate.1 = 10272000 bps
// adslAturInvVendorID.1 = "0"
// adslAturInvVersionNumber.1 = "0"
// adslAturCurrSnrMgn.1 = 210 tenth dB
// adslAturCurrAtn.1 = 20 tenth dB
// adslAturCurrStatus.1 = "00 00 "
// adslAturCurrOutputPwr.1 = 0 tenth dBm
// adslAturCurrAttainableRate.1 = 1056000 bps
// adslAtucChanInterleaveDelay.1 = 6 milli-seconds
// adslAtucChanCurrTxRate.1 = 8064000 bps
// adslAtucChanPrevTxRate.1 = 0 bps
// adslAturChanInterleaveDelay.1 = 9 milli-seconds
// adslAturChanCurrTxRate.1 = 512000 bps
// adslAturChanPrevTxRate.1 = 0 bps
// adslAtucPerfLofs.1 = 0
// adslAtucPerfLoss.1 = 0
// adslAtucPerfLols.1 = 0
// adslAtucPerfLprs.1 = 0
// adslAtucPerfESs.1 = 0
// adslAtucPerfInits.1 = 1
// adslAtucPerfValidIntervals.1 = 0
// adslAtucPerfInvalidIntervals.1 = 0
// adslAturPerfLoss.1 = 0 seconds
// adslAturPerfESs.1 = 0 seconds
// adslAturPerfValidIntervals.1 = 0
// adslAturPerfInvalidIntervals.1 = 0
if (isset($this_port['adslLineCoding'])) {
    $rrd_name = getPortRrdName($port_id, 'adsl');
    $rrd_def = array(
        'DS:AtucCurrSnrMgn:GAUGE:600:0:635',
        'DS:AtucCurrAtn:GAUGE:600:0:635',
        'DS:AtucCurrOutputPwr:GAUGE:600:0:635',
        'DS:AtucCurrAttainableR:GAUGE:600:0:U',
        'DS:AtucChanCurrTxRate:GAUGE:600:0:U',
        'DS:AturCurrSnrMgn:GAUGE:600:0:635',
        'DS:AturCurrAtn:GAUGE:600:0:635',
        'DS:AturCurrOutputPwr:GAUGE:600:0:635',
        'DS:AturCurrAttainableR:GAUGE:600:0:U',
        'DS:AturChanCurrTxRate:GAUGE:600:0:U',
        'DS:AtucPerfLofs:COUNTER:600:U:100000000000',
        'DS:AtucPerfLoss:COUNTER:600:U:100000000000',
        'DS:AtucPerfLprs:COUNTER:600:U:100000000000',
        'DS:AtucPerfESs:COUNTER:600:U:100000000000',
        'DS:AtucPerfInits:COUNTER:600:U:100000000000',
        'DS:AturPerfLofs:COUNTER:600:U:100000000000',
        'DS:AturPerfLoss:COUNTER:600:U:100000000000',
        'DS:AturPerfLprs:COUNTER:600:U:100000000000',
        'DS:AturPerfESs:COUNTER:600:U:100000000000',
        'DS:AtucChanCorrectedBl:COUNTER:600:U:100000000000',
        'DS:AtucChanUncorrectBl:COUNTER:600:U:100000000000',
        'DS:AturChanCorrectedBl:COUNTER:600:U:100000000000',
        'DS:AturChanUncorrectBl:COUNTER:600:U:100000000000',
    );

    $adsl_oids = array(
        'AtucCurrSnrMgn',
        'AtucCurrAtn',
        'AtucCurrOutputPwr',
        'AtucCurrAttainableRate',
        'AtucChanCurrTxRate',
        'AturCurrSnrMgn',
        'AturCurrAtn',
        'AturCurrOutputPwr',
        'AturCurrAttainableRate',
        'AturChanCurrTxRate',
        'AtucPerfLofs',
        'AtucPerfLoss',
        'AtucPerfLprs',
        'AtucPerfESs',
        'AtucPerfInits',
        'AturPerfLofs',
        'AturPerfLoss',
        'AturPerfLprs',
        'AturPerfESs',
        'AtucChanCorrectedBlks',
        'AtucChanUncorrectBlks',
        'AturChanCorrectedBlks',
        'AturChanUncorrectBlks',
    );

    $adsl_db_oids = array(
        'adslLineCoding',
        'adslLineType',
        'adslAtucInvVendorID',
        'adslAtucInvVersionNumber',
        'adslAtucCurrSnrMgn',
        'adslAtucCurrAtn',
        'adslAtucCurrOutputPwr',
        'adslAtucCurrAttainableRate',
        'adslAturInvSerialNumber',
        'adslAturInvVendorID',
        'adslAturInvVersionNumber',
        'adslAtucChanCurrTxRate',
        'adslAturChanCurrTxRate',
        'adslAturCurrSnrMgn',
        'adslAturCurrAtn',
        'adslAturCurrOutputPwr',
        'adslAturCurrAttainableRate',
    );

    $adsl_tenth_oids = array(
        'adslAtucCurrSnrMgn',
        'adslAtucCurrAtn',
        'adslAtucCurrOutputPwr',
        'adslAturCurrSnrMgn',
        'adslAturCurrAtn',
        'adslAturCurrOutputPwr',
    );

    foreach ($adsl_tenth_oids as $oid) {
        $this_port[$oid] = ($this_port[$oid] / 10);
    }

    if (dbFetchCell('SELECT COUNT(*) FROM `ports_adsl` WHERE `port_id` = ?', array($port_id)) == '0') {
        dbInsert(array('port_id' => $port_id), 'ports_adsl');
    }

    $port['adsl_update'] = array('port_adsl_updated' => array('NOW()'));
    foreach ($adsl_db_oids as $oid) {
        $data = str_replace('"', '', $this_port[$oid]);
        // FIXME - do we need this?
        $port['adsl_update'][$oid] = $data;
    }

    dbUpdate($port['adsl_update'], 'ports_adsl', '`port_id` = ?', array($port_id));

    if ($this_port['adslAtucCurrSnrMgn'] > '1280') {
        $this_port['adslAtucCurrSnrMgn'] = 'U';
    }

    if ($this_port['adslAturCurrSnrMgn'] > '1280') {
        $this_port['adslAturCurrSnrMgn'] = 'U';
    }

    $fields = array();
    foreach ($adsl_oids as $oid) {
        $oid  = 'adsl'.$oid;
        $data = str_replace('"', '', $this_port[$oid]);
        // Set data to be "unknown" if it's garbled, unexistant or zero
        if (!is_numeric($data)) {
            $data = 'U';
        }
        $fields[$oid] = $data;
    }

    $tags = compact('ifName', 'rrd_name', 'rrd_def');
    data_update($device, 'adsl', $tags, $fields);

    echo 'ADSL ('.$this_port['adslLineCoding'].'/'.formatRates($this_port['adslAtucChanCurrTxRate']).'/'.formatRates($this_port['adslAturChanCurrTxRate']).')';
}//end if
