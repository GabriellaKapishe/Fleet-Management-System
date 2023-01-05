<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{

    protected $fillable =['imei'];
    protected $table='batch_cut_off';
}
