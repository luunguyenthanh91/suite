<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductTypes;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductTypesController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'types-product';
        $menu_parent_active = 'products-group';
        return view(
            'admin.products.type',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );

    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $data = ProductTypes::orderBy("type" , "ASC");
        if(@$request->name != '' ){
            $data = $data->where('type', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = ProductTypes::orderBy("type" , "ASC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        
        $data = ProductTypes::find($request->id);
        $data->type = $request->type;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function addData(Request $request) {
        
        $data = new ProductTypes();
        $data->type = $request->type;
        $data->created_at = date('Y-m-d H:i:s');
        $data->updated_at = date('Y-m-d H:i:s');
        $data->save();
        return response()->json(['data'=>$data]);
    }

    function delete(Request $request,$id) {
        $data = ProductTypes::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Phân Quyền Thành Công."]);
    }

}
