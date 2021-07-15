<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>支払明細書</title>
</head>
<body>
@if ($data->loai_job == 1)

    <table id="customers">
        <tr>
            <th colspan="5">支払明細書</th>
        </tr>
        <!-- <tr>
            <td colspan="3"></td>
            <td class="title">受領日</td>
            <td class="content">{{$data->date_company_pay}}</td>
        </tr> -->
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="title">受注No.</td>
            <td class="content">{{$data->codejob}}</td>
        </tr>
        <tr>
            <td class="saleTitle" colspan="5" style="text-transform: uppercase;">{{$dataSales[0]->userInfo->name}}　様</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" class="nameCompany" style="padding-left: 100px;">株式会社ＡｌｐｈａＣｅｐ</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">〒２７３－０１１１</td>
            <td rowspan="4">
                <img class="condau" src="{{ asset('assets/images/condau.png') }}" />
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">千葉県鎌ケ谷市北中沢１－１８－２２</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">スカラビル３Ｆ</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">電話: 0474-022-022</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding-left: 100px;">Email: support@alphacep.co.jp</td>
        </tr>
        <!-- <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding-left: 100px;">Website http://alphacep.co.jp/</td>
        </tr> -->
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
            <td class="totalTitle" style="padding: 10px;">総合計金額</td>
            <td class="totalPrice">¥{{ number_format($data->tong_thu) }}</td>
            <td >&nbsp;</td>
            <td colspan="2" >担当：ジェン　ティ　タン　ガー</td>
        </tr>
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" class="border-all title_form" >　説明</td>
            <td class="border-all title_form">金額</td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
            @if ($data->loai_job == 2)
                通訳手配料<br/>
            @else 
                通訳料<br/>
            @endif
                    ・通訳日： {{$data->ngay_pd}}<br/>
                    ・通訳会場:  {{$data->address_pd}}<br/>                    
                営業者<br/>
                    ・氏名：<span style="text-transform: uppercase;">{{$dataSales[0]->userInfo->name}}</span> <br/>
                通訳人<br/>
                    ・氏名：<span style="text-transform: uppercase;">{{$dataColla[0]->userInfo->name}}</span> <br/>
            </td>
            <td class="border-all data_form" style="text-align: right;" >
                @if( ( ($data->tong_thu / 1.1) - ($dataColla[0]->price_total) - ($dataColla[0]->price_ctv * 0.1021) - ($dataColla[0]->phi_chuyen_khoan) - ($dataSales[0]->price_total) ) < 0 )
                    <span style="color:red">¥{{ number_format( ($data->tong_thu / 1.1) - ($dataColla[0]->price_total) - ($dataColla[0]->price_ctv * 0.1021) - ($dataColla[0]->phi_chuyen_khoan) - ($dataSales[0]->price_total) ) }}</span>              
                @else 
                    ¥{{ number_format( ($data->tong_thu / 1.1) - ($dataColla[0]->price_total) - ($dataColla[0]->price_ctv * 0.1021) - ($dataColla[0]->phi_chuyen_khoan) - ($dataSales[0]->price_total) ) }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form">
                通訳給与合計<br/>    
                （通訳給与)<br>    
                （交通費等)
            </td>
            <td class="border-all data_form" style="text-align: right;" >
            ¥{{ number_format($dataColla[0]->price_total) }}<br>
            (¥{{ number_format($dataColla[0]->price_ctv) }})<br>
            (¥{{ number_format($dataColla[0]->price_move) }})
            </td>
        </tr>
       
        <tr>
            <td colspan="4" class="border-all data_form" >
                源泉徴収額（10.21%）<br/>
                （課税対象額）
            </td>
            <td class="border-all data_form" style="text-align: right;" >
            ¥{{ number_format($dataColla[0]->price_ctv * 0.1021) }}<br>
            (¥{{ number_format($dataColla[0]->price_ctv) }})
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
                営業報酬
            </td>
            <td class="border-all data_form" style="text-align: right;" >
            ¥{{ number_format($dataSales[0]->price_total) }}
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
                振込手数料
            </td>
            <td class="border-all data_form" style="text-align: right;" >
                ¥{{ number_format($data->tong_chuyen_khoan) }}
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                小計	
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu / 1.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                消費税(10%)		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format(($data->tong_thu / 1.1) * 0.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                合計		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu) }}</td>
        </tr>

        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>

        <tr>
            <td colspan="1"  class="title" style="height:100px;text-align: center;">備考</td>
            <td colspan="4"  class="border-all data_form" ></td>
        </tr>
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
    </table>

