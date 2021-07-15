@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')



<div class="mdk-drawer-layout__content page-content">

    <!-- Header -->


    <!-- // END Header -->

    <!-- BEFORE Page Content -->

    <!-- // END BEFORE Page Content -->

    <!-- Page Content -->
    <div id="list-data">
    
    <div class=" mb-sm-0 mr-sm-24pt" >
        <h1 class="h3 mb-0">
            <center @click="showLeftBar()" style="text-decoration: underline">通訳案件カレンダー</center>
        </h1>
    </div>
<!--
        <div 
            class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-center" >
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-md-0">

                <div class=" mb-sm-0 mr-sm-24pt" >
                    <h1 class="h2 mb-0">
                    <a  @click="showLeftBar()" style="text-decoration: underline">通訳案件カレンダー</a>
                    </h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">通訳派遣カレンダー</li>
                    </ol>
                </div>
            </div>
        </div>
-->

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                
                <div class="col-lg-12 d-flex ">
                    <div class="flex">
                        <div id='calendar'></div>
                       <!-- <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                            <div class="card-header p-0 nav">
                                <div class="row no-gutters"
                                        role="tablist">
                                    <div class="col-auto">
                                        <a href="#"
                                            data-toggle="tab"
                                            role="tab"
                                            aria-selected="true"
                                            class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active tab_click" id="tab1">
                                            <span class="h2 mb-0 mr-3">1</span>
                                            <span class="flex d-flex flex-column">
                                                <strong class="card-title">Calendar</strong>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-auto border-left border-right">
                                        <a href="#"
                                            data-toggle="tab"
                                            role="tab"
                                            aria-selected="false"
                                            class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                            <span class="h2 mb-0 mr-3">2</span>
                                            <span class="flex d-flex flex-column">
                                                <strong class="card-title">Chart</strong>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body tab-content">
                                <div class="tab-pane active text-70" id="detailtab1">
                                <div id='calendar'></div>
                                </div>
                                <div class="tab-pane text-70" id="detailtab2">aBC</div>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
            <div class="row mb-32pt">
                <div class="col-lg-12">
                    <!-- <div class="page-separator">
                        <div class="page-separator__text">絞り込み</div>
                    </div> -->
					
                    <div class="form-group col-lg-12" style="text-align:center">
                        <label class="form-label m-0">ステータス</label><br>
						<button type="button" @click="clearSearchStatus()"　style="background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;">全てOFF</button>
						
						<button type="button" @click="setSearchStatus()" 　style="background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;">全てON</button>
                        <div class="form-group" >
						<div class="col-lg-12 p-0">
							<input type="checkbox" id="0" value="0" v-model="checkedNames" @change="someHandlerChange()">
							<label for="0">受注</label>
							<input type="checkbox" id="1" value="1" v-model="checkedNames" @change="someHandlerChange()">
							<label for="1">通訳者選定</label>
							<input type="checkbox" id="2" value="2" v-model="checkedNames" @change="someHandlerChange()">
							<label for="2">通訳待機</label>
							<input type="checkbox" id="3" value="3" v-model="checkedNames" @change="someHandlerChange()">
							<label for="3">客様の入金確認</label>
							<input type="checkbox" id="4" value="4" v-model="checkedNames" @change="someHandlerChange()">
							<label for="4">通訳給与支払い</label>
							<input type="checkbox" id="5" value="5" v-model="checkedNames" @change="someHandlerChange()">
							<label for="5">営業報酬支払い</label>
							<input type="checkbox" id="8" value="8" v-model="checkedNames" @change="someHandlerChange()">
							<label for="7">手配料金入金確認</label>
							<input type="checkbox" id="6" value="6" v-model="checkedNames" @change="someHandlerChange()">
							<label for="6">クローズ</label>
							<input type="checkbox" id="7" value="7" v-model="checkedNames" @change="someHandlerChange()">
							<label for="7">キャンセル</label>
							</div>
					  </div>  
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
<link href="{{ asset('js/lib/main.css') }}" rel='stylesheet' />
<script src="{{ asset('js/lib/main.js') }}"></script>


