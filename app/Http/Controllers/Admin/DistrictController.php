<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Models\Provinces;
use App\Models\Districts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
{
    
    function getDistrictByProvinces(Request $request,$id) {
       $allDistricts = Districts::where("province_id", '=', $id)->get();
       return response()->json(['data'=>$allDistricts]);
    }

}
