<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>出金伝票</title>
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
    <table id="customers">
        <tr>
            <td colspan="3" style="vertical-align:top;text-align:center">
                <div style="font-size:24;">出 金 伝 票</div>    
                <div>(通訳事業)</div>
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span style="margin-left:20px;">支払日：{{$data->year}} 年 {{$data->month}} 月 {{$data->day}} 日<br><br></span>
                
            </td>
        </tr>
        <tr>            
            <td colspan="3">
                <table id="customers3"> 
                    <tr>
                        <td rowspan="2" style="width:10px;border:1px solid #000;text-align:center">支<br>払<br>先</td>
                        <td rowspan="2" style="border:1px solid #000;width:400px;text-align:center">
                                <span style="font-size:20px;">{{$data->sale_name}} 様</span>
                                <span style="font-size:20px;text-align:right"></span>
                        </td>
                        <td class="bgRowHeaderPDF" style="width:70px;border:1px solid #000;text-align:center">担当印</td>
                        <td class="bgRowHeaderPDF" style="width:70px;border:1px solid #000;text-align:center">承認印</td>
                    </tr>
                    <tr>
                        <td style="height:50px;"></td>
                        <td style="height:50px;"></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td class="bgRowHeaderPDF border-all title_form" style="width:200px">勘定科目</td>
            <td class="bgRowHeaderPDF border-all title_form" style="width:375px">案件</td>
            <td class="bgRowHeaderPDF border-all title_form" style="width:75px">金額</td>
        </tr>
        <tr>
            <td class="border-all data_form" style="vertical-align:top">
            {{$data->receipt_type}}
            </td>
            <td class="border-all data_form" style="height:200px;vertical-align:top">
                受注番号：{{$data->codejob}}<br>
                通訳日： {{$data->ngay_pd}}<br/>
                通訳住所:  {{$data->address_pd}}
            </td>
            <td class="border-all data_form" style="text-align:right;vertical-align:top">
                @if ($data->price_total > 0)
                    ¥{{ number_format($data->price_total) }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bgRowHeaderPDF border-all data_form" style="text-align:center">合計</td>
            <td class="border-all data_form" style="text-align:right;">¥{{ number_format($data->price_total) }}</td>
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