<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Fee;

class FeeHead extends Model
{

	use Sortable;

	public $sortable = ['id', 'name'];

	/**
     * Get the fees for the fee head.
     */
    public function fee()
    {
        return $this->hasMany('App\Models\Fee', 'fee_head_id', 'id');
    }



    /**
     * Get the fee head list for listing.
     */
    public static function getAllFeeHeadForListing()
    {
    	return FeeHead::select('fee_heads.id', 'fee_heads.name')->get();
    }



}
