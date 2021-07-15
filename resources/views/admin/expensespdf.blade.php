<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>経費一覧表</title>
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
    <table style="width:100%;">
        <tr>
            <td style="vertical-align:top;text-align:center">
                <div style="font-size:24;">経費一覧表</div>  
            </td>
        </tr>
    </table>
    <table style="width:100%;">
        <tr>
            <td style="text-align:left">
                <table id="customers2"> 
                    <tr>
                        <td>件数： {{ number_format($data->sumData) }} 件</td>
                    </tr>
                    <tr>
                        <td>支払月： {{$data->selectedMonth}}</td>
                    </tr>
                    <tr>
                        <td>経費合計： ¥{{ number_format($data->sumPay) }}</td>
                    </tr>
                </table>
            </td>
            <td style="width:100px;">
                <table id="customers3"> 
                    <tr>
                        <td class="bgRowHeaderPDF" style="border:1px solid #000;text-align:center">作成者</td>
                        <td class="bgRowHeaderPDF" style="border:1px solid #000;text-align:center">決裁者</td>
                    </tr>
                    <tr>
                        <td style="height:50px;border:1px solid #000"></td>
                        <td style="height:50px;border:1px solid #000"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
        
    <table id="customers">
        
    @if ($data->sumData == 0)
        <div>該当のデータがありません。</div>
    @else 
        <tr>
            <td class="bgRowHeaderPDF border-all title_form" style="width:400px">月</td>
            <td class="bgRowHeaderPDF border-all title_form" style="width:150px">金額</td>
            <td class="bgRowHeaderPDF border-all title_form" >確認者</td>
            <td class="bgRowHeaderPDF border-all title_form" >承認者</td>
        </tr>
        @foreach($data as $item)
            <tr>
                <td class="border-all data_form"  style="vertical-align:top">
                    <span>{{$item->date}}</span>
                </td>
                <td class="border-all data_form" style="vertical-align:top;text-align:right">
                    ¥{{ number_format($item->price) }}
                </td>
                <td class="border-all data_form"></td>
                <td class="border-all data_form"></td>
            </tr>
        @endforeach    
    @endif
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
  /* margin-right: 30px; */
  /* margin-left: -20px; */
  /* margin-bottom: 10px; */
}

#customers td, #customers th {
  border: 0px solid #ddd;
  padding: 2px 8px;
  /* width : 20%; */
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
  width: 300px;  
  margin-bottom: 10px;
  margin-top: 10px;
  padding: 0px;
}

#customers2 td, #customers2 th {
  border-bottom: 1px solid #000;
  padding: 2px 8px;
  width : 20%;
}
#customers2 td.title {
    /* background: #ccc; */
    border-bottom: 1px solid #000;
}
#customers2 td.content {
    border-bottom: 1px solid #000;
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