@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件詳細')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')	
	
    <!-- content -->
    <div id="list-data">

        <!-- button control -->
        <!-- <div class="bodyButtonLeft" v-if='isMobile == false'>
            <a type="button" class="btn btn-outline-secondary2" style="background:green" href="/admin/projectupdate/{{$id}}">
                <i class="fas fa-edit"><div class="labelButton">編集</div></i>
            </a>
            <a type="button" class="btn btn-outline-secondary2" style="background:blue" href="/admin/company/pdf-type-new/{{$id}}">
                <i class="fas fa-file-pdf"><div class="labelButton">受注書</div></i>
            </a>  
            <a type="button" class="btn btn-outline-secondary2" style="background:orange" href="/admin/company/pdf/{{$id}}">
                <i class="fas fa-file-pdf"><div class="labelButton">支払明細書</div></i>
            </a>  
            <a type="button" class="btn btn-outline-secondary2" style="background:purple" href="/admin/company/pdf-type/{{$id}}">
                <i class="fas fa-file-pdf"><div class="labelButton">受領書</div></i>
            </a>  
            <a type="button" class="btn btn-outline-secondary2" style="background:red" @click="deleteRecore('{{$id}}')">
                <i class="fas fa-trash-alt"><div class="labelButton">削除</div></i>
            </a>           
        </div> -->
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/projectupdate/{{$id}}">
                <i class="fas fa-edit"><span class="labelButton">編集</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:blue" href="/admin/company/pdf-type-new/{{$id}}">
                <i class="fas fa-file-pdf"><span class="labelButton">受注書(PDF)</span></i>
            </a>  
            <a type="button" class="btn btn-outline-secondary3" style="background:orange" href="/admin/company/pdf/{{$id}}">
                <i class="fas fa-file-pdf"><span class="labelButton">支払明細書(PDF)</span></i>
            </a>  
            <a type="button" class="btn btn-outline-secondary3" style="background:purple" href="/admin/company/pdf-type/{{$id}}">
                <i class="fas fa-file-pdf"><span class="labelButton">受領書(PDF)</span></i>
            </a>  
            @if (Auth::guard('admin')->user()->id == 1 )
            <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="deleteRecore('{{$id}}')">
                <i class="fas fa-trash-alt"><span class="labelButton">削除</span></i>
            </a> 
            @endif      
        </div>
        <div class="container page__container page-section page_container_custom" :style="'margin-top: ' + marginTop">
            <form action="" method="POST" class="p-0 mx-auto form-data" >
                @csrf
                <div class="row page_container_custom_marginright">
                    <div class="col-lg-12">
                        <div class="form-group bodayRightContentGrid">
                            @if ( @$message && @$message['status'] === 1 )
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>{{ $message['message'] }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif
                            @if ( @$message && @$message['status'] === 2 )
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>{{ $message['message'] }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif
                            
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                                        <div class="card-header p-0 nav">
                                            <div class="row no-gutters" role="tablist">
                                                <div class="col-auto">
                                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click active" id="tab1">
                                                        <span class="flex d-flex flex-column">
                                                            <strong class="card-title">基本情報</strong>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-auto border-left border-right">
                                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab4">
                                                        <span class="flex d-flex flex-column">
                                                            <strong class="card-title">営業者</strong>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-auto border-left border-right">
                                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab5">
                                                        <span class="flex d-flex flex-column">
                                                            <strong class="card-title">通訳者</strong>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-auto border-left border-right">
                                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab6">
                                                        <span class="flex d-flex flex-column">
                                                            <strong class="card-title">入金</strong>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-auto border-left border-right">
                                                    <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                                        <span class="flex d-flex flex-column">
                                                            <strong class="card-title">売上</strong>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-auto border-left border-right">
                                                    <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab7">
                                                        <span class="flex d-flex flex-column">
                                                            <strong class="card-title">備考</strong>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body tab-content">
                                            <div class="tab-pane active" id="detailtab1">
                                                <div class="row">                                                
                                                    <div class="col-lg-12">
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <tr>
                                                                <td class="titleTd">受注番号：</td>
                                                                <td :class="''+classRowContent">
                                                                    <span> {{@$data->codejob}} </span><br>
                                                                    <a type="button" class="btn btn-outline-secondary2"  style="background:#9863ed" @click="copyClipboad(data)">
                                                                        <i class="fa fa-clipboard"></i>
                                                                    </a>
                                                                    <a type="button" class="btn btn-outline-secondary2"  style="background:#57BFFF" @click="copyClipboadLink(data)">
                                                                        <i class="fa fa-link"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">ステータス：</td>
                                                                <td :class="''+classRowContent">
                                                                    <span v-if='{{@$data->status}} == 0 || {{@$data->status}} == ""'>受注</span>
                                                                    <span v-if='{{@$data->status}} == 1'>通訳者選定</span>
                                                                    <span v-if='{{@$data->status}} == 2'>通訳待機</span>
                                                                    <span v-if='{{@$data->status}} == 3'>客様の入金確認</span>
                                                                    <span v-if='{{@$data->status}} == 8'>手配料金入金確認</span>
                                                                    <span v-if='{{@$data->status}} == 4'>通訳給与支払い</span>
                                                                    <span v-if='{{@$data->status}} == 5'>営業報酬支払い</span>
                                                                    <span v-if='{{@$data->status}} == 6'>クローズ</span>
                                                                    <span v-if='{{@$data->status}} == 7'>キャンセル</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">通訳日：</td>
                                                                <td :class="''+classRowContent">
                                                                    {{@$data->ngay_pd}}
                                                                    <br>
                                                                    {{@$data->address_pd}}
                                                                    <a target="_blank" :href="'https://www.google.co.jp/maps/place/'+address_pd">
                                                                        <i class="fas fa-map-marked-alt"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>  
                                                            <tr>
                                                                <td class="titleTd">受注日:</td>
                                                                <td :class="''+classRowContent">
                                                                    {{@$data->date_start}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">通訳日数:</td>
                                                                <td :class="''+classRowContent">
                                                                    {{@$data->total_day_pd}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">種類:</td>
                                                                <td :class="''+classRowContent">
                                                                    <span v-if='{{@$data->loai_job}} == 1'>パートナー対応</span>
                                                                    <span v-if='{{@$data->loai_job}} == 2'>通訳手配料のみ</span>
                                                                    <span v-if='{{@$data->loai_job}} == 3'>従業員対応</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">契約金額:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney({{@$data->tienphiendich}}) ))
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="detailtab4">
                                                <div class="row">                                                
                                                    <div class="col-lg-auto" v-for="(itemCTV, index) in listAcountSale">
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <tr>
                                                                <td class="titleTd">営業者:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseName(itemCTV.info.name) ))<br>
                                                                    (( parseAddr(itemCTV.info.address) ))<br>
                                                                    (( parsePhone(itemCTV.info.phone) )) <br>
                                                                    <a type="button" class="btn btn-outline-secondary2" style="background:#f9c0f2" target="_blank" :href="'/admin/ctvjobs/edit/' + itemCTV.ctv_jobs_id">
                                                                        <i class="fas fa-info-circle"></i>
                                                                    </a>
                                                                    <a type="button" class="btn btn-outline-secondary2"  style="background:#2362af" @click="copyClipboadCTV(itemCTV)">
                                                                        <i class="fa fa-clipboard"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">報酬:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.price_total) ))
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <thead class="thead-light" style="text-align:center">
                                                            <tr>
                                                                <th colspan="2">振込情報</th>
                                                            </tr>
                                                            </thead>
                                                            <tr style="border-top: solid 1px #000">
                                                                <td class="titleTd">振込日:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( itemCTV.ngay_chuyen_khoan ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">振込口座:</td>
                                                                <td :class="''+classRowContent">
                                                                    <span v-if="itemCTV.payplace == 1" :class="''+classRowContent">
                                                                        <span v-if=" itemCTV.info.ten_bank ">((itemCTV.info.ten_bank)) <br></span>
                                                                        <span v-if=" itemCTV.info.chinhanh ">((itemCTV.info.chinhanh)) <br> </span>
                                                                        <span v-if=" itemCTV.info.stk ">((itemCTV.info.stk)) <br></span>
                                                                        <span v-if=" itemCTV.info.ten_chutaikhoan ">((itemCTV.info.ten_chutaikhoan)) <br></span>
                                                                    </span>
                                                                    <span v-if="itemCTV.payplace == 2" :class="''+classRowContent">
                                                                        現金
                                                                    </span>                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">振込金額:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.price_total) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">手数料:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.phi_chuyen_khoan) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">振込状態:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( convertStatusBank(itemCTV.status) ))
                                                                </td>
                                                            </tr>
                                                            <tr v-if="itemCTV.payplace == 2">
                                                                <td colspan="2">
                                                                    <a type="button" class="btn btn-outline-secondary3" style="background:#e22e5d" href="/admin/partner-sale-receipt-pdf/{{$id}}">
                                                                        <i class="fas fa-file-pdf"><span class="labelButton">出金伝票(PDF)</span></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="detailtab5">
                                                <div class="row">                                                
                                                    <div class="col-lg-auto" v-for="(itemCTV, index) in listBankAccount">
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <tr>
                                                                <td class="titleTd mobileColumn" colspan="2">
                                                                    
                                                                </td>
                                                            </tr>    
                                                            <tr>
                                                                <td class="titleTd">通訳者:</td>
                                                                <td :class="''+classRowContent">
                                                                    <p :class="''+classRowContent" v-for="itemCTV in listBankAccount">
                                                                        (( parseName(itemCTV.info.name) ))
                                                                        <i v-if="itemCTV.info.male == 1" class="fa fa-male"></i>
                                                                        <i v-if="itemCTV.info.male == 2" class="fa fa-female"></i>
                                                                        <br>
                                                                        <span>(( parseAddr(itemCTV.info.address) )) </span>
                                                                        <a target="_blank" :href="'https://www.google.co.jp/maps/place/'+itemCTV.info.address">
                                                                            <i class="fas fa-map-marked-alt"></i>
                                                                        </a>
                                                                        <br>
                                                                        <span>(( parsePhone(itemCTV.info.phone) ))</span>
                                                                        <a :href="'tel:'+itemCTV.info.phone">
                                                                            <i class="fas fa-phone-square"></i>
                                                                        </a>
                                                                        <br>
                                                                        <a type="button" class="btn btn-outline-secondary2" style="background:#f4d000" target="_blank" :href="'/admin/collaborators/edit/' + itemCTV.info.id">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </a>
                                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#b3f791" @click="copyClipboadCTVpd(itemCTV.info)">
                                                                            <i class="fa fa-clipboard"></i>
                                                                        </a>
                                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#B8054E" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+itemCTV.info.address+'&s=1&fl=1&to='+address_pd">
                                                                            <i class="fa fa-train"></i>
                                                                        </a>
                                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:green" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+itemCTV.info.address+'/'+address_pd">
                                                                            <i class="fa fa-map"></i>
                                                                        </a>
                                                                        @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                                                        @if($itemMailTemplate->name == "通訳依頼通知")
                                                                        <div>
                                                                            <a type="button" class="btn btn-outline-secondary3" style="background:#a4dd3c" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                                                <i class="fas fa-envelope"><span class="labelButton">{{$itemMailTemplate->name}}</span></i>
                                                                            </a>
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                                                    <div>
                                                                        @if($itemMailTemplate->name == "通訳報告願い")
                                                                            <a type="button" class="btn btn-outline-secondary3" style="background:#F672D9" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                                                <i class="fas fa-envelope"><span class="labelButton">{{$itemMailTemplate->name}}</span></i>
                                                                            </a>
                                                                        @endif
                                                                        </<div>
                                                                    @endforeach
                                                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                                                        @if($itemMailTemplate->name == "手配手数料請求")
                                                                        <div v-if="loai_job == 2">
                                                                            <a v-bind:class='loai_job == 2 ? "" : "hidden"' type="button" class="btn btn-outline-secondary3" style="background:#256CE9" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                                                <i class="fas fa-envelope"><span class="labelButton">{{$itemMailTemplate->name}}</span></i>
                                                                            </a>
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                                                        @if($itemMailTemplate->name == "入金確認完了通知")
                                                                        <div v-if="loai_job == 2">
                                                                            <a v-bind:class='loai_job == 2 ? "" : "hidden"' type="button" class="btn btn-outline-secondary3" style="background:#F7D52B" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                                                <i class="fas fa-envelope"><span class="labelButton">{{$itemMailTemplate->name}}</span></i>
                                                                            </a>
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                                                        @if($itemMailTemplate->name == "給与振込完了通知")
                                                                        <div v-if="loai_job == 1">
                                                                            <a v-bind:class='loai_job == 1 ? "" : "hidden"' type="button" class="btn btn-outline-secondary3" style="background:#6289ff" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal">
                                                                                <i class="fas fa-envelope"><span class="labelButton">{{$itemMailTemplate->name}}</span></i>
                                                                            </a>
                                                                        </div>
                                                                        @endif
                                                                    @endforeach
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">給与:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.phi_phien_dich_total) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">交通費:</td>
                                                                <td :class="''+classRowContent">
                                                                 (( parseMoney(itemCTV.phi_giao_thong_total) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">給与合計:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.price_total) ))
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <thead class="thead-light" style="text-align:center">
                                                            <tr>
                                                                <th colspan="2">振込情報</th>
                                                            </tr>
                                                            </thead>
                                                            <tr>
                                                                <td class="titleTd">振込日:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( itemCTV.ngay_chuyen_khoan ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">振込口座:</td>
                                                                <td :class="''+classRowContent">
                                                                    <div v-for="itemBank in itemCTV.listBank">
                                                                        <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.ten_bank))<br></span> 
                                                                        <span v-if=" itemBank.id == itemCTV.bank_id && itemBank.chinhanh">((itemBank.chinhanh))<br></span> 
                                                                        <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.stk))<br></span> 
                                                                        <span v-if=" itemBank.id == itemCTV.bank_id">((itemBank.ten_chutaikhoan))<br></span> 
                                                                    </div>
                                                                    <span v-if="itemCTV.bank_id == 2">
                                                                        現金
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">振込金額:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.price_total) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">手数料:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.phi_chuyen_khoan) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">振込状態:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( convertStatusBank(itemCTV.status) ))
                                                                </td>
                                                            </tr>
                                                            <tr v-if="itemCTV.bank_id == 2">
                                                                <td colspan="2">
                                                                    <a type="button" class="btn btn-outline-secondary3" style="background:#e22e5d" href="/admin/partner-sale-receipt-pdf/{{$id}}">
                                                                        <i class="fas fa-file-pdf"><span class="labelButton">出金伝票(PDF)</span></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <thead class="thead-light" style="text-align:center">
                                                            <tr>
                                                                <th colspan="2">源泉徴収</th>
                                                            </tr>
                                                            </thead>
                                                            <tr>
                                                                <td class="titleTd">納税日:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( itemCTV.paytaxdate )) 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">納税地:</td>
                                                                <td :class="''+classRowContent">
                                                                (( convertTaxPlace(itemCTV.paytaxplace) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">納税額:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney(itemCTV.thue_phien_dich_total) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">納税状態:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( convertStatusBank(itemCTV.paytaxstatus) ))
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <thead class="thead-light" style="text-align:center">
                                                                <tr>
                                                                    <th scope="col fullWidth">通訳詳細</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(item1, index1) in itemCTV.dateList">
                                                                    <td :class="''+classRowContent">
                                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                                            <tr>
                                                                                <td class="titleTd">通訳日:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    (( item1.ngay_phien_dich ))
                                                                                </td>
                                                                            </tr>    
                                                                            <tr>
                                                                                <td class="titleTd">開始時間:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    (( item1.gio_phien_dich ))
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="titleTd">終了時間:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    (( item1.gio_ket_thuc ))
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="titleTd">延長時間:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    (( item1.gio_tang_ca ))
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="titleTd">通訳給与:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    (( parseMoney(item1.phi_phien_dich) ))
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="titleTd">交通費:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    (( parseMoney(item1.phi_giao_thong) ))
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="titleTd">報告内容:</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">
                                                                                    <p class="rowContent fullWidth">
                                                                                        <textarea disabled type="text" style="background:white;" class="form-control textarea ckeditor" rows="10">(( item1.note ))</textarea>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="titleTd">領収書ファイル:</td>
                                                                                <td :class="''+classRowContent">
                                                                                    <a v-if=" item1.file_hoa_don " type="button" class="btn btn-outline-secondary3" style="background:#f38434" target="_blank" href="/admin/move-fee-receipt-pdf/{{$id}}">
                                                                                        <i class="fas fa-download"><span class="labelButton">領収書</span></i>
                                                                                    </a> 
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="detailtab6">
                                                <div class="row">  
                                                    <div class="col-lg-auto">
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <tr>
                                                                <td class="titleTd">入金日:</td>
                                                                <td :class="''+classRowContent">
                                                                    {{@$data->date_company_pay}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">入金口座:</td>
                                                                <td :class="''+classRowContent">
                                                                    @foreach($allMyBank as $itemBank)
                                                                        @if ($data->stk_thanh_toan_id == $itemBank->id)
                                                                            (( parseBank({{$itemBank}}) ))
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">入金額:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( parseMoney({{@$data->tong_thu}}) )) 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">入金確認:</td>
                                                                <td :class="''+classRowContent">
                                                                    (( convertStatusBank({{$data->status_bank}}) ))
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="detailtab2">
                                                <div class="row">                                                
                                                    <div class="col-lg-auto">
                                                        <table class="table thead-border-top-0 table-nowrap table-mobile">
                                                            <thead class="thead-light" style="text-align:right">
                                                            <tr>
                                                                <th></th>
                                                                <th class="minWidthCol">予測</th>
                                                                <th class="minWidthCol">実績</th>
                                                            </tr>
                                                            </thead>
                                                            <tr>
                                                                <td class="titleTd">売上額:</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoney({{@$data->tong_thu_du_kien}}) ))
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoney({{@$data->tong_thu}}) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">営業報酬:</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoneyMinus({{@$data->price_sale}}) ))
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <span class="textAlignR" v-for="(item, index) in listAcountSale">
                                                                        (( parseMoneyMinus(item.price_total) ))
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">通訳給与:</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoneyMinus({{@$data->price_send_ctvpd}}) ))
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <span v-for="(item, index) in listBankAccount">
                                                                        (( parseMoneyMinus(item.phi_phien_dich_total) ))
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">報酬源泉徴収税 ({{@$data->percent_vat_ctvpd}}%):</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoneyMinus({{@$data->price_vat_ctvpd}}) ))
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <span v-for="(item, index) in listBankAccount">
                                                                        (( parseMoneyMinus(item.thue_phien_dich_total) ))
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">交通費等:</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoneyMinus({{@$data->ortherPrice}}) ))
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <span v-for="(item, index) in listBankAccount">
                                                                        (( parseMoneyMinus(item.phi_giao_thong_total) ))
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">運営費用:</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    (( parseMoneyMinus({{@$data->price_company_duytri}}) ))
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <span v-for="(item, index) in listAcountSale">
                                                                        (( parseMoneyMinus(item.phi_chuyen_khoan) ))
                                                                    </span><br>
                                                                    <span v-for="(item, index) in listBankAccount">
                                                                        (( parseMoneyMinus(item.phi_chuyen_khoan) ))
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr style="border-top: solid 1px #000">
                                                                <td class="titleTd">純利益:</td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <!-- <span v-if="{{@$data->tong_kimduocdukien}} < 0" class="femaleClass">(( parseMoney({{@$data->tong_kimduocdukien}}) ))</span> -->
                                                                    <span>(( parseMoney({{@$data->tong_kimduocdukien}}) ))</span>
                                                                </td>
                                                                <td :class="''+classRowContent+' textAlignR'">
                                                                    <span v-if="{{@$data->price_nhanduoc}} < 0" class="femaleClass">(( parseMoney({{@$data->price_nhanduoc}}) ))</span>
                                                                    <span v-if="{{@$data->price_nhanduoc}} >= 0">(( parseMoney({{@$data->price_nhanduoc}}) ))</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="detailtab7">
                                                <div class="row mb-32pt">
                                                    <div class="col-lg-12">
                                                        <p class="rowContent fullWidth">
                                                        {!! @$data->description !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>								
							</div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" >
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label">宛先</label>
                                <div class="search-form" >
                                    <input type="text" class="form-control" v-model="objSendMail.mail_cc" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">件名</label>
                                <div class="search-form" >
                                    <input type="text" class="form-control" v-model="objSendMail.title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">本文</label>
                                <div class="search-form" >
                                <textarea type="text" class="form-control" v-model="objSendMail.body" rows="50" ></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer bgTotal">
                            <a type="button" class="btn btn-outline-secondary3" style="background:#673FF7" @click="submitSendMail()">
                                <i class="fas fa-paper-plane">送信</i>
                            </a> 
                            <a type="button" class="btn btn-outline-secondary3" style="background:red" data-dismiss="modal">
                                <i class="fas fa-window-close">キャンセル</i>
                            </a> 
                        </div>
                        </div>
                </div>
            </div>

        </div>

    </div>

    <div id="error-details" style="display:none">
        <span id="copyName"></span><br>
        <span id="copyFurigana"></span><br>
        <span id="copyPhone"></span><br>
    </div>
    
    <!-- // END Page Content -->

    <!-- Footer -->

    @include('admin.component.footer')

    <!-- // END Footer -->

</div>
@include('admin.component.left-bar')
<!-- // END drawer-layout__content -->

<!-- Drawer -->

@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>


<script type="text/javascript" src="{{ asset('lib_upload/ckeditor/ckeditor.js') }}"></script> 
<script type="text/javascript" src="{{ asset('lib_upload/ckfinder/ckfinder.js') }}"></script>  
<link href="{{ asset('lib_upload/jquery-ui/css/ui-lightness/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('lib_upload/jquery-ui/js/jquery-ui.js') }}"></script>
<script src="{{ asset('lib_upload/jquery.slug.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('lib_upload/jquery.datepick.css') }}"> 
<script type="text/javascript" src="{{ asset('lib_upload/jquery.plugin.js') }}"></script> 
<script type="text/javascript" src="{{ asset('lib_upload/jquery.datepick.js') }}"></script>

<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });

        
    
    });
    jQuery(document).ready(function (){
        $('#listDate').datepick({ 
        multiSelect: 999, 
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1});
        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
            jQuery(this).toggle();
        });

        $(window).keydown(function(event){
            if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3]) && ($(event.target)[0]!=$("textarea")[4]) ) {
                event.preventDefault();
                return false;
            }
        });

    });
    var imgId;

    function chooseImage(id) {
        imgId = id;
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileField;
        finder.popup();
    }
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileField(fileUrl) {
        document.getElementById('chooseImage_img' + imgId).src = fileUrl;
        document.getElementById('chooseImage_input' + imgId).value = fileUrl;
        document.getElementById('chooseImage_div' + imgId).style.display = '';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = 'none';
    }

    function clearImage(imgId) {
        document.getElementById('chooseImage_img' + imgId).src = '';
        document.getElementById('chooseImage_input' + imgId).value = '';
        document.getElementById('chooseImage_div' + imgId).style.display = 'none';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = '';
    }


    function chooseFile(event)
    {   
        id= event.rel;
        imgId = id;
        console.log('chooseImage_input' + imgId);
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileFieldFile;
        finder.popup();
    } 
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileFieldFile( fileUrl )
    {
        document.getElementById( 'chooseImage_input' + imgId).value = fileUrl;
        $("#chooseImage_input"+ imgId).val(fileUrl)[0].dispatchEvent(new Event('input'));

    }
    function clearFile(event)
    {
        imgId= event.rel;
        document.getElementById( 'chooseImage_input' + imgId ).value = '';
        $("#chooseImage_input"+ imgId).val('')[0].dispatchEvent(new Event('input'));
    }


    function addMoreImg()
    {
        jQuery("ul#images > li.hidden").filter(":first").removeClass('hidden');
    }

