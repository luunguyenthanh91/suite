<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Phep;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PhepController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'phep';
        $menu_parent_active = 'phep-group';
        return view(
            'admin.phep.phep',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );

    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $data = Phep::orderBy("name" , "ASC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = Phep::orderBy("name" , "ASC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        
        $data = Phep::find($request->id);
        $data->name = $request->name;
        $data->image = $request->image;
        $data->description = $request->description;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new Phep();
        $data->name = $request->name;
        $data->image = $request->image;
        $data->description = $request->description;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function delete(Request $request,$id) {
        $data = Phep::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Nhóm Phân Quyền Thành Công."]);
    }

}
