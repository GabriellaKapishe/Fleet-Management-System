<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FleetServiceStation extends Model
{
    protected $table='fleet_service_station';
    protected $fillable = [
        'companyId',
        'serviceStationId',
    ];
}
