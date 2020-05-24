<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeFrequency extends Model
{

	/**
     * Get the fee frequency list for listing.
     */
    public static function getAllFeeFrequencyForListing()
    {
    	return FeeFrequency::select('fee_frequencies.id', 'fee_frequencies.name')->get();
    }


    //Get value for particular frequency
    public static function getValueByFrequency($frequency_id)
    {
    	dd($frequency_id);
    	$frequency_value = FeeFrequency::where('id',$frequency_id)->get();
    	dd($frequency_value);
    	return $frequency_value;
    }
}
