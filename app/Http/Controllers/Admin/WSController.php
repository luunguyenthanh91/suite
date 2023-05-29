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
use App\Models\HistoryLog;
use App\Models\WorkPartern;
use App\Models\MasterGensen;
use App\Models\NationalHoliday;
use App\Models\Payslip;
use App\Models\PayslipPartern;
use App\Models\BoPhan;
use App\Models\HistoryLogSche;
use App\Models\Bookname;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use PDF;

class WSController extends Controller
{
    private $limit = 20;
    private $mail_template_id = 15;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function addPayslip(Request $request) {
        try {
            $data = new Payslip();

            $data->status = 0;
            $data->month = $request->month;
            $data->user_id = $request->user_id;

            $listdata = $this->getListWorkDaysItem($data->user_id, $data->month);
            $daycount = $listdata['daycount'];

            $data->created_on = date('Y-m-d');
            $data->created_by = Auth::guard('admin')->user()->id;

            $employee = Admin::where('code' ,$data->user_id)->first();
            $data->payslip_partern = $employee->payslip_partern;

            $pay_partern = PayslipPartern::where('id' , $data->payslip_partern)->first();
            $data->koyouhoken_rate = $pay_partern->koyouhoken_rate;
            $data->overtime_rate = $pay_partern->overtime_rate;
            $data->jikyu = $pay_partern->jikyu;
            $data->kihonkyu = $pay_partern->kihonkyu;
            $data->tsukin_teate = $pay_partern->tsukin_teate * $daycount;

            $data->kenkouhoken = $pay_partern->kenkouhoken;
            $data->koseinenkin = $pay_partern->koseinenkin;
            $data->shotokuzei = $pay_partern->shotokuzei;
            $data->juminzei = $pay_partern->juminzei;

            $data->zangyou_teate = 0;
            $data->holiday_teate = 0;
            $data->night_teate = 0;
            if ($data->jikyu != "") {
                $worktimecount = $listdata['worktimecount'];
                list($work_h, $work_m) = explode(":", $worktimecount);
                $data->kihonkyu = round($work_h * $data->jikyu + ($work_m * $data->jikyu/60));
                
                $overworktimecount = $listdata['overworktimecount'];
                list($overtime_work_h, $overtime_work_m) = explode(":", $overworktimecount);
                $overtime_rate = $data->overtime_rate;
                $data->zangyou_teate = round($overtime_work_h * $data->jikyu * $overtime_rate + ($overtime_work_m * $data->jikyu * $overtime_rate/60));
            }

            $plus_zei_total = $data->kihonkyu + $data->zangyou_teate;
            if ($data->koyouhoken_rate != "") {
                $data->koyohoken = round(($plus_zei_total + $data->tsukin_teate) * $data->koyouhoken_rate/100);
            }
            if (!$data->shotokuzei) {
                $gensen =MasterGensen::where('range_from', '<=', $plus_zei_total)->where('range_to', '>', $plus_zei_total)->first();
                if ($gensen) {
                    $fuyo_number = $employee->fuyo_number;
                    if ($fuyo_number == 0) {
                        $data->shotokuzei = $gensen->value_0;
                    }
                    else if ($fuyo_number == 1) {
                        $data->shotokuzei = $gensen->value_1;
                    }
                    else if ($fuyo_number == 2) {
                        $data->shotokuzei = $gensen->value_2;
                    }
                    else if ($fuyo_number == 3) {
                        $data->shotokuzei = $gensen->value_3;
                    }
                    else if ($fuyo_number == 4) {
                        $data->shotokuzei = $gensen->value_4;
                    }
                    else if ($fuyo_number == 5) {
                        $data->shotokuzei = $gensen->value_5;
                    }
                    else if ($fuyo_number == 6) {
                        $data->shotokuzei = $gensen->value_6;
                    }
                    else if ($fuyo_number == 7) {
                        $data->shotokuzei = $gensen->value_7;
                    }
                }
            }
            
            list($year, $month) = explode("-", $data->month);
            $date = date('Y-m-d', strtotime('+1 month', strtotime(
                $year . "-" . $month . "-" . str_pad(10, 2, '0', STR_PAD_LEFT)
            )));
            while (true) {
                $timestamp = strtotime($date);
                $w_date = date('w', $timestamp);
                $offDay = NationalHoliday::where('start', $date)->first();
                if ($offDay || $w_date==6 || $w_date==0) {
                    $date = date('Y-m-d', strtotime('-1 day', strtotime($date)));
                    continue;
                }
                break;
            }
            $data->pay_day = $date;

            $data->save();
            
            return redirect('/admin/payslip-view/'.$data->id);
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die;
        }
    }

    function updatePayslip(Request $request,$id) {
        if ($request->isMethod('post')) {
            $data = Payslip::find($request->id);
            if ($data) {
                $data->month = $request->month;
                $data->user_id = $request->user_id;
                $data->note = $request->note;

                $data->kihonkyu = $request->kihonkyu;
                $data->zangyou_teate = $request->zangyou_teate;
                $data->tsukin_teate = $request->tsukin_teate;

                $data->kenkouhoken = $request->kenkouhoken;
                $data->koseinenkin = $request->koseinenkin;
                $data->koyohoken = $request->koyohoken;
                $data->shotokuzei = $request->shotokuzei;
                $data->juminzei = $request->juminzei;
                $data->nenmatsuchosei = $request->nenmatsuchosei;

                $data->save();
            }
            return redirect('/admin/payslip-view/'.$data->id);
        }

        $data = Payslip::find($request->id);
        return view('admin.payslip-update', compact(['data' , 'id']));
    }
   
