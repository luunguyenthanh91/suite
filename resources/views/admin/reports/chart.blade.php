@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')



<div class="mdk-drawer-layout__content page-content">

    <!-- Header -->

    @include('admin.component.header')

    <!-- // END Header -->

    <!-- BEFORE Page Content -->

    <!-- // END BEFORE Page Content -->

    <!-- Page Content -->
    <div id="list-data">
        <div
            class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-md-0">

                <div class=" mb-sm-0 mr-sm-24pt">
                    <h1 class="h2 mb-0">通訳案件の件数集計</h1>
<!--
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">通訳派遣集計</li>
                    </ol>
-->
                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
<div class="col-12 col-md-12">
				<div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                    <div class="card-header p-0 nav">
                        <div class="row no-gutters"
                                role="tablist">
                            <div class="col-auto">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active tab_click" id="tab1">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">日ごと</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="true"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">月ごと</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab3">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">年ごと</strong>
                                    </span>
                                </a>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active text-70" id="detailtab1">
                            <div class="row mb-32pt">
                                <div class="col-12 col-md-12">
                    <div class="page-separator">
                        <div class="page-separator__text">日の件数</div>
                    </div>
                    <div class="flex" id="chart1" style="max-width: 100%">
                        
                    </div>
					<div class="form-group col-lg-12">
					</div>
                    <div class="form-group col-lg-2">
                        <label class="form-label m-0">月の選択</label>
                        <input type="month" class="form-control search"  @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich">
                            
                    </div>
					<div class="flex" id="chart1Spec" style="max-width: 100%">
                        
                    </div>
                </div>
                            </div>
                        </div>
                        <div class="tab-pane text-70" id="detailtab2">
                            <div class="row mb-32pt">
							
							
							
							</div>
						</div>
                       <div class="tab-pane text-70" active id="detailtab3">
                            <div class="row mb-32pt">
							
							
							
							
							</div>
						</div>
					</div>
                </div>
				</div>
<div class="col-12 col-md-12">
                    <div class="page-separator">
                        <div class="page-separator__text">月の件数</div>
                    </div>
                    <div class="flex" id="chart2" style="max-width: 100%">
                        
                    </div>
					
					<div class="form-group col-lg-12">
					</div>
					<div class="form-group col-lg-2">
                        <label class="form-label m-0">年の選択</label>
                        <input type="month" class="form-control search"  @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich">
                            
                    </div>
					<div class="flex" id="chart2Spec" style="max-width: 100%">
                        
                    </div>
                </div>

                
                
                
				
				

            </div>
    
        </div>
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



<script class="code" type="text/javascript">
$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [];
        var ticks = [];
        @foreach($dayJobs as $key => $itemReport)
        s1.unshift('{{$itemReport}}');
        ticks.unshift("{{ date('m/d', strtotime($key)) }}");
        @endforeach
        
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
                yaxis: {
                    min:0,
                    max:20
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 10,
                        lineWidth: 1,
                        xOffset: 0.05,
                        color: 'red',
                        shadow: false,
						linePattern: 'dashed'
                    }}
                ]
            }
        });
    
        $('#chart1').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
		
		
        plot1Spec = $.jqplot('chart1Spec', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                },
                yaxis: {
                    min:0,
                    max:20
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 10,
                        lineWidth: 1,
                        xOffset: 0.05,
                        color: 'red',
                        shadow: false,
						linePattern: 'dashed'
                    }}
                ]
            }
        });
    
        $('#chart1Spec').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );



        $.jqplot.config.enablePlugins = true;
        var s2 = [];
        var ticks2 = [];
        @foreach($yearReport as $key => $itemReport)
        s2.push('{{$itemReport}}');
        ticks2.push("{{ $key }}");
        @endforeach
        
        plot2 = $.jqplot('chart2', [s2], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks2
                },
                yaxis: {
                    min:0,
                    max:200
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 100,
                        lineWidth: 1,
                        xOffset: 0.1,
                        color: 'red',
                        shadow: false,
						linePattern: 'dashed'
                    }}
                ]
            }
        });
    
        $('#chart2').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info2').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
		
		plot2 = $.jqplot('chart2Spec', [s2], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks2
                },
                yaxis: {
                    min:0,
                    max:200
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: true,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 100,
                        lineWidth: 1,
                        xOffset: 0.1,
                        color: 'red',
                        shadow: false,
						linePattern: 'dashed'
                    }}
                ]
            }
        });
    
        $('#chart2Spec').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info2').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );

        $.jqplot.config.enablePlugins = true;
        var s3 = [];
        var s4 = [];
        var s7 = [];
        var s8 = [];
        var ticks3 = [];
        

        
    });
</script>

<script type="text/javascript">
	
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#list-data',
    data: {
        
    },
    delimiters: ["((", "))"],
    mounted() {
    },
    methods: {
       
    },
});

jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });

        
    
    });
</script>

@stop