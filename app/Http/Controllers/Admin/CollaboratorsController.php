<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\BankCollaborators;
use App\Models\Collaborators;
use App\Models\District;
use App\Models\Language;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
class CollaboratorsController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        
        // print_r($dashboard);die;
        return view(
            'admin.collaborators.list',
            compact([])
        );

    }

    function day(Request $request) {
        $district = District::all();

        $dashboard = DB::table('collaborators')
        ->select('created_at', DB::raw('count(*) as total'))
        ->groupBy('created_at')
        ->limit(7)
        ->orderBy('created_at', 'DESC')
        ->get();
        $countCTV = Collaborators::count();

        $allDistricts = District::all();

        foreach ($allDistricts as &$item) {
            $item->person = Collaborators::where('address','LIKE','%' . trim($item->name) . '%')->count();
        }
        unset($item);
        // print_r($dashboard);die;
        return view(
            'admin.collaborators.day',
            compact(['district' , 'dashboard', 'countCTV' , 'allDistricts'])
        );

    }

    function district(Request $request) {
        $district = District::all();

        $dashboard = DB::table('collaborators')
        ->select('created_at', DB::raw('count(*) as total'))
        ->groupBy('created_at')
        ->limit(7)
        ->orderBy('created_at', 'DESC')
        ->get();
        $countCTV = Collaborators::count();

        $allDistricts = District::all();

        foreach ($allDistricts as &$item) {
            $item->person = Collaborators::where('address','LIKE','%' . trim($item->name) . '%')->count();
        }
        unset($item);
        // print_r($dashboard);die;
        return view(
            'admin.collaborators.district',
            compact(['district' , 'dashboard', 'countCTV' , 'allDistricts'])
        );

    }


    function getList(Request $request) {
        $page = $request->page - 1;
        if(@$request->location != '') {
            $longKey = explode(',', $request->location);

            $conditionString = [];
            if(@$request->name != '' ){
                $conditionString[] = 'collaborators.name like "' . '%'.$request->name.'%" ';
            }
            if(@$request->phone != '' ){
                $conditionString[] = 'collaborators.phone like "' . '%'.$request->phone.'%" ';
            }
            if(@$request->male != '' ){
                $conditionString[] = 'collaborators.male like "' . '%'.$request->male.'%" ';
            }
            if(@$request->lever_nihongo != '' ){
                $conditionString[] = 'collaborators.lever_nihongo = ' .$request->lever_nihongo;
            }
            if(@$request->jplt != '' ){
                $conditionString[] = 'collaborators.jplt = ' .$request->jplt;
            }
            if(@$request->status != '' ){
                $conditionString[] = 'collaborators.status = ' .$request->status;
            }
            $strCondition = '';
            if(count($conditionString) > 0 ){
                $strCondition = implode(' And ' , $conditionString);
            }

            if ($strCondition != '') {
                $data = DB::select("SELECT * , SQRT( POW(69.1 * (`latitude` - $longKey[1]), 2) + POW(69.1 * ($longKey[0] - `longitude`) * COS(latitude / 57.3), 2)) AS distance FROM `collaborators` WHERE $strCondition ORDER BY distance limit 10;");
            } else {
                $data = DB::select("SELECT * , SQRT( POW(69.1 * (`latitude` - $longKey[1]), 2) + POW(69.1 * ($longKey[0] - `longitude`) * COS(latitude / 57.3), 2)) AS distance FROM `collaborators` ORDER BY distance limit 10;");
            }
            
            $count = 10;
            $count = $count === 0 ? 1 : $count;
            $pageTotal = ceil($count/10);
            return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
        } else {
            $data = Collaborators::orderBy("id" , "DESC")->with('bank');
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
            if(@$request->male != '' ){
                $data = $data->where('male', 'like', '%'.$request->male.'%');
            }
            if(@$request->lever_nihongo != '' ){
                $data = $data->where('lever_nihongo', $request->lever_nihongo);
            }
            if(@$request->jplt != '' ){
                $data = $data->where('jplt', $request->jplt);
            }
            if(@$request->status != '' ){
                $data = $data->where('status', $request->status);
            }
            if(@$request->district != '' ){
                $data = $data->where('list_di_dich', 'like', '%,'. $request->district.',%');
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
        
    }
    function getListByAddress(Request $request) {

        $data = DB::select("SELECT * , SQRT( POW(69.1 * (`latitude` - $request->lat), 2) + POW(69.1 * ($request->long - `longitude`) * COS(latitude / 57.3), 2)) AS distance FROM `collaborators` ORDER BY distance limit 10;");
        $count = 10;
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
    function getListByAddressAndCondition(Request $request) {
        $condition = '';
        if(@$request->name != '' ){
            if($condition == ''){
                $condition .= " WHERE `name` LIKE '%".$request->name."%' ";
            } else {
                $condition .= " AND `name` LIKE '%".$request->name."%' ";
            }
        }
        
        if(@$request->male != '' ){
            if($condition == ''){
                $condition .= " WHERE `male` LIKE '%".$request->male."%' ";
            } else {
                $condition .= " AND `male` LIKE '%".$request->male."%' ";
            }
        }
        if(@$request->jplt != '' ){
            if($condition == ''){
                $condition .= " WHERE `jplt` = ".$request->jplt." ";
            } else {
                $condition .= " AND `jplt` = ".$request->jplt." ";
            }
        }

        $data = DB::select("SELECT * , SQRT( POW(69.1 * (`latitude` - $request->lat), 2) + POW(69.1 * ($request->long - `longitude`) * COS(latitude / 57.3), 2)) AS distance FROM `collaborators` ". $condition ." ORDER BY distance limit 10;");
        $count = 10;
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
            $value->bank = BankCollaborators::where('collaborators_id' , $value->id)->get();
        }
        
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
                $data = Collaborators::find($request->id);
                if ($data) {
                    $data->name = trim($request->name);
                    $data->furigana = trim($request->furigana);
                    $data->male = $request->male;
                    // $data->zipcode = trim( str_replace("-","",$request->zipcode) ) ;
                    $data->address = trim($request->address);
                    // $data->ga_gannhat = trim($request->ga_gannhat);
                    // $data->list_di_dich = $request->list_di_dich;
                    $data->phone = trim( str_replace("-","",$request->phone) ) ;
                    $data->email = trim($request->email);
                    // $data->quoctich = $request->quoctich;
                    // $data->banglai = $request->banglai;
                    $data->lever_nihongo = $request->lever_nihongo;
                    // $data->line_barcode = $request->line_barcode ? $request->line_barcode : $data->line_barcode;
                    // $data->image_ctv = $request->image_ctv ? $request->image_ctv : $data->image_ctv;
                    // $data->file1 = $request->file1 ? $request->file1 : $data->file1;
                    // $data->file2 = $request->file2 ? $request->file2 : $data->file2;
                    $data->status = $request->status ? $request->status : $data->status;
                    // $data->trinhdo_tiengnhat = $request->trinhdo_tiengnhat;
                    if($request->ngon_ngu){
                        $flagNgonNgu = ',' . implode(',' , $request->ngon_ngu) . ',';
                        $data->ngon_ngu = $flagNgonNgu;
                    } else {
                        $data->ngon_ngu = '';
                    }
                    if($request->list_di_dich){
                        $flagDiDich = ',' . implode(',' , $request->list_di_dich) . ',';
                        $data->list_di_dich = $flagDiDich;
                    } else {
                        $data->list_di_dich = '';
                    }
                    if($request->password){
                        $data->password = Hash::make($request->password);
                    }
                    // $data->ngon_ngu = $request->ngon_ngu;
                    $data->jplt = $request->jplt;
                    // $data->songonhat_year = $request->songonhat_year;
                    $data->note = $request->note;
                    $data->longitude = $request->longitude;
                    $data->latitude = $request->latitude;
                    $data->updated_at = date('Y-m-d H:i:s');
                    
                    $data->created_at = $request->created_at;
                    $data->date_update = $request->date_update;
                    $data->save();
                }
                

                if ($request->banklist && count($request->banklist) > 0 ) {
                    foreach ($request->banklist as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new BankCollaborators();
                                $dataBank->collaborators_id = $data->id;
                                $dataBank->ten_bank = $item['ten_bank'];
                                $dataBank->stk = $item['stk'];
                                $dataBank->chinhanh = $item['chinhanh'];
                                $dataBank->ten_chutaikhoan = $item['ten_chutaikhoan'];
                                $dataBank->loai_taikhoan = $item['loai_taikhoan'];
                                $dataBank->ms_nganhang = $item['ms_nganhang'];
                                $dataBank->ms_chinhanh = $item['ms_chinhanh'];
                                $dataBank->save();
                            }
                            
                        } else {
                            $dataBank = BankCollaborators::find($item['id']);

                            
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                } else {
                                    $dataBank->ten_bank = $item['ten_bank'];
                                    $dataBank->stk = $item['stk'];
                                    $dataBank->chinhanh = $item['chinhanh'];
                                    $dataBank->ten_chutaikhoan = $item['ten_chutaikhoan'];
                                    $dataBank->loai_taikhoan = $item['loai_taikhoan'];
                                    $dataBank->ms_nganhang = $item['ms_nganhang'];
                                    $dataBank->ms_chinhanh = $item['ms_chinhanh'];
                                    $dataBank->save();
                                }
                            }
                        }
                        
                    }
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
        $district = District::all();
        $language = Language::all();
        $data = Collaborators::find($request->id);
        $data->ngon_ngu = trim($data->ngon_ngu,",");
        if($data->ngon_ngu){
            $flagNgonNgu = explode(',' , $data->ngon_ngu);
            $data->ngon_ngu = $flagNgonNgu;
        } else {
            $data->ngon_ngu = [];
        }
        
        $data->list_di_dich = trim($data->list_di_dich,",");
        if( $data->list_di_dich ) {
            $flagDiDich = explode(',' , $data->list_di_dich);
            $data->list_di_dich = $flagDiDich;
        } else {
            $data->list_di_dich = [];
        }

        $dataBank = BankCollaborators::where('collaborators_id' , $request->id)->get();
        $id = $request->id;
        return view(
            'admin.collaborators.edit',
            compact(['message' , 'data' , 'dataBank' , 'district' , 'language' , 'id'])
        );
    }

    function add(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = new Collaborators();
                $data->name = trim($request->name);
                $data->furigana = trim($request->furigana);
                $data->male = $request->male;
                // $data->quoctich = $request->quoctich;
                // $data->banglai = $request->banglai;
                // $data->zipcode = trim( str_replace("-","",$request->zipcode) ) ;
                $data->address = trim($request->address);
                // $data->ga_gannhat = trim($request->ga_gannhat);
                // $data->list_di_dich = $request->list_di_dich;
                $data->phone = trim( str_replace("-","",$request->phone) );
                $data->email = trim($request->email);
                $data->lever_nihongo = $request->lever_nihongo;
                // $data->line_barcode = $request->line_barcode;
                // $data->image_ctv = $request->image_ctv;
                // $data->file1 = $request->file1;
                // $data->file2 = $request->file2;
                $data->status = $request->status;
                if($request->password){
                    $data->password = Hash::make($request->password);
                }
                if($request->ngon_ngu){
                    $flagNgonNgu = ',' . implode(',' , $request->ngon_ngu) . ',';
                    $data->ngon_ngu = $flagNgonNgu;
                }

                if($request->list_di_dich){
                    $flagDiDich = ',' . implode(',' , $request->list_di_dich) . ',';
                    $data->list_di_dich = $flagDiDich;
                }
                // $data->trinhdo_tiengnhat = $request->trinhdo_tiengnhat;
                $data->jplt = $request->jplt;
                // $data->songonhat_year = $request->songonhat_year;
                $data->note = $request->note;
                $data->longitude = $request->longitude;
                $data->latitude = $request->latitude;
                $data->created_at = date('Y-m-d');
                $data->save();

                if ($request->banklist && count($request->banklist)  > 0  ) {
                    foreach ($request->banklist as $item) {
                        if ($item['id'] === 'new') {
                            $dataBank = new BankCollaborators();
                            $dataBank->collaborators_id = $data->id;
                            $dataBank->ten_bank = $item['ten_bank'];
                            $dataBank->stk = $item['stk'];
                            $dataBank->chinhanh = $item['chinhanh'];
                            $dataBank->ten_chutaikhoan = $item['ten_chutaikhoan'];
                            $dataBank->loai_taikhoan = $item['loai_taikhoan'];
                            $dataBank->ms_nganhang = $item['ms_nganhang'];
                            $dataBank->ms_chinhanh = $item['ms_chinhanh'];
                            $dataBank->save();
                        } else {
                            $dataBank = BankCollaborators::find($item['id']);
                            if ($dataBank) {
                                $dataBank->ten_bank = $item['ten_bank'];
                                $dataBank->stk = $item['stk'];
                                $dataBank->chinhanh = $item['chinhanh'];
                                $dataBank->ten_chutaikhoan = $item['ten_chutaikhoan'];
                                $dataBank->loai_taikhoan = $item['loai_taikhoan'];
                                $dataBank->ms_nganhang = $item['ms_nganhang'];
                                $dataBank->ms_chinhanh = $item['ms_chinhanh'];
                                $dataBank->save();
                            }
                            
                        }
                        
                    }
                }
                $message = [
                    "message" => "Đã thêm dữ liệu thành công.",
                    "status" => 1
                ];
                return redirect('/admin/collaborators/edit/'.$data->id)->with('message','Đã thêm dữ liệu thành công.');
            } catch (Exception $e) {
                
                echo "<pre>";
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thêm vào dữ liệu.",
                    "status" => 2
                ];
            }
            
        }
        $district = District::all();
        $language = Language::all();
        return view(
            'admin.collaborators.add',
            compact(['message' , 'district' , 'language'])
        );

    }

    function delete(Request $request,$id) {
        BankCollaborators::where('collaborators_id' , $id)->delete();
        $data = Collaborators::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Cộng Tác Viên Thành Công."]);
    }

    function getDetailId(Request $request,$id) {
        $data = Collaborators::with('bank')->where('id',$id)->first();
        return response()->json(['data'=> $data]);
    }

}
