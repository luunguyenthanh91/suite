@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '労働者名簿更新')

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
                                                    {{@$data->employee_code}}
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td>{{ trans('label.name') }}</td>
                                                <td>
                                                (( parseName('{{@$data->employee_name}}') ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.furigana') }}</td>
                                                <td>
                                                (( parseName('{{@$data->employee_nick_name}}') ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.sex') }}</td>
                                                <td>
                                                @if ( @$data->male == 1 )
                                                    <span>{{ trans('label.male') }}</span>
                                                @endif
                                                @if ( @$data->male == 2 )
                                                    <span>{{ trans('label.female') }}</span>
                                                @endif
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.birthday') }}</td>
                                                <td>
                                                {{@$data->employee_birthday}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.address') }}</td>
                                                <td>
                                                {{@$data->address}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.employ_date') }}</td>
                                                <td>
                                                {{@$data->employ_date}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.employee_depname') }}</td>
                                                <td>
                                                (( parseName('{{@$data->employee_depname}}') ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.inside_history') }}</td>
                                                <td>
                                                <textarea type="text" name="inside_history" class="form-control" rows="5">{{@$data->inside_history}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.retire_date') }}</td>
                                                <td>
                                                <input type="date" name="retire_date" value="{{$data->retire_date}}" class="form-control">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.retire_note') }}</td>
                                                <td>
                                                <textarea type="text" name="retire_note" class="form-control" rows="10">{{@$data->retire_note}}</textarea>
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
    var imgId;

    function chooseImage(id) {
        imgId = id;
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileField;
        finder.popup();
    }
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileField(fileUrl) {
        document.getElementById('chooseImage_img' + imgId).src = fileUrl;
        document.getElementById('chooseImage_input' + imgId).value = fileUrl;
        document.getElementById('chooseImage_div' + imgId).style.display = '';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = 'none';
    }

    function clearImage(imgId) {
        document.getElementById('chooseImage_img' + imgId).src = '';
        document.getElementById('chooseImage_input' + imgId).value = '';
        document.getElementById('chooseImage_div' + imgId).style.display = 'none';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = '';
    }


    function chooseFile(event)
    {   
        id= event.rel;
        imgId = id;
        console.log('chooseImage_input' + imgId);
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileFieldFile;
        finder.popup();
    } 
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileFieldFile( fileUrl )
    {
        document.getElementById( 'chooseImage_input' + imgId).value = fileUrl;
        $("#chooseImage_input"+ imgId).val(fileUrl)[0].dispatchEvent(new Event('input'));

    }
    function clearFile(event)
    {
        imgId= event.rel;
        document.getElementById( 'chooseImage_input' + imgId ).value = '';
        $("#chooseImage_input"+ imgId).val('')[0].dispatchEvent(new Event('input'));
    }


    function addMoreImg()
    {
        jQuery("ul#images > li.hidden").filter(":first").removeClass('hidden');
    }

//]]>
</script>

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
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            setTimeout(function(){ $('.form-data').submit(); }, 1000);
        },
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        parseMoney (value) {
            value = (isNaN(value)) ? 0 : value;
            const formatter = new Intl.NumberFormat('ja-JP', {
                style: 'currency',
                currency: 'JPY',currencyDisplay: 'name'
            });
            return formatter.format(value);
        },
        parseName (value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parseMonth (value) {
            return this.isNull(value)? S_HYPEN : 
            value.replace("-", " 年 ")+" 月度";
        },
        parseAddr(value) {
            return this.isNull(value)? S_HYPEN : value;
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
    },
});
</script>

@stop
