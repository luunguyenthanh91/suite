<?php

namespace App\Http\Controllers\Admin;
use Mail;
use App\User;
use App\Models\BankCollaborators;
use App\Models\Collaborators;
use App\Models\Company;
use App\Models\CtvJobs;
use App\Models\NationalHoliday;
use App\Models\CtvJobsJoin;
use App\Models\CollaboratorsJobs;
use App\Models\MyBank;
use App\Models\DetailCollaboratorsJobs;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    private $limit = 20;
    function index(Request $request) {
        $now = date('Y-m-d');
        $page = $request->page - 1;
        $data = Company::orderBy("company.id" , "DESC")->with('dateList')->with([
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
        
        $count = $data->count();
        $data = $data->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        foreach ($data as &$item) {
            $item->ngay_pd = explode(',',$item->ngay_pd);
        }
        unset($item);
        // echo "<pre>";
        // print_r($data);die;
        return view(
            'admin.reports.index',
            compact(['data' , 'now'])
        );

    }
    public function getCalendar(Request $request) {
        $page = $request->page - 1;
        $data = Company::orderBy("company.id" , "DESC")->with('dateList')->with([
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
        
        $count = $data->count();
        $data = $data->get();
        $count = $count === 0 ? 1 : $count;
        $pageTotal = ceil($count/$this->limit);
        foreach ($data as &$item) {
            $item->ngay_pd = explode(',',$item->ngay_pd);
        }
        unset($item);

        $data->national_holiday = NationalHoliday::orderBy("start" , "ASC")->get();

        return $data;
    }
    function calendar(Request $request) {
        $now = date('Y-m-d');
        $data = $this->getCalendar($request);
        $holidays = $data->national_holiday;

        // echo "<pre>";
        // print_r($data);die;
        return view(
            'admin.calendar',
            compact(['data' , 'now', 'holidays'])
        );
    }
    function calendarMobile(Request $request) {
        $now = date('Y-m-d');
        $data = $this->getCalendar($request);
        $holidays = $data->national_holiday;

        // echo "<pre>";
        // print_r($data);die;
        return view(
            'admin.mobile.calendar',
            compact(['data' , 'now', 'holidays'])
        );
    }
    function chart(Request $request) {
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
            $listRecords = Company::where("ngay_pd", 'Like' , "%".$yearNow . '-' . $key."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $countFlag = 0;
            foreach ($listRecords as $value) {
                $countFlag += substr_count($value->ngay_pd, $yearNow . '-' . $key); 
            }
            $yearReport[$key.'月'] = $countFlag;
        }

        

        // echo "<pre>";
        // print_r($yearReportPrice);die;
        return view(
            'admin.reports.chart',
            compact(['dayJobs' , 'yearReport' ])
        );

    }
    function chartPrice(Request $request) {
        $yearNow = date('Y');
        $yearReportPrice = [];
        for($i = 1; $i < 13 ; $i++ ) {
            $key = $i;
            if ($key < 10) {
                $key = '0'.$key;
            }
            $listRecords = Company::where("ngay_pd", 'Like' , "%".$yearNow . '-' . $key."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
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
            $list = Company::where("ngay_pd", 'Like' , "%".$key."%")->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
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

        // echo "<pre>";
        // print_r($yearReportPrice);die;
        return view(
            'admin.reports.chart-price',
            compact([ 'dayPrices' , 'yearReportPrice'])
        );

    }
    function chartPriceNew(Request $request) {
       
        $yearNow = date('Y');
        $yearReportPrice = [];
        for($i = 1; $i < 13 ; $i++ ) {
            $key = $i;
            if ($key < 10) {
                $key = '0'.$key;
            }
            $listRecords = Company::whereYear("date_company_pay", $yearNow )->whereMonth("date_company_pay", $key )->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;
            foreach ($listRecords as $itemList) {
                $total += $itemList->tong_thu_du_kien;
                $totalThu += $itemList->tong_kimduocdukien;
                $totalKimDcTT += $itemList->tong_thu;
                $totalLoiTT += ($itemList->tong_thu - $itemList->tong_chi);
            }
            if ($totalLoiTT < 0) {
                $totalLoiTT = 0;
            }
            $yearReportPrice[$key.'月'][] =  round( $total/10000, 0, PHP_ROUND_HALF_DOWN) ;
            $yearReportPrice[$key.'月'][] = round( $totalThu/10000, 0, PHP_ROUND_HALF_DOWN) ;
            $yearReportPrice[$key.'月'][] = round( $totalKimDcTT/10000, 0, PHP_ROUND_HALF_DOWN) ;
            $yearReportPrice[$key.'月'][] = round( $totalLoiTT/10000, 0, PHP_ROUND_HALF_DOWN) ;
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
            $list = Company::where("date_company_pay",  $key)->where("status",'!=' , 7)->where('ngay_pd', '>=' , '2021-03-17' )->get();
            $total = 0;
            $totalThu = 0;
            $totalKimDcTT = 0;
            $totalLoiTT = 0;
            foreach ($list as $itemList) {
                $total += $itemList->tong_thu_du_kien;
                $totalThu += $itemList->tong_kimduocdukien;
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

        // echo "<pre>";
        // print_r($yearReportPrice);die;
        return view(
            'admin.reports.chart-price-new',
            compact([ 'dayPrices' , 'yearReportPrice'])
        );

    }
}
