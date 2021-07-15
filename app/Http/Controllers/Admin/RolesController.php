<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Roles;
use App\Models\RolePermissions;
use App\Models\GroupPermissions;
use App\Models\Permissions;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'roles';
        $menu_parent_active = 'users-group';
        return view(
            'admin.users.roles',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );

    }

    function checkListPermission(Request $request, $id) {
        
        $data = GroupPermissions::all();

        $thisGroup = RolePermissions::where('role_id', $id)->get();
        $arrGroup = [];
        foreach($thisGroup as $item){
            $arrGroup[] = $item->permission_id;
        }
        foreach($data as &$item){
            $item->childrent = Permissions::where('group_permission_id', $item->id)->get();
            $item->edit = 0;
            foreach($item->childrent as &$child) {
                if (in_array($child->id, $arrGroup)) {
                    $item->edit = 1;
                    $child->checked = 1;
                } else {
                    $child->checked = 0;
                }
            }
            unset($child);
        }
        unset($item);
        
        return response()->json(['data'=>$data]);
    }
    function addListPermission(Request $request, $id) {
        
        $data = $request->data;

        RolePermissions::where('role_id', $id)->delete();
        foreach($data as $item){
            if(@$item['childrent']) {
                foreach($item['childrent'] as $child) {
                    if (@$child['checked'] == 1) {
                        $newPer = new RolePermissions();
                        $newPer->role_id = $id;
                        $newPer->permission_id = $child['id'];
                        $newPer->save();
                    }
                }
            }
            
        }
        
        return response()->json(['message'=> "success update permission"]);
    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $data = Roles::orderBy("name" , "ASC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = Roles::orderBy("id" , "DESC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        
        $data = Roles::find($request->id);
        $data->name = $request->name;
        $data->guard_name = $request->guard_name;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new Roles();
        $data->name = $request->name;
        $data->guard_name = $request->guard_name;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function delete(Request $request,$id) {
        $data = Roles::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Nhóm Thành Viên Thành Công."]);
    }

}
