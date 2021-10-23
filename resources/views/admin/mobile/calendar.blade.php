@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', 'カレンダー')

<div class="mdk-drawer-layout__content page-content page-notscroolMobile">

    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <div id="list-data">
        <div class="bodyContentMobile" style=background:white;">
            <div class="col-lg-12"  style=margin-top:10px;">
                <div id='calendar' style="text-align:center;"></div>
            </div>
        </div>
    </div>

</div>

<!-- menu -->
@include('admin.component.left-bar')

@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>
<link href="{{ asset('js/lib/main.css') }}" rel='stylesheet' />
<script src="{{ asset('js/lib/main.js') }}"></script>


<script type="text/javascript">
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
var headerControl = (viewPC)? {
    left: 'prev,next,today',
    center: 'title',
    right:'dayGridMonth,dayGridWeek,dayGridDay,listWeek'
} : {
    left: '',
    center: 'prevYear,prev,today,next,nextYear,title,dayGridWeek,dayGridDay,dayGridMonth,listWeek',
    right:''
};
var footerControl = (viewPC)? {
    left: '',
    center: '',
    right: ''
} : {
    left: '',
    center: '',
    right:''
};
var heightScr = $(window).height() - 150;
var widthScr = $(window).width();
        
var calendar;
var listDate = [];
var listHolidayDate = [];
@foreach($holidays as $item)
    listHolidayDate.push(
        {
            title: '{{@$item->title}}',
            start: '{{@$item->start}}',
            textColor:'red',
            rendering: 'background',
            color:"#ffd0d0",
        }
    );
@endforeach
@foreach($data as $item)
    @foreach($item->ngay_pd as $itemdateList)
    var imgDiv = '';
    if ('{{@$item->ctvList[0]->male}}' == '1') {
        imgDiv = "<i class='fa fa-male' style='color:blue'></i>";
    } else if ('{{@$item->ctvList[0]->male}}' == '2') {
        imgDiv = "<i class='fa fa-female' style='color:red'></i>";
    }
    
    if ('{{$item->status}}' == '3') {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: '#008000',
                borderColor:'#008000'
            }
        );
    } else if ('{{$item->status}}' == '4') {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: '#20B2AA',
                borderColor:'#20B2AA'
            }
        );
    }  else if ('{{$item->status}}' == '5') {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: '#9400D3',
                borderColor:'#9400D3'
            }
        );
    }   else if ('{{$item->status}}' == '8') {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: '#fe28a2',
                borderColor:'#fe28a2'
            }
        );
    } else if ('{{$item->status}}' == '6') {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor:'grey',
                textColor:'#fff',
                borderColor:'grey'
            }
        );
    } else if ('{{$item->status}}' == '7') {
        listDate.push(
            {
                title: '<s>'+'受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase()+'</s>',
                                    url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: 'red',
                borderColor: 'red'
            }
        );
    } else if ('{{$item->status}}' == '2') {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                 url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: '#00BFFF',
                borderColor:'#00BFFF'
            }
        );
    } else {
        listDate.push(
            {
                title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                 url: '/admin/projectview/{{$item->id}}',
                extendedProps: {
                    isResourceHtml: 'YES'
                },
                start: '{{$itemdateList}}',
                backgroundColor: '#CC7000',
                borderColor:'#CC7000'
            }
        );
    }
    @endforeach
