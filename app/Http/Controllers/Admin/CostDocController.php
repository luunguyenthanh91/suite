<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\MailTemplate;
use App\Models\Payslip;
use App\Models\PayslipPartern;
use App\Models\TransactionLog;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailTemplate;
use App\Jobs\SendEmailTemplatePO;
use Helper;
use App\Models\Admin;
use App\Models\CostTransport;
use App\Models\CostDoc;
use App\Models\NationalHoliday;
use App\Models\BoPhan;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\DocFile;
class CostDocController extends Controller
{
    private $limit = 20;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function listCostTransport(Request $request) {
        return view('admin.costtransport', compact([]));
    }

    function listCostPrePay(Request $request) {
        return view('admin.costprepay', compact([]));
    }

    function getListCostTransport(Request $request) {
        $page = $request->page - 1;
        
        $data = CostDoc::orderBy($this->defSortName, $this->defSortType);
        if(@$request->item_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->item_id.'%' );
        }
        if(@$request->type != '' ){
			$data = $data->where('type', $request->type);
        }
        if(@$request->user_id != '' ){
			$data = $data->where('user_id', 'LIKE' , '%'.$request->user_id.'%' );
        }
        if(@$request->user_name != '' ){
            $newData = Admin::where('name','like', '%'.$request->user_name.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }
            $data = $data->whereIn('id',$listIdIn);
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
            $this->getCostTransport($item);
        }

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }

    function getCostTransport($item) {
        $item->classStyle = "";
        if ($item->status == 0) {
            $item->classStyle = "status6";
        } else if ($item->status == 1) {
            $item->classStyle = "status3";
        } else if ($item->status == 2) {
            $item->classStyle = "status4";
        } else if ($item->status == 3) {
            $item->classStyle = "status2";
        }

        $item->detail = CostTransport::where('doc_id', $item->id)->get();

        $sumprice = 0;
        foreach ($item->detail as &$detailitem) {
            $sumprice += $detailitem->price;
        }
        $item->sumprice = $sumprice;

        $created_user = Admin::where('id' ,$item->created_by)->first();
        if ($created_user) {
            $item->created_by_name = $created_user->name;
            $item->created_by_sign = $created_user->sign_name;
        }

        $item->employee_name = $created_user->name;
        $item->employee_code = $created_user->code;
        $bophan = BoPhan::where('id' ,$created_user->bophan_id)->first();
        if ($bophan) {
            $item->employee_depname = $bophan->name;
        }

        if ($item->submited_on) {
            list($item->year, $item->month, $item->day) = explode ("-",$item->submited_on);
        }

        $submited_user = Admin::where('id' ,$item->submited_by)->first();
        if ($submited_user) {
            $item->submited_by_name = $submited_user->name;
            $item->submited_by_sign = $submited_user->sign_name;
        }

        $checked_user = Admin::where('id' ,$item->checked_by)->first();
        if ($checked_user) {
            $item->checked_by_name = $checked_user->name;
            $item->checked_by_sign = $checked_user->sign_name;
        }

        $approved_user = Admin::where('id' ,$item->approved_by)->first();
        if ($approved_user) {
            $item->approved_by_name = $approved_user->name;
            $item->approved_by_sign = $approved_user->sign_name;
        }

        $pay_user = Admin::where('id' ,$item->pay_by)->first();
        if ($pay_user) {
            $item->pay_by_name = $pay_user->name;
            $item->pay_by_sign = $pay_user->sign_name;
        }
    }

    function deletecosttransport(Request $request,$id) {
        $data = CostDoc::find($id);

        CostTransport::where('doc_id', $id)->delete();
        DocFile::where('item_id', $id)->where('table_name', 'cost_doc')->delete();

        $data->delete();
        return response()->json([]);
    }
    
    function addcosttransport(Request $request) {
        try {
            $data = new CostDoc();
            $data->name = $request->name;
            $data->type = $request->type;
            $data->note = $request->note;
            $data->status = 1;
            $data->created_on = date('Y-m-d');
            $data->created_by = Auth::guard('admin')->user()->id;

            $data->save();
            
            if ($data->type == 0) {
                return redirect('/admin/costtransport-view/'.$data->id);
            } else if ($data->type == 1) {
                return redirect('/admin/billprepay-view/'.$data->id);
            }
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die;
        }
    }

    function viewcosttransport(Request $request,$id) {
        $data = CostDoc::find($id);
        $this->getCostTransport($data);

        if ($data->type==1) {
            return view('admin.billprepay-view', compact(['data' , 'id']));

        } else {
            return view('admin.costtransport-view', compact(['data' , 'id']));

        }
    }
    function updatecosttransport(Request $request , $id) {
        if ($request->isMethod('post')) {
            try {
                $data = CostDoc::find($request->id);
                if ($data) {
                    $data->save();
                }
                
                if ($request->transport && count($request->transport) > 0 ) {
                    foreach ($request->transport as $item) {
                        if ($item['id'] == 'new') {
                            if ($item['action'] != 'delete') {
                                $dataTransport = new CostTransport();
                                $dataTransport->doc_id = $id;
                                $dataTransport->date = $item['date'];
                                $dataTransport->name = $item['name'];
                                $dataTransport->note = $item['note'];
                                $dataTransport->place_from = $item['place_from'];

                                if ($data->type == 0) {
                                    $dataTransport->place_to = $item['place_to'];

                                }
                                $dataTransport->price = $item['price'];
                                
                                
                                if ($data->type == 0) {
                                    $dataTransport->type = $item['type'];

                                }
                                $dataTransport->save();
                            }
                        } else {
                            $dataTransport = CostTransport::find($item['id']);
                            if ($dataTransport) {
                                if ($item['action'] == 'delete') {
                                    $dataTransport->delete();
                                } else {
                                    $dataTransport->date = $item['date'];
                                    $dataTransport->name = $item['name'];
                                    $dataTransport->note = $item['note'];
                                    $dataTransport->place_from = $item['place_from'];

                                    if ($data->type == 0) {
                                        $dataTransport->place_to = $item['place_to'];
                                    }

                                    $dataTransport->price = $item['price'];
                                    
                                    if ($data->type == 0) {
                                        $dataTransport->type = $item['type'];

                                    }

                                    $dataTransport->save();
                                }
                            }
                        }
                        
                    }
                } else {
                    CostTransport::where('doc_id', $id)->delete();
                }
                if ($request->docs && count($request->docs) > 0 ) {
                    foreach ($request->docs as $item) {
                        if ($item['id'] == 'new') {
                            if ($item['action'] != 'delete') {
                                $dataDoc = new DocFile();
                                $dataDoc->item_id = $id;
                                $dataDoc->url = $item['url'];
                                if (!str_contains($dataDoc->url, $this->url())){
                                    $dataDoc->url = $this->url().$dataDoc->url;
                                }
                                $dataDoc->table_name = $item['table_name'];
                                // $dataDoc->file_name = $item['file_name'];
                                $dataDoc->save();
                            }
                        } else {
                            $dataDoc = DocFile::find($item['id']);
                            if ($dataDoc) {
                                if ($item['action'] == 'delete') {
                                    $dataDoc->delete();
                                } else { 
                                    $dataDoc->url = $item['url'];
                                    if (!str_contains($dataDoc->url, $this->url())){
                                        $dataDoc->url = $this->url().$dataDoc->url;
                                    }   
                                    // $dataDoc->file_name = $item['file_name'];
                                    $dataDoc->save();
                                }
                            }
                        }
                        
                    }
                } else {
                    DocFile::where('item_id', $id)->where('table_name', 'cost_doc')->delete();
                }

                $message = [
                    "message" => "Đã thay đổi dữ liệu thành công.",
                    "status" => 1
                ];

                if ($data->type == 1) {
                    return redirect('/admin/billprepay-view/'.$data->id);

                } else {
                    return redirect('/admin/costtransport-view/'.$data->id);

                }
            } catch (\Throwable $th) {
                print_r($th->getMessage());die;
                $message = [
                    "message" => $th->getMessage(),
                    "status" => 2
                ];
            }
        }
        $data = CostDoc::find($id);
        $this->getCostTransport($data);

        if ($data->type == 1) {
            return view('admin.billprepay-update', compact(['data' , 'id']));

        } else {
            return view('admin.costtransport-update', compact(['data' , 'id']));

        }
    }

    function url(){
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );
    }
   
    function costtransportsubmit(Request $request,$id) {
        try {
            $data = CostDoc::find($request->id);
            if ($data) {
                $data->submited_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->submited_on = date('Y-m-d');
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

    function costtransportcheck(Request $request,$id) {
        try {
            $data = CostDoc::find($request->id);
            if ($data) {
                $data->checked_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->checked_on = date('Y-m-d');
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

    function costtransportapprove(Request $request,$id) {
        try {
            $data = CostDoc::find($request->id);
            if ($data) {
                $data->approved_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->approved_on = date('Y-m-d');
                $data->status = 0;
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

    function costtransportsendmailpay(Request $request,$id) {
        try {
            $data = CostDoc::find($request->id);
            $this->getCostTransport($data);

            if ($data) {
                $data->pay_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->pay_on = date('Y-m-d');
                $data->save();

                $employee = Admin::where('id' ,$data->created_by)->first();
                $email = $employee->email;
                list($year2, $month2, $date2) = explode("-", $data->pay_day);

                $messageData["email"] = $email;
                $messageData["title"] = "振込通知メール";
                $messageData["employee_name"] = $data->employee_name;
                $messageData["money"] = $data->sumprice;
                $messageData["note"] = $data->name;
                $messageData["url"] = "https://workspace.alphacep.co.jp/admin/billprepay-view/".$data->id;
                $messageData["pay_day"] = $year2.trans('label.year').$month2.trans('label.month').$date2.trans('label.date');
                

                Mail::send('mails.mail-billprepay', $messageData, function($message)use($messageData) {
                    $message->to($messageData["email"], $messageData["email"])
                            ->subject($messageData["title"]);
                });
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

    public function costtransportpdf(Request $request, $id) {
        $data = CostDoc::find($id);
        $this->getCostTransport($data);

        $data->detail = CostTransport::where('doc_id', $id)->get();
        $data->detailpluscount = 12 - $data->detail->count();

        $sumprice = 0;
        foreach ($data->detail as &$item) {
            $sumprice += $item->price;
        }
        $data->sumprice = $sumprice;


        if ($data->type == 1) {
            $pdf = PDF::loadView('admin.billprepay-pdf', compact('data'));
            $filename = trans('label.billprepay_pdf3').$data->id.'_'.$data->employee_code.'('.$data->employee_name.')'.'.pdf';
            

        } else {
            $pdf = PDF::loadView('admin.costtransport-pdf', compact('data'));
            $filename = trans('label.costtransport_pdf3').$data->id.'_'.$data->employee_code.'('.$data->employee_name.')'.'.pdf';
            

        }
        
        
        return $pdf->download($filename);
    }

    function getListCostTransportDetail(Request $request) {
        $page = $request->page - 1;
        
        $data = new CostTransport();
        if(@$request->doc_id != '' ){
			$data = $data->where('doc_id', $request->doc_id);
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

        $sumprice = 0;
        foreach ($data as &$item) {
            $sumprice += $item->price;
        }

        return response()->json([
            'data'=>$data,
            'sumprice'=>$sumprice,
            'count'=>$count,
        ]);
    }
}
