<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\User;
use App\Models\BankCollaborators;
use App\Models\Collaborators;
use App\Models\Company;
use App\Models\CtvJobs;
use App\Models\CtvJobsJoin;
use App\Models\CusJobs;
use App\Models\CusJobsJoin;
use App\Models\CollaboratorsJobs;
use App\Models\MyBank;
use App\Models\DetailCollaboratorsJobs;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\MailTemplate;
use App\Models\MailPo;
use NumberFormatter;
use PDF;
use App\Jobs\SendEmailTemplatePO;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    private $limit = 20;

    function SendEmailPo(Request $request) {
        $mailTemplate = MailTemplate::where('id',15)->first();
        $bodyMail = '';
        $subject = '';
        if ($mailTemplate) {
            $countPd = count(explode(',',$request->ngay_pd));
            $newPo = new MailPo();
            $newPo->address_pd = $request->address_pd ;
            $newPo->ngay_pd = $request->ngay_pd ;
            $newPo->count_ngay_pd = $countPd ;
            $newPo->name = $request->name ;
            // $newPo->mail = $request->mail ;
            $newPo->price = $request->price ;
            $newPo->type_train = $request->type_train ;
            $newPo->sale_price = $request->sale_price ;
            $newPo->note = $request->note_create_po ;
            $newPo->create_at = now() ;
            $newPo->save();
            $subject = $mailTemplate->subject;
            $subject = str_replace("[address_pd]",$request->address_pd, $subject);
            $subject = str_replace("[ngay_pd]",$request->ngay_pd, $subject);
            
            $bodyMail = $mailTemplate->body;
            $bodyMail = str_replace("[name]",$request->name, $bodyMail);
            $bodyMail = str_replace("[mail]",$request->mail, $bodyMail);
            $bodyMail = str_replace("[ngay_pd]",$request->ngay_pd, $bodyMail);
            $bodyMail = str_replace("[address_pd]",$request->address_pd, $bodyMail);
            $bodyMail = str_replace("[price]",$request->price, $bodyMail);
            $bodyMail = str_replace("[type_train]",$request->type_train == 0 ? '込み' : '実費' , $bodyMail);
            $bodyMail = str_replace("[sale_price]",$request->sale_price, $bodyMail);
            $bodyMail = str_replace("[note]",$request->note, $bodyMail);
            $message = [
                'title' => $subject,
                'mail_to' => $mailTemplate->to_mail,
                'mail_cc' => 'admin@alphacep.co.jp',
                'body' => $bodyMail
            ];
            SendEmailTemplatePO::dispatch($message)->delay(now()->addMinute(1));
            return redirect($request->redirect);
        } else {
            return response()->json(['code'=> 200 , 'logs' => 'Template Mail Không Tồn Tại.' ]); 
        }
    }
    function list(Request $request) {
        return view(
            'admin.company.list',
            compact([])
        );

    }
    function pdf(Request $request , $id) {
        $data = Company::find($request->id);
        $data->tong_chi = 0;
        $data->tong_chuyen_khoan = 0;
        $data->type_jobs = trim($data->type_jobs,",");
        if( $data->type_jobs ) {
            $flagType = explode(',' , $data->type_jobs);
            $data->type_jobs = $flagType;
        } else {
            $data->type_jobs = [];
        }

        $dataColla = CollaboratorsJobs::where('jobs_id' , $request->id)->get();
        $priceMove = 0;
        $priceSend = 0;
        $ctvPrice = 0;
        foreach($dataColla as &$item) {
            $item['userInfo'] = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
            $item['dateList'] = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $item->id)->get();
            $item->price_total = 0;
            $item->price_move = 0;
            $item->price_ctv = 0;
            foreach ($item['dateList'] as &$value) {
                # code...
                $value['type'] = 'update';
                $item->price_total += $value->phi_phien_dich + $value->phi_giao_thong;
                $item->price_move +=  $value->phi_giao_thong;
                $item->price_ctv += $value->phi_phien_dich;
                $item->phi_phien_dich_total += $value->phi_phien_dich;

                $priceMove += $value->phi_giao_thong;
                $ctvPrice += $value->phi_phien_dich;
            }
            unset($value);

            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
            $data->tong_chuyen_khoan +=  $item->phi_chuyen_khoan;
            $data->tong_chuyen_pd = $priceMove + $ctvPrice;
            $data->thue_phien_dich = floor($item->price_ctv * $data->percent_vat_ctvpd / 100);
            $data->phi_phien_dich = $ctvPrice;
            $data->phi_giao_thong = $priceMove;
            $data->tong_phi_phien_dich = $data->thue_phien_dich + $data->phi_phien_dich;
            $priceSend = $item->phi_chuyen_khoan;
            $data->ten_phien_dich = strtoupper($item['userInfo']->name);

            if ($item->ngay_chuyen_khoan) {
                $dateParse = explode('-', $item->ngay_chuyen_khoan);
                $data->ngay_chuyen_khoan_nam = $dateParse[0];
                $data->ngay_chuyen_khoan_thang = $dateParse[1];
                $data->ngay_chuyen_khoan_ngay = $dateParse[2];
            }
        }

        $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
            $data->tong_chuyen_khoan +=  $item->phi_chuyen_khoan;
        }
        
        $data->year = date('Y');
        $data->month = date('m');
        $data->date = date('d');
        $data->worker = strtoupper(Auth::guard('admin')->user()->name);
        $pdf = PDF::loadView('admin.company.pdf', compact('data' , 'dataSales' , 'dataColla'));
        $name = $data->id;
        return $pdf->download('支払明細書(受注No.'.$name.').pdf');
    }

    function pdfType(Request $request , $id) {
        $data = Company::find($request->id);
        $data->tong_chi = 0;
        $data->type_jobs = trim($data->type_jobs,",");
        if( $data->type_jobs ) {
            $flagType = explode(',' , $data->type_jobs);
            $data->type_jobs = $flagType;
        } else {
            $data->type_jobs = [];
        }

        $dataColla = CollaboratorsJobs::where('jobs_id' , $request->id)->get();
        $priceMove = 0;
        $priceSend = 0;
        $ctvPrice = 0;
        foreach($dataColla as &$item) {
            $item['userInfo'] = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
            $item['dateList'] = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $item->id)->get();
            $item->price_total = 0;
            foreach ($item['dateList'] as &$value) {
                # code...
                $value['type'] = 'update';
                $item->price_total += $value->phi_phien_dich + $value->phi_giao_thong;
                $priceMove += $value->phi_giao_thong;
                $ctvPrice += $value->phi_phien_dich;
            }
            unset($value);

            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
            $priceSend = $item->phi_chuyen_khoan;
        }

        $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        }

        $dataCustomer = CusJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataCustomer as &$item) {
            $item['userInfo'] = CusJobs::where("id" , $item->cus_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        }

        // echo "<pre>";print_r($dataSales);die;
        if ($data->tong_thu != 0) {
            $data->price_nhanduoc = $data->tong_thu - $data->tong_chi;
        } else {
            $data->price_nhanduoc = 0;
        }
        $dataUpdate = Company::find($request->id);
        $dataUpdate->price_nhanduoc = $data->price_nhanduoc;
        $dataUpdate->save();
        $allMyBank = MyBank::get();
        $id = $request->id;
        $typesList = [];
        $typesList[] = ["name" => '空港出迎え' , 'id' => 1];
        $typesList[] = ["name" => '入寮' , 'id' => 2];
        $typesList[] = ["name" => '役所の転入' , 'id' => 3];
        $typesList[] = ["name" => '銀行口座開設' , 'id' => 4];
        $typesList[] = ["name" => '日本語講習' , 'id' => 5];
        $typesList[] = ["name" => 'その他の講習' , 'id' => 6];
        $typesList[] = ["name" => '配属' , 'id' => 7];
        $typesList[] = ["name" => '定期巡回' , 'id' => 8];
        $typesList[] = ["name" => '臨時面会' , 'id' => 9];
        $typesList[] = ["name" => '試験' , 'id' => 10];
        $typesList[] = ["name" => 'その他' , 'id' => 11];
        $contentPd = '';
        foreach ($data->type_jobs as $itemPD) {
            foreach ($typesList as $itemList) {
                if ($itemList['id'] == $itemPD) {
                    $contentPd .= $itemList['name'] . ',';
                }
            }
        }
        $id = $request->id;
        $allMailTemplate = MailTemplate::whereIn('id',[8,9,10,11,13])->orderBy("name" , "ASC")->get();
        $flagSendMail = 0;
        $flagCustomer = 0;
        $itemSendMail = [];
        if (count($dataColla) > 0 ) {
            $flagSendMail = 1;
            $itemSendMail = $dataColla[0];
            $flagCustomer = $itemSendMail->userInfo->id;
        }
        if ($data->date_company_pay != '') {
            $dateParse = explode('-',$data->date_company_pay);
            $data->date_company_pay = $dateParse[0].'年'.$dateParse[1].'月'.$dateParse[2].'日';
        }
        // echo "<pre>";print_r($dataSales[0]);die;
        // return view(
        //     'admin.company.pdf',
        //     compact(['data' , 'dataSales' ,'dataColla'])
        // );
        // $data->year = date('Y');
        // $data->month = date('m');
        // $data->date = date('d');

        if ($item->date_company_pay) {
            $dateParse = explode('-', $item->date_company_pay);
            $data->year = $dateParse[0];
            $data->month = $dateParse[1];
            $data->date = $dateParse[2];
        }

        $data->worker = strtoupper(Auth::guard('admin')->user()->name);
        $pdf = PDF::loadView('admin.company.pdf-type', compact('data' , 'dataSales' , 'dataColla'));
        $name = $data->id;
        return $pdf->download('受領書(受注No.'.$name.').pdf');
    }

    function pdfTypeNew(Request $request , $id) {
        $data = Company::find($request->id);
        $data->tong_chi = 0;
        $data->type_jobs = trim($data->type_jobs,",");
        if( $data->type_jobs ) {
            $flagType = explode(',' , $data->type_jobs);
            $data->type_jobs = $flagType;
        } else {
            $data->type_jobs = [];
        }

        $dataColla = CollaboratorsJobs::where('jobs_id' , $request->id)->get();
        $priceMove = 0;
        $priceSend = 0;
        $ctvPrice = 0;
        foreach($dataColla as &$item) {
            $item['userInfo'] = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
            $item['dateList'] = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $item->id)->get();
            $item->price_total = 0;
            foreach ($item['dateList'] as &$value) {
                # code...
                $value['type'] = 'update';
                $item->price_total += $value->phi_phien_dich + $value->phi_giao_thong;
                $priceMove += $value->phi_giao_thong;
                $ctvPrice += $value->phi_phien_dich;
            }
            unset($value);

            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
            $priceSend = $item->phi_chuyen_khoan;
        }

        $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        }

        $dataCustomer = CusJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataCustomer as &$item) {
            $item['userInfo'] = CusJobs::where("id" , $item->cus_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        }

        // echo "<pre>";print_r($dataSales);die;
        if ($data->tong_thu != 0) {
            $data->price_nhanduoc = $data->tong_thu - $data->tong_chi;
        } else {
            $data->price_nhanduoc = 0;
        }
        $dataUpdate = Company::find($request->id);
        $dataUpdate->price_nhanduoc = $data->price_nhanduoc;
        $dataUpdate->save();
        $allMyBank = MyBank::get();
        $id = $request->id;
        $typesList = [];
        $typesList[] = ["name" => '空港出迎え' , 'id' => 1];
        $typesList[] = ["name" => '入寮' , 'id' => 2];
        $typesList[] = ["name" => '役所の転入' , 'id' => 3];
        $typesList[] = ["name" => '銀行口座開設' , 'id' => 4];
        $typesList[] = ["name" => '日本語講習' , 'id' => 5];
        $typesList[] = ["name" => 'その他の講習' , 'id' => 6];
        $typesList[] = ["name" => '配属' , 'id' => 7];
        $typesList[] = ["name" => '定期巡回' , 'id' => 8];
        $typesList[] = ["name" => '臨時面会' , 'id' => 9];
        $typesList[] = ["name" => '試験' , 'id' => 10];
        $typesList[] = ["name" => 'その他' , 'id' => 11];
        $contentPd = '';
        foreach ($data->type_jobs as $itemPD) {
            foreach ($typesList as $itemList) {
                if ($itemList['id'] == $itemPD) {
                    $contentPd .= $itemList['name'] . ',';
                }
            }
        }
        $id = $request->id;
        $allMailTemplate = MailTemplate::whereIn('id',[8,9,10,11,13])->orderBy("name" , "ASC")->get();
        $flagSendMail = 0;
        $flagCustomer = 0;
        $itemSendMail = [];
        if (count($dataColla) > 0 ) {
            $flagSendMail = 1;
            $itemSendMail = $dataColla[0];
            $flagCustomer = $itemSendMail->userInfo->id;
        }
        if ($data->date_company_pay != '') {
            $dateParse = explode('-',$data->date_company_pay);
            $data->date_company_pay = $dateParse[0].'年'.$dateParse[1].'月'.$dateParse[2].'日';
        }
        // echo "<pre>";print_r($dataSales[0]);die;
        // return view(
        //     'admin.company.pdf',
        //     compact(['data' , 'dataSales' ,'dataColla'])
        // );

        
        if ($item->date_start) {
            $dateParse = explode('-', $item->date_start);
            $data->year = $dateParse[0];
            $data->month = $dateParse[1];
            $data->date = $dateParse[2];
        }
        // $data->year = date('Y');
        // $data->month = date('m');
        // $data->date = date('d');
        $data->worker = strtoupper(Auth::guard('admin')->user()->name);
        $pdf = PDF::loadView('admin.company.pdf-type-new', compact('data' , 'dataSales' , 'dataColla'));
        $name = $data->id;
        return $pdf->download('受注書(受注No.'.$name.').pdf');
    }    
    
    function pdfMoveFeeReceipt(Request $request , $id) {
        $data = Company::find($request->id);
        $data->sale_name = '';

        $dataSales = CollaboratorsJobs::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
            $data->ten_phien_dich = strtoupper($item['userInfo']->name);
            
            $item['dateList'] = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $item->id)->get();
            $hoadon = 0;
            $price = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                if ($valueDate->file_hoa_don != '') {
                    $data->file_hoa_don = $valueDate->file_hoa_don;
                    $hoadon = 1;
                }
                $price += $valueDate->phi_giao_thong;
            }

            $data->sale_name = strtoupper($item['userInfo']->name);
            $data->file_hoa_don_status = $hoadon;
            $data->price = $price;
            
        }
        
        unset($item);

        if ($data->ngay_pd) {
            $dateParse = explode('-', $data->ngay_pd);
            $data->year = $dateParse[0];
            $data->month = $dateParse[1];
            $data->date = $dateParse[2];
        }

        $pdf = PDF::loadView('admin.movefeereceiptpdf', compact('data' , 'dataSales'));
        $name = $data->id."-".$data->sale_name;
        return $pdf->download('交通費領収書(受注No.'.$name.').pdf');
    }

    function pdfTaxPD(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
        // $data = Company::orderBy("company.ngay_pd" , "ASC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->ctv_sex == '1' || @$request->ctv_sex == '2'){
            $newData = Collaborators::where('male','=', )->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if (@$request->loai_statusbank_multi == '0' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.paytaxstatus', 'LIKE' , '%0%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '1' ) {
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.paytaxstatus', 'LIKE' , '%1%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $count = $data->count();
        $data->sumData = $count;
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumTaxPD = 0;
        $sumPay = 0;
        $data->selectedMonth = $request->thang_chuyen_khoan;

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $sumTaxPD += $sumThuePhienDich;
            $sumPay += $sumPhiPhienDich;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            if ($item->status_bank) {
                $item->statusChecked = "☑";
            } else {
                $item->statusChecked = "";
            }
        }
        $data->sumPay = $sumPay;
		$data->sumTaxPD = $sumTaxPD;
        $data->sumData = $count;
        unset($item);
        $pdf = PDF::loadView('admin.taxpdpdf', compact('data'));

        // $name = $data->codejob;
        return $pdf->download('源泉徴収リスト('.$data->selectedMonth.').pdf');
    }

    function pdfEarnings(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->ngay_phien_dich_from != '' ){
            $data = $data->where('company.ngay_pd', '>=' , $request->ngay_phien_dich_from );
        }
        if(@$request->ngay_phien_dich_to != '' ){
            $data = $data->where('company.ngay_pd', '<=' , $request->ngay_phien_dich_to );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' );
        }
        if(@$request->ngay_chuyen_khoan_from != '' ){
			$data = $data->where('company.date_company_pay', '>=' , $request->ngay_chuyen_khoan_from );
        }
        if(@$request->ngay_chuyen_khoan_to != '' ){
			$data = $data->where('company.date_company_pay', '<=' , $request->ngay_chuyen_khoan_to );
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $data = $data->where('company.status_bank','not like', '%1%' );
        } else if (@$request->loai_statusbank_multi != '' ) {
            $data = $data->whereIn('company.status_bank', explode(',', $request->loai_statusbank_multi) );
        }

        $count = $data->count();
        $data->sumData = $count;
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumTaxPD = 0;
        $sumPay = 0;
        $data->selectedMonth = '';
        if(@$request->thang_phien_dich != '' ){
            $data->selectedMonth = $request->thang_phien_dich;
        }
        
        if(@$request->ngay_phien_dich_from != '' ){
            $data->selectedMonth = $data->selectedMonth . $request->ngay_phien_dich_from . '～';
        }

        if(@$request->ngay_phien_dich_to != '' ){
            if(@$request->ngay_phien_dich_from != '' ){
                $data->selectedMonth = $data->selectedMonth . $request->ngay_phien_dich_to;
            } else {
                $data->selectedMonth = $data->selectedMonth . $request->ngay_phien_dich_to . 'まで';
            }
        }

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $sumTaxPD += $sumThuePhienDich;
            
            $sumPay += $item->tong_thu;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            if ($item->status_bank) {
                $item->statusChecked = "☑";
            } else {
                $item->statusChecked = "";
            }
        }
        $data->sumPay = $sumPay;
		$data->sumTaxPD = $sumTaxPD;
        $data->sumData = $count;
        unset($item);
        // return view(
        //     'admin.earningspdf',
        //     compact(['data'])
        // );
        $pdf = PDF::loadView('admin.earningspdf', compact('data'));
        // die;
        // $name = $data->codejob;
        return $pdf->download('売上帳('.$data->selectedMonth.').pdf');
    }

    function pdfPay(Request $request) {

        $page = $request->page - 1;
        $data = Company::orderBy("company.ngay_pd" , "ASC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $data = $data->where('company.status_bank','not like', '%1%' );
        } else if (@$request->loai_statusbank_multi != '' ) {
            $data = $data->whereIn('company.status_bank', explode(',', $request->loai_statusbank_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }

        $count = $data->count();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumTaxPD = 0;
        $sumPay = 0;
        $data->selectedMonth = $request->thang_phien_dich;

        foreach($data as &$item) {



            // $dataColla = CollaboratorsJobs::where('jobs_id' , $item->id)->get();

            // foreach($dataColla as &$ctvItem) {
            //     print_r($ctvItem->id);die;
            //     $item->userInfo = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
            // }

            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $sumTaxPD += $sumThuePhienDich;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            if ($item->status_bank) {
                $item->statusChecked = "☑";
            } else {
                $item->statusChecked = "";
            }

            $sumPay += $item->tong_thu;
        }
        $data->sumPay = $sumPay;
        unset($item);


        // $data = Company::find($request->id);
        // $data->tong_chi = 0;
        // $data->type_jobs = trim($data->type_jobs,",");
        // if( $data->type_jobs ) {
        //     $flagType = explode(',' , $data->type_jobs);
        //     $data->type_jobs = $flagType;
        // } else {
        //     $data->type_jobs = [];
        // }

        // $dataColla = CollaboratorsJobs::where('jobs_id' , $request->id)->get();
        // $priceMove = 0;
        // $priceSend = 0;
        // $ctvPrice = 0;
        // foreach($dataColla as &$item) {
        //     $item['userInfo'] = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
        //     $item['dateList'] = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $item->id)->get();
        //     $item->price_total = 0;
        //     foreach ($item['dateList'] as &$value) {
        //         # code...
        //         $value['type'] = 'update';
        //         $item->price_total += $value->phi_phien_dich + $value->phi_giao_thong;
        //         $priceMove += $value->phi_giao_thong;
        //         $ctvPrice += $value->phi_phien_dich;
        //     }
        //     unset($value);

        //     $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        //     $priceSend = $item->phi_chuyen_khoan;
        // }

        // $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        // foreach($dataSales as &$item) {
        //     $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
        //     $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        // }

        // $dataCustomer = CusJobsJoin::where('jobs_id' , $request->id)->get();
        // foreach($dataCustomer as &$item) {
        //     $item['userInfo'] = CusJobs::where("id" , $item->cus_jobs_id)->first();
        //     $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan;
        // }

        // // echo "<pre>";print_r($dataSales);die;
        // if ($data->tong_thu != 0) {
        //     $data->price_nhanduoc = $data->tong_thu - $data->tong_chi;
        // } else {
        //     $data->price_nhanduoc = 0;
        // }
        // $dataUpdate = Company::find($request->id);
        // $dataUpdate->price_nhanduoc = $data->price_nhanduoc;
        // $dataUpdate->save();
        // $allMyBank = MyBank::get();
        // $id = $request->id;
        // $typesList = [];
        // $typesList[] = ["name" => '空港出迎え' , 'id' => 1];
        // $typesList[] = ["name" => '入寮' , 'id' => 2];
        // $typesList[] = ["name" => '役所の転入' , 'id' => 3];
        // $typesList[] = ["name" => '銀行口座開設' , 'id' => 4];
        // $typesList[] = ["name" => '日本語講習' , 'id' => 5];
        // $typesList[] = ["name" => 'その他の講習' , 'id' => 6];
        // $typesList[] = ["name" => '配属' , 'id' => 7];
        // $typesList[] = ["name" => '定期巡回' , 'id' => 8];
        // $typesList[] = ["name" => '臨時面会' , 'id' => 9];
        // $typesList[] = ["name" => '試験' , 'id' => 10];
        // $typesList[] = ["name" => 'その他' , 'id' => 11];
        // $contentPd = '';
        // foreach ($data->type_jobs as $itemPD) {
        //     foreach ($typesList as $itemList) {
        //         if ($itemList['id'] == $itemPD) {
        //             $contentPd .= $itemList['name'] . ',';
        //         }
        //     }
        // }
        // $id = $request->id;
        // $allMailTemplate = MailTemplate::whereIn('id',[8,9,10,11,13])->orderBy("name" , "ASC")->get();
        // $flagSendMail = 0;
        // $flagCustomer = 0;
        // $itemSendMail = [];
        // if (count($dataColla) > 0 ) {
        //     $flagSendMail = 1;
        //     $itemSendMail = $dataColla[0];
        //     $flagCustomer = $itemSendMail->userInfo->id;
        // }
        // foreach ($allMailTemplate as &$itemMail) {
        //     if ($flagSendMail == 1) {

        //         $itemMail->cc_mail = $itemSendMail->userInfo->email;
        //         $itemMail->subject = str_replace("[ordernumber]",$data->codejob,$itemMail->subject);
        //         $itemMail->subject = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->subject);
        //         $itemMail->body = str_replace("[name]",strtoupper($itemSendMail->userInfo->name),$itemMail->body);
        //         $itemMail->body = str_replace("[ordernumber]",$data->codejob,$itemMail->body);
        //         $itemMail->body = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->body);
        //         $itemMail->body = str_replace("[workcontent]", $contentPd ,$itemMail->body);
        //         $itemMail->body = str_replace("[workplace]",$data->address_pd,$itemMail->body);
        //         $itemMail->body = str_replace("[worktime]",$data->phone_nguoilienlac,$itemMail->body);
        //         $itemMail->body = str_replace("[othername]",$itemSendMail->userInfo->furigana,$itemMail->body);
        //         $itemMail->body = str_replace("[phone]",$itemSendMail->userInfo->phone,$itemMail->body);
        //         $itemMail->body = str_replace("[your-email]",$itemSendMail->userInfo->email,$itemMail->body);
        //         $itemMail->body = str_replace("[companyname]",$data->ten_nguoilienlac,$itemMail->body);
        //         $itemMail->body = str_replace("[place]",$data->address_pd,$itemMail->body);
        //         $itemMail->body = str_replace("[name_interpreter]",strtoupper($itemSendMail->userInfo->name),$itemMail->body);
        //         // setlocale(LC_MONETARY,"ja_JP");
        //         $fmt = new NumberFormatter( 'ja_JP', NumberFormatter::CURRENCY );
        //         $itemMail->body = str_replace("[customer_totalmoney]",$fmt->formatCurrency($data->tong_thu,'JPY'),$itemMail->body);
        //         $itemMail->body = str_replace("[interpreter_totalmoney]",$fmt->formatCurrency(($priceMove + $priceSend + $ctvPrice),'JPY'),$itemMail->body);
        //         $itemMail->body = str_replace("[interpreter_money]",$fmt->formatCurrency($ctvPrice,'JPY'),$itemMail->body);
        //         $itemMail->body = str_replace("[move_money]",$fmt->formatCurrency($priceMove,'JPY'),$itemMail->body);
        //         $itemMail->body = str_replace("[bank_money]",$fmt->formatCurrency($priceSend,'JPY'),$itemMail->body);
        //         $itemMail->body = str_replace("[total_money]",$fmt->formatCurrency(($data->tong_thu - $priceMove - $priceSend - $ctvPrice),'JPY'),$itemMail->body);
        //     }
        // }
        // unset($itemMail);
        // if ($data->date_company_pay != '') {
        //     $dateParse = explode('-',$data->date_company_pay);
        //     $data->date_company_pay = $dateParse[0].'年'.$dateParse[1].'月'.$dateParse[2].'日';
        // }
        // // echo "<pre>";print_r($dataSales[0]);die;
        // // return view(
        // //     'admin.company.pdf',
        // //     compact(['data' , 'dataSales' ,'dataColla'])
        // // );
        // $pdf = PDF::loadView('admin.company.pdf-type-new', compact('data' , 'dataSales' , 'dataColla'));
        $pdf = PDF::loadView('admin.company.pdfpay', compact('data'));

        // $name = $data->codejob;
        return $pdf->download('入金リスト('.$data->selectedMonth.').pdf');
    }

    // function getListAll(Request $request) {
    //     $data = Collaborators::orderBy("id" , "DESC");
    //     $data = $data->all();
    //     return response()->json(['data'=>$data]);
    // }

    // function getList(Request $request) {
    //     $page = $request->page - 1;
    //     $sortName = "company.id";
    //     $sortType = "DESC";
    //     if(@$request->sortname != '' ){
    //         $sortName = @$request->sortname;
    //         $sortType = @$request->sorttype;
    //     }
    //     $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
    //         'ctvList' => function($q) {
    //             $q
    //             ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
    //             ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
    //         }
    //     ])->with([
    //         'ctvSalesList' => function($q) {
    //             $q
    //             ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
    //             ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
    //         }
    //     ]);
    //     if(@$request->name != '' ){
    //         $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
    //     }
    //     if(@$request->status != '' ){
    //         $data = $data->where('company.status', $request->status );
    //     }
    //     if(@$request->date_start != '' ){
    //         $data = $data->where('company.date_start', $request->date_start );
    //     }
    //     if(@$request->type_jobs != '' ){
    //         $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
    //     }
    //     if(@$request->code_jobs != '' ){
    //         $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
    //     }
    //     if(@$request->address != '' ){
    //         $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
    //     }
    //     if(@$request->status_multi != '' ){
    //         $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
    //     }
    //     if(@$request->loai_job_multi != '' ){
    //         $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
    //     }
    //     if (@$request->ctv_sex == '1' || @$request->ctv_sex == '2'){
    //         $newData = Collaborators::where('male','=', )->get();
    //         $listIdIn = [];
    //         if($newData) {
    //             foreach($newData as $item) {
    //                 $listIdIn[] = $item->id;
    //             }
    //         }

    //         $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
    //         $listCompany = [];
    //         if($newDataJobs) {
    //             foreach($newDataJobs as $item) {
    //                 if (!in_array($item->jobs_id,$listCompany)) {
    //                     $listCompany[] = $item->jobs_id;
    //                 }

    //             }
    //         }
    //         $data = $data->whereIn('id',$listCompany);
    //     }
    //     if(@$request->ctv_pd != '' ){
    //         $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
    //         $listIdIn = [];
    //         if($newData) {
    //             foreach($newData as $item) {
    //                 $listIdIn[] = $item->id;
    //             }
    //         }

    //         $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
    //         $listCompany = [];
    //         if($newDataJobs) {
    //             foreach($newDataJobs as $item) {
    //                 if (!in_array($item->jobs_id,$listCompany)) {
    //                     $listCompany[] = $item->jobs_id;
    //                 }

    //             }
    //         }
    //         $data = $data->whereIn('id',$listCompany);
    //     }
    //     if(@$request->ctv_sale != '' ){
    //         // CtvJobsJoin
    //         $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
    //         $listIdIn = [];
    //         if($newData) {
    //             foreach($newData as $item) {
    //                 $listIdIn[] = $item->id;
    //             }
    //         }

    //         $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
    //         $listCompany = [];
    //         if($newDataJobs) {
    //             foreach($newDataJobs as $item) {
    //                 if (!in_array($item->jobs_id,$listCompany)) {
    //                     $listCompany[] = $item->jobs_id;
    //                 }

    //             }
    //         }
    //         $data = $data->whereIn('id',$listCompany);
    //     }
    //     $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
    //     if(@$request->ngay_phien_dich != '' ){
    //         // echo $request->ngay_phien_dich;die;
    //         // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
    //         $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
    //     }
    //     if(@$request->thang_phien_dich != '' ){
	// 		$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
    //     }
    //     if(@$request->date_start_month != '' ){
	// 		$data = $data->where('company.date_start', 'LIKE' , '%'.$request->date_start_month.'%' );
    //     }
    //     if (@$request->check_akaji != '' ){
    //         $data = $data->where('company.tong_kimduocdukien','<', '0' );
    //     }

    //     // $count = $data->count();
    //     // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
    //     // $count = $count === 0 ? 1 : $count;
    //     // $pageTotal = ceil($count/$this->limit);

    //     $count = $data->count();
    //     $showCount = $request->showcount;
    //     if ($showCount == 0) {
    //         $showCount = $count;
    //     }
    //     $data = $data->offset($page * $showCount)->limit($showCount)->get();
    //     $countPage = $count === 0 ? 1 : $count;
    //     $pageTotal = ceil($countPage/$showCount);



    //     // echo "<pre>";
    //     // print_r($data);die;
    //     foreach($data as &$item) {
    //         $item->classStyle = "statusOther";
    //         if ($item->status == 7) {
    //             $item->classStyle = "status7";
    //         } else if ($item->status == 2) {
    //             $item->classStyle = "status2";
    //         } else if ($item->status == 6) {
    //             $item->classStyle = "status6";
    //         } else if ($item->status == 3 ||$item->status == 4 || $item->status == 5 || $item->status== 8) {
    //             $item->classStyle = "status458";
    //         }
    //         if ($item->tong_kimduocdukien < 0) {
    //             $item->classStyle = $item->classStyle."Minus";
    //         }

    //         $item->type_jobs = trim($item->type_jobs,",");
    //         if( $item->type_jobs ) {
    //             $flagType = explode(',' , $item->type_jobs);
    //             $item->type_jobs = $flagType;
    //         } else {
    //             $item->type_jobs = [];
    //         }
    //         $sumPhiPhienDich = 0;
    //         $sumThuePhienDich = 0;
    //         $sumPhiGiaoThong = 0;

    //         $sumPhiChuyenKhoanSale = 0;
    //         foreach ( $item->ctvSalesList as $ctvItem) 
    //         {
    //             if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
    //                 $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
    //             }
    //         }
    //         foreach ( $item->ctvList as $ctvItem) 
    //         {
    //             if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
    //                 $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
    //             }
    //         }
    //         $item->sumPhiChuyenKhoanSale = $sumPhiChuyenKhoanSale;

    //         foreach ( $item->dateList as $valueDate) {
    //             # code...
    //             $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
    //             $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
    //             $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
    //         }
    //         $item->sumPhPhienDich = $sumPhiPhienDich;
    //         $item->sumThuePhienDich = $sumThuePhienDich;
    //         $item->sumPhiGiaoThong = $sumPhiGiaoThong;



    //         $typesList = [];
    //         $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
    //         $typesList[] = ["name" => '入寮' , 'id' => '2'];
    //         $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
    //         $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
    //         $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
    //         $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
    //         $typesList[] = ["name" => '配属' , 'id' => '7'];
    //         $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
    //         $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
    //         $typesList[] = ["name" => '試験' , 'id' => '10'];
    //         $typesList[] = ["name" => 'その他' , 'id' => '11'];
    //         $item->types = $typesList;
    //     }
    //     unset($item);



    //     return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    // }

    
    
    // function listProject(Request $request) {
    //     return view(
    //         'admin.project',
    //         compact([])
    //     );
    // }

    // function getListProject(Request $request) {
    //     $page = $request->page - 1;
    //     $sortName = "company.id";
    //     $sortType = "DESC";
    //     if(@$request->sortname != '' ){
    //         $sortName = @$request->sortname;
    //         $sortType = @$request->sorttype;
    //     }
    //     $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
    //         'ctvList' => function($q) {
    //             $q
    //             ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
    //             ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
    //         }
    //     ])->with([
    //         'ctvSalesList' => function($q) {
    //             $q
    //             ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
    //             ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
    //         }
    //     ]);
    //     if(@$request->name != '' ){
    //         $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
    //     }
    //     if(@$request->status != '' ){
    //         $data = $data->where('company.status', $request->status );
    //     }
    //     if(@$request->date_start != '' ){
    //         $data = $data->where('company.date_start', $request->date_start );
    //     }
    //     if(@$request->type_jobs != '' ){
    //         $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
    //     }
    //     if(@$request->code_jobs != '' ){
    //         $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
    //     }
    //     if(@$request->address != '' ){
    //         $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
    //     }
    //     if(@$request->status_multi != '' ){
    //         $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
    //     }
    //     if(@$request->loai_job_multi != '' ){
    //         $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
    //     }

    //     if(@$request->ctv_pd != '' ){
    //         $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
    //         $listIdIn = [];
    //         if($newData) {
    //             foreach($newData as $item) {
    //                 $listIdIn[] = $item->id;
    //             }
    //         }

    //         $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
    //         $listCompany = [];
    //         if($newDataJobs) {
    //             foreach($newDataJobs as $item) {
    //                 if (!in_array($item->jobs_id,$listCompany)) {
    //                     $listCompany[] = $item->jobs_id;
    //                 }

    //             }
    //         }
    //         $data = $data->whereIn('id',$listCompany);
    //     }
    //     if(@$request->ctv_sale != '' ){
    //         // CtvJobsJoin
    //         $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
    //         $listIdIn = [];
    //         if($newData) {
    //             foreach($newData as $item) {
    //                 $listIdIn[] = $item->id;
    //             }
    //         }

    //         $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
    //         $listCompany = [];
    //         if($newDataJobs) {
    //             foreach($newDataJobs as $item) {
    //                 if (!in_array($item->jobs_id,$listCompany)) {
    //                     $listCompany[] = $item->jobs_id;
    //                 }

    //             }
    //         }
    //         $data = $data->whereIn('id',$listCompany);
    //     }
    //     $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
    //     if(@$request->ngay_phien_dich != '' ){
    //         // echo $request->ngay_phien_dich;die;
    //         // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
    //         $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
    //     }
    //     if(@$request->thang_phien_dich != '' ){
	// 		$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
    //     }

    //     $count = $data->count();
    //     $showCount = $request->showcount;
    //     if ($showCount == 0) {
    //         $showCount = $count;
    //     }
    //     $data = $data->offset($page * $showCount)->limit($showCount)->get();
    //     $count = $count === 0 ? 1 : $count;
    //     $pageTotal = ceil($count/$showCount);
    //     // echo "<pre>";
    //     // print_r($data);die;
    //     foreach($data as &$item) {
    //         $item->type_jobs = trim($item->type_jobs,",");
    //         if( $item->type_jobs ) {
    //             $flagType = explode(',' , $item->type_jobs);
    //             $item->type_jobs = $flagType;
    //         } else {
    //             $item->type_jobs = [];
    //         }
    //         $sumPhiPhienDich = 0;
    //         $sumThuePhienDich = 0;
    //         $sumPhiGiaoThong = 0;
    //         foreach ( $item->dateList as $valueDate) {
    //             # code...
    //             $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
    //             $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
    //             $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
    //         }
    //         $item->sumPhPhienDich = $sumPhiPhienDich;
    //         $item->sumThuePhienDich = $sumThuePhienDich;
    //         $item->sumPhiGiaoThong = $sumPhiGiaoThong;



    //         $typesList = [];
    //         $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
    //         $typesList[] = ["name" => '入寮' , 'id' => '2'];
    //         $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
    //         $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
    //         $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
    //         $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
    //         $typesList[] = ["name" => '配属' , 'id' => '7'];
    //         $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
    //         $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
    //         $typesList[] = ["name" => '試験' , 'id' => '10'];
    //         $typesList[] = ["name" => 'その他' , 'id' => '11'];
    //         $item->types = $typesList;
    //     }
    //     unset($item);



    //     return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    // }

    function listPay(Request $request) {
        return view(
            'admin.company.listpay',
            compact([])
        );

    }

    function listMoveFee(Request $request) {
        return view(
            'admin.movefee',
            compact([])
        );
    }

    function getListMoveFee(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);

            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;

        foreach($data as $keyIndex => &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            $hoadon = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                if ($valueDate->file_hoa_don != '') {
                    $hoadon = 1;
                }
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;       
            $item->file_hoa_don_status = ($sumPhiGiaoThong > 0)? $hoadon : 1;
            

            $sumPay += $sumPhiGiaoThong;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            // if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
            //     unset($data[$keyIndex]);
            // }
        }

        if (@$request->loai_move_status == '0') {
            foreach(@$data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->sumPhiGiaoThong != '' && $item->sumPhiGiaoThong > 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }

        } 
        if (@$request->loai_move_status == '1') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }
        }

        if (@$request->loai_receipt_status == '0') {
            foreach(@$data as $keyIndex => &$item) {    
                if ($item->file_hoa_don_status == 1) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }

        } 
        if (@$request->loai_receipt_status == '1') {
            foreach($data as $keyIndex => &$item) {
                if ($item->file_hoa_don_status == 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }
        }

        // echo "<pre>";
        // print_r($data);die;
        // $data = $dataNew;
        unset($item);

        

        // foreach ($data as $key => &$itemData) {
        //     if ($itemData->sumPhiGiaoThong > 0) {
        //         unset($data[$key]);
        //     }
        // }


        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal,'sumPay' => $sumPay]);
    }

    

    function listEarnings(Request $request) {
        return view(
            'admin.earnings',
            compact([])
        );
    }

    function getListEarnings(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->ngay_phien_dich_from != '' ){
            $data = $data->where('company.ngay_pd', '>=' , $request->ngay_phien_dich_from );
        }
        if(@$request->ngay_phien_dich_to != '' ){
            $data = $data->where('company.ngay_pd', '<=' , $request->ngay_phien_dich_to );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' );
        }
        if(@$request->ngay_chuyen_khoan_from != '' ){
			$data = $data->where('company.date_company_pay', '>=' , $request->ngay_chuyen_khoan_from );
        }
        if(@$request->ngay_chuyen_khoan_to != '' ){
			$data = $data->where('company.date_company_pay', '<=' , $request->ngay_chuyen_khoan_to );
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $data = $data->where('company.status_bank','not like', '%1%' );
        } else if (@$request->loai_statusbank_multi != '' ) {
            $data = $data->whereIn('company.status_bank', explode(',', $request->loai_statusbank_multi) );
        }

        if (@$request->typePay == '1' ){
            $data = $data->where('company.stk_thanh_toan_id', '!=' , '24' )->where('company.stk_thanh_toan_id', '!=' , '' );
        }
        if (@$request->typePay == '2' ) {
            $data = $data->where('company.stk_thanh_toan_id', '=' , '24' );
        }
        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;

        $allMyBank = MyBank::get();

        foreach($data as $keyIndex => &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;            

            $sumPay += $item->tong_thu;

            foreach($allMyBank as $bankDataItem) {
                if ($bankDataItem->id == $item->stk_thanh_toan_id ) {
                    $item->ten_bank = $bankDataItem->name_bank;
                    break;
                }
            }

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            // if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
            //     unset($data[$keyIndex]);
            // }
        }

        if (@$request->loai_move_status == '0') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->tong_thu != '' && $item->tong_thu > 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->tong_thu;
                }
            }

        } else if (@$request->loai_move_status == '1') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->tong_thu == '' || $item->tong_thu <= 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->tong_thu;
                }
            }
        }

        // echo "<pre>";
        // print_r($data);die;
        // $data = $dataNew;
        unset($item);

        

        // foreach ($data as $key => &$itemData) {
        //     if ($itemData->sumPhiGiaoThong > 0) {
        //         unset($data[$key]);
        //     }
        // }


        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal,'sumPay' => $sumPay]);
    }

    

    

    

    function getListCost(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' );
        }

        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;

        foreach($data as $keyIndex => &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            $hoadon = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                if ($valueDate->file_hoa_don != '') {
                    $hoadon = 1;
                }
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = floor($item->percent_vat_ctvpd * $sumPhiPhienDich / 100);
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;   
            $item->file_hoa_don_status = ($sumPhiGiaoThong > 0)? $hoadon : 1;
            
            $sumSale = 0;
            $sumBankFee = 0;
            foreach ( $item->ctvSalesList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
                $sumSale += $ctvItem->price_total;
            }
            $item->sumSale = $sumSale;
            foreach ( $item->ctvList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumBankFee = $sumBankFee;
            

            $item->sumSale = $sumSale;
            $item->cost = $sumSale + $sumPhiPhienDich + $sumPhiGiaoThong + $sumBankFee + $sumThuePhienDich;
            $sumPay += $item->cost;


            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            // if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
            //     unset($data[$keyIndex]);
            // }
        }

        if (@$request->loai_move_status == '0') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->tong_thu != '' && $item->tong_thu > 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->tong_thu;
                }
            }

        } else if (@$request->loai_move_status == '1') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->tong_thu == '' || $item->tong_thu <= 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->tong_thu;
                }
            }
        }

        // echo "<pre>";
        // print_r($data);die;
        // $data = $dataNew;
        unset($item);

        

        // foreach ($data as $key => &$itemData) {
        //     if ($itemData->sumPhiGiaoThong > 0) {
        //         unset($data[$key]);
        //     }
        // }


        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal,'sumPay' => $sumPay]);
    }

    

    function listBenefit(Request $request) {
        return view(
            'admin.benefit',
            compact([])
        );
    }

    function getListBenefit(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' );
        }

        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;

        foreach($data as $keyIndex => &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = floor($item->percent_vat_ctvpd * $sumPhiPhienDich / 100);
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;   
            
            $sumSale = 0;
            $sumBankFee = 0;
            foreach ( $item->ctvSalesList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
                $sumSale += $ctvItem->price_total;
            }
            $item->sumSale = $sumSale;
            foreach ( $item->ctvList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumBankFee = $sumBankFee;
            

            $item->sumSale = $sumSale;
            $item->cost = $sumSale + $sumPhiPhienDich + $sumPhiGiaoThong + $sumBankFee + $sumThuePhienDich;
            $item->benefit = $item->tong_thu - $item->cost;
            $sumPay += $item->benefit;


            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            // if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
            //     unset($data[$keyIndex]);
            // }
        }

        if (@$request->loai_move_status == '0') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->tong_thu != '' && $item->tong_thu > 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->tong_thu;
                }
            }

        } else if (@$request->loai_move_status == '1') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->tong_thu == '' || $item->tong_thu <= 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->tong_thu;
                }
            }
        }

        // echo "<pre>";
        // print_r($data);die;
        // $data = $dataNew;
        unset($item);

        

        // foreach ($data as $key => &$itemData) {
        //     if ($itemData->sumPhiGiaoThong > 0) {
        //         unset($data[$key]);
        //     }
        // }


        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal,'sumPay' => $sumPay]);
    }

    function listDashboard(Request $request) {
        $yearNow = date('Y');
        $yearReportPrice = [];
        for($i = 1; $i < 13 ; $i++ ) {
            $key = $i;
            $key2 = $i;
            if ($key2 < 10) {
                $key2 = '0'.$key2;
            }
            $listRecords = Company::where("date_company_pay", 'Like' , "%".$yearNow . '-' . $key2."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;


            $sumPay = 0;
            $sumEarningMonth = 0;
            $sumBenefitMonth = 0;

            foreach ($listRecords as $item) {
               
                $sumPhiPhienDich = 0;
                $sumThuePhienDich = 0;
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    # code...
                    $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhPhienDich = $sumPhiPhienDich;
                $item->sumThuePhienDich = floor($item->percent_vat_ctvpd * $sumPhiPhienDich / 100);
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;   
                
                $sumSale = 0;
                $sumBankFee = 0;
                foreach ( $item->ctvSalesList as $ctvItem) 
                {
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
    
                        $sumBankFee += $ctvItem->phi_chuyen_khoan;
                    }
                    $sumSale += $ctvItem->price_total;
                }
                $item->sumSale = $sumSale;
                foreach ( $item->ctvList as $ctvItem) 
                {
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
    
                        $sumBankFee += $ctvItem->phi_chuyen_khoan;
                    }
                }
                $item->sumBankFee = $sumBankFee;
                
    
                $item->sumSale = $sumSale;
                $item->cost = $sumSale + $sumPhiPhienDich + $sumPhiGiaoThong + $sumBankFee + $sumThuePhienDich;
                $item->benefit = $item->tong_thu - $item->cost;
                $sumPay += $item->benefit;
    
                $sumEarningMonth += $item->tong_thu;
                $sumBenefitMonth += $item->benefit;
            }
            $yearReportPrice[$key.'月'][] =  floor( $sumEarningMonth/10000) ;
            $yearReportPrice[$key.'月'][] = floor( $sumBenefitMonth/10000) ;

            // foreach ($listRecords as $itemList) {
            //     $datePd = explode(',',$itemList->date_company_pay);
            //     $countPD = 0;
            //     foreach($datePd as $itemPd){
            //         if (str_contains($itemPd, $yearNow . '-' . $key)) {
            //             $countPD++;
            //         }
            //     }
            //     // $total += ((($itemList->tong_thu_du_kien)/count($datePd))*$countPD);
            //     // $totalThu += ((($itemList->tong_kimduocdukien)/count($datePd))*$countPD);
            //     $totalThu +=$itemList->tong_thu;
            //     $total += 
            // }
            // $yearReportPrice[$key.'月'][] =  floor( $total/10000) ;
            // $yearReportPrice[$key.'月'][] = floor( $totalThu/10000) ;
        }

        $dayPrices = [];
            /*
        $dayPrices[date('Y-m-d')] = [];
        $dayPrices[date('Y-m-d', strtotime('-1 days'))] = [];
        $dayPrices[date('Y-m-d', strtotime('-2 days'))] = [];
        $dayPrices[date('Y-m-d', strtotime('-3 days'))] = [];
        $dayPrices[date('Y-m-d', strtotime('-4 days'))] = [];
        $dayPrices[date('Y-m-d', strtotime('-5 days'))] = [];
        $dayPrices[date('Y-m-d', strtotime('-6 days'))] = [];
        */
        for($i = date('t'); $i >=  1; $i--)
        {
            $dayPrices[date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT)] = [];
        }
        
        foreach ($dayPrices as $key => &$item) {
            $list = Company::where("date_company_pay", 'Like' , "%".$key."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;
            foreach ($list as $itemList) {
                $datePd = explode(',',$itemList->date_company_pay);

                $total += ($itemList->tong_thu_du_kien / count($datePd));
                $totalThu += ($itemList->tong_kimduocdukien / count($datePd));
                $totalKimDcTT += $itemList->tong_thu;
                $totalLoiTT += ($itemList->tong_thu - $itemList->tong_chi);
            }
            if ($totalLoiTT < 0) {
                $totalLoiTT = 0;
            }
            // $item[] =  round( $total/10000, 0, PHP_ROUND_HALF_DOWN) ;
            // $item[] = round( $totalThu/10000, 0, PHP_ROUND_HALF_DOWN) ;
            // $item[] = round( $totalKimDcTT/10000, 0, PHP_ROUND_HALF_DOWN) ;
            $item[] = floor( $totalLoiTT/10000) ;
        }

        $dayJobs = [];
		/*
        $dayJobs[date('Y-m-d', strtotime('+3 days'))] = [];
        $dayJobs[date('Y-m-d', strtotime('+2 days'))] = [];
        $dayJobs[date('Y-m-d', strtotime('+1 days'))] = [];
        $dayJobs[date('Y-m-d')] = [];
        $dayJobs[date('Y-m-d', strtotime('-1 days'))] = [];
        $dayJobs[date('Y-m-d', strtotime('-2 days'))] = [];
        $dayJobs[date('Y-m-d', strtotime('-3 days'))] = [];
		*/
		for($i = date('t'); $i >=  1; $i--)
		{
			$dayJobs[date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT)] = [];
		}
		
        foreach ($dayJobs as $key => &$item) {
            $item =  Company::where("ngay_pd", 'Like' , "%".$key."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->count();
        }
        unset($item);

        $yearNow = date('Y');
        $yearReport = [];
        for($i = 1; $i < 13 ; $i++ ) {
            $key = $i;
            if ($key < 10) {
                $key = '0'.$key;
            }
            // $listRecords = Company::where("ngay_pd", 'Like' , "%".$yearNow . '-' . $key."%")->where("status",'!=' , 7)->get();
            $listRecords = Company::where("date_start", 'Like' , "%".$yearNow . '-' . $key."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $countFlag = 0;
            foreach ($listRecords as $value) {
                $countFlag += substr_count($value->ngay_pd, $yearNow . '-' . $key); 
            }
            $yearReport[$key.'月'] = $countFlag;
        }

        unset($item);
        return view(
            'admin.dashboard',
            compact(['dayPrices' , 'yearReportPrice','dayJobs' , 'yearReport'])
        );
    }

    function getListDashboard(Request $request) {
        $page = $request->page - 1;

        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data3 = Company::orderBy("company.date_start" , "DESC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        $data3 = $data3->where('company.ngay_pd', '>=' , '2021-03-17' );
        $thangpd = "{{date('Y-m')}}";
        $data3 = $data3->where('company.date_start', 'LIKE' ,'%'.$request->thang_phien_dich.'%' );
        

        $count3 = $data3->count();
        $data3 = $data3->offset($page * $count3)->limit($count3)->get();
        $count3 = $count3 === 0 ? 1 : $count3;
        $pageTotal3 = ceil($count3/$count3);

        foreach($data3 as $keyIndex => &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;
        }


       
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' );
        }

        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;
        $sumEarningMonth = 0;
        $sumBenefitMonth = 0;
        $sumCountMonth = 0;

        foreach($data as $keyIndex => &$item) {
            
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = floor($item->percent_vat_ctvpd * $sumPhiPhienDich / 100);
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;   
            
            $sumSale = 0;
            $sumBankFee = 0;
            foreach ( $item->ctvSalesList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
                $sumSale += $ctvItem->price_total;
            }
            $item->sumSale = $sumSale;
            foreach ( $item->ctvList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumBankFee = $sumBankFee;
            

            $item->sumSale = $sumSale;
            $item->cost = $sumSale + $sumPhiPhienDich + $sumPhiGiaoThong + $sumBankFee + $sumThuePhienDich;
            $item->benefit = $item->tong_thu - $item->cost;
            $sumPay += $item->benefit;

            $sumEarningMonth += $item->tong_thu;
            $sumBenefitMonth += $item->benefit;
            $sumCountMonth += 1;
        }

        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data5 = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
       if(@$request->thang_chuyen_khoan != '' ){
            $data5 = $data5->where('company.date_start', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' );
        }
        $data5 = $data5->where('company.ngay_pd', '>=' , '2021-03-17' );
        $sumCountMonth =$data5->count();


        $yearNow = substr($request->thang_chuyen_khoan, 0, 4); 
        $data6 = Company::where("date_start", 'Like' , "%".$yearNow."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
        $sumCountYear = $data6->count();
       



        $data2 = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data2 = $data2->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data2 = $data2->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data2 = $data2->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data2 = $data2->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data2 = $data2->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data2 = $data2->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data2 = $data2->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data2 = $data2->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data2 = $data2->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data2 = $data2->whereIn('id',$listCompany);
        }
        $data2 = $data2->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data2 = $data2->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $year = substr($request->thang_chuyen_khoan, 0, 4); 
			$data2 = $data2->where('company.date_company_pay', 'LIKE' , '%'.$year.'%' );
        }

        $count2 = $data2->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data2 = $data2->offset($page * $count2)->limit($count2)->get();
        $count2 = $count2 === 0 ? 1 : $count2;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal2 = ceil($count2/$count2);
        // echo "<pre>";
        // print_r($data);die;
        

        $sumEarningYear = 0;
        $sumBenefitYear = 0;
        foreach($data2 as $keyIndex => &$item) {
            $sumEarningYear += $item->tong_thu;

            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = floor($item->percent_vat_ctvpd * $sumPhiPhienDich / 100);
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;   
            
            $sumSale = 0;
            $sumBankFee = 0;
            foreach ( $item->ctvSalesList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
                $sumSale += $ctvItem->price_total;
            }
            $item->sumSale = $sumSale;
            foreach ( $item->ctvList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumBankFee += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumBankFee = $sumBankFee;
            $item->sumSale = $sumSale;
            $item->cost = $sumSale + $sumPhiPhienDich + $sumPhiGiaoThong + $sumBankFee + $sumThuePhienDich;
            $item->benefit = $item->tong_thu - $item->cost;
            $sumBenefitYear += $item->benefit;
        }

        unset($item);


        // function chartPrice(Request $request) {
       
            $yearNow = date('Y');
            $yearReportPrice = [];
            for($i = 1; $i < 13 ; $i++ ) {
                $key = $i;
                if ($key < 10) {
                    $key = '0'.$key;
                }
                $listRecords = Company::where("ngay_pd", 'Like' , "%".$yearNow . '-' . $key."%")->where("status",'!=' , 7)->get();
                $total = 0;
                $totalThu = 0;
                $totalKimDcTT = 0;
                $totalLoiTT = 0;
                foreach ($listRecords as $itemList) {
                    $datePd = explode(',',$itemList->ngay_pd);
                    $countPD = 0;
                    foreach($datePd as $itemPd){
                        if (str_contains($itemPd, $yearNow . '-' . $key)) {
                            $countPD++;
                        }
                    }
                    $total += ((($itemList->tong_thu_du_kien)/count($datePd))*$countPD);
                    $totalThu += ((($itemList->tong_kimduocdukien)/count($datePd))*$countPD);
                }
                if ($totalLoiTT < 0) {
                    $totalLoiTT = 0;
                }
                $yearReportPrice[$key.'月'][] =  round( $total/10000, 0, PHP_ROUND_HALF_DOWN) ;
                $yearReportPrice[$key.'月'][] = round( $totalThu/10000, 0, PHP_ROUND_HALF_DOWN) ;
            }
    
    
            $dayPrices = [];
            /*
            $dayPrices[date('Y-m-d')] = [];
            $dayPrices[date('Y-m-d', strtotime('-1 days'))] = [];
            $dayPrices[date('Y-m-d', strtotime('-2 days'))] = [];
            $dayPrices[date('Y-m-d', strtotime('-3 days'))] = [];
            $dayPrices[date('Y-m-d', strtotime('-4 days'))] = [];
            $dayPrices[date('Y-m-d', strtotime('-5 days'))] = [];
            $dayPrices[date('Y-m-d', strtotime('-6 days'))] = [];
            */
            for($i = date('t'); $i >=  1; $i--)
            {
                $dayPrices[date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT)] = [];
            }
            
            foreach ($dayPrices as $key => &$item) {
                $list = Company::where("ngay_pd", 'Like' , "%".$key."%")->where("status",'!=' , 7)->get();
                $total = 0;
                $totalThu = 0;
                $totalKimDcTT = 0;
                $totalLoiTT = 0;
                foreach ($list as $itemList) {
                    $datePd = explode(',',$itemList->ngay_pd);
    
                    $total += ($itemList->tong_thu_du_kien / count($datePd));
                    $totalThu += ($itemList->tong_kimduocdukien / count($datePd));
                    $totalKimDcTT += $itemList->tong_thu;
                    $totalLoiTT += ($itemList->tong_thu - $itemList->tong_chi);
                }
                if ($totalLoiTT < 0) {
                    $totalLoiTT = 0;
                }
                $item[] =  round( $total/10000, 0, PHP_ROUND_HALF_DOWN) ;
                $item[] = round( $totalThu/10000, 0, PHP_ROUND_HALF_DOWN) ;
                $item[] = round( $totalKimDcTT/10000, 0, PHP_ROUND_HALF_DOWN) ;
                $item[] = round( $totalLoiTT/10000, 0, PHP_ROUND_HALF_DOWN) ;
            }
            unset($item);
    
        //     // echo "<pre>";
        //     // print_r($yearReportPrice);die;
        //     return view(
        //         'admin.reports.chart-price',
        //         compact([ 'dayPrices' , 'yearReportPrice'])
        //     );
    
        // }


        return response()->json(['data3'=>$data3,'data'=>$data,'count'=>$count3,'pageTotal' => $pageTotal3,'sumPay' => $sumPay, 'sumEarningMonth' => $sumEarningMonth, 'sumEarningYear' => $sumEarningYear, 'sumBenefitMonth' => $sumBenefitMonth, 'dayPrices' => $yearReportPrice, 'sumBenefitYear' => $sumBenefitYear, 'sumCountYear' => $sumCountYear, 'sumCountMonth' => $sumCountMonth]);
    }

    function listBankFee(Request $request) {
        return view(
            'admin.bankfee',
            compact([])
        );
    }

    function getListBankFee(Request $request) {

        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $sumPay = 0;
        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $pagecount = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($pagecount/$pagecount);
        // echo "<pre>";
        // print_r($data);die;

        foreach($data as $keyIndex => &$item) {
            $sumPhiChuyenKhoanSale = 0;
            foreach ( $item->ctvSalesList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                }
            }
            $sumPhiChuyenKhoanPD = 0;
            foreach ( $item->ctvList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumPhiChuyenKhoanPD += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumPhiChuyenKhoanSale = $sumPhiChuyenKhoanSale;
            $item->sumPhiChuyenKhoanPD = $sumPhiChuyenKhoanPD;
            $item->sum_phi_chuyen_khoan = $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanPD;
            $sumPay +=$item->sum_phi_chuyen_khoan;
        }

        if (@$request->loai_bankfee_status == '0') {
            foreach($data as $keyIndex => &$item) {  
    
                if ($item->sum_phi_chuyen_khoan > 0) {
                    $count = $count - 1;
                    $sumPay = $sumPay -  $item->sum_phi_chuyen_khoan;
                    unset($data[$keyIndex]);
                }
            }

        } 
         if (@$request->loai_bankfee_status == '1') {
            foreach($data as $keyIndex => &$item) { 
    
                if ($item->sum_phi_chuyen_khoan <= 0) {
                    $count = $count - 1;
                    $sumPay = $sumPay -  $item->sum_phi_chuyen_khoan;
                    unset($data[$keyIndex]);
                }
            }
        }

        unset($item);

        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal,'sumPay' => $sumPay]);
    }

    function pdfBankFee(Request $request) {

        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;

        foreach($data as $keyIndex => &$item) {

            $in = $item->address_pd;
            $item->address_pd_short = strlen($in) > 15 ? mb_substr($in,0,15)."..." : $in;

            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;  

            $sumPhiChuyenKhoanSale = 0;
            foreach ( $item->ctvSalesList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumPay += $ctvItem->phi_chuyen_khoan;
                    $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                }
            }
            $sumPhiChuyenKhoanPD = 0;
            foreach ( $item->ctvList as $ctvItem) 
            {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {

                    $sumPay += $ctvItem->phi_chuyen_khoan;
                    $sumPhiChuyenKhoanPD += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumPhiChuyenKhoanSale = $sumPhiChuyenKhoanSale;
            $item->sumPhiChuyenKhoanPD = $sumPhiChuyenKhoanPD;
            $item->sum_phi_chuyen_khoan = $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanPD;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            foreach ( $item->ctvList as $ctvPD) {
                $bankData = BankCollaborators::where('collaborators_id' , $ctvPD->collaborators_id)->get();
                foreach($bankData as $bankDataItem) {
                    $ctvPD->ten_bank = $bankDataItem->ten_bank;
                    $ctvPD->stk = $bankDataItem->stk;
                    $ctvPD->chinhanh = $bankDataItem->chinhanh;
                    $ctvPD->ten_chutaikhoan = $bankDataItem->ten_chutaikhoan;
                    $ctvPD->loai_taikhoan = $bankDataItem->loai_taikhoan;
                    $ctvPD->ms_nganhang = $bankDataItem->ms_nganhang;
                    $ctvPD->ms_chinhanh = $bankDataItem->ms_chinhanh;
                    break;
                }
            }

            // if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
            //     unset($data[$keyIndex]);
            // }
        }

        if (@$request->loai_bankfee_status == '0') {
            foreach($data as $keyIndex => &$item) {  
    
                if ($item->sum_phi_chuyen_khoan > 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sum_phi_chuyen_khoan;
                }
            }

        } 
         if (@$request->loai_bankfee_status == '1') {
            foreach($data as $keyIndex => &$item) { 
    
                if ($item->sum_phi_chuyen_khoan <= 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sum_phi_chuyen_khoan;
                }
            }
        }

        // echo "<pre>";
        // print_r($data);die;
        // $data = $dataNew;
        unset($item);

        
        $data->sumPay = $sumPay;
        $data->sumData = $count;
        $data->selectedMonth = $request->thang_chuyen_khoan;

        $pdf = PDF::loadView('admin.bankfeepdf', compact('data'));

        return $pdf->download('振込手数料一覧表('.$data->selectedMonth.').pdf');
    }

    function getListPay(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
        // $data = Company::orderBy("company.ngay_pd" , "ASC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $data = $data->where('company.status_bank','not like', '%1%' );
        } else if (@$request->loai_statusbank_multi != '' ) {
            $data = $data->whereIn('company.status_bank', explode(',', $request->loai_statusbank_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.date_company_pay', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumTaxPD = 0;
        $sumPay = 0;

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $sumTaxPD += $sumThuePhienDich;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            if ($item->status_bank) {
                $item->statusChecked = "☑";
            } else {
                $item->statusChecked = "";
            }

            $sumPay += $item->tong_thu;
        }

        unset($item);


        // $ngay_pds = [];
        // foreach($data as $item) {
        //     $ngay_pds[] = $item['ngay_pd'];
        // }

        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal, 'sumPay' => $sumPay]);
    }

    function listTaxPD(Request $request) {
        return view(
            'admin.taxpd',
            compact([])
        );

    }
    function getListTaxPD(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
        // $data = Company::orderBy("company.ngay_pd" , "ASC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->ctv_sex == '1' || @$request->ctv_sex == '2'){
            $newData = Collaborators::where('male','=', )->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        
        if(@$request->pay_tax_month != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.paytaxdate', 'LIKE' , '%'.$request->pay_tax_month.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->pay_tax_date != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.paytaxdate', 'LIKE' , '%'.$request->pay_tax_date.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        {
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.status', '=' , '1' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if (@$request->loai_statusbank_multi == '0' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.paytaxstatus', 'LIKE' , '%0%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '1' ) {
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.paytaxstatus', 'LIKE' , '%1%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $countPage = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($countPage/$countPage);
        // echo "<pre>";
        // print_r($data);die;

        $sumTaxPD = 0;
        $sumPhiPD = 0;

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = floor($item->percent_vat_ctvpd * $sumPhiPhienDich / 100);
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $sumTaxPD += $sumThuePhienDich;
            $sumPhiPD += $sumPhiPhienDich;

            foreach ( $item->ctvList as $ctvPD) {
                if ($ctvPD->paytaxstatus) {
                    $ctvPD->paytaxstatusChecked = "☑";
                } else {
                    $ctvPD->paytaxstatusChecked = "";
                }
            }

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;
        }

        unset($item);


        // $ngay_pds = [];
        // foreach($data as $item) {
        //     $ngay_pds[] = $item['ngay_pd'];
        // }

        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal, 'sumTaxPD' => $sumTaxPD, 'sumPhiPD' => $sumPhiPD]);
    }

    function listPD(Request $request) {
        return view(
            'admin.partnerinterpreter',
            compact([])
        );
    }
    function getListPD(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
        // $data = Company::orderBy("company.ngay_pd" , "ASC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }

        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.status', 'LIKE' , '%0%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '1' ) {
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.status', 'LIKE' , '%1%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        if (@$request->typePay == '1' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.bank_id', '!=' , '2')->where('collaborators_jobs.bank_id', '!=' , '')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->typePay == '2' ) {
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.bank_id', '=' , '2')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPriceTotal = 0;

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;

            foreach ( $item->ctvList as $ctvPD) {
                if ($ctvPD->status) {
                    $ctvPD->statusChecked = "☑";
                } else {
                    $ctvPD->statusChecked = "";
                }
                $sumPriceTotal += $ctvPD->price_total;
                $bankData = BankCollaborators::where('collaborators_id' , $ctvPD->collaborators_id)->get();
                foreach($bankData as $bankDataItem) {
                    $ctvPD->ten_bank = $bankDataItem->ten_bank;
                    $ctvPD->stk = $bankDataItem->stk;
                    $ctvPD->chinhanh = $bankDataItem->chinhanh;
                    $ctvPD->ten_chutaikhoan = $bankDataItem->ten_chutaikhoan;
                    $ctvPD->loai_taikhoan = $bankDataItem->loai_taikhoan;
                    $ctvPD->ms_nganhang = $bankDataItem->ms_nganhang;
                    $ctvPD->ms_chinhanh = $bankDataItem->ms_chinhanh;
                    break;
                }
            }

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;
        }

        unset($item);
        

        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal, 'sumPriceTotal' => $sumPriceTotal ]);
    }

    function pdfListPD(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
        // $data = Company::orderBy("company.ngay_pd" , "ASC")->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.status', 'LIKE' , '%0%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '1' ) {
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.status', 'LIKE' , '%1%')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPriceTotal = 0;

        $sumTaxPD = 0;
        $sumPay = 0;

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $sumTaxPD += $sumThuePhienDich;
            $sumPay += $sumPhiPhienDich;


            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            if ($item->status_bank) {
                $item->statusChecked = "☑";
            } else {
                $item->statusChecked = "";
            }

            foreach ( $item->ctvList as $ctvPD) {
                $sumPriceTotal += $ctvPD->price_total;

                $bankData = BankCollaborators::where('collaborators_id' , $ctvPD->collaborators_id)->get();
                foreach($bankData as $bankDataItem) {
                    $ctvPD->ten_bank = $bankDataItem->ten_bank;
                    $ctvPD->stk = $bankDataItem->stk;
                    $ctvPD->chinhanh = $bankDataItem->chinhanh;
                    $ctvPD->ten_chutaikhoan = $bankDataItem->ten_chutaikhoan;
                    $ctvPD->loai_taikhoan = $bankDataItem->loai_taikhoan;
                    $ctvPD->ms_nganhang = $bankDataItem->ms_nganhang;
                    $ctvPD->ms_chinhanh = $bankDataItem->ms_chinhanh;
                    break;
                }
            }
        }
        $data->sumPay = $sumPay;
		$data->sumTaxPD = $sumTaxPD;
        $data->sumData = $count;
        $data->sumPriceTotal = $sumPriceTotal;
        $data->selectedMonth = $request->thang_chuyen_khoan;

        unset($item);

        $pdf = PDF::loadView('admin.partnerinterpreterpdf', compact('data'));

        return $pdf->download('通訳報酬一覧表('.$data->selectedMonth.').pdf');
    }

    function pdfMoveFee(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }
        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);
        
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);

            $newDataJobs = CollaboratorsJobs::where('collaborators_jobs.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumPay = 0;

        foreach($data as $keyIndex => &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            $hoadon = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                if ($valueDate->file_hoa_don != '') {
                    $hoadon = 1;
                }
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;       
            $item->file_hoa_don_status = ($sumPhiGiaoThong > 0)? $hoadon : 1;
            

            $sumPay += $sumPhiGiaoThong;

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;

            // if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
            //     unset($data[$keyIndex]);
            // }
        }

        if (@$request->loai_move_status == '0') {
            foreach(@$data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->sumPhiGiaoThong != '' && $item->sumPhiGiaoThong > 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }

        } 
        if (@$request->loai_move_status == '1') {
            foreach($data as $keyIndex => &$item) {
                $sumPhiGiaoThong = 0;
                foreach ( $item->dateList as $valueDate) {
                    $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                }
                $item->sumPhiGiaoThong = $sumPhiGiaoThong;    
    
                if ($item->sumPhiGiaoThong == '' || $item->sumPhiGiaoThong <= 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }
        }

        if (@$request->loai_receipt_status == '0') {
            foreach(@$data as $keyIndex => &$item) {    
                if ($item->file_hoa_don_status == 1) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }

        } 
        if (@$request->loai_receipt_status == '1') {
            foreach($data as $keyIndex => &$item) {
                if ($item->file_hoa_don_status == 0) {
                    unset($data[$keyIndex]);
                    $count = $count - 1;
                    $sumPay =  $sumPay - $item->sumPhiGiaoThong;
                }
            }
        }

        $data->sumPay = $sumPay;
        $data->sumData = $count;
        $data->selectedMonth = $request->thang_chuyen_khoan;

        unset($item);

        $pdf = PDF::loadView('admin.movefeepdf', compact('data'));

        return $pdf->download('交通費一覧表('.$data->selectedMonth.').pdf');
    }
    function cmp($a, $b) {
        $a_name = "";
        $b_name = "";
        // foreach ( $a->ctvSalesList as $ctvSale) {
        //     $a_name = $ctvSale->name;
        // }
        // foreach ( $b->ctvSalesList as $ctvSale) {
        //     $b_name = $ctvSale->name;
        // }
        return strcmp($a_name, $b_name);
    }



    function listSale(Request $request) {
        return view(
            'admin.partnersale',
            compact([])
        );

    }
    function getListSale(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }

        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);

        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->ngay_phien_dich_from != '' ){
            $data = $data->where('company.ngay_pd', '>=' , $request->ngay_phien_dich_from );
        }
        if(@$request->ngay_phien_dich_to != '' ){
            $data = $data->where('company.ngay_pd', '<=' , $request->ngay_phien_dich_to );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ngay_chuyen_khoan != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', '=' , $request->ngay_chuyen_khoan )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.status', '!=' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '1' ) {
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.status', '=' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_status_sale_fee_multi == '0' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.price_total', '<=' , '0')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_status_sale_fee_multi == '1' ) {
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.price_total', '>' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        if (@$request->typePay == '1' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.payplace', '=' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->typePay == '2' ) {
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.payplace', '=' , '2')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;

        $sumHoaHong = 0;

        foreach($data as &$item) {
            $item->type_jobs = trim($item->type_jobs,",");
            if( $item->type_jobs ) {
                $flagType = explode(',' , $item->type_jobs);
                $item->type_jobs = $flagType;
            } else {
                $item->type_jobs = [];
            }
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            foreach ( $item->dateList as $valueDate) {
                # code...
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;

            foreach ( $item->ctvSalesList as $ctvSale) {
                if ($ctvSale->status) {
                    $ctvSale->statusChecked = "☑";
                } else {
                    $ctvSale->statusChecked = "";
                }
                $sumHoaHong += $ctvSale->price_total;
            }

            $typesList = [];
            $typesList[] = ["name" => '空港出迎え' , 'id' => '1'];
            $typesList[] = ["name" => '入寮' , 'id' => '2'];
            $typesList[] = ["name" => '役所の転入' , 'id' => '3'];
            $typesList[] = ["name" => '銀行口座開設' , 'id' => '4'];
            $typesList[] = ["name" => '日本語講習' , 'id' => '5'];
            $typesList[] = ["name" => 'その他の講習' , 'id' => '6'];
            $typesList[] = ["name" => '配属' , 'id' => '7'];
            $typesList[] = ["name" => '定期巡回' , 'id' => '8'];
            $typesList[] = ["name" => '臨時面会' , 'id' => '9'];
            $typesList[] = ["name" => '試験' , 'id' => '10'];
            $typesList[] = ["name" => 'その他' , 'id' => '11'];
            $item->types = $typesList;
        }

        unset($item);


        // $ngay_pds = [];
        // foreach($data as $item) {
        //     $ngay_pds[] = $item['ngay_pd'];
        // }

        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal, 'sumHoaHong' => $sumHoaHong]);
    }

    

    function pdfListSale(Request $request) {
        $page = $request->page - 1;
        $sortName = "company.id";
        $sortType = "DESC";
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }

        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            'ctvSalesList' => function($q) {
                $q->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);

        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')->orWhere('address', 'like', '%'.$request->name.'%')->orWhere('title_jobs', 'like', '%'.$request->name.'%')->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->type_jobs != '' ){
            $data = $data->where('company.type_jobs','like', '%,'.$request->type_jobs.',%' );
        }
        if(@$request->code_jobs != '' ){
            $data = $data->where('company.codejob','like', '%'.$request->code_jobs.'%' );
        }
        if(@$request->address != '' ){
            $data = $data->where('company.address_pd','like', '%'.$request->address.'%' );
        }
        if(@$request->status_multi != '' ){
            $data = $data->whereIn('company.status', explode(',', $request->status_multi) );
        }
        if(@$request->loai_job_multi != '' ){
            $data = $data->whereIn('company.loai_job', explode(',', $request->loai_job_multi) );
        }

        if(@$request->ctv_pd != '' ){
            $newData = Collaborators::where('name','like', '%'.$request->ctv_pd.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('collaborators_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if(@$request->ctv_sale != '' ){
            // CtvJobsJoin
            $newData = CtvJobs::where('name','like', '%'.$request->ctv_sale.'%')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->id;
                }
            }

            $newDataJobs = CtvJobsJoin::whereIn('ctv_jobs_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->ngay_phien_dich != '' ){
            // echo $request->ngay_phien_dich;die;
            // $data = $data->join('detail_collaborators_jobs', 'detail_collaborators_jobs.company_id', '=', 'company.id');
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->thang_chuyen_khoan != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan.'%' )->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '0' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.status', '!=' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_statusbank_multi == '1' ) {
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.status', '=' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_status_sale_fee_multi == '0' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.price_total', '<=' , '0')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->loai_status_sale_fee_multi == '1' ) {
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.price_total', '>' , '1')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }

                }
            }
            $data = $data->whereIn('id',$listCompany);
        }

        $count = $data->count();
        // $data = $data->offset($page * $this->limit)->limit($this->limit)->get();
        $data = $data->offset($page * $count)->limit($count)->get();
        $count = $count === 0 ? 1 : $count;
        // $pageTotal = ceil($count/$this->limit);
        $pageTotal = ceil($count/$count);
        // echo "<pre>";
        // print_r($data);die;


        $sumPay = 0;

        foreach($data as &$item) {
            foreach ( $item->ctvSalesList as $ctvItem) {
                $sumPay += $ctvItem->price_total;
            }
        }
        $data->sumPay = $sumPay;
        $data->sumData = $count;
        $data->selectedMonth = $request->thang_chuyen_khoan;

        unset($item);

        $pdf = PDF::loadView('admin.partnersalepdf', compact('data'));

        return $pdf->download('報酬出金票('.$data->selectedMonth.').pdf');
    }
    
    function pdfSaleReceipt(Request $request , $id) {
        $data = Company::find($request->id);
        
        $data->receipt_type = "営業報酬";
        $data->price_total = 0;
        $data->sale_name = '';
        $data->year = '';
        $data->month = '';
        $data->day = '';
        $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->price_total += $item->price_total;
            $data->ngay_chuyen_khoan = $item->ngay_chuyen_khoan;
            $data->sale_name = strtoupper($item['userInfo']->name);

            $OldDate = $item->ngay_chuyen_khoan;
            if ($OldDate) {
                list($data->year, $data->month, $data->day) = explode("-", $OldDate);
            }
        }
        
        unset($itemMail);

        $pdf = PDF::loadView('admin.cost-sale-receipt-pdf', compact('data' , 'dataSales'));
        $name = $data->id."-".$data->sale_name;
        return $pdf->download('支払明細書(受注No.'.$name.').pdf');
    }
    
    function pdfInterpreterReceipt(Request $request , $id) {
        $data = Company::find($request->id);
        
        $data->receipt_type = "通訳報酬";
        $data->price_total = 0;
        $data->sale_name = '';
        $data->year = '';
        $data->month = '';
        $data->day = '';

        $dataSales = CollaboratorsJobs::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = Collaborators::where("id" , $item->collaborators_id)->with('bank')->first();
            $data->price_total += $item->price_total;
            $data->ngay_chuyen_khoan = $item->ngay_chuyen_khoan;
            $data->sale_name = strtoupper($item['userInfo']->name);

            $OldDate = $item->ngay_chuyen_khoan;
            list($data->year, $data->month, $data->day) = explode("-", $OldDate);
        }
        
        unset($item);

        $pdf = PDF::loadView('admin.partnersalereceiptpdf', compact('data' , 'dataSales'));
        $name = $data->codejob."-".$data->sale_name;
        return $pdf->download('出金伝票('.$name.').pdf');
    }

    
    function SendEmailTemplateJobs(Request $request)
    {
        if (!$request->userId) {
            return response()->json(['code'=>400]);
        }
        $users = Collaborators::where('id', $request->userId )->get();
        $message = [
            'title' => $request->title,
            'mail_cc' => $request->mail_cc,
            'body' => $request->body

        ];
        SendEmailTemplate::dispatch($message, $users)->delay(now()->addMinute(1));

        return response()->json(['code'=> 200 ]);
    }
    function sendMail(Request $request)
    {
        if (!$request->id) {
            return response()->json(['code'=>400]);
        }
        if (!$request->list) {
            return response()->json(['code'=>400]);
        }
        $data = Company::find($request->id);
        $listUser = explode(',',$request->list);
        $users = Collaborators::whereIn('id', $listUser )->get();
        $message = [
            'type' => 'Create task',
            'task' => 'test',
            'content' => 'has been created!',
            'ngay_pd' => $data->ngay_pd,
            'address_pd' => $data->address_pd,
            'description' => $data->description

        ];
        SendEmail::dispatch($message, $users)->delay(now()->addMinute(1));

        return response()->json(['code'=> 200 ]);
    }
    public function aaac($value) {
        echo $value;die; 
    }

    function delete(Request $request,$id) {
        CollaboratorsJobs::where('jobs_id' , $id)->delete();
        $data = Company::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Công Việc Thành Công."]);
    }

}
