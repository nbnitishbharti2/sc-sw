<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\Type;
use App\Models\RoomType;
use App\Models\Hostel;

class Room extends Model
{
	use Sortable;

	use SoftDeletes;

	protected $fillable = [ 'session_id', 'name', 'type_id', 'hostel_id', 'room_type_id', 'room_capacity', 'current_room_capacity', 'charge' ];

	public $sortable = ['id', 'session_id', 'name', 'type_id', 'hostel_id', 'room_type_id', 'room_capacity', 'current_room_capacity', 'charge', 'created_at', 'updated_at'];

	public function type()
	{
		return $this->belongsTo('App\Models\Type', 'type_id', 'id');
	}

	public function hostel()
	{
		return $this->belongsTo('App\Models\Hostel', 'hostel_id', 'id');
	}

	public function room_type()
	{
		return $this->belongsTo('App\Models\RoomType', 'room_type_id', 'id');
	}

	public static function get_room_list($hostel_id,$session_id)
	{
		//dd($hostel_id);
		return Room::where(['hostel_id'=>$hostel_id, 'session_id'=>$session_id])->pluck('name', 'id')->toArray();
	}

	public static function getCharge($room_id,$session_id,$bed_no)
    { 
        //dd($room_id);
        $room =Room::where(['id'=>$room_id, 'session_id'=>$session_id])->first();
        //$charge=$room->charge; 
        $room_capacity = $room->room_capacity;
        //dd($room_capacity);
        $alloted_bed_numbers = StudentHostelDetail::where(['room_id'=>$room_id, 'session_id'=>$session_id])->pluck('bed_no','bed_no')->toArray();
        //dd($alloted_bed_numbers);
        $bed_no_list = array();

        array_push($bed_no_list, $bed_no);
       
        for($i=1; $i<=$room_capacity; $i++)
        {
           
            if(!in_array($i,$alloted_bed_numbers)){
               array_push($bed_no_list, $i);
            }
             
        }
        return $bed_no_list;
    }



	
}
