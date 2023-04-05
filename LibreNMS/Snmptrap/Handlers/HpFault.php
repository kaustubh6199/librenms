<?php

namespace LibreNMS\Snmptrap\Handlers;

use App\Models\Device;
use LibreNMS\Interfaces\SnmptrapHandler;
use LibreNMS\Snmptrap\Trap;

class HpFault implements SnmptrapHandler
{
    /**
     * Handle snmptrap.
     * Data is pre-parsed and delivered as a Trap.
     *
     * @param  Device  $device
     * @param  Trap  $trap
     * @return void
     */
    public function handle(Device $device, Trap $trap)
    {
        $type = $trap->getOidData($trap->findOid('HP-ICF-FAULT-FINDER-MIB::hpicfFfLogFaultType'));
        switch ($type) {
            case 'badXcvr':
                $trap->log('Fault - CRC Error ' . $trap->getOidData($trap->findOid('HP-ICF-FAULT-FINDER-MIB::hpicfFfFaultInfoURL')), 4, $type);
                break;
            case 'badCable':
                $trap->log('Fault - Bad Cable ' . $trap->getOidData($trap->findOid('HP-ICF-FAULT-FINDER-MIB::hpicfFfFaultInfoURL')), 4, $type);
                break;
            case 'bcastStorm':
                $trap->log('Fault - Broadcaststorm ' . $trap->getOidData($trap->findOid('HP-ICF-FAULT-FINDER-MIB::hpicfFfFaultInfoURL')), 5, $type);
                break;
            default:
                $trap->log('Fault - Unhandled ' . $trap->getOidData($trap->findOid('HP-ICF-FAULT-FINDER-MIB::hpicfFfFaultInfoURL')), 2, $type);
                break;
        }
    }
}
