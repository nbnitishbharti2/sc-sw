<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class StudentTransportDetail extends Model
{
    use Sortable;

	protected $fillable=[ 'session_id', 'student_session_detail_id', 'root_id', 'vehicle_type_id', 'vehicle_id', 'stopage_id', 'fee_head_id', 'fee_type_id', 'amount' ];
}
