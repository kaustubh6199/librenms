<?php

namespace App\Models;

class Vlan extends DeviceRelatedModel
{
    protected $primaryKey = 'vlan_id';
    public $timestamps = false;
    protected $fillable = [
        'vlan_vlan',
        'vlan_domain',
        'vlan_name',
        'vlan_type',
        'vlan_mtu',
    ];
}
