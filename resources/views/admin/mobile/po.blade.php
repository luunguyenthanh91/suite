@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '依頼書')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <div id="list-data">
        <div class="modal fade" id="createPo">
            <form method="POST" class="modal-dialog char-h-mobile" action="/admin/authentication/create-po">
                @csrf
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.po_new') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                            <input type="text" autocomplete="off" name="ngay_pd" id="listDatePo" class="form-control"  required>
                        </div>
                        <div class="form-group countDateLabel col-lg-12">
                            <div id="txtCountDayPo">（{{ trans('label.count_day') }}: - ）</div>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.address_pd') }}</label>
                            <div class="search-form" >
                                <input type="hidden" name="redirect" value="{{ Request::url() }}">
                                <input id="address-po" type="text" required class="form-control" name="address_pd" >
                                <div>
                                    <a id="link-map-po" type="button" class="btn btn-outline-secondary" style="border:0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sale2') }}</label>
                                <input type="text" required class="form-control" name="name" >
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sale_cost') }}</label>
                                <input type="text" class="form-control money_parse" name="sale_price">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.contract_money') }}</label>
                                <div class="search-form" >
                                    <input type="text" class="form-control money_parse" name="price">
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.move_fee') }}</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiomale1" name="type_train" type="radio" class="custom-control-input" value="1">
                                        <label for="radiomale1" class="custom-control-label">{{ trans('label.include') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiomale2" name="type_train" type="radio" class="custom-control-input" value="2">
                                        <label for="radiomale2" class="custom-control-label">{{ trans('label.exclude') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.note') }}</label>
                            <textarea type="text" class="form-control" name="note_create_po" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <span class="labelButton">{{ trans('label.ok') }}</span>
                        </button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">
                            <span class="labelButton">{{ trans('label.cancel') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.search') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.order_id') }}</label>
                                <input type="text" class="form-control search" v-model="po_id_search">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.order_date') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder" min="2021-03-17">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.order_month') }}</label>
                                <input type="month" class="form-control search" v-model="dateOrder_month">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.order_date_from') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder_from" min="2021-03-17">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.order_date_to') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder_to" min="2021-03-17">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.status') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="0" value="0" v-model="checkedNames">
                                <label class="status2" for="0">{{ trans('label.po_status1') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames">
                                <label class="status6" for="1">{{ trans('label.po_status2') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames">
                                <label class="status7" for="2">{{ trans('label.cancel') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich" min="2021-03-17">
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_to') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_to" min="2021-03-17">
                            </div>                            
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.address_pd') }}</label>
                                <input type="text" class="form-control search" v-model="address_pd_search">
                            </div>                         
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sale2') }}</label>
                                <input type="text" class="form-control search" v-model="name_search">
                            </div>                       
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.move_fee') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="sexMale" value="0" v-model="type_train_search">
                                <label for="sexMale">{{ trans('label.include') }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="sexFemale" value="1" v-model="type_train_search">
                                <label for="sexFemale">{{ trans('label.exclude') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.id') }}</label>
                                <input type="text" class="form-control search" v-model="project_id_search">
                            </div>
                        </div>
                    </div>
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
        <div class="modal fade" id="leftMenu">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="page-separator">
                            <div class="page-separator__text">
                            {{ trans("label.search2") }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px;">
                                    <div class="form-group col-lg-12">
                                        <input class="checkboxHor2" type="checkbox" id="po_status1" value="0" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status2" for="po_status1">{{ trans('label.po_status1') }}</label>

                                        <input class="checkboxHor" type="checkbox" id="po_status2" value="1" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status6" for="po_status2">{{ trans('label.po_status2') }}</label>

                                        <input class="checkboxHor" type="checkbox" id="cancel" value="2" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status7" for="cancel">{{ trans('label.cancel') }}</label>

                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text">
                            {{ trans("label.sum_search") }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px; margin-right:0px;">
                                    <div class="form-group col-lg-12">
                                    <a target="_blank" @click="todayProject()">
                                        <span class="labelButtonDropMenu">{{ trans('label.today_po') }}<span>(</span>(( getToday() ))<span>)</span></span>
                                    </a> 
                                    <div class="page-separator-line"></div>
                                    <a target="_blank" @click="lastMonthProject()">
                                        <span class="labelButtonDropMenu">{{ trans('label.lastmonth3') }}<span>(</span>(( getLastMonth() ))<span>)</span></span>
                                    </a>  
                                    <div class="page-separator-line"></div>
                                    <a  target="_blank" @click="thisMonthProject()">
                                        <span class="labelButtonDropMenu">{{ trans('label.thismonth3') }}<span>(</span>(( getThisMonth() ))<span>)</span></span>
                                    </a>  
                                    <div class="page-separator-line"></div>
                                    <a target="_blank" @click="thisYearProject()">
                                        <span class="labelButtonDropMenu">{{ trans('label.thisyear3') }}<span>(</span>(( getThisYear() ))<span>)</span></span>
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
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3 newButtonBg" data-toggle="modal" data-target="#createPo">
                    <i class="fa fa-plus-square"><span class="labelButton">{{ trans('label.new') }}</span></i>
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
                                    <div v-bind:class="[sortBy === 'id' ? sortDirection : '']">{{ trans('label.po') }}</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list" id="search">
                            <tr v-for="item in sortedProducts">
                                <td :class="item.classStyle  + ' '">
                                <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/po-view/' + item.id">
                                    {{ trans('label.order_id') }}((item.id)) ( <span v-if="item.status==0">{{ trans('label.po_status1') }}</span>
                                    <span v-if="item.status==1">{{ trans('label.po_status2') }}</span>   
                                    <span v-if="item.status==2">{{ trans('label.cancel') }}</span> )
                                </a><br>
                                <span><u><b>(( parseName(item.name) )) {{ trans('label.sama') }}</u></b></span><br>
                                {{ trans('label.order_date') }}: (( removeTime(item.create_at) ))<br>
                                {{ trans('label.ngay_phien_dich') }}: ((item.ngay_pd))<br>
                                ((item.address_pd))<br>
                                {{ trans('label.contract_money') }}: (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name'  }).format(item.price) )) ( {{ trans('label.move_fee') }}: <span v-if="item.type_train==0">{{ trans('label.include') }}</span>
                                <span v-if="item.type_train==1">{{ trans('label.exclude') }}</span> )<br>
                                {{ trans('label.sale_cost') }}: (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(item.sale_price) ))
                                <a v-if="item.project_id" target="_blank" :href="'/admin/projectview/' + item.project_id"><br>{{ trans('label.id') }}(( item.project_id ))</a>
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

@include('admin.component.left-bar')
@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function (){
    $('#link-map-po').on('click',function() {
        var addressPo = $('#address-po').val();
        if (addressPo.trim() == '') {
            alert("Nhập địa chỉ.");
            return false;
        }
        var win = window.open('https://www.google.com/maps/place/'+addressPo, '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }
    });
    $('#listDatePo').datepick({ 
        multiSelect: 999, 
        minDate: 0,
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1,
        onSelect: function(dateText, inst) {
            $(this).change();
        }
    });
    $('#listDatePo').change(function(event) {
        $cntDay = this.value.split(',').length;
        $('#txtCountDayPo').text("（日数: " + $cntDay + "）");
    });
    CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
});

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],

        po_id_search:'{{ Request::get("keyword") }}',
        type_train_search: '',
        project_id_search:'',
        name_search: '',
        address_pd_search: '',
        ngay_phien_dich: '',
        ngay_phien_dich_from: '',
        ngay_phien_dich_to: '',
		thang_phien_dich: '',
        checkedNames: [0,1,2],
        dateOrder: '',
        dateOrder_from: '',
        dateOrder_to: '',
        dateOrder_month: '',
        
        sumPrice:0,
        sumSalePrice:0,


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
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        codeJobs: '{{ Request::get("keyword") }}',
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
        sortBy: 'codejob',
        sortDirection: 'desc',
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

            this.dateOrder_from = `${year}-01-01`;
            this.dateOrder_to = `${year}-12-31`;
            this.sortName = 'create_at';  
            this.sortType = "ASC";  
            this.sortBy= 'create_at';
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

            this.dateOrder_month = `${year}-${month}`;
            this.sortName = 'create_at';  
            this.sortType = "ASC";  
            this.sortBy= 'create_at';
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

            this.dateOrder_month = `${year}-${month}`;
            this.sortName = 'create_at';  
            this.sortType = "ASC";  
            this.sortBy= 'create_at';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        todayProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
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

            this.dateOrder = `${year}-${month}-${day}`;
            this.sortName = 'create_at';  
            this.sortType = "ASC";  
            this.sortBy= 'create_at';
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
        notRegister: function() {
            this.clearSearchCondition();
            this.checkedNames = [0];
            this.sortName = 'create_at';  
            this.sortType = "ASC";  
            this.sortBy= 'create_at',
            this.sortDirection= 'ASC',
            this.onSearch();
        },
        refresh: function() {
            this.clearSearchCondition();
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
            this.po_id_search = '';
            this.type_train_search = '';
            this.project_id_search = '';
            this.name_search = '';
            this.address_pd_search = '';
            this.ngay_phien_dich = '';
            this.ngay_phien_dich_from = '';
            this.ngay_phien_dich_to = '';
			this.thang_phien_dich = '';
            this.checkedNames = [0,1,2];
            this.dateOrder = '';
            this.dateOrder_from = '';
            this.dateOrder_to = '';
            this.dateOrder_month = '';


            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";    
            this.checkAkaji= 0;   
            
            this.onLoadPagination();
        },
        clearSearchCondition() {
            this.po_id_search = '';
            this.project_id_search = '';
            this.type_train_search = '';
            this.name_search = '';
            this.address_pd_search = '';
            this.ngay_phien_dich = '';
            this.ngay_phien_dich_from = '';
            this.ngay_phien_dich_to = '';
			this.thang_phien_dich = '';
            this.checkedNames = [0,1,2];
            this.dateOrder = '';
            this.dateOrder_from = '';
            this.dateOrder_to = '';
            this.dateOrder_month = '';


            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;     
            
            this.onLoadPagination();    
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
            this.checkedNames = [0,1,2];
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
        removeTime (value) {
            return this.isNull(value)? S_HYPEN : (value.split(' ')[0]);
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
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.po_id_search != '') {
                conditionSearch += '&po_id=' + this.po_id_search;
            }
            if (this.type_train_search != '') {
                conditionSearch += '&type_train=' + this.type_train_search;
            }
            if (this.project_id_search != '') {
                conditionSearch += '&project_id=' + this.project_id_search;
            }
            if (this.name_search != '') {
                conditionSearch += '&name=' + this.name_search;
            }
            if (this.address_pd_search != '') {
                conditionSearch += '&address_pd=' + this.address_pd_search;
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
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.dateOrder != '') {
                conditionSearch += '&date_start=' + this.dateOrder;
            }
            if (this.dateOrder_from != '') {
                conditionSearch += '&date_start_from=' + this.dateOrder_from;
            }
            if (this.dateOrder_to != '') {
                conditionSearch += '&date_start_to=' + this.dateOrder_to;
            }
            if (this.dateOrder_month != '') {
                conditionSearch += '&date_start_month=' + this.dateOrder_month;
            }




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
            if (this.name_kh != '') {
                conditionSearch += '&name_kh=' + this.name_kh;
            }
            if (this.ctv_pd != '') {
                conditionSearch += '&ctv_pd=' + this.ctv_pd;
            }
            if (this.codeJobs != '') {
                conditionSearch += '&code_jobs=' + this.codeJobs;
            }
            if (this.checkedTypes.length > 0) {
                conditionSearch += '&loai_job_multi=' + this.checkedTypes.join();
            }
            if (this.checkedCTVSex.length > 0) {
                conditionSearch += '&ctv_sex=' + this.checkedCTVSex.join();
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
                url: "{{route('admin.getListPO')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                        that.sumPrice = data.sumPrice;
                        that.sumSalePrice = data.sumSalePrice;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.sumPrice = 0;
                        that.sumSalePrice = 0;
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

                    // fixed 1
                    setTimeout(function() { 
                        $('.fix-col1').attr("style","z-index:100;left:0px;background:#CCCCCC");
                        $('.fix-col2').attr("style","z-index:100;left:80px;background:#CCCCCC");
                        $('.fix-col3').attr("style","z-index:100;left:"+(94.63 + 80)+"px;background:#CCCCCC");


                        $('.fix-col1-detail').attr("style","z-index:99;left:0px;");
                        $('.fix-col2-detail').attr("style","z-index:99;left:80px;");
                        $('.fix-col3-detail').attr("style","z-index:99;left:"+(94.63 + 80)+"px;");
                    }, 100);
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