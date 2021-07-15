<?php

namespace App\Http\Controllers\Admin;

use App\Models\Suppliers;
use App\Models\ProductTypes;
use App\Models\SupplierProductTypes;
use App\Models\Provinces;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        $menu_active = 'suppliers';
        return view(
            'admin.suppliers.list',
            compact([
                'menu_active'
            ])
        );

    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $data = Suppliers::orderBy("id" , "DESC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
            $data = $data->orWhere('code', 'like', '%'.$request->name.'%');
        }
        $count = $data->count();
        $pageTotal = ceil($count/$this->limit);
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        foreach($data as &$item){
            $item->debt_money = Helper::formatCurency($item->debt_money);
        }
        unset($item);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = Permissions::orderBy("id" , "DESC");
        $data = $data->all();
        return response()->json(['data'=>$data]);
    }

    function edit(Request $request,$id) {
        $message = [
            "message" => "",
            "status" => 0
        ];

        if ($request->isMethod('post')) {

            $new = Suppliers::find($id);
            $new->name = $request->name;
            $new->nick_name = $request->nick_name;
            $new->phone = $request->phone;
            $new->province_id = $request->province_id;
            $new->district_id = $request->district_id;
            $new->ward_id = $request->ward_id;
            $new->address = $request->address;
            $new->is_debt = $request->is_debt;
            $new->import_money = $request->import_money;
            $new->paid_money = $request->paid_money;
            $new->debt_money = $request->debt_money;
            $new->note = $request->note;
            $new->is_active = $request->is_active;
            $new->updated_at = date('Y-m-d H:i:s');
            $new->save();

            if(@$request->type){
                SupplierProductTypes::where("supplier_id",$id)->delete();
                foreach($request->type as $key=>$value){
                    $newSP = new SupplierProductTypes();
                    $newSP->supplier_id = $new->id;
                    $newSP->product_type_id =$key;
                    $newSP->save();
                }
            }
            $message = [
                "message" => "Thay Đổi Nhà Phân Phối Thành Công",
                "status" => 1
            ];
        }

        $listProductTypes = ProductTypes::all();
        $listSP = SupplierProductTypes::where("supplier_id",$id)->get();
        $arrSp = [];
        foreach($listSP as $item){
            $arrSp[] = $item->product_type_id;
        }

        foreach($listProductTypes as &$item){
            if (in_array($item->id, $arrSp)) {
                $item->checked = 1;
            } else {
                $item->checked = 0;
            }
        }
        unset($item);

        $data = Suppliers::find($id);
        $listProvinces = Provinces::all();
        $menu_active = 'suppliers';
        return view(
            'admin.suppliers.edit',
            compact([
                'menu_active',
                'listProvinces',
                'listProductTypes',
                'message',
                'data'
            ])
        );

    }
    function convertCode($number){
        if($number < 10) {
            return '000'.$number;
        } else if($number < 100 && $number >= 10) {
            return '00'.$number;
        } else if($number < 1000 && $number >= 100) {
            return '0'.$number;
        } else {
            return $number;
        }
    }
    function addData(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {

            $new = new Suppliers();
            $new->name = $request->name;
            $new->nick_name = $request->nick_name;
            $new->code = "NCC";
            $new->phone = $request->phone;
            $new->province_id = $request->province_id;
            $new->district_id = $request->district_id;
            $new->ward_id = $request->ward_id;
            $new->address = $request->address;
            $new->is_debt = $request->is_debt;
            $new->import_money = $request->import_money;
            $new->paid_money = $request->paid_money;
            $new->debt_money = $request->debt_money;
            $new->note = $request->note;
            $new->is_active = $request->is_active;
            $new->created_at = date('Y-m-d H:i:s');
            $new->updated_at = date('Y-m-d H:i:s');
            $new->save();
            $new->code = $new->code.$this->convertCode($new->id);
            $new->save();

            if(@$request->type){
                foreach($request->type as $key=>$value){
                    $newSP = new SupplierProductTypes();
                    $newSP->supplier_id = $new->id;
                    $newSP->product_type_id =$key;
                    $newSP->save();
                }
            }
            return redirect('/admin/suppliers/edit/'.$new->id)->with('message-add','Thêm Nhà Phân Phối Thành Công!');
        }
        $listProvinces = Provinces::all();
        $listProductTypes = ProductTypes::all();
        $menu_active = 'suppliers';
        return view(
            'admin.suppliers.add',
            compact([
                'menu_active',
                'listProvinces',
                'listProductTypes',
                'message'
            ])
        );

    }

    function delete(Request $request,$id) {
        $data = Suppliers::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Phân Quyền Thành Công."]);
    }
    function active(Request $request,$id) {
        $users = Suppliers::find($id);
        $users->is_active = 1 ;
        $users->save();
        return response()->json(['message'=>"Active Thành Công."]);
    }

    function deactive(Request $request,$id) {
        $users = Suppliers::find($id);
        $users->is_active = 0 ;
        $users->save();
        return response()->json(['message'=>"Deactive Thành Công."]);
    }

}
