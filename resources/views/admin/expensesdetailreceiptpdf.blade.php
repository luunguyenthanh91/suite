<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>出金伝票</title>
</head>
<body>
    <table id="customers">
        <tr>
            <td colspan="5" style="vertical-align:top;text-align:center">
                <div style="font-size:24;">出 金 伝 票</div>    
                <div>(通訳事業)</div>
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <table > 
                    <tr>
                        <td>日付：</td>
                        <td>{{$data->date}}</td>
                    </tr>
                    <tr>
                        <td>勘定科目：</td>
                        <td>
                            @if ($data->typeLog == 1)
                                <span>租税公課</span>
                            @endif
                            @if ($data->typeLog == 2)
                                <span>修繕費</span>
                            @endif
                            @if ($data->typeLog == 3)
                                <span>水道光熱費</span>
                            @endif
                            @if ($data->typeLog == 4)
                                <span>保険料</span>
                            @endif
                            @if ($data->typeLog == 5)
                                <span>消耗品費</span>
                            @endif
                            @if ($data->typeLog == 6)
                                <span>法定福利費</span>
                            @endif
                            @if ($data->typeLog == 7)
                                <span>給料賃金</span>
                            @endif
                            @if ($data->typeLog == 8)
                                <span>地代家賃</span>
                            @endif
                            @if ($data->typeLog == 9)
                                <span>外注工賃</span>
                            @endif
                            @if ($data->typeLog == 10)
                                <span>支払手数料</span>
                            @endif
                            @if ($data->typeLog == 11)
                                <span>旅費交通費</span>
                            @endif
                            @if ($data->typeLog == 12)
                                <span>開業費/創立費</span>
                            @endif
                            @if ($data->typeLog == 13)
                                <span>通信費</span>
                            @endif
                            @if ($data->typeLog == 14)
                                <span>接待交際費</span>
                            @endif
                            @if ($data->typeLog == 15)
                                <span>その他</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>摘要：</td>
                        <td>{{$data->name}}</td>
                    </tr>
                    <tr>
                        <td>金額：</td>
                        <td>¥{{ number_format($data->price) }}</td>
                    </tr>
                </table>
            </td>
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