<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LibreNMS\Util\DynamicConfig;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $tab
     * @param string $section
     * @return \Illuminate\Http\Response
     */
    public function index($tab = 'global', $section = '')
    {
        $data = [
            'active_tab' => $tab,
            'active_section' => $section,
        ];

        return view('settings.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DynamicConfig $config
     * @param  \Illuminate\Http\Request $request
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DynamicConfig $config, Request $request, $id)
    {
        $value = $request->get('value');

        if (!$config->isValidSetting($id)) {
            return $this->jsonResponse($id, ":id is not a valid setting", null, 400);
        }

        $current = \LibreNMS\Config::get($id);
        $config_item = $config->get($id);

        if (!$config_item->checkValue($value)) {
            return $this->jsonResponse($id, __('settings.validate.' . $config_item->getType(), ['id' => $id, 'value' => $value]), $current, 400);
        }

        if (\LibreNMS\Config::set($id, $value, true)) {
            return $this->jsonResponse($id, "Successfully set $id", $value);
        }

        return $this->jsonResponse($id, "Failed to update :id", $current, 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DynamicConfig $config
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DynamicConfig $config, $id)
    {
        if (!$config->isValidSetting($id)) {
            return $this->jsonResponse($id, ":id is not a valid setting", null, 400);
        }

        if (\App\Models\Config::destroy($id)) {
            return $this->jsonResponse($id, ":id reset to default", $config->get($id)->default);
        }

        return $this->jsonResponse($id, ":id is not set", null, 400);
    }

    public function listAll(DynamicConfig $config)
    {
        return response()->json($config->all()->filter->isValid());
    }

    /**
     * @param string $id
     * @param string $message
     * @param mixed $value
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($id, $message, $value = null, $status = 200)
    {
        return new JsonResponse([
            'message' => __($message, ['id' => $id]),
            'value' => $value,
        ], $status);
    }
}
