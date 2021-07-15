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
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h1 class="h2 mb-0">Create Template Mails</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/mails">Template Mail</a></li>
                        <li class="breadcrumb-item active">Template Mails</li>
                    </ol>

                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Thông Tin Cơ Bản</div>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <form action="" method="POST" class="p-0 mx-auto">
                            @csrf
                            <div class="form-group">
                                @if ( @$message && @$message['status'] === 1 )
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <strong>{{ $message['message'] }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                </div>
                                @endif
                                @if ( @$message && @$message['status'] === 2 )
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <strong>{{ $message['message'] }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">Name:</label>
                                <input type="text" name="name" class="form-control" id="tenNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">From:</label>
                                <input type="text" name="from_mail" class="form-control" id="tenNganHang">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chiNhanhNganHang">To:</label>
                                <input type="text" name="to_mail" class="form-control" id="chiNhanhNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">CC:</label>
                                <input type="text" name="cc_mail" class="form-control" id="tenNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">Subject:</label>
                                <input type="text" name="subject" class="form-control" id="tenNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="soTaiKhoan">Body:</label>
                                <textarea type="text" name="body" class="form-control"  rows="10" ></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chuTaiKhoan">note:</label>
                                <textarea type="text" name="note" class="form-control" rows="10" ></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Gửi</button>
                        </form>
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

<script type="text/javascript">
    //<![CDATA[

    jQuery(document).ready(function (){
        

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

    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {},
});
</script>

@stop