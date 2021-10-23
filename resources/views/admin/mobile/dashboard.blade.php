@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', 'ホーム')

<div class="mdk-drawer-layout__content page-content">
    @include('admin.component.header_mobile')

    <div id="list-data">
        <div class="container page__container page-section">
            <div class="row" style="margin-bottom:50px;margin-top:-20px;">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <div class="page-separator">
                            <div class="page-separator__text"><span>{{ trans("label.year_graph2") }}</span></div>
                        </div>
                        <div class="card card-body">
                            <div class="chart" style="height: 420px;">
                                <div class="flex" id="chart6" style="max-width: 100%;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                                    <div class="card-body">
                                        <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(sumEarning) ))</h4>
                                        <div>{{ trans("label.earning_sum") }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card text-center mb-lg-0">
                                    <div class="card-body">
                                        <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(sumCost) ))</h4>
                                        <div>{{ trans("label.cost1") }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card text-center mb-lg-0">
                                    <div class="card-body">
                                        <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(sumBenefit) ))</h4>
                                        <div><span>{{ trans("label.benefit_sum") }} (率:</span><span>((sumBenefit_percent))%)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.today_interpreter2") }}(<span>((listToday.length))件</span>)</div>
                        </div>
                        <div class="card" v-if="listToday.length">
                            <table class="table thead-border-top-0 table-nowrap mb-0 mt-10">
                                <tbody class="list">
                                    <tr v-for="item in listToday">
                                        <td>
                                            <div>
                                                <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/projectview/' + item.id">
                                                    <span class="labelButton">{{ trans('label.id') }}((item.id))</span> 
                                                    <span> (</span>
                                                    <span v-if='item.status == 0 || item.status == ""'>{{ trans('label.status0') }}</span>
                                                    <span v-if='item.status == 1'>{{ trans('label.status1') }}</span>
                                                    <span v-if='item.status == 2'>{{ trans('label.status2') }}</span>
                                                    <span v-if='item.status == 3'>{{ trans('label.status3') }}</span>
                                                    <span v-if='item.status == 8'>{{ trans('label.status8') }}</span>
                                                    <span v-if='item.status == 4'>{{ trans('label.status4') }}</span>
                                                    <span v-if='item.status == 5'>{{ trans('label.status5') }}</span>
                                                    <span v-if='item.status == 6'>{{ trans('label.status6') }}</span>
                                                    <span v-if='item.status == 7'>{{ trans('label.status7') }}</span>
                                                    <span> )</span>
                                                </a>    
                                            </div>
                                            <div v-if="item.cus_jobs_id">
                                                <a target="_blank" :href="'/admin/customer-view/' + item.cus_jobs_id">
                                                    <u><b>
                                                        (( parseName(item.customer_name) )) 
                                                    </b></u>
                                                </a>
                                                <span v-for="itemCTV in item.ctv_sales_list" class="spaceLabel">
                                                    <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                                    <u><b><span>(</span>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}<span>)</span></b></u>
                                                    </a>
                                                </span> 
                                            </div>
                                            <div v-if="!item.cus_jobs_id">
                                                <span v-for="itemCTV in item.ctv_sales_list">
                                                    <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                                        <u><b>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}</b></u>
                                                    </a>
                                                </span> 
                                            </div>
                                            <div>(( item.ngay_pd )) ((item.address_pd))</div>
                                            <div v-for="itemCTV in item.ctv_list">
                                                <i v-if="itemCTV.male == 1" class="fa fa-male maleClass"></i>
                                                <i v-if="itemCTV.male == 2" class="fa fa-female femaleClass"></i>
                                                 <a target="_blank" :href="'/admin/partner-interpreter-view/' + itemCTV.user_id">
                                                 (( parseName(itemCTV.name) ))
                                                </a>
                                                <span class="spaceLabel">(</span>
                                                <a target="_blank" :href="'tel:'+itemCTV.phone">
                                                    {{ trans('label.tel2') }}: (( parsePhone(itemCTV.phone) ))
                                                </a>
                                                <span>)</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.tomorrow_interpreter2") }}(<span>((listNextday.length))件</span>)</div>
                        </div>
                        <div class="card" v-if="listNextday.length">
                            <table class="table thead-border-top-0 table-nowrap mb-0 mt-10">
                                <tbody class="list">
                                    <tr v-for="item in listNextday">
                                        <td>
                                        <div>
                                                <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/projectview/' + item.id">
                                                    <span class="labelButton">{{ trans('label.id') }}((item.id))</span> 
                                                    <span> (</span>
                                                    <span v-if='item.status == 0 || item.status == ""'>{{ trans('label.status0') }}</span>
                                                    <span v-if='item.status == 1'>{{ trans('label.status1') }}</span>
                                                    <span v-if='item.status == 2'>{{ trans('label.status2') }}</span>
                                                    <span v-if='item.status == 3'>{{ trans('label.status3') }}</span>
                                                    <span v-if='item.status == 8'>{{ trans('label.status8') }}</span>
                                                    <span v-if='item.status == 4'>{{ trans('label.status4') }}</span>
                                                    <span v-if='item.status == 5'>{{ trans('label.status5') }}</span>
                                                    <span v-if='item.status == 6'>{{ trans('label.status6') }}</span>
                                                    <span v-if='item.status == 7'>{{ trans('label.status7') }}</span>
                                                    <span> )</span>
                                                </a>    
                                            </div>
                                            <div v-if="item.cus_jobs_id">
                                                <a target="_blank" :href="'/admin/customer-view/' + item.cus_jobs_id">
                                                    <u><b>
                                                        (( parseName(item.customer_name) )) 
                                                    </b></u>
                                                </a>
                                                <span v-for="itemCTV in item.ctv_sales_list" class="spaceLabel">
                                                    <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                                    <u><b><span>(</span>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}<span>)</span></b></u>
                                                    </a>
                                                </span> 
                                            </div>
                                            <div v-if="!item.cus_jobs_id">
                                                <span v-for="itemCTV in item.ctv_sales_list">
                                                    <a target="_blank" :href="'/admin/partner-sale-view/' + itemCTV.ctv_jobs_id">
                                                        <u><b>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}</b></u>
                                                    </a>
                                                </span> 
                                            </div>
                                            <div>(( item.ngay_pd )) ((item.address_pd))</div>
                                            <div v-for="itemCTV in item.ctv_list">
                                                <i v-if="itemCTV.male == 1" class="fa fa-male maleClass"></i>
                                                <i v-if="itemCTV.male == 2" class="fa fa-female femaleClass"></i>
                                                 <a target="_blank" :href="'/admin/partner-interpreter-view/' + itemCTV.user_id" class="spaceLabel">
                                                 (( parseName(itemCTV.name) ))
                                                </a>
                                                <span class="spaceLabel">(</span>
                                                <a target="_blank" :href="'tel:'+itemCTV.phone">
                                                    {{ trans('label.tel2') }}: (( parsePhone(itemCTV.phone) ))
                                                </a>
                                                <span>)</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.log") }}</div>
                        </div>
                        <div class="card">
                            <table class="table thead-border-top-0 table-nowrap mb-0">
                                <tbody class="list" id="search">
                                    <tr v-for="item in sortedProducts">
                                        <td>
                                        ((item.create_date)) - ((item.creator_name))<br>
                                        {{ trans('label.log_id') }}((item.id)) - ((item.title))<br>
                                        <div class="text-block" v-html="item.content">
                                        ((item.content))
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-footer p-8pt">
                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                    <li class="page-item" v-bind:class="pageLog <= 1 ? 'disabled' : ''"
                                        @click="onPrePageLog()">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                            <span>{{ trans('label.pre_page') }}</span>
                                        </a>
                                    </li>
                                    <li class="page-item disabled" v-if="pageLog > 3 ">
                                        <a class="page-link" href="#">
                                            <span>...</span>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="item in listPageLog"
                                        v-if="pageLog > (item - 3) && pageLog < (item + 3) " @click="onPageChangeLog(item)"
                                        v-bind:class="pageLog == item ? 'active' : ''">
                                        <a class="page-link" href="#" aria-label="Page 1">
                                            <span>((item))</span>
                                        </a>
                                    </li>
                                    <li class="page-item" @click="onNextPageLog()"
                                        v-bind:class="pageLog > countLog - 1 ? 'disabled' : ''">
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

    <!-- // END Page Content -->

    <!-- Footer -->

    @include('admin.component.footer_mobile')

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


