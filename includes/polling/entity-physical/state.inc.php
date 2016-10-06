<?php

// Set Entity state
foreach (dbFetch('SELECT * FROM `entPhysical_state` WHERE `device_id` = ?', array($device['device_id'])) as $entity) {
    if (!isset($entPhysical_state[$entity['entPhysicalIndex']][$entity['subindex']][$entity['group']][$entity['key']])) {
        dbDelete(
            'entPhysical_state',
            '`device_id` = ? AND `entPhysicalIndex` = ? AND `subindex` = ? AND `group` = ? AND `key` = ?',
            array(
                $device['device_id'],
                $entity['entPhysicalIndex'],
                $entity['subindex'],
                $entity['group'],
                $entity['key'],
            )
        );
    } else {
        if ($entPhysical_state[$entity['entPhysicalIndex']][$entity['subindex']][$entity['group']][$entity['key']] != $entity['value']) {
            echo 'no match!';
        }

        unset($entPhysical_state[$entity['entPhysicalIndex']][$entity['subindex']][$entity['group']][$entity['key']]);
    }
}//end foreach

// End Set Entity Attrivs
// Delete Entity state
foreach ($entPhysical_state as $epi => $entity) {
    foreach ($entity as $subindex => $si) {
        foreach ($si as $group => $ti) {
            foreach ($ti as $key => $value) {
                dbInsert(array('device_id' => $device['device_id'], 'entPhysicalIndex' => $epi, 'subindex' => $subindex, 'group' => $group, 'key' => $key, 'value' => $value), 'entPhysical_state');
            }
        }
    }
} // End Delete Entity state
