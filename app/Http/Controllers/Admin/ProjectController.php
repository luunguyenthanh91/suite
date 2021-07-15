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
use NumberFormatter;
use PDF;

class ProjectController extends Controller
{
    private $limit = 20;
    private $defSortName = "company.id";
    private $defSortType = "DESC";

    function getViewProject(Request $request) {
        return view(
            'admin.project',
            compact([])
        );
    }

    function getListProject(Request $request) {
        $page = $request->page - 1;

        $sortName = $this->defSortName;
        $sortType = $this->defSortType;
        if(@$request->sortname != '' ){
            $sortName = @$request->sortname;
            $sortType = @$request->sorttype;
        }

        $data = Company::orderBy($sortName , $sortType)->with('dateList')->with([
            // 通訳者
            'ctvList' => function($q) {
                $q
                ->join('collaborators', 'collaborators.id', '=', 'collaborators_jobs.collaborators_id')
                ->select('collaborators.*', 'collaborators_jobs.*' , 'collaborators.id as user_id');
            }
        ])->with([
            // 営業者
            'ctvSalesList' => function($q) {
                $q
                ->join('ctv_jobs', 'ctv_jobs.id', '=', 'ctv_jobs_join.ctv_jobs_id')
                ->select('ctv_jobs.*', 'ctv_jobs_join.*' , 'ctv_jobs.id as sale_id');
            }
        ]);

        $data = $data->where('company.ngay_pd', '>=' , '2021-03-17' );
        if(@$request->name != '' ){
            $data = $data->where('name_company', 'like', '%'.$request->name.'%')
            ->orWhere('address', 'like', '%'.$request->name.'%')
            ->orWhere('title_jobs', 'like', '%'.$request->name.'%')
            ->orWhere('ten_nguoilienlac', 'like', '%'.$request->name.'%');
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->ngay_phien_dich != '' ){
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->date_start_month != '' ){
			$data = $data->where('company.date_start', 'LIKE' , '%'.$request->date_start_month.'%' );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if (@$request->check_akaji != '' ){
            $data = $data->where('company.tong_kimduocdukien','<', '0' );
        }
        if(@$request->status != '' ){
            $data = $data->where('company.status', $request->status );
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
        if (@$request->ctv_sex == '1' || @$request->ctv_sex == '2'){
            $newData = Collaborators::where('male','=', @$request->ctv_sex)->get();
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

        $count = $data->count();
        $showCount = $request->showcount;
        if ($showCount == 0) {
            $showCount = $count;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);

        foreach($data as &$item) {
            $item->classStyle = "statusOther";
            if ($item->status == 7) {
                $item->classStyle = "status7";
            } else if ($item->status == 2) {
                $item->classStyle = "status2";
            } else if ($item->status == 6) {
                $item->classStyle = "status6";
            } else if ($item->status == 3 ||$item->status == 4 || $item->status == 5 || $item->status== 8) {
                $item->classStyle = "status458";
            }
            if ($item->tong_kimduocdukien < 0) {
                $item->classStyle = $item->classStyle."Minus";
            }

            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            $sumPhiChuyenKhoanSale = 0;

            foreach ( $item->ctvSalesList as $ctvItem) {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                    $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                }
            }
            foreach ( $item->ctvList as $ctvItem) {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                    $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                }
            }
            $item->sumPhiChuyenKhoanSale = $sumPhiChuyenKhoanSale;

            foreach ( $item->dateList as $valueDate) {
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumThuePhienDich += floor($item->percent_vat_ctvpd * $valueDate->phi_phien_dich / 100);
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
        }

        unset($item);
        return response()->json(['data'=>$data,'count'=>$count,'pageTotal' => $pageTotal]);
    }

    function addProject(Request $request) {
        if ($request->isMethod('post')) {
            try {
                $data = new Company();
                $data->name_company = $request->name_company;
                
                $data->ngay_pd = $request->ngay_pd;
                $data->total_day_pd = count(explode(',', $request->ngay_pd));
                $data->address_pd = $request->address_pd;
                $data->tienphiendich = $request->tienphiendich;
                $data->description = $request->description;
                
                $data->date_start = date("Y-m-d");
                $data->codejob = date("Y/m/d H:i:s") . '';
                $data->codejob = str_replace('/', '' , str_replace(' ', '' , str_replace(':', '' , $data->codejob) ) );
                $data->created_at = date('Y-m-d H:i:s');
                
                $data->save();
                return redirect('/admin/projectview/'.$data->id);

            } catch (Exception $e) {
                echo "<pre>";
                print_r($e->getMessage());die;
            }
        }

        return view(
            'admin.projectnew',
            compact([])
        );
    }

    function viewProject(Request $request,$id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = Company::find($request->id);
                if ($data) {
                    $data->name_company = $request->name_company;
                    // $data->phone = $request->phone;
                    // $data->email = $request->email;
                    // $data->address = $request->address;
                    $data->longitude = $request->longitude;
                    $data->latitude = $request->latitude;
                    // $data->tong_chidukien = $request->tong_chidukien;
                    $data->tong_thu_du_kien = $request->tong_thu_du_kien;
                    $data->codejob = $request->codejob;
                    // $data->ga = $request->ga;
                    // $data->title_jobs = $request->title_jobs;
                    $data->description = $request->description;
                    $data->ten_nguoilienlac = $request->ten_nguoilienlac;
                    $data->phone_nguoilienlac = $request->phone_nguoilienlac;
                    $data->date_start = $request->date_start;
                    $data->total_day_pd = count(explode(',', $request->ngay_pd));
                    // $data->price_phiendich = $request->price_phiendich;
                    $data->price_giaothong = $request->price_giaothong;
                    // $data->status_fax = $request->status_fax;
                    $data->status_bank = $request->status_bank ? $request->status_bank : 0;
                    $data->loai_job = $request->loai_job ? $request->loai_job : 1;
                    $data->price_send_ctvpd = $request->price_send_ctvpd;
                    if ($data->loai_job == 3) {
                        $data->price_send_ctvpd = 0;
                    }
                    $data->percent_vat_ctvpd = $request->percent_vat_ctvpd;
                    $data->price_vat_ctvpd = floor($request->percent_vat_ctvpd * $request->price_send_ctvpd / 100);
                    $data->price_sale = $request->price_sale;
                    $data->price_company_duytri = $request->price_company_duytri;
                    $data->tienphiendich = $request->tienphiendich;
                    $data->tienphiendich = str_replace(',','',$data->tienphiendich);
                    $data->tienphiendich = str_replace('￥','',$data->tienphiendich);
                    $data->typehoahong = $request->typehoahong ? $request->typehoahong : 0;
                    $data->ortherPrice = $request->ortherPrice;
                    $data->descriptionPrice = $request->descriptionPrice;
                    if ($data->loai_job == 1) {
                        $data->tong_kimduocdukien = $request->tong_thu_du_kien - $request->price_send_ctvpd - $data->price_vat_ctvpd - $request->price_sale - $request->price_company_duytri - $request->ortherPrice;
                    } else {
                        $data->tong_kimduocdukien = $request->tong_thu_du_kien - $request->price_sale - $request->price_company_duytri - $request->ortherPrice;
                    }
                    // $data->price_status_thucte = $request->price_status_thucte;
                    $data->status = $request->status;
                    $data->ngay_pd = $request->ngay_pd;
                    $data->tong_chi = $request->tong_chi;
                    $data->status_chi = $request->status_chi;
                    // $data->status_ctv = $request->status_ctv;
                    // $data->status_ctv_pd = $request->status_ctv_pd;
                    if($request->types){
                        $flagTypes = ',' . implode(',' , $request->types) . ',';
                        $data->type_jobs = $flagTypes;
                    } else {
                        $data->type_jobs = '';
                    }

                    $data->address_pd = $request->address_pd;
                    $data->stk_thanh_toan_id = $request->stk_thanh_toan_id;
                    // $data->hoahong = $request->hoahong;
                    // $data->price_giaothongthucte = $request->price_giaothongthucte;
                    // $data->chang_ctv = $request->chang_ctv;
                    // $data->house_tts = $request->house_tts ? $request->house_tts : 0;
                    $data->tong_thu = $request->tong_thu;
                    // $data->price_company_pay = $request->price_company_pay;
                    $data->date_company_pay = $request->date_company_pay;
                    // $data->collaborators_price = $request->collaborators_price;
                    // $data->price_hoahong = $request->price_hoahong;
                    // $data->date_pay_collaborators = $request->date_pay_collaborators;
                    $data->price_nhanduoc = $request->price_nhanduoc;
                    $data->created_at = date('Y-m-d H:i:s');
                    $data->updated_at = date('Y-m-d H:i:s');
                    $data->save();
                }


                if ($request->jobsConnect && count($request->jobsConnect)  > 0  ) {
                    foreach ($request->jobsConnect as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new CollaboratorsJobs();
                                $dataBank->jobs_id = $data->id;
                                $dataBank->collaborators_id = $item['collaborators_id'];
                                $dataBank->price_total = $item['price_total'];
                                $dataBank->bank_id = $item['bank_id'];
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->paytaxplace = @$item['paytaxplace'] ? $item['paytaxplace'] : 0;
                                $dataBank->paytaxdate = $item['paytaxdate'];
                                if (@$item['paytaxstatus']) {
                                    $dataBank->paytaxstatus =$item['paytaxstatus'];
                                } else {
                                    $dataBank->paytaxstatus = 0;
                                }
                                $dataBank->save();
                                if (@$item['dateList']) {
                                    foreach (@$item['dateList'] as $itemChild) {
                                        if ($itemChild['id'] === 'new') {
                                            if ($itemChild['type'] !== 'delete') {
                                                $dataDetail = new DetailCollaboratorsJobs();
                                                $dataDetail->collaborators_jobs_id = $dataBank->id;
                                                $dataDetail->ngay_phien_dich = $itemChild['ngay_phien_dich'];
                                                $dataDetail->gio_phien_dich = $itemChild['gio_phien_dich'];
                                                $dataDetail->gio_ket_thuc = $itemChild['gio_ket_thuc'];
                                                $dataDetail->gio_tang_ca = $itemChild['gio_tang_ca'];
                                                $dataDetail->note = $itemChild['note'];
                                                $dataDetail->phi_phien_dich = $itemChild['phi_phien_dich'];
                                                $dataDetail->phi_giao_thong = $itemChild['phi_giao_thong'];
                                                // $dataDetail->file_bao_cao = $itemChild['file_bao_cao'];
                                                $dataDetail->file_hoa_don = $itemChild['file_hoa_don'];
                                                $dataDetail->company_id = $data->id;
                                                $dataDetail->save();
                                            }
                                        } else {
                                            $dataDetail = DetailCollaboratorsJobs::find($itemChild['id']);
                                            if ($dataDetail) {
                                                if ($itemChild['type'] === 'delete') {
                                                    $dataDetail->delete();
                                                } else {
                                                    $dataDetail->ngay_phien_dich = $itemChild['ngay_phien_dich'];
                                                    $dataDetail->gio_phien_dich = $itemChild['gio_phien_dich'];
                                                    $dataDetail->gio_ket_thuc = $itemChild['gio_ket_thuc'];
                                                    $dataDetail->gio_tang_ca = $itemChild['gio_tang_ca'];
                                                    $dataDetail->note = $itemChild['note'];
                                                    $dataDetail->phi_phien_dich = $itemChild['phi_phien_dich'];
                                                    $dataDetail->phi_giao_thong = $itemChild['phi_giao_thong'];
                                                    // $dataDetail->file_bao_cao = $itemChild['file_bao_cao'];
                                                    $dataDetail->file_hoa_don = $itemChild['file_hoa_don'];
                                                    $dataDetail->company_id = $data->id;
                                                    $dataDetail->save();
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                        } else {
                            $dataBank = CollaboratorsJobs::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                    DetailCollaboratorsJobs::where('collaborators_jobs_id',$item['id'])->delete();
                                } else {
                                    $dataBank->price_total = $item['price_total'];
                                    $dataBank->bank_id = $item['bank_id'];
                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }
                                    $dataBank->paytaxplace = @$item['paytaxplace'] ? $item['paytaxplace'] : 0;
                                    $dataBank->paytaxdate = $item['paytaxdate'];
                                    if (@$item['paytaxstatus']) {
                                        $dataBank->paytaxstatus =$item['paytaxstatus'];
                                    } else {
                                        $dataBank->paytaxstatus = 0;
                                    }
                                    $dataBank->save();
                                    if (@$item['dateList']) {
                                        foreach (@$item['dateList'] as $itemChild) {
                                            if ($itemChild['id'] === 'new') {
                                                if ($itemChild['type'] !== 'delete') {
                                                    $dataDetail = new DetailCollaboratorsJobs();
                                                    $dataDetail->collaborators_jobs_id = $dataBank->id;
                                                    $dataDetail->ngay_phien_dich = @$itemChild['ngay_phien_dich'];
                                                    $dataDetail->gio_phien_dich = @$itemChild['gio_phien_dich'];
                                                    $dataDetail->gio_ket_thuc = @$itemChild['gio_ket_thuc'];
                                                    $dataDetail->gio_tang_ca = @$itemChild['gio_tang_ca'];
                                                    $dataDetail->note = @$itemChild['note'];
                                                    $dataDetail->phi_phien_dich = @$itemChild['phi_phien_dich'];
                                                    $dataDetail->phi_giao_thong = @$itemChild['phi_giao_thong'];
                                                    // $dataDetail->file_bao_cao = @$itemChild['file_bao_cao'];
                                                    $dataDetail->file_hoa_don = @$itemChild['file_hoa_don'];
                                                    $dataDetail->company_id = $data->id;
                                                    $dataDetail->save();
                                                }
                                            } else {
                                                $dataDetail = DetailCollaboratorsJobs::find($itemChild['id']);
                                                if ($dataDetail) {
                                                    if ($itemChild['type'] === 'delete') {
                                                        $dataDetail->delete();
                                                    } else {
                                                        $dataDetail->ngay_phien_dich = @$itemChild['ngay_phien_dich'];
                                                        $dataDetail->gio_phien_dich = @$itemChild['gio_phien_dich'];
                                                        $dataDetail->gio_ket_thuc = @$itemChild['gio_ket_thuc'];
                                                        $dataDetail->gio_tang_ca = @$itemChild['gio_tang_ca'];
                                                        $dataDetail->note = @$itemChild['note'];
                                                        $dataDetail->phi_phien_dich = @$itemChild['phi_phien_dich'];
                                                        $dataDetail->phi_giao_thong = @$itemChild['phi_giao_thong'];
                                                        // $dataDetail->file_bao_cao = @$itemChild['file_bao_cao'];
                                                        $dataDetail->file_hoa_don = @$itemChild['file_hoa_don'];
                                                        $dataDetail->company_id = $data->id;
                                                        $dataDetail->save();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }

                    }
                }
                if ($request->jobsSale && count($request->jobsSale)  > 0  ) {
                    foreach ($request->jobsSale as $item) {

                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new CtvJobsJoin();
                                $dataBank->jobs_id = $data->id;
                                $dataBank->ctv_jobs_id = $item['ctv_jobs_id'];
                                $dataBank->price_total = $item['price_total'];
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                $dataBank->payplace = @$item['payplace'] ? $item['payplace']  :  0;
                                $dataBank->save();

                            }
                        } else {
                            $dataBank = CtvJobsJoin::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                } else {
                                    $dataBank->price_total = $item['price_total'];
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }

                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                    $dataBank->payplace = @$item['payplace'] ? $item['payplace']  :  0;
                                    $dataBank->save();

                                }
                            }
                        }

                    }
                }

                if ($request->jobsCustomer && count($request->jobsCustomer)  > 0  ) {
                    foreach ($request->jobsCustomer as $item) {

                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new CusJobsJoin();
                                $dataBank->jobs_id = $data->id;
                                $dataBank->cus_jobs_id = $item['cus_jobs_id'];
                                $dataBank->price_total = $item['price_total'];
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                $dataBank->save();

                            }
                        } else {
                            $dataBank = CusJobsJoin::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                } else {
                                    $dataBank->price_total = $item['price_total'];
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }

                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
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
            } catch (Exception $e) {

                echo "<pre>";
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thay đổi vào dữ liệu.",
                    "status" => 2
                ];
            }

        }
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
                $item->phi_giao_thong_total += $value->phi_giao_thong;
                $item->phi_phien_dich_total += $value->phi_phien_dich;
                $priceMove += $value->phi_giao_thong;
                $ctvPrice += $value->phi_phien_dich;
            }
			$item->thue_phien_dich_total = floor($item->phi_phien_dich_total * $data->percent_vat_ctvpd / 100);
            unset($value);
            if ($data->loai_job != 2) {
                $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan + $item->thue_phien_dich_total;
            }
            $priceSend = $item->phi_chuyen_khoan;
        }

        $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan + $item->thue_phien_dich_total;
        }

