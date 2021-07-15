@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件登録')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')

    <!-- content -->
    <div id="list-data">
        <div class="container page__container page-section">
            <form action="" method="POST" class="p-0 mx-auto form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-group ">
                                <label class="form-label">通訳日</label>
                                <input type="text" autocomplete="off" id="listDate" name="ngay_pd" class="form-control" required >
                            </div>
                            <div class="form-group countDateLabel">
                                <div id="txtCountDay">（日数: - ）</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">住所</label>
                                <div class="search-form" >
                                    <input type="text" name="address_pd"  class="form-control" required  v-model="address_pd" >
                                    <a :href="'https://www.google.co.jp/maps/place/' + address_pd" target="_blank" type="button" class="btn btn-warning" style="background:blue">Google<br>マップ</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">通訳料金</label> 
                                <div class="search-form">
                                    <input type="text" id="tienphiendich" class="form-control" >
                                    <input type="hidden" id="tienphiendichdata" name="tienphiendich" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">備考</label>
                                <textarea type="text" name="description" class="form-control textarea ckeditor col-lg-12" rows="10"></textarea>
                            </div>
                            <div class="form-group" style="text-align:right">
                                <a @click="onSubmit()" class="btn btn-primary btn-submit">登録</a>
                                <a class="btn btn-danger" href="/admin/project">キャンセル</a>
                            </div>
                        </div>
                    </div>
                </div>     
            </form>
        </div>
    </div>

    <!-- Footer -->
    @include('admin.component.footer')
</div>
@include('admin.component.left-bar')
@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>
<script type="text/javascript" src="{{ asset('lib_upload/ckeditor/ckeditor.js') }}"></script> 
<script type="text/javascript" src="{{ asset('lib_upload/ckfinder/ckfinder.js') }}"></script>  
<link href="{{ asset('lib_upload/jquery-ui/css/ui-lightness/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('lib_upload/jquery-ui/js/jquery-ui.js') }}"></script>
<script src="{{ asset('lib_upload/jquery.slug.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('lib_upload/jquery.datepick.css') }}"> 
<script type="text/javascript" src="{{ asset('lib_upload/jquery.plugin.js') }}"></script> 
<script type="text/javascript" src="{{ asset('lib_upload/jquery.datepick.js') }}"></script>

<script type="text/javascript">

jQuery(document).ready(function (){
    $("#tienphiendich").on("change", function() {
        var flagPrice = $('#tienphiendich').val();
        flagPrice = parseInt(flagPrice.replace('￥' , '').replace(',', '').replace('.',''));
        $('#tienphiendichdata').val(flagPrice);
        if (flagPrice) {
            $('#tienphiendichdata').val(flagPrice);
            flagPrice = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(flagPrice);
        } else {
            flagPrice = '';
            $('#tienphiendichdata').val(flagPrice);
        }
        $('#tienphiendich').val(flagPrice);
    });

    $('#listDate').change(function(event) {
        $cntDay = this.value.split(',').length;
        $('#txtCountDay').text("（日数: " + $cntDay + "）");
    });

    $('#listDate').datepick({ 
        multiSelect: 999, 
        minDate: 0,
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1,
        onSelect: function(dateText, inst) {
            $(this).change();
        }
    });

    CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
    jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
        jQuery(this).toggle();
    });

    $(window).keydown(function(event){
        if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3])) {
            event.preventDefault();
            return false;
        }
    });
});

</script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#list-data',
    data: {
        tienphiendich : '',
        address_pd: ''
    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            const that = this;
            setTimeout(function(){ $('.form-data').submit(); }, 1000);
        }
    },
});
</script>

@stop