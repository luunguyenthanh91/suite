<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>入金リスト</title>
</head>
<body>
<div style='float:right;'>
 <div style='position: fixed; right:0'>
 <img width="100px" height="20px" style="margin-top:-15px" src="{{ asset('assets/images/secretstamp.png') }}" />
 </div>
</div>

    <table id="customers">
        <tr>
            <td colspan="2" rowspan="6">
                <div style="font-size:28px">入金リスト</div>
                <div style="margin-top:-2px; margin-left:20px;">(通訳事業)</div>
                <table> <tr style="border-bottom:1px solid #000">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr style="border-bottom:1px solid #000">
                    <td colspan="2" style="border-bottom:1px solid #000">入金月：{{$data->selectedMonth}}</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-bottom:1px solid #000">入金額合計：¥{{ number_format($data->sumPay) }}</td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="nameCompany" style="padding-left: 100px;">株式会社ＡｌｐｈａＣｅｐ</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 100px;">〒２７３－０１１１</td>
            <td rowspan="3">
                <img class="condau" src="{{ asset('assets/images/condau.png') }}" />
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 100px;">千葉県鎌ケ谷市北中沢１－１８－２２</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 100px;">スカラビル３Ｆ</td>
        </tr>
        <tr>
            <td colspan="3" style="padding-left: 100px;">電話: 0474-022-022</td>
        </tr>

        
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="4" >&nbsp;</td>
        </tr>
        <tr>
            <td class="border-all title_form" >受注番号</td>
            <td class="border-all title_form">通訳日</td>
            <td class="border-all title_form">営業者</td>
            <td class="border-all title_form">通訳者</td>
            <td class="border-all title_form">入金日</td>
            <td class="border-all title_form">金額</td>
        </tr>
        @foreach($data as $item)
            <tr>
                <td class="border-all data_form" >
                {{$item->codejob}}
                </td>
                <td class="border-all data_form" >
                {{$item->ngay_pd}}
                </td>
                <td class="border-all data_form" >
                @foreach ( $item->ctvSalesList as $ctvItem) 
                        <div style="text-transform: uppercase;">{{$ctvItem->name}}</div>
                    @endforeach
                </td>
                <td class="border-all data_form">
                    @foreach ( $item->ctvList as $ctvItem) 
                        <div style="text-transform: uppercase;">{{$ctvItem->name}}</div>
                    @endforeach
                </td>
                <td class="border-all data_form" >
                {{$item->date_company_pay}}
                </td>
                <td class="border-all data_form" style="text-align:right">
                    <div>
                        @if ($item->tong_thu > 0)
                            <p>¥{{ number_format($item->tong_thu) }}</p>
                        @endif
                    </div>    
                </td>
            </tr>
        @endforeach
            <tr>
                <td colspan="5" class="border-all data_form" style="text-align:right;">合計: </td>
                <td class="border-all data_form" style="text-align:right;">¥{{ number_format($data->sumPay) }}</td>
            </tr>
        
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
  margin-right: 30px;
  margin-left: -20px;
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
</style>
</body>
</html>