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
use Helper;
use App\Models\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;


use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CollaboratorsExport;

class ProjectController extends Controller
{
    private $limit = 20;
    private $defSortName = "company.id";
    private $defSortType = "DESC";    

    function deletePO(Request $request,$id) {
        $data = MailPo::find($id);
        $data->delete();
        return response()->json(['message'=>"Xóa Cộng Tác Viên Thành Công."]);
    }

    function viewPO(Request $request,$id) {
        $data = MailPo::find($request->id);
        return view(
            'admin.po-view',
            compact(['data' , 'id'])
        );
    }

    function listPO(Request $request) {
        return view(
            'admin.po',
            compact([])
        );
    }

    function addProjectByPO(Request $request,$id) {
        try {
            $data_po = MailPo::find($id);

            $list_ngay_pd = explode(',',$data_po->ngay_pd);
            $day_count = count($list_ngay_pd) ;
            $tienphiendich = $data_po->price / $day_count;
            $address_pd = $data_po->address_pd;
            $description = $data_po->note;

            $comma = '';
            $newid = '';
            foreach($list_ngay_pd as $ngay_pd) {
                $data = new Company();
                $data->ngay_pd = $ngay_pd;
                $data->address_pd = $address_pd;
                $data->tienphiendich = $tienphiendich;
                $data->description = $description;
                $data->po_id = $data_po->id;
                $data->date_start = date("Y-m-d");
                $data->created_at = date('Y-m-d H:i:s');
                $data->creator = strtoupper(Auth::guard('admin')->user()->sign_name);
                $data->save();

                $data_po->project_id = $data_po->project_id . $comma . $data->id;
                $comma = ",";
                $newid = $data->id;
            }
            $data_po->status = 1;
            $data_po->save();

            return redirect('/admin/projectview/'.$newid);

        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());die;
        }
    }

    function getViewProjectOnlyFee(Request $request) {
        
        return view(
            'admin.project-onlyfee',
            compact([])
        );
    }

    function getViewProjectNormal(Request $request) {
        return view(
            'admin.project-normal',
            compact([])
        );
    }

    function getViewProject(Request $request) {
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
            return redirect('/admin/mobile');
        }
        return view(
            'admin.project',
            compact([])
        );
    }


    function getViewProjectMobile(Request $request) {
        return view(
            'admin.mobile.project',
            compact([])
        );
    }

    public function days_in_month($month, $year) {
        // calculate number of days in a month
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function searchProject(Request $request) {
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
            $data = $data->where('address', 'like', '%'.$request->name.'%')
            ->orWhere('title_jobs', 'like', '%'.$request->name.'%');
        }
        if(@$request->project_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->project_id.'%' );
        }
        if(@$request->thang_phien_dich != '' ){
			$data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->thang_phien_dich.'%' );
        }
        if(@$request->ngay_phien_dich != '' ){
            $data = $data->where('company.ngay_pd', 'LIKE' , '%'.$request->ngay_phien_dich.'%' );
        }
        if(@$request->ngay_phien_dich_from != '' ){
            $data = $data->where('company.ngay_pd', '>=' , $request->ngay_phien_dich_from );
        }
        if(@$request->ngay_phien_dich_to != '' ){
            $data = $data->where('company.ngay_pd', '<=' , $request->ngay_phien_dich_to );
        }
        if(@$request->date_start_month != '' ){
			$data = $data->where('company.date_start', 'LIKE' , '%'.$request->date_start_month.'%' );
        }
        if(@$request->date_start != '' ){
            $data = $data->where('company.date_start', $request->date_start );
        }
        if(@$request->date_start_from != '' ){
			$data = $data->where('company.date_start', '>=' , $request->date_start_month );
        }
        if(@$request->date_start_to != '' ){
			$data = $data->where('company.date_start', '<=' , $request->date_start_to );
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
        if(@$request->type_trans_multi != '' ){
            $data = $data->whereIn('company.type_trans', explode(',', $request->type_trans_multi) );
        }
        if(@$request->type_lang_multi != '' ){
            $data = $data->whereIn('company.type_lang', explode(',', $request->type_lang_multi) );
        }
        if (@$request->check_deposit_status == '0') {
            $data = $data->where('company.status_bank','0' );
        }
        if (@$request->check_deposit_status == '1') {
            $data = $data->where('company.status_bank','1' );
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
        if(@$request->ctv_pd_id != '' ){
            $newData = Collaborators::where('id',$request->ctv_pd_id)->get();
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
        if(@$request->ctv_sale_id != '' ){
            $newData = CtvJobs::where('id',$request->ctv_sale_id)->get();
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
        if (@$request->check_pay_sale_status == '0') {
            $newDataJobs = CtvJobsJoin::where('status','0')->orWhereNull('status')->get();
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
         if (@$request->check_pay_sale_status == '1') {
            $newDataJobs = CtvJobsJoin::where('status','1')->get();
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
        if (@$request->check_cost_sale_status == '0') {
            $newDataJobs = CtvJobsJoin::where('price_total','0')->orWhereNull('price_total')->get();
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
         if (@$request->check_cost_sale_status == '1') {
            $newDataJobs = CtvJobsJoin::where('price_total','>','0')->get();
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
        if (@$request->check_cost_interpreter_status == '0') {
            $newDataJobs = CollaboratorsJobs::where('price_total','0')->orWhereNull('price_total')->get();
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
        if (@$request->check_cost_interpreter_status == '1') {
            $newDataJobs = CollaboratorsJobs::where('price_total','>','0')->get();
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
        if (@$request->check_cost_interpreter_bank_status == '0') {
            $newDataJobs = CollaboratorsJobs::where('status','0')->get();
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
        if (@$request->check_cost_interpreter_bank_status == '1') {
            $newDataJobs = CollaboratorsJobs::where('status','1')->get();
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
        if (@$request->check_cost_incometax_status == '0') {
            $newDataJobs = CollaboratorsJobs::where('price_total','0')->orWhereNull('price_total')->get();
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
        if (@$request->check_cost_incometax_status == '1') {
            $newDataJobs = CollaboratorsJobs::where('price_total','>','0')->get();
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

        if (@$request->check_pay_cost_incometax_status == '0') {
            $newDataJobs = CollaboratorsJobs::where('paytaxstatus','0')->get();
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
        if (@$request->check_pay_cost_incometax_status == '1') {
            $newDataJobs = CollaboratorsJobs::where('paytaxstatus','1')->get();
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

        if (@$request->check_cost_bankfee_status == '0') {
            $newDataJobs = CollaboratorsJobs::where('phi_chuyen_khoan','0')->orWhereNull('phi_chuyen_khoan')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }
                }
            }
            $data = $data->whereIn('id',$listCompany);

            $newDataJobs = CtvJobsJoin::where('phi_chuyen_khoan','0')->orWhereNull('phi_chuyen_khoan')->get();
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
        if (@$request->check_cost_bankfee_status == '1') {
            $newDataJobs = CollaboratorsJobs::where('phi_chuyen_khoan','>','0')->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }
                }
            }
            $newDataJobs = CtvJobsJoin::where('phi_chuyen_khoan','>','0')->get();
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->jobs_id;
                    }
                }
            }
            $data = $data->whereIn('id',$listCompany);
        }
        if (@$request->check_cost_movefee_status == '0') {
            $newData = DetailCollaboratorsJobs::where('phi_giao_thong','0')->orWhere('phi_giao_thong','')->orWhereNull('phi_giao_thong')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->collaborators_jobs_id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('id',$listIdIn)->get();
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
        if (@$request->check_cost_movefee_status == '1') {
            $newData = DetailCollaboratorsJobs::where('phi_giao_thong','>','0')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->collaborators_jobs_id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('id',$listIdIn)->get();
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
        if (@$request->check_receipt_movefee_status == '0') {
            $newData = DetailCollaboratorsJobs::where('file_hoa_don','')->orWhereNull('file_hoa_don')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->collaborators_jobs_id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('id',$listIdIn)->get();
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
        if (@$request->check_receipt_movefee_status == '1') {
            $newData = DetailCollaboratorsJobs::where('file_hoa_don','<>','')->get();
            $listIdIn = [];
            if($newData) {
                foreach($newData as $item) {
                    $listIdIn[] = $item->collaborators_jobs_id;
                }
            }

            $newDataJobs = CollaboratorsJobs::whereIn('id',$listIdIn)->get();
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
        
        if (@$request->paytaxdate != '') {
            $newDataJobs = CollaboratorsJobs::where('paytaxdate',@$request->paytaxdate)->get();
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
        if (@$request->thang_paytaxdate != '') {
            $newDataJobs = CollaboratorsJobs::where('paytaxdate','LIKE','%'.$request->thang_paytaxdate.'%')->get();
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
        if(@$request->thang_chuyen_khoan_sale != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', 'LIKE' , '%'.$request->thang_chuyen_khoan_sale.'%' )->get();
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
        if(@$request->ngay_chuyen_khoan_sale != '' ){
            $newDataJobs = CtvJobsJoin::where('ctv_jobs_join.ngay_chuyen_khoan', $request->ngay_chuyen_khoan_sale)->get();
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
        if ($showCount == 0) {
            $showCount = 1;
        }
        $data = $data->offset($page * $showCount)->limit($showCount)->get();
        $countPage = $count === 0 ? 1 : $count;
        $pageTotal = ceil($countPage/$showCount);
        $sumCost = 0;
        $sumCostSale = 0;
        $sumCostInterpreter = 0;
        $sumCostIncomeTax = 0;
        $sumCostMoveFee = 0;
        $sumCostBankFee = 0;
        $sumCostBankFeeSale = 0;
        $sumCostBankFeeInterpreter = 0;
        $sumEarning = 0;
        $sumBenefit = 0;
        $sumDeposit = 0;
        $sumTienPhienDich = 0;
        $sumTongThuDuKien = 0;
        $sumTongKimDuocDuKien = 0;

        foreach($data as &$item) {
            $in = $item->address_pd;
            $maxLength = 15;
            $item->address_pd_short = strlen($in) > $maxLength ? mb_substr($in,0,$maxLength)."..." : $in;

            $item->classStyle = "statusOther";
            if ($item->status == 7) {
                $item->classStyle = "status7";
            } else if ($item->status == 2) {
                $item->classStyle = "status2";
            } else if ($item->status == 3) {
                $item->classStyle = "status3";
            } else if ($item->status == 4) {
                $item->classStyle = "status4";
            } else if ($item->status == 5) {
                $item->classStyle = "status5";
            } else if ($item->status == 6) {
                $item->classStyle = "status6";
            } else if ($item->status== 8) {
                $item->classStyle = "status8";
            }
            if ($item->price_nhanduoc < 0) {
                $item->classStyle = $item->classStyle."Minus";
            }

            
            $sumPhiSale = 0;
            $sumPhiPhienDich = 0;
            $sumThuePhienDich = 0;
            $sumPhiGiaoThong = 0;
            $sumFileHoaDon = '';
            $sumPhiChuyenKhoan = 0;
            $sumPhiChuyenKhoanSale = 0;
            $sumPhiChuyenKhoanInterpreter = 0;
            $ctv_sales_list_name = [];
            $ctv_list_name = [];

            foreach ( $item->ctvSalesList as $ctvItem) {
                $sumPhiSale += $ctvItem->price_total;
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                    $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                }
                array_push($ctv_sales_list_name, $ctvItem->name);
            }
            $item->sumPhiSale = $sumPhiSale;
            foreach ( $item->ctvList as $ctvItem) {
                if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                    $sumPhiChuyenKhoanInterpreter += $ctvItem->phi_chuyen_khoan;
                }
                array_push($ctv_list_name, $ctvItem->name);
            }
            $item->ctv_sales_list_name = $ctv_sales_list_name;
            $item->ctv_list_name = $ctv_list_name;
            $item->sumPhiChuyenKhoan = $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanInterpreter;
            $item->sumPhiChuyenKhoanSale = $sumPhiChuyenKhoanSale;
            $item->sumPhiChuyenKhoanInterpreter = $sumPhiChuyenKhoanInterpreter;
            $sumPhiChuyenKhoan =  $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanInterpreter;

            foreach ( $item->dateList as $valueDate) {
                $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                $sumFileHoaDon = $sumFileHoaDon . $valueDate->file_hoa_don;
            }
            $item->sumPhPhienDich = $sumPhiPhienDich;
            $sumThuePhienDich = floor($item->sumPhPhienDich * $item->percent_vat_ctvpd / 100);
            $item->sumThuePhienDich = $sumThuePhienDich;
            $item->sumPhiGiaoThong = $sumPhiGiaoThong;
            $item->sumFileHoaDon = $sumFileHoaDon;

            $sumCostSale += $sumPhiSale;
            $sumCostInterpreter += $sumPhiPhienDich;
            $sumCostIncomeTax += $sumThuePhienDich;
            $sumCostMoveFee += $sumPhiGiaoThong;
            $sumCostBankFee += $sumPhiChuyenKhoan;
            $sumCostBankFeeSale += $sumPhiChuyenKhoanSale;
            $sumCostBankFeeInterpreter += $sumPhiChuyenKhoanInterpreter;
            $item->sumCostAll = $sumPhiSale + $sumPhiPhienDich + $sumThuePhienDich + $sumPhiGiaoThong + $sumPhiChuyenKhoan;
            $sumCost += $item->sumCostAll;
            $sumEarning += $item->tong_thu;
            $sumBenefit += $item->price_nhanduoc;
            $sumDeposit += $item->tong_thu;
            $sumTienPhienDich += $item->tienphiendich;
            $sumTongThuDuKien += $item->tong_thu_du_kien;
            $sumTongKimDuocDuKien += $item->tong_kimduocdukien;

            $item->ngay_pd_list = explode(',', $item->ngay_pd);
        }
        $data->count = $count;
        $data->sumData = $count;
        $data->pageTotal = $pageTotal;
        $data->sumCost = $sumCost;
        $data->sumPay = $sumCost;
        $data->sumCostSale = $sumCostSale;
        $data->sumCostInterpreter = $sumCostInterpreter;
        $data->sumCostIncomeTax = $sumCostIncomeTax;
        $data->sumCostMoveFee = $sumCostMoveFee;
        $data->sumCostBankFee = $sumCostBankFee;
        $data->sumCostBankFeeSale = $sumCostBankFeeSale;
        $data->sumCostBankFeeInterpreter = $sumCostBankFeeInterpreter;
        $data->sumEarning = $sumEarning;
        $data->sumBenefit = $sumBenefit;
        $data->sumDeposit = $sumDeposit;
        $data->sumTienPhienDich = $sumTienPhienDich;
        $data->sumTongThuDuKien = $sumTongThuDuKien;
        $data->sumTongKimDuocDuKien = $sumTongKimDuocDuKien;
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

        $ReportArea = [];
        $prefecture_array = array(
            '北海道',
            '青森県',
            '岩手県',
            '宮城県',
            '秋田県',
            '山形県',
            '福島県',
            '茨城県',
            '栃木県',
            '群馬県',
            '埼玉県',
            '千葉県',
            '東京都',
            '神奈川県',
            '新潟県',
            '富山県',
            '石川県',
            '福井県',
            '山梨県',
            '長野県',
            '岐阜県',
            '静岡県',
            '愛知県',
            '三重県',
            '滋賀県',
            '京都府',
            '大阪府',
            '兵庫県',
            '奈良県',
            '和歌山県',
            '鳥取県',
            '島根県',
            '岡山県',
            '広島県',
            '山口県',
            '徳島県',
            '香川県',
            '愛媛県',
            '高知県',
            '福岡県',
            '佐賀県',
            '長崎県',
            '熊本県',
            '大分県',
            '宮崎県',
            '鹿児島県',
            '沖縄県'
        );
        $prefecture_array2 = array_reverse($prefecture_array);
        foreach ($prefecture_array2 as $prefecture_name) {
            $listRecords = Company::where('address_pd', 'like', '%'.$prefecture_name.'%')->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $ReportArea[$prefecture_name][] = count($listRecords);
            $ReportArea[$prefecture_name][] = $prefecture_name;
        }
           

        $startYear = 2030;
        $yearNow = date('Y');

        $everyYearReportCount = [];
        for($i = 9; $i >= 0 ; $i-- ) {
            
            $days = $this->days_in_month('12', $startYear);
            $listRecords = Company::where('ngay_pd', '>=' , $startYear.'-01-01')->where('ngay_pd', '<=' , $startYear.'-12-'.$days)->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
           
            $everyYearReportCount[$startYear.'年'][] = count($listRecords);
            $everyYearReportCount[$startYear.'年'][] = $startYear;

            $startYear = $startYear - 1;
        }    

        $dayCount = [];
        $year = date('Y'); ;
        if (@$request->year != '') {
            $year = $request->year;
        }
        $thisMonth = date('m');
        $month = date('m');
        if (@$request->month != '') {
            $month = $request->month;
        }
        $days = $this->days_in_month($month, $year);
		for($i = $days; $i >=  1; $i--)
		{
			$dayCount[$year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT)] = [];
		}
        foreach ($dayCount as $key => &$item) {
            $list = Company::where("ngay_pd", 'LIKE' , '%'.$key.'%')->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $item[] = count($list);
            $item[] = $key;
        }

        $yearReportCount = [];
        for($i = 12; $i > 0 ; $i-- ) {
            $key = $i;
            if ($key < 10) {
                $key = '0'.$key;
            }
            
            $days = $this->days_in_month($i, $startYear);
            $listRecords = Company::where('ngay_pd', '>=' , $yearNow.'-'.$key.'-01')->where('ngay_pd', '<=' , $yearNow.'-'.$key.'-'.$days)->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();

            $yearReportCount[$key.'月'][] = count($listRecords);
            $yearReportCount[$key.'月'][] = $i;
        }

        $startYear = 2030;
        $everyYearReportPrice = [];
        $everyYearReportMoveFee = [];
        $everyYearReportBankFee = [];
        $everyYearReportThuePhienDich = [];
        $everyYearReportInterpreter = [];
        $everyYearReportSale = [];
        $everyYearReportCost = [];
        for($i = 9; $i >= 0 ; $i-- ) {
            $days = $this->days_in_month('12', $startYear);
            $listRecords = Company::where('ngay_pd', '>=' , $startYear.'-01-01')->where('ngay_pd', '<=' , $startYear.'-12-'.$days)->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;
            $totalMoveFee = 0;
            $totalBankFee = 0;
            $totalThuePhienDich = 0;
            $totalPhiPhienDich = 0;
            $totalPhiSale = 0;
            $totalCost = 0;
            foreach ($listRecords as $itemList) {
                $total += $itemList->tong_thu_du_kien;
                $totalThu += $itemList->tong_kimduocdukien;
                $totalKimDcTT += $itemList->tong_thu;

                $sumPhiSale = 0;
                $sumPhiPhienDich = 0;
                $sumThuePhienDich = 0;
                $sumPhiGiaoThong = 0;
                $sumPhiChuyenKhoanSale = 0;
                $sumPhiChuyenKhoanInterpreter = 0;

                $ctvSalesList = CtvJobsJoin::where('jobs_id', $itemList->id)->get();
                foreach ( $ctvSalesList as $ctvItem) {
                    $sumPhiSale += $ctvItem->price_total;
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                        $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                    }
                }
                $ctvList = CollaboratorsJobs::where('jobs_id',$itemList->id)->get();
                foreach ( $ctvList as $ctvItem) {
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                        $sumPhiChuyenKhoanInterpreter += $ctvItem->phi_chuyen_khoan;
                    }

                    $dateList = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $ctvItem->id)->get();
                    foreach ( $dateList as $valueDate) {
                        $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                        $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                    }
                    $sumThuePhienDich = floor($sumPhiPhienDich * $itemList->percent_vat_ctvpd / 100);
                }
                
                $tongLoi = ($itemList->tong_thu -  $sumPhiSale - $sumPhiPhienDich - $sumThuePhienDich - $sumPhiGiaoThong - $sumPhiChuyenKhoanSale - $sumPhiChuyenKhoanInterpreter );
                $totalLoiTT += $tongLoi;
                $totalMoveFee += $sumPhiGiaoThong;
                $totalBankFee += $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanInterpreter;
                $totalThuePhienDich += $sumThuePhienDich;
                $totalPhiPhienDich += $sumPhiPhienDich;
                $totalPhiSale += $sumPhiSale;
                $totalCost += $sumPhiSale + $sumPhiPhienDich + $sumThuePhienDich + $sumPhiGiaoThong + $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanInterpreter ;
            }
            if ($totalLoiTT < 0) {
                $totalLoiTT = 0;
            }
            $everyYearReportPrice[$startYear.'年'][] = round( $total/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportPrice[$startYear.'年'][] = round( $totalThu/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportPrice[$startYear.'年'][] = round( $totalKimDcTT/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportPrice[$startYear.'年'][] = round( $totalLoiTT/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportPrice[$startYear.'年'][] = $startYear;
            
            $everyYearReportMoveFee[$startYear.'年'][] = round( $totalMoveFee/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportMoveFee[$startYear.'年'][] = $startYear;

            $everyYearReportBankFee[$startYear.'年'][] = round( $totalBankFee/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportBankFee[$startYear.'年'][] = $startYear;

            $everyYearReportThuePhienDich[$startYear.'年'][] = round( $totalThuePhienDich/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportThuePhienDich[$startYear.'年'][] = $startYear;

            $everyYearReportInterpreter[$startYear.'年'][] = round( $totalPhiPhienDich/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportInterpreter[$startYear.'年'][] = $startYear;

            $everyYearReportSale[$startYear.'年'][] = round( $totalPhiSale/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportSale[$startYear.'年'][] = $startYear;

            $everyYearReportCost[$startYear.'年'][] = round( $totalCost/10000, 2, PHP_ROUND_HALF_DOWN) ;
            $everyYearReportCost[$startYear.'年'][] = $startYear;

            $startYear = $startYear - 1;
        }

        $yearNow = date('Y');
        $yearReportPrice = [];
        $yearReportMoveFee = [];
        $yearReportBankFee = [];
        $yearReportThuePhienDich = [];
        $yearReportInterpreter = [];
        $yearReportSale = [];
        $yearReportCost = [];
        for($i = 12; $i > 0 ; $i-- ) {
            $key = $i;
            if ($key < 10) {
                $key = '0'.$key;
            }
            $days = $this->days_in_month($i, $yearNow);
            $listRecords = Company::where('ngay_pd', '>=' , $yearNow.'-'.$key.'-01')->where('ngay_pd', '<=' , $yearNow.'-'.$key.'-'.$days)->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;
            $totalMoveFee = 0;
            $totalBankFee = 0;
            $totalThuePhienDich = 0;
            $totalPhiPhienDich = 0;
            $totalPhiSale = 0;
            $totalCost = 0;
            $totalCount = 0;
            foreach ($listRecords as $itemList) {
                $total += $itemList->tong_thu_du_kien;
                $totalThu += $itemList->tong_kimduocdukien;
                $totalKimDcTT += $itemList->tong_thu;

                $sumPhiSale = 0;
                $sumPhiPhienDich = 0;
                $sumThuePhienDich = 0;
                $sumPhiGiaoThong = 0;
                $sumPhiChuyenKhoanSale = 0;
                $sumPhiChuyenKhoanInterpreter = 0;

                $ctvSalesList = CtvJobsJoin::where('jobs_id', $itemList->id)->get();
                foreach ( $ctvSalesList as $ctvItem) {
                    $sumPhiSale += $ctvItem->price_total;
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                        $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                    }
                }
                $ctvList = CollaboratorsJobs::where('jobs_id',$itemList->id)->get();
                foreach ( $ctvList as $ctvItem) {
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                        $sumPhiChuyenKhoanInterpreter += $ctvItem->phi_chuyen_khoan;
                    }

                    $dateList = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $ctvItem->id)->get();
                    foreach ( $dateList as $valueDate) {
                        $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                        $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                    }
                    $sumThuePhienDich = floor($sumPhiPhienDich * $itemList->percent_vat_ctvpd / 100);
                }
                
                $tongLoi = ($itemList->tong_thu -  $sumPhiSale - $sumPhiPhienDich - $sumThuePhienDich - $sumPhiGiaoThong - $sumPhiChuyenKhoanSale - $sumPhiChuyenKhoanInterpreter );
                $totalLoiTT += $tongLoi;
                $totalMoveFee += $sumPhiGiaoThong;
                $totalBankFee += $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanInterpreter;
                $totalThuePhienDich += $sumThuePhienDich;
                $totalPhiPhienDich += $sumPhiPhienDich;
                $totalPhiSale += $sumPhiSale;
                $totalCost += $sumPhiSale + $sumPhiPhienDich + $sumThuePhienDich + $sumPhiGiaoThong + $sumPhiChuyenKhoanSale + $sumPhiChuyenKhoanInterpreter;
            }
            if ($totalLoiTT < 0) {
                $totalLoiTT = 0;
            }
            $yearReportPrice[$key.'月'][] = round( $total/10000, 1, PHP_ROUND_HALF_DOWN);
            $yearReportPrice[$key.'月'][] = round( $totalThu/10000, 1, PHP_ROUND_HALF_DOWN);
            $yearReportPrice[$key.'月'][] = round( $totalKimDcTT/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportPrice[$key.'月'][] = round( $totalLoiTT/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportPrice[$key.'月'][] = $i;

            $yearReportMoveFee[$key.'月'][] = round( $totalMoveFee/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportMoveFee[$key.'月'][] = $i;

            $yearReportBankFee[$key.'月'][] = round( $totalBankFee/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportBankFee[$key.'月'][] = $i;

            $yearReportThuePhienDich[$key.'月'][] = round( $totalThuePhienDich/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportThuePhienDich[$key.'月'][] = $i;

            $yearReportInterpreter[$key.'月'][] = round( $totalPhiPhienDich/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportInterpreter[$key.'月'][] = $i;

            $yearReportSale[$key.'月'][] = round( $totalPhiSale/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportSale[$key.'月'][] = $i;

            $yearReportCost[$key.'月'][] = round( $totalCost/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $yearReportCost[$key.'月'][] = $i;
        }

        $dayPrices = [];
        $year = date('Y'); ;
        if (@$request->year != '') {
            $year = $request->year;
        }
        $month = date('m');
        if (@$request->month != '') {
            $month = $request->month;
        }
        $days = $this->days_in_month($month, $year);
        $today = date("Y-m-d");
		for($i = $days; $i >=  1; $i--)
		{
            $key = $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $date1 = date($key);
            
            $list = Company::where("ngay_pd", 'LIKE' , '%'.$key.'%')->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;

            foreach ($list as $itemList) {
                $total += $itemList->tong_thu_du_kien;
                $totalThu += $itemList->tong_kimduocdukien;
                $total_day_pd = count(explode(',', $itemList->ngay_pd));
                $totalKimDcTT += ($itemList->tong_thu/$total_day_pd);

                $sumPhiSale = 0;
                $sumPhiPhienDich = 0;
                $sumThuePhienDich = 0;
                $sumPhiGiaoThong = 0;
                $sumPhiChuyenKhoanSale = 0;
                $sumPhiChuyenKhoanInterpreter = 0;

                $ctvSalesList = CtvJobsJoin::where('jobs_id', $itemList->id)->get();
                foreach ( $ctvSalesList as $ctvItem) {
                    $sumPhiSale += $ctvItem->price_total;
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                        $sumPhiChuyenKhoanSale += $ctvItem->phi_chuyen_khoan;
                    }
                }
                $ctvList = CollaboratorsJobs::where('jobs_id',$itemList->id)->get();
                foreach ( $ctvList as $ctvItem) {
                    if ($ctvItem->phi_chuyen_khoan != '' && $ctvItem->phi_chuyen_khoan > 0) {
                        $sumPhiChuyenKhoanInterpreter += $ctvItem->phi_chuyen_khoan;
                    }

                    $dateList = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $ctvItem->id)->get();
                    foreach ( $dateList as $valueDate) {
                        $sumPhiPhienDich +=  $valueDate->phi_phien_dich;
                        $sumPhiGiaoThong +=  $valueDate->phi_giao_thong;
                    }
                    $sumThuePhienDich = floor($sumPhiPhienDich * $itemList->percent_vat_ctvpd / 100);
                }
                
                $tongLoi = ($itemList->tong_thu -  $sumPhiSale - $sumPhiPhienDich - $sumThuePhienDich - $sumPhiGiaoThong - $sumPhiChuyenKhoanSale - $sumPhiChuyenKhoanInterpreter );
                $totalLoiTT += ($tongLoi/$total_day_pd);
            }
            if ($totalLoiTT < 0) {
                $totalLoiTT = 0;
            }

            $dayPrices[$key][] = round( $total/10000, 1, PHP_ROUND_HALF_DOWN);
            $dayPrices[$key][] = round( $totalThu/10000, 1, PHP_ROUND_HALF_DOWN);
            $dayPrices[$key][] = round( $totalKimDcTT/10000, 1, PHP_ROUND_HALF_DOWN) ;
            $dayPrices[$key][] = round( $totalLoiTT/10000, 1, PHP_ROUND_HALF_DOWN);
            $dayPrices[$key][] = $key;
        }

        
        $data->dayPrices = $dayPrices;
        $data->yearReportPrice = $yearReportPrice;
        $data->everyYearReportPrice = $everyYearReportPrice;
        $data->yearReportMoveFee = $yearReportMoveFee;
        $data->everyYearReportMoveFee = $everyYearReportMoveFee;
        $data->yearReportBankFee = $yearReportBankFee;
        $data->everyYearReportBankFee = $everyYearReportBankFee;
        $data->yearReportThuePhienDich = $yearReportThuePhienDich;
        $data->everyYearReportThuePhienDich = $everyYearReportThuePhienDich;
        $data->yearReportInterpreter = $yearReportInterpreter;
        $data->everyYearReportInterpreter = $everyYearReportInterpreter;
        $data->yearReportSale = $yearReportSale;
        $data->everyYearReportSale = $everyYearReportSale;
        $data->yearReportCost = $yearReportCost;
        $data->everyYearReportCost = $everyYearReportCost;
        $data->dayCount = $dayCount;
        $data->yearReportCount = $yearReportCount;
        $data->everyYearReportCount = $everyYearReportCount;
        $data->ReportArea = $ReportArea;

        unset($item);
        return $data;
    }

    function getChartEarning(Request $request) {

    }

    function dashboard(Request $request) {
        return view(
            'admin.dashboard',
            compact([])
        );
    }

    function getListProject(Request $request) {
        $data = $this->searchProject($request);

        return response()->json(['data'=>$data,'count'=>$data->count,
            'pageTotal' => $data->pageTotal, 
            'sumCost' => $data->sumCost, 
            'sumCostSale' => $data->sumCostSale, 
            'sumCostInterpreter' => $data->sumCostInterpreter, 
            'sumCostIncomeTax' => $data->sumCostIncomeTax, 
            'sumCostMoveFee' => $data->sumCostMoveFee,
            'sumCostBankFee' => $data->sumCostBankFee,
            'sumCostBankFeeSale' => $data->sumCostBankFeeSale,
            'sumCostBankFeeInterpreter' => $data->sumCostBankFeeInterpreter,
            'sumEarning' => $data->sumEarning,
            'sumBenefit' => $data->sumBenefit,
            'sumDeposit' => $data->sumDeposit,
            'sumTienPhienDich' => $data->sumTienPhienDich,
            'sumTongThuDuKien' => $data->sumTongThuDuKien,
            'sumTongKimDuocDuKien' => $data->sumTongKimDuocDuKien,
            'dayPrices' => $data->dayPrices,
            'yearReportPrice' => $data->yearReportPrice,
            'everyYearReportPrice' => $data->everyYearReportPrice,
            'yearReportMoveFee' => $data->yearReportMoveFee,
            'everyYearReportMoveFee' => $data->everyYearReportMoveFee,
            'yearReportBankFee' => $data->yearReportBankFee,
            'everyYearReportBankFee' => $data->everyYearReportBankFee,
            'yearReportThuePhienDich' => $data->yearReportThuePhienDich,
            'everyYearReportThuePhienDich' => $data->everyYearReportThuePhienDich,
            'yearReportInterpreter' => $data->yearReportInterpreter,
            'everyYearReportInterpreter' => $data->everyYearReportInterpreter,
            'yearReportSale' => $data->yearReportSale,
            'everyYearReportSale' => $data->everyYearReportSale,
            'yearReportCost' => $data->yearReportCost,
            'everyYearReportCost' => $data->everyYearReportCost,
            'dayCount' => $data->dayCount,
            'yearReportCount' => $data->yearReportCount,
            'everyYearReportCount' => $data->everyYearReportCount,
            'ReportArea' => $data->ReportArea,
        ]);
    }

    function listDeposit(Request $request) {
        return view(
            'admin.deposit',
            compact([])
        );
    }

    function listCost(Request $request) {
        return view(
            'admin.cost',
            compact([])
        );
    }

    function listCostSale(Request $request) {
        return view(
            'admin.cost-sale',
            compact([])
        );
    }

    function listCostInterpreter(Request $request) {
        return view(
            'admin.cost-interpreter',
            compact([])
        );
    }

    function listCostIncomeTax(Request $request) {
        return view(
            'admin.cost-incometax',
            compact([])
        );
    }

    function listCostMoveFee(Request $request) {
        return view(
            'admin.cost-movefee',
            compact([])
        );
    }

    function listCostBankFee(Request $request) {
        return view(
            'admin.cost-bankfee',
            compact([])
        );
    }

    public function pdfFile(Request $request, $viewName, $fileName) {
        $request->sortname = "ngay_pd";
        $request->sorttype = "ASC";
        $request->showcount = 0;
        $data = $this->searchProject($request);
        $data->file_name = $fileName;

        $pdf = PDF::loadView($viewName, compact('data'));

        return $pdf->download($fileName.'('.$data->selectedMonth.').pdf');
    }

    function pdfEarnings(Request $request) {
        return $this->pdfFile(@$request, 'admin.earnings-pdf', '売上一覧表');
    }

    function pdfDeposit(Request $request) {
        $file_name = "入金一覧表";
        if ($request->notpay == 1) {
            $file_name = "未入金一覧表";
        }        
        return $this->pdfFile(@$request, 'admin.deposit-pdf', $file_name);
    }

    function pdfCost(Request $request) {
        return $this->pdfFile(@$request, 'admin.cost-pdf', '費用一覧表');
    }

    function pdfCostSale(Request $request) {
        return $this->pdfFile(@$request, 'admin.cost-sale-pdf', '営業報酬一覧表');
    }

    function pdfCostInterpreter(Request $request) {
        $file_name = "通訳報酬一覧表";
        if ($request->notpay == 1) {
            $file_name = "通訳報酬未払い一覧表";
        }        
        return $this->pdfFile(@$request, 'admin.cost-interpreter-pdf', $file_name);
    }

    function pdfCostInterpreter2(Request $request) {
        $file_name = "通訳報酬一覧表";
        if ($request->notpay == 1) {
            $file_name = "通訳報酬未払い一覧表";
        }        
        return $this->pdfFile(@$request, 'admin.cost-interpreter-pdf2', $file_name);
    }

    function pdfCostIncomeTax(Request $request) {
        $file_name = "源泉徴収一覧表";
        if ($request->notpay == 1) {
            $file_name = "未納税一覧表";
        }        
        return $this->pdfFile(@$request, 'admin.cost-incometax-pdf', $file_name);
    }

    function pdfCostMoveFee(Request $request) {
        return $this->pdfFile(@$request, 'admin.cost-movefee-pdf', '交通費一覧表');
    }

    function pdfCostBankFee(Request $request) {
        return $this->pdfFile(@$request, 'admin.cost-bankfee-pdf', '振込手数料一覧表');
    }

    function addProject(Request $request) {
        if ($request->isMethod('post')) {
            try {
                $data = new Company();
                $data->ngay_pd = $request->ngay_pd;
                $data->address_pd = $request->address_pd;
                $data->tienphiendich = (int) Helper::decodeCurrency($request->tienphiendich);
                $data->description = $request->description;
                $data->date_start = date("Y-m-d");
                $data->created_at = date('Y-m-d H:i:s');
                $data->creator = strtoupper(Auth::guard('admin')->user()->sign_name);
                
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
        $linkReport =  base64_encode($id);
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
                $itemMail->body = str_replace("[titlecalendar]",$data->address_pd,$itemMail->body);

                $mail_ngay_pd = explode(',', $request->ngay_pd)[0];
                $parseTimeCalendar = date_create($mail_ngay_pd);
                $tomor =  date_create($mail_ngay_pd);
                date_add($tomor, date_interval_create_from_date_string('1 days'));
                $itemMail->body = str_replace("[datecalendar]",date_format($parseTimeCalendar,"Ymd").'/'.date_format($tomor,"Ymd"),$itemMail->body);
                $itemMail->body = str_replace("[noidungcalendar]",strtoupper($itemSendMail->userInfo->name),$itemMail->body);
                $itemMail->body = str_replace("[link_report]",url('/report_interpreter/'.$linkReport),$itemMail->body);
                $itemMail->cc_mail = $itemSendMail->userInfo->email;
                $itemMail->subject = str_replace("[id]",$data->id,$itemMail->subject);
                $itemMail->subject = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->subject);
                $itemMail->body = str_replace("[name]",strtoupper($itemSendMail->userInfo->name),$itemMail->body);
                $itemMail->body = str_replace("[id]",$data->id,$itemMail->body);
                $itemMail->body = str_replace("[dateinterpreter]",$data->ngay_pd,$itemMail->body);
                $itemMail->body = str_replace("[workcontent]", $contentPd ,$itemMail->body);
                $itemMail->body = str_replace("[workplace]",$data->address_pd,$itemMail->body);
                $itemMail->body = str_replace("[description]",$data->description,$itemMail->body);
                $itemMail->body = str_replace("[othername]",$itemSendMail->userInfo->furigana,$itemMail->body);
                $itemMail->body = str_replace("[phone]",$itemSendMail->userInfo->phone,$itemMail->body);
                $itemMail->body = str_replace("[your-email]",$itemSendMail->userInfo->email,$itemMail->body);
                $itemMail->body = str_replace("[place]",$data->address_pd,$itemMail->body);
                $itemMail->body = str_replace("[name_interpreter]",strtoupper($itemSendMail->userInfo->name),$itemMail->body);
                // setlocale(LC_MONETARY,"ja_JP");
                // $fmt = new NumberFormatter( 'ja_JP', NumberFormatter::CURRENCY );
                // $itemMail->body = str_replace("[customer_totalmoney]",$fmt->formatCurrency($data->tong_thu,'JPY'),$itemMail->body);
                // $itemMail->body = str_replace("[interpreter_totalmoney]",$fmt->formatCurrency(($priceMove + $priceSend + $ctvPrice),'JPY'),$itemMail->body);
                // $itemMail->body = str_replace("[interpreter_money]",$fmt->formatCurrency($ctvPrice,'JPY'),$itemMail->body);
                // $itemMail->body = str_replace("[move_money]",$fmt->formatCurrency($priceMove,'JPY'),$itemMail->body);
                // $itemMail->body = str_replace("[bank_money]",$fmt->formatCurrency($priceSend,'JPY'),$itemMail->body);
                // $itemMail->body = str_replace("[total_money]",$fmt->formatCurrency(($data->tong_thu - $priceMove - $priceSend - $ctvPrice),'JPY'),$itemMail->body);
            }
        }
        unset($itemMail);
        return view(
            'admin.projectview',
            compact(['flagCustomer', 'flagSendMail', 'allMailTemplate', 'id' ,'data' , 'dataColla' , 'allMyBank' , 'dataSales' , 'id' , 'typesList' , 'dataCustomer'])
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
                    $data->tong_thu_du_kien = (int) Helper::decodeCurrency($request->tong_thu_du_kien);
                    $data->description = $request->description;
                    $data->date_start = $request->date_start;
                    $data->total_day_pd = count(explode(',', $request->ngay_pd));
                    $data->price_giaothong = $request->price_giaothong;
                    $data->status_bank = $request->status_bank ? $request->status_bank : 0;
                    $data->loai_job = $request->loai_job;
                    $data->type_trans = $request->type_trans;
                    $data->type_lang = $request->type_lang;
                    $data->price_send_ctvpd =  (int) Helper::decodeCurrency($request->price_send_ctvpd);
                    if ($data->loai_job == 3) {
                        $data->price_send_ctvpd = 0;
                    }
                    $data->percent_vat_ctvpd = ($request->percent_vat_ctvpd)? $request->percent_vat_ctvpd : 0;
                    $data->price_vat_ctvpd = floor($data->percent_vat_ctvpd * $data->price_send_ctvpd / 100);
                    $data->price_sale = (int) Helper::decodeCurrency($request->price_sale);
                    $data->price_company_duytri = (int) Helper::decodeCurrency($request->price_company_duytri);
                    $data->tienphiendich = (int) Helper::decodeCurrency($request->tienphiendich);
                    $data->tienphiendich = str_replace(',','',$data->tienphiendich);
                    $data->tienphiendich = str_replace('￥','',$data->tienphiendich);
                    $data->typehoahong = $request->typehoahong ? $request->typehoahong : 0;
                    $data->ortherPrice = (int) Helper::decodeCurrency($request->ortherPrice);
                    $data->descriptionPrice = $request->descriptionPrice;
                    if ($data->loai_job == 1) {
                        $data->tong_kimduocdukien = $data->tong_thu_du_kien - $data->price_send_ctvpd - $data->price_vat_ctvpd - $data->price_sale - $data->price_company_duytri - $data->ortherPrice;
                    } else {
                        $data->tong_kimduocdukien = $data->tong_thu_du_kien - $data->price_sale - $data->price_company_duytri - $data->ortherPrice;
                    }
                    $data->status = $request->status;
                    $data->ngay_pd = $request->ngay_pd;
                    $data->tong_chi = $request->tong_chi;
                    $data->status_chi = $request->status_chi;
                    if($request->types){
                        $flagTypes = ',' . implode(',' , $request->types) . ',';
                        $data->type_jobs = $flagTypes;
                    } else {
                        $data->type_jobs = '';
                    }

                    $data->address_pd = $request->address_pd;
                    $data->stk_thanh_toan_id = $request->stk_thanh_toan_id;
                    $data->tong_thu = (int) Helper::decodeCurrency($request->tong_thu);
                    $data->date_company_pay = $request->date_company_pay;
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
                                // $dataBank->price_total = (int) Helper::decodeCurrency($item['price_total']);
                                $dataBank->bank_id = $item['bank_id'];
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = (int) Helper::decodeCurrency($item['phi_chuyen_khoan']);
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
                                                $dataDetail->note2 = $itemChild['note2'];
                                                $dataDetail->phi_phien_dich = $itemChild['phi_phien_dich'];
                                                $dataDetail->phi_giao_thong = $itemChild['phi_giao_thong'];
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
                                                    $dataDetail->note2 = $itemChild['note2'];
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
                                    // $dataBank->price_total = $item['price_total'];
                                    $dataBank->bank_id = $item['bank_id'];
                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = (int) Helper::decodeCurrency($item['phi_chuyen_khoan']);
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
                                                    $dataDetail->note2 = @$itemChild['note2'];
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
                                                        $dataDetail->note2 = @$itemChild['note2'];
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
                                $dataBank->price_total = (int) Helper::decodeCurrency($item['price_total']);
                                if (@$item['status']) {
                                    $dataBank->status =$item['status'];
                                } else {
                                    $dataBank->status = 0;
                                }
                                $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                $dataBank->phi_chuyen_khoan = (int) Helper::decodeCurrency($item['phi_chuyen_khoan']);
                                $dataBank->payplace = @$item['payplace'] ? $item['payplace']  :  0;
                                $dataBank->save();

                            }
                        } else {
                            $dataBank = CtvJobsJoin::find($item['id']);
                            if ($dataBank) {
                                if ($item['type'] === 'delete') {
                                    $dataBank->delete();
                                } else {
                                    $dataBank->price_total = (int) Helper::decodeCurrency($item['price_total']);
                                    if (@$item['status']) {
                                        $dataBank->status =$item['status'];
                                    } else {
                                        $dataBank->status = 0;
                                    }

                                    $dataBank->ngay_chuyen_khoan = $item['ngay_chuyen_khoan'];
                                    $dataBank->phi_chuyen_khoan = (int) Helper::decodeCurrency($item['phi_chuyen_khoan']);
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

        return view(
            'admin.projectupdate',
            compact(['message' , 'id' ,'data' , 'dataColla' , 'allMyBank' , 'dataSales' , 'id' , 'dataCustomer'])
        );
    }

    function checkProject(Request $request,$id) {
        try {
            $data = Company::find($request->id);
            if ($data) {
                $data->checker = strtoupper(Auth::guard('admin')->user()->sign_name);
                $data->checked_date = date('Y-m-d');
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

    function approveProject(Request $request,$id) {
        try {
            $data = Company::find($request->id);
            if ($data) {
                $data->approver = strtoupper(Auth::guard('admin')->user()->sign_name);
                $data->approved_date = date('Y-m-d');
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

    function deleteProject(Request $request,$id) {
        CtvJobsJoin::where('jobs_id' ,  $id)->delete();

        $dataColla = CollaboratorsJobs::where('jobs_id' , $id)->get();
        foreach($dataColla as &$item) {
            DetailCollaboratorsJobs::where("collaborators_jobs_id" , $item->id)->delete();
        }

        CollaboratorsJobs::where('jobs_id' , $id)->delete();

        $data = Company::find($id);
        $data->delete();

        return response()->json(['message'=>"Xóa Công Việc Thành Công."]);
    }

    public function parsePhone($value) {
        if (!$value) return "-";
        if (strlen($value) == 11) {
            $value = mb_substr($value,0,3) . "-" . mb_substr($value,3,4) . "-" . mb_substr($value,7,4);
        } else if (strlen($value) == 10) {
            $value = mb_substr($value,0,3) . "-" . mb_substr($value,3,4) . "-" . mb_substr($value,7,3);
        }
        return $value;
    }

    public function pdfReport(Request $request , $id, $file_name) {
        $data = Company::find($id);
        $data->year = date('Y');
        $data->month = date('m');
        $data->date = date('d');
        list($data->year_pd, $data->month_pd, $data->date_pd) = explode('-',$data->ngay_pd);

        $ctvSalesList = CtvJobsJoin::where('jobs_id', $id)->get();
        foreach($ctvSalesList as &$item) {
            $item['userInfo'] = CtvJobs::where("id" , $item->ctv_jobs_id)->first();
            $data->sale_name = strtoupper($item['userInfo']->name);
        }

        $ctvList = CollaboratorsJobs::where('jobs_id', $id)->get();
        foreach ( $ctvList as $ctvItem) {
            $item['userInfo'] = Collaborators::where("id" , $ctvItem->collaborators_id)->first();
            $data->pd_name = strtoupper($item['userInfo']->name);
            $data->pd_phone = $this->parsePhone($item['userInfo']->phone);

            $dateList = DetailCollaboratorsJobs::where("collaborators_jobs_id" , $ctvItem->id)->get();
            foreach ( $dateList as $dataDetail) {
                $data->ngay_phien_dich = $dataDetail->ngay_phien_dich;
                $data->gio_phien_dich = $dataDetail->gio_phien_dich;
                if ($data->gio_phien_dich) {
                    if (count (explode(' ',$data->gio_phien_dich)) > 1) {
                        $data->gio_phien_dich = explode(' ',$data->gio_phien_dich)[1];
                    }
                }
                $data->gio_ket_thuc = $dataDetail->gio_ket_thuc;
                if ($data->gio_ket_thuc) {
                    if (count (explode(' ',$data->gio_ket_thuc)) > 1) {
                        $data->gio_ket_thuc = explode(' ',$data->gio_ket_thuc)[1];
                    }
                }
                $data->note_pd = $dataDetail->note;
                $re = '/([\p{Katakana}\p{Hiragana}\p{Han}「」]+)/mu';
                preg_match_all($re, $data->note_pd, $matches, PREG_SET_ORDER, 0);
                if ($matches) {
                    foreach ($matches as $key => $value) {
                        $data->note_pd = str_replace($value[0], '<span class="jp-font">'.$value[0].'</span>',$data->note_pd );
                    }
                }
                $data->note_pd2 = $dataDetail->note2;
                preg_match_all($re, $data->note_pd2, $matches, PREG_SET_ORDER, 0);
                if ($matches) {
                    foreach ($matches as $key => $value) {
                        $data->note_pd2 = str_replace($value[0], '<span class="jp-font">'.$value[0].'</span>',$data->note_pd2 );
                    }
                }
            }
        }

        $pdf = PDF::loadView($file_name, compact('data'));
        return $pdf->download('報告書(受注No.'.$id.').pdf');
    }

    function pdfProjectReport(Request $request , $id) {
        return $this->pdfReport($request, $id, 'admin.project-report-pdf');
    }

    function pdfProjectReportPerson(Request $request , $id) {
        return $this->pdfReport($request, $id, 'admin.project-report-person-pdf');
    }

    function exportProjectOnlyFee(Request $request) {
        $dataReturn = [];
        $row = [];
        $row[] = 'ID';
        $row[] = '受領日';
        $row[] = '依頼人';
        $row[] = '通訳日';
        $row[] = '通訳会場';
        $row[] = '営業者';
        $row[] = '通訳者';
        $row[] = '売上金額';
        $row[] = '営業報酬';
        $row[] = '交通費等';
        $row[] = '振込手数料';
        $dataReturn[] = $row;
    
       
        $request->sortname = "ngay_pd";
        $request->sorttype = "ASC";
        $request->showcount = 0;
        $data = $this->searchProject($request);
        foreach($data as $item) {
            $row = [];
            $row[] = $item->id;
            $row[] = $item->date_company_pay;
            $row[] = '';
            $row[] = $item->ngay_pd;
            $row[] = $item->address_pd;
            $row[] = strtoupper(implode(',' , $item->ctv_sales_list_name));
            $row[] = strtoupper(implode(',' , $item->ctv_list_name));
            $row[] = $item->tong_thu;
            $row[] = $item->sumPhiSale;
            $row[] = $item->sumPhiGiaoThong;
            $row[] = $item->sumPhiChuyenKhoan;
            $dataReturn[] = $row;
        }
    
        $target_fileDownload = '通訳手配料('.date('Y-m-d').').xlsx';
    
        $export = new CollaboratorsExport($dataReturn);
        return Excel::download($export, $target_fileDownload);
    
    }

    function exportProjectNormal(Request $request) {
        $dataReturn = [];
        $row = [];
        $row[] = 'ID';
        $row[] = '受領日';
        $row[] = '依頼人';
        $row[] = '通訳日';
        $row[] = '通訳会場';
        $row[] = '営業者';
        $row[] = '通訳者';
        $row[] = '売上金額';
        $row[] = '営業報酬';
        $row[] = '通訳報酬';
        $row[] = '源泉徴収額';
        $row[] = '交通費等';
        $row[] = '振込手数料';
        $dataReturn[] = $row;
    
        
        $request->sortname = "ngay_pd";
        $request->sorttype = "ASC";
        $request->showcount = 0;
        $data = $this->searchProject($request);
        foreach($data as $item) {
            $row = [];
            $row[] = $item->id;
            $row[] = $item->date_company_pay;
            $row[] = '';
            $row[] = $item->ngay_pd;
            $row[] = $item->address_pd;
            $row[] = strtoupper(implode(',' , $item->ctv_sales_list_name));
            $row[] = strtoupper(implode(',' , $item->ctv_list_name));
            $row[] = $item->tong_thu;
            $row[] = $item->sumPhiSale;
            $row[] = $item->sumPhPhienDich;
            $row[] = '';
            $row[] = $item->sumPhiGiaoThong;
            $row[] = $item->sumPhiChuyenKhoan;
            $dataReturn[] = $row;
        }
    
        $target_fileDownload = '通訳料('.date('Y-m-d').').xlsx';
    
        $export = new CollaboratorsExport($dataReturn);
        return Excel::download($export, $target_fileDownload);
    
    }
}