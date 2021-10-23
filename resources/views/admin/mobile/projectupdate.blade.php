@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件更新')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <div id="list-data">
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="onSubmit()">
                    <i class="fas fa-save"><span class="labelButton">{{ trans('label.save') }}</span></i>
                </a>
                <a type="button" class="btn btn-outline-secondary3" style="background:red" href="/admin/projectview/{{$id}}">
                    <i class="fas fa-window-close"><span class="labelButton">{{ trans('label.cancel') }}</span></i>
                </a>
            </div>
        </div>
        <div class="container page__container page-section page_container_custom">
            <form action="" method="POST" class="p-0 mx-auto form-data" >
                @csrf
                <div>
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
                </div>
                <div class="col-lg-12">
                    <div class="card dashboard-area-tabs p-relative o-hidden poViewMobile">
                        <div class="card-header p-0 nav">
                            <div class="row no-gutters" role="tablist">
                                <div class="col-auto">
                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active tab_click" id="tab1">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.property') }}</strong>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-auto border-left border-right">
                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab3">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.customer') }}</strong>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-auto border-left border-right">
                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab4">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.sale') }}</strong>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-auto border-left border-right">
                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab5">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.interpreter') }}</strong>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-auto border-left border-right">
                                    <a data-toggle="tab" role="tab" aria-selected="true" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.earning') }}</strong>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane active" id="detailtab1">
                                <div class="row">
                                    <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.id') }}</td>
                                                <td>
                                                    {{@$data->id}}
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.date_start') }}</td>
                                                <td>
                                                <input type="date" name="date_start" class="form-control" required value="{{@$data->date_start}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.status') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <select class="form-control custom-select" name="status">
                                                            <option value="" ></option>
                                                            <!-- <option value="0" @if(@$data->status == 0) selected @endif>{{ trans('label.status0') }}</option> -->
                                                            <option value="1" @if(@$data->status == 1) selected @endif>{{ trans('label.status1') }}</option>
                                                            <option value="2" @if(@$data->status == 2) selected @endif>{{ trans('label.status2') }}</option>
                                                            <option value="3" @if(@$data->status == 3) selected @endif>{{ trans('label.status3') }}</option>
                                                            <option value="4" v-bind:class='loai_job == 1 ? "" : "hidden" ' @if(@$data->status == 4) selected @endif>{{ trans('label.status4') }}</option>
                                                            <option value="5" @if(@$data->status == 5) selected @endif>{{ trans('label.status5') }}</option>
                                                            <option value="8" v-bind:class='loai_job == 2 ? "" : "hidden" ' @if(@$data->status == 8) selected @endif>{{ trans('label.status8') }}</option>
                                                            <option value="6" @if(@$data->status == 6) selected @endif>{{ trans('label.status6') }}</option>
                                                            <option value="7" @if(@$data->status == 7) selected @endif>{{ trans('label.status7') }}</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.type_trans') }}</td>
                                                <td>
                                                    <div >
                                                        <div class="custom-control custom-radio" style="margin:5px;">
                                                            <input id="type_trans_radiotype1" name="type_trans" type="radio" class="custom-control-input" v-model="type_trans" value="1">
                                                            <label for="type_trans_radiotype1" class="custom-control-label">{{ trans('label.type_trans1') }}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="margin:5px;">
                                                            <input id="type_trans_radiotype2" name="type_trans" type="radio" class="custom-control-input" v-model="type_trans" value="2">
                                                            <label for="type_trans_radiotype2" class="custom-control-label">{{ trans('label.type_trans2') }}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="margin:5px;">
                                                            <input id="type_trans_radiotype3" name="type_trans" type="radio" class="custom-control-input" v-model="type_trans" value="3">
                                                            <label for="type_trans_radiotype3" class="custom-control-label">{{ trans('label.type_trans3') }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.language') }}</td>
                                                <td>
                                                    <select class="form-control" name="type_lang">
                                                        <option value="VNM" @if(@$data->type_lang == "VNM") selected @endif>{{ trans('label.type_lang1') }}</option>
                                                        <option value="PHL" @if(@$data->type_lang == "PHL") selected @endif>{{ trans('label.type_lang2') }}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.type') }}</td>
                                                <td>
                                                    <div >
                                                        <div class="custom-control custom-radio" style="margin:5px;">
                                                            <input id="radiotype1" @change="changeTypeJobs()" name="loai_job" type="radio" class="custom-control-input" v-model="loai_job" value="1">
                                                            <label for="radiotype1" class="custom-control-label">{{ trans('label.type1') }}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="margin:5px;">
                                                            <input id="radiotype2" @change="changeTypeJobs()" name="loai_job" type="radio" class="custom-control-input" v-model="loai_job" value="2">
                                                            <label for="radiotype2" class="custom-control-label">{{ trans('label.type2') }}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="margin:5px;">
                                                            <input id="radiotype3" @change="changeTypeJobs()" name="loai_job" type="radio" class="custom-control-input" v-model="loai_job" value="3">
                                                            <label for="radiotype3" class="custom-control-label">{{ trans('label.type3') }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tax_percent') }}</td>
                                                <td>
                                                    <input type="text" name="percent_vat_ctvpd" v-model="percent_vat_ctvpd" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.ngay_phien_dich') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <input type="text" autocomplete="off" name="ngay_pd" id="listDate" class="form-control" required value="{{@$data->ngay_pd}}">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.count_day') }}</td>
                                                <td>{{@$data->total_day_pd}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.address_pd') }}</td>
                                                <td>
                                                    <input type="text" id="address_pd" name="address_pd" class="form-control" required  v-model="address_pd" >
                                                    <!-- <a type="button" style="background:blue" class="btn btn-warning" @click="goGoogleMap()">{{ trans('label.google_map') }}</a> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.contract_money') }}</td>
                                                <td>
                                                    <div class="search-form">
                                                        <input type="text" name="tienphiendich" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->tienphiendich}}') ))" >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.deposit_date') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <input type="date" name="date_company_pay" class="form-control" value="{{@$data->date_company_pay}}" >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>入金口座</td>
                                                <td>
                                                <div class="search-form" >
                                                    <select class="form-control custom-select" name="stk_thanh_toan_id">
                                                        <option value=""></option>
                                                        @foreach($allMyBank as $itemBank)
                                                        <option value="{{$itemBank->id}}" @if(@$data->stk_thanh_toan_id == $itemBank->id)
                                                            selected @endif >
                                                            @if($itemBank->name_bank){{$itemBank->name_bank}}@endif
                                                            - @if($itemBank->stk){{$itemBank->stk}}@endif 
                                                            - @if($itemBank->ten_chusohuu){{$itemBank->ten_chusohuu}}@endif 
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.deposit') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <input type="text" name="tong_thu" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->tong_thu}}') ))">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.deposit_status') }}</td>
                                                <td>
                                                <label class="form-check-label" style="margin-left : 20px">
                                                    <input type="checkbox" name="status_bank" @if(@$data->status_bank == 1) checked @endif value="1">
                                                    {{ trans('label.bank_status_1') }}
                                                </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.employee') }}</td>
                                                <td>
                                                <input type="text" name="employee_id" class="form-control" value="{{@$data->employee_id}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.note') }}</td>
                                                <td>
                                                <textarea type="text" name="description" class="form-control" rows="10">{{@$data->description}}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="detailtab3">
                                <div v-for="(item, index) in listAcountCustomer"　v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                    <div class="row">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.customer') }}</td>
                                                <td>
                                                    {{ trans('label.id_customer') }}(( item.info.id ))<br>
                                                    (( parseName(item.info.name) ))<br>
                                                    (( parseAddr(item.info.address) ))<br>
                                                    {{ trans('label.tel2') }}:(( parsePhone(item.info.phone) ))<br>
                                                    <input type="hidden" v-bind:name="'jobsCustomer['+index+'][id]'" v-model="item.id">
                                                    <input type="hidden" v-bind:name="'jobsCustomer['+index+'][cus_jobs_id]'" v-model="item.cus_jobs_id">
                                                    <input type="hidden" v-bind:name="'jobsCustomer['+index+'][type]'" v-model="item.type">
                                                    <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="removeRecordCustomer(item)">
                                                        <i class="fas fa-trash"><span class="labelButton">削除</span></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.contact_person_id') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <input type="text" v-bind:name="'jobsCustomer['+index+'][contact_user_id]'" class="form-control" v-model="item.contact_user_id">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>                                
                                    <div class="page-separator-line"></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label m-0">{{ trans('label.name') }}</label>
                                            <input type="text" class="form-control search" v-on:keyup.enter="onGetCustomer()" v-model="conditionNameCustomer">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary col-lg-12" type="button" @click="onGetCustomer()">
                                                {{ trans('label.search2') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                            <tbody class="list" id="search">
                                                <tr v-for="item in listCustomer">
                                                    <td>
                                                        <div style="display: flex; justify-content: flex-start; align-items: left;">
                                                            <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="addRecordCustomer(item)">
                                                                <i class="fas fa-plus-square"><span class="labelButton">{{ trans('label.add') }}</span></i>
                                                            </a>
                                                            <a  target="_blank" :href="'/admin/customer-view/' + item.id" >
                                                                <strong class="js-lists-values-employee-name btn btn-outline-secondary" style="text-transform: uppercase;text-align:left">
                                                                    {{ trans('label.id_customer') }}(( item.id ))<br>        
                                                                    ((item.name))<br>
                                                                    {{ trans('label.tel2') }}:(( parsePhone(item.phone) ))<br>
                                                                    (( parseAddr(item.address) ))
                                                                </strong>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="card-footer p-8pt">
                                            <ul class="pagination justify-content-start pagination-xsm m-0">
                                                <li class="page-item" v-bind:class="pageCustomer <= 1 ? 'disabled' : ''" @click="onPrePageCustomer()">
                                                    <a class="page-link"  aria-label="Previous">
                                                        <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                        <span>{{ trans('label.pre_page') }}</span>
                                                    </a>
                                                </li>
                                                <li class="page-item disabled" v-if="pageCustomer > 3 ">
                                                    <a class="page-link" >
                                                        <span>...</span>
                                                    </a>
                                                </li>
                                                <li class="page-item" v-for="item in listPageCustomer"
                                                    v-if="pageCustomer > (item - 3) && pageCustomer < (item + 3) " @click="onPageChangeCustomer(item)"
                                                    v-bind:class="pageCustomer == item ? 'active' : ''">
                                                    <a class="page-link"  aria-label="Page 1">
                                                        <span>((item))</span>
                                                    </a>
                                                </li>
                                                <li class="page-item" @click="onNextPageCustomer()"
                                                    v-bind:class="pageCustomer > count - 1 ? 'disabled' : ''">
                                                    <a class="page-link" >
                                                        <span>{{ trans('label.next_page') }}</span>
                                                        <span aria-hidden="true" class="material-icons">chevron_right</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="detailtab4">
                                <div v-for="(item, index) in listAcountSale"　v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                    <div class="row">
                                    <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                                <tr>
                                                    <td>{{ trans('label.sale') }}</td>
                                                    <td>
                                                        (( parseName(item.info.name) ))<br>
                                                        (( parseAddr(item.info.address) ))<br>
                                                        {{ trans('label.tel2') }}:(( parsePhone(item.info.phone) ))<br>
                                                        <input type="hidden" v-bind:name="'jobsSale['+index+'][id]'" v-model="item.id">
                                                        <input type="hidden" v-bind:name="'jobsSale['+index+'][ctv_jobs_id]'" v-model="item.ctv_jobs_id">
                                                        <input type="hidden" v-bind:name="'jobsSale['+index+'][type]'" v-model="item.type">
                                                        <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="removeRecordSales(item)">
                                                            <i class="fas fa-trash"><span class="labelButton">削除</span></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('label.bank_name1') }}</td>
                                                    <td>
                                                        <select class="form-control custom-select" v-bind:name="'jobsSale['+index+'][payplace]'" v-model="item.payplace">
                                                            <option value="0"></option>
                                                            <option value="1">
                                                                <span v-if=" item.info.ten_bank ">((item.info.ten_bank))</span> 
                                                                <span v-if=" item.info.ms_nganhang ">( ((item.info.ms_nganhang)) ) </span> 
                                                                <span v-if=" item.info.chinhanh ">- ((item.info.chinhanh)) </span>
                                                                <span v-if=" item.info.ms_chinhanh ">( ((item.info.ms_chinhanh)) ) </span> 
                                                                <span v-if=" item.info.loai_taikhoan ">- ((item.info.loai_taikhoan)) </span>
                                                                <span v-if=" item.info.stk ">- ((item.info.stk))</span>
                                                                <span v-if=" item.info.ten_chutaikhoan ">- ((item.info.ten_chutaikhoan))</span>
                                                            </option>      
                                                            </option>
                                                            <option value="2">{{ trans('label.cash') }}</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('label.bank_date') }}</td>
                                                    <td>
                                                        <div class="search-form" >
                                                            <input type="date" v-bind:name="'jobsSale['+index+'][ngay_chuyen_khoan]'" class="form-control" v-model="item.ngay_chuyen_khoan">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('label.sale_cost') }}</td>
                                                    <td>
                                                        <div class="search-form" >
                                                            <input type="text" v-bind:name="'jobsSale['+index+'][price_total]'" class="form-control money_parse" v-model="item.price_total">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('label.bank_fee') }}</td>
                                                    <td>
                                                        <div class="search-form" >
                                                            <input type="text" v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'" class="form-control money_parse1" v-model="item.phi_chuyen_khoan">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('label.bank_status') }}</td>
                                                    <td>
                                                        <label class="form-check-label" style="margin-left : 20px">
                                                            <input  type="checkbox" v-bind:name="'jobsSale['+index+'][status]'" v-model="item.status" value="1" true-value="1" false-value="0">
                                                            {{ trans('label.bank_status_1') }}
                                                        </label>
                                                    </td>
                                                </tr>
                                            </table>
                                    </div>                                
                                    <div class="page-separator-line"></div>
                                </div>
                                <div class="row">
                                <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label m-0">{{ trans('label.name') }}</label>
                                                <input type="text" class="form-control search" v-on:keyup.enter="onGetSales()" v-model="conditionNameSale">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary col-lg-12" type="button" @click="onGetSales()">{{ trans('label.search2') }}</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                                <tbody class="list" id="search">
                                                    <tr v-for="item in listSales">
                                                        <td>
                                                            <div style="display: flex; justify-content: flex-start; align-items: left;">
                                                                <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="addRecordSale(item)">
                                                                    <i class="fas fa-plus-square"><span class="labelButton">{{ trans('label.add') }}</span></i>
                                                                </a>
                                                                <a  target="_blank" :href="'/admin/partner-sale-view/' + item.id" >
                                                                    <strong class="js-lists-values-employee-name btn btn-outline-secondary" style="text-transform: uppercase;text-align:left">
                                                                            ((item.name))<br>
                                                                            (( parseAddr(item.address) ))<br>
                                                                            {{ trans('label.tel2') }}:(( parsePhone(item.phone) ))
                                                                    </strong>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="card-footer p-8pt">
                                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                                    <li class="page-item" v-bind:class="pageSales <= 1 ? 'disabled' : ''" @click="onPrePageSales()">
                                                        <a class="page-link"  aria-label="Previous">
                                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                            <span>{{ trans('label.pre_page') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item disabled" v-if="pageSales > 3 ">
                                                        <a class="page-link" >
                                                            <span>...</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" v-for="item in listPageSales"
                                                        v-if="pageSales > (item - 3) && pageSales < (item + 3) " @click="onPageChangeSales(item)"
                                                        v-bind:class="pageSales == item ? 'active' : ''">
                                                        <a class="page-link"  aria-label="Page 1">
                                                            <span>((item))</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" @click="onNextPageSales()"
                                                        v-bind:class="pageSales > count - 1 ? 'disabled' : ''">
                                                        <a class="page-link" >
                                                            <span>{{ trans('label.next_page') }}</span>
                                                            <span aria-hidden="true" class="material-icons">chevron_right</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="detailtab5">
                                <div v-for="(item, index) in listBankAccount"　v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                    <div class="row">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.interpreter') }}</td>
                                                <td>
                                                    <i v-if="item.info.male == 1" class="fa fa-male maleClass"></i>
                                                    <i v-if="item.info.male == 2" class="fa fa-female femaleClass"></i>
                                                    (( parseName(item.info.name) ))<br>
                                                    <span>(( parseAddr(item.info.address) ))</span><br>
                                                    <span>{{ trans('label.tel2') }}:(( parsePhone(item.info.phone) ))</span><br>
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][id]'" v-model="item.id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][collaborators_id]'" v-model="item.collaborators_id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][type]'" v-model="item.type">
                                                    <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="removeRecord(item)">
                                                        <i class="fas fa-trash"><span class="labelButton">{{ trans('label.delete') }}</span></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.bank_name1') }}</td>
                                                <td>
                                                    <select class="form-control custom-select" v-bind:name="'jobsConnect['+index+'][bank_id]'" v-model="item.bank_id">
                                                        <option value=""></option>
                                                        <option v-for="itemBank in item.listBank" v-bind:value='itemBank.id'>
                                                            <span v-if=" itemBank.ten_bank ">((itemBank.ten_bank))</span> 
                                                            <span v-if=" itemBank.chinhanh ">- ((itemBank.chinhanh)) </span>
                                                            <span v-if=" itemBank.loai_taikhoan ">- ((itemBank.loai_taikhoan)) </span>
                                                            <span v-if=" itemBank.stk ">- ((itemBank.stk))</span>
                                                            <span v-if=" itemBank.ten_chutaikhoan ">- ((itemBank.ten_chutaikhoan))</span>
                                                        </option>
                                                        <option value="2">{{ trans('label.cash') }}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.bank_date') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <input type="date" v-bind:name="'jobsConnect['+index+'][ngay_chuyen_khoan]'" class="form-control" v-model="item.ngay_chuyen_khoan">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.transfer_money') }}</td>
                                                <td>
                                                    (( parseMoney(item.price_total) ))
                                                    <!-- <input type="text" v-bind:name="'jobsConnect['+index+'][price_total]'" class="form-control" readonly v-model="item.price_total"> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.bank_fee') }}</td>
                                                <td>
                                                    <input type="text" v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'" class="form-control" v-model="item.phi_chuyen_khoan">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.bank_status') }}</td>
                                                <td>
                                                <label class="form-check-label" style="margin-left:20px">
                                                    <input  type="checkbox" v-bind:name="'jobsConnect['+index+'][status]'" v-model="item.status" value="1" true-value="1" false-value="0">
                                                    {{ trans('label.bank_status_1') }}
                                                </label>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td>{{ trans('label.tax_place') }}</td>
                                                <td>
                                                    <select class="form-control custom-select" v-bind:name="'jobsConnect['+index+'][paytaxplace]'" v-model="item.paytaxplace">
                                                        <option value=""></option>
                                                        <option value="松戸税務署">{{ trans('label.matsudo_tax') }}</option>
                                                    </select>
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td>{{ trans('label.tax_date') }}</td>
                                                <td>
                                                <input type="date" v-bind:name="'jobsConnect['+index+'][paytaxdate]'" class="form-control" v-model="item.paytaxdate">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tax_org_value') }}</td>
                                                <td>
                                                    (( parseMoney(item.phi_phien_dich_total) ))
                                                    <!-- <input type="number" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'" class="form-control" readonly v-model="item.phi_phien_dich_total">  -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tax_percent') }}</td>
                                                <td>
                                                {{@$data->percent_vat_ctvpd}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tax') }}</td>
                                                <td>
                                                    (( parseMoney(item.thue_phien_dich_total) ))
                                                    <!-- <input type="number" v-bind:name="'jobsConnect['+index+'][thue_phien_dich_total]'" class="form-control" readonly v-model="item.thue_phien_dich_total"> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tax_status') }}</td>
                                                <td>
                                                    <label class="form-check-label" style="margin-left:20px">
                                                        <input  type="checkbox" v-bind:name="'jobsConnect['+index+'][paytaxstatus]'" v-model="item.paytaxstatus" value="1" true-value="1" false-value="0">
                                                        {{ trans('label.bank_status_1') }}
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.ngay_phien_dich') }}</td>
                                                <td>
                                                    <div class="search-form" >
                                                        <input type="date" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][ngay_phien_dich]'" readonly class="form-control" v-model="item1.ngay_phien_dich">
                                                    </div>
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][id]'" class="form-control" v-model="item1.id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][type]'" class="form-control" v-model="item1.type">
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.begin_time') }}</td>
                                                <td>
                                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_phien_dich]'" class="form-control" v-model="item1.gio_phien_dich">
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.end_time') }}</td>
                                                <td>
                                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_ket_thuc]'" class="form-control" v-model="item1.gio_ket_thuc">
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.route_move') }}</td>
                                                <td>
                                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_tang_ca]'" class="form-control" v-model="item1.gio_tang_ca">
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.interpreter_cost') }}</td>
                                                <td>
                                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_phien_dich]'" class="form-control" v-model="item1.phi_phien_dich">
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.move_fee') }}</td>
                                                <td>
                                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_giao_thong]'" class="form-control" v-model="item1.phi_giao_thong">
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.receipt') }}</td>
                                                <td>
                                                    <input v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][file_hoa_don]'" class="form-control"  type="text" v-bind:id="'chooseImage_inputfilehd'+index1" v-model="item1.file_hoa_don">
                                                    <a type="button" class="btn btn-outline-secondary3" style="background:MediumOrchid" onclick="chooseFile(this)"  :rel="'filehd'+index1">
                                                        <i class="fas fa-upload"><span class="labelButton">{{ trans('label.upload') }}</span></i>
                                                    </a>
                                                    <a type="button" class="btn btn-outline-secondary3" style="background:Crimson" onclick="clearFile(this)" :rel="'filehd'+index1">
                                                        <i class="fas fa-trash"><span class="labelButton">{{ trans('label.clear') }}</span></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.report_content') }}</td>
                                                <td>
                                                    <textarea type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][note]'" class="form-control" rows="10" >((item1.note))</textarea>
                                                </td>
                                            </tr>
                                            <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
                                                <td>{{ trans('label.note') }}</td>
                                                <td>
                                                    <textarea type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][note2]'" class="form-control" rows="5" >((item1.note2))</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="page-separator-line"></div> 
                                </div>
                                <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label m-0">{{ trans('label.name') }}</label>
                                                <input type="text" class="form-control search" v-on:keyup.enter="onGetByAddress()" v-model="conditionName">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary col-lg-12" type="button" @click="onGetByAddress()">{{ trans('label.search2') }}</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-10">
                                            <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                                <tbody class="list" id="search">
                                                    <tr v-for="item in list">
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <div class="flex title-edit">
                                                                    <div style="display: flex; justify-content: flex-start; align-items: left;">
                                                                        <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="addRecord(item)">
                                                                            <i class="fas fa-plus-square"><span class="labelButton">{{ trans('label.add') }}</span></i>
                                                                        </a>
                                                                        <a  target="_blank" :href="'/admin/partner-interpreter-view/' + item.id" >
                                                                            <strong class="js-lists-values-employee-name btn btn-outline-secondary" style="text-transform: uppercase;text-align:left;" >
                                                                                    <i v-if="item.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                                    <i v-if="item.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                                    ((item.name))<br>
                                                                                    (( parseAddr(item.address) ))<br>
                                                                                    {{ trans('label.tel2') }}:(( parsePhone(item.phone) ))
                                                                            </strong>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="card-footer p-8pt">
                                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                                    <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''" @click="onPrePage()">
                                                        <a class="page-link"  aria-label="Previous">
                                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                            <span>{{ trans('label.pre_page') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item disabled" v-if="page > 3 ">
                                                        <a class="page-link" >
                                                            <span>...</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" v-for="item in listPage"
                                                        v-if="page > (item - 3) && page < (item + 3) " @click="onPageChange(item)"
                                                        v-bind:class="page == item ? 'active' : ''">
                                                        <a class="page-link"  aria-label="Page 1">
                                                            <span>((item))</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" @click="onNextPage()"
                                                        v-bind:class="page > count - 1 ? 'disabled' : ''">
                                                        <a class="page-link" >
                                                            <span>{{ trans('label.next_page') }}</span>
                                                            <span aria-hidden="true" class="material-icons">chevron_right</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="detailtab2">
                                <div class="row">
                                    <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                        <tr>
                                            <td>{{ trans('label.gues') }}{{ trans('label.earning') }}</td>
                                            <td>
                                            <div class="search-form">
                                                <input type="text" name="tong_thu_du_kien" id="totalIWill" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->tong_thu_du_kien}}') ))">
                                            </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.gues') }}{{ trans('label.sale_cost') }}</td>
                                            <td>
                                                <input type="text" name="price_sale" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->price_sale}}') ))">
                                                <a @click="calculatorCheck()" target="_blank" style="background-color: #5567ff;" class="btn btn-outline-secondary3">
                                                    <span class="labelButton">{{ trans('label.earning_gues') }}</span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.gues') }}{{ trans('label.interpreter_cost') }}</td>
                                            <td>
                                                <div class="search-form" >
                                                    <input type="text" name="price_send_ctvpd" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->price_send_ctvpd}}') ))">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.gues') }}{{ trans('label.move_fee') }}</td>
                                            <td>
                                                <div class="search-form" >
                                                    <input type="text"  id="priceOrther" name="ortherPrice" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->ortherPrice}}') ))">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.gues') }}{{ trans('label.bank_fee') }}</td>
                                            <td>
                                                <div class="search-form" >
                                                    <input type="text"  id="price_company_duytri" name="price_company_duytri" class="form-control money_parse" :value="(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format('{{@$data->price_company_duytri}}') ))">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </form>
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



