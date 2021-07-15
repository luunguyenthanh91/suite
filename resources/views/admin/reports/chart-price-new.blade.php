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
                    <h1 class="h2 mb-0">通訳案件入金集計</h1>
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
                    <div class="page-separator">
                        <div class="page-separator__text">日の売上・実績</div>
                    </div>
                    
                    <div class="flex" id="chart5" style="max-width: 100%">
                        
                    </div>
                </div>

                <div class="col-12 col-md-12">
                    
                    <div class="page-separator">
                        <div class="page-separator__text">月の売上・実績</div>
                    </div>
                    <div class="flex" id="chart6" style="max-width: 100%">
                        
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
        

        $.jqplot.config.enablePlugins = true;
        var s3 = [];
        var s4 = [];
        var s7 = [];
        var s8 = [];
        

        var ticks5 = [];
        @foreach($dayPrices as $key => $itemReport)
            s7.unshift('{{$itemReport[2]}}');
            s8.unshift('{{$itemReport[3]}}');
            ticks5.unshift("{{ date('m/d', strtotime($key)) }}");
        @endforeach
        
        plot5 = $.jqplot('chart5', [s7
        ,s8], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks5
                },
                yaxis: {
                    min:0,
                    max:20
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: false,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 50,
                        lineWidth: 3,
                        xOffset: 0,
                        color: '#4BB2C5',
                        shadow: false
                    }},
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 10,
                        lineWidth: 3,
                        xOffset: 0,
                        color: 'red',
                        shadow: false
                    }}
                ]
            }
        });

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



        $.jqplot.config.enablePlugins = true;
        var s5 = [];
        var s6 = [];
        var s9 = [];
        var s10 = [];
        

        var ticks6 = [];
        @foreach($yearReportPrice as $key => $itemReport)
            s9.push('{{$itemReport[2]}}');
            s10.push('{{$itemReport[3]}}');
            ticks6.push("{{ $key }}");
        @endforeach
        
        plot6 = $.jqplot('chart6', [s9,s10], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks6
                },
                yaxis: {
                    min:0,
                    max:400
                }
            },
            highlighter: { show: false },
            canvasOverlay: {
                show: false,
                objects: [
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 300,
                        lineWidth: 3,
                        xOffset: 0,
                        color: '#4BB2C5',
                        shadow: false
                    }},
                    {horizontalLine: {
                        name: 'pebbles',
                        y: 100,
                        lineWidth: 3,
                        xOffset: 0,
                        color: 'red',
                        shadow: false
                    }}
                ]
            }
        });

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
</script>

@stop