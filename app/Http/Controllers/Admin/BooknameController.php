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
        $data = Admin::find($id);
        $this->getBookname($data);

        return view('admin.bookname-view', compact(['data' , 'id']));
    }

    function deleteBookname(Request $request,$id) {
        $data = Admin::find($id);
        $data->delete();
        return response()->json([]);
    }

    function updateBookname(Request $request,$id) {
        if ($request->isMethod('post')) {
            $data = Admin::find($id);
            if ($data) {
                $data->code = $request->code;
                $data->male = $request->male;
                $data->name = $request->name;
                $data->nick_name = $request->nick_name;
                $data->birthday = $request->birthday;
                $data->email = $request->email;
                $data->phone = $request->phone;
                $data->address = $request->address;
                $data->employ_date = $request->employ_date;
                $data->employ_type = $request->employ_type;
                $data->note = $request->note;
                $data->my_number = $request->my_number;
                $data->bank = $request->bank;
                $data->fuyo_number = $request->fuyo_number;
                $data->avatar = $request->avatar;
                $data->save();
            }
            return redirect('/admin/bookname-view/'.$data->id);
        }

        $data = Admin::find($id);
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
