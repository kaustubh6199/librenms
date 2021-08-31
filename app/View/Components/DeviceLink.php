<?php

namespace App\View\Components;

use App\Facades\DeviceCache;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\View\Component;
use LibreNMS\Util\Graph;

class DeviceLink extends Component
{
    /**
     * @var \App\Models\Device
     */
    public $device;
    public $graphStart;
    public $graphEnd;
    public $tab;
    public $secondGraphStart;
    public $section;

    /**
     * Create a new component instance.
     *
     * @param int|\App\Models\Device $device
     */
    public function __construct($device, ?string $tab = null, ?string $section = null, ?string $graphStart = null, ?string $graphEnd = null)
    {
        $this->device = $device instanceof Device ? $device : DeviceCache::get($device);
        $this->graphStart = $graphStart;
        $this->graphEnd = $graphEnd;
        $this->secondGraphStart = Carbon::parse($graphStart)->subWeek()->timestamp;
        $this->tab = $tab;
        $this->section = $section;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (! $this->device->canAccess(auth()->user())) {
            return view('components.device-link-no-access');
        }

        return view('components.device-link', [
            'graphs' => Graph::getOverviewGraphsForDevice($this->device),
        ]);
    }

    public function linkClass()
    {
        if ($this->device->disabled) {
            return 'list-device-disabled';
        }

        if ($this->device->ignore) {
            return $this->device->status ? 'list-device-ignored-up' : 'list-device-ignored';
        }

        return $this->device->status ? 'list-device' : 'list-device-down';
    }
}
