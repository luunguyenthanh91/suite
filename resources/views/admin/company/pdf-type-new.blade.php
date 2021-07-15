<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>受注書</title>
</head>
<body>
    <table id="customers">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <th>受注書</th>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="title">受注No.</td>
            <td class="content">{{$data->codejob}}</td>
        </tr>
        <tr>
            @if ($data->loai_job == 1 || $data->loai_job == 3)
                <td class="saleTitle" colspan="5" style="text-transform: uppercase;">{{$dataSales[0]->userInfo->name}}　様</td>

            @else
                <td class="saleTitle" colspan="5" style="text-transform: uppercase;">{{$dataColla[0]->userInfo->name}}　様</td>

            @endif
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
            <td class="totalPrice">¥{{ number_format($data->tong_thu_du_kien) }}</td>
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
            </td>
            <td class="border-all data_form" style="text-align: right;" >
                @if( ( ($data->tong_thu_du_kien / 1.1) ) < 0 )
                    <span style="color:red">¥{{ number_format( ($data->tong_thu_du_kien / 1.1)  ) }}</span>
                @else 
                    ¥{{ number_format( ($data->tong_thu_du_kien / 1.1) ) }}
                @endif
            </td>
        </tr>
        
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                小計	
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu_du_kien / 1.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                消費税(10%)		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format(($data->tong_thu_du_kien / 1.1) * 0.1) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="" class="border-all data_form">
                合計		
            </td>
            <td class="border-all data_form" style="text-align: right;" >¥{{ number_format($data->tong_thu_du_kien) }}</td>
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
        <tr>
            <td colspan="5">上記依頼を承りました。</td>
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
</style>
</body>
</html>