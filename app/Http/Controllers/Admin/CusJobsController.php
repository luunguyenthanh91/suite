<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\BankCollaborators;
use App\Models\CusJobs;
use App\Models\CusJobsJoin;
use App\Models\District;
use App\Models\Language;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class CusJobsController extends Controller
{
    private $limit = 20;
    
    function viewCustomer(Request $request,$id) {
        $data = CusJobs::find($request->id);
        return view('admin.customer-view', compact(['data' , 'id']));
    }

    function list(Request $request) {
        $district = District::all();
        return view(
            'admin.customer',
            compact(['district'])
        );

    }


    function getList(Request $request) {
        $page = $request->page - 1;
        
        $data = CusJobs::orderBy("id" , "DESC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
            // $data = $data->whereHas('product_catalog', function ($q) use ($id) {
            //     $q->where('product_catalog_id', $id)
            //         ->orWhere('parent_id', $id);
            // })->paginate(12);

        }
        if(@$request->address != '' ){
            $data = $data->where('address', 'like', '%'.$request->address.'%');
        }
        if(@$request->phone != '' ){
            $data = $data->where('phone', 'like', '%'.$request->phone.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('status', $request->status);
        }
        if(@$request->email != '' ){
            $data = $data->where('email', 'like', '%'.$request->email.'%');
        }
        
        $count = $data->count();
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        foreach ($data as &$value) {
            if (strlen($value->address) > 20)
            {
                $value->address_cut = mb_convert_encoding(substr($value->address, 0, 20) . '...', 'UTF-8', 'UTF-8');
            } 
            if (strlen($value->email) > 20)
            {
                $value->email_cut = mb_convert_encoding(substr($value->email, 0, 20) . '...', 'UTF-8', 'UTF-8');
            } else {
                $value->email_cut = $value->email;
            }
        }
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
        
    }
   
    function getListAll(Request $request) {
        $data = CusJobs::orderBy("id" , "DESC");
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
                $data = CusJobs::find($request->id);
                if ($data) {
                    $data->name = $request->name;
                    $data->phone = $request->phone;
                    $data->email = $request->email;
                    $data->website = $request->website;
                    $data->lever_nihongo = $request->lever_nihongo;
                    $data->furigana = trim($request->furigana);
                    $data->male = $request->male;
                    if($request->password){
                        $data->password = Hash::make($request->password);
                    }
                    $data->address = $request->address;
                    // $data->image_ctv = $request->image_ctv;
                    $data->status = $request->status ? $request->status : $data->status;
                    $data->updated_at = date('Y-m-d H:i:s');
                    $data->ten_bank = $request->ten_bank;
                    $data->stk = $request->stk;
                    $data->chinhanh = $request->chinhanh;
                    $data->ten_chutaikhoan = $request->ten_chutaikhoan;
                    $data->loai_taikhoan = $request->loai_taikhoan;
                    $data->ms_chinhanh = $request->ms_chinhanh;
                    $data->ms_nganhang = $request->ms_nganhang;
                    $data->note = $request->note;
                    $data->jplt = $request->jplt;
                    $data->created_at = $request->created_at;
                    $data->date_update = $request->date_update;
                    $data->save();
                }
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
       
        $data = CusJobs::find($request->id);
        
       
        return view(
            'admin.cusjobs.edit',
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
                $data = new CusJobs();
                $data->name = $request->name;
                $data->phone = $request->phone;
                $data->email = $request->email;
                if($request->password){
                    $data->password = Hash::make($request->password);
                }
                $data->address = $request->address;
                $data->status = $request->status;
                $data->website = $request->website;
                // $data->image_ctv = $request->image_ctv;
                $data->furigana = trim($request->furigana);
                $data->male = $request->male;
                $data->ten_bank = $request->ten_bank;
                $data->stk = $request->stk;
                $data->chinhanh = $request->chinhanh;
                $data->ten_chutaikhoan = $request->ten_chutaikhoan;
                $data->loai_taikhoan = $request->loai_taikhoan;
                $data->ms_chinhanh = $request->ms_chinhanh;
                $data->ms_nganhang = $request->ms_nganhang;
                $data->lever_nihongo = $request->lever_nihongo;
                $data->jplt = $request->jplt;
                $data->note = $request->note;
                $data->created_at = date('Y-m-d');
                $data->save();
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/cusjobs/edit/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                
                echo "<pre>";
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
            
        }
        return view(
            'admin.cusjobs.add',
            compact(['message'])
        );

    }

    function delete(Request $request,$id) {
        CusJobsJoin::where('cus_jobs_id' , $id)->delete();
        $data = CusJobs::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Cộng Tác Viên Thành Công."]);
    }

    function getDetailId(Request $request,$id) {
        $data = CusJobs::where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }

}
