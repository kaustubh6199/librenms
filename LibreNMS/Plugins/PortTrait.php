<?php

namespace LibreNMS\Plugins;

use App\Models\Port;

trait PortTrait
{
    public static function port_container($device, $port)
    {
        echo view(self::prefix() . self::authenticateDeviceHook($device, $port), self::portData(Port::find($port['port_id'])));
    }

    protected static function authenticatePortHook($device)
    {
        return 'port';
    }

    protected static function portData(Port $port): array
    {
        return [
            'title' => self::className(),
            'port'  => $port,
        ];
    }
}
