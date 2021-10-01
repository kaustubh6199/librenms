<?php

namespace App\Observers;

use App\Models\Device;
use Log;

class DeviceObserver
{
    /**
     * Handle the device "created" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function created(Device $device)
    {
        Log::event("Device $device->hostname has been created", $device, 'system', 3);
    }

    /**
     * Handle the device "deleted" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function deleted(Device $device)
    {
        // delete with NULL Device, so it doesn't get's deleted by daily cleanup scripts
        Log::event("Device $device->hostname has been removed", null, 'system', 3);
    }

    /**
     * Handle the device "updated" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function updated(Device $device)
    {
        // handle device dependency updates
        if ($device->isDirty('max_depth')) {
            $device->children->each->updateMaxDepth();
        }

        // key attribute changes
        foreach (['os', 'sysName', 'version', 'hardware', 'features', 'serial', 'icon', 'type'] as $attribute) {
            if ($device->isDirty($attribute)) {
                Log::event(self::attributeChangedMessage($attribute, $device->$attribute, $device->getOriginal($attribute)), $device, 'system', 3);
            }
        }
        if ($device->isDirty('location_id')) {
            Log::event(self::attributeChangedMessage('location', (string) $device->location, null), $device, 'system', 3);
        }
    }

    /**
     * Handle the device "deleting" event.
     *
     * @param  \App\Models\Device  $device
     * @return void
     */
    public function deleting(Device $device)
    {
        $device->disabled = 1;
        $device->save();

        // delete related data
        $device->ports()->delete();
        $device->syslogs()->delete();
        $device->eventlogs()->delete();
        $device->applications()->delete();

        // handle device dependency updates
        $device->children->each->updateMaxDepth($device->device_id);
    }

    /**
     * Handle the device "Pivot Attached" event.
     *
     * @param  \App\Models\Device  $device
     * @param  string  $relationName  parents or children
     * @param  array  $pivotIds  list of pivot ids
     * @param  array  $pivotIdsAttributes  additional pivot attributes
     * @return void
     */
    public function pivotAttached(Device $device, $relationName, $pivotIds, $pivotIdsAttributes)
    {
        if ($relationName == 'parents') {
            // a parent attached to this device

            // update the parent's max depth incase it used to be standalone
            Device::whereIn('device_id', $pivotIds)->get()->each->validateStandalone();

            // make sure this device's max depth is updated
            $device->updateMaxDepth();
        } elseif ($relationName == 'children') {
            // a child device attached to this device

            // if this device used to be standalone, we need to udpate max depth
            $device->validateStandalone();

            // make sure the child's max depth is updated
            Device::whereIn('device_id', $pivotIds)->get()->each->updateMaxDepth();
        }
    }

    public static function attributeChangedMessage($attribute, $value, $previous)
    {
        return trans("device.attributes.$attribute") . ': '
            . (($previous && $previous != $value) ? "$previous -> " : '')
            . $value;
    }
}
