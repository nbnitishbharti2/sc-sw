<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Session;
use App\Models\StudentDetail;
use App\Models\PaymentMode;


class StudentAdmissionTransaction extends Model
{
	use Sortable;

    protected $fillable = [ 'session_id', 'student_detail_id', 'payment_mode_id', 'transaction_no', 'remarks', 'created_at', 'updated_at' ];

    public $sortable = ['id', 'session_id', 'student_detail_id', 'payment_mode_id', 'transaction_no', 'remarks', 'created_at', 'updated_at' ];


}
