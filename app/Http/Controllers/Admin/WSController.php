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
use App\Models\NationalHoliday;
use App\Models\BoPhan;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use PDF;

class WSController extends Controller
{
    private $limit = 20;
    private $mail_template_id = 15;
    private $defSortName = "id";
    private $defSortType = "DESC";

    function addWorkSheet(Request $request) {
        try {
            $data = new WorkSheet();

            $data->status = 0;
            $data->month = $request->month;
            $data->user_id = $request->user_id;
            $data->note = $request->note;
            $data->created_on = date('Y-m-d');
            $data->created_by = Auth::guard('admin')->user()->id;

            $data->save();
            
            return redirect('/admin/worksheet-view/'.$data->id);
        } catch (Exception $e) {
            echo "<pre>";
            print_r($e->getMessage());
            die;
        }
    }

    function updateWorkSheet(Request $request,$id) {
        
    }

   
    function worksheetsubmit(Request $request,$id) {
        try {
            $data = WorkSheet::find($request->id);
            if ($data) {
                $data->submited_by = strtoupper(Auth::guard('admin')->user()->id);
                $data->submited_on = date('Y-m-d');
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

    function getListWorkDays(Request $request) {
        $data = [];
        $daycount = 0;
        $worktimelist = [];
        $overworktimelist = [];

        
        $employee = Admin::where('code' ,$request->user_id)->first();
        $user_id = $employee->id;
        $workpartern = WorkPartern::where('id' ,$employee->work_partern)->first();
        $workpartern_timecount = $workpartern->timecount;

        $selMonth = $request->month;
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

            $historyLog = HistoryLog::where('userId' ,$user_id)->where('type', '1')->where('date', $selDate)->first();
            if ($historyLog) {
                $starttime = $historyLog->time;
                $startdate = $historyLog->date;
                $ws_type = 1;
                $classStyle = "status4";
                if ($offDay) {
                    $classStyle = "status4Minus";
                }
                $daycount++;
            }

            $endtime = "";
            $enddate = "";
            $historyLog2 = HistoryLog::where('userId' ,$user_id)->where('type', '2')->where('date', $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT))->first();
            if ($historyLog2) {
                $endtime = $historyLog2->time;
                $enddate = $historyLog->date;
            }

            if ($ws_type == 1) {
                list($year1, $month1, $day1) = explode('-', $startdate);
                list($hour1, $min1, $sec1) = explode(':', $starttime);
                list($year2, $month2, $day2) = explode('-', $enddate);
                list($hour2, $min2, $sec2) = explode(':', $endtime);

                $d1 = date_create($startdate." ".$starttime);
                $d2 = date_create($enddate." ".$endtime);
                $diff_date = date_diff($d1, $d2);
                $worktimelist[] = $diff_date;

                $time_count = $diff_date->h;
                $min_count = $diff_date->i;
                $overtime_count = $time_count - $workpartern_timecount;
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
                $time_count_str = $time_count.":".$min_count;
            }

            $overtime_count_str = "";
            if ($overtime_count > 0 || ($overtime_count == 0 && $min_count > 0 ) ) {
                $overtime_count_str = $overtime_count.":".$min_count;
                $overworktimelist[] = $overtime_count_str;
            }
            
            $data[] = [
                'year'=>$year,
                'month'=>$month,
                'day'=>$i,
                'date'=>$week[$date],
                'ws_type'=>$ws_type,
                'starttime'=>$starttime,
                'endtime'=>$endtime,
                'time_count'=> $time_count_str,
                'overtime_count'=> $overtime_count_str,
                'classStyle' => $classStyle,
                'offdaytitle' => $offDay_title,
                'breaktime' => '',
                'note' => ''
            ];
		}

        $count = $days;
        $pageTotal = 1;

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal,
            'daycount' => $daycount,
            'worktimecount' => $this->CalculateTime($worktimelist),
            'overworktimecount' => $this->CalculateTime2($overworktimelist),
        ]);
    }

    public function worksheetpdf(Request $request, $id) {
        $data = [];
        $daycount = 0;
        $worktimelist = [];
        $overworktimelist = [];

        $ws = WorkSheet::find($id);
        $employee = Admin::where('code' ,$ws->user_id)->first();
        $user_id = $employee->id;
        $selMonth = $ws->month;
        list($year, $month) = explode('-', $selMonth);
        $workpartern = WorkPartern::where('id' ,$employee->work_partern)->first();
        $workpartern_timecount = $workpartern->timecount;

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

            $historyLog = HistoryLog::where('userId' ,$user_id)->where('type', '1')->where('date', $selDate)->first();
            if ($historyLog) {
                $starttime = $historyLog->time;
                $startdate = $historyLog->date;
                $ws_type = 1;
                $classStyle = "status4";
                if ($offDay) {
                    $classStyle = "status4Minus";
                }
                $daycount++;
            }

            $endtime = "";
            $enddate = "";
            $historyLog2 = HistoryLog::where('userId' ,$user_id)->where('type', '2')->where('date', $year . "-" . $month . "-" . str_pad($i, 2, '0', STR_PAD_LEFT))->first();
            if ($historyLog2) {
                $endtime = $historyLog2->time;
                $enddate = $historyLog->date;
            }

            if ($ws_type == 1) {
                list($year1, $month1, $day1) = explode('-', $startdate);
                list($hour1, $min1, $sec1) = explode(':', $starttime);
                list($year2, $month2, $day2) = explode('-', $enddate);
                list($hour2, $min2, $sec2) = explode(':', $endtime);

                $d1 = date_create($startdate." ".$starttime);
                $d2 = date_create($enddate." ".$endtime);
                $diff_date = date_diff($d1, $d2);
                $worktimelist[] = $diff_date;

                $time_count = $diff_date->h;
                $min_count = $diff_date->i;
                $overtime_count = $time_count - $workpartern_timecount;
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
                $time_count_str = $time_count.":".$min_count;
            }

            $overtime_count_str = "";
            if ($overtime_count > 0 || ($overtime_count == 0 && $min_count > 0 ) ) {
                $overtime_count_str = $overtime_count.":".$min_count;
                $overworktimelist[] = $overtime_count_str;
            }
            
            $data[] = [
                'year'=>$year,
                'month'=>$month,
                'day'=>$i,
                'datenumber'=>$date,
                'date'=>$week[$date],
                'ws_type'=>$ws_type,
                'starttime'=>$starttime,
                'endtime'=>$endtime,
                'time_count'=> $time_count_str,
                'overtime_count'=> $overtime_count_str,
                'classStyle' => $classStyle,
                'offdaytitle' => $offDay_title,
                'breaktime' => '',
                'note' => ''
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

        $file_name = trans('label.worksheet')."_".$ws->month."_".$employee->name."(".$employee->code.")";
        

        $worktimecount = $this->CalculateTime($worktimelist);
        $overworktimecount = $this->CalculateTime2($overworktimelist);

        $pdf = PDF::loadView('admin.worksheet-pdf',
            compact('data', 'submited_by_sign', 'checked_by_sign', 'approved_by_sign', 'selyear', 'selmonth', 'employee_depname', 'employee_name', 'employee_code', 'year', 'month', 'day','daycount','worktimecount','overworktimecount'));

        return $pdf->download($file_name.'.pdf');
    }

    function deleteWorkSheet(Request $request,$id) {
        $data = WorkSheet::find($id);
        $data->delete();
        return response()->json([]);
    }

    function viewWorkSheet(Request $request,$id) {
        $data = WorkSheet::find($request->id);

        $employee = Admin::where('code' ,$data->user_id)->first();
        $data->employee_name = $employee->name;
        $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
        $data->employee_depname = $bophan->name;

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

        return view('admin.worksheet-view', compact(['data' , 'id']));
    }

    function listWorkSheet(Request $request) {
        return view('admin.worksheet', compact([]));
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

    public function CalculateTime2($times) {
        if (sizeof($times)==0) return "";

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
            $employee = Admin::where('code' ,$item->user_id)->first();
            $item->employee_name = $employee->name;
            $bophan = BoPhan::where('id' ,$employee->bophan_id)->first();
            $item->employee_depname = $bophan->name;

            $created_user = Admin::where('id' ,$item->created_by)->first();
            if ($created_user) {
                $item->created_by_name = $created_user->name;
            }

            $checked_user = Admin::where('id' ,$item->checked_by)->first();
            if ($checked_user) {
                $item->checked_by_name = $checked_user->name;
            }

            $approved_user = Admin::where('id' ,$item->approved_by)->first();
            if ($approved_user) {
                $item->approved_by_name = $approved_user->name;
            }
        }

        return response()->json([
            'data'=>$data,
            'count'=>$count,
            'pageTotal' => $pageTotal
        ]);
    }
}
