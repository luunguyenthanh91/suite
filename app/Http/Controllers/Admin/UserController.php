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
use App\Models\Academic;
use App\Models\Bookname;

class UserController extends Controller
{
    private $limit = 20;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function addEmployee(Request $request) {
        $user = new Admin();
        $user->code = $request->code;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->app_version = 1;
        $user->user = 1;
        $user->updated_at = date("Y-m-d");
        $user->created_at = date("Y-m-d");
        $user->save();
        return redirect('/admin/employee-view/'.$user->id);
    }

    function checkOut(Request $request , $slug) {
        $users = Admin::where('code' ,$slug )->first();
        if ($users) {
            $data = HistoryLog::where('userId', $users->id)->where('type', 2)->where('date', date("Y-m-d"))->first();
            if (!$data) {
                $newData = new HistoryLog();
                $newData->userId = $users->id;
                $newData->type = 2;
                $newData->date = date("Y-m-d");
                $newData->time = date("H:i:s");
                $newData->save();
                $body = $users->name." さん<br/>お疲れ様です。<br/>本日(".date("Y-m-d").")の退社時間は「".date("H:i:s")."」です。<br/> お疲れさまでした！<br/> 以上。";
                $message = [
                    'title' => "【勤務管理】".$users->name." 退社(".now().")",
                    'mail_cc' => $users->email,
                    'body' => $body

                ];
                SendEmailCheckOut::dispatch($message)->delay(now()->addMinute(1));
                
            }
           
        }
        
        // $data = HistoryLog::with('userProfile')->first();
        return response()->json(['data'=> 'ok', 'messgae' => 0]);
    }

    function checkIn(Request $request , $slug) {

        $users = Admin::where('code' ,$slug )->first();
        if ($users) {
            $data = HistoryLog::where('userId', $users->id)->where('type', 1)->where('date', date("Y-m-d"))->first();
            if (!$data) {
                $newData = new HistoryLog();
                $newData->userId = $users->id;
                $newData->type = 1;
                $newData->date = date("Y-m-d");
                $newData->time = date("H:i:s");
                $newData->save();
                $body = $users->name." さん<br/>お疲れ様です。<br/>本日(".date("Y-m-d").")の出社時間は「".date("H:i:s")."」です。<br/> 今日も一日頑張りましょう！<br/> 以上。";
                $message = [
                    'title' => "【勤務管理】".$users->name." 出社(".now().")",
                    'mail_cc' => $users->email,
                    'body' => $body

                ];
                SendEmailCheckIn::dispatch($message)->delay(now()->addMinute(1));

            }
        }
        
        // $data = HistoryLog::with('userProfile')->first();
        return response()->json(['data'=> 'ok', 'messgae' => 0]);
    }

    function checkCode(Request $request , $slug) {
        $users = Admin::where('code' ,$slug )->first();
        $message = 0;
        $data = [];
        if (!$users) {
            $message = 1;
        } else {
            $data = [
                'avatar' => url('/').$users->avatar,
                'name' => $users->name,
                'code' => $users->code,
                'code' => $users->code
            ];
        }
        return response()->json(['data'=>$data , 'messgae' => $message]);
    }

    function list(Request $request) {
        $menu_active = 'users';
        $menu_parent_active = 'users-group';
        return view(
            'admin.users.list',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );
    }

