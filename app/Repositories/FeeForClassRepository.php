<?php 

namespace App\Repositories;

use App\Models\Fee;
use App\Models\Classes;
use App\Models\FeeForClass;
use Log;
use Session;


class FeeForClassRepository{

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllFeeForClass($request)
    {
        try {
            $class=null;
            $fee=null;
            $fee_head=null;
            $fee_type=null;
            $fee_frequency=null;

            $query = FeeForClass::where('session_id',Session::get('session'))->with(['fee','class','fee.fee_head'])->get(); 

            if(isset($request->class)){
                $class=$request->class;
                $query = $query->where('class_id', '=', $class); 
            }
            if(isset($request->fee)){
                $fee=$request->fee;
                $query = $query->where('fee_id', '=', $fee); 
            }
            if(isset($request->fee_head)){
                $fee_head=$request->fee_head;
                $query = $query->where('fee_head_id', '=', $fee_head); 
            }
            if(isset($request->fee_type)){
                $fee_type=$request->fee_type;
                $query = $query->where('fee_type_id', '=', $fee_type); 
            }
            if(isset($request->fee_frequency)){
                $fee_frequency=$request->fee_frequency;
                $query = $query->where('fee_frequency_id', '=', $fee_frequency); 
            }
            return  $query;
        } catch(\Exception $err){
            Log::error('message error in getAllFeeForClass on FeeForClassRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
    public function addFeeForClasses($fee_id)
    {
        try {
            $fee = Fee::findOrFail($fee_id);

            $class_id = FeeForClass::with(['fee','class'])->where('fee_id',$fee_id)->pluck('charge','class_id')->toArray();

            // Create data for add form
            $data = [
                'action'             => route('store.fee-for-classes'),
                'page_title'         => trans('label.fee_for_classes'),
                'title'              => trans('title.add_fee_for_class'),
                'fee_id'             => $fee->id,
                'fee_name'           => $fee->fee_name,
                'fee_short_name'     => $fee->fee_short_name,
                'class_list'         => Classes::getAllClassForListing(),
                'class_id'           => $class_id,  
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in addFeeForClasses on FeeForClassRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function storeFeeForClasses($request)
    {
        try {
            $fee=Fee::findOrFail($request->fee_id);
            $fee_id = $request->fee_id;
            
            $old_class_id = FeeForClass::with(['fee','class'])->where('fee_id',$fee_id)->pluck('class_id','class_id')->toArray();
           
            $fees = array_filter($request->class_id);   
            $class_id = $fees;//current class ids

            $remove_class_id = array_diff($old_class_id,$class_id);//class ids to be removed
           
            $new_class_id = array_diff($class_id,$old_class_id);//class ids to be inserted
            
            //Remove class ids
            $removed_class_id = FeeForClass::where(['session_id'=>Session::get('session'),'fee_id'=>$fee_id])->whereIn('class_id',$remove_class_id)->delete(); 

            //Add class id
            $new_data=array(); 
            foreach ($new_class_id as $key => $value) {
                $new_record=array();
                $new_record['session_id']=Session::get('session');
                $new_record['fee_id']=$fee_id;
                $new_record['class_id']=$key;
                $new_record['charge']=$value;
                $new_record['fee_head_id']=$fee->fee_head_id;
                $new_record['fee_type_id']=$fee->fee_type_id;
                $new_record['fee_frequency_id']=$fee->frequency_id;
                array_push($new_data,$new_record);
            }
            $insert_fee_for_classes = FeeForClass::insert($new_data); 
            
            if($removed_class_id || $insert_fee_for_classes) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in storeFeeForClasses on FeeForClassRepository :'. $err->getMessage());
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
            $fee_for_classes = FeeForClass::with(['fee','class'])->where('id',$fee_id)->first(); //Fetch fee for class data
         
            $class_id = FeeForClass::with(['fee','class'])->where('id',$fee_id)->pluck('charge','class_id')->toArray();

            // Create data for edit form
            $data = [
                'action'          => route('update.fee-for-classes'),
                'page_title'      => trans('label.fee_for_class'),
                'title'           => trans('title.edit_fee_for_class'),
                'fee_id'  => $fee_for_classes->id,
                'fee_name'           => $fee_for_classes->fee->fee_name,
                'fee_short_name'     => $fee_for_classes->fee->fee_short_name,
                'class_list'         => Classes::getSingleClassForListing($fee_for_classes->class_id),
                'class_id'           => $class_id,   
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on FeeForClassRepository :'. $err->getMessage());
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
            $fee_for_classes = FeeForClass::findOrFail($request->fee_id);
              
            $class_id = $request->class_id;//current class ids

            //Add class id
            foreach ($class_id as $key => $value) {
                $fee_for_classes->class_id=$key;
                $fee_for_classes->charge=$value;
            }

            $fee_for_classes->save(); // Update data

            if ($fee_for_classes->wasChanged()) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on FeeForClassRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }




}