<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });
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
        edit_form: 1,
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
        type_trans : '{{@$data->type_trans}}',
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
        typehoahong: '{{$data->typehoahong}}',
        percent_vat_ctvpd: '{{$data->percent_vat_ctvpd}}',
        showListPD : 0,
        showListCus : 0,
        showListCtv : 0,
        isMobile : ( viewPC )? false : true,
        marginTop: "100px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classRowContent: (viewPC)? "" : "rowContent ",
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
            }
        );
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
                contact_user_id: '{{$itemConnect->contact_user_id}}',
                contact_user_name: '{{$itemConnect->contact_user_name}}',
                contact_user_phone: '{{$itemConnect->contact_user_phone}}',
                info: @json($itemConnect['userInfo']),
            });
        @endforeach
    },
    methods: {
        
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        parseName (value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parseAddr(value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parsePhone(value) {
            if (this.isNull(value)) return S_HYPEN;

            value = (new String(value)).replaceAll(S_HYPEN, '').replaceAll(' ', ''); 
            var vLength = value.length;
            if (vLength == 11) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(7, 4);
            } else if (vLength == 10) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(7, 3);
            }
            return value;
        },
        parseMoney (value) {
            value = (isNaN(value)) ? 0 : value;
            const formatter = new Intl.NumberFormat('ja-JP', {
                style: 'currency',
                currency: 'JPY',currencyDisplay: 'name'
            });
            return formatter.format(value);
        },
        changeTienPhienDich() {
            var flagPrice = $('#tienphiendich').val();
            flagPrice = parseInt(flagPrice.replace('￥' , '').replace(',', '').replace('.',''));
            $('#tienphiendichdata').val(flagPrice);
            if (flagPrice) {
                $('#tienphiendichdata').val(flagPrice);
                flagPrice = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(flagPrice);
            } else {
                flagPrice = '';
                $('#tienphiendichdata').val(flagPrice);
            }
            $('#tienphiendich').val(flagPrice);
        },
        goGoogleMap() {
            var address = $('#address_pd').val();
            if (address.trim() == '') {
                alert("Nhập địa chỉ.");
                return false;
            }
            var win = window.open('https://www.google.com/maps/place/'+address, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
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
            setTimeout(function(){ 
                $('.form-data').submit();
                // document.getElementById('btnCancel').click();//fake a click on the link
            }, 1000);
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
                this.percent_vat_ctvpd  = 10.23;
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
            conditionSearch += "&showcount=20";
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
                contact_user_id: '',
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
            conditionSearch += "&showcount=20";
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
