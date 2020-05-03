<?php 

namespace App\Repositories;

use App\Models\Stopage;
use App\Models\VehicleRootMap;
use App\Models\Root;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Log;
use Lang;
use Session;


class StopageRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllStopage()
    {

        try {
            return  $query = Stopage::where('session_id',Session::get('session'))->withTrashed()->with(['roots','vehicle_types','vehicles'])->get();  
        } catch(\Exception $err){
            Log::error('message error in getAllStopage on StopageRepository :'. $err->getMessage());
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
                'action'          => route('store.stopage'),
                'page_title'      => Lang::get('label.stopage'),
                'title'           => Lang::get('title.add_stopage'),
                'stopage_id' => 0,
                'stopage_name' => (old('stopage_name')) ? old('stopage_name') : '',
                'root_list'    => Root::getAllRootForListing(),
                'root_id'       => 0,
                'vehicle_type_id'       => 0,
                'vehicle_id'       => 0,
                'charge' => (old('charge')) ? old('charge') : '',

            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on StopageRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    public function getVehicleType($root_id)
    { 
        try { 
            $vehicle_type_ids=VehicleRootMap::with('vehicle_types')->distinct()->where('root_id',$root_id)->get()->pluck('vehicle_types.name', 'vehicle_types.id');
            return $vehicle_type_ids;
        } catch(\Exception $err){
            Log::error('message error in getVehicleType on StopageRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    public function getVehicleNo($vehicle_type_id,$root_id)
    { 
        try {  
            $vehicle_ids=Vehicle::join('vehicle_root_maps','vehicle_root_maps.vehicle_id','=','vehicles.id')->where(['vehicle_root_maps.root_id'=>$root_id,'vehicle_root_maps.vehicle_type_id'=>$vehicle_type_id])->select(\DB::raw("CONCAT(vehicles.vehicle_no, ' (', vehicles.driver_name, ')') AS VEHICLEDETAILS"),'vehicles.id')->get()->pluck('VEHICLEDETAILS', 'id');
            return $vehicle_ids;
        } catch(\Exception $err){
            Log::error('message error in getVehicleNo on StopageRepository :'. $err->getMessage());
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
                'session_id'       => Session::get('session'),
                'stopage_name'     => $request->stopage_name,
                'root_id'          => $request->root_id,
                'vehicle_type_id'  => $request->vehicle_type_id,
                'vehicle_id'       => $request->vehicle_id,
                'charge'           => $request->charge,
            ];
            
            $stopage = Stopage::create($data);
            if ($stopage->exists) {
             return true;
         } else {
             return false;
         }
     } catch(\Exception $err){
        Log::error('message error in store on StopageRepository :'. $err->getMessage());
        return back()->with('error', $err->getMessage());
    }
}

    /**
    * Method to fetch edit resource data
    * @param int $stopage_id
    * @return array $data
    */
    public function edit($stopage_id)
    {
        try {
            $stopage = Stopage::withTrashed()->with(['roots','vehicle_types','vehicles'])
                ->where('id',$stopage_id)->first(); //Fetch stopage root map data
            // Create data for edit form
                $data = [
                    'action'              => route('update.stopage'),
                    'page_title'          => Lang::get('label.stopage'),
                    'title'               => Lang::get('title.edit_stopage'),
                    'stopage_id'          => $stopage->id,
                    'stopage_name'        => ($stopage->stopage_name) ? $stopage->stopage_name : old('stopage_name'),
                    'root_list'           => Root::getAllRootForListing(),
                    'root_id'             => $stopage->roots->id,
                    'vehicle_type_id'     => $stopage->vehicle_types->id,
                    'vehicle_id'          => $stopage->vehicles->id,
                    'charge'              => ($stopage->charge) ? $stopage->charge : old('charge'),
                ];
                return $data;
            } catch(\Exception $err){ 
                Log::error('message error in edit on StopageRepository :'. $err->getMessage());
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
            $stopage  = Stopage::findOrFail($request->stopage_id); //Fetch stopage data
            $stopage->stopage_name     =  $request->stopage_name;
            $stopage->root_id          =  $request->root_id;
            $stopage->vehicle_type_id  =  $request->vehicle_type_id;
            $stopage->vehicle_id       =  $request->vehicle_id;
            $stopage->charge           =  $request->charge;
            $stopage->save(); // Update data
            if ($stopage->wasChanged()) { //Check if data was updated
             return true;
         } else {
             return false;
         }
     } catch(\Exception $err){
        Log::error('message error in update on StopageRepository :'. $err->getMessage());
        return back()->with('error', $err->getMessage());
    }
}

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($stopage_id)
    {
        try {
            $stopage = Stopage::destroy($stopage_id);
            if ($stopage) { //Check if data was updated
             return true;
         } else {
             return false;
         }
     } catch(\Exception $err){
        Log::error('message error in delete on StopageRepository :'. $err->getMessage());
        return back()->with('error', $err->getMessage());
    }
}

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($stopage_id)
    {
        try {
            $stopage = Stopage::withTrashed()->find($stopage_id)->restore();
            if ($stopage) { //Check if data was updated
             return true;
         } else {
             return false;
         }
     } catch(\Exception $err){
        Log::error('message error in restore on StopageRepository :'. $err->getMessage());
        return back()->with('error', $err->getMessage());
    }
}
public function importPreviousSessionStopages()
{
    try{
       $prevsession = Session::get('prevsession');
       $nextSession = Session::get('session');
       $stopage = Stopage::where('session_id',$prevsession)->get();
        if ($stopage->count() == 0) { //Check if data was not found in previous session
           return false;
       } else {
        foreach ($stopage as $key => $value) {
            $data = [
                'session_id'    => $nextSession,
                'stopage_name'    => $value->stopage_name,
                'root_id'   => $value->root_id,
                'vehicle_type_id'    => $value->vehicle_type_id,
                'vehicle_id'   => $value->vehicle_id,
                'charge'   => $value->charge
            ];
            $check_stopage = Stopage::where(['stopage_name' => $value->stopage_name,'root_id' => $value->root_id,'vehicle_type_id' => $value->vehicle_type_id,'vehicle_id' => $value->vehicle_id, 'session_id' => $nextSession])->count(); 
                    if($check_stopage == 0) { // If stopage is not inserted in current session
                        $stopage = Stopage::create($data); //Insert stopage data
                        // Insert Section data 
                    }
                }
                return true;
            }
        } catch(\Exception $err){
            Log::error('message error in importPreviousSessionStopages on StopageRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


}