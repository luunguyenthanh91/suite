@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '顧客管理')



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
                            <div class="page-separator__text">{{ trans("label.search2") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px;">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.id_customer') }}</label>
                                        <input type="text" class="form-control search" v-model="code" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.name_customer') }}</label>
                                        <input type="text" class="form-control search" v-model="name" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.address') }}</label>
                                        <input type="text" class="form-control search" v-model="address" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.tel') }}</label>
                                        <input type="text" class="form-control search" v-model="phone" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
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
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:#e52b50;" target="_blank" @click="filterLang('VNM')">
                                        {{ trans('label.VNM') }}<span></span>
                                        </a>  
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:Fuchsia;" target="_blank" @click="filterLang('PHL')">
                                        {{ trans('label.PHL') }}<span></span>
                                        </a>  
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:#8A2BE2;" target="_blank" @click="filterLang('CHN')">
                                        {{ trans('label.CHN') }}<span></span>
                                        </a>  
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:Coral;" target="_blank" @click="filterLang('MMR')">
                                        {{ trans('label.MMR') }}<span></span>
                                        </a>  
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:#008B8B;" target="_blank" @click="filterLang('MNG')">
                                        {{ trans('label.MNG') }}<span></span>
                                        </a>  
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:DarkGray;" target="_blank" @click="filterLang('MYS')">
                                        {{ trans('label.MYS') }}<span></span>
                                        </a>  
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:DarkOliveGreen;" target="_blank" @click="filterLang('THA')">
                                        {{ trans('label.THA') }}<span></span>
                                        </a>   
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:Gold;" target="_blank" @click="filterLang('KHM')">
                                        {{ trans('label.KHM') }}<span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text">
                            {{ trans("label.graph") }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px; margin-right:0px;">
                                    <div class="form-group col-lg-12">
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:#800020;" data-toggle="modal" @click="onLoadChart" data-target="#myModalChart">
                                        {{ trans('label.areaGraph') }}
                                        </a> 
                                        <a type="button" class="btn btn-outline-secondary3 fullWidth" style="background:MediumTurquoise;" data-toggle="modal" @click="onLoadChartLang" data-target="#myModalChartLang">
                                        {{ trans('label.langGraph') }}
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
        <div class="modal fade" id="newPartnerSale">
            <form method="POST" class="modal-dialog char-h-mobile" action="/admin/new-customer">
                @csrf
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.customer_new') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.name_customer') }}</label>
                            <div class="search-form" >
                                <input type="text" autocomplete="off" name="name" class="form-control"  required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.address') }}</label>
                            <div class="search-form" >
                                <input type="text" class="form-control" name="address" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.tel') }}</label>
                            <div class="search-form" >
                                <input type="text" class="form-control" name="phone" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.website') }}</label>
                            <div class="search-form" >
                                <input type="text" class="form-control" name="website" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.note') }}</label>
                            <div class="search-form" >
                            <textarea type="text" class="form-control" name="note" rows="10"></textarea>
                            </div>
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
        <div class="modal fade" id="myModalChart">
            <div class="modal-dialog  char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.areaGraph') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center class="col-lg-12 mt-10">
                            <div class="d-flex col-lg-3">
                                {{ trans('label.language') }}
                                <select id="selLang" @change="onLoadChart()" class="form-control search" v-model="selLang" >
                                    <option value="0">全て</option>
                                    <option value='VNM'>ベトナム</option>  
                                    <option value='CHN'>中国</option>     
                                    <option value='IDN'>インドネシア</option>
                                    <option value='PHL'>フィリピン</option>
                                    <option value='MMR'>ミャンマー</option>
                                    <option value='KHM'>カンボジア</option>
                                    <option value='THA'>タイ</option>
                                    <option value='MNG'>モンゴル</option>
                                    <option value='NPL'>ネパール</option>
                                    <option value='IND'>インド</option>
                                    <option value='BGD'>バングラデシュ</option>
                                    <option value='LAO'>ラオス</option>
                                    <option value='UZB'>ウズベキスタン</option>  
                                    <option value='KGZ'>キルギス</option> 
                                    <option value='BTN'>ブータン</option>
                                    <option value='LKA'>スリランカ</option>
                                    <option value='MYS'>マレーシア</option>
                                    <option value='PAK'>パキスタン</option>
                                    <option value='PER'>ペルー</option>
                                    <option value='RUS'>ロシア</option>                          
                                </select>
                            </div>
                        </center>
                        <div class="flex" id="chart6" style="max-width: 100%;margin-top:20px"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartLang">
            <div class="modal-dialog  char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.langGraph') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="flex" id="chart7" style="max-width: 100%;margin-top:20px"></div>
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
            <div class="modal-dialog  char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.search_header') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.id_customer') }}</label>
                                <input type="text" class="form-control search" v-model="code">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.name_customer') }}</label>
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
                                <label class="form-label">{{ trans('label.website') }}</label>
                                <input type="text" class="form-control search" v-model="website">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.email') }}</label>
                                <input type="text" class="form-control search" v-model="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.status') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames">
                                <label for="1">{{ trans('label.cus_status_1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames">
                                <label for="2">{{ trans('label.cus_status_2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="3" value="3" v-model="checkedNames">
                                <label for="3">{{ trans('label.cus_status_3') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="4" value="4" v-model="checkedNames">
                                <label for="4">{{ trans('label.cus_status_4') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="5" value="5" v-model="checkedNames">
                                <label for="5">{{ trans('label.cus_status_5') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="6" value="6" v-model="checkedNames">
                                <label for="6">{{ trans('label.cus_status_6') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="button" @click="clearSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_off') }}</button>
                                <button type="button" @click="setSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_on') }}</button>
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
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3 newButtonBg" data-toggle="modal" data-target="#newPartnerSale">
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
                                    <div v-bind:class="[sortBy === 'id' ? sortDirection : '']">{{ trans('label.customer') }}</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list" id="search">
                            <tr v-for="item in sortedProducts">
                                <td :class="item.classStyle  + ' '">
                                    <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/customer-view/' + item.id">
                                        {{ trans('label.id_customer') }}((item.id))
                                    </a><br>
                                    (( parseName(item.name) ))<br>
                                (( parseName(item.address) ))<br>
                                {{ trans('label.tel2') }}: (( parsePhone(item.phone) ))<br>
                                {{ trans('label.hp') }}: (( item.website ))
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
<link rel="stylesheet" href="{{ asset('assets/fixed-columns/bootstrap-table-fixed-columns.css') }}">
<script src="{{ asset('assets/fixed-columns/bootstrap-table-fixed-columns.js') }}"></script>


<script type="text/javascript">
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
        code:'',
        name:'',
        address:'',
        phone:'',
        website:'',
        email:'',
        checkedNames: [1,2,3,4,5,6],
        typeLang: '',
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
        sortDirection: 'desc',
        ReportArea: [],
        ReportLang: [],
        selLang:"0",
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
                if (this.sortBy == 'number_cus') {
                    return (p1[this.sortBy] - p2[this.sortBy])* modifier;
                } else {
                    if(p1[this.sortBy] < p2[this.sortBy]) return -1 * modifier; 
                    if(p1[this.sortBy] > p2[this.sortBy]) return 1 * modifier;
                    return 0;
                }
            });
        }
    },
    methods: {
        onLoadChart() {
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartCustomer')}}?sel_lang=" + that.selLang,
                success: function(data) {
                    that.ReportArea = data.ReportArea;
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
            var ticks6 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];
            var s10 = [];

            const that = this;
            Object.keys(this.ReportArea).map(function(key , value) {
                s9.unshift(that.ReportArea[key][0]);
                s10.unshift(that.ReportArea[key][2]);
                var prefecture = that.ReportArea[key][1];
                var name = '';
                for (var i = 0; i < prefecture.length; i++) {
                    name = name + prefecture.charAt(i) + "<br>";
                }
                ticks6.unshift(name);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart6', [s9,s10], {
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
                title: '',
                // seriesDefaults:{
                //     renderer:$.jqplot.BarRenderer,
                //     pointLabels: { show: true , escapeHTML: false },
                //     markerOptions: {color: 'red'}
                // },
                series:[
                    { label: '{{ trans("label.list_comp_count") }}' ,
                        renderer: $.jqplot.BarRenderer,
                        pointLabels: { show: true, location: 'n', edgeTolerance: -15 },
                        rendererOptions: {barWidth:5,shadow: false}
                    },
                    { label: '{{ trans("label.intepreter_count") }}' ,
                    markerOptions: { style:"filledSquare", size:10 }
                    }
                ],
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks6,
                        // label: '{{ trans("label.area") }}'
                    },
                    yaxis: {
                        min:0,
                        max:500,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: '{{ trans("label.list_comp_count") }}'
                    }
                },
                legend: {show: true},
                highlighter: { show: false },
                height: document.getElementById('myModalChart').clientHeight * 0.6,
                canvasOverlay: {
                    show: false,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 160,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }},
                    ]
                }});
                plot6.replot();
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
        onLoadChartLang() {
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartCustomerLang')}}",
                success: function(data) {
                    that.ReportLang = data.ReportLang;
                    that.loadChartLang();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChartLang() {
            var ticks6 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];

            const that = this;
            Object.keys(this.ReportLang).map(function(key , value) {
                s9.unshift(that.ReportLang[key][0]);
                var prefecture = that.ReportLang[key][1];
                var name = '';
                for (var i = 0; i < prefecture.length; i++) {
                    name = name + prefecture.charAt(i) + "<br>";
                }
                ticks6.unshift(name);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart7', [s9], {
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
                title: '',
                seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true , escapeHTML: false },
                    markerOptions: {color: 'red'}
                },
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks6,
                        // label: '{{ trans("label.area") }}'
                    },
                    yaxis: {
                        min:0,
                        max:4000,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: '{{ trans("label.list_comp_count") }}'
                    }
                },
                highlighter: { show: false },
                height: document.getElementById('myModalChartLang').clientHeight * 0.6,
                canvasOverlay: {
                    show: false,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 160,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }},
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
        filterLang: function(lang) {
            this.clearSearch();
            this.typeLang = lang;
            this.sortName = 'name';  
            this.sortType = "ASC";  
            this.sortBy= 'name';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
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
            var url = baseUrl + "/customer-view/" + _i.id;
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
        clearSearch() {
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
            this.code='';
            this.name='';
            this.address='';
            this.phone='';
            this.email = '';
            this.checkedNames = [1,2,3,4,5,6];
            this.typeLang = '';
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;     
            
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            this.onLoadPagination();
		},
        clearSearchStatusReload() {
            this.clearSearchStatus();
            this.onLoadPagination();
        },
		setSearchStatusReload() {
			this.setSearchStatus();
            this.onLoadPagination();
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [1,2,3,4,5,6];
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
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

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
            if (this.website != '') {
                conditionSearch += '&website=' + this.website;
            }
            if (this.email != '') {
                conditionSearch += '&email=' + this.email;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.typeLang != '') {
                conditionSearch += '&type_langs=' + this.typeLang;
            }
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;                
            }
            conditionSearch += '&showcount=' + this.showCount; 
            this.conditionSearch = conditionSearch;          

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.page  + conditionSearch ,
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