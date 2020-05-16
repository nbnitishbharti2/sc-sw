<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    /**
     * Get the Month for listing.
     */
    public static function getAllMonthForListing()
    {
        return Month::pluck('name','id');
    }



}
