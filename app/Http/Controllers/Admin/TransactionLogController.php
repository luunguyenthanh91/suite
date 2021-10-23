<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\MailTemplate;
use App\Models\MailPo;
use App\Models\TransactionLog;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailTemplate;
use App\Jobs\SendEmailTemplatePO;
use Helper;

class TransactionLogController extends Controller
{
    private $limit = 10;
    private $mail_template_id = 15;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function viewLog(Request $request,$id) {
        $data = TransactionLog::find($request->id);
        return view('admin.log-view', compact(['data' , 'id']));
    }

    function listLog(Request $request) {
        return view('admin.log', compact([]));
    }

    function getListLog(Request $request) {
        $page = $request->page - 1;
        
        $data = TransactionLog::orderBy($this->defSortName, $this->defSortType);
        if(@$request->log_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->log_id.'%' );
        }
        if(@$request->title != '' ){
			$data = $data->where('title', 'LIKE' , '%'.$request->title.'%' );
        }
        if(@$request->content != '' ){
			$data = $data->where('content', 'LIKE' , '%'.$request->content.'%' );
        }
        if(@$request->creator_name != '' ){
			$data = $data->where('creator_name', 'LIKE' , '%'.$request->creator_name.'%' );
        }
        if(@$request->create_date != '' ){
            $data = $data->where('create_date', $request->create_date);
        }
        if(@$request->create_date_from != '' ){
            $data = $data->where('create_date', '>=' , $request->create_date_from );
        }
        if(@$request->create_date_to != '' ){
            $data = $data->where('create_date', '<=' , $request->create_date_to );
        }

        $count = $data->count();
        $showCount = $this->limit;
        if ($showCount == 0) {
            $showCount = $count;
        }
        if ($showCount == 0) {
            $showCount = 1;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);


        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
}
