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
                    <h1 class="h2 mb-0">Create My Bank Account</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/my-bank">Bank Account</a></li>
                        <li class="breadcrumb-item active">New Bank Account</li>
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
                                <label class="form-label" for="tenNganHang">Ngân Hàng:</label>
                                <input type="text" name="name_bank" class="form-control" id="tenNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">Mã Số Ngân Hàng:</label>
                                <input type="text" name="ms_nganhang" class="form-control" id="tenNganHang">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chiNhanhNganHang">Chi Nhánh Ngân Hàng:</label>
                                <input type="text" name="chi_nhanh" class="form-control" id="chiNhanhNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">Mã Số Chi Nhánh Ngân Hàng:</label>
                                <input type="text" name="ms_chinhanh" class="form-control" id="tenNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">Loại Tài Khoản:</label>
                                <input type="text" name="type" class="form-control" id="tenNganHang" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="soTaiKhoan">Số Tài Khoản:</label>
                                <input type="text" name="stk" class="form-control" id="soTaiKhoan" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chuTaiKhoan">Tên Chủ Tài Khoản:</label>
                                <input type="text" name="ten_chusohuu" class="form-control" id="chuTaiKhoan" >
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