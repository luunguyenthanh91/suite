<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('label.pdf_detail_pay2') }}</title>
</head>
<body>
<div style="margin:30px;">
    <div style='text-align:right; height:50px;margin-top:70px;;width:100%'>
        {{ trans('label.created_date') }}: {{$data->ngay_chuyen_khoan_nam}} 年 {{$data->ngay_chuyen_khoan_thang}} 月 {{$data->ngay_chuyen_khoan_ngay}} 日
    </div>
    <div style='text-align:left; height:50px;width:100%'>
    <span style="text-transform:uppercase;">{{$dataColla[0]->userInfo->name}}<span> {{ trans('label.sama') }}
    </div>
    <div style='text-align:center; vertical-align:middle; height:30px;width:100%'>
        <div style="font-size:24;"><b><u>{{ trans('label.pdf_detail_pay2') }}</u></b></div>   
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
    下記のとおりお支払い申し上げます
    </div>
    <table style='width:400px;border-collapse:collapse;margin-top:-10px;'>
        <tr>
            <td class="bgRowHeaderPDF" style="border:1px solid black;height:50px; font-size:24px; text-align:center;">{{ trans('label.pay_money') }}</td>
            <td style="text-align:center; border:1px solid black;height:50px;font-size:24px;">{{ number_format($data->tong_chuyen_pd) }} 円</td>
        </tr>
    </table>
    <div style='margin-top:50px;width:100%'>
        <div>{{ trans('label.pdf_detail_pay3') }}</div>
    </div>
    <table style='width:100%;border-collapse:collapse;margin-top:5px;'>
        <tr>
            <td colspan="2" class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;height:20px;padding:5px;vertical-align:top;">{{ trans('label.pay_detail') }}</td>
            <td class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;padding:5px;vertical-align:top;width:50px;">{{ trans('label.tax_exclude') }}</td>
            <td class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;padding:5px;vertical-align:top;width:50px;">{{ trans('label.tax_money') }}</td>
            <td class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;padding:5px;vertical-align:top;width:50px;">{{ trans('label.money_include_tax') }}</td>
            <td class="bgRowHeaderPDF" style="text-align:center; border:1px solid black;padding:5px;vertical-align:top">{{ trans('label.note') }}</td>
        </tr>
        <tr>
            <td style="border:1px solid black;padding:10px;width:100px;text-align:center">
                @if ($data->loai_job == 2)
                通訳手配依頼
                @else 
                通訳依頼
                @endif
            </td>
            <td style="border:1px solid black;height:150px;vertical-align:top;padding:5px;">
                {{ trans('label.id') }}{{$data->id}}<br/><br/>
                {{ trans('label.ngay_phien_dich') }} {{$data->ngay_pd}}<br/><br/>
                {{ trans('label.address_pd') }} {{$data->address_pd}}<br/><br/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_phien_dich) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_phien_dich * 0.1) ) }} <div style="font-size:8px;">(10%)</div>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_phien_dich + $data->phi_phien_dich * 0.1) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:center;">
            小　　　　　計
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_phien_dich) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_phien_dich * 0.1) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_phien_dich + $data->phi_phien_dich * 0.1) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:center;">
            源　泉　徴　収　額
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:70px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:50px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->thue_phien_dich) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:center;">
            通　訳　料　計
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right;background:#fff0d8">
            {{ number_format( ($data->phi_phien_dich) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td rowspan="2" style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:center;vertical-align: middle;">
            立　　替　　金
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right;text-align:center;width:200px;">
            交通費
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:70px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:50px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right;background:#fff0d8">
            {{ number_format( ($data->phi_giao_thong) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right;text-align:center;">
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:70px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:50px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right;">
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:center;">
            立　替　金　計
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:70px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:50px;height:20px;"/>
           </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->phi_giao_thong) ) }}
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border:1px solid black;vertical-align:top;padding:5px;height:20px;text-align:center;">
            請　 求 　金 　額
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:70px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            <img src="{{ asset('assets/images/R.png') }}" style="width:50px;height:20px;"/>
            </td>
            <td style="text-align:center; border:1px solid black;vertical-align:top;padding:5px;text-align:right">
            {{ number_format( ($data->tong_chuyen_pd) ) }}
            </td>
            <td style="text-align:center; border-left:1px solid black;border-top:1px solid black;vertical-align:top;padding:5px;text-align:right">
            </td>
        </tr>
    </table>
</div>
<div style="margin:30px; border:1px solid black">
    <div style='height:280px; width:100%;margin-left:20px;margin-right:50px'>
        <div style='text-align:center; vertical-align:middle; height:30px;width:100%;padding:10px;'>
            <div style="font-size:16;">受 領 書</div>   
        </div>
        <div style='height:50px;;width:100%;margin-top:10px;padding:10px;'>
            <u>株式会社　ＡｌｐｈａＣｅｐ　御中</u>
        </div>
        <div style='text-align:right; height:50px;margin-top:-70px;;width:100%;padding:10px;'>
            {{$data->ngay_chuyen_khoan_nam}} 年 {{$data->ngay_chuyen_khoan_thang}} 月 {{$data->ngay_chuyen_khoan_ngay}} 日
        </div>
        <table style="width:100%;height:50px;">
            <tr>
                <td></td>
                <td class="bgRowHeaderPDF" ></td>
                <td></td>
            </tr>  
        </table>
        <div style="width:100%;text-align:center;font-size:20px;margin-top:-40px;height:50px;">
        {{ number_format($data->tong_chuyen_pd) }} 円
        </div>
        <div style="width:100%;text-align:center;margin-left:150px;margin-top:-10px;">
        但　通訳料として、上記領収いたしました
        </div>
        <div style='text-align:right; margin-top:20px;width:100%;padding:10px;'>
        <span style="margin-right:50px;">{{$data->ten_phien_dich}}</span><br>
        </div>
        <div style='text-align:right;width:100%;padding:10px;margin-top:-30px;'>
        <span>__________________________________</span>
        </div>
    </div>
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