<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\DoMac;
use App\Models\StartDo;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'do';
        $menu_parent_active = 'do-group';
        return view(
            'admin.do.do',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );

    }
    function checkListPermission(Request $request, $id) {
        
        $data = DoMac::all();

        $thisGroup = StartDo::where('do_id', $id)->get();
        
        $arrGroup = [];
        foreach($thisGroup as $item){
            $arrGroup[] = $item->start_do_id;
        }
        foreach($data as &$item){
            if (in_array($item->id, $arrGroup)) {
                $item->edit = 1;
                $item->checked = 1;
            } else {
                $item->checked = 0;
            }
        }
        unset($item);
        
        return response()->json(['data'=>$data]);
    }
    function addListPermission(Request $request, $id) {
        
        $data = $request->data;

        StartDo::where('do_id', $id)->delete();
        foreach($data as $item){
            if (@$item['checked'] == 1) {
                $newPer = new StartDo();
                $newPer->do_id = $id;
                $newPer->start_do_id = $item['id'];
                $newPer->save();
            }
            
        }
        
        return response()->json(['message'=> "success update permission"]);
    }


    function getList(Request $request) {
        $page = $request->page - 1;
        $data = DoMac::orderBy("name" , "ASC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = DoMac::orderBy("name" , "ASC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        
        $data = DoMac::find($request->id);
        $data->name = $request->name;
        $data->image = $request->image;
        $data->cost = $request->cost;
        $data->description = $request->description;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new DoMac();
        $data->name = $request->name;
        $data->image = $request->image;
        $data->cost = $request->cost;
        $data->description = $request->description;
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function delete(Request $request,$id) {
        $data = DoMac::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Nhóm Phân Quyền Thành Công."]);
    }

}
