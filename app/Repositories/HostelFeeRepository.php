<?php 

namespace App\Repositories;

use App\Models\Fee;
use App\Models\HostelFee;
use App\Models\FeeFrequency;
use App\Models\FeeHead;
use App\Models\HostelFeeMonth;
use App\Models\FeeType;
use App\Models\Month;
use App\Models\FeeSetting;
use App\Models\Classes;
use App\Models\FeeForClass;
use Log;
use Session;


class HostelFeeRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllFee()
    {
    	try {
            return  $query = HostelFee::where('session_id',Session::get('session'))->with(['fee_head','fee_type','fee_frequency']) ->withTrashed()->get(); 
        } catch(\Exception $err){
            Log::error('message error in getAllFee on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch create resource data
    *
    * @return array $data
    */
    public function create()
    {
        $applied_in_month_ids = array();
        try {
            $data = [
                'action'          => route('store.hostel-fee'),
                'page_title'      => trans('label.fee'),
                'title'           => trans('title.add_fee'),
                'fee_id'          => 0,
                'fee_name'        => (old('fee_name')) ? old('fee_name') : '',
                'fee_short_name'  => (old('fee_short_name')) ? old('fee_short_name') : '',
                'fee_head_list'   => FeeHead::getAllFeeHeadForListing(),
                'fee_head_id'     => 0,
                'fee_type_list'   => FeeType::getAllFeeTypeForListing(),
                'fee_type_id'     => 0,
                'frequency_id'    => 0,
                'frequency_value' => 0,
                'month_list'      => Month::getAllMonthForListing(),
                'month_ids'       => $applied_in_month_ids,
                'amount'          => 0,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

   
    /**
    * Method to create resource
    * @param $request
    * @return boolean
    */
    public function store($request) 
    {
        try {
            $data = [
                'session_id'            => Session::get('session'),
                'fee_name'              => $request->fee_name,
                'fee_short_name'        => $request->fee_short_name,
                'fee_head_id'           => $request->fee_head_id,
                'fee_type_id'           => $request->fee_type_id,
                'frequency_id'          => $request->frequency_id,
                'amount'                => $request->amount,
                'status'                => 'Active',
            ];
            
            $fee=HostelFee::create($data);
            if ($fee->exists) {
                $new_data=array(); 
                foreach ($request->month_ids as $key => $value) {
                    $new_record=array();
                    $new_record['session_id']=Session::get('session');
                    $new_record['hostel_fee_id']=$fee->id;
                    $new_record['month_id']=$value;
                    array_push($new_data,$new_record);
                }
                $fee_months = HostelFeeMonth::insert($new_data); 
                if($fee_months){
                    return true;
                } else {
                    return false;  
                }
            }else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch edit resource data
    * @param int $hostel_fee_id
    * @return array $data
    */
    public function edit($hostel_fee_id)
    {
        try {
            $hostel_fee = HostelFee::withTrashed()->with(['fee_head','fee_type','fee_frequency'])->where('id',$hostel_fee_id)->first(); //Fetch hostel fee data
           
            $applied_in_month_ids = HostelFeeMonth::where(['session_id'=>Session::get('session'),'hostel_fee_id'=>$hostel_fee_id])->pluck('month_id')->toArray();
           
            $frequency_id = ($hostel_fee->frequency_id == null) ? '0' : $hostel_fee->fee_frequency->id;
    
            // Create data for edit form
            $data = [
                'action'          => route('update.hostel-fee'),
                'page_title'      => trans('label.fee'),
                'title'           => trans('title.edit_fee'),
                'fee_id'          => $hostel_fee->id,
                'fee_name'        => ($hostel_fee->fee_name) ? $hostel_fee->fee_name : old('fee_name'),
                'fee_short_name'  => ($hostel_fee->fee_short_name) ? $hostel_fee->fee_short_name : old('fee_short_name'),
                'fee_head_list'   => FeeHead::getAllFeeHeadForListing(),
                'fee_head_id'     => $hostel_fee->fee_head->id,
                'fee_type_list'   => FeeType::getAllFeeTypeForListing(),
                'fee_type_id'     => $hostel_fee->fee_type->id,
                'frequency_id'    => (old('frequency_id')) ? old('frequency_id') : $frequency_id,
                'frequency_value' => (isset($hostel_fee->fee_frequency->value)) ? $hostel_fee->fee_frequency->value : '0',
                'month_list'      => Month::getAllMonthForListing(),
                'month_ids'       => (empty($applied_in_month_ids)) ? array() : $applied_in_month_ids,   
                'amount'          => ($hostel_fee->amount) ? $hostel_fee->amount : old('amount'),
            ];  
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to update resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function update($request)
    {
        try {
            $response = 'false';
            $hostel_fee  = HostelFee::findOrFail($request->fee_id); //Fetch hostel fee data

            if($request->frequency_id != null)
            {
                $old_month_ids = HostelFeeMonth::where(['session_id'=>Session::get('session'),'hostel_fee_id'=>$request->fee_id])->pluck('month_id','month_id')->toArray(); //old month ids
        
                $month_ids=$request->month_ids; //current requested month ids
                
                $remove_month_ids=array_diff($old_month_ids,$month_ids);
                
                $new_month_ids=array_diff($month_ids,$old_month_ids);//month ids to be inserted
               
                //Remove month ids
                $removed_month_ids = HostelFeeMonth::where(['session_id'=>Session::get('session'),'hostel_fee_id'=>$request->fee_id])->whereIn('month_id',$remove_month_ids)->delete(); 

                //Add month ids
                $new_data=array(); 
                foreach ($new_month_ids as $key => $value) {
                    $new_record=array();
                    $new_record['session_id']=Session::get('session');
                    $new_record['hostel_fee_id']=$request->fee_id;
                    $new_record['month_id']=$value;
                    array_push($new_data,$new_record);
                }
                $hostel_fee_months = HostelFeeMonth::insert($new_data); 
            }
            
            //Updating Fee data
            $hostel_fee->fee_name              = $request->fee_name;
            $hostel_fee->fee_short_name        = $request->fee_short_name;
            $hostel_fee->fee_head_id           = $request->fee_head_id;
            $hostel_fee->fee_type_id           = $request->fee_type_id;
            $hostel_fee->frequency_id          = $request->frequency_id;
            $hostel_fee->amount                = $request->amount;
            $hostel_fee->status                = 'Active';
            $hostel_fee->save(); // Update data
        
            if($hostel_fee->wasChanged() || $removed_month_ids || $hostel_fee_months) { 
            //Check if data was updated
                $response = 'true';
            }else {
                $response = 'false';
            }
            return $response;
        } catch(\Exception $err){
            Log::error('message error in update on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($hostel_fee_id)
    {
        try {
            $hostel_fee = HostelFee::destroy($hostel_fee_id);
            if ($hostel_fee) { //Check if data was deleted
                 return true;
            } else {
                 return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($hostel_fee_id)
    {
        try {
            $hostel_fee = HostelFee::withTrashed()->find($hostel_fee_id)->restore();
            if ($hostel_fee) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on HostelFeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
 


}