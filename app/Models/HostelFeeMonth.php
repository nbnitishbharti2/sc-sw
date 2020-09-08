<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Session;
use App\Models\HostelFee;

class HostelFeeMonth extends Model
{
    use Sortable;

	protected $fillable = [ 'session_id', 'hostel_fee_id', 'month_id' ];

	public $sortable = ['id', 'session_id', 'hostel_fee_id', 'month_id', 'created_at', 'updated_at'];
}
