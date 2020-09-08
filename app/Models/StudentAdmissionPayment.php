<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Session;
use App\Models\StudentDetail;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\FeeHead;
use App\Models\StudentAdmissionTransaction;

class StudentAdmissionPayment extends Model
{
	use Sortable;

    protected $fillable = [ 'session_id', 'student_detail_id', 'fee_id', 'fee_type_td', 'fee_head_id', 'st_adm_trans_id', 'amount', 'created_at', 'updated_at' ];

    public $sortable = ['id', 'session_id', 'student_detail_id', 'fee_id', 'fee_type_td', 'fee_head_id', 'st_adm_trans_id', 'amount', 'created_at', 'updated_at' ];

  
}