    function Payslipsubmit(Request $request,$id) {
        try {
            $data = Payslip::find($request->id);
            if ($data) {
                $data->submited_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->submited_on = date('Y-m-d');
                $data->status = 1;
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

    function Payslipcheck(Request $request,$id) {
        try {
            $data = Payslip::find($request->id);
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

    function Payslipapprove(Request $request,$id) {
        try {
            $data = Payslip::find($request->id);
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

    function payslipreceive(Request $request,$id) {
        try {
            $data = Payslip::find($request->id);
            if ($data) {
                $data->received_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->received_on = date('Y-m-d');
                $data->status = 4;
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

    function deletePayslip(Request $request,$id) {
        $data = Payslip::find($id);
        $data->delete();
        return response()->json([]);
    }

    function getPayslip($data) {
        $employee = Admin::where('code' ,$data->user_id)->first();
        $data->employee_name = $employee->name;
        $data->employee_code = $employee->code;
        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $data->employee_depname = $bophan->name;
        
        $data->plus_zei_total = $data->kihonkyu + $data->zangyou_teate;
        $data->plus_nozei_total = $data->tsukin_teate;
        $data->plus_total = $data->plus_zei_total + $data->plus_nozei_total;

        $data->shakaihoken = $data->kenkouhoken + $data->koseinenkin;
        $data->minus_total = $data->kenkouhoken + $data->koseinenkin + $data->koyohoken + $data->shotokuzei + $data->juminzei + $data->nenmatsuchosei;
        $data->pay_total = $data->plus_total - $data->minus_total;

        $created_user = Admin::where('id' ,$data->created_by)->first();
        if ($created_user) {
            $data->created_by_name = $created_user->name;
            $data->created_by_sign = $created_user->sign_name;
        }

        $submited_user = Admin::where('id' ,$data->submited_by)->first();
        if ($submited_user) {
            $data->submited_by_name = $submited_user->name;
            $data->submited_by_sign = $submited_user->sign_name;
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

        $sendmail_user = Admin::where('id' ,$data->sendmail_by)->first();
        if ($sendmail_user) {
            $data->sendmail_by_name = $sendmail_user->name;
            $data->sendmail_by_sign = $sendmail_user->sign_name;
        }

        $received_user = Admin::where('id' ,$data->received_by)->first();
        if ($received_user) {
            $data->received_by_name = $received_user->name;
            $data->received_by_sign = $received_user->sign_name;
        }

        list($data->month_year, $data->month_month) = explode ("-",$data->month);
        list($data->selyear, $data->selmonth, $data->seldate) = explode ("-",$data->pay_day);

        $data->classStyle = "";
        if ($data->status == 0) {
            $data->classStyle = "status2";
        } else if ($data->status == 1) {
            $data->classStyle = "status3";
        } else if ($data->status == 2) {
            $data->classStyle = "status4";
        } else if ($data->status == 3) {
            $data->classStyle = "status5";
        } else if ($data->status == 4) {
            $data->classStyle = "status6";
        }

        $sumPayslip = $this->getSumPayslip($data->user_id, $data->pay_day);
        $data->sum_pay  = $sumPayslip['sum_pay'];
        $data->sum_shakaihoken  = $sumPayslip['sum_shakaihoken'];
        $data->sum_tax  = $sumPayslip['sum_tax'];

        $listdata = $this->getListWorkDaysItem($data->user_id, $data->month);
        $data->daycount = $listdata['daycount'];
        $data->worktimecount = $listdata['worktimecount'];
        $data->overworktimecount = $listdata['overworktimecount'];

        $ws = WorkSheet::where('user_id', $data->user_id)->where('month', $data->month)->where('type', '0')->first();
        if ($ws) {
            $data->worksheet_id = $ws->id;
        }
    }

    function viewPayslip(Request $request,$id) {
        $data = Payslip::find($id);
        $this->getPayslip($data);

        return view('admin.payslip-view', compact(['data' , 'id']));
    }

    function listPayslip(Request $request) {
        return view('admin.payslip', compact([]));
    }


    function getListPayslip(Request $request) {
        $page = $request->page - 1;
        
        $data = Payslip::orderBy($this->defSortName, $this->defSortType);
        if(@$request->item_id != '' ){
			$data = $data->where('id', 'LIKE' , '%'.$request->item_id.'%' );
        }
        if(@$request->month != '' ){
			$data = $data->where('month', 'LIKE' , '%'.$request->month.'%' );
        }
        if(@$request->month_from != '' ){
			$data = $data->where('month', '>=' , $request->month );
        }
        if(@$request->month_to != '' ){
			$data = $data->where('month', '<=' , $request->month_to );
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

            $newDataJobs = Payslip::whereIn('user_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->id;
                    }
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

        $sum_tsukin_teate = 0;
        $sum_shakaihoken = 0;
        $sum_koyohoken = 0;
        $sum_shotokuzei = 0;
        foreach ($data as &$item) {
            $this->getPayslip($item);

            $sum_tsukin_teate += $item->tsukin_teate;
            $sum_shakaihoken += $item->shakaihoken;
            $sum_koyohoken += $item->koyohoken;
            $sum_shotokuzei += $item->shotokuzei;
        }

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'sum_tsukin_teate' =>$sum_tsukin_teate,
            'sum_shakaihoken' => $sum_shakaihoken,
            'sum_koyohoken' => $sum_koyohoken,
            'sum_shotokuzei' => $sum_shotokuzei,
            'pageTotal' => $pageTotal
        ]);
    }

    function addWorkSheet(Request $request) {
        try {
            $user = Auth::guard('admin')->user();
            
            $data = new WorkSheet();
            $data->work_partern = $user->work_partern;
            $data->status = 0;
            $data->month = $request->month;
            $data->type = $request->type;
            $data->user_id = $user->code;
            $data->note = $request->note;
            $data->created_on = date('Y-m-d');
            $data->created_by = $user->id;

            $data->save();

            if ($data->type == 1) {
                $workpartern = WorkPartern::where('id' ,$data->work_partern)->first();
                
                $off_hol = $workpartern->off_holiday;
                $off_sat = $workpartern->off_sat;
                $off_sun = $workpartern->off_sun;
                $off_mon = $workpartern->off_mon;
                $off_tue = $workpartern->off_tue;
                $off_wed = $workpartern->off_wed;
                $off_thu = $workpartern->off_thu;
                $off_fri = $workpartern->off_fri;
                $starttime = $workpartern->starttime;
                $endtime = $workpartern->endtime;

                list($year, $month) = explode('-', $data->month);

                $days = $this->days_in_month($month, $year);
                $week = [
                    '日', //0
                    '月', //1
                    '火', //2
                    '水', //3
                    '木', //4
                    '金', //5
                    '土', //6
                ];
                
                for($i = 1; $i <=  $days; $i++)
                {
                    $timestamp = mktime(0, 0, 0, $month, $i, $year);
                    $date = date('w', $timestamp);


                    $selDate = $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $offDay = NationalHoliday::where('start', $selDate)->first();
                    $off = (($offDay && $off_hol==1) || ($off_sat==1 && $date==6) || ($off_sun==1 && $date==0)  ||
                                ($off_mon==1 && $date==1) || 
                                ($off_tue==1 && $date==2) ||
                                ($off_wed==1 && $date==3) ||
                                ($off_thu==1 && $date==4) ||
                                ($off_fri==1 && $date==5))? true : false;

                    $time_begin = "";
                    $time_end = "";
                    if (!$off) {
                        $time_begin = $starttime;
                        $time_end = $endtime;
                    }


                    $workdate = new HistoryLogSche();
                    $workdate->date = $selDate;
                    if (!$off) {
                        $workdate->time =$time_begin;
                    }
                    $workdate->type = 1;
                    $workdate->userId = Auth::guard('admin')->user()->id;
                    $workdate->save();

                    $workdate2 = new HistoryLogSche();
                    $workdate2->date = $selDate;
                    if (!$off) {
                        $workdate2->time =$time_end;
                    }
                    $workdate2->type = 2;
                    $workdate2->userId = Auth::guard('admin')->user()->id;
                    $workdate2->save();
                }


                return redirect('/admin/worksheetsche-view/'.$data->id);
            } else {
                return redirect('/admin/worksheet-view/'.$data->id);
            }
            
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die;
        }
    }
    

    function viewWorkSheetDay(Request $request,$id) {
        $data = HistoryLog::find($id);
        $user_id = $data->userId;
        $date = $data->date;
        $time1 = $data->time;
        if ($data->time_update && $data->approved_on) {
            $time1 = $data->time_update;
        }

        $employee = Admin::where('id' ,$user_id)->first();
        $employee_name = $employee->name;
        $employee_code = $employee->code;
        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $employee_depname = $bophan->name;

        $historyLog2 = HistoryLog::where('userId' ,$user_id)->where('date' ,$date)->where('type' ,'2')->first();
        $time2 = $historyLog2->time;
        if ($historyLog2->time_update && $historyLog2->approved_on) {
            $time2 = $historyLog2->time_update;
        }

        return view('admin.worksheetday-view', compact(['id', 'data', 'employee_code', 'employee_depname', 'employee_name', 'date', 'time1', 'time2']));
    
    }

    function updateWorkSheetDay(Request $request,$id) {
        if ($request->isMethod('post')) {
            $data = HistoryLog::find($id);
            if ($data) {
                $data->note = $request->note;
                $data->save();
            }
            return redirect('/admin/worksheetday-view/'.$id);
        }

        $data = HistoryLog::find($id);
        $user_id = $data->userId;
        $date = $data->date;
        $time1 = $data->time;
        if ($data->time_update && $data->approved_on) {
            $time1 = $data->time_update;
        }

        $employee = Admin::where('id' ,$user_id)->first();
        $employee_name = $employee->name;
        $employee_code = $employee->code;
        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $employee_depname = $bophan->name;

        $historyLog2 = HistoryLog::where('userId' ,$user_id)->where('date' ,$date)->where('type' ,'2')->first();
        $time2 = $historyLog2->time;
        if ($historyLog2->time_update && $historyLog2->approved_on) {
            $time2 = $historyLog2->time_update;
        }

        return view('admin.worksheetday-update', compact(['id', 'data', 'employee_code', 'employee_depname', 'employee_name', 'date', 'time1', 'time2']));
    }

    function updateWorkSheet(Request $request,$id) {
        if ($request->isMethod('post')) {
            $data = WorkSheet::find($request->id);
            if ($data) {
                $data->note = $request->note;
                $data->save();

                if ($request->childUpdate) {
                    foreach ($request->childUpdate as $key => $value) {
                        if ($data->type == 1) {
                            $updateModelDay = HistoryLogSche::find($key);
                            if ($value['ws_type'] == 1) {
                                $updateModelDay->time = sprintf('%02d:%02d', str_pad($value['starttime_h'], 2, '0', STR_PAD_LEFT), str_pad($value['starttime_m'], 2, '0', STR_PAD_LEFT));
                            } else {
                                $updateModelDay->time = null;
                            }
                            $updateModelDay->note = $value['note'];
                            $updateModelDay->save();

                            $updateModelDay2 = HistoryLogSche::where('date' ,$updateModelDay->date)->where('type', '2')->where('userId', $updateModelDay->userId)->first();
                            if ($value['ws_type'] == 1) {
                                $updateModelDay2->time = sprintf('%02d:%02d', str_pad($value['endtime_h'], 2, '0', STR_PAD_LEFT), str_pad($value['endtime_m'], 2, '0', STR_PAD_LEFT));
                            } else {
                                $updateModelDay2->time = null;
                            }
                            $updateModelDay2->note = $value['note'];
                            $updateModelDay2->save();
                        } else {
                            $updateModelDay = HistoryLog::find($key);
                            $updateModelDay->note = $value['note'];
                            $updateModelDay->save();
                        }
                    }
                }
            }

            if ($data->type == 1) {
                return redirect('/admin/worksheetsche-view/'.$data->id);
            } else {
                return redirect('/admin/worksheet-view/'.$data->id);
            }
        }

        $data = WorkSheet::find($id);
        $this->getWorkSheet($data);

        if ($data->type == 1) {
            return view('admin.worksheetsche-update', compact(['data' , 'id']));

        } else {
            return view('admin.worksheet-update', compact(['data' , 'id']));

        }
    }
   
    function worksheetsubmit(Request $request,$id) {
        try {
            $data = WorkSheet::find($request->id);
            if ($data) {
                $data->submited_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->submited_on = date('Y-m-d');
                $data->status = 1;
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

    function worksheetcheck(Request $request,$id) {
        try {
            $data = WorkSheet::find($request->id);
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

    function worksheetapprove(Request $request,$id) {
        try {
            $data = WorkSheet::find($request->id);
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

    function getListWorkDaysItem($user_code, $selMonth, $sche=0) {
        $data = [];
        $daycount = 0;
        $worktimelist = [];
        $overworktimelist = [];
        
        $employee = Admin::where('code' ,$user_code)->first();
        $user_id = $employee->id;

        $workpartern = WorkPartern::where('id' ,$employee->work_partern)->first();
        $workpartern_timecount = $workpartern->timecount;
        $workpartern_type = $workpartern->type;
        $workpartern_starttime = $workpartern->starttime;
        $workpartern_endtime = $workpartern->endtime;
        $breaktime_min = $workpartern->breaktime_min;
        $breaktime_min2 = $workpartern->breaktime_min2;
        $off_hol = $workpartern->off_holiday;
        $off_sat = $workpartern->off_sat;
        $off_sun = $workpartern->off_sun;

        list($year, $month) = explode('-', $selMonth);

        $days = $this->days_in_month($month, $year);
        $week = [
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土', //6
          ];
        
        for($i = 1; $i <=  $days; $i++)
		{
            $breaktime = $workpartern->breaktime_count;
            $breaktime2 = $workpartern->breaktime_count2;
            $timestamp = mktime(0, 0, 0, $month, $i, $year);
            $date = date('w', $timestamp);

            $ws_type = 0;

            $starttime = "";
            $hour1 = "";
            $min1 = "";
            $sec1 = "";
            $hour2 = "";
            $min2 = "";
            $sec2 = "";
            $time_count = "";
            $overtime_count = "";
            $min_count = "";
            $offDay_title = "";
            $dayid = "";
            $note = "";

            $startdate = "";
            $selDate = $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $offDay = NationalHoliday::where('start', $selDate)->first();
            if ($offDay) {
                $offDay_title = $offDay->title;
            }

            $classStyle = "status6";
            if ($offDay) {
                $classStyle = "status6Minus";
            }

            if ($sche) {
                $historyLog = HistoryLogSche::where('userId' ,$user_id)->where('type', '1')->where('date', $selDate)->first();
                if ($historyLog) {
                    $dayid = $historyLog->id;
                    $starttime = $historyLog->time;
                    $startdate = $historyLog->date;
                    if ($starttime != "") {
                        $ws_type = 1;
                        
                        $classStyle = "";
                        if ($offDay) {
                            $classStyle = "status7Minus";
                        }
                        $daycount++;
                    }
                    $note = $historyLog->note;
                }
            } else {
                if ($workpartern_type == 1) {
                    if ($offDay && $off_hol==1) { }
                    else if ($off_sat==1 && $date==6) {}
                    else if ($off_sun==1 && $date==0) {}
                    else {
                        $starttime = $workpartern_starttime;
                        if ($starttime != "") {
                            $startdate = $selDate;
                            $ws_type = 1;
                            $classStyle = "status2";
                            $daycount++;
                        }
                    }
                } else {
                    $historyLog = HistoryLog::where('userId' ,$user_id)->where('type', '1')->where('date', $selDate)->first();
                    if ($historyLog) {
                        $dayid = $historyLog->id;
                        $starttime = $historyLog->time;
                        if ($historyLog->time_update && $historyLog->approved_on) {
                            $starttime = $historyLog->time_update;
                        }
                        $startdate = $historyLog->date;
                        if ($starttime != "") {
                            $ws_type = 1;
                            
                            $classStyle = "status2";
                            if ($offDay) {
                                $classStyle = "status2Minus";
                            }
                            $daycount++;
                        }
                        $note = $historyLog->note;
                    }
                }
            }

            $endtime = "";
            $enddate = "";

            if ($workpartern_type == 1) {
                if ($offDay && $off_hol==1) {}
                else if ($off_sat==1 && $date==6) {}
                else if ($off_sun==1 && $date==0) {}
                else {
                    $endtime = $workpartern_endtime;
                    $enddate = $selDate;
                }
            } else {
                if ($sche) {
                    $historyLog2 = HistoryLogSche::where('userId' ,$user_id)->where('type', '2')->where('date', $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT))->first();
                } else {
                    $historyLog2 = HistoryLog::where('userId' ,$user_id)->where('type', '2')->where('date', $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT))->first();
                }
            if ($historyLog2) {
                    $endtime = $historyLog2->time;
                    if ($historyLog2->time_update && $historyLog2->approved_on) {
                        $endtime = $historyLog2->time_update;
                    }
                    $enddate = $historyLog2->date;
                }
            }

            if ($ws_type == 1) {
                if ($startdate != "") {
                    list($year1, $month1, $day1) = explode('-', $startdate);
                }
                if ($starttime != "") {
                    list($hour1, $min1, $sec1) = explode(':', $starttime);
                }
                if ($enddate != "") {
                    list($year2, $month2, $day2) = explode('-', $enddate);
                }
                if ($endtime) {
                    list($hour2, $min2, $sec2) = explode(':', $endtime);
                }


                $d1 = date_create($startdate." ".sprintf('%02d:%02d:00', $hour1, $min1));
                $d2 = date_create($enddate." ".sprintf('%02d:%02d:00', $hour2, $min2));
                $diff_date = date_diff($d1, $d2);
                if ($diff_date->h > $breaktime_min2 || ($diff_date->h == $breaktime_min2 && $diff_date->i > 0)) {
                    $breaktime = $breaktime2;
                }
                if ($diff_date->h < $breaktime_min) {
                    if ($breaktime != "" && !$workpartern->is_breaktime) {
                        $breaktime = "";
                    }
                }
                if ($breaktime != "") {
                    $diff_date = $this->DiffBreaktime($diff_date->h, $diff_date->i, $breaktime);
                    list($time_count, $min_count) = explode(':', $diff_date);
                } else {
                    $time_count = $diff_date->h;
                    $min_count = $diff_date->i;
                }
               
                $overtime_count = $time_count - $workpartern_timecount;
                $worktimelist[] = $time_count.":".$min_count;
            }
            
            $starttime = "";
            if ($hour1) {
                $starttime = $hour1.":".$min1;
            }
            $endtime = "";
            if ($hour2) {
                $endtime = $hour2.":".$min2;
            }
            $time_count_str = "";
            if ($time_count) {
                $time_count_str = str_pad($time_count, 2, '0', STR_PAD_LEFT).":".str_pad($min_count, 2, '0', STR_PAD_LEFT);
            }

            $overtime_count_str = "";
            if ($overtime_count > 0 || ($overtime_count == 0 && $min_count > 0 ) ) {
                $overtime_count_str = str_pad($overtime_count, 2, '0', STR_PAD_LEFT).":".str_pad($min_count, 2, '0', STR_PAD_LEFT);
                $overworktimelist[] = $overtime_count.":".$min_count;
            }

            $breaktime_str = "";
            if ($ws_type == 1) {
                $breaktime_str = $breaktime;
            }
            
            $data[] = [
                'dayid'=>$dayid,
                'year'=>$year,
                'month'=>$month,
                'day'=>$i,
                'date'=>$week[$date],
                'ws_type'=>$ws_type,
                'starttime'=>$starttime,
                'starttime_h'=>$hour1,
                'starttime_m'=>$min1,
                'endtime'=>$endtime,
                'endtime_h'=>$hour2,
                'endtime_m'=>$min2,
                'time_count'=> $time_count_str,
                'overtime_count'=> $overtime_count_str,
                'classStyle' => $classStyle,
                'offdaytitle' => $offDay_title,
                'breaktime' => $breaktime_str,
                'note' => $note,
                'edit' => 0
            ];
		}

        $count = $days;
        $pageTotal = 1;

        return [
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal,
            'daycount' => $daycount,
            'worktimecount' => $this->CalculateTime2($worktimelist),
            'overworktimecount' => $this->CalculateTime2($overworktimelist),
        ];
    }

    function getListWorkDays(Request $request) {
        $sche = 0;
        if ($request->sche != "") {
            $sche = $request->sche;
        }
        $listdata = $this->getListWorkDaysItem($request->user_id, $request->month, $sche);

        $data = $listdata['data'];
        $count = $listdata['count'];
        $pageTotal = $listdata['pageTotal'];
        $daycount = $listdata['daycount'];
        $worktimecount = $listdata['worktimecount'];
        $overworktimecount = $listdata['overworktimecount'];

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal,
            'daycount' => $daycount,
            'worktimecount' => $worktimecount,
            'overworktimecount' => $overworktimecount,
        ]);
    }

    function getSumPayslip($user_code, $pay_day) {
        $sum_pay = 0;
        $sum_shakaihoken = 0;
        $sum_tax = 0;

        list($selYear, $selMonth, $selDay) = explode ("-", $pay_day);
        $firstMonth = $selYear."-01-01";
        $datalist = Payslip::where('user_id', $user_code)->where('pay_day', '<=', $pay_day)->where('pay_day', '>=', $firstMonth)->get();
        foreach ( $datalist as $data) {
            $pay_partern = PayslipPartern::where('id' , $data->payslip_partern)->first();
            $data->kihonkyu = $pay_partern->kihonkyu;
            $data->jikyu = $pay_partern->jikyu;
            $data->zangyou_teate = 0;
            if ($data->jikyu != "") {
                $listdata = $this->getListWorkDaysItem($data->user_id, $data->month);
                $worktimecount = $listdata['worktimecount'];
                list($work_h, $work_m) = explode(":", $worktimecount);
                $data->kihonkyu = round($work_h * $data->jikyu + ($work_m * $data->jikyu/60));
                
                $overworktimecount = $listdata['overworktimecount'];
                list($overtime_work_h, $overtime_work_m) = explode(":", $overworktimecount);
                $overtime_rate = $pay_partern->overtime_rate;
                $data->zangyou_teate = round($overtime_work_h * $data->jikyu * $overtime_rate
                + ($overtime_work_m * $data->jikyu * $overtime_rate/60));
            }

            $sum_pay += $data->kihonkyu + $data->zangyou_teate;
            $sum_shakaihoken += $data->kenkouhoken + $data->koseinenkin + $data->koyohoken;
            $sum_tax += $data->shotokuzei;
        }

        return [
            'sum_pay' => $sum_pay,
            'sum_shakaihoken' => $sum_shakaihoken,
            'sum_tax' => $sum_tax,
        ];
    }

    public function payslippdf(Request $request, $id) {
        $data = Payslip::find($id);
        $this->getPayslip($data);
        $messageData = [];
        $messageData["email"] = "luunguyenthanh91@gmail.com";
        $messageData["title"] = "Test Aptach File";
        $messageData["body"] = "File ok";
        $pdf = PDF::loadView('admin.payslip-pdf', compact('data'));
        // Mail::send('mails.mail-paypal', $messageData, function($message)use($messageData, $pdf) {
        //     $message->to($messageData["email"], $messageData["email"])
        //             ->subject($messageData["title"])
        //             ->attachData($pdf->output(), "hoadon".time().".pdf");
        // });
        $filename = trans('label.payslip_id').$data->id.'_'.$data->month.'_'.$data->user_id.'('.$data->employee_name.')'.'.pdf';
        return $pdf->download($filename);
    }

    public function sendmailpayslip(Request $request, $id) {
        $data = Payslip::find($id);
        $data->sendmail_by = strtoupper(Auth::guard('admin')->user()->id);
        $data->sendmail_on = date('Y-m-d');
        $data->save();

        $this->getPayslip($data);

        $messageData = [];

        $employee = Admin::where('code' ,$data->user_id)->first();
        $email = $employee->email;

        list($year, $month) = explode("-", $data->month);
        list($year2, $month2, $date2) = explode("-", $data->pay_day);

        $messageData["email"] = $email;
        $messageData["title"] = $year.trans('label.year').$month.trans('label.month')."度給与明細発行通知";
        $messageData["employee_name"] = $data->employee_name;
        $messageData["pay_day"] = $year2.trans('label.year').$month2.trans('label.month').$date2.trans('label.date');
        
        $pdf = PDF::loadView('admin.payslip-pdf', compact('data'));
        $filename = trans('label.payslip_id').$data->id.'_'.$data->month.'_'.$data->user_id.'('.$data->employee_name.')'.'.pdf';

        Mail::send('mails.mail-paypal', $messageData, function($message)use($messageData, $pdf, $filename) {
            $message->to($messageData["email"], $messageData["email"])
                    ->subject($messageData["title"])
                    ->attachData($pdf->output(), $filename);
        });
        
        return response()->json([]);
    }

    public function sendmailpayslipcheck(Request $request, $id) {
        $data = Payslip::find($id);
        $this->getPayslip($data);

        $messageData = [];

        $employee = Admin::where('code' ,$data->user_id)->first();
        $email = $employee->email;
        list($year2, $month2, $date2) = explode("-", $data->pay_day);

        $messageData["email"] = $email;
        $messageData["title"] = "給与入金確認をお願いします。";
        $messageData["employee_name"] = $data->employee_name;
        $messageData["url"] = "https://workspace.alphacep.co.jp/admin/payslip-view/".$data->id;
        $messageData["pay_day"] = $year2.trans('label.year').$month2.trans('label.month').$date2.trans('label.date');
        

        Mail::send('mails.mail-paypal-check', $messageData, function($message)use($messageData) {
            $message->to($messageData["email"], $messageData["email"])
                    ->subject($messageData["title"]);
        });
        
        return response()->json([]);
    }

    public function worksheetpdf(Request $request, $id) {
        $data = [];
        $daycount = 0;
        $worktimelist = [];
        $overworktimelist = [];

        $ws = WorkSheet::find($id);
        $sche = ($ws->type == 1)? 1 : 0;
        $employee = Admin::where('code' ,$ws->user_id)->first();
        $user_id = $employee->id;
        $ws_note = $ws->note;

        $workpartern = WorkPartern::where('id' ,$ws->work_partern)->first();
        $workpartern_timecount = $workpartern->timecount;
        $workpartern_type = $workpartern->type;
        $workpartern_starttime = $workpartern->starttime;
        $workpartern_endtime = $workpartern->endtime;
        $breaktime_min = $workpartern->breaktime_min;
        $breaktime_min2 = $workpartern->breaktime_min2;
        $off_hol = $workpartern->off_holiday;
        $off_sat = $workpartern->off_sat;
        $off_sun = $workpartern->off_sun;

        $selMonth = $ws->month;
        list($year, $month) = explode('-', $selMonth);

        $days = $this->days_in_month($month, $year);
        $week = [
            '日', //0
            '月', //1
            '火', //2
            '水', //3
            '木', //4
            '金', //5
            '土', //6
          ];
        
        for($i = 1; $i <=  $days; $i++)
		{
            $breaktime = $workpartern->breaktime_count;
            $breaktime2 = $workpartern->breaktime_count2;
            $timestamp = mktime(0, 0, 0, $month, $i, $year);
            $date = date('w', $timestamp);

            $ws_type = 0;

            $starttime = "";
            $hour1 = "";
            $min1 = "";
            $sec1 = "";
            $hour2 = "";
            $min2 = "";
            $sec2 = "";
            $time_count = "";
            $overtime_count = "";
            $min_count = "";
            $offDay_title = "";
            $note = "";

            $startdate = "";
            $selDate = $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
            $offDay = NationalHoliday::where('start', $selDate)->first();
            if ($offDay) {
                $offDay_title = $offDay->title;
            }

            $classStyle = "status6";
            if ($offDay) {
                $classStyle = "status6Minus";
            }

            if ($sche) {
                $historyLog = HistoryLogSche::where('userId' ,$user_id)->where('type', '1')->where('date', $selDate)->first();
                if ($historyLog) {
                    $starttime = $historyLog->time;
                    $startdate = $historyLog->date;
                    if ($starttime != "") {
                        $ws_type = 1;
                        $classStyle = "status2";
                        if ($offDay) {
                            $classStyle = "status2Minus";
                        }
                        $daycount++;
                    }
                    $note = $historyLog->note;
                }
            } else {
                if ($workpartern_type == 1) {
                    if ($offDay && $off_hol==1) { }
                    else if ($off_sat==1 && $date==6) {}
                    else if ($off_sun==1 && $date==0) {}
                    else {
                        $starttime = $workpartern_starttime;
                        if ($starttime != "") {
                            $startdate = $selDate;
                            $ws_type = 1;
                            $classStyle = "status2";
                            $daycount++;
                        }
                    }
                } else {
                    $historyLog = HistoryLog::where('userId' ,$user_id)->where('type', '1')->where('date', $selDate)->first();
                    if ($historyLog) {
                        $starttime = $historyLog->time;
                        if ($historyLog->time_update && $historyLog->approved_on) {
                            $starttime = $historyLog->time_update;
                        }
                        $startdate = $historyLog->date;
                        if ($starttime != "") {
                            $ws_type = 1;
                            $classStyle = "status2";
                            if ($offDay) {
                                $classStyle = "status2Minus";
                            }
                            $daycount++;
                        }
                        $note = $historyLog->note;
                    }
                }
            }

            $endtime = "";
            $enddate = "";

            if ($workpartern_type == 1) {
                if ($offDay && $off_hol==1) {}
                else if ($off_sat==1 && $date==6) {}
                else if ($off_sun==1 && $date==0) {}
                else {
                    $endtime = $workpartern_endtime;
                    $enddate = $selDate;
                }
            } else {
                if ($sche) {
                    $historyLog2 = HistoryLogSche::where('userId' ,$user_id)->where('type', '2')->where('date', $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT))->first();
                } else {
                    $historyLog2 = HistoryLog::where('userId' ,$user_id)->where('type', '2')->where('date', $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT))->first();

                }
                if ($historyLog2) {
                    $endtime = $historyLog2->time;
                    if ($historyLog2->time_update && $historyLog2->approved_on) {
                        $endtime = $historyLog2->time_update;
                    }
                    $enddate = $historyLog2->date;
                }
            }

            if ($ws_type == 1) {

                list($year1, $month1, $day1) = explode('-', $startdate);
                list($hour1, $min1, $sec1) = explode(':', $starttime);
                list($year2, $month2, $day2) = explode('-', $enddate);
                list($hour2, $min2, $sec2) = explode(':', $endtime);

                $d1 = date_create($startdate." ".sprintf('%02d:%02d:00', $hour1, $min1));
                $d2 = date_create($enddate." ".sprintf('%02d:%02d:00', $hour2, $min2));
                $diff_date = date_diff($d1, $d2);
                if ($diff_date->h > $breaktime_min2 || ($diff_date->h == $breaktime_min2 && $diff_date->i > 0)) {
                    $breaktime = $breaktime2;
                }
                if ($diff_date->h < $breaktime_min) {
                    if ($breaktime != "" && !$workpartern->is_breaktime) {
                        $breaktime = "";
                    }
                }
                if ($breaktime != "") {
                    $diff_date = $this->DiffBreaktime($diff_date->h, $diff_date->i, $breaktime);
                    list($time_count, $min_count) = explode(':', $diff_date);
                } else {
                    $time_count = $diff_date->h;
                    $min_count = $diff_date->i;
                }
                
                $overtime_count = $time_count - $workpartern_timecount;
                $worktimelist[] = $time_count.":".$min_count;
            }
            
            $starttime = "";
            if ($hour1) {
                $starttime = $hour1.":".$min1;
            }
            $endtime = "";
            if ($hour2) {
                $endtime = $hour2.":".$min2;
            }
            $time_count_str = "";
            if ($time_count) {
                $time_count_str = str_pad($time_count, 2, '0', STR_PAD_LEFT).":".str_pad($min_count, 2, '0', STR_PAD_LEFT);
            }

            $overtime_count_str = "";
            if ($overtime_count > 0 || ($overtime_count == 0 && $min_count > 0 ) ) {
                $overtime_count_str = str_pad($overtime_count, 2, '0', STR_PAD_LEFT).":".str_pad($min_count, 2, '0', STR_PAD_LEFT);
                $overworktimelist[] = $overtime_count.":".$min_count;
            }
            
            $breaktime_str = "";
            if ($ws_type == 1) {
                $breaktime2 = "";
                if ($breaktime != "") {
                    list($breaktime_hour, $breaktime_minute) = explode(':', $breaktime);
                    $breaktime2 = sprintf('%02d:%02d', $breaktime_hour, $breaktime_minute);
                } else {
                    $breaktime2 = sprintf('%02d:%02d', 0, 0);
                }
                $breaktime_str = $breaktime2;
            }
            
            $data[] = [
                'year'=>$year,
                'month'=>$month,
                'day'=>$i,
                'date'=>$week[$date],
                'datenumber'=>$date,
                'ws_type'=>$ws_type,
                'starttime'=>$starttime,
                'endtime'=>$endtime,
                'time_count'=> $time_count_str,
                'overtime_count'=> $overtime_count_str,
                'classStyle' => $classStyle,
                'offdaytitle' => $offDay_title,
                'breaktime' => $breaktime_str,
                'note' => $note,
            ];
		}
       
        list($selyear, $selmonth) = explode("-",$ws->month);
        list($year, $month, $day) = explode("-",$ws->created_on);
        
        $employee_name = $employee->name;
        $employee_code = $employee->code;

        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $employee_depname = $bophan->name;

        $submited_by_sign = "";
        $submited_user = Admin::where('id' ,$ws->submited_by)->first();
        if ($submited_user) {
            $submited_by_sign = $submited_user->sign_name;
        }

        $checked_by_sign = "";
        $checked_user = Admin::where('id' ,$ws->checked_by)->first();
        if ($checked_user) {
            $checked_by_sign = $checked_user->sign_name;
        }

        $approved_by_sign = "";
        $approved_user = Admin::where('id' ,$ws->approved_by)->first();
        if ($approved_user) {
            $approved_by_sign = $approved_user->sign_name;
        }

        $filename_pre = ($sche)? trans('label.worksheetsche') : trans('label.worksheet');
        $filename = $filename_pre.'_'.$ws->month.'_'.$ws->user_id.'('.$employee_name.')'.'.pdf';
        

        $worktimecount = $this->CalculateTime2($worktimelist);
        $overworktimecount = $this->CalculateTime2($overworktimelist);

        $viewname = ($sche)? 'admin.worksheetsche-pdf': 'admin.worksheet-pdf';
        $pdf = PDF::loadView($viewname,
            compact('data', 'ws_note', 'id','submited_by_sign', 'checked_by_sign', 'approved_by_sign', 'selyear', 'selmonth', 'employee_depname', 'employee_name', 'employee_code', 'year', 'month', 'day','daycount','worktimecount','overworktimecount'));

        return $pdf->download($filename.'.pdf');
    }


    function deleteWorkSheet(Request $request,$id) {
        $data = WorkSheet::find($id);
        $data->delete();
        return response()->json([]);
    }

    function viewWorkSheet(Request $request,$id) {
        $data = WorkSheet::find($id);
        $this->getWorkSheet($data);

        if ($data->type == 1) {
            return view('admin.worksheetsche-view', compact(['data' , 'id']));
        } else {

            return view('admin.worksheet-view', compact(['data' , 'id']));
        }
    }

    function listWorkSheet(Request $request) {
        return view('admin.worksheet', compact([]));
    }

    function listWorkSheetSche(Request $request) {
        return view('admin.worksheetsche', compact([]));
    }

    public function days_in_month($month, $year) {
        // calculate number of days in a month
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function CalculateTime($times) {
        if (sizeof($times)==0) return "";
        
        $i = 0;
        foreach ($times as $time) {
            $hour = $time->h;
            $min = $time->i;
            $i += $hour * 60 + $min;
        }

        if($h = floor($i / 60)) {
            $i %= 60;
        }

        return sprintf('%02d:%02d', $h, $i);
    }

    public function DiffBreaktime($hour, $min, $breaktime) {
        $time_val = $hour * 60 + $min;

        list($hour_breaktime, $min_breaktime) = explode(":", $breaktime);
        $breaktime_val = $hour_breaktime * 60 + $min_breaktime;

        $time_val = $time_val - $breaktime_val;

        if($h = floor($time_val / 60)) {
            $time_val %= 60;
        }

        return sprintf('%02d:%02d', $h, $time_val);
    }

    public function CalculateTime2($times) {
        if (sizeof($times)==0) return "00:00";

        $i = 0;
        foreach ($times as $time) {
            list($hour, $min) = explode(":", $time);
            $i += $hour * 60 + $min;
        }

        if($h = floor($i / 60)) {
            $i %= 60;
        }

        return sprintf('%02d:%02d', $h, $i);
    }

    function getWorkSheet($item) {
        $user_code = $item->user_id;
        $month = $item->month;

        $item->classStyle = "";
        if ($item->status == 0) {
            $item->classStyle = "status2";
        } else if ($item->status == 1) {
            $item->classStyle = "status3";
        } else if ($item->status == 2) {
            $item->classStyle = "status4";
        } else if ($item->status == 3) {
            $item->classStyle = "status6";
        }

        $employee = Admin::where('code' ,$user_code)->first();
        $item->employee_name = $employee->name;
        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $item->employee_depname = $bophan->name;

        $sche = ($item->type == 1)? 1 : 0;
        $listdata = $this->getListWorkDaysItem($user_code, $month, $sche);

        $item->daycount = $listdata['daycount'];
        $item->worktimecount = $listdata['worktimecount'];
        $item->overworktimecount = $listdata['overworktimecount'];

        $created_user = Admin::where('id' ,$item->created_by)->first();
        if ($created_user) {
            $item->created_by_name = $created_user->name;
            $item->created_by_sign = $created_user->sign_name;
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
        if(@$request->type != '' ){
			$data = $data->where('type', $request->type );
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

            $newDataJobs = WorkSheet::whereIn('user_id',$listIdIn)->get();
            $listCompany = [];
            if($newDataJobs) {
                foreach($newDataJobs as $item) {
                    if (!in_array($item->jobs_id,$listCompany)) {
                        $listCompany[] = $item->id;
                    }
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
            $this->getWorkSheet($item);
        }

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }
}
