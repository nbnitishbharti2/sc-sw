<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public static function getFeeApplicable($session_id,$class,$fee_head,$fee_type)
    {
    	return FeeForClass::select('fee_for_classes.id', 'fee_for_classes.charge', 'fee_for_classes.fee_id')->where('fee_for_classes.session_id', $session_id)->where('fee_for_classes.class_id', $class)->where('fee_for_classes.fee_head_id', $fee_head)->where('fee_for_classes.fee_type_id', $fee_type)->with('fee')->get();
    }
}