<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
let d = new Date();
let year = d.getFullYear();
let month = String(d.getMonth() + 1);
let day = String(d.getDate());


$leftBarVal = 0;
new Vue({
    el: '#list-data',
    data: {
        thisMonth: month,
        daystr: "{{date('Y-m-d')}}",
        thisYear: year,
        thisDay: day,
        message: '',
        loadingTable: 0,
        loadingTableLog: 0,
        count: 0,
        page: 1,
        pageLog: 1,
        conditionSearch: '',
        countLog: 0,
        listLog: [],
        listToday: [],
        listNextday: [],
        list: [],
        listPage: [],
        listPageLog: [],
        conditionName: '',
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        groups: [],
        conditionStatus: '',
        conditionAddress: '',
        ngay_phien_dich: '',
		thang_chuyen_khoan: "{{date('Y-m')}}",
        thang_phien_dich: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        type_jobs: '',
        codeJobs: '',
        checkedNames: [4,5,6],
		checkedTypes: [1,2,3],
        sortName: '',
        sortType:"DESC",
        sumPay: 0,
        sumCount:0,
        sumEarning:0,
        sumBenefit: 0,
        sumBenefit_percent: 0,
        sumCost:0 ,
        yearReportPrice: [],
        sortBy: 'id',
        sortDirection: 'desc',
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
        this.onLoadLog();
    },
    computed: {
        sortedProducts: function(){
            return this.listLog.sort((p1,p2) => {

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
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onPageChangeLog(_p) {
            this.pageLog = _p;
            this.onLoadLog();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChange: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        sortNgayPD: function() {
            this.sortName = "company.ngay_pd";
            this.onLoadPagination();
        },
        sortJobID: function() {
            this.sortName = "company.codejob";
            this.onLoadPagination();
        },
        showLeftBar: function() {
            if ($leftBarVal == 0) {
                $("#default-drawer").css("display","none");
                $leftBarVal = 1;
            } else {
                $("#default-drawer").css("display","block");
                $leftBarVal = 0;
            }
        },
        clearSearch() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.ngay_phien_dich = '';
			this.thang_phien_dich = '';
            this.thang_chuyen_khoan = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.type_jobs = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.pageLog = 1;
            this.conditionSearch = "";
            this.checkedNames = [4,5,6];
			this.checkedTypes = [1,2,3];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.sumPay= 0;
            this.sumCount=0;
            this.sumEarning =0;
            this.sumBenefit =0;
            this.sumCost =0;
            
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            this.onLoadPagination();
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [4,5,6];
            this.onLoadPagination();
		},
		clearSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [];
            this.onLoadPagination();
		},
		setSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [1,2,3];
            this.onLoadPagination();
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
                title: that.thisYear + "年",
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
                        ticks: ticks6,
                        // label: that.thisYear + "年"
                    },
                    yaxis: {
                        min:0,
                        max:300,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        // label: "万円",
                        pad: 0,
                    }
                },

                highlighter: { show: false },
                height: 410,
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
                    url: "/admin/company/delete/" + _i.id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        that.loadingTable = 0;
                        that.onLoadPagination();
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
        onLoadLog() {
            this.loadingTableLog = 1;
            const that = this;
            
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListLog')}}?page=" + this.pageLog,
                success: function(data) {
                    if (data.count > 0) {
                        that.countLog = data.pageTotal;
                        that.listLog = data.data;
                    } else {
                        that.countLog = 0;
                        that.listLog = [];
                    }
                    that.loadingTableLog = 0;
                    let pageArr = [];
                    if (that.pageLog - 2 > 0) {
                        pageArr.push(that.pageLog - 2);
                    }
                    if (that.pageLog - 1 > 0) {
                        pageArr.push(that.pageLog - 1);
                    }
                    pageArr.push(that.pageLog);
                    if (that.pageLog + 1 <= that.countLog) {
                        pageArr.push(that.pageLog + 1);
                    }
                    if (that.pageLog + 2 <= that.countLog) {
                        pageArr.push(that.pageLog + 2);
                    }
                    that.listPageLog = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
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
            let checkedNames = [0,1,2,3,4,5,6,8];
            conditionSearch += '&status_multi=' + checkedNames.join();
            this.showCount=0;
            this.conditionSearch = conditionSearch;

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListProject')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {                        
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumPay = data.sumPay;
                        that.sumCount = data.count;
                        that.sumEarning = data.sumEarning;
                        that.sumBenefit = data.sumBenefit;
                        that.sumCost = data.sumCost;
                        that.sumEarning = data.sumEarning;
                        that.dayPrices = data.dayPrices;
                        that.yearReportPrice = data.yearReportPrice;

                        that.sumBenefit_percent = Math.floor(that.sumBenefit / that.sumEarning * 100);

                        var today = new Date();
                        var yyyy = today.getFullYear();
                        var mm = String(today.getMonth() + 1).padStart(2, '0');
                        var dd = String(today.getDate()).padStart(2, '0');
                        var todaystr = yyyy + "-" + mm + '-' + dd;
                        for (var item of that.list) {
                            var ngay_pd = item["ngay_pd"];
                            if (ngay_pd.indexOf(todaystr) != -1) {
                                that.listToday.push(item);
                            }
                        }

                        const tomorrow = new Date(today);
                        tomorrow.setDate(tomorrow.getDate() + 1);
                        var tomorrowstr = tomorrow.getFullYear() + "-" + String(tomorrow.getMonth() + 1).padStart(2, '0') + '-' + String(tomorrow.getDate()).padStart(2, '0');
                        for (var item of that.list) {
                            var ngay_pd = item["ngay_pd"];
                            if (ngay_pd.indexOf(tomorrowstr) != -1) {
                                that.listNextday.push(item);
                            }
                        }

                        that.loadChartMonth();
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.list = [];
                        that.listToday = [];
                        that.listNextday = [];
                        that.sumEarning = 0;
                        that.sumBenefit = 0;
                        that.sumBenefit_percent = 0;
                        that.sumCost = 0;
                        that.yearReportPrice = [];
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
        onPrePageLog() {
            if (this.pageLog > 1) {
                this.pageLog = this.pageLog - 1;
            }
            this.onLoadLog();
        },
        onNextPageLog() {
            if (this.pageLog < this.countLog) {
                this.pageLog = this.pageLog + 1;
            }
            this.onLoadLog();
        }
    },
});
</script>

@stop