@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '売上')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')
    <div id="list-data">
        <div class="modal fade" id="leftMenu">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <div class="page-separator">
                            <div class="page-separator__text bgWhite">{{ trans("label.search2") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px; margin-right:0px;">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                                        <input type="date" class="form-control search" v-model="ngay_phien_dich" min="2021-03-17" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">                        
                                        <label class="form-label">{{ trans('label.thang_phien_dich') }}</label>
                                        <input type="month" class="form-control search"  v-model="thang_phien_dich"  min="2021-03" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.ngay_phien_dich_from') }}</label>
                                        <input type="date" class="form-control search" v-model="ngay_phien_dich_from" min="2021-03-17" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.ngay_phien_dich_to') }}</label>
                                        <input type="date" disabled class="form-control search" v-model="ngay_phien_dich_to" min="2021-03-17" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text bgWhite">
                            {{ trans("label.sum_search") }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px; margin-right:0px;">
                                    <div class="form-group col-lg-12">
                                        <a class="dropdown-item" target="_blank" @click="lastMonthProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.lastmonth') }}<span>(</span>(( getLastMonth() ))<span>)</span></span>
                                        </a>  
                                        <a class="dropdown-item" target="_blank" @click="thisMonthProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.thismonth') }}<span>(</span>(( getThisMonth() ))<span>)</span></span>
                                        </a>  
                                        <a class="dropdown-item" target="_blank" @click="thisYearProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.thisyear') }}<span>(</span>(( getThisYear() ))<span>)</span></span>
                                        </a>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text bgWhite">
                            {{ trans("label.graph") }}( {{ trans("label.earning") }})
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px; margin-right:0px;">
                                    <div class="form-group col-lg-12">
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChart" data-target="#myModalChartToday">
                                            <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.list_count_order_day2') }}</span>
                                        </a>     
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChartMonth" data-target="#myModalChartMonth">
                                            <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.list_count_order_month2') }}</span>
                                        </a>      
                                        <a class="dropdown-item" data-toggle="modal" @click="loadChartYear" data-target="#myModalChartYear">
                                            <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.this10YearGraph_count2') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartToday">
            <div class="modal-dialog char-h-mobile" >
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.msg4_day') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center class="col-lg-12">
                            <div class="d-flex col-lg-3">
                                <input type="month" class="form-control search" id="chart_today" @change="onLoadChart"  min="2021-03" value="{{ date('Y-m') }}">
                            </div>
                        </center>
                        <div class="flex" id="chart5" style="max-width: 100%;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartMonth">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.msg4_month') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center class="col-lg-12">
                            <div class="d-flex col-lg-2">
                                <select id="selLang" @change="onLoadChartMonth()" class="form-control search" v-model="thisYear" >
                                    <option value="2021" selected>2021年</option>
                                    <option value="2022">2022年</option>
                                    <option value="2023">2023年</option>
                                    <option value="2024">2024年</option>
                                    <option value="2025">2025年</option>
                                    <option value="2026">2026年</option>
                                    <option value="2027">2027年</option>
                                    <option value="2028">2028年</option>
                                    <option value="2029">2029年</option>
                                    <option value="2030">2030年</option>                        
                                </select>
                            </div>
                        </center>
                        <div class="flex" id="chart6" style="max-width: 100%;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartYear">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.msg4_year') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="flex" id="chart7" style="max-width: 100%;margin-top:20px;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.search_header') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.id') }}</label>
                                <input type="text" class="form-control search" v-model="codeJobs">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-12">                        
                                <label class="form-label">{{ trans('label.thang_phien_dich') }}</label>
                                <input type="month" class="form-control search"  v-model="thang_phien_dich"  min="2021-03">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_from') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_to') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_to" min="2021-03-17" disabled>
                            </div>                            
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" value="0" id="akaji" v-model="checkAkaji">
                                <label for="akaji" class="statusMinus">{{ trans('label.akaji') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.status') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="0" value="0" v-model="checkedNames">
                                <label class="statusOther" for="0">{{ trans('label.status0') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames">
                                <label class="statusOther" for="1">{{ trans('label.status1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames">
                                <label class="status2" for="2">{{ trans('label.status2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="3" value="3" v-model="checkedNames">
                                <label class="status458" for="3">{{ trans('label.status3') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="8" value="8" v-model="checkedNames">
                                <label class="status458" for="8">{{ trans('label.status8') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="4" value="4" v-model="checkedNames">
                                <label class="status458" for="4">{{ trans('label.status4') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="5" value="5" v-model="checkedNames">
                                <label class="status458" for="5">{{ trans('label.status5') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="6" value="6" v-model="checkedNames">
                                <label class="status6" for="6">{{ trans('label.status6') }}</label>
                            </div>
                           
                            <div class="form-group col-lg-12">
                                <button type="button" @click="clearSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_off') }}</button>
                                <button type="button" @click="setSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_on') }}</button>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sale') }}</label>
                                <input type="text" class="form-control search" v-model="ctv_sale">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.interpreter') }}</label>
                                <input type="text" class="form-control search" v-model="ctv_pd">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.type') }}</label>  
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type0" value="1" v-model="checkedTypes">
                                <label for="type0">{{ trans('label.type1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type1" value="2" v-model="checkedTypes">
                                <label for="type1">{{ trans('label.type2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type2" value="3" v-model="checkedTypes">
                                <label for="type2">{{ trans('label.type3') }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <a type="button" class="btn btn-outline-secondary3 clearButtonBg" @click="clearSearch()">
                            <span class="labelButton">{{ trans('label.clear_search') }}</span>
                        </a>
                        <a type="button" class="btn btn-outline-secondary3 searchButtonBg" @click="someHandlerChange()" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.search2') }}</span>
                        </a>
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3 pdfButtonBg" target="_blank" :href="'/admin/earnings-pdf?' + conditionSearch">
                    <i class="fa fa-file-pdf"><span class="labelButton">{{ trans('label.pdf_table') }}</span></i>
                </a> 
                <a type="button" class="btn btn-outline-secondary3 searchButtonBg" data-toggle="modal" data-target="#myModal">
                    <i class="fas fa-search"><span class="labelButton">{{ trans('label.search') }}</span></i>
                </a> 
                <div class="vl3"></div> 
                <a type="button" class="btn btn-outline-secondary3 menuButtonMobile" data-toggle="modal" data-target="#leftMenu">
                    <i class="fas fa-th-large"></i>
                </a> 
            </div>
        </div>
        <div class="row">
            <div class="d-flex fullWidthMobile">
                <div class="gridControl3">
                    <label class="form-label">{{ trans('label.number_show') }}</label>
                    <select id="showCount" @change="someHandlerChangeShowCount()" v-model="showCount" >
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="0">全て</option>
                    </select>
                    <label class="form-label">of ((sumCount)) {{ trans('label.ken') }}</label>
                </div>
                <div class="vl"></div>
                <a @click="resetSearch()" type="button" class="btn btn-outline-secondary updateButton">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </div>
        <div class="container page__container page-section page_container_custom">
            <div class="bodyContent">
                <div class="bodyContentRight tableFixHead">
                    <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr> 
                                <th scope="col" @click="sort('id')" >
                                    <div v-bind:class="[sortBy === 'id' ? sortDirection : '']">{{ trans('label.project') }}</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list" id="search">
                            <tr v-for="item in sortedProducts">
                                <td :class="item.classStyle  + ' '">
                                <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/projectview/' + item.id">
                                        {{ trans('label.id') }}((item.id)) (<span v-if='item.status == 1'>{{ trans('label.status1') }}</span>
                                                            <span v-if='item.status == 2'>{{ trans('label.status2') }}</span>
                                                            <span v-if='item.status == 3'>{{ trans('label.status3') }}</span>
                                                            <span v-if='item.status == 8'>{{ trans('label.status8') }}</span>
                                                            <span v-if='item.status == 4'>{{ trans('label.status4') }}</span>
                                                            <span v-if='item.status == 5'>{{ trans('label.status5') }}</span>
                                                            <span v-if='item.status == 6'>{{ trans('label.status6') }}</span>
                                                            <span v-if='item.status == 7'>{{ trans('label.status7') }}</span>)
                                    </a><br>
                                    <span v-for="itemCTV in item.ctv_sales_list">
                                        <u><b>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}</b></u><br>
                                    </span>
                                    (( item.ngay_pd )) ((item.address_pd))<br>
                                    <div v-for="itemCTV in item.ctv_list">
                                        <div>
                                            <i v-if="itemCTV.male == 1" class="fa fa-male maleClass"></i>
                                            <i v-if="itemCTV.male == 2" class="fa fa-female femaleClass"></i>  
                                            (( parseName(itemCTV.name) )) (<span>
                                                <a target="_blank" :href="'tel:'+itemCTV.phone">
                                                (( parsePhone(itemCTV.phone) ))
                                                </a>
                                                </span>)
                                        </div>
                                    </div>
                                    <span class="moneyCol" >
                                    {{ trans('label.earning') }}: (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(item.tong_thu) )) (<span>{{ trans('label.benefit') }}: (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(item.price_nhanduoc) ))</span>)
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>                       
                    <div class="card-footer p-8pt">
                        <ul class="pagination justify-content-start pagination-xsm m-0">
                            <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''"
                                @click="onPrePage()">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true" class="material-icons">chevron_left</span>
                                    <span>{{ trans('label.pre_page') }}</span>
                                </a>
                            </li>
                            <li class="page-item disabled" v-if="page > 3 ">
                                <a class="page-link" href="#">
                                    <span>...</span>
                                </a>
                            </li>
                            <li class="page-item" v-for="item in listPage"
                                v-if="page > (item - 3) && page < (item + 3) " @click="onPageChange(item)"
                                v-bind:class="page == item ? 'active' : ''">
                                <a class="page-link" href="#" aria-label="Page 1">
                                    <span>((item))</span>
                                </a>
                            </li>
                            <li class="page-item" @click="onNextPage()"
                                v-bind:class="page > count - 1 ? 'disabled' : ''">
                                <a class="page-link" href="#">
                                    <span>{{ trans('label.next_page') }}</span>
                                    <span aria-hidden="true" class="material-icons">chevron_right</span>
                                </a>
                            </li>
                        </ul>
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

</div>

<!-- menu -->
@include('admin.component.left-bar')
@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>


<link href="{{ asset('assets/charts/jquery.jqplot.min.css') }}" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{ asset('assets/charts/shCoreDefault.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ asset('assets/charts/shThemejqPlot.min.css') }}" />
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jquery.jqplot.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/charts/shCore.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/charts/shBrushJScript.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/charts/shBrushXml.min.js') }}"></script>
<!-- Additional plugins go here -->

<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.barRenderer.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.pieRenderer.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.categoryAxisRenderer.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.pointLabels.min.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/charts/jqplot.canvasOverlay.min.js') }}"></script>


<script class="code" type="text/javascript">

$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [];
        var ticks = [];
    });
</script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
let d = new Date();
let year = d.getFullYear();
let month = String(d.getMonth() + 1);
let day = String(d.getDate());

function convertDate(d) {
    let year = d.getFullYear()
    let month = String(d.getMonth() + 1)
    let day = String(d.getDate())

    // Adding leading 0 if the day or month
    // is one digit value
    month = month.length == 1 ? 
        month.padStart('2', '0') : month;

    day = day.length == 1 ? 
    day.padStart('2', '0') : day;

    return `${year}-${month}-${day}`;
}
let today = convertDate(d);

new Vue({
    el: '#list-data',
    data: {
        thisMonth: month,
        thisYear: year,
        thisDay: day,
        selYear: '',
        selMonth: '',
        selDay: '',
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        conditionSearch: '',
        sumCount: 0,
        listPage: [],
        conditionName: '',
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        groups: [],
        conditionStatus: '',
        conditionAddress: '',
        ngay_phien_dich: '',
        ngay_phien_dich_from: '',
        ngay_phien_dich_to: today,
		thang_phien_dich: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        dateOrder_from: '',
        dateOrder_to: '',
        dateOrder_month: '',
        codeJobs: '',
        checkedNames: [0,1,2,3,4,5,6,8],
		checkedTypes: [1,2,3],
        checkedCTVSex: [1,2],
        sortName: '',
        sortType:"DESC",
        sortNameSelect : '1',
        showCount: '20',
        isMobile : ( viewPC )? false : true,
        type_show: ( viewPC )? 1 : 2,
        checkAkaji: 0,
        marginTop: "30px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classBodayRightContentGrid: (viewPC)? "bodayRightContentGrid" : "",
        classColLG12: (viewPC)? "col-lg-12" : "colLg12Mobile",
        classRightGrid: "col-lg-10",
        classLefttGrid: "col-lg-2",
        hiddenMenu: "displayNone",
        sortBy: 'codejob',
        sumTongThuDuKien: 0,
        sumTongKimDuocDuKien: 0,
        sortDirection: 'desc',
        sumEarning:'',
        sumBenefit:'',
        dayPrices: [],
        yearReportPrice: [],
        everyYearReportPrice: [],
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
    },
    computed: {
        sortedProducts: function(){
            return this.list.sort((p1,p2) => {

                let modifier = 1;
                if(this.sortDirection === 'desc') modifier = -1;
                if (this.sortBy == 'ctv_sales_list' || this.sortBy == 'ctv_list') {
                    if(p1[this.sortBy].length == 0 && p2[this.sortBy].length > 0) return -1 * modifier; 
                    if(p1[this.sortBy].length > 0 && p2[this.sortBy].length == 0) return 1 * modifier;
                    if(p1[this.sortBy].length == 0 && p2[this.sortBy].length == 0) return 0;

                    if(p1[this.sortBy][0]['name'] < p2[this.sortBy][0]['name']) return -1 * modifier; 
                    if(p1[this.sortBy][0]['name'] > p2[this.sortBy][0]['name']) return 1 * modifier;
                    return 0;
                } else {
                    if(p1[this.sortBy] < p2[this.sortBy]) return -1 * modifier; 
                    if(p1[this.sortBy] > p2[this.sortBy]) return 1 * modifier;
                    return 0;
                }
            });
        }
    },
    methods: {
        getYesterday: function () {
            // Creating the date instance
            let d = new Date();
            
            // Adding one date to the present date
            d.setDate(d.getDate() - 1);

            let year = d.getFullYear()
            let month = String(d.getMonth() + 1)
            let day = String(d.getDate())

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
                month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            return `${year}-${month}-${day}`;
        },
        getToday: function() {
            let d = new Date();

            let year = d.getFullYear()
            let month = String(d.getMonth() + 1)
            let day = String(d.getDate())

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
                month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            return `${year}-${month}-${day}`;
        },
        getThisYear: function() {
            let d = new Date();
            
            let year = d.getFullYear();
            return `${year}`;
        },
        getThisMonth: function () {
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth() + 1)
            let day = String(d.getDate());

            month = month.length == 1 ? month.padStart('2', '0') : month;
            return `${year}-${month}`;
        },
        getLastMonth: function () {
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth());
            let day = String(d.getDate());

            month = month.length == 1 ? month.padStart('2', '0') : month;
            return `${year}-${month}`;
        },
        HideLeft: function() {
            if (this.classRightGrid == "col-lg-12") {
                this.classRightGrid = "col-lg-10";
                this.classLefttGrid = "col-lg-2";
                this.hiddenMenu = "displayNone";
            } else {
                this.classRightGrid = "col-lg-12";
                this.classLefttGrid = "col-lg-0 displayNone";
                this.hiddenMenu = "";
            }
        },
        thisYearProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
            let d = new Date();
            let year = d.getFullYear();

            this.ngay_phien_dich_from = `${year}-01-01`;
            this.ngay_phien_dich_to = `${year}-12-31`;
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        thisMonthProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth() + 1);
            let day = String(d.getDate());

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
            month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            this.thang_phien_dich = `${year}-${month}`;
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        lastMonthProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth());
            let day = String(d.getDate());

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
            month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            this.thang_phien_dich = `${year}-${month}`;
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        sort: function(s){
            if(s === this.sortBy) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            }
            this.sortBy = s;
        },
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
            $('#copyFurigana').html("");
            $('#copyPhone').html("");

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
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChange: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChangeShowCount() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChangeSortName: function () {
            var selVal = this.sortNameSelect;
            
            var sName = "company.id";
            var sType = "DESC";
            var lblOrderNumber = "受注番号";
            var lblOrderStatus = "ステータス";
            var lblOrderDate = "通訳日";
            switch (selVal) {
                case "1":
                    sName = "company.codejob";
                    sType = "DESC";
                    lblOrderNumber = "受注番号 ▼";
                    break;
                case "2":
                    sName = "company.codejob";
                    sType = "ASC";
                    lblOrderNumber = "受注番号 ▲";
                    break;
                case "3":
                    sName = "company.ngay_pd";
                    sType = "DESC";
                    lblOrderDate = "通訳日 ▼";
                    break;
                case "4":
                    sName = "company.ngay_pd";
                    sType = "ASC";
                    lblOrderDate = "通訳日 ▲";
                    break;
                case "5":
                    sName = "company.status";
                    sType = "DESC";
                    lblOrderStatus = "ステータス ▼";
                    break;
                case "6":
                    sName = "company.status";
                    sType = "ASC";
                    lblOrderStatus = "ステータス ▲";
                    break;
            }

            this.sortName = sName;
            this.sortType = sType;
            $("#lblOrderNumber").text(lblOrderNumber);   
            $("#lblOrderStatus").text(lblOrderStatus); 
            $("#lblOrderDate").text(lblOrderDate);
            
            this.page = 1;
            this.onLoadPagination();
        },
        switchView: function() {
            this.type_show = (this.type_show == 1) ? 2 : 1;
        },
        resetSearch() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.dateOrder_from = '';
            this.dateOrder_to = '';
            this.dateOrder_month = '';
            this.ngay_phien_dich = '';
            this.ngay_phien_dich_from = '';
            this.ngay_phien_dich_to = '';
			this.thang_phien_dich = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";    
            this.checkAkaji= 0;   
            
            this.onLoadPagination();
        },
        clearSearchCondition() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.dateOrder_from = '';
            this.dateOrder_to = '';
            this.dateOrder_month = '';
            this.ngay_phien_dich = '';
            this.ngay_phien_dich_from = '';
            this.ngay_phien_dich_to = '';
			this.thang_phien_dich = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;     
        },
        clearSearch() {
            this.clearSearchCondition();
            
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            this.onLoadPagination();
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
            // this.onLoadPagination();
		},
		clearSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [];
            // this.onLoadPagination();
		},
		setSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [1,2,3];
            // this.onLoadPagination();
		},
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
        onLoadChart() {
            var selDate = document.getElementById("chart_today").value;
            this.selYear = selDate.split('-')[0];
            this.selMonth = selDate.split('-')[1];
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListProject')}}?year=" + that.selYear  + "&month=" + that.selMonth,
                success: function(data) {
                    if (data.count > 0) {
                        that.dayPrices = data.dayPrices;
                    } else {
                        that.dayPrices = [];
                    }
                    that.loadChart();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChart() {
            var selDate = document.getElementById("chart_today").value;
            this.selYear = selDate.split('-')[0];
            this.selMonth = selDate.split('-')[1];
            var ticks5 = [];
            
            $.jqplot.config.enablePlugins = true;
            var s7 = [];
            var s10 = [];
            var s7_guess = [];
            var s10_guess = [];
            const that = this;
            var d = new Date(this.thisYear, this.thisMonth, 0);
            let lastday = String(d.getDate());
            Object.keys(this.dayPrices).map(function(key , value) {
                s7.unshift(that.dayPrices[key][2]);
                s10.unshift(that.dayPrices[key][3]);
                s7_guess.unshift(that.dayPrices[key][0]);
                s10_guess.unshift(that.dayPrices[key][1]);
                var d = new Date(that.dayPrices[key][4]);
                year = d.getFullYear();
                month = '' + (d.getMonth() + 1);
                day = '' + d.getDate();
                // ticks5.unshift(month + '/' + day);
                // if (d.getDate() == lastday) {
                    day = day +'日';
                // }
                if (d.getDate() == that.thisDay && month == that.thisMonth && year == that.thisYear) {
                    day = '<span style="color:red;border-bottom:1px solid red">'+day+'</span>';
                }
                ticks5.unshift(day);
            });
            setTimeout(function(){ 
                plot5 = $.jqplot('chart5', [s7,s10,s7_guess,s10_guess], {
                    // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                    animate: !$.jqplot.use_excanvas,
                    cursor: {
                        show: true,
                        showTooltip: true,
                        showTooltipGridPosition: true,
                        //  showTooltipDataPosition: false,
                        showTooltipUnitPosition: false,
                        useAxesFormatters: false,
                        // showVerticalLine : true,
                        followMouse: true
                    },
                    // title: that.selYear + "年" + that.selMonth+"月",
                    seriesColors: ['#90EE90', '#ffb7c5', 'blue', 'red', '#9BBB59', '#F79646', '#948A54', '#4000E3'],
                    seriesDefaults:{
                        renderer:$.jqplot.DateAxisRenderer,
                        pointLabels: { show: true , escapeHTML: false },
                        markerOptions: {color: 'red'}
                    },
                    series:[
                        { label: '{{ trans("label.gues_earning") }}',
                            renderer: $.jqplot.BarRenderer,
                            pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                            rendererOptions: {barWidth:20,barPadding:-20,shadow: false}
                        },
                        { label: '{{ trans("label.gues_earning2") }}' ,
                            renderer: $.jqplot.BarRenderer,
                            pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                            rendererOptions: {barWidth:20,barPadding:-20,shadow: false}
                        },
                        { label: '{{ trans("label.earning") }}' ,
                        markerOptions: { style:"filledSquare", size:10 }
                        },
                        { label: '{{ trans("label.benefit") }}' },
                    ],
                    axes: {
                        xaxis: {
                            renderer: $.jqplot.CategoryAxisRenderer,
                            ticks: ticks5
                        },
                        yaxis: {
                            min:0,
                            max:15,
                            tickOptions: { 
                                formatString: '%d' 
                            },
                            label: "万円"
                        }
                    },
                    highlighter: { show: false },
                    height: document.getElementById('myModalChartToday').clientHeight * 0.6,
                    legend: {show: true},
                    canvasOverlay: {
                        show: true,
                        objects: [
                            {horizontalLine: {
                                linePattern: 'dashed',
                                name: 'pebbles',
                                y: 2,
                                lineWidth: 1,
                                xOffset: 0.2,
                                color: 'red',
                                shadow: false
                            }},
                            {horizontalLine: {
                                linePattern: 'dashed',
                                name: 'pebbles',
                                y: 10,
                                lineWidth: 1,
                                xOffset: 0.2,
                                color: 'blue',
                                shadow: false
                            }}
                        ]
                    }}
                );
                plot5.replot();
                $('#chart5').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info5').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                $('#chart5').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info5').html('Nothing');
                    }
                );
            }, 500);
        },
        onLoadChartMonth() {
            this.selYear = document.getElementById("selLang").value;
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListProject')}}?year=" + that.selYear,
                success: function(data) {
                    if (data.count > 0) {
                        that.yearReportPrice = data.yearReportPrice;
                    } else {
                        that.yearReportPrice = [];
                    }
                    that.loadChartMonth();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChartMonth() {
            var ticks6 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];
            var s10 = [];
            var s9_guess = [];
            var s10_guess = [];

            const that = this;
            Object.keys(this.yearReportPrice).map(function(key , value) {
                s9.unshift(that.yearReportPrice[key][2]);
                s10.unshift(that.yearReportPrice[key][3]);
                s9_guess.unshift(that.yearReportPrice[key][0]);
                s10_guess.unshift(that.yearReportPrice[key][1]);
                var month = that.yearReportPrice[key][4];
                // if (that.yearReportPrice[key][4] == 12) {
                    month = month +'月';
                // }
                if (that.yearReportPrice[key][4] == that.thisMonth) {
                    month = '<span style="color:red;border-bottom:1px solid red">'+month+'</span>';
                }
                ticks6.unshift(month);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart6', [s9_guess,s10_guess,s9,s10], {
                // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                animate: !$.jqplot.use_excanvas,
                stackSeries: false,
                cursor: {
                    show: true,
                    showTooltip: true,
                    showTooltipGridPosition: true,
                    //  showTooltipDataPosition: false,
                    showTooltipUnitPosition: false,
                    useAxesFormatters: false,
                    // showVerticalLine : true,
                    followMouse: true
                },
                // title: that.thisYear + "年",
                seriesColors: ['#90EE90', '#ffb7c5', 'blue', 'red', '#9BBB59', '#F79646', '#948A54', '#4000E3'],
                // seriesDefaults:{
                //     renderer:$.jqplot.DateAxisRenderer,
                //     pointLabels: { show: true , escapeHTML: false },
                //     markerOptions: {color: 'red'}
                // },
                // seriesDefaults: {
                //     renderer: $.jqplot.BarRenderer, // グラフの種類を「棒グラフ」に
                // },
                series:[
                    { label: '{{ trans("label.gues") }}{{ trans("label.earning") }}',
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                        rendererOptions: {barWidth:20,barPadding:-20,shadow: false}
                    },
                    { label: '{{ trans("label.gues") }}{{ trans("label.benefit") }}' ,
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                        rendererOptions: {barWidth:20,barPadding:-20,shadow: false}
                    },
                    { label: '{{ trans("label.earning") }}' ,
                    markerOptions: { style:"filledSquare", size:10 }
                    },
                    { label: '{{ trans("label.benefit") }}' },
                ],
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks6
                    },
                    yaxis: {
                        min:0,
                        max:300,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: "万円",
                        pad: 0,
                    }
                },

                highlighter: { show: false },
                height: document.getElementById('myModalChartMonth').clientHeight * 0.6,
                legend: {show: true},
                canvasOverlay: {
                    show: true,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 200,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'blue',
                            shadow: false
                        }},
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 60,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }}
                    ]
                }});

                $('#chart6').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info6').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                    
                $('#chart6').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info6').html('Nothing');
                    }
                );
                
            }, 500);
        },
        loadChartYear() {
            var ticks7 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];
            var s10 = [];
            var s9_guess = [];
            var s10_guess = [];

            const that = this;
            Object.keys(this.everyYearReportPrice).map(function(key , value) {
                s9.unshift(that.everyYearReportPrice[key][2]);
                s10.unshift(that.everyYearReportPrice[key][3]);
                s9_guess.unshift(that.everyYearReportPrice[key][0]);
                s10_guess.unshift(that.everyYearReportPrice[key][1]);
                var y = that.everyYearReportPrice[key][4];
                // if (that.everyYearReportPrice[key][4] == 2030) {
                    y = y + "年";
                // }
                if (that.everyYearReportPrice[key][4] == that.thisYear) {
                    y = '<span style="color:red;border-bottom:1px solid red">'+y+'</span>';
                }
                ticks7.unshift(y);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart7', [s9_guess,s10_guess,s9,s10], {
                // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                animate: !$.jqplot.use_excanvas,
                cursor: {
                    show: true,
                    showTooltip: true,
                    showTooltipGridPosition: true,
                    //  showTooltipDataPosition: false,
                    showTooltipUnitPosition: false,
                    useAxesFormatters: false,
                    // showVerticalLine : true,
                    followMouse: true
                },
                title: "2021年～2030年",
                seriesColors: ['#90EE90', '#ffb7c5', 'blue', 'red', '#9BBB59', '#F79646', '#948A54', '#4000E3'],
                seriesDefaults:{
                    renderer:$.jqplot.DateAxisRenderer,
                    pointLabels: { show: true , escapeHTML: false },
                    markerOptions: {color: 'red'}
                },
                series:[
                    { label: '{{ trans("label.gues") }}{{ trans("label.earning") }}',
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                        rendererOptions: {barWidth:20,barPadding:-20,shadow: false}
                    },
                    { label: '{{ trans("label.gues") }}{{ trans("label.benefit") }}' ,
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                        rendererOptions: {barWidth:20,barPadding:-20,shadow: false}
                    },
                    { label: '{{ trans("label.earning") }}' ,
                    markerOptions: { style:"filledSquare", size:10 }
                    },
                    { label: '{{ trans("label.benefit") }}' },
                ],
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks7
                    },
                    yaxis: {
                        min:0,
                        max:3600,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: "万円"
                    }
                },
                highlighter: { show: false },
                height: document.getElementById('myModalChartYear').clientHeight * 0.6,
                legend: {show: true},
                canvasOverlay: {
                    show: true,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 2400,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'blue',
                            shadow: false
                        }},
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 720,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }}
                    ]
                }});

                $('#chart7').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info6').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                    
                $('#chart7').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info6').html('Nothing');
                    }
                );
                
            }, 500);
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.conditionAddress != '') {
                conditionSearch += '&address=' + this.conditionAddress;
            }
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.ctv_sale != '') {
                conditionSearch += '&ctv_sale=' + this.ctv_sale;
            }
            if (this.conditionStatus != '') {
                conditionSearch += '&status=' + this.conditionStatus;
            }
            if (this.dateOrder != '') {
                conditionSearch += '&date_start=' + this.dateOrder;
            }
            if (this.dateOrder_from != '') {
                conditionSearch += '&date_start=' + this.dateOrder_from;
            }
            if (this.dateOrder_to != '') {
                conditionSearch += '&date_start=' + this.dateOrder_to;
            }
            if (this.dateOrder_month != '') {
                conditionSearch += '&date_start_month=' + this.dateOrder_month;
            }
            if (this.ngay_phien_dich != '') {
                conditionSearch += '&ngay_phien_dich=' + this.ngay_phien_dich;
            }
            if (this.ngay_phien_dich_from != '') {
                conditionSearch += '&ngay_phien_dich_from=' + this.ngay_phien_dich_from;
            }
            if (this.ngay_phien_dich_to != '') {
                conditionSearch += '&ngay_phien_dich_to=' + this.ngay_phien_dich_to;
            }
            if (this.thang_phien_dich != '') {
                conditionSearch += '&thang_phien_dich=' + this.thang_phien_dich;
            }
            if (this.name_kh != '') {
                conditionSearch += '&name_kh=' + this.name_kh;
            }
            if (this.ctv_pd != '') {
                conditionSearch += '&ctv_pd=' + this.ctv_pd;
            }
            if (this.codeJobs != '') {
                conditionSearch += '&project_id=' + this.codeJobs;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.checkedTypes.length > 0) {
                conditionSearch += '&loai_job_multi=' + this.checkedTypes.join();
            }
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;                
            }
            if (this.checkAkaji != 0) {
                conditionSearch += '&check_akaji=' + this.checkAkaji;
            }
            conditionSearch += '&showcount=' + this.showCount;      
            
            this.conditionSearch = conditionSearch;

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListProject')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                        that.sumEarning = data.sumEarning;
                        that.sumBenefit = data.sumBenefit;
                        that.dayPrices = data.dayPrices;
                        that.yearReportPrice = data.yearReportPrice;
                        that.everyYearReportPrice = data.everyYearReportPrice;
                        that.sumTongThuDuKien = data.sumTongThuDuKien;
                        that.sumTongKimDuocDuKien = data.sumTongKimDuocDuKien;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.list = [];
                        that.sumEarning = 0;
                        that.sumBenefit = 0;
                        that.sumTongThuDuKien = 0;
                        that.sumTongKimDuocDuKien = 0;
                        that.dayPrices = [];
                        that.yearReportPrice = [];
                        that.everyYearReportPrice = [];
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

                    // fixed 1
                    setTimeout(function() { 
                        $('.fix-col1').attr("style","z-index:100;left:0px;background:#CCCCCC");
                        $('.fix-col2').attr("style","z-index:100;left:80px;background:#CCCCCC");
                        $('.fix-col3').attr("style","z-index:100;left:"+(94.63 + 80)+"px;background:#CCCCCC");


                        $('.fix-col1-detail').attr("style","z-index:99;left:0px;");
                        $('.fix-col2-detail').attr("style","z-index:99;left:80px;");
                        $('.fix-col3-detail').attr("style","z-index:99;left:"+(94.63 + 80)+"px;");
                    }, 500);
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
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
        }
    },
});
</script>

@stop