@endforeach

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            height: heightScr,
            themeSystem: 'bootstrap',
            windowResize: function(view) {
                
            },
            views: {
                timeGridWeek: {
                    titleFormat: function (date) {
                    const startMonth = date.start.month + 1;
                    const endMonth = date.end.month + 1;

                    // 1週間のうちに月をまたぐかどうかの分岐処理
                    if (startMonth === endMonth) {
                        return startMonth + '月';
                    } else {
                        return startMonth + '月～' + endMonth + '月'; 
                    }
                    },
                    dayHeaderFormat: function (date) {
                    const day = date.date.day;
                    const weekNum = date.date.marker.getDay();
                    const week = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'][weekNum];

                    return day + ' ' + week;
                    }
                }
            },
            resourceLabelContent: function(arg) {
                // let spanEl  = document.createElement('span')
                // let resHtml = arg.resource.extendedProps['resourceHtml'];

                // if (arg.resource.extendedProps.isResourceHtml) {
                //     spanEl .innerHTML = resHtml
                // } else {
                //     spanEl .innerHTML = arg.resource.title
                // }
                // let arrayOfDomNodesLabelContent = [ spanEl ]
                // return { domNodes: arrayOfDomNodesLabelContent }
            },
                //FOR EVENTS
            eventContent: function(arg) {
                let divEl = document.createElement('div');
                divEl.style.overflow = 'hidden';
                let htmlTitle = arg.event._def.extendedProps['html'];
                if (arg.event.extendedProps.isHTML) {
                    divEl.innerHTML = htmlTitle
                } else {
                    divEl.innerHTML = arg.event.title
                }
                let arrayOfDomNodes = [ divEl ]
                return { domNodes: arrayOfDomNodes }
            },
            eventSources : [
                // {
                //     googleCalendarApiKey: 'AIzaSyBjxrUOpSUO31Ia7roHJiWs-_hG7uTgUsk',
                //     // googleCalendarId でも url でもどちらでも動作する
                //     googleCalendarId: 'japanese__ja@holiday.calendar.google.com',
                //     textColor:'red',
                //     rendering: 'background',
                //     color:"#ffd0d0"
                // }
            ],
            stickyHeaderDates: true,
            initialDate: '2021-03-17',
            businessHours: true,
            editable: true,
            locale: 'ja',
            firstDay: 1,
            // contentHeight:"auto",
            handleWindowResize:true,
            weekends: true,
            eventOrder:"title",
            buttonText: {
                today:    '今日',
                month:    '月',
                week:     '週',
                day:      '日',
                list:     '一覧'
            },
            monthNames: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            // 月略称
            monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
            // 曜日名称
            dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
            // 曜日略称
            dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
            headerToolbar: headerControl,
            footerToolbar: footerControl,
            dayCellContent: function(e) {
                e.dayNumberText = e.dayNumberText.replace('日', '');
            },            
            validRange: function() {
                return {
                    start: '2021-03-17'
                };
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
            },
            
            eventDidMount: function(info) {
                $(info.el).tooltip({
                    title: info.event.title,
                    html: true,
                    container: 'body',
                    delay: { "show": 50, "hide": 50},
                });
            },
        });
        
        calendar.addEventSource(listHolidayDate);
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
        checkedNames: [0,1,2,3,4,5,6,8],
        marginTop: "30px;",
        classColLG12: (viewPC)? "col-lg-12" : "colLg12Mobile",
        classBodayRightContentGrid: (viewPC)? "bodayRightContentGrid" : ""
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
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
                                var imgDiv = '';
                                if ('{{@$item->ctvList[0]->male}}' == '1') {
                                    imgDiv = "<i class='fa fa-male' style='color:blue'></i>";
                                } else if ('{{@$item->ctvList[0]->male}}' == '2') {
                                    imgDiv = "<i class='fa fa-female' style='color:red'></i>";
                                }
                                
                                if ('{{$item->status}}' == '3') {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: '#008000',
                                            borderColor:'#008000'
                                        }
                                    );
                                } else if ('{{$item->status}}' == '4') {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: '#20B2AA',
                                            borderColor:'#20B2AA'
                                        }
                                    );
                                }  else if ('{{$item->status}}' == '5') {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: '#9400D3',
                                            borderColor:'#9400D3'
                                        }
                                    );
                                }   else if ('{{$item->status}}' == '8') {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: '#fe28a2',
                                            borderColor:'#fe28a2'
                                        }
                                    );
                                } else if ('{{$item->status}}' == '6') {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor:'grey',
                                            textColor:'#fff',
                                            borderColor:'grey'
                                        }
                                    );
                                } else if ('{{$item->status}}' == '7') {
                                    listDate.push(
                                        {
                                            title: '<s>受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase()+'</s>',
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: 'red',
                                            borderColor: 'red'
                                        }
                                    );
                                } else if ('{{$item->status}}' == '2') {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: '#00BFFF',
                                            borderColor:'#00BFFF'
                                        }
                                    );
                                } else {
                                    listDate.push(
                                        {
                                            title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                            extendedProps: {
                                                isResourceHtml: 'YES'
                                            },
                                            start: '{{$itemdateList}}',
                                            backgroundColor: '#CC7000',
                                            borderColor:'#CC7000'
                                        }
                                    );
                                }
                                    
                            
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
                        var imgDiv = '';
                        if ('{{@$item->ctvList[0]->male}}' == '1') {
                            imgDiv = "<i class='fa fa-male' style='color:blue'></i>";
                        } else if ('{{@$item->ctvList[0]->male}}' == '2') {
                            imgDiv = "<i class='fa fa-female' style='color:red'></i>";
                        }
                        if ('{{$item->status}}' == '3') {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: '#008000',
                                    borderColor:'#008000'
                                }
                            );
                        } else if ('{{$item->status}}' == '4') {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: '#20B2AA',
                                    borderColor:'#20B2AA'
                                }
                            );
                        }  else if ('{{$item->status}}' == '5') {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: '#9400D3',
                                    borderColor:'#9400D3'
                                }
                            );
                        }   else if ('{{$item->status}}' == '8') {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: '#fe28a2',
                                    borderColor:'#fe28a2'
                                }
                            );
                        } else if ('{{$item->status}}' == '6') {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                            url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor:'grey',
                                    textColor:'#fff',
                                    borderColor:'grey'
                                }
                            );
                        } else if ('{{$item->status}}' == '7') {
                            listDate.push(
                                {
                                    title: '<s>'+'受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase()+'</s>',
                                            url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: 'red',
                                    borderColor: 'red'
                                }
                            );
                        } else if ('{{$item->status}}' == '2') {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: '#00BFFF',
                                    borderColor:'#00BFFF'
                                }
                            );
                        } else {
                            listDate.push(
                                {
                                    title: '受注No.{{$item->id}}('+'{{@$item->ctvSalesList[0]->name}}'.toUpperCase()+')<br>{{$item->address_pd}} '+'<br>'+imgDiv+'{{@$item->ctvList[0]->name}}'.toUpperCase(),
                                    url: '/admin/projectview/{{$item->id}}',
                                    extendedProps: {
                                        isResourceHtml: 'YES'
                                    },
                                    start: '{{$itemdateList}}',
                                    backgroundColor: '#CC7000',
                                    borderColor:'#CC7000'
                                }
                            );
                        }
                    
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