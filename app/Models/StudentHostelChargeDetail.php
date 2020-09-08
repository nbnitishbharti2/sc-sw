<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class StudentHostelChargeDetail extends Model
{
    use Sortable;

	protected $fillable=[ 'session_id', 'student_session_detail_id', 'student_hostel_detail_id', 'hostel_fee_id', 'fee_type_id', 'fee_head_id', 'amount' ];


}
