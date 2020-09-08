<?php 

namespace App\Repositories;

use App\Models\Fee;
use App\Models\FeeFrequency;
use App\Models\FeeHead;
use App\Models\FeeMonth;
use App\Models\FeeType;
use App\Models\Month;
use App\Models\FeeSetting;
use App\Models\Classes;
use App\Models\FeeForClass;
use Log;
use Session;


class FeeRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllFee()
    {
    	try {
            return  $query = Fee::where('session_id', Session::get('session'))->with(['fee_head', 'fee_type', 'fee_frequency'])->where('fee_head_id', '1')->withTrashed()->get(); 
        } catch(\Exception $err){
            Log::error('message error in getAllFee on FeeRepository :'. $err->getMessage());
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
                'action'          => route('store.fee'),
                'page_title'      => trans('label.fee'),
                'title'           => trans('title.add_fee'),
                'fee_id'          => 0,
                'fee_name'        => (old('fee_name')) ? old('fee_name') : '',
                'fee_short_name'  => (old('fee_short_name')) ? old('fee_short_name') : '',
                'fee_head_id'     => 0,
                'fee_type_list'   => FeeType::getAllFeeTypeForListing(),
                'fee_type_id'     => 0,
                'frequency_id'    => 0,
                'frequency_value' => 0,
                'month_list'      => Month::getAllMonthForListing(),
                'month_ids'       => $applied_in_month_ids,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getFee($fee_head_id,$fee_type_id)
    { 
        try { 
            $fee=Fee::where(['fee_head_id'=>$fee_head_id, 'fee_type_id'=>$fee_type_id])->pluck('fee_name', 'id');
            return $fee;
        } catch(\Exception $err){
            Log::error('message error in getFee on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getFeeHeadFrequency($fee_head_id)
    { 
        try { 
            if($fee_head_id==1){
                $field='school_fee_frequency';
            }else if($fee_head_id==2){
                $field='transport_fee_frequency';
            }else if($fee_head_id==3){
                $field='hostel_fee_frequency';
            }
            $frequency_settings=FeeSetting::first($field);
            return $frequency_settings;
        } catch(\Exception $err){
            Log::error('message error in getFeeFrequency on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getFeeFrequency($fee_setting_id)
    { 
        try { 
            $frequency_ids=FeeFrequency::where('id', '>=', $fee_setting_id)->pluck('name','id');
            return json_encode($frequency_ids);
        } catch(\Exception $err){
            Log::error('message error in getFeeFrequency on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getFeeFrequencyValue($frequency_id)
    {
        try { 
            $frequency_value=FeeFrequency::where('id', $frequency_id)->pluck('value');
            return json_encode($frequency_value);
        } catch(\Exception $err){
            Log::error('message error in getFeeFrequencyValue on FeeRepository :'. $err->getMessage());
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
                'status'                => 'Active',
            ];
            $fee=Fee::create($data);
            if ($fee->exists) {
                $new_data=array(); 
                foreach ($request->month_ids as $key => $value) {
                    $new_record=array();
                    $new_record['session_id']=Session::get('session');
                    $new_record['fee_id']=$fee->id;
                    $new_record['month_id']=$value;
                    array_push($new_data,$new_record);
                }
                $fee_months = FeeMonth::insert($new_data); 
                if($fee_months){
                    return true;
                } else {
                    return false;  
                }
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch edit resource data
    * @param int $fee_id
    * @return array $data
    */
    public function edit($fee_id)
    {
        try {
            $fee = Fee::withTrashed()->with(['fee_head','fee_type','fee_frequency'])->where('id',$fee_id)->first(); //Fetch fee data

            $applied_in_month_ids = FeeMonth::where(['session_id'=>Session::get('session'),'fee_id'=>$fee_id])->pluck('month_id')->toArray();
            
            $frequency_id = ($fee->frequency_id == null) ? '0' : $fee->fee_frequency->id;

            // Create data for edit form
            $data = [
                'action'          => route('update.fee'),
                'page_title'      => trans('label.fee'),
                'title'           => trans('title.edit_fee'),
                'fee_id'          => $fee->id,
                'fee_name'        => ($fee->fee_name) ? $fee->fee_name : old('fee_name'),
                'fee_short_name'  => ($fee->fee_short_name) ? $fee->fee_short_name : old('fee_short_name'),
                'fee_head_id'     => $fee->fee_head->id,
                'fee_type_list'   => FeeType::getAllFeeTypeForListing(),
                'fee_type_id'     => $fee->fee_type->id,
                'frequency_id'    => (old('frequency_id')) ? old('frequency_id') : $frequency_id,
                'frequency_value' => (isset($fee->fee_frequency->value)) ? $fee->fee_frequency->value : '0',
                'month_list'      => Month::getAllMonthForListing(),
                'month_ids'       => (empty($applied_in_month_ids)) ? array() : $applied_in_month_ids,   
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on FeeRepository :'. $err->getMessage());
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
            $fee  = Fee::findOrFail($request->fee_id); //Fetch fee data

            if($request->frequency_id != null)
            {
                $old_month_ids = FeeMonth::where(['session_id'=>Session::get('session'),'fee_id'=>$request->fee_id])->pluck('month_id','month_id')->toArray(); //old month ids
        
                $month_ids=$request->month_ids; //current requested month ids
                
                $remove_month_ids=array_diff($old_month_ids,$month_ids);
                
                $new_month_ids=array_diff($month_ids,$old_month_ids);//month ids to be inserted
               
                //Remove month ids
                $removed_month_ids = FeeMonth::where(['session_id'=>Session::get('session'),'fee_id'=>$request->fee_id])->whereIn('month_id',$remove_month_ids)->delete(); 

                //Add month ids
                $new_data=array(); 
                foreach ($new_month_ids as $key => $value) {
                    $new_record=array();
                    $new_record['session_id']=Session::get('session');
                    $new_record['fee_id']=$request->fee_id;
                    $new_record['month_id']=$value;
                    array_push($new_data,$new_record);
                }
                $fee_months = FeeMonth::insert($new_data); 

                if($removed_month_ids || $fee_months){
                    $response = 'true';
                }else {
                    $response = 'false';
                }
            }
            
            //Updating Fee data
            $fee->fee_name              = $request->fee_name;
            $fee->fee_short_name        = $request->fee_short_name;
            $fee->fee_head_id           = $request->fee_head_id;
            $fee->fee_type_id           = $request->fee_type_id;
            $fee->frequency_id          = $request->frequency_id;
            $fee->status                = 'Active';
            $fee->save(); // Update data
        
            if($fee->wasChanged()|| $removed_month_ids || $fee_months) {  
            //Check if data was updated
                $response = 'true';
            }else {
                $response = 'false';
            }
            return $response;
        } catch(\Exception $err){
            Log::error('message error in update on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($fee_id)
    {
        try {
            $fee = Fee::destroy($fee_id);
            if ($fee) { //Check if data was deleted
                 return true;
            } else {
                 return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($fee_id)
    {
        try {
            $fee = Fee::withTrashed()->find($fee_id)->restore();
            if ($fee) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on FeeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    


}