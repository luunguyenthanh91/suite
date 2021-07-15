<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\BankCollaborators;
use App\Models\Collaborators;
use App\Models\Baihoc;
use App\Models\Chitietbaihoc;
use App\Models\District;
use App\Models\Language;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class JlptController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        
        // print_r($dashboard);die;
        return view(
            'admin.jlpt.list',
            compact([])
        );

    }

    function getList(Request $request) {
        $page = $request->page - 1;
        
        $data = Baihoc::orderBy("id" , "DESC");
        
        if(@$request->jplt != '' ){
            $data = $data->where('type_n', $request->jplt);
        }
       
        $count = $data->count();
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
        
    }
    
    function getListAll(Request $request) {
        $data = Collaborators::orderBy("id" , "DESC");
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
                $data = Baihoc::find($id);
                $data->number = date("Y/m/d H:i:s") . '';
                $data->number = str_replace('/', '' , str_replace(' ', '' , str_replace(':', '' , $data->number) ) );
                $data->type_n = $request->type_n;
                $data->type_unit_n = $request->type_unit_n;
                $data->unit = $request->unit;
                $data->name = $request->name;
                $data->debai = $request->debai;
                $data->type_bai_hoc = $request->type_bai_hoc;
                $data->save();

                if ($request->banklist && count($request->banklist)  > 0  ) {
                    foreach ($request->banklist as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] != 'delete' && $item['cauhoi'] != '') {
                                $dataBank = new Chitietbaihoc();
                                $dataBank->cauhoi = $item['cauhoi'];
                                $dataBank->traloi_1 = $item['traloi_1'];
                                $dataBank->traloi_2 = $item['traloi_2'];
                                $dataBank->traloi_3 = $item['traloi_3'];
                                $dataBank->traloi_4 = $item['traloi_4'];
                                $dataBank->dap_an = $item['dap_an'];
                                $dataBank->chu_thich = $item['chu_thich'];
                                $dataBank->baihoc_id = $data->id;
                                $dataBank->save();
                            }
                            
                        } else {
                            if ($item['type'] != 'delete') {
                                $dataBank = Chitietbaihoc::find($item['id']);
                                if ($dataBank) {
                                    $dataBank->cauhoi = $item['cauhoi'];
                                    $dataBank->traloi_1 = $item['traloi_1'];
                                    $dataBank->traloi_2 = $item['traloi_2'];
                                    $dataBank->traloi_3 = $item['traloi_3'];
                                    $dataBank->traloi_4 = $item['traloi_4'];
                                    $dataBank->dap_an = $item['dap_an'];
                                    $dataBank->chu_thich = $item['chu_thich'];
                                    $dataBank->save();
                                }
                            } else {
                                $dataBank = Chitietbaihoc::find($item['id']);
                                $dataBank->delete();
                            }
                            
                        }
                        
                    }
                }
                $message = [
                    "message" => "Đã thay đổi dữ liệu thành công.",
                    "status" => 1
                ];
            } catch (Exception $e) {
                
                echo "<pre>";
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
            
        }
        $data = Baihoc::find($id);
        $dataBank = Chitietbaihoc::where('baihoc_id', $id)->get();
        $newArr  = [];
        $newArr = array_pad($newArr, 5, null);
        return view(
            'admin.jlpt.edit',
            compact(['message' , 'data' , 'dataBank' , 'id' , 'newArr'])
        );
    }

    function add(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = new Baihoc();
                $data->number = date("Y/m/d H:i:s") . '';
                $data->number = str_replace('/', '' , str_replace(' ', '' , str_replace(':', '' , $data->number) ) );
                $data->type_n = $request->type_n;
                $data->type_unit_n = $request->type_unit_n;
                $data->unit = $request->unit;
                $data->name = $request->name;
                // $data->debai = $request->debai;
                $data->type_bai_hoc = $request->type_bai_hoc;
                $data->save();

                if ($request->banklist && count($request->banklist)  > 0  ) {
                    foreach ($request->banklist as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] != 'delete') {
                                $dataBank = new Chitietbaihoc();
                                $dataBank->cauhoi = $item['cauhoi'];
                                $dataBank->traloi_1 = $item['traloi_1'];
                                $dataBank->traloi_2 = $item['traloi_2'];
                                $dataBank->traloi_3 = $item['traloi_3'];
                                $dataBank->traloi_4 = $item['traloi_4'];
                                $dataBank->dap_an = $item['dap_an'];
                                $dataBank->chu_thich = $item['chu_thich'];
                                $dataBank->baihoc_id = $data->id;
                                $dataBank->save();
                            }
                            
                        } else {
                            if ($item['type'] != 'delete') {
                                $dataBank = Chitietbaihoc::find($item['id']);
                                if ($dataBank) {
                                    $dataBank->cauhoi = $item['cauhoi'];
                                    $dataBank->traloi_1 = $item['traloi_1'];
                                    $dataBank->traloi_2 = $item['traloi_2'];
                                    $dataBank->traloi_3 = $item['traloi_3'];
                                    $dataBank->traloi_4 = $item['traloi_4'];
                                    $dataBank->dap_an = $item['dap_an'];
                                    $dataBank->chu_thich = $item['chu_thich'];
                                    $dataBank->save();
                                }
                            } else {
                                $dataBank = Chitietbaihoc::find($item['id']);
                                $dataBank->delete();
                            }
                            
                        }
                        
                    }
                }
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/jlpt/edit/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                
                echo "<pre>";
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
            
        }
        $newArr  = [];
        $newArr = array_pad($newArr, 5, null);
        return view(
            'admin.jlpt.add',
            compact(['message' , 'newArr'])
        );

    }

    function delete(Request $request,$id) {
        Chitietbaihoc::where('baihoc_id' , $id)->delete();
        $data = Baihoc::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Cộng Tác Viên Thành Công."]);
    }

    function getDetailId(Request $request,$id) {
        $data = Collaborators::with('bank')->where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }

}