@elseif ($data->loai_job == 2)
    <table id="customers">
        <tr>
            <th colspan="5">支払明細書</th>
        </tr>
        <!-- <tr>
            <td colspan="3"></td>
            <td class="title">受領日</td>
            <td class="content">{{$data->date_company_pay}}</td>
        </tr> -->
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="title">受注No.</td>
            <td class="content">{{$data->codejob}}</td>
        </tr>
        <tr>
            <td class="saleTitle" colspan="5" style="text-transform: uppercase;">{{$dataColla[0]->userInfo->name}}　様</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" class="nameCompany" style="padding-left: 100px;">株式会社ＡｌｐｈａＣｅｐ</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">〒２７３－０１１１</td>
            <td rowspan="4">
                <img class="condau" src="{{ asset('assets/images/condau.png') }}" />
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">千葉県鎌ケ谷市北中沢１－１８－２２</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">スカラビル３Ｆ</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">電話: 0474-022-022</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding-left: 100px;">Email: support@alphacep.co.jp</td>
        </tr>
        <!-- <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding-left: 100px;">Website http://alphacep.co.jp/</td>
        </tr> -->
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
            <td class="totalTitle" style="padding: 10px;">総合計金額</td>
            <td class="totalPrice">¥{{ number_format($data->tong_thu) }}</td>
            <td >&nbsp;</td>
            <td colspan="2" >担当：ジェン　ティ　タン　ガー</td>
        </tr>
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" class="border-all title_form" >　説明</td>
            <td class="border-all title_form">金額</td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
            @if ($data->loai_job == 2)
                通訳手配料<br/>
            @else 
                通訳料<br/>
            @endif
                    ・通訳日： {{$data->ngay_pd}}<br/>
                    ・通訳会場:  {{$data->address_pd}}<br/>
                営業者<br/>
                    ・氏名：<span style="text-transform: uppercase;">{{$dataSales[0]->userInfo->name}}</span> <br/>
                通訳人<br/>
                    ・氏名：<span style="text-transform: uppercase;">{{$dataColla[0]->userInfo->name}}</span><br/>
            </td>
            <td class="border-all data_form" style="text-align: right;" >
                @if( ( ($data->tong_thu / 1.1) - ($dataSales[0]->price_total) - ($data->tong_chuyen_khoan) ) < 0 )
                    <span style="color:red">¥{{ number_format( ($data->tong_thu / 1.1) - ($dataSales[0]->price_total) - ($data->tong_chuyen_khoan)  ) }}</span>
                @else 
                    ¥{{ number_format( ($data->tong_thu / 1.1) - ($dataSales[0]->price_total) - ($data->tong_chuyen_khoan) ) }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
                営業報酬
            </td>
            <td class="border-all data_form" style="text-align: right;" >
            ¥{{ number_format($dataSales[0]->price_total) }}
            </td>
        </tr>
        
        <tr>
            <td colspan="4" class="border-all data_form" >
                振込手数料
            </td>
            <td class="border-all data_form" style="text-align: right;" >
                ¥{{ number_format($data->tong_chuyen_khoan) }}
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                小計	
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu / 1.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                消費税(10%)		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format(($data->tong_thu / 1.1) * 0.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                合計		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu) }}</td>
        </tr>

        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>

        <tr>
            <td colspan="1"  class="title" style="height:100px;text-align: center;">備考</td>
            <td colspan="4"  class="border-all data_form" ></td>
        </tr>
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
    </table>
