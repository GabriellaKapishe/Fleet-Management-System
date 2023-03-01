<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FleetServiceStation;

class FleetServiceStationController extends Controller
{
    
 public function read(){

    try{
        $types = FleetServiceStation::get();
        return response()->json([
            "code"=>200,
            "message"=>'success',
            "data"=>$types

          ],200);
    }
    catch(\Exception  $exception)
    {
        return response()->json([
            "code"=>422,
            "message"=>'failed',

        ],422);
    }
}

public function create(Request $request)
{
    $validator=$this->createValidation($request->all());
    if($validator->fails())
    {
        return response()->json([
            "code"=>400,
            "message"=>'Bad Request',
            "data"=>$validator->errors()->toArray()
        ],400);
    }
    try{

        $fleetServiceStation=new FleetServiceStation();
        $fleetServiceStation->companyId=$request->companyId;
        $fleetServiceStation->serviceStationId=$request->serviceStationId;
        $fleetServiceStation->save();
        return response()->json([
          "code"=>200,
          "message"=>"success",
          "data"=>$fleetServiceStation
        ]);
    }
    catch(\Exception  $exception)
    {
        return response()->json([
            "code"=>422,
            "message"=>'failed',
        ],422);
    }

}

protected function createValidation(Array $data)
{
    return Validator::make($data,[
      'companyId'=>'required',
      'serviceStationId'=>'required|unique:fleet_service_station',
    ]);
}

public function update(Request $request,$id)
{
    try {

    $fleetServiceStation=FleetServiceStation::find($id);
    $fleetServiceStation->update($request->all());
    //return $fleetServiceStation;
    return response()->json([
        "code"=>200,
        "message"=>"success",
        "data"=>$fleetServiceStation 
      ]);
    }
    catch(\Exception  $exception)
        {
            return response()->json([
                "code"=>422,
                "message"=>'failed',
            ],422);
        }

}

public function destroy($id)
    {
        try{
        $types = FleetServiceStation::destroy($id);
        return response()->json([
          "code"=>200,
          "message"=>"success", 

        ]);
        }
        catch(\Exception  $exception)
        {
            return response()->json([
                "code"=>422,
                "message"=>'failed',
            ],422);
        }
    }



}