    function listCheckIn(Request $request) {
        $menu_active = 'checkin';
        $menu_parent_active = 'checkin-group';
        return view(
            'admin.users.list-checkin',
            compact([
                'menu_active',
                'menu_parent_active'
            ])
        );
    }
    function getListCheckin(Request $request) {
        $page = $request->page - 1;
        $users = HistoryLog::orderBy("id" , "DESC")->with('userProfile');
        if(@$request->name != '' ){
            $someId = $request->name;
            $users = $users->whereHas('userProfile', function ($query) use($someId) {
                return $query->where('name', 'like', '%'.$someId.'%');
            });
        }
        if(@$request->type != '' ){
            $users = $users->whereIn('type', explode(',', $request->type) );
        }
        
        $count = $users->count();
        $pageTotal = ceil($count/$this->limit);
        $users = $users->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$users,'count'=>$count,'pageTotal' => $pageTotal]);
    }

    function getList(Request $request) {
        $page = $request->page - 1;
        $users = Admin::orderBy("name" , "ASC")->with('bophan');
        if(@$request->name != '' ){
            $users = $users->where('name', 'like', '%'.$request->name.'%');
        }
        if(@$request->email != '' ){
            $users = $users->Where('email', 'like', '%'.$request->email.'%');
        }
        
        $count = $users->count();
        $pageTotal = ceil($count/$this->limit);
        $users = $users->offset($page * $this->limit)->limit($this->limit)->get();
        return response()->json(['data'=>$users,'count'=>$count,'pageTotal' => $pageTotal]);
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

    function add(Request $request) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            $user = $request->all();

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|unique:users',
                    'phone' => 'required|unique:users',
                    'password' => 'required|alpha_dash'
    
                ],
                [
                    'email.required' => 'Please enter your email!',
                    'email.unique' => 'This email already exists!',
                    'phone.required' => 'Please enter your phone number !',
                    'phone.unique' => 'This phone number already exists!',
                    'password.required' => 'Please re-enter your password !'
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput($request->input());
            }
            
            $user = new Admin();
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->avatar = $request->avatar;
            $user->code = $request->code;
            $user->bophan_id = $request->bophan_id;
            $user->app_version = 1;
            $user->updated_at = date("Y-m-d");
            $user->created_at = date("Y-m-d");
            $user->save();
            return redirect('/admin/user/edit/'.$user->id)->with('message-add','Add Successful Members!');
        }
        
        
        $menu_active = 'users';
        
        $bophans = BoPhan::all();
        return view(
            'admin.users.add',
            compact([
                'menu_active',
                'bophans',
                'message',
            ])
        );

    }

    function edit(Request $request,$id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            
            $user = Admin::find($id);
            
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->avatar = $request->avatar;
            $user->code = $request->code;
            $user->bophan_id = $request->bophan_id;
            if ($request->password != '') {
                if ($request->password == $request->password_new) {

                    $user->password = Hash::make($request->password);
                    $user->save();
                    $message = [
                        "message" => "Update Success!",
                        "status" => 1
                    ];
                } else {
                    $message = [
                        "message" => "Password not match.",
                        "status" => 2
                    ];
                }
            } else {
                $user->save();
                $message = [
                    "message" => "Update Success!",
                    "status" => 1
                ];
            }
            
        }
        
        $data = Admin::find($id);
        if ( $data->birthday != '') {
            $data->birthday = date("d/m/Y", strtotime($data->birthday) );
        }
        $menu_active = 'users';
        $bophans = BoPhan::all();
        return view(
            'admin.users.edit',
            compact([
                'menu_active',
                'bophans',
                'message',
                'data'
            ])
        );
    }

    function updateMailContact(Request $request,$id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            
            $user = Admin::find($id);
            
            $user->email_to = $request->email_to ? $request->email_to : $user->email_to ;
            $user->save();
            $message = [
                "message" => "Update Success!",
                "status" => 1
            ];
            
        }
        
        $data = Admin::find($id);
        if ( $data->birthday != '') {
            $data->birthday = date("d/m/Y", strtotime($data->birthday) );
        }
        $menu_active = 'users';
        return view(
            'admin.users.contact-mail',
            compact([
                'menu_active',
                'message',
                'data'
            ])
        );
    }

    function checkListPermission(Request $request, $id) {
        
        $data = GroupPermissions::all();

        $thisGroup = UserPermissions::where('user_id', $id)->get();
        
        $arrGroup = [];
        foreach($thisGroup as $item){
            $arrGroup[] = $item->permission_id;
        }
        foreach($data as &$item){
            $item->childrent = Permissions::where('group_permission_id', $item->id)->get();
            $item->edit = 0;
            foreach($item->childrent as &$child) {
                if (in_array($child->id, $arrGroup)) {
                    $item->edit = 1;
                    $child->checked = 1;
                } else {
                    $child->checked = 0;
                }
            }
            unset($child);
        }
        unset($item);
        
        return response()->json(['data'=>$data]);
    }
    function addListPermission(Request $request, $id) {
        
        $data = $request->data;

        UserPermissions::where('user_id', $id)->delete();
        foreach($data as $item){
            if(@$item['childrent']) {
                foreach($item['childrent'] as $child) {
                    if (@$child['checked'] == 1) {
                        $newPer = new UserPermissions();
                        $newPer->user_id = $id;
                        $newPer->permission_id = $child['id'];
                        $newPer->save();
                    }
                }
            }
            
        }
        
        return response()->json(['message'=> "success update permission"]);
    }



    function delete(Request $request,$id) {
        $users = Admin::find($id);
        $users->delete();
        return response()->json(['message'=>"Xóa Thành Viên Thành Công."]);
    }

    function active(Request $request,$id) {
        $users = Admin::find($id);
        $users->is_active = 1 ;
        $users->save();
        return response()->json(['message'=>"Active Thành Viên Thành Công."]);
    }

    function deactive(Request $request,$id) {
        $users = Admin::find($id);
        $users->is_active = 0 ;
        $users->save();
        return response()->json(['message'=>"Deactive Thành Viên Thành Công."]);
    }

    function viewEmployee(Request $request,$id) {
        $data = Admin::find($id);
        $this->getEmployee($data);

        return view('admin.employee-view', compact(['data' , 'id']));
    }

    function deleteEmployee(Request $request,$id) {
        $data = Admin::find($id);
        $data->delete();
        return response()->json([]);
    }

    function getAcademic(Request $request) {
        $page = $request->page - 1;

        $employee = Admin::where('code' ,$request->user_id)->first();
        $user_id = $employee->id;

        $data = Academic::where('user_id', $user_id)->where('type', "1")->get();
        foreach($data as $item) {
            list($item->sel_year, $item->sel_month) = explode ("-", $item->month);
        }

        $data2 = Academic::where('user_id', $user_id)->where('type', "2")->get();
        foreach($data2 as $item) {
            list($item->sel_year, $item->sel_month) = explode ("-", $item->month);
        }

        $data3 = Academic::where('user_id', $user_id)->where('type', "3")->get();
        foreach($data3 as $item) {
            list($item->sel_year, $item->sel_month) = explode ("-", $item->month);
        }

        return response()->json([
            'data'=>$data,
            'data2'=>$data2,
            'data3'=>$data3,
        ]);
    }

    function updateEmployee(Request $request,$id) {
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
            return redirect('/admin/employee-view/'.$data->id);
        }

        $data = Admin::find($id);
        return view('admin.employee-update', compact(['data' , 'id']));
    }

    function getEmployee($data) {
        if ($data->bophan_id != "") {
            $bophan = BoPhan::where('id' ,$data->bophan_id)->first();
            $data->employee_depname = $bophan->name;
        }
        
        if ($data->birthday != "") {
            $data->age = date_diff(date_create($data->birthday), date_create('now'))->y;
        }

        $bookname = Bookname::where('user_id' ,$data->id)->first();
        if ($bookname) {
            $data->bookname_id = $bookname->id;
        }

        $data->classStyle = "";
        if ($data->employ_type == 1) {
            $data->classStyle = "status2";
        } else if ($data->employ_type == 2) {
            $data->classStyle = "status3";
        }
    }

    function listEmployee(Request $request) {
        return view('admin.employee', compact([]));
    }

    function getListEmployee(Request $request) {
        $page = $request->page - 1;
        
        $data = Admin::orderBy($this->defSortName, $this->defSortType);
        $data = $data->where('user', '1');
        if(@$request->item_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->item_id.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('employ_type', explode(',', $request->status_multi) );
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
            $this->getEmployee($item);
        }

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }

}
