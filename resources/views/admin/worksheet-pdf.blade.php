<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>出勤簿</title>
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
        <div style='text-align:center; vertical-align:middle; height:50px;width:100%;border-bottom:3px solid black'>
            <div style="font-size:24;"><b>出 勤 簿</b></div>   
        </div>
        <div style='text-align:right; width:100%;font-size:12pt;height:30px;margin-top:5px;'>
        <span style="margin-right20px;"></span>
        </div>
        <div class="fontweight" style='text-align:left; height:19px; width:200px; border-bottom:1px solid black;margin-top:-20px;'>
        {{$employee_depname}}
        </div>
        <div class="fontweight" style='text-align:left; height:19px; width:200px; border-bottom:1px solid black;margin-top:5px;'>
        
        {{$employee_name}} ({{$employee_code}})
        </div>
        <div class="fontweight" style='text-align:left; height:19px; width:200px; border-bottom:1px solid black;margin-top:5px;'>
        
        {{$selyear}} 年 {{$selmonth}} 月度
        </div>

        <table style='width:100%;border-collapse:collapse;margin-top:15'>
            <tr>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.datetime') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.day') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.ws_type') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.time_start') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.time_end') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.breaktime') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.time_count') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.overtime_count2') }}</td>
                <td class="bgRowHeaderPDF border-all title_form">{{ trans('label.note') }}</td>
            </tr>
            @foreach($data as $item)
            <tr>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['day'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['date'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center">
                {{ $item['ws_type'] }}
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
.bgRowHeaderPDF {
    background-color: #d1d1d1
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