@else 
    <table id="customers">
        <tr>
        <th colspan="5">支払明細書</th>
        </tr>
        <!-- <tr>
            <td colspan="3"></td>
            <td class="title">受領日</td>
            <td class="content">{{$data->date_company_pay}}</td>
        </tr> -->
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="title">受注No.</td>
            <td class="content">{{$data->codejob}}</td>
        </tr>
        <tr>
            <td class="saleTitle" colspan="5" style="text-transform: uppercase;">{{$dataSales[0]->userInfo->name}}　様</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" class="nameCompany" style="padding-left: 100px;">株式会社ＡｌｐｈａＣｅｐ</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">〒２７３－０１１１</td>
            <td rowspan="4">
                <img class="condau" src="{{ asset('assets/images/condau.png') }}" />
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">千葉県鎌ケ谷市北中沢１－１８－２２</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">スカラビル３Ｆ</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="padding-left: 100px;">電話: 0474-022-022</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding-left: 100px;">Email: support@alphacep.co.jp</td>
        </tr>
        <!-- <tr>
            <td colspan="2"></td>
            <td colspan="3" style="padding-left: 100px;">Website http://alphacep.co.jp/</td>
        </tr> -->
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
            <td class="totalTitle" style="padding: 10px;">総合計金額</td>
            <td class="totalPrice">¥{{ number_format($data->tong_thu) }}</td>
            <td >&nbsp;</td>
            <td colspan="2" >担当：ジェン　ティ　タン　ガー</td>
        </tr>
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" class="border-all title_form" >　説明</td>
            <td class="border-all title_form">金額</td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
            @if ($data->loai_job == 2)
                通訳手配料<br/>
            @else 
                通訳料<br/>
            @endif
                    ・通訳日： {{$data->ngay_pd}}<br/>
                    ・通訳会場:  {{$data->address_pd}}<br/>
                営業者<br/>
                    ・氏名：<span style="text-transform: uppercase;">{{$dataSales[0]->userInfo->name}}</span> <br/>
                通訳人<br/>
                    ・氏名：<span style="text-transform: uppercase;">{{$dataColla[0]->userInfo->name}}</span> (※従業員)<br/>
            </td>
            <td class="border-all data_form" style="text-align: right;" >
                @if( ( ($data->tong_thu / 1.1) - ($dataColla[0]->price_total) - ($dataSales[0]->price_total) - ($data->tong_chuyen_khoan)) < 0 )
                    <span style="color:red">¥{{ number_format( ($data->tong_thu / 1.1) - ($dataColla[0]->price_total) - ($dataSales[0]->price_total) - ($data->tong_chuyen_khoan) ) }}</span>
                @else 
                    ¥{{ number_format( ($data->tong_thu / 1.1) - ($dataColla[0]->price_total) - ($dataSales[0]->price_total) - ($data->tong_chuyen_khoan) ) }}
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-all data_form" >
                経費等（交通費、ガソリン代、駐車場代、食費など）
            </td>
            <td class="border-all data_form" style="text-align: right;" >
            ¥{{ number_format($dataColla[0]->price_total) }}
            </td>
        </tr>
        
        <tr>
            <td colspan="4" class="border-all data_form" >
                営業報酬
            </td>
            <td class="border-all data_form" style="text-align: right;" >         
            ¥{{ number_format($dataSales[0]->price_total) }}
            </td>
        </tr>
        
        <tr>
            <td colspan="4" class="border-all data_form" >
                振込手数料
            </td>
            <td class="border-all data_form" style="text-align: right;" >                
                ¥{{ number_format($data->tong_chuyen_khoan) }}
                
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                小計	
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu / 1.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                消費税(10%)		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format(($data->tong_thu / 1.1) * 0.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form" >
                合計		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu) }}</td>
        </tr>

        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>

        <tr>
            <td colspan="1"  class="title" style="height:100px;text-align: center;">備考</td>
            <td colspan="4"  class="border-all data_form" ></td>
        </tr>
        <tr>
            <td class="">&nbsp;</td>
            <td class=""></td>
            <td colspan="3" >&nbsp;</td>
        </tr>
    </table>
@endif
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
    /* background: #363cda;
    color: #fff; */
    font-weight: bold;
}
</style>
</body>
</html>