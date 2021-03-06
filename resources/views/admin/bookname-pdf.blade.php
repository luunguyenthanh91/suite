<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ trans('label.bookname') }}</title>
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
        
        <div style='text-align:center; vertical-align:middle; height:35px;width:100%;'>
            <div style="font-size:24;"><b>{{ trans('label.namebook2') }}</b></div>
        </div>
        <table style='width:100%;border-collapse:collapse;margin-top:40px;'>
            <tr>
                <td class="border-all title_form" style="text-align:center;width:100px;">
                フリガナ
                </td>
                <td class="border-all title_form" style="text-align:left;width:450px;padding-left:10px;">
                {{@$data->employee_nick_name}}
                </td>
                <td class="border-all title_form">
                性別
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:50px;width:100px;">
                氏名
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;;vertical-align:middle;padding-left:10px;">
                {{@$data->employee_name}}
                </td>
                <td class="border-all title_form" style="width:50px;text-align:center;vertical-align:middle">
                @if ( @$data->male == 1 )
                    <span>{{ trans('label.male') }}</span>
                @endif
                @if ( @$data->male == 2 )
                    <span>{{ trans('label.female') }}</span>
                @endif
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:50px;;width:100px;">
                生年月日
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;;padding-left:10px;" colspan=2>
                {{@$data->employee_birthday_year}} 年 {{@$data->employee_birthday_month}} 月 {{@$data->employee_birthday_date}}日
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:50px;;width:100px;;">
                現住所
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;;padding-left:10px" colspan=2>
                {{@$data->address}}
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:50px;;width:100px;">
                雇入年月日
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;;padding-left:10px" colspan=2>
                {{@$data->employ_date_year}} 年 {{@$data->employ_date_month}} 月 {{@$data->employ_date_date}}日
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:70px;;width:100px;">
                従事する<br>業務の種類
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;padding-left:10px;" colspan=2>
                {{@$data->employee_depname}}
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:200px;;width:100px;">
                履歴
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;;padding-left:10px" colspan=2>
                <span >
                    {!! nl2br( @$data->inside_history) !!}
                </span>
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:150px;;width:100px;">
                解雇･退職<br>または死亡
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;" colspan=2>
                    <table style="width:100%;height:150px;border-collapse:collapse;">
                        <tr>
                            <td style="text-align:center;border-bottom: 1px solid #000 !important;border-right: 1px solid #000 !important;width:80px;">年月日</td>
                            <td style="width:400px;text-align:left;border-bottom: 1px solid #000 !important;;padding-left:10px">
                            @if ( @$data->retire_date_year != "" )
                                {{@$data->retire_date_year}} 年 {{@$data->retire_date_month}} 月 {{@$data->retire_date_date}}日
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:middle;border-right: 1px solid #000 !important;height:130px;">
                            事由
                            </td>
                            <td style="padding-left:10px">
                            <span >
                                {!! nl2br( @$data->retire_note) !!}
                            </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="border-all title_form" style="text-align:center;height:200px;;width:100px;">
                備考
                </td>
                <td class="border-all title_form" style="text-align:left;width:100%;;padding-left:10px" colspan=2>
                <span >
                    {!! nl2br( @$data->note) !!}
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
.border-all2 {
    border-bottom: 1px solid #000 !important;
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
    background-color: #FFFFF0
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