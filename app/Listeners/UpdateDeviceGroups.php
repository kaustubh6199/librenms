<?php

namespace App\Listeners;

use App\Action;
use App\Actions\Device\UpdateDeviceGroupsAction;
use App\Events\DevicePolled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class UpdateDeviceGroups
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DevicePolled  $event
     * @return void
     */
    public function handle(DevicePolled $event)
    {
        Log::info('### Start Device Groups ###');
        $dg_start = microtime(true);

        // update device groups
        $group_changes = Action::execute(UpdateDeviceGroupsAction::class, $event->device);

        $added = implode(',', $group_changes['attached']);
        $removed = implode(',', $group_changes['detached']);
        $elapsed = round(microtime(true) - $dg_start, 4);

        Log::debug("Groups Added: $added  Removed: $removed");
        Log::info("### End Device Groups, runtime: {$elapsed}s ### \n");
    }
}
