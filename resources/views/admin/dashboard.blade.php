@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')

@section('contentTitle', 'ホーム')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')
    
    <div id="list-data">
        <div class="container page__container page-section">
        <div class="row mb-32pt">
             <div class="col-lg-6">
                <div class="page-separator">
                    <div class="page-separator__text">売上情報</div>
                </div>
                <div class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                            <div class="card-body">
                                <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumEarningMonth) ))</h4>
                                <div>当月売上高</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card text-center mb-lg-0">
                            <div class="card-body">
                                <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumEarningYear) ))</h4>
                                <div>本年売上高</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div>（万円）</div>
                        <div class="flex" id="chart4" style="max-width: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="page-separator">
                    <div class="page-separator__text">利益情報</div>
                </div>
                <div class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                            <div class="card-body">
                                <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumBenefitMonth) ))</h4>
                                <div>当月利益高</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card text-center mb-lg-0">
                            <div class="card-body">
                                <h4 class="h2 mb-0">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumBenefitYear) ))</h4>
                                <div>本年利益高</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div>（万円）</div>
                        <div class="flex" id="chartBenefit" style="max-width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
            <div class="page-separator">
                <div class="page-separator__text">受注件数</div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0">(( sumCountMonth ))</h4>
                            <div>当月受注件数</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0">(( sumCountYear ))</h4>
                            <div>本年受注件数</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="col-12 col-md-12">
                    <div>（件）</div>
                    <div class="flex" id="chart1" style="max-width: 100%"></div>
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
$(document).ready(function(){

        $.jqplot.config.enablePlugins = true;
        var s5 = [];
        var s6 = [];
        var ticks4 = [];
        @foreach($yearReportPrice as $key => $itemReport)
            s5.push('{{$itemReport[0]}}');
            s6.push('{{$itemReport[1]}}');
            ticks4.push("{{ $key }}");
        @endforeach
        plot4 = $.jqplot('chart4', [s5], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks4
                },
                yaxis: {
                    min:0,
                    max:120
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 100,
                        lineWidth: 2,
                        xOffset: 0.1,
                        color: 'red',
                        shadow: false,
						linePattern: 'dotted'
                    }}
                ]
            }
        });

        

        $('#chart4').bind('jqplotDataHighlight', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info4').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
             
        $('#chart4').bind('jqplotDataUnhighlight', 
            function (ev) {
                $('#info4').html('Nothing');
            }
        );

        plotBenefit = $.jqplot('chartBenefit', [s6], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesColors:['orange'],
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks4
                },
                yaxis: {
                    min:0,
                    max:120
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                   
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 60,
                        lineWidth: 2,
                        xOffset: 0.1,
                        color: 'red',
                        shadow: false,
						linePattern: 'dotted'
                    }}
                ]
            }
        });

        $('#chartBenefit').bind('jqplotDataHighlight', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info4').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
            
        $('#chartBenefit').bind('jqplotDataUnhighlight', 
            function (ev) {
                $('#info4').html('Nothing');
            }
        );


        var s1 = [];
        var ticks = [];
        @foreach($yearReport as $key => $itemReport)
            s1.push('{{$itemReport}}');
            ticks.unshift("{{ date('m/d', strtotime($key)) }}");
        @endforeach
        plotchart1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesColors:['purple'],
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks4
                },
                yaxis: {
                    min:0,
                    max:400
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                   
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 200,
                        lineWidth: 1,
                        xOffset: 0.1,
                        color: 'red',
                        shadow: false,
						linePattern: 'dotted'
                    }}
                ]
            }
        });

        $('#chart1').bind('jqplotDataHighlight', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info4').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
            
        $('#chart1').bind('jqplotDataUnhighlight', 
            function (ev) {
                $('#info4').html('Nothing');
            }
        );
        
    });

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$leftBarVal = 0;
new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        conditionSearch: '',
        list: [],
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
		thang_chuyen_khoan: "{{date('Y-m')}}",
        thang_phien_dich: "{{date('Y-m')}}",
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        type_jobs: '',
        codeJobs: '',
        checkedNames: [0,1,2,3,4,5,6,8],
		checkedTypes: [1,2,3],
        sortName: '',
        sortType:"DESC",
        sumPay: 0,
        sumEarningMonth: 0,
        sumEarningYear: 0,
        sumBenefitMonth:0,
        sumBenefitYear:0 ,
        sumCountMonth:0,
        sumCountYear:0,
        sumCount:0,
        dayPrices:[]
    },
    delimiters: ["((", "))"],
    mounted() {

        this.onLoadPagination();
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
            this.conditionSearch = "";
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1,2,3];
            this.sortName = '';  
            this.sortType = "DESC";  
        this.sumPay= 0;
        this.sumEarningMonth = 0;
        this.sumEarningYear = 0;
        this.sumBenefitMonth = 0;
        this.sumBenefitYear = 0;
        this.sumCountMonth = 0;
        this.sumCountYear = 0;
        this.sumCount=0;
        this.dayPrices=[];
            
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
            if (this.type_jobs != '') {
                conditionSearch += '&type_jobs=' + this.type_jobs;
            }
            if (this.dateOrder != '') {
                conditionSearch += '&date_start=' + this.dateOrder;
            }
            if (this.ngay_phien_dich != '') {
                conditionSearch += '&ngay_phien_dich=' + this.ngay_phien_dich;
            }
            if (this.thang_phien_dich != '') {
                conditionSearch += '&thang_phien_dich=' + this.thang_phien_dich;
            }
            if (this.thang_chuyen_khoan != '') {
                conditionSearch += '&thang_chuyen_khoan=' + this.thang_chuyen_khoan;
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
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.checkedTypes.length > 0) {
                conditionSearch += '&loai_job_multi=' + this.checkedTypes.join();
            }
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;
                if (this.sortType == "DESC") {
                    this.sortType = "ASC";
                } else {
                    this.sortType = "DESC";
                }
            }
            this.conditionSearch = conditionSearch;
            

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListDashboard')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        
                        that.count = data.pageTotal;
                        that.list = data.data3;
                        that.sumPay = data.sumPay;
                        that.sumEarningMonth = data.sumEarningMonth;
                        that.sumEarningYear = data.sumEarningYear;
                        that.sumBenefitMonth = data.sumBenefitMonth;
                        that.sumBenefitYear = data.sumBenefitYear;
                        that.sumCountMonth = data.sumCountMonth;
                        that.sumCountYear = data.sumCountYear;
                        that.sumCount = data.count;
                        that.dayPrices = data.dayPrices;
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
        }
    },
});
</script>

@stop
