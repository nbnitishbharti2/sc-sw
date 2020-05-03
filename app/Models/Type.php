<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    
    /**
     * Get the type list for listing.
     */
    public static function getAllTypeForListing()
    {
    	return Type::select('types.id', 'types.name')->get();
    }
}
