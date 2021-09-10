<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LibreNMS\Interfaces\Models\Keyable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessPoint extends DeviceRelatedModel implements Keyable
{
    use HasFactory;
    use SoftDeletes;

    public $primaryKey = 'accesspoint_id';
    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'name',
        'radio_number',
        'type',
        'mac_addr',
        'channel',
        'txpow',
        'radioutil',
        'numasoclients',
        'nummonclients',
        'numactbssid',
        'nummonbssid',
        'interference',
    ];

    public function getCompositeKey()
    {
        return "$this->mac_addr-$this->radio_number";
    }

}
