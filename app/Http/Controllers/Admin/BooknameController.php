<?php

namespace App\Http\Controllers\Admin;
use App\Models\Provinces;
use App\Models\Admin;
use App\Models\Roles;
use App\Models\RolePermissions;
use App\Models\GroupPermissions;
use App\Models\Permissions;
use App\Models\UserPermissions;
use App\Models\UserRoles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\HistoryLog;
use App\Jobs\SendEmailCheckOut;
use App\Jobs\SendEmailCheckIn;
use App\Models\BoPhan;
use App\Models\Bookname;
use App\Models\Academic;
use Illuminate\Support\Facades\Auth;
use PDF;

class BooknameController extends Controller
{
    private $limit = 20;
    private $defSortName = "id";
    private $defSortType = "DESC";

    

    public function booknamepdf(Request $request, $id) {
        $data = Bookname::find($id);
        $this->getBookname($data);
        
        $pdf = PDF::loadView('admin.bookname-pdf', compact('data'));
        return $pdf->download(trans('label.namebook')."_".$data->employee_code."(".$data->employee_name.")".'.pdf');
    }

    function addBookname(Request $request) {
        $employee = Admin::where('code' ,$request->code)->first();

        try {
            $data = new Bookname();

            $data->status = 0;
            $data->user_id = $employee->id;
            $data->note = $request->note;
            $data->created_on = date('Y-m-d');
            $data->created_by = Auth::guard('admin')->user()->id;

            $data->save();
            
            return redirect('/admin/bookname-view/'.$data->id);
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die;
        }
    }

    function viewBookname(Request $request,$id) {
        $data = Bookname::find($id);
        $this->getBookname($data);

        return view('admin.bookname-view', compact(['data' , 'id']));
    }

    function deleteBookname(Request $request,$id) {
        $data = Bookname::find($id);
        $data->delete();
        return response()->json([]);
    }

    function updateBookname(Request $request,$id) {
        if ($request->isMethod('post')) {
            $data = Bookname::find($id);
            if ($data) {
                $data->inside_history = $request->inside_history;
                $data->retire_date = $request->retire_date;
                $data->retire_note = $request->retire_note;
                $data->note = $request->note;
                $data->save();
            }
            return redirect('/admin/bookname-view/'.$data->id);
        }

        $data = Bookname::find($id);
        $this->getBookname($data);
        return view('admin.bookname-update', compact(['data' , 'id']));
    }

    function getBookname($data) {
        $employee = Admin::where('id' ,$data->user_id)->first();
        $data->employee_id = $employee->id;
        $data->employee_name = $employee->name;
        $data->employee_code = $employee->code;
        $data->employee_nick_name = $employee->nick_name;
        $data->employee_birthday = $employee->birthday;
        $data->male = $employee->male;
        $data->employ_date = $employee->employ_date;
        $data->address = $employee->address;
        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $data->employee_depname = $bophan->name;
        $data->age = date_diff(date_create($data->birthday), date_create('now'))->y;

        $data->classStyle = "";
        if ($data->status == 0) {
            $data->classStyle = "status2";
        } else if ($data->status == 1) {
            $data->classStyle = "status3";
        } else if ($data->status == 2) {
            $data->classStyle = "status4";
        }

        $created_user = Admin::where('id' ,$data->created_by)->first();
        if ($created_user) {
            $data->created_by_name = $created_user->name;
            $data->created_by_sign = $created_user->sign_name;
        }

        $checked_user = Admin::where('id' ,$data->checked_by)->first();
        if ($checked_user) {
            $data->checked_by_name = $checked_user->name;
            $data->checked_by_sign = $checked_user->sign_name;
        }

        $approved_user = Admin::where('id' ,$data->approved_by)->first();
        if ($approved_user) {
            $data->approved_by_name = $approved_user->name;
            $data->approved_by_sign = $approved_user->sign_name;
        }
    }

     

    function booknamecheck(Request $request,$id) {
        try {
            $data = Bookname::find($request->id);
            if ($data) {
                $data->checked_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->checked_on = date('Y-m-d');
                $data->status = 2;
                $data->save();
            }

            $message = [
                "message" => "Đã thay đổi dữ liệu thành công.",
                "status" => 1
            ];

            return response()->json(['message'=>"Xóa Công Việc Thành Công."]);
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());die;
            $message = [
                "message" => "Có lỗi xảy ra khi thay đổi vào dữ liệu.",
                "status" => 2
            ];
        }
    }

    function booknameapprove(Request $request,$id) {
        try {
            $data = Bookname::find($request->id);
            if ($data) {
                $data->approved_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->approved_on = date('Y-m-d');
                $data->status = 3;
                $data->save();
            }

            $message = [
                "message" => "Đã thay đổi dữ liệu thành công.",
                "status" => 1
            ];

            return response()->json(['message'=>"Xóa Công Việc Thành Công."]);
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());die;
            $message = [
                "message" => "Có lỗi xảy ra khi thay đổi vào dữ liệu.",
                "status" => 2
            ];
        }
    }

    function listBookname(Request $request) {
        return view('admin.bookname', compact([]));
    }

    function getListBookname(Request $request) {
        $page = $request->page - 1;
        
        $data = Bookname::orderBy($this->defSortName, $this->defSortType);
        if(@$request->item_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->item_id.'%' );
        }
        if(@$request->created_on != '' ){
            $data = $data->where('created_on', $request->created_on);
        }
        if(@$request->created_on_from != '' ){
            $data = $data->where('created_on', '>=' , $request->created_on_from );
        }
        if(@$request->created_on_to != '' ){
            $data = $data->where('created_on', '<=' , $request->created_on_to );
        }
        if(@$request->checked_on != '' ){
            $data = $data->where('checked_on', $request->created_on);
        }
        if(@$request->checked_on_from != '' ){
            $data = $data->where('checked_on', '>=' , $request->checked_on_from );
        }
        if(@$request->checked_on_to != '' ){
            $data = $data->where('created_on', '<=' , $request->checked_on_to );
        }
        if(@$request->approved_on != '' ){
            $data = $data->where('approved_on', $request->approved_on);
        }
        if(@$request->approved_on_from != '' ){
            $data = $data->where('approved_on', '>=' , $request->approved_on_from );
        }
        if(@$request->approved_on_to != '' ){
            $data = $data->where('approved_on', '<=' , $request->approved_on_to );
        }

        $count = $data->count();
        $showCount = $request->showcount;
        if ($showCount == 0) {
            $showCount = $count;
        }
        if ($showCount == 0) {
            $showCount = 1;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);

        foreach ($data as &$item) {
            $this->getBookname($item);
        }

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }
}
