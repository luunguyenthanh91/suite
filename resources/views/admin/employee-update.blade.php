@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '社員情報更新')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')

    <!-- content -->
    <div id="list-data">
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="onSubmit()">
                <i class="fas fa-save"><span class="labelButton">{{ trans('label.save') }}</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:red" href="/admin/employee-view/{{$id}}">
                <i class="fas fa-window-close"><span class="labelButton">{{ trans('label.cancel') }}</span></i>
            </a>
        </div>

        <div class="container page__container page-section page_container_custom">
            <form action="" method="POST" class="p-0 mx-auto form-data" >
                @csrf
                <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                        <div class="card-header p-0 nav">
                            <div class="row no-gutters" role="tablist">
                                <div class="col-auto">
                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click active" id="tab1">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.property') }}</strong>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane active" id="detailtab1">
                                <div class="row">                                                
                                    <div class="col-lg-12">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">
                                            <tr>
                                                <td>{{ trans('label.user_id') }}</td>
                                                <td>
                                                <input type="text" name="code" value="{{$data->id}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.name') }}</td>
                                                <td>
                                                <input type="text" name="name" value="{{$data->name}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.furigana') }}</td>
                                                <td>
                                                <input type="text" name="nickname" value="{{$data->nickname}}" class="form-control">
                                                </td>
                                            </tr> 
                                            
                                            <tr>
                                                <td>{{ trans('label.sex') }}</td>
                                                <td>
                                                    <div class="custom-controls-stacked">
                                                    <div class="custom-control custom-radio">
                                                        <input id="radiomale1" name="male" type="radio" class="custom-control-input" @if(1==@$data->male) checked @endif value="1">
                                                        <label for="radiomale1" class="custom-control-label">{{ trans('label.male') }}</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input id="radiomale2" name="male" type="radio" class="custom-control-input" @if(2==@$data->male) checked @endif value="2">
                                                        <label for="radiomale2" class="custom-control-label">{{ trans('label.female') }}</label>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.birthday') }}</td>
                                                <td>
                                                <input type="date" name="birthday" value="{{$data->birthday}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.email') }}</td>
                                                <td>
                                                <input type="text" name="email" value="{{$data->phone}}" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tel') }}</td>
                                                <td>
                                                <input type="text" name="phone" value="{{$data->phone}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.address') }}</td>
                                                <td>
                                                <input type="text" name="address" value="{{$data->address}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.employ_date') }}</td>
                                                <td>
                                                <input type="date" name="employ_date" value="{{$data->employ_date}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.note') }}</td>
                                                <td>
                                                <textarea type="text" name="note" class="form-control" rows="10">{{@$data->note}}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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



<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
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
            $('#txtCountDayPo').text($cntDay);
        });
    });
//]]>
</script>
<style type="text/css">
    #images { list-style-type: none; margin: 0; padding: 0;}
    #images li { margin: 10px; float: left; text-align: center;  height: 190px;}
    .modal-backdrop {
        display: none !important;
    }
</style>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

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
