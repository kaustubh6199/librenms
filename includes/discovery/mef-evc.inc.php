<?php

/*
 * Try to discover any MEF Links
 */

if ($device['os'] == 'coriant') {
    /*
     * Variable to hold the discovered MEF Links.
     */

    $mefevc_list = array();

    /*
     * Fetch information about MEF Links.
     */

    $oids = snmpwalk_cache_multi_oid($device, 'MefServiceEvcCfgEntry', $oids, 'MEF-UNI-EVC-MIB');

    echo "MEF EVC : ";
    foreach ($oids as $index => $entry) {
        $mefIdent    = $entry['mefServiceEvcCfgIdentifier'];
        $mefType     = $entry['mefServiceEvcCfgServiceType'];
        $mefMtu      = $entry['mefServiceEvcCfgMtuSize'];
        $mefAdmState = $entry['mefServiceEvcCfgAdminState'];
        $mefRowState = $entry['mefServiceEvcCfgRowStatus'];

        /*
         * Coriant MEF-EVC is quite strange, MTU is sometime set to 0 setting it to "strange" default value
         * According to Coriant this should be fixed in Nov 2017.
         */
        if ($mefMtu == 0) {
            $mefMtu = 1600;
        }

        /*
         * Check if the MEF EVC is already known for this host
         */
       if (dbFetchCell("SELECT COUNT(id) FROM `mefinfo` WHERE `device_id` = ? AND `mefID` = ?", array($device['device_id'], $index)) == 0) {
           $mefid = dbInsert(array('device_id' => $device['device_id'], 'mefID' => $index, 'mefType' => mres($mefType), 'mefIdent' => mres($mefIdent), 'mefMTU' => mres($mefMtu), 'mefAdmState' => mres($mefAdmState), 'mefRowState' => mres($mefRowState)), 'mefinfo');
           log_event("MEF link: ". mres($mefIdent) . " (" . $index . ") Discovered", $device, 'system', $mefid);
           echo '+';
       } else {
           echo '.';
       }
       /*
        * Save the discovered MEF Link
        */
       $mefevc_list[] = $index;
    }

    /*
     * Get a list of all the known EVC Links for this host
     */

    $sql = "SELECT id, mefID, mefIdent FROM mefinfo WHERE device_id = '".$device['device_id']."'";
    foreach (dbFetchRows($sql) as $db_mef) {
	/*
         * Delete the MEF Link that are removed from the host.
	 */
	if (!in_array($db_mef['mefID'], $mefevc_list)) {
            dbDelete('mefinfo', '`id` = ?', array($db_mef['id']));
            log_event("MEF link: ".mres($db_mef['mefIdent']).' Removed', $device, 'system', $db_mef['mefID']);
            echo '-';
        }
    }
    /*
     * Finished MEF information
     */
    unset($mefevc_list, $oids, $db_mef);
    echo PHP_EOL;
}//end if
