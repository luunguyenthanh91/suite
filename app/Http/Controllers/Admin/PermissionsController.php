<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Permissions;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'permission';
        $menu_parent_active = 'users-group';
        return view(
            'admin.permission.list',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );

    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $data = Permissions::orderBy("group_permission_id" , "DESC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->with('group')->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = Permissions::orderBy("id" , "DESC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        
        $data = Permissions::find($request->id);
        $data->name = $request->name;
        $data->group_permission_id = $request->group_permission_id;
        $data->guard_name = $request->guard_name;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new Permissions();
        $data->name = $request->name;
        $data->group_permission_id = $request->group_permission_id;
        $data->guard_name = $request->guard_name;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function delete(Request $request,$id) {
        $data = Permissions::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Phân Quyền Thành Công."]);
    }

}
