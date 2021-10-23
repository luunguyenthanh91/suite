@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')

    <div id="list-data">
        <div class="modal fade" id="myModal">
            <div class="modal-dialog ">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.search_header') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.id') }}</label>
                                <input type="text" class="form-control search" v-model="project_id">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.date_start') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.date_start_month') }}</label>
                                <input type="month" class="form-control search" v-model="dateOrder_month">
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.date_start_from') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.date_start_to') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder_to" min="2021-03-17">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">                        
                                <label class="form-label">{{ trans('label.thang_phien_dich') }}</label>
                                <input type="month" class="form-control search"  v-model="thang_phien_dich"  min="2021-03">
                            </div>
                        </div>
                        <div class="row d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_from') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_to') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_to" min="2021-03-17">
                            </div>                            
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label m-0">{{ trans('label.address_pd') }}</label>
                                <input type="text" class="form-control search" v-model="conditionAddress">
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
                        <div class="row d-flex">
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
                                <input type="checkbox" id="7" value="7" v-model="checkedNames">
                                <label class="status7" for="7">{{ trans('label.status7') }}</label>
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
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sex') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="sexMale" value="1" v-model="checkedCTVSex">
                                <label for="sexMale">{{ trans('label.male') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="sexFemale" value="2" v-model="checkedCTVSex">
                                <label for="sexFemale">{{ trans('label.female') }}</label>
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
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3" style="background:coral" @click="clearSearch()">
                            <i class="fas fa-trash"><span class="labelButton">{{ trans('label.clear_search') }}</span></i>
                        </a>
                        <a type="button" class="btn btn-outline-secondary3 searchButtonBg" @click="someHandlerChange()" data-dismiss="modal">
                            <i class="fas fa-search"><span class="labelButton">{{ trans('label.search') }}</span></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container page__container page-section page_container_custom">
            <div class="row page_container_custom_marginright">
                <div :class="''+classColLG12">
                    <div :class="'' + classBodayRightContentGrid">
                        <div class="bodyContent">
                            <div class="d-flex col-lg-12">
                                <div  class="fullWidth">
                                    <div class="search-form"> 
                                        <input type="text" class="form-control search" v-model="project_id" placeholder="{{ trans('label.msg3') }}">
                                        <button class="btn btn-outline-secondary3 searchBtn" @click="someHandlerChange()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <a type="button" class="btn btn-outline-secondary3 searchButtonBg searchBtnInterpreter" data-toggle="modal" data-target="#myModal">
                                    <span class="labelButton">{{ trans('label.search') }}</span>
                                </a> 
                            </div> 
                            <div class="bodyContentRight tableFixHead">
                                <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0 mt-10">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" @click="sort('status')" style="width: 100%; ">
                                                <div v-bind:class="[sortBy === 'status' ? sortDirection : '']">{{ trans('label.project') }}</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="search">
                                        <tr v-for="item in sortedProducts">
                                            <td :class="item.classStyle">
                                                <div>
                                                    <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/projectview/' + item.id">
                                                        <i class="fas fa-info-circle">
                                                            <span class="labelButton">((item.id))</span>
                                                            <span v-if='item.status == 0 || item.status == ""'>{{ trans('label.status0') }}</span>
                                                            <span v-if='item.status == 1'>{{ trans('label.status1') }}</span>
                                                            <span v-if='item.status == 2'>{{ trans('label.status2') }}</span>
                                                            <span v-if='item.status == 3'>{{ trans('label.status3') }}</span>
                                                            <span v-if='item.status == 8'>{{ trans('label.status8') }}</span>
                                                            <span v-if='item.status == 4'>{{ trans('label.status4') }}</span>
                                                            <span v-if='item.status == 5'>{{ trans('label.status5') }}</span>
                                                            <span v-if='item.status == 6'>{{ trans('label.status6') }}</span>
                                                            <span v-if='item.status == 7'>{{ trans('label.status7') }}</span>
                                                        </i>
                                                    </a>    
                                                </div>
                                                <div>(( item.ngay_pd )) ((item.address_pd))</div>
                                                <div v-for="itemCTV in item.ctv_sales_list">
                                                    <div :class="' '+item.classStyle">(( parseName(itemCTV.name) ))</div>
                                                </div>
                                                <div v-for="itemCTV in item.ctv_list">
                                                    <div :class="' '+item.classStyle">通訳者:</div>
                                                    <div :class="' '+item.classStyle">(( parseName(itemCTV.name) ))</div>
                                                    <div :class="' '+item.classStyle">(( parseName(itemCTV.address) ))</div>
                                                </div>
                                                <div>
                                                (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_thu) ))
                                                (利益: (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_nhanduoc) )))
                                                </div>
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
    $('#link-map-proj').on('click',function() {
        var addressPo = $('#addressProj').val();
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

    $('#listDateProj').datepick({ 
        multiSelect: 999, 
        minDate: 0,
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1,
        onSelect: function(dateText, inst) {
            $(this).change();
        }
    });

    $('#listDateProj').change(function(event) {
        $cntDay = this.value.split(',').length;
        $('#txtCountDay').text("（日数: " + $cntDay + "）");
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
        ngay_phien_dich_to: '',
		thang_phien_dich: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        dateOrder_from: '',
        dateOrder_to: '',
        dateOrder_month: '',
        codeJobs: '',
        project_id: '{{ Request::get("keyword") }}',
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
            this.project_id = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";    
            this.checkAkaji= 0;   
            
            this.onLoadPagination();
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

            this.ngay_phien_dich = `${year}-${month}-${day}`;
            this.onSearch();
        },
        tomorrowProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
            let d = new Date();
            
            // Adding one date to the present date
            d.setDate(d.getDate() + 1);

            let year = d.getFullYear()
            let month = String(d.getMonth() + 1)
            let day = String(d.getDate())

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
                month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            this.ngay_phien_dich = `${year}-${month}-${day}`;
            this.onSearch();
        },
        refresh: function() {
            this.clearSearchCondition();
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
            this.project_id = '';
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
        parseNgayPD(value) {
            return value.split(',').join('<br />');
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
                conditionSearch += '&code_jobs=' + this.codeJobs;
            }
            if (this.project_id != '') {
                conditionSearch += '&project_id=' + this.project_id;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
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
                url: "{{route('admin.getListProject')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
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