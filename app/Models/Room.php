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
}
