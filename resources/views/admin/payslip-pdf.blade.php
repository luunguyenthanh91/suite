<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('label.payslip') }}</title>
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
        <table style="width:100%;">
            <tr>
                <td style="text-align:left;">
                    <div style="border:0.1px solid black;width:400px;">
                        <div style="margin-left:20px;padding:10px;">
                            <center>
                                <label style="font-size:18px;">{{ $year }}{{ trans('label.year') }}{{ $month }}{{ trans('label.payslip_month') }}</label><label style="font-size:24px;margin-left:40px;">{{ trans('label.payslip_title') }}</label><br>
                                {{ trans('label.myname') }}
                            </center>
                            <table style="border:0px;font-size:12px;">
                                <tr>
                                    <td>{{ trans('label.dep') }}</td>
                                    <td><div style="margin-left:10px;">{{ $employee_depname }}</div></td>
                                </tr>
                                <tr>
                                    <td>{{ trans('label.user_name') }}</td>
                                    <td><div style="margin-left:10px;">({{ $employee_code }}) {{ $employee_name }} {{ trans('label.sama') }}</div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td style="vertical-align:bottom;width:250px;text-align:right"> 
                    <div style='text-align:center;border-bottom:1px solid black'>
                    {{ trans('label.pay_day') }}<label style="margin-left:20px;">{{ $selyear }}{{ trans('label.year') }}{{ $selmonth }}{{ trans('label.month') }}{{ $seldate }}{{ trans('label.date') }}</label>
                    </div>
                </td>
            </tr>
        </table>
        <div style="width:42px;height:42px;border:1px solid black;float:right;top:10;right:10;position:fixed">
            @if ($data->received_by_name != "") 
            <div class="circle" style="margin-top:5px;margin-left:5px;">
            </div>
            @endif
            <div style="font-size:11px;margin-top:5px;text-align:right">{{ trans('label.paid') }}</div>  
        </div>
        <table style="width:100%;margin-top:15px;">
            <tr>
                <td>
                    <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0.1px solid #9AFEFF;'>
                        <tr>
                            <td class="headerColor border-all2 title_form" style="height:35px;vertical-align:middle;text-align:center;background:#CCFFFF;border-color:1px solid #9AFEFF;">{{ trans('label.ws') }}</td>
                        </tr>
                        <tr>
                            <td style="height:500px;vertical-align:top;">
                                <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0px'>
                                    <tr>
                                        <td class="headerColor border-all2 title_form" style="padding-left:10px;height:30px;border-color:1px solid #9AFEFF;vertical-align:middle;background-color:#F0FFFF">{{ trans('label.work_day_count') }}</td>
                                        <td class="border-all2"  style="vertical-align:middle;text-align:center">{{ $data->daycount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all2 title_form" style="padding-left:10px;height:30px;border-color:1px solid #9AFEFF;vertical-align:middle;background-color:#F0FFFF;">{{ trans('label.work_time_count') }}</td>
                                        <td class="border-all2"  style="vertical-align:middle;text-align:center">{{ $data->worktimecount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all2 title_form" style="padding-left:10px;height:30px;border-color:1px solid #9AFEFF;vertical-align:middle;background-color:#F0FFFF;">{{ trans('label.overtime_count') }}</td>
                                        <td class="border-all2"  style="vertical-align:middle;text-align:center">{{ $data->overworktimecount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all2 title_form" style="padding-left:10px;height:30px;border-color:1px solid #9AFEFF;vertical-align:middle;background-color:#F0FFFF;">{{ trans('label.overtime_count_night') }}</td>
                                        <td class="border-all2"  style="vertical-align:middle;text-align:center"></td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all2 title_form" style="padding-left:10px;height:30px;border-color:1px solid #9AFEFF;vertical-align:middle;background-color:#F0FFFF;">{{ trans('label.holiday_time_count') }}</td>
                                        <td class="border-all2"  style="vertical-align:middle;text-align:center"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:30px;border-color:1px solid transparent;">
                                
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0.1px solid #FFFACD;'>
                        <tr>
                            <td class="headerColor border-all3 title_form" style="height:35px;vertical-align:middle;text-align:center;background:#FFFFCC;">{{ trans('label.plus') }}</td>
                        </tr>
                        <tr>
                            <td class="border-all3" style="height:500px;vertical-align:top;">
                                <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0px'>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFFFEA">{{ trans('label.time_money') }}</td>
                                        <td class="border-all31"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->jikyu) }} 円</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFFFEA;">{{ trans('label.kihonkyu') }}</td>
                                        <td class="border-all31"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->kihonkyu) }} 円</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFFFEA;">{{ trans('label.zangyou_teate') }}</td>
                                        <td class="border-all31"  style="vertical-align:middle;text-align:right;padding-right:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFFFEA;">{{ trans('label.holiday_teate') }}</td>
                                        <td class="border-all31"  style="vertical-align:middle;text-align:right;padding-right:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFFFEA;">{{ trans('label.night_teate') }}</td>
                                        <td class="border-all31"  style="vertical-align:middle;text-align:right;padding-right:10px;"></td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFFFEA;">{{ trans('label.tsukin_teate') }}</td>
                                        <td class="border-all31"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->tsukin_teate) }} 円</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-all3 title_form" style="height:28px;vertical-align:middle;text-align:center;">
                                <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0px'>
                                    <tr>
                                        <td class="headerColor border-all31 title_form" style="height:26px;width:100px;vertical-align:middle;text-align:center;background:#FFFFCC;">
                                        {{ trans('label.total_plus') }}
                                        </td>
                                        <td class="border-all31 title_form" style="height:26px;vertical-align:middle;text-align:center;padding-right:10px;;">
                                        {{ number_format($data->plus_total) }} 円
                                        </td>
                                    </tr>
                                </table> 
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0.1px solid #FFFACD;'>
                        <tr>
                            <td class="headerColor border-all4 title_form" style="height:35px;vertical-align:middle;text-align:center;background:#F9B7FF;">{{ trans('label.minus') }}</td>
                        </tr>
                        <tr>
                            <td class="border-all4" style="height:500px;vertical-align:top;">
                                <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0px'>
                                    <tr>
                                        <td class="headerColor border-all41 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFE9FF">{{ trans('label.kenkouhoken') }}</td>
                                        <td class="border-all41"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->kenkouhoken) }} 円</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all41 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFE9FF;">{{ trans('label.koseinenkin') }}</td>
                                        <td class="border-all41"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->koseinenkin) }} 円</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all41 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFE9FF;">{{ trans('label.koyohoken') }}</td>
                                        <td class="border-all41"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->koyohoken) }} 円</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all41 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFE9FF;">{{ trans('label.shotokuzei') }}</td>
                                        <td class="border-all41"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->shotokuzei) }} 円</td>
                                    </tr>
                                    <tr>
                                        <td class="headerColor border-all41 title_form" style="padding-left:10px;height:30px;vertical-align:middle;background-color:#FFE9FF;">{{ trans('label.juminzei') }}</td>
                                        <td class="border-all41"  style="vertical-align:middle;text-align:right;padding-right:10px;">{{ number_format($data->juminzei) }} 円</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-all4 title_form" style="height:28px;vertical-align:middle;text-align:center;">
                                <table style='width:100%;border-collapse:collapse;font-size:10.5;border:0px'>
                                    <tr>
                                        <td class="headerColor border-all41 title_form" style="height:26px;width:100px;vertical-align:middle;text-align:center;background:#F9B7FF;">
                                        {{ trans('label.total_minus') }}
                                        </td>
                                        <td class="border-all41 title_form" style="height:26px;vertical-align:middle;text-align:center;;padding-right:10px;">
                                        {{ number_format($data->minus_total) }} 円
                                        </td>
                                    </tr>
                                </table> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table style="width:100%;margin:2px;border-collapse:collapse;height:40px;border:1px solid #d38956">
            <tr>
                <td style="height:50px;width:453px;vertical-align:middle;text-align:center;background:#DBA077;">
                    <span style="padding:5px;">{{ trans('label.pay_total') }}</span>
                </td>
                <td style="text-align:center">
                {{ number_format($data->pay_total) }} 円
                </td>
            </tr>
        </table>

        <table style="width:100%;margin-top:10px;">
            <tr>
                <td>
                    <div class="fontweight" style='text-align:left; height:60px;padding:5px;border:0.1px solid black;vertical-align:top;'>
                        <u>{{ trans('label.note') }}:</u><br>
                        {!! nl2br( $data->note) !!}
                    </div>
                </td>
            </tr>
        </table>
        <div style="width:100%;text-align:right;font-size:10.5px;">
        {{ trans('label.payslip_msg') }}
        </div>

        <div style='text-align:center; vertical-align:middle; margin-top:20px;height:1px;width:100%;border-bottom:1px dotted black'>
        </div>
        <table style="width:100%;margin-top:30px;border-collapse:collapse;border:1px solid #CCC">
            <tr>
                <td style="text-align:center;background:#DDD;border:1px solid #CCC;;height:25px;">
                {{ trans('label.pay_total1') }}
                </td>
                <td style="text-align:center;background:#DDD;border:1px solid #CCC;;height:25px;">
                {{ trans('label.pay_total4') }}
                </td>
                <td style="text-align:center;background:#DDD;border:1px solid #CCC;height:25px;">
                {{ trans('label.pay_total3') }}
                </td>
            </tr><tr>
                <td style="border:1px solid #CCC;height:30px;">
                
                </td>
                <td style="border:1px solid #CCC;height:30px;">
                
                </td>
                <td style="border:1px solid #CCC;height:30px;">
                
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
    border: 1px solid #CCC !important;
}
.border-all2 {
    border: 1px solid #7DFDFE !important;
}

.border-all3{
    border: 1px solid #FFDF00 !important;
}
.border-all31{
    border: 1px solid #FFF380 !important;
}
.border-all4{
    border: 1px solid #E238EC !important;
}
.border-all41{
    border: 1px solid #F2A2E8 !important;
}
.title_form{
    /* text-align: center; */
    /* background: #363cda;
    color: #fff; */
    font-weight: bold;
}
.condau {
    height : 80px;
}
.headerColor {
    background-color: #DDD
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