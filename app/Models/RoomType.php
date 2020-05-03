<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    

    /**
     * Get the vehicle type list for listing.
     */
    public static function getAllRoomTypeForListing()
    {
    	return RoomType::select('room_types.id', 'room_types.name')->get();
    }
}
