<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('label.costtransport') }}</title>
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
            <div style="font-size:24;"><b>{{ trans('label.billprepay_pdf2') }}</b></div>
        </div>
        <div style='text-align:right; width:100%;font-size:14px;height:50px;margin-top:5px;'>
        {{ trans('label.request_cost_id') }}{{$data->id}}<br>
        {{ trans('label.submited_on') }}： {{$data->year}}{{ trans('label.year') }}{{$data->month}}{{ trans('label.month') }}{{$data->day}}{{ trans('label.date') }}
        </div>

        <table style="width:100%;margin-top:-25px;">
            <tr>
                <td style="text-align:left;">
                    <div class="fontweight" style='font-size:14px;text-align:left; height:19px; width:250px; border-bottom:1px solid black;margin-top:0px;'>
                    {{ trans('label.dep') }}: <b>{{$data->employee_depname}}</b>
                    </div>

                    <div class="fontweight" style='font-size:14px;text-align:left; height:19px; width:250px; border-bottom:1px solid black;margin-top:5px;'>
                    {{ trans('label.employee_code') }}: <b>{{$data->employee_code}}</b>
                    </div>

                    <div class="fontweight" style='font-size:14px;text-align:left; height:19px; width:250px; border-bottom:1px solid black;margin-top:5px;'>
                    {{ trans('label.user_name') }}: <b>{{$data->employee_name}}</b>
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
                            @if ($data->submited_by_sign != "") 
                            <div class="circle">{{$data->submited_by_sign}}</div>
                            @endif
                            </td>
                            <td style="height:40px;border:1px solid #000">
                            @if ($data->checked_by_sign != "") 
                            <div class="circle">{{$data->checked_by_sign}}</div>
                            @endif
                            </td>
                            <td style="height:40px;border:1px solid #000">
                            @if ($data->approved_by_sign != "") 
                            <div class="circle">{{$data->approved_by_sign}}</div>
                            @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table style="width:300px;border-collapse:collapse;margin-top:10px;">
            <tr>
                <td class="headerColor border-all title_form" style="text-align:center;height:40px;width:150px;padding:5px;">
                    {{ trans('label.money2') }}
                </td>
                <td class="border-all data_form" style="text-align:right;padding:5px;">
                    {{ number_format($data->sumprice) }} 円      
                </td>
            </tr>
        </table>

        <table style='width:100%;border-collapse:collapse;margin-top:20px;font-size:10.5'>
            <tr>
                <td class="headerColor border-all title_form" style="height:30px;width:100px;">{{ trans('label.cost_date') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.costprepay_place') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.costprepay_name') }}</td>
                <td class="headerColor border-all title_form" style="width:80px;">{{ trans('label.price2') }}</td>
                <td class="headerColor border-all title_form">{{ trans('label.note') }}</td>
            </tr>
            @foreach($data->detail as $item)
            <tr>
                <td class="border-all data_form"  style="height:30px;vertical-align:top;text-align:center;padding:5px;vertical-align:middle">
                {{ $item['date'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center;padding:5px;vertical-align:middle">
                {{ $item['place_from'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:left;padding:5px;vertical-align:middle">
                {{ $item['name'] }}
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:right;padding:5px;vertical-align:middle">
                {{ number_format($item['price']) }} 円                           
                </td>
                <td class="border-all data_form"  style="vertical-align:top;padding:5px;vertical-align:middle">
                {{ $item['note'] }}
                </td>
            </tr>
            @endforeach   
            
            @if ($data->detailpluscount > 0 )
            @for ($i = 0; $i < $data->detailpluscount; $i++)
            <tr>
                <td class="border-all data_form"  style="height:30px;vertical-align:top;text-align:center;padding:5px;vertical-align:middle">
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center;padding:5px;vertical-align:middle">
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:center;padding:5px;vertical-align:middle">
                </td>
                <td class="border-all data_form"  style="vertical-align:top;text-align:right;padding:5px;vertical-align:middle">
                </td>
                <td class="border-all data_form"  style="vertical-align:top;padding:5px;vertical-align:middle">
                </td>
            </tr>
            @endfor
            @endif
        </table>
        <table style="width:100%;border-collapse:collapse;margin-top:20px;font-size:10.5">
            <tr>
                <td class="headerColor" style="height:30px;border:1px solid #000;text-align:center;font-size:10.5">
                {{ trans('label.note') }}
                </td>
            </tr>
            <tr>
                <td style="height:100px;padding:5px;border:1px solid #000;text-align:left;font-size:10.5">
                <span style="font-size:12px; ">
                    {!! nl2br( $data->note) !!}
                </span>
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
    background-color: #EEEEEE
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