<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeSetting extends Model
{
    public static function getFeeDetails($session=null)
    {
        $session_id=($session)?$session:Session::get('session');
        return FeeSetting::where('session_id', $session_id)->first();
    }
}
