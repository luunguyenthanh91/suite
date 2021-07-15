<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>売上帳</title>
</head>
<div style='float:right;'>
    <div style='position: fixed; right:0;'>
        <img width="100px" height="20px" style="margin-top:-15px;" src="{{ asset('assets/images/secretstamp.png') }}" />
    </div>
</div>
<div style='float:left;'>
    <div style='position: fixed; left:0; margin-top:-15px;'>
        <div>株式会社ＡｌｐｈａＣｅｐ</div>
    </div>
</div>
<body>
    <table id="customers" style="border-collapse:collapse;">
        <tr>
            <td colspan="5" style="vertical-align:top;text-align:center">
                <div style="font-size:24;">売上帳</div>    
                <div>(通訳事業)</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table id="customers2"> 
                    <tr>
                        <td class="bgRowHeaderPDF" style="width:70px">件数：</td>
                        <td>{{ number_format($data->sumData) }} 件</td>
                    </tr>
                    <tr>
                        <td class="bgRowHeaderPDF" style="width:70px">売上高：</td>
                        <td>¥{{ number_format($data->sumPay) }}</td>
                    </tr>
                    <tr>
                        <td class="bgRowHeaderPDF" style="width:70px">通訳月：</td>
                        <td>{{$data->selectedMonth}}</td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td colspan="3">
                <table id="customers2"> 
                    <tr>
                        <td class="bgRowHeaderPDF" style="border:1px solid #000;text-align:center">作成日</td>
                        <td class="bgRowHeaderPDF" style="border:1px solid #000;text-align:center">作成者</td>
                        <td class="bgRowHeaderPDF" style="border:1px solid #000;text-align:center">承認日</td>
                        <td class="bgRowHeaderPDF" style="border:1px solid #000;text-align:center">承認者</td>
                    </tr>
                    <tr>
                        <td style="height:47px;border:1px solid #000"></td>
                        <td style="height:47px;border:1px solid #000"></td>
                        <td style="height:48px;border:1px solid #000"></td>
                        <td style="height:48px;border:1px solid #000"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table id="customers" >
        <tr>
            <td class="bgRowHeaderPDF border-all title_form" >受注番号</td>
            <td class="bgRowHeaderPDF border-all title_form" >通訳日</td>
            <td class="bgRowHeaderPDF border-all title_form">入金日</td>
            <td class="bgRowHeaderPDF border-all title_form">入金額</td>
            <td class="bgRowHeaderPDF border-all title_form">確認者</td>
        </tr>
        @foreach($data as $item)
            <tr>
                <td class="border-all data_form" style="vertical-align:top">
                    {{$item->codejob}}
                </td>
                <td class="border-all data_form" style="vertical-align:top">
                    {{$item->ngay_pd}}<br>
                    <span style="width : 200px;">{{$item->address_pd}}</span>
                </td>
                <td style="width : 100px;vertical-align:top" class="border-all data_form">
                    {{$item->date_company_pay}}
                </td>
                <td class="border-all data_form"  style="text-align:right;vertical-align:top">
                ¥{{ number_format($item->tong_thu) }}
                </td>
                <td class="border-all"></td>
            </tr>
        @endforeach
            <!-- <tr>
                <td colspan="4" class="bgRowHeaderPDF border-all data_form" style="text-align:right">合計: </td>
                <td class="border-all data_form" style="text-align:right;">¥{{ number_format($data->sumTaxPD) }}</td>
            </tr> -->
        
    </table>
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
  margin-bottom: 10px;
}

#customers td, #customers th {
  border: 0px solid #ddd;
  padding: 2px 8px;
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
  padding: 0px;
}

#customers2 td, #customers2 th {
  border: 1px solid #000;
  padding: 2px 8px;
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