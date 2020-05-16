<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fee;
use App\Models\Classes;

class FeeForClass extends Model
{

	protected $fillable = [ 'session_id', 'fee_id', 'class_id', 'charge' ];

    public function fee()
    {
        return $this->belongsTo('App\Models\Fee', 'fee_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id', 'id');
    }
}
