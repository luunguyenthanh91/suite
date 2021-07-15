<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\GroupPermissions;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GroupPermissionsController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'permission-group';
        $menu_parent_active = 'users-group';
        return view(
            'admin.permission.groups',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );

    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $data = GroupPermissions::orderBy("name" , "ASC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = GroupPermissions::orderBy("name" , "ASC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        
        $data = GroupPermissions::find($request->id);
        $data->name = $request->name;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new GroupPermissions();
        $data->name = $request->name;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function delete(Request $request,$id) {
        $data = GroupPermissions::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Nhóm Phân Quyền Thành Công."]);
    }

}
