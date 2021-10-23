@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '通訳者')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <div id="list-data">
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
                                <label class="form-label">{{ trans('label.matching') }}</label>
                                <input type="text" class="form-control search" v-model="conditionAddress">
                            </div>
                        </div>                        
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.longtitude') }},{{ trans('label.latitude') }}</label>
                                <div class="search-form" >
                                    <input type="text" class="form-control search" v-model="LongLat">
                                    <a type="button" class="btn btn-warning" style="background:blue" href="https://www.google.co.jp/maps">{{ trans('label.google_map3') }}</a>
                                </div>
                            </div>
                        </div>                 
                        <div class="page-separator-line"></div>  
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.language') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_lang1" value="VNM" v-model="TypeLang">
                                <label for="type_lang1">{{ trans('label.type_lang1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_lang2" value="PHL" v-model="TypeLang">
                                <label for="type_lang2">{{ trans('label.type_lang2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="button" @click="clearSearchTypeLang()" class="linkCheckboxAll">{{ trans('label.all_off') }}</button>
                                <button type="button" @click="setSearchTypeLang()" class="linkCheckboxAll">{{ trans('label.all_on') }}</button>
                            </div>
                        </div>               
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.id_intepreter') }}</label>
                                <input type="text" class="form-control search" v-model="IDNumber">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.name') }}</label>
                                <input type="text" class="form-control search" v-model="name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.address') }}</label>
                                <input type="text" class="form-control search" v-model="address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.tel') }}</label>
                                <input type="text" class="form-control search" v-model="phone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.email') }}</label>
                                <input type="text" class="form-control search" v-model="email">
                            </div>
                        </div>  
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.jlpt') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="n1" value="1" v-model="multi_JLPT">
                                <label for="n1">N1</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="n2" value="2" v-model="multi_JLPT">
                                <label for="n2">N2</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="n3" value="3" v-model="multi_JLPT">
                                <label for="n3">N3</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="n4" value="4" v-model="multi_JLPT">
                                <label for="n4">N4</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="n5" value="5" v-model="multi_JLPT">
                                <label for="n5">N5</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="button" @click="clearSearchStatusJLPT()" class="linkCheckboxAll">{{ trans('label.all_off') }}</button>
                                <button type="button" @click="setSearchStatusJLPT()" class="linkCheckboxAll">{{ trans('label.all_on') }}</button>
                            </div>
                        </div>     
                        <div class="page-separator-line"></div>  
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.status') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="0" value="0" v-model="checkedNames">
                                <label for="0">{{ trans('label.status_not') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames">
                                <label for="1">{{ trans('label.status_yes') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames">
                                <label for="2">{{ trans('label.status_cancel') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="button" @click="clearSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_off') }}</button>
                                <button type="button" @click="setSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_on') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <a type="button" class="btn btn-outline-secondary3 clearButtonBg" @click="clearSearch()">
                            <span class="labelButton">{{ trans('label.clear_search') }}</span>
                        </a>
                        <a type="button" class="btn btn-outline-secondary3 searchButtonBg" @click="onMatching()" data-dismiss="modal">
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
                            {{ trans("label.graph") }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px; margin-right:0px;">
                                    <div class="form-group col-lg-12">
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChart" data-target="#myModalChartArea">
                                            <i class="fas fa-chart-bar"></i><span class="labelButton">{{ trans('label.intepreter_count') }}</span>
                                        </a> 
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChartMonth" data-target="#myModalChartMonth">
                                            <i class="fas fa-chart-bar"></i><span class="labelButton">{{ trans('label.chart_interpreter_month') }}</span>
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
        <div class="modal fade" id="myModalChartArea">
            <div class="modal-dialog  char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.areaGraph2') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
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
        <div class="modal fade" id="myModalChartMonth">
            <div class="modal-dialog  char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.chart_interpreter_month') }}{{ trans('label.graph') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="flex" id="chart7" style="max-width: 100%;"></div>
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
                <a type="button" class="btn btn-outline-secondary3" style="background:#da1d81" target="_blank" @click="notReceiptSearch()">
                    <i class="fas fa-key"><span class="labelButton">{{ trans('label.not_approve') }}</span></i>
                </a>
                @if (Auth::guard('admin')->user()->id == 1 )    
                <a type="button" href="/admin/collaborators/export" class="btn btn-outline-secondary3" style="background:orange">
                    <i class="fas fa-file-excel"><span class="labelButton">{{ trans('label.excel') }}</span></i>
                </a>
                @endif  
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
                                <th scope="col" @click="sort('distance')" >
                                    <div v-bind:class="[sortBy === 'distance' ? sortDirection : '']">{{ trans('label.interpreter') }}</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list" id="search">
                            <tr v-for="item in sortedProducts">
                                <td :class="item.classStyle  + ' '">
                                    <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/partner-interpreter-view/' + item.id">
                                    {{ trans('label.id_intepreter') }}((item.id)) (
                                    <span v-if="item.type_lang == 'VNM'">{{ trans('label.type_lang1') }}</span>
                                    <span v-if="item.type_lang == 'PHL'">{{ trans('label.type_lang2') }}</span>
                                    /
                                    <span v-if='item.jplt == 1'>N1</span>
                                    <span v-if='item.jplt == 2'>N2</span>
                                    <span v-if='item.jplt == 3'>N3</span>
                                    <span v-if='item.jplt == 4'>N4</span>
                                    <span v-if='item.jplt == 5'>N5</span>
                                    )
                                    </a><br>
                                    <i v-if="item.male == 1" class="fa fa-male maleClass"></i>
                                    <i v-if="item.male == 2" class="fa fa-female femaleClass"></i>    
                                    (( parseName(item.name) )) ( <a :href="'tel:'+item.phone"> (( parsePhone(item.phone) ))</a> )<br>
                                    (( parseName(item.address) ))<br>
                                    <span v-if="item.distance">(( parseInt(item.distance) )) Km<br></span>
                                    <a type="button" class="btn btn-outline-secondary3" style="background:Tomato" href="#" @click="copyClipboadCTVpd(item)">
                                        <i class="fa fa-clipboard"><span class="labelButton">{{ trans('label.copy') }}</span></i>
                                    </a>
                                    <a v-if="item.distance" type="button" class="btn btn-outline-secondary3"  style="background:#B8054E" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+item.address+'&s=1&fl=1&to='+conditionAddress">
                                        <i class="fa fa-train"><span class="labelButton">{{ trans('label.search_yahoo') }}</span></i>
                                    </a>
                                    <a v-if="item.distance" type="button" class="btn btn-outline-secondary3"  style="background:green" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+item.address+'/'+conditionAddress">
                                        <i class="fa fa-map"><span class="labelButton">{{ trans('label.google_map2') }}</span></i>
                                    </a>
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
    
    <!-- copy clipboard -->
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmgpRGpKtjqZM4MRho4hHI-eYJbnGdbwY" type="text/javascript"></script>
<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
let d = new Date();
let year = d.getFullYear();
let month = String(d.getMonth() + 1);
let day = String(d.getDate());

jQuery(document).ready(function (){
    $('#link-map-address').on('click',function() {
        var address = $('#address').val();
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
    });

    CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        
});
new Vue({
    el: '#list-data',
    data: {
        thisMonth: month,
        thisYear: year,
        thisDay: day,
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        conditionSearch: '',
        conditionLocation: '',
        sumCount: 0,
        listPage: [],
        addModal: 1,
        conditionName: '',
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        groups: [],
        conditionStatus: '',
        request_type: "{{ app('request')->input('type') }}",
        name: "{{ app('request')->input('type') ? '' :  app('request')->input('keyword') }}",
        conditionAddress: "{{ app('request')->input('type') ?  app('request')->input('keyword') : '' }}",
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
        code:'',
        address:'',
        phone:'',
        email:'',
        checkedNames: [1],
        multi_JLPT:[1,2,3,4,5],
        IDNumber: '',
        LongLat: '',
		checkedTypes: [1,2,3],
        checkedCTVSex: [1,2],
        TypeLang: ["VNM","PHL"],
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
        sortBy: 'id',
        sortDirection: 'desc',
        ReportArea: [],
        ReportMonth: [],
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onMatching();
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
                } else if (this.sortBy == 'distance') {
                    var x1 = parseInt(p1[this.sortBy], 10);
                    var x2 = parseInt(p2[this.sortBy], 10);
                    if(x1 < x2) return -1 * modifier; 
                    if(x1 > x2) return 1 * modifier;
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
        notReceiptSearch: function() {
            this.clearSearchCondition();
            
            this.checkedNames = [0];
            this.sortName = 'id';  
            this.sortType = "ASC";  
            this.sortBy= 'id';
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
            this.clearSearchCondition();
            this.onLoadPagination();
        },
        clearSearchCondition: function() {
            this.conditionName = '';
            this.conditionStatus = '';
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
            this.code='';
            this.name='';
            this.address='';
            this.phone='';
            this.email = '';
            this.IDNumber = '';
            this.LongLat = '';
            this.checkedNames = [1];
            this.multi_JLPT= [1,2,3,4,5];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.TypeLang = ["VNM","PHL"];
            this.sortName = '';  
            this.sortType = "DESC";    
            this.checkAkaji= 0;   
        },
        onMatching: function() {
            if (this.request_type === 'address' || (this.request_type === '' && this.conditionAddress != '') ) {
                this.sortBy= 'distance';
                this.sortDirection= 'ASC';
                const that = this;
                geocoder = new google.maps.Geocoder();
                var address = this.conditionAddress;
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        that.conditionLocation = results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
                        console.log(that.conditionLocation);
                        that.page = 1;
                        that.onLoadPagination();
                    } 
                    else {
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",
                        });
                        $('.btn-submit').prop('disabled', false);
                    }
                });
                
            } else {
                this.page = 1;
                this.onLoadPagination();
            }

            // if ( $('.locationSearchLongLat').val() != '') {
            //     this.conditionLocation = $('.locationSearchLongLat').val();
            //     console.log(this.conditionLocation);
            //     this.page = 1;
            //     this.onLoadPagination();
                
            // } else {
            //     this.page = 1;
            //     this.onLoadPagination();
            // }
            
        },
        clearSearchMatching() {
            this.conditionAddress = '';
        },
        clearSearch() {
            this.conditionName = '';
            this.conditionLocation = '';
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
            this.code='';
            this.name='';
            this.address='';
            this.phone='';
            this.email = '';
            this.IDNumber = '';
            this.LongLat = '';
            this.checkedNames = [1];
            this.multi_JLPT= [1,2,3,4,5];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.TypeLang = ["VNM","PHL"];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;     
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [1];
		},
		clearSearchStatusJLPT() {
			this.page = 1;
            this.multi_JLPT = [];
		},
		setSearchStatusJLPT() {
			this.page = 1;
            this.multi_JLPT = [1,2,3,4,5];
		},
		clearSearchTypeLang() {
			this.page = 1;
            this.TypeLang = [];
		},
		setSearchTypeLang() {
			this.page = 1;
            this.TypeLang = ["VNM","PHL"];
		},
		clearSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [];
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
        loadChartMonth() {
            var ticks6 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];

            const that = this;
            Object.keys(this.ReportMonth).map(function(key , value) {
                s9.unshift(that.ReportMonth[key][0]);
                var month = that.ReportMonth[key][1];
                // if (that.ReportMonth[key][1] == 12) {
                    month = month +'月';
                // }
                if (that.ReportMonth[key][1] == that.thisMonth) {
                    month = '<span style="color:red;border-bottom:1px solid red">'+month+'</span>';
                }
                ticks6.unshift(month);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart7', [s9], {
                    captureRightClick: true,
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
                // title: that.thisYear + "年",
                seriesDefaults:{
                    renderer:$.jqplot.DateAxisRenderer,
                    pointLabels: { show: true , escapeHTML: false },
                    markerOptions: {color: 'red'}
                },
                series:[
                    { label: '{{ trans("label.areaGraph") }}' },
                ],
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks6,
                        label: that.thisYear + "年"
                    },
                    yaxis: {
                        min:0,
                        max:300,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        // label: "通訳者数"
                    }
                },
                highlighter: { show: false },
                height: document.getElementById('myModalChartMonth').clientHeight * 0.65,
                legend: {show: true},
                canvasOverlay: {
                    show: true,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 100,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }}
                    ]
                }}
                );

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
        onLoadChartMonth() {
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartInterpreterMonth')}}",
                success: function(data) {
                    that.ReportMonth = data.ReportMonth;
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
        loadChartArea() {
            var ticks6 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];
            var s10 = [];

            const that = this;
            Object.keys(this.ReportArea).map(function(key , value) {
                s9.unshift(that.ReportArea[key][1]);
                s10.unshift(that.ReportArea[key][0]);
                var prefecture = that.ReportArea[key][2];
                var name = prefecture;
                // for (var i = 0; i < prefecture.length; i++) {
                //     name = name + prefecture.charAt(i) + "<br>";
                // }
                ticks6.unshift(name);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart6', [s9,s10], {
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
                seriesColors: ['blue','red'],
                series:[                
                    { 
                        renderer:$.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                        shadowAngle: 135,
                        rendererOptions: {
                            barDirection: 'horizontal'
                        },
                        label: '{{ trans("label.intepreter_count") }}' 
                    }, 
                    { 
                        renderer:$.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                        shadowAngle: 135,
                        rendererOptions: {
                            barDirection: 'horizontal'
                        },
                        xaxis:'x2axis',
                        label: '{{ trans("label.project_count") }}',
                    },   
                ],
                axes: {
                    xaxis: {
                        min:0,
                        max:150,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        pad: 0,
                        label: '{{ trans("label.project_count") }}',
                    },
                    x2axis: {
                        min:0,
                        max:150,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        pad: 0,
                        label: '{{ trans("label.intepreter_count") }}' 
                    },
                    yaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks6,
                    }
                },
                highlighter: { show: false },
                height: 1000,
                legend: {show: true},
                canvasOverlay: {
                    show: false,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 80,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'blue',
                            shadow: false
                        }},
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 50,
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
        onLoadChart() {
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartInterpreter')}}",
                success: function(data) {
                    that.ReportArea = data.ReportArea;
                    that.loadChartArea();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.conditionLocation != '') {
                this.conditionLocation = this.conditionLocation.replace("(", "");
                this.conditionLocation = this.conditionLocation.replace(")", "");
                conditionSearch += '&location=' + this.conditionLocation;
            }
            if (this.conditionAddress != '') {
                conditionSearch += '&address=' + this.conditionAddress;
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
            if (this.code != '') {
                conditionSearch += '&code=' + this.code;
            }
            if (this.name != '') {
                conditionSearch += '&name=' + this.name;
            }
            if (this.phone != '') {
                conditionSearch += '&phone=' + this.phone;
            }
            if (this.address != '') {
                conditionSearch += '&address=' + this.address;
            }
            if (this.email != '') {
                conditionSearch += '&email=' + this.email;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.multi_JLPT.length > 0) {
                conditionSearch += '&status_jlpt=' + this.multi_JLPT.join();
            }
            if (this.IDNumber != '') {
                conditionSearch += '&id_number=' + this.IDNumber;
            }
            if (this.LongLat != '') {
                this.LongLat = this.LongLat.replace("(", "");
                this.LongLat = this.LongLat.replace(")", "");
                conditionSearch += '&location=' + this.LongLat;
            }
            if (this.checkedCTVSex.length > 0) {
                conditionSearch += '&male=' + this.checkedCTVSex.join();
            }
            if (this.TypeLang.length > 0) {
                conditionSearch += '&type_lang=' + this.TypeLang.join();
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
                url: "{{route('admin.getListPartnerInterpreter')}}?page=" + this.page  + conditionSearch ,
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

// fixed 1
setTimeout(function() { 
    $('.fix-col1').attr("style","z-index:100;left:0px;background:#CCCCCC");
    $('.fix-col2').attr("style","z-index:100;left:100px;background:#CCCCCC");
    $('.fix-col3').attr("style","z-index:100;left:"+(50 + 100)+"px;background:#CCCCCC");


    $('.fix-col1-detail').attr("style","z-index:99;left:0px;");
    $('.fix-col2-detail').attr("style","z-index:99;left:100px;");
    $('.fix-col3-detail').attr("style","z-index:99;left:"+(50 + 100)+"px;");
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