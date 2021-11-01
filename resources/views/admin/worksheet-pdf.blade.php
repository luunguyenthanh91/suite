<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('label.worksheet') }}</title>
</head>
<div style='float:right;'>
    <div style='position: fixed; right:0;'>
        <!-- <img width="100px" height="20px" style="margin-top:-15px;" src="{{ asset('assets/images/secretstamp.png') }}" /> -->
    </div>
</div>
<div style='float:left;'>
    <div style='position: fixed; left:0; margin-top:-15px;'>
        <!-- <div>株式会社ＡｌｐｈａＣｅｐ</div> -->
    </div>
</div>
<body>
    <div style="margin-top:10px;margin-bottom:10px; margin-left:10px;margin-right:10px;">
        
        <div style='text-align:center; vertical-align:middle; height:45px;width:100%;border-bottom:2px solid black'>
            <div style="font-size:24;"><b>{{ trans('label.worksheet2') }}</b></div>
        </div>
        <div style='text-align:right; width:100%;font-size:8pt;height:30px;margin-top:5px;'>
        <u><span style="margin-right20px;">{{ trans('label.worksheet_id') }}：</span>{{$data->id}}</u>
        </div>
        <table style="width:100%;margin-top:-25px;">
            <tr>
                <td style="text-align:left;">
                    <div class="fontweight" style='font-size:14px;text-align:left; height:19px; width:250px; border-bottom:1px solid black;margin-top:0px;'>
                    {{ trans('label.dep') }}: <b>{{$employee_depname}}</b>
                    </div>

                    <div class="fontweight" style='font-size:14px;text-align:left; height:19px; width:250px; border-bottom:1px solid black;margin-top:5px;'>
                    {{ trans('label.employee_code') }}: <b>{{$employee_code}}</b>
                    </div>

                    <div class="fontweight" style='font-size:14px;text-align:left; height:19px; width:250px; border-bottom:1px solid black;margin-top:5px;'>
                    {{ trans('label.user_name') }}: <b>{{$employee_name}}</b>
                    </div>
                    <div class="fontweight" style='text-align:left; height:19px; width:200px;margin-top:10px;'>
                    <span style="background-color:#FF8F22;color:white;font-weight: bold;">{{$selyear}} {{ trans('label.year') }} {{$selmonth}} {{ trans('label.month2') }}</span>
                    </div>
                </td>
                <td style="width:150px;">
                    <table id="customers3" style="margin-top:20px !important;"> 
                        <tr>
                            <td class="headerColor" style="border:1px solid #000;text-align:center;font-size:10.5">{{ trans('label.submit') }}</td>
                            <td class="headerColor" style="border:1px solid #000;text-align:center;font-size:10.5">{{ trans('label.check') }}</td>
                            <td class="headerColor" style="border:1px solid #000;text-align:center;font-size:10.5">{{ trans('label.approve') }}</td>
                        </tr>
                        <tr>
                            <td style="height:40px;border:1px solid #000">
                            @if ($submited_by_sign != "") 
                            <div class="circle">{{$submited_by_sign}}</div>
                            @endif
                            </td>
                            <td style="height:40px;border:1px solid #000">
                            @if ($checked_by_sign != "") 
                            <div class="circle">{{$checked_by_sign}}</div>
                            @endif
                            </td>
                            <td style="height:40px;border:1px solid #000">
                            @if ($approved_by_sign != "") 
                            <div class="circle">{{$approved_by_sign}}</div>
                            @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style='width:100%;border-collapse:collapse;margin-top:5px;font-size:10.5'>
            <tr>
                <td class="headerColor border-all title_form">{{ trans('label.datetime') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.day') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.ws') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.time_start') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.time_end') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.breaktime2') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.time_count') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.overtime_count2') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.note') }}</td>
            </tr>
            @foreach($data as $item)
            <tr>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['day'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                @if ($item['datenumber'] == 0 || $item['datenumber'] == 6) 
                    <span style="color:gray">{{ $item['date'] }}</span>
                @elseif ($item['offdaytitle'] != "")
                    <span style="color:red">{{ $item['date'] }}(祝)</span>
                @else
                    {{ $item['date'] }}
                @endif
                
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                @if ($item['ws_type'] == 1)
                {{ trans('label.work_day') }}
                @endif 
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['starttime'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['endtime'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['breaktime'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['time_count'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['overtime_count'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top">
                {{ $item['note'] }}
                </td>
            </tr>
            @endforeach    
        </table>
        <table style="width:100%;;margin-top:5px;">
            <tr>
                <td>
                    <div class="fontweight" style='text-align:left; height:60px;padding:5px;margin-right:5px;border:1px solid black;vertical-align:top;'>
                        <u>{{ trans('label.note') }}:</u>
                    </div>
                </td>
                <td style="width:200px;">
                    <table id="customers3" style="width:200px;"> 
                        <tr>
                            <td class="headerColor" style="border:1px solid #000;font-size:10.5">{{ trans('label.work_day_count') }}</td>
                            <td style="width:100%;border:1px solid #000;text-align:center;;font-size:10.5">
                            {{ $daycount }}
                            </td>
                        </tr>
                        <tr>
                            <td class="headerColor" style="border:1px solid #000;font-size:10.5">{{ trans('label.work_time_count') }}</td>
                            <td style="width:100%;border:1px solid #000;text-align:center;;font-size:10.5">
                            {{ $worktimecount }}
                            </td>
                        </tr>
                        <tr>
                            <td class="headerColor" style="border:1px solid #000;font-size:10.5">{{ trans('label.work_overtime_count') }}</td>
                            <td style="width:100%;border:1px solid #000;text-align:center;;font-size:10.5">
                            {{ $overworktimecount }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
<style>
body {
    font-family: ipag;
}
.condau {
    height : 80px;
}
.fontweight {
    font-family: ipag !important;
    /* color: #0015b1; */
}
.nameCompany {
    text-align: left;
    font-size: 18px;
    font-weight: bold;
    /* color: #0015b1; */
}
#customers {
    font-family: ipag;
  border-collapse: collapse;
  width: 100%;  
  margin-right: 30px;
  /* margin-left: -20px; */
  margin-bottom: 10px;
}

#customers td, #customers th {
  border: 0px solid #ddd;
  padding: 2px 8px;
  width : 20%;
}
#customers td.title {
    /* background: #ccc; */
    border: 1px solid #000;
}
#customers td.content {
    border: 1px solid #000;
}
#customers td.saleTitle {
    color: #000;
    font-size: 18px;
    font-weight: bold;
}
#customers tr:nth-child(even){background-color: #fff;}

#customers tr:hover {background-color: #fff;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    background-color: #fff;
    border: 0px;
    text-align: center;
    font-size: 32px;
    /* color: #3640bb; */
}
.totalTitle {
    border: 2px solid #000 !important;
    text-align: center;
}
.totalPrice{
    border: 2px solid #000 !important;
    text-align: center;
}
.border-all {
    border: 1px solid #000 !important;
}
.title_form{
    text-align: center;
    /* background: #363cda;
    color: #fff; */
    font-weight: bold;
}
.condau {
    height : 80px;
}
.headerColor {
    background-color: #FFFFF0
}

.circle {
    width: 30px;
    height: 30px;
    line-height: 22px;
    border-radius: 130%;
    font-size: 12px;
    color: red;
    text-align: center;
    /* background: red */
    border:1px solid red;
  }
  .plusRed {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0px !important;
  }
  .plusRed img {
      width: 53px;
      height: 52px;
      position: absolute;
      left: 9px;
      top: 3px;
      object-fit: cover;
      object-position: center;
  }
  .plusRed .title1 {
      position: absolute;
      left: 24px;
      top: 8px;
      color: red;
      font-size: 8px !important;
      font-family: system-ui !important;
      margin: 0px;
  } 
  .plusRed .title2 {
      position: absolute;
      left: 14px;
      top: 23px;
      color: red;
      font-size: 8px !important;
      font-family: system-ui !important;
      margin: 0px;
      width: 100%;
  } 
  .plusRed .title3 {
      position: absolute;
      left: 29px;
      top: 38px;
      color: red;
      font-size: 8px !important;
      font-family: system-ui !important;
      margin: 0px;
  } 


#customers2 {
    font-family: ipag;
  border-collapse: collapse;
  width: 100%;  
  margin-bottom: 10px;
  margin-top: 10px;
  padding: 0px;
}

