<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\MailTemplate;
use App\Models\StartDo;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MailTemplateController extends Controller
{
    private $limit = 20;
    function list(Request $request) {
        return view(
            'admin.mails.list',
            compact([])
        );

    }


    function getList(Request $request) {
        $page = $request->page - 1;
        $data = MailTemplate::orderBy("id" , "DESC");
        if(@$request->name != '' ){
            $data = $data->where('name', 'like', '%'.$request->name.'%')->orWhere('note', 'like', '%'.$request->name.'%');
            // $data = $data->whereHas('product_catalog', function ($q) use ($id) {
            //     $q->where('product_catalog_id', $id)
            //         ->orWhere('parent_id', $id);
            // })->paginate(12);

        }
        $count = $data->count();
        $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }
    function getListAll(Request $request) {
        $data = MailTemplate::orderBy("id" , "DESC");
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
                $data = MailTemplate::find($request->id);
                $data->name = $request->name;
                $data->from_mail = $request->from_mail;
                $data->to_mail = $request->to_mail;
                $data->cc_mail = $request->cc_mail;
                $data->subject = $request->subject;
                $data->body = $request->body;
                $data->note = $request->note;
                $data->save();
                $message = [
                    "message" => "???? thay ?????i d??? li???u th??nh c??ng.",
                    "status" => 1
                ];
            } catch (\Throwable $th) {
                $message = [
                    "message" => "C?? l???i x???y ra khi thay ?????i v??o d??? li???u.",
                    "status" => 2
                ];
            }
            
        }
        $data = MailTemplate::find($request->id);
        $id = $request->id;
        return view(
            'admin.mails.edit',
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
                $data = new MailTemplate();
                $data->name = $request->name;
                $data->from_mail = $request->from_mail;
                $data->to_mail = $request->to_mail;
                $data->cc_mail = $request->cc_mail;
                $data->subject = $request->subject;
                $data->body = $request->body;
                $data->note = $request->note;
                $data->save();
                $message = [
                    "message" => "???? th??m d??? li???u th??nh c??ng.",
                    "status" => 1
                ];
            } catch (\Throwable $th) {
                $message = [
                    "message" => "C?? l???i x???y ra khi th??m v??o d??? li???u.",
                    "status" => 2
                ];
            }
            
        }

        return view(
            'admin.mails.add',
            compact(['message'])
        );

    }

    function delete(Request $request,$id) {
        $data = MailTemplate::find($id);
        $data->delete();
        return response()->json(['message'=>"X??a Mail Th??nh C??ng."]);
    }

}
