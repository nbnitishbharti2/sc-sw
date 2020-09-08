<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class StudentHostelDetail extends Model
{
    use Sortable;

	protected $fillable=[ 'session_id', 'st_session_detail_id', 'hostel_id', 'room_id', 'bed_no', 'amount' ];


}
