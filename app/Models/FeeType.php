<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    /**
     * Get the fee type list for listing.
     */
    public static function getAllFeeTypeForListing()
    {
    	return FeeType::select('fee_types.id', 'fee_types.name')->get();
    }

    
}
