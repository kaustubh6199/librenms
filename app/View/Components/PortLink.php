<?php

namespace App\View\Components;

use App\Models\Port;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use LibreNMS\Util\Rewrite;
use LibreNMS\Util\Url;

class PortLink extends Component
{
    public $port;
    public $link;
    public $label;
    public $description;
    public $graphs;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Port $port, $graphs = null)
    {
        $this->port = $port;
        $this->link = Url::portUrl($port);
        $this->label = Rewrite::normalizeIfName($port->getLabel());
        $this->description = $port->getDescription();

        $this->graphs = $graphs === null ? [
            ['type' => 'port_bits', 'title' => trans('Traffic'), 'vars' => [['from' => '-1d'], ['from' => '-7d'], ['from' => '-30d'], ['from' => '-1y']]],
        ] : Arr::wrap($graphs);

        if ($this->description == $this->label) {
            $this->description = '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.port-link');
    }

    public function linkClass()
    {
        if ($this->port->ifAdminStatus == 'down') {
            return 'interface-admindown';
        }

        if ($this->port->ifAdminStatus == 'up' && $this->port->ifOperStatus != 'up') {
            return 'interface-updown';
        }

        return 'interface-upup';
    }

    public function fillDefaultVars(array $vars): array
    {
        return array_map(function ($graph_vars) {
            return array_merge([
                'from' => '-1d',
                'type' => 'port_bits',
                'legend' => 'yes',
                'text' => '',
            ], Arr::wrap($graph_vars));
        }, $vars);
    }
}
