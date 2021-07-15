<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\MyBank;
use App\Models\StartDo;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MyBankController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        return view(
            'admin.my-bank.list',
            compact([])
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
        $data = MyBank::orderBy("id" , "DESC");
        if(@$request->name != '' ){
            $data = $data->where('name_bank', 'like', '%'.$request->name.'%')->orWhere('ten_chusohuu', 'like', '%'.$request->name.'%');
            // $data = $data->whereHas('product_catalog', function ($q) use ($id) {
            //     $q->where('product_catalog_id', $id)
            //         ->orWhere('parent_id', $id);
            // })->paginate(12);

        }
        $count = $data->count();
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = MyBank::orderBy("id" , "DESC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = MyBank::find($request->id);
                $data->name_bank = $request->name_bank;
                $data->chi_nhanh = $request->chi_nhanh;
                $data->stk = $request->stk;
                $data->ten_chusohuu = $request->ten_chusohuu;
                $data->type = $request->type;
                $data->ms_nganhang = $request->ms_nganhang;
                $data->ms_chinhanh = $request->ms_chinhanh;
                $data->save();
                $message = [
                    "message" => "Đã thay đổi dữ liệu thành công.",
                    "status" => 1
                ];
            } catch (\Throwable $th) {
                $message = [
                    "message" => "Có lỗi xảy ra khi thay đổi vào dữ liệu.",
                    "status" => 2
                ];
            }
            
        }
        $data = MyBank::find($request->id);
        $id = $request->id;
        return view(
            'admin.my-bank.edit',
            compact(['message' , 'data' , 'id'])
        );
    }

    function add(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = new MyBank();
                $data->name_bank = $request->name_bank;
                $data->chi_nhanh = $request->chi_nhanh;
                $data->stk = $request->stk;
                $data->ten_chusohuu = $request->ten_chusohuu;
                $data->type = $request->type;
                $data->ms_nganhang = $request->ms_nganhang;
                $data->ms_chinhanh = $request->ms_chinhanh;
                $data->save();
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
            } catch (\Throwable $th) {
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
            
        }

        return view(
            'admin.my-bank.add',
            compact(['message'])
        );

    }

    function delete(Request $request,$id) {
        $data = MyBank::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Tài Khoản Ngân Hàng Thành Công."]);
    }

}
