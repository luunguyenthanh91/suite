<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\MailTemplate;
use App\Models\WorkSheet;
use App\Models\TransactionLog;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailTemplate;
use App\Jobs\SendEmailTemplatePO;
use Helper;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class WSController extends Controller
{
    private $limit = 20;
    private $mail_template_id = 15;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function addWorkSheet(Request $request) {
        
    }

    function updateWorkSheet(Request $request,$id) {
        
    }

    function deleteWorkSheet(Request $request,$id) {
        $data = WorkSheet::find($id);
        $data->delete();
        return response()->json([]);
    }

    function viewWorkSheet(Request $request,$id) {
        $data = WorkSheet::find($request->id);
        return view('admin.worksheet-view', compact(['data' , 'id']));
    }

    function listWorkSheet(Request $request) {
        return view('admin.worksheet', compact([]));
    }

    function getListWorkSheet(Request $request) {
        $page = $request->page - 1;
        
        $data = WorkSheet::orderBy($this->defSortName, $this->defSortType);
        if(@$request->item_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->item_id.'%' );
        }
        if(@$request->month != '' ){
			$data = $data->where('month', 'LIKE' , '%'.$request->month.'%' );
        }
        if(@$request->user_id != '' ){
			$data = $data->where('user_id', 'LIKE' , '%'.$request->user_id.'%' );
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

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }
}
