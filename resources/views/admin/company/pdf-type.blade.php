<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('label.pdf_receipt') }}</title>
</head>
<body>
    <div style="margin:30px;">
        <div style='text-align:right; height:50px;margin-top:70px;;width:100%'>
            {{ trans('label.created_date') }}: {{$data->year}} 年 {{$data->month}} 月 {{$data->date}} 日
        </div>
        <div style='text-align:left; height:50px;width:100%'>
            @if ($data->loai_job == 1 || $data->loai_job == 3)
                <span style="text-transform:uppercase;">{{$dataSales[0]->userInfo->name}}<span> {{ trans('label.sama') }}
            @else
            <span style="text-transform:uppercase;">{{$dataColla[0]->userInfo->name}}<span> {{ trans('label.sama') }}
            @endif
        </div>
        <div style='text-align:center; vertical-align:middle; height:30px;width:100%'>
            <div style="font-size:24;"><b><u>{{ trans('label.pdf_receipt') }}</u></b></div>   
        </div>
        <div style='text-align:right; height:110px;margin-top:50px;width:100%'>
            <div style="font-size:12;">{{ trans('label.myname') }}</div>
            <div style="font-size:10;">
            {{ trans('label.mypostcode') }}<br>
            （{{ trans('label.address') }}） {{ trans('label.myaddress') }}<br>
            {{ trans('label.myaddress2') }}<br>
            {{ trans('label.mytel') }}<br>
            {{ trans('label.myemail') }}<br>
            <img class="condau" src="{{ asset('assets/images/condau.png') }}" style="margin-top:-60px;margin-right:-30px;opacity: 0.2;"/>
            </div>
        </div>
        <div style='text-align:left; vertical-align:middle; height:50px;width:100%; margin-top:10px;'>
        下記の通り、領収いたしました
        </div>
        <table style='width:400px;border-collapse:collapse;margin-top:-10px;'>
            <tr>
                <td class="bgRowHeaderPDF" style="border:1px solid black;height:50px; font-size:24px; text-align:center;">{{ trans('label.money') }}</td>
                <td style="text-align:center; border:1px solid black;height:50px;font-size:24px;">{{ number_format($data->tong_thu_du_kien) }} 円</td>
            </tr>
        </table>
        <div style='text-align:right;margin-top:50px;width:100%'>
            <div>{{ trans('label.worker') }}: {{$data->worker}}</div>
        </div>
        <table style='width:100%;border-collapse:collapse;margin-top:5px;'>
            <tr>
                <td colspan="2" class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;height:20px;padding:5px;vertical-align:top">{{ trans('label.content') }}</td>
                <td class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;width:150px;padding:5px;vertical-align:top">{{ trans('label.money') }}</td>
            </tr>
            <tr>
                <td style="border:1px solid black;padding:10px;width:100px;text-align:center">
                    @if ($data->loai_job == 2)
                    通訳手配料
                    @else 
                    通訳料
                    @endif
                </td>
                <td style="border:1px solid black;height:150px;vertical-align:top;padding:5px;">
                    {{ trans('label.id') }}{{$data->id}}<br/><br/>
                    {{ trans('label.ngay_phien_dich') }} {{$data->ngay_pd}}<br/><br/>
                    {{ trans('label.address_pd') }} {{$data->address_pd}}<br/><br/>
                </td>
                <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
                    {{ number_format( ($data->tong_thu / 1.1) ) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bgRowHeaderPDF"  style="border:1px solid black;vertical-align:top;padding:5px;height:20px;;text-align:right">
                小計
                </td>
                <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
                {{ number_format($data->tong_thu / 1.1) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bgRowHeaderPDF"  style="border:1px solid black;vertical-align:top;padding:5px;height:20px;;text-align:right">
                消費税(10%)
                </td>
                <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
                {{ number_format(($data->tong_thu / 1.1) * 0.1) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bgRowHeaderPDF"  style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:right">
                合計
                </td>
                <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
                {{ number_format($data->tong_thu) }}
                </td>
            </tr>
        </table>
        <table style='width:100%;border-collapse:collapse;margin-top:40px;'>
            <tr>
                <td style="border:1px solid black;height:100px;padding:5px;vertical-align:top; width:100%;"><u>{{ trans('label.note') }}:</u></td>
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
  margin-right: 10px;
    /* margin-left: -30px; */
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
    /* background: #363cda; */
    /* color: #fff; */
    font-weight: bold;
}
.bgRowHeaderPDF {
    background-color: #f2f2f2
}
</style>
</body>
</html>