#customers2 td, #customers2 th {
  border: 1px solid #000;
  padding: 2px 8px;
  width : 20%;
}
#customers2 td.title {
    /* background: #ccc; */
    border: 1px solid #000;
}
#customers2 td.content {
    border: 1px solid #000;
}
#customers2 td.saleTitle {
    color: #000;
    font-size: 18px;
    font-weight: bold;
}
#customers2 tr:nth-child(even){background-color: #fff;}

#customers2 tr:hover {background-color: #fff;}

#customers2 th {
    padding-top: 12px;
    padding-bottom: 12px;
    background-color: #fff;
    border: 0px;
    text-align: center;
    font-size: 32px;
    /* color: #3640bb; */
}




#customers3 {
font-family: ipag;
  border-collapse: collapse;
  width: 100%;  
  margin-bottom: 10px;
  margin-top: 10px;
  padding: 0px;
}

#customers3 td, #customers3 th {
  border: 1px solid #000;
  padding: 2px 8px;
  width : 20%;
}
#customers3 td.title {
    /* background: #ccc; */
    border: 1px solid #000;
}
#customers3 td.content {
    border: 1px solid #000;
}
#customers3 td.saleTitle {
    color: #000;
    font-size: 18px;
    font-weight: bold;
}
#customers3 tr:nth-child(even){background-color: #fff;}

#customers3 tr:hover {background-color: #fff;}

#customers3 th {
    padding-top: 12px;
    padding-bottom: 12px;
    background-color: #fff;
    border: 0px;
    text-align: center;
    font-size: 32px;
    /* color: #3640bb; */
}

</style>
</body>
</html>