<script type="text/javascript">
    var calendar;
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });

        
    
    });
    var listDate = [];
    @foreach($data as $item)
        @foreach($item->ngay_pd as $itemdateList)
        listDate.push(
            {
                title: '{{$item->address_pd}} '+'( {{@$item->ctvSalesList[0]->name}} )'.toUpperCase()+' ( {{@$item->ctvList[0]->name}} ) '.toUpperCase(),
                url: '/admin/company/edit/{{$item->id}}',
                start: '{{$itemdateList}}'
            }
        );
        @endforeach
    @endforeach
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
			left: 'today',
            center: 'title',
			right:''
        },
		footerToolbar: {
			left: 'prevYear,prev,next,nextYear',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
		},
        initialDate: '{{$now}}',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        dayMaxEvents: false, // allow "more" link when too many events
        events: listDate,
	
        eventClick: function(event) {
            if (event.event.url) {
            event.jsEvent.preventDefault()
            window.open(event.event.url, "_blank");
            }
        }
        });

        calendar.render();
    });
    
</script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$leftBarVal = 0;

new Vue({
    el: '#list-data',
    data: {
        conditionStatus: "",
        checkedNames: [0,1,2,3,4,5,6,8]
    },
    delimiters: ["((", "))"],
    mounted() {
    },
    methods: {
		onLoadPagination() {
            
            console.log(this.checkedNames.length);
            if ( this.checkedNames.length > 0) {
                    listDate = [];
                    this.checkedNames.map(itemMap =>  {
                        @foreach($data as $item)
                        if (itemMap == "{{$item->status}}") {
                            
                                @foreach($item->ngay_pd as $itemdateList)
                                    
                                    
                                        listDate.push(
                                            {
                                                title: '{{$item->address_pd}} '+'( {{@$item->ctvSalesList[0]->name}} )'.toUpperCase()+' ( {{@$item->ctvList[0]->name}} ) ',
                                                url: '/admin/company/edit/{{$item->id}}',
                                                start: '{{$itemdateList}}'
                                            }
                                        );
                                
                                @endforeach
                            
                            }
                        @endforeach
                    })
                    
                    calendar.removeAllEvents();
                    calendar.addEventSource(listDate);
                    // var calendarEl = document.getElementById('calendar');

                    // calendar = new FullCalendar.Calendar(calendarEl, {
                    // headerToolbar: {
                    //     left: 'prevYear,prev,next,nextYear today',
                    //     center: 'title',
                    //     right: 'dayGridMonth,dayGridWeek,dayGridDay'
                    // },
                    // initialDate: '{{$now}}',
                    // navLinks: true, 
                    // editable: true,
                    // dayMaxEvents: false, 
                    // events: listDate,
                    // eventClick: function(event) {
                    //     if (event.event.url) {
                    //     event.jsEvent.preventDefault()
                    //     window.open(event.event.url, "_blank");
                    //     }
                    // }
                    // });

                    // calendar.render();
                    
            } else {
                listDate = [];
                    
                @foreach($data as $item)
                    @foreach($item->ngay_pd as $itemdateList)
                        listDate.push(
                            {
                                title: '{{$item->address_pd}} '+'( {{@$item->ctvSalesList[0]->name}} )'.toUpperCase()+' ( {{@$item->ctvList[0]->name}} ) ',
                                url: '/admin/company/edit/{{$item->id}}',
                                start: '{{$itemdateList}}'
                            }
                        );
                    
                    @endforeach
                @endforeach
                calendar.removeAllEvents();
                calendar.addEventSource(listDate);
            }
        },
		clearSearchStatus() {
            this.checkedNames = [];
            this.onLoadPagination();
		},
		setSearchStatus() {
            this.checkedNames = [0,1,2,3,4,5,6,7,8];
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
        someHandlerChange: function() {
			this.onLoadPagination();
            
        }
    },
});
</script>

@stop