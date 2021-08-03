<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\BoPhan;
use App\Models\Chitien;
use App\Models\ParentChitien;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use NumberFormatter;
use PDF;

class BoPhanController extends Controller
{
    private $limit = 20;
    function getList(Request $request) {
        $page = $request->page - 1;
        $data = BoPhan::orderBy("id" , "DESC");
        $count = $data->count();
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function view(Request $request) {
        return view(
            'admin.bophan.list',
            compact([])
        );
    }

    function add(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                // print_r($request->date);die;
                $data = new BoPhan();
                $data->name = $request->name;
                $data->save();
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/bophan/edit/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }

        return view(
            'admin.bophan.add',
            compact(['message'])
        );

    }
    function edit(Request $request , $id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = BoPhan::find($id);
                $data->name = $request->name;
                $data->save();
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/bophan/edit/'.$data->id)->with('message','Đã sửa dữ liệu thành công.');
            } catch (Exception $e) {
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
        }
        $data = BoPhan::find($id);
        return view(
            'admin.bophan.edit',
            compact(['message','data' , 'id'])
        );

    }
    function delete(Request $request,$id) {
        $data = bophan::find($id);
        $data->delete();
        return response()->json(['message'=>'Đã xoá dữ liệu thành công.']);
    }

    
}
