<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Models\Provinces;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WardsController extends Controller
{
    function getWardsByDistrict(Request $request,$id) {
        $allWards = Wards::where("district_id", '=', $id)->get();
        return response()->json(['data'=>$allWards]);
    }    
}
