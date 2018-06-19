<?php

namespace App\Models;

class Inventory extends BaseModel
{
    protected $table = 'entPhysical';

    protected $primaryKey = 'entPhysical_id';

    public $timestamps = false;

    public function scopeHasAccess($query, User $user)
    {
        return $this->hasDeviceAccess($query, $user);
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }
}
