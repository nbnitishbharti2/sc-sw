<?php 

namespace App\Repositories;

use App\Models\PaymentMode;
use Log;
use Session;

class PaymentModeRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllPaymentMode()
    {
       
    	try {
    		return  $query = PaymentMode::withTrashed()->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllPaymentMode on PaymentModeRepository :'. $err->getMessage());
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
        try {
            $data = [
                'action'          => route('store.payment_mode'),
                'page_title'      => trans('label.payment_mode'),
                'title'           => trans('title.add_payment_mode'),
                'payment_mode_id' => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on PaymentModeRepository :'. $err->getMessage());
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
                'name'    => $request->name
            ];
            
            $payment_mode = PaymentMode::create($data);
            if ($payment_mode->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on PaymentModeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $payment_mode_id
    * @return array $data
    */
    public function edit($payment_mode_id)
    {
        try {
            $payment_mode = PaymentMode::findOrFail($payment_mode_id); //Fetch payment_mode data 
            $data = [
                'action'          => route('update.payment_mode'),
                'page_title'      => trans('label.payment_mode'),
                'title'           => trans('title.edit_payment_mode'),
                'payment_mode_id' => $payment_mode->id,
                'name'            => ($payment_mode->name) ? $payment_mode->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on PaymentModeRepository :'. $err->getMessage());
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
            $payment_mode  = PaymentMode::findOrFail($request->payment_mode_id); //Fetch payment mode data
            $payment_mode->name  = $request->name;
            $payment_mode->save(); // Update data
            if ($payment_mode->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on PaymentModeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($payment_mode_id)
    {
        try {
            $payment_mode = PaymentMode::destroy($payment_mode_id);
            if ($payment_mode) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on PaymentModeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($payment_mode_id)
    {
        try {
            $payment_mode = PaymentMode::withTrashed()->find($payment_mode_id)->restore();
            if ($payment_mode) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on PaymentModeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}