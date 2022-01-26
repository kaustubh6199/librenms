<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use Illuminate\Http\Request;
use LibreNMS\Config;
use LibreNMS\DB\Eloquent;
use LibreNMS\Util\Html;

class LocationController extends Controller
{
    public function index()
    {
        $maps_api = Config::get('geoloc.api_key');
        $data = [
            'maps_api' => $maps_api,
            'maps_engine' => $maps_api ? Config::get('geoloc.engine') : '',
        ];

        $data['graph_template'] = '';
        Config::set('enable_lazy_load', false);
        $graph_array = [
            'type' => 'location_bits',
            'height' => '100',
            'width' => '220',
            'legend' => 'no',
            'id' => '{{id}}',
        ];

        $data['device_types'] = $this->device_types();

        foreach (Html::graphRow($graph_array) as $graph) {
            $data['graph_template'] .= "<div class='col-md-3'>";
            $data['graph_template'] .= str_replace('%7B%7Bid%7D%7D', '{{id}}', $graph); // restore handlebars
            $data['graph_template'] .= '</div>';
        }

        return view('locations', $data);
    }

    private function device_types(): array
    {
        $device_types = [];

        $counts = Device::groupBy('type')->select('type', Eloquent::DB()->raw('COUNT(*) as total'))->orderByDesc('total')->pluck('total', 'type');
        // only top n columns visible by default, or show all present device_types
        $top = $counts->take(\LibreNMS\Config::get('top_device_types') ?: count(\LibreNMS\Config::get('device_types')));

        foreach(\LibreNMS\Config::get('device_types') as $device_type) {
            $device_types[] = [
                'type' => $device_type['type'],
                'count' => $counts->get($device_type['type'], 0),
                'visible' => $top->has($device_type['type']),
            ];
        }

        usort($device_types, function ($item1, $item2) {
            return $item1['type'] <=> $item2['type'];
        });

        return $device_types;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Location  $location
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Location $location)
    {
        $this->authorize('admin', $request->user());

        $this->validate($request, [
            'lat' => 'required|numeric|max:90|min:-90',
            'lng' => 'required|numeric|max:180|min:-180',
        ]);

        $location->fill($request->only(['lat', 'lng']));
        $location->fixed_coordinates = true;  // user has set coordinates, block automated changes
        $location->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location  $location
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function destroy(Request $request, Location $location)
    {
        $this->authorize('admin', $request->user());

        $location->delete();

        return response()->json(['status' => 'success']);
    }
}