//]]>
</script>
<style type="text/css">
    #images { list-style-type: none; margin: 0; padding: 0;}
    #images li { margin: 10px; float: left; text-align: center;  height: 190px;}
    .modal-backdrop {
        display: none !important;
    }
</style>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);


new Vue({
    el: '#list-data',
    data: {
        listBankAccount: [],
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        listPage: [],
        conditionName: '',
        jplt: '',
        male: '',
        addModal: 1,
        edit_form: 0,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        instan: 25,
        long: '{{@$data->longitude}}',
        lat: '{{@$data->latitude}}',
        kinh_vido: '',
        ga_gannhat: '{{@$data->ga}}',
        address_pd: '{{@$data->address_pd}}',
        groups: [],
        loai_job : '{{@$data->loai_job}}',
        listAcountSale: [],
        loadingTableSale: 0,
        countSales: 0,
        pageSales: 1,
        listSales: [],
        listPageSales: [],
        conditionNameSale: '',
        listAcountCustomer: [],
        loadingTableCustomer: 0,
        countCustomer: 0,
        pageCustomer: 1,
        listCustomer: [],
        listPageCustomer: [],
        conditionNameCustomer: '',
        objSendMail : [],
        listSendMail : [],
        flagSendMail : '{{$flagSendMail}}',
        userCustomerId: '{{$flagCustomer}}',
        typehoahong: '{{$data->typehoahong}}',
        percent_vat_ctvpd: '{{$data->percent_vat_ctvpd}}',
        showListPD : 0,
        showListCus : 0,
        showListCtv : 0,
        isMobile : ( viewPC )? false : true,
        marginTop: "30px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classRowContent: (viewPC)? "" : "rowContent "
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
        @foreach($dataColla as $itemConnect)

        $.ajax({
            url: "/admin/collaborators/get-detail-id/{{$itemConnect->collaborators_id}}",
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                that.listBankAccount.push({
                    id: '{{$itemConnect->id}}',
                    type: 'update',
                    collaborators_id: '{{$itemConnect->collaborators_id}}',
                    price_total: '{{$itemConnect->price_total}}',
                    phi_phien_dich_total: '{{$itemConnect->phi_phien_dich_total}}',
                    phi_giao_thong_total: '{{$itemConnect->phi_giao_thong_total}}',
                    thue_phien_dich_total: '{{$itemConnect->thue_phien_dich_total}}',
                    bank_id: '{{$itemConnect->bank_id}}',
                    listBank: res.data.bank,
                    ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                    phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                    dateList: @json($itemConnect['dateList']),
                    status: '{{$itemConnect->status}}',
                    paytaxdate: '{{$itemConnect->paytaxdate}}',
                    paytaxstatus: '{{$itemConnect->paytaxstatus}}',
                    paytaxplace: '{{$itemConnect->paytaxplace}}',
                    info: res.data
                });
            },
            error: function(xhr, textStatus, error) {
                Swal.fire({
                    title: "Có lỗi dữ liệu nhập vào!",
                    type: "warning",

                });
            }
        });

        @endforeach

        @foreach($allMailTemplate as $itemMailTemplate)
            that.listSendMail.push({
                title: '{{$itemMailTemplate->subject}}',
                mail_cc: '{{$itemMailTemplate->cc_mail}}',
                body: @json($itemMailTemplate->body) 
            });
        @endforeach

        @foreach($dataSales as $itemConnect)      
            that.listAcountSale.push({
                id: '{{$itemConnect->id}}',
                type: 'update',
                ctv_jobs_id: '{{$itemConnect->ctv_jobs_id}}',
                price_total: '{{$itemConnect->price_total}}',
                ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                payplace: '{{$itemConnect->payplace}}',
                status: '{{$itemConnect->status}}',
                info: @json($itemConnect['userInfo']),
            });

        @endforeach
        @foreach($dataCustomer as $itemConnect)

      
            that.listAcountCustomer.push({
                id: '{{$itemConnect->id}}',
                type: 'update',
                cus_jobs_id: '{{$itemConnect->cus_jobs_id}}',
                price_total: '{{$itemConnect->price_total}}',
                ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                status: '{{$itemConnect->status}}',
                info: @json($itemConnect['userInfo']),
            });

        @endforeach
    },
    methods: {
        execCopyClipboad() {
            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();
        },
        copyClipboadCTV(_i) {
            $('#copyName').html(this.parseName(_i.name));
            $('#copyFurigana').html(_i.address);
            $('#copyPhone').html(this.parsePhone(_i.phone));

            this.execCopyClipboad();
        },
        copyClipboadCTVpd(_i) {
            $('#copyName').html(this.parseName(_i.name));
            $('#copyFurigana').html(_i.furigana);
            $('#copyPhone').html(this.parsePhone(_i.phone));

            this.execCopyClipboad();
        },
        copyClipboad(_i) {
            $('#copyName').html(_i.codejob);
            $('#copyFurigana').html(_i.ngay_pd);
            $('#copyPhone').html(_i.address_pd);

            this.execCopyClipboad();
        },
        copyClipboadLink(_i) {
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            var url = baseUrl + "/projectview/" + _i.id;
            $('#copyName').html(url);
            $('#copyFurigana').html("");
            $('#copyPhone').html("");

            this.execCopyClipboad();
        },
        toggelPd() {
            this.showListPD = this.showListPD == 1 ? 0 : 1;
        },
        toggelCus() {
            this.showListCus = this.showListCus == 1 ? 0 : 1;
        },
        toggelCtv() {
            this.showListCtv = this.showListCtv == 1 ? 0 : 1;
        },
        calculatorCheck() {
            var totalAlerMessage = $('#totalIWill').val() - $('#priceDuyTri').val() - $('#priceOrther').val() - $('#priceVat').val() - 500;
            alert("営業者報酬 : "+ (totalAlerMessage * 10 / 100));
        },
        copyClipboad(_i) {
            $('#copyName').html(_i.name);
            $('#copyFurigana').html(_i.furigana);
            $('#copyPhone').html(_i.phone);

            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();

        },
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            // if ('{{@$data->address_pd}}' !=  this.address_pd) {
            //     const that = this;
            //     $.ajax({
            //         type: 'GET',
            //         url: "http://api.positionstack.com/v1/forward?access_key=d4eb3bcee90d3d0a824834770881ce70&query=" + this.address_pd,
            //         success: function(data) {
            //             that.long = data.data[0].latitude;
            //             that.lat = data.data[0].longitude;
            //             setTimeout(function(){ $('.form-data').submit(); }, 1000);

            //         },
            //         error: function(xhr, textStatus, error) {
            //             Swal.fire({
            //                 title: "Có lỗi dữ liệu nhập vào!",
            //                 type: "warning",

            //             });
            //         }
            //     });
            // } else {
            //     setTimeout(function(){ $('.form-data').submit(); }, 1000);
            // }
            setTimeout(function(){ $('.form-data').submit(); }, 1000);
        },
        sendMailTemplate(_idMail) {
            if (this.flagSendMail == 0) {
                Swal.fire({
                    title: "Chọn thông dịch viên và lưu lại trước khi gửi mail.",
                    type: "warning",
                });
                return;
            }
            this.objSendMail = this.listSendMail[_idMail];
            
        },
        
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        convertStatusBank (value) {
            return (value == "1")? "済み" : "";
        },
        convertTaxPlace (value) {
            return (value == "0")? "" : value;
        },
        parseMoney (value) {
            value = (isNaN(value)) ? 0 : value;
            const formatter = new Intl.NumberFormat('ja-JP', {
                style: 'currency',
                currency: 'JPY'
            });
            return formatter.format(value);
        },
        parseMoneyMinus(value) {
            value = this.parseMoney(value);
            return (value == 0)? value : (S_HYPEN + " " +value);
        },
        parseBank (itemBank) {
            var value = itemBank["name_bank"];
            return value;
        },
        parseName (value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parseAddr(value) {
            return this.isNull(value)? S_HYPEN : value;
        },
        parsePhone(value) {
            if (this.isNull(value)) return S_HYPEN;

            value = (new String(value)).replaceAll(S_HYPEN, '').replaceAll(' ', ''); 
            var vLength = value.length;
            if (vLength == 11) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(6, 4);
            } else if (vLength == 10) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(6, 3);
            }
            return value;
        },
        submitSendMail() {
            var body = { 
                _token: CSRF_TOKEN ,
                mail_cc : this.objSendMail.mail_cc,
                title : this.objSendMail.title,
                body : this.objSendMail.body,
                userId : this.userCustomerId
            };
            $.ajax({
                type: 'POST',
                url: '/admin/company/send-mail-template',
                data: body,
                success: function(data) {
                    if (data.code == 200) {
                        Swal.fire({
                            title: "Đã gửi Email!",
                            type: "success",

                        });
                    } else {
                        Swal.fire({
                            title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                            type: "warning",

                        });
                    }
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                        type: "warning",

                    });
                }
            });
            
        },
        onSendEmail() {
            let arrSendMail = [];
            this.list.map(item => {
                if (item.send_mail == 1) {
                    if (!arrSendMail.includes(item.id)) {
                        arrSendMail.push(item.id);
                    }
                }
            });
            if (arrSendMail.length > 0) {
                let listId = arrSendMail.join(',');
                $.ajax({
                    type: 'GET',
                    url: "/admin/company/send-mail?id={{$id}}&list=" + listId,
                    success: function(data) {
                        if (data.code == 200) {
                            Swal.fire({
                                title: "Đã gửi Email!",
                                type: "success",

                            });
                        } else {
                            Swal.fire({
                                title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                                type: "warning",

                            });
                        }
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                            type: "warning",

                        });
                    }
                });
            }
        },
        changeTypeJobs() {
            if (this.loai_job != 1) {
                this.percent_vat_ctvpd  = 0;
            } else {
                if (this.loai_job == 3) {
                    this.price_send_ctvpd = 0;
                }
                this.percent_vat_ctvpd  = 10.21;
            }
        },
        changeTypeHoaHong() {
            if (this.typehoahong == 1) {
                this.percent_vat_ctvpd  = 0;
            } else {
                this.percent_vat_ctvpd  = 10.21;
            }   
        },
        cancleEdit() {
            this.edit_form = 0;
        },
        openEdit() {
            this.edit_form = 1;
        },
        onOpenLoction() {
            window.open("http://maps.google.com/maps?q="+this.ga_gannhat, '_blank');
        },
        onOpenLoctionAddress() {
            window.open("http://maps.google.com/maps?q="+this.address_pd, '_blank');
        },
        onGetSales() {
            this.pageSales = 1;
            this.loadingTableSale = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSale != '') {
                conditionSearch += '&name=' + this.conditionNameSale;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCtvJobs')}}?page=" + this.pageSales  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countSales = data.pageTotal;
                        that.listSales = data.data;
                    } else {
                        that.countSales = 0;
                        that.listSales = [];
                    }
                    that.loadingTableSale = 0;
                    let pageArr = [];
                    if (that.pageSales - 2 > 0) {
                        pageArr.push(that.pageSales - 2);
                    }
                    if (that.pageSales - 1 > 0) {
                        pageArr.push(that.pageSales - 1);
                    }
                    pageArr.push(that.pageSales);
                    if (that.pageSales + 1 <= that.count) {
                        pageArr.push(that.pageSales + 1);
                    }
                    if (that.pageSales + 2 <= that.countSales) {
                        pageArr.push(that.pageSales + 2);
                    }
                    that.listPageSales = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onGetCustomer() {
            this.pageCustomer = 1;
            this.loadingTableCustomer = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSCustomer != '') {
                conditionSearch += '&name=' + this.conditionNameCustomer;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.pageCustomer  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countCustomer = data.pageTotal;
                        that.listCustomer = data.data;
                    } else {
                        that.countCustomer = 0;
                        that.listCustomer = [];
                    }
                    that.loadingTableCustomer = 0;
                    let pageArr = [];
                    // if (that.pageCustomer - 2 > 0) {
                    //     pageArr.push(that.pageCustomer - 2);
                    // }
                    // if (that.pageCustomer - 1 > 0) {
                    //     pageArr.push(that.pageCustomer - 1);
                    // }
                    // pageArr.push(that.pageCustomer);
                    // if (that.pageCustomer + 1 <= that.count) {
                    //     pageArr.push(that.pageCustomer + 1);
                    // }
                    // if (that.pageCustomer + 2 <= that.countCustomer) {
                    //     pageArr.push(that.pageCustomer + 2);
                    // }
                    for (let index = 1; index <= data.pageTotal; index++) {
                        pageArr.push(index);
                        
                    }
                    that.listPageCustomer = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onGetByAddress() {
            this.page = 1;
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.jplt != '') {
                conditionSearch += '&jplt=' + this.jplt;
            }
            if (this.male != '') {
                conditionSearch += '&male=' + this.male;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/collaborators/get-list?" + conditionSearch,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                    } else {
                        that.count = 0;
                        that.list = [];
                    }
                    that.loadingTable = 0;
                    let pageArr = [];
                    if (that.page - 2 > 0) {
                        pageArr.push(that.page - 2);
                    }
                    if (that.page - 1 > 0) {
                        pageArr.push(that.page - 1);
                    }
                    pageArr.push(that.page);
                    if (that.page + 1 <= that.count) {
                        pageArr.push(that.page + 1);
                    }
                    if (that.page + 2 <= that.count) {
                        pageArr.push(that.page + 2);
                    }
                    that.listPage = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        addListRecord(i) {
            
            i.dateList.push({
                id: 'new',
                type: 'add',
                ngay_phien_dich: '',
                gio_phien_dich: '',
                gio_ket_thuc: '',
                gio_tang_ca: '',
                note: '',
                phi_phien_dich: '',
                phi_giao_thong: '',
                // file_bao_cao: '',
                file_hoa_don: ''
            });
        },
        removeListRecord(i) {
            i.type = 'delete';
        },
        removeRecordSales(i) {
            i.type = 'delete';
        },
        removeRecordCustomer(i) {
            i.type = 'delete';
        },
        addRecordSale(i) {
            this.listAcountSale.push({
                id: 'new',
                type: 'add',
                ctv_jobs_id: i.id,
                price_total: '',
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                payplace: 0,
                status: '',
                info: i
            });
        },
        addRecordCustomer(i) {
            this.listAcountCustomer.push({
                id: 'new',
                type: 'add',
                cus_jobs_id: i.id,
                price_total: '',
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                status: '',
                info: i
            });
        },
        addRecord(i) {
            let listDatePd = $('#listDate').val();
            let dateListCheck = [];
            if (listDatePd != '') {
                listDatePd = listDatePd.split(",");
                listDatePd.map(itemMap => {
                    dateListCheck.push({
                        id: 'new',
                        type: 'add',
                        ngay_phien_dich: itemMap,
                        gio_phien_dich: '',
                        gio_ket_thuc: '',
                        gio_tang_ca: '',
                        note: '',
                        phi_phien_dich: '',
                        phi_giao_thong: '',
                        // file_bao_cao: '',
                        file_hoa_don: ''
                    });
                });
            }
            this.listBankAccount.push({
                id: 'new',
                type: 'add',
                collaborators_id: i.id,
                price_total: '',
                bank_id: '',
                listBank: i.bank,
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                dateList: dateListCheck,
                paytaxplace: 0,
                info: i
            });
        },
        removeRecord(i) {
            i.type = 'delete';
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        deleteRecore(_i) {
            const that = this;
            Swal.fire({
                title: "Xác Nhận",
                text: "Bạn có đồng ý xóa giá trị này không?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!",
                cancelButtonText: "Không!",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/company/delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/company";
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",

                        });
                    }
                });

            })
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCollaborators')}}?page=" + this.page + "&name=" + this
                    .conditionName,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                            item.send_mail = 0;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                    } else {
                        that.count = 0;
                        that.list = [];
                    }
                    that.loadingTable = 0;
                    let pageArr = [];
                    if (that.page - 2 > 0) {
                        pageArr.push(that.page - 2);
                    }
                    if (that.page - 1 > 0) {
                        pageArr.push(that.page - 1);
                    }
                    pageArr.push(that.page);
                    if (that.page + 1 <= that.count) {
                        pageArr.push(that.page + 1);
                    }
                    if (that.page + 2 <= that.count) {
                        pageArr.push(that.page + 2);
                    }
                    that.listPage = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onPrePage() {
            if (this.page > 1) {
                this.page = this.page - 1;
            }
            this.onLoadPagination();
        },
        onNextPage() {
            if (this.page < this.count) {
                this.page = this.page + 1;
            }
            this.onLoadPagination();
        },
        onPrePageSales() {
            if (this.pageSales > 1) {
                this.pageSales = this.pageSales - 1;
            }
            this.onGetSalesPage();
        },
        onNextPageSales() {
            if (this.pageSales < this.countSales) {
                this.pageSales = this.pageSales + 1;
            }
            this.onGetSalesPage();
        },
        
        onPageChangeSales(_p) {
            this.pageSales = _p;
            this.onGetSalesPage();
        },
        onGetSalesPage() {
            this.loadingTableSale = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSale != '') {
                conditionSearch += '&name=' + this.conditionNameSale;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCtvJobs')}}?page=" + this.pageSales  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countSales = data.pageTotal;
                        that.listSales = data.data;
                    } else {
                        that.countSales = 0;
                        that.listSales = [];
                    }
                    that.loadingTableSale = 0;
                    let pageArr = [];
                    if (that.pageSales - 2 > 0) {
                        pageArr.push(that.pageSales - 2);
                    }
                    if (that.pageSales - 1 > 0) {
                        pageArr.push(that.pageSales - 1);
                    }
                    pageArr.push(that.pageSales);
                    if (that.pageSales + 1 <= that.count) {
                        pageArr.push(that.pageSales + 1);
                    }
                    if (that.pageSales + 2 <= that.countSales) {
                        pageArr.push(that.pageSales + 2);
                    }
                    that.listPageSales = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        
        onPrePageCustomer() {
            if (this.pageCustomer > 1) {
                this.pageCustomer = this.pageCustomer - 1;
            }
            this.onGetCustomerPage();
        },
        onNextPageCustomer() {
            if (this.pageCustomer < this.countCustomer) {
                this.pageCustomer = this.pageCustomer + 1;
            }
            this.onGetCustomerPage();
        },
        
        onPageChangeCustomer(_p) {
            this.pageCustomer = _p; 
            this.onGetCustomerPage();
        },
        onGetCustomerPage() {
            this.loadingTableCustomer = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSCustomer != '') {
                conditionSearch += '&name=' + this.conditionNameCustomer;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.pageCustomer  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countCustomer = data.pageTotal;
                        that.listCustomer = data.data;
                    } else {
                        that.countCustomer = 0;
                        that.listCustomer = [];
                    }
                    that.loadingTableCustomer = 0;
                    let pageArr = [];
                    // if (that.pageCustomer - 2 > 0) {
                    //     pageArr.push(that.pageCustomer - 2);
                    // }
                    // if (that.pageCustomer - 1 > 0) {
                    //     pageArr.push(that.pageCustomer - 1);
                    // }
                    // pageArr.push(that.pageCustomer);
                    // if (that.pageCustomer + 1 <= that.count) {
                    //     pageArr.push(that.pageCustomer + 1);
                    // }
                    // if (that.pageCustomer + 2 <= that.countCustomer) {
                    //     pageArr.push(that.pageCustomer + 2);
                    // }
                    for (let index = 1; index <= data.pageTotal; index++) {
                        pageArr.push(index);
                        
                    }
                    that.listPageCustomer = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        }


    },
});
</script>

@stop
