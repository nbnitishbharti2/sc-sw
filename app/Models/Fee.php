<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\FeeFrequency;
use App\Models\FeeHead;
use App\Models\FeeMonth;
use App\Models\FeeSetting;


class Fee extends Model
{
    use Sortable;

	use SoftDeletes;

	protected $fillable = [ 'session_id', 'fee_name', 'fee_short_name', 'fee_head_id', 'fee_type_id', 'frequency_id', 'status' ];

	public $sortable = ['id', 'session_id', 'fee_name', 'fee_short_name', 'fee_head_id', 'fee_type_id', 'frequency_id', 'status', 'created_at', 'updated_at'];

	/**
     * Get the fee head for the fee.
     */
    public function fee_head()
    {
        return $this->belongsTo('App\Models\FeeHead', 'fee_head_id', 'id');
    }

    /**
     * Get the fee type for the fee.
     */
    public function fee_type()
    {
        return $this->belongsTo('App\Models\FeeType', 'fee_type_id', 'id');
    }

    /**
     * Get the frequency for the fee.
     */
    public function fee_frequency()
    {
        return $this->belongsTo('App\Models\FeeFrequency', 'frequency_id', 'id');
    }

    /**
     * Get the frequency for the fee.
     */
    public function fee_month_map()
    {
        return $this->hasMany('App\Models\FeeMonth', 'fee_id', 'id');
    }

    /**
     * Get the fee list for listing.
     */
    public static function getAllFeeForListing()
    {
        return Fee::select('fees.id', 'fees.fee_name')->leftjoin('sessions', 'sessions.id', 'fees.session_id')->where('sessions.id', Session::get('session'))->get();
    }

    
}