        $dataCustomer = CusJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataCustomer as &$item) {
            $item['userInfo'] = CusJobs::where("id" , $item->cus_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan + $item->thue_phien_dich_total;
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
        foreach ($allMailTemplate as &$itemMail) {
            if ($flagSendMail == 1) {

                $itemMail->cc_mail = $itemSendMail->userInfo->email;
                $itemMail->subject = str_replace("[ordernumber]",$data->codejob,$itemMail->subject);
                $itemMail->subject = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->subject);
                $itemMail->body = str_replace("[name]",$itemSendMail->userInfo->name,$itemMail->body);
                $itemMail->body = str_replace("[ordernumber]",$data->codejob,$itemMail->body);
                $itemMail->body = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->body);
                $itemMail->body = str_replace("[workcontent]", $contentPd ,$itemMail->body);
                $itemMail->body = str_replace("[workplace]",$data->address_pd,$itemMail->body);
                $itemMail->body = str_replace("[worktime]",$data->phone_nguoilienlac,$itemMail->body);
                $itemMail->body = str_replace("[othername]",$itemSendMail->userInfo->furigana,$itemMail->body);
                $itemMail->body = str_replace("[phone]",$itemSendMail->userInfo->phone,$itemMail->body);
                $itemMail->body = str_replace("[your-email]",$itemSendMail->userInfo->email,$itemMail->body);
                $itemMail->body = str_replace("[companyname]",$data->ten_nguoilienlac,$itemMail->body);
                $itemMail->body = str_replace("[place]",$data->address_pd,$itemMail->body);
                $itemMail->body = str_replace("[name_interpreter]",$itemSendMail->userInfo->name,$itemMail->body);
                // setlocale(LC_MONETARY,"ja_JP");
                $fmt = new NumberFormatter( 'ja_JP', NumberFormatter::CURRENCY );
                $itemMail->body = str_replace("[customer_totalmoney]",$fmt->formatCurrency($data->tong_thu,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[interpreter_totalmoney]",$fmt->formatCurrency(($priceMove + $priceSend + $ctvPrice),'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[interpreter_money]",$fmt->formatCurrency($ctvPrice,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[move_money]",$fmt->formatCurrency($priceMove,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[bank_money]",$fmt->formatCurrency($priceSend,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[total_money]",$fmt->formatCurrency(($data->tong_thu - $priceMove - $priceSend - $ctvPrice),'JPY'),$itemMail->body);
            }
        }
        unset($itemMail);
        return view(
            'admin.projectview',
            compact(['flagCustomer', 'flagSendMail', 'allMailTemplate', 'message' , 'id' ,'data' , 'dataColla' , 'allMyBank' , 'dataSales' , 'id' , 'typesList' , 'dataCustomer'])
        );
    }

    function updateProject(Request $request,$id) {
        $message = [
            "message" => "",
            "status" => 0
        ];
        if ($request->isMethod('post')) {
            try {
                $data = Company::find($request->id);
                if ($data) {
                    $data->name_company = $request->name_company;
                    // $data->phone = $request->phone;
                    // $data->email = $request->email;
                    // $data->address = $request->address;
                    $data->longitude = $request->longitude;
                    $data->latitude = $request->latitude;
                    // $data->tong_chidukien = $request->tong_chidukien;
                    $data->tong_thu_du_kien = $request->tong_thu_du_kien;
                    $data->codejob = $request->codejob;
                    // $data->ga = $request->ga;
                    // $data->title_jobs = $request->title_jobs;
                    $data->description = $request->description;
                    $data->ten_nguoilienlac = $request->ten_nguoilienlac;
                    $data->phone_nguoilienlac = $request->phone_nguoilienlac;
                    $data->date_start = $request->date_start;
                    $data->total_day_pd = count(explode(',', $request->ngay_pd));
                    // $data->price_phiendich = $request->price_phiendich;
                    $data->price_giaothong = $request->price_giaothong;
                    // $data->status_fax = $request->status_fax;
                    $data->status_bank = $request->status_bank ? $request->status_bank : 0;
                    $data->loai_job = $request->loai_job ? $request->loai_job : 1;
                    $data->price_send_ctvpd = $request->price_send_ctvpd;
                    if ($data->loai_job == 3) {
                        $data->price_send_ctvpd = 0;
                    }
                    $data->percent_vat_ctvpd = $request->percent_vat_ctvpd;
                    $data->price_vat_ctvpd = floor($request->percent_vat_ctvpd * $request->price_send_ctvpd / 100);
                    $data->price_sale = $request->price_sale;
                    $data->price_company_duytri = $request->price_company_duytri;
                    $data->tienphiendich = $request->tienphiendich;
                    $data->tienphiendich = str_replace(',','',$data->tienphiendich);
                    $data->tienphiendich = str_replace('￥','',$data->tienphiendich);
                    $data->typehoahong = $request->typehoahong ? $request->typehoahong : 0;
                    $data->ortherPrice = $request->ortherPrice;
                    $data->descriptionPrice = $request->descriptionPrice;
                    if ($data->loai_job == 1) {
                        $data->tong_kimduocdukien = $request->tong_thu_du_kien - $request->price_send_ctvpd - $data->price_vat_ctvpd - $request->price_sale - $request->price_company_duytri - $request->ortherPrice;
                    } else {
                        $data->tong_kimduocdukien = $request->tong_thu_du_kien - $request->price_sale - $request->price_company_duytri - $request->ortherPrice;
                    }
                    // $data->price_status_thucte = $request->price_status_thucte;
                    $data->status = $request->status;
                    $data->ngay_pd = $request->ngay_pd;
                    $data->tong_chi = $request->tong_chi;
                    $data->status_chi = $request->status_chi;
                    // $data->status_ctv = $request->status_ctv;
                    // $data->status_ctv_pd = $request->status_ctv_pd;
                    if($request->types){
                        $flagTypes = ',' . implode(',' , $request->types) . ',';
                        $data->type_jobs = $flagTypes;
                    } else {
                        $data->type_jobs = '';
                    }

                    $data->address_pd = $request->address_pd;
                    $data->stk_thanh_toan_id = $request->stk_thanh_toan_id;
                    // $data->hoahong = $request->hoahong;
                    // $data->price_giaothongthucte = $request->price_giaothongthucte;
                    // $data->chang_ctv = $request->chang_ctv;
                    // $data->house_tts = $request->house_tts ? $request->house_tts : 0;
                    $data->tong_thu = $request->tong_thu;
                    // $data->price_company_pay = $request->price_company_pay;
                    $data->date_company_pay = $request->date_company_pay;
                    // $data->collaborators_price = $request->collaborators_price;
                    // $data->price_hoahong = $request->price_hoahong;
                    // $data->date_pay_collaborators = $request->date_pay_collaborators;
                    $data->price_nhanduoc = $request->price_nhanduoc;
                    $data->created_at = date('Y-m-d H:i:s');
                    $data->updated_at = date('Y-m-d H:i:s');
                    $data->save();
                }


                if ($request->jobsConnect && count($request->jobsConnect)  > 0  ) {
                    foreach ($request->jobsConnect as $item) {
                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new CollaboratorsJobs();
                                $dataBank->jobs_id = $data->id;
                                $dataBank->collaborators_id = $item['collaborators_id'];
                                $dataBank->price_total = $item['price_total'];
                                $dataBank->bank_id = $item['bank_id'];
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->paytaxplace = @$item['paytaxplace'] ? $item['paytaxplace'] : 0;
                                $dataBank->paytaxdate = $item['paytaxdate'];
                                if (@$item['paytaxstatus']) {
                                    $dataBank->paytaxstatus =$item['paytaxstatus'];
                                } else {
                                    $dataBank->paytaxstatus = 0;
                                }
                                $dataBank->save();
                                if (@$item['dateList']) {
                                    foreach (@$item['dateList'] as $itemChild) {
                                        if ($itemChild['id'] === 'new') {
                                            if ($itemChild['type'] !== 'delete') {
                                                $dataDetail = new DetailCollaboratorsJobs();
                                                $dataDetail->collaborators_jobs_id = $dataBank->id;
                                                $dataDetail->ngay_phien_dich = $itemChild['ngay_phien_dich'];
                                                $dataDetail->gio_phien_dich = $itemChild['gio_phien_dich'];
                                                $dataDetail->gio_ket_thuc = $itemChild['gio_ket_thuc'];
                                                $dataDetail->gio_tang_ca = $itemChild['gio_tang_ca'];
                                                $dataDetail->note = $itemChild['note'];
                                                $dataDetail->phi_phien_dich = $itemChild['phi_phien_dich'];
                                                $dataDetail->phi_giao_thong = $itemChild['phi_giao_thong'];
                                                // $dataDetail->file_bao_cao = $itemChild['file_bao_cao'];
                                                $dataDetail->file_hoa_don = $itemChild['file_hoa_don'];
                                                $dataDetail->company_id = $data->id;
                                                $dataDetail->save();
                                            }
                                        } else {
                                            $dataDetail = DetailCollaboratorsJobs::find($itemChild['id']);
                                            if ($dataDetail) {
                                                if ($itemChild['type'] === 'delete') {
                                                    $dataDetail->delete();
                                                } else {
                                                    $dataDetail->ngay_phien_dich = $itemChild['ngay_phien_dich'];
                                                    $dataDetail->gio_phien_dich = $itemChild['gio_phien_dich'];
                                                    $dataDetail->gio_ket_thuc = $itemChild['gio_ket_thuc'];
                                                    $dataDetail->gio_tang_ca = $itemChild['gio_tang_ca'];
                                                    $dataDetail->note = $itemChild['note'];
                                                    $dataDetail->phi_phien_dich = $itemChild['phi_phien_dich'];
                                                    $dataDetail->phi_giao_thong = $itemChild['phi_giao_thong'];
                                                    // $dataDetail->file_bao_cao = $itemChild['file_bao_cao'];
                                                    $dataDetail->file_hoa_don = $itemChild['file_hoa_don'];
                                                    $dataDetail->company_id = $data->id;
                                                    $dataDetail->save();
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                        } else {
                            $dataBank = CollaboratorsJobs::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                    DetailCollaboratorsJobs::where('collaborators_jobs_id',$item['id'])->delete();
                                } else {
                                    $dataBank->price_total = $item['price_total'];
                                    $dataBank->bank_id = $item['bank_id'];
                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }
                                    $dataBank->paytaxplace = @$item['paytaxplace'] ? $item['paytaxplace'] : 0;
                                    $dataBank->paytaxdate = $item['paytaxdate'];
                                    if (@$item['paytaxstatus']) {
                                        $dataBank->paytaxstatus =$item['paytaxstatus'];
                                    } else {
                                        $dataBank->paytaxstatus = 0;
                                    }
                                    $dataBank->save();
                                    if (@$item['dateList']) {
                                        foreach (@$item['dateList'] as $itemChild) {
                                            if ($itemChild['id'] === 'new') {
                                                if ($itemChild['type'] !== 'delete') {
                                                    $dataDetail = new DetailCollaboratorsJobs();
                                                    $dataDetail->collaborators_jobs_id = $dataBank->id;
                                                    $dataDetail->ngay_phien_dich = @$itemChild['ngay_phien_dich'];
                                                    $dataDetail->gio_phien_dich = @$itemChild['gio_phien_dich'];
                                                    $dataDetail->gio_ket_thuc = @$itemChild['gio_ket_thuc'];
                                                    $dataDetail->gio_tang_ca = @$itemChild['gio_tang_ca'];
                                                    $dataDetail->note = @$itemChild['note'];
                                                    $dataDetail->phi_phien_dich = @$itemChild['phi_phien_dich'];
                                                    $dataDetail->phi_giao_thong = @$itemChild['phi_giao_thong'];
                                                    // $dataDetail->file_bao_cao = @$itemChild['file_bao_cao'];
                                                    $dataDetail->file_hoa_don = @$itemChild['file_hoa_don'];
                                                    $dataDetail->company_id = $data->id;
                                                    $dataDetail->save();
                                                }
                                            } else {
                                                $dataDetail = DetailCollaboratorsJobs::find($itemChild['id']);
                                                if ($dataDetail) {
                                                    if ($itemChild['type'] === 'delete') {
                                                        $dataDetail->delete();
                                                    } else {
                                                        $dataDetail->ngay_phien_dich = @$itemChild['ngay_phien_dich'];
                                                        $dataDetail->gio_phien_dich = @$itemChild['gio_phien_dich'];
                                                        $dataDetail->gio_ket_thuc = @$itemChild['gio_ket_thuc'];
                                                        $dataDetail->gio_tang_ca = @$itemChild['gio_tang_ca'];
                                                        $dataDetail->note = @$itemChild['note'];
                                                        $dataDetail->phi_phien_dich = @$itemChild['phi_phien_dich'];
                                                        $dataDetail->phi_giao_thong = @$itemChild['phi_giao_thong'];
                                                        // $dataDetail->file_bao_cao = @$itemChild['file_bao_cao'];
                                                        $dataDetail->file_hoa_don = @$itemChild['file_hoa_don'];
                                                        $dataDetail->company_id = $data->id;
                                                        $dataDetail->save();
                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                            }
                        }

                    }
                }
                if ($request->jobsSale && count($request->jobsSale)  > 0  ) {
                    foreach ($request->jobsSale as $item) {

                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new CtvJobsJoin();
                                $dataBank->jobs_id = $data->id;
                                $dataBank->ctv_jobs_id = $item['ctv_jobs_id'];
                                $dataBank->price_total = $item['price_total'];
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                $dataBank->payplace = @$item['payplace'] ? $item['payplace']  :  0;
                                $dataBank->save();

                            }
                        } else {
                            $dataBank = CtvJobsJoin::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                } else {
                                    $dataBank->price_total = $item['price_total'];
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }

                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                    $dataBank->payplace = @$item['payplace'] ? $item['payplace']  :  0;
                                    $dataBank->save();

                                }
                            }
                        }

                    }
                }

                if ($request->jobsCustomer && count($request->jobsCustomer)  > 0  ) {
                    foreach ($request->jobsCustomer as $item) {

                        if ($item['id'] === 'new') {
                            if ($item['type'] !== 'delete') {
                                $dataBank = new CusJobsJoin();
                                $dataBank->jobs_id = $data->id;
                                $dataBank->cus_jobs_id = $item['cus_jobs_id'];
                                $dataBank->price_total = $item['price_total'];
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
                                $dataBank->save();

                            }
                        } else {
                            $dataBank = CusJobsJoin::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                } else {
                                    $dataBank->price_total = $item['price_total'];
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }

                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = $item['phi_chuyen_khoan'];
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
                
                return redirect('/admin/projectview/'.$data->id);
            } catch (Exception $e) {

                echo "<pre>";
                print_r($e->getMessage());die;
                $message = [
                    "message" => "Có lỗi xảy ra khi thay đổi vào dữ liệu.",
                    "status" => 2
                ];
            }

        }
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
                $item->phi_giao_thong_total += $value->phi_giao_thong;
                $item->phi_phien_dich_total += $value->phi_phien_dich;
                $priceMove += $value->phi_giao_thong;
                $ctvPrice += $value->phi_phien_dich;
            }
			$item->thue_phien_dich_total = floor($item->phi_phien_dich_total * $data->percent_vat_ctvpd / 100);
            unset($value);
            if ($data->loai_job != 2) {
                $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan + $item->thue_phien_dich_total;
            }
            $priceSend = $item->phi_chuyen_khoan;
        }

        $dataSales = CtvJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataSales as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan + $item->thue_phien_dich_total;
        }

        $dataCustomer = CusJobsJoin::where('jobs_id' , $request->id)->get();
        foreach($dataCustomer as &$item) {
            $item['userInfo'] = CusJobs::where("id" , $item->cus_jobs_id)->first();
            $data->tong_chi += $item->price_total + $item->phi_chuyen_khoan + $item->thue_phien_dich_total;
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
        foreach ($allMailTemplate as &$itemMail) {
            if ($flagSendMail == 1) {

                $itemMail->cc_mail = $itemSendMail->userInfo->email;
                $itemMail->subject = str_replace("[ordernumber]",$data->codejob,$itemMail->subject);
                $itemMail->subject = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->subject);
                $itemMail->body = str_replace("[name]",$itemSendMail->userInfo->name,$itemMail->body);
                $itemMail->body = str_replace("[ordernumber]",$data->codejob,$itemMail->body);
                $itemMail->body = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->body);
                $itemMail->body = str_replace("[workcontent]", $contentPd ,$itemMail->body);
                $itemMail->body = str_replace("[workplace]",$data->address_pd,$itemMail->body);
                $itemMail->body = str_replace("[worktime]",$data->phone_nguoilienlac,$itemMail->body);
                $itemMail->body = str_replace("[othername]",$itemSendMail->userInfo->furigana,$itemMail->body);
                $itemMail->body = str_replace("[phone]",$itemSendMail->userInfo->phone,$itemMail->body);
                $itemMail->body = str_replace("[your-email]",$itemSendMail->userInfo->email,$itemMail->body);
                $itemMail->body = str_replace("[companyname]",$data->ten_nguoilienlac,$itemMail->body);
                $itemMail->body = str_replace("[place]",$data->address_pd,$itemMail->body);
                $itemMail->body = str_replace("[name_interpreter]",$itemSendMail->userInfo->name,$itemMail->body);
                // setlocale(LC_MONETARY,"ja_JP");
                $fmt = new NumberFormatter( 'ja_JP', NumberFormatter::CURRENCY );
                $itemMail->body = str_replace("[customer_totalmoney]",$fmt->formatCurrency($data->tong_thu,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[interpreter_totalmoney]",$fmt->formatCurrency(($priceMove + $priceSend + $ctvPrice),'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[interpreter_money]",$fmt->formatCurrency($ctvPrice,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[move_money]",$fmt->formatCurrency($priceMove,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[bank_money]",$fmt->formatCurrency($priceSend,'JPY'),$itemMail->body);
                $itemMail->body = str_replace("[total_money]",$fmt->formatCurrency(($data->tong_thu - $priceMove - $priceSend - $ctvPrice),'JPY'),$itemMail->body);
            }
        }
        unset($itemMail);
        return view(
            'admin.projectupdate',
            compact(['flagCustomer', 'flagSendMail', 'allMailTemplate', 'message' , 'id' ,'data' , 'dataColla' , 'allMyBank' , 'dataSales' , 'id' , 'typesList' , 'dataCustomer'])
        );
    }
}
