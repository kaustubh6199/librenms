<?php

namespace App\Models;

class PortVdsl extends PortRelatedModel
{
    protected $fillable = [
        'port_id',
        'xdsl2LineStatusAttainableRateDs',
        'xdsl2LineStatusAttainableRateUs',
        'xdsl2ChStatusActDataRateXtur',
        'xdsl2ChStatusActDataRateXtuc',
        'xdsl2LineStatusActAtpDs',
        'xdsl2LineStatusActAtpUs',
    ];
    protected $table = 'ports_vdsl';
    protected $primaryKey = 'port_id';
    public $timestamps = false;
}
