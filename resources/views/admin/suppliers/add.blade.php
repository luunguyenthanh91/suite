@extends('admin.layouts.main')

@section('parentPageTitle', 'Admin')
@section('title', 'Nhà Phân Phối')


@section('content')
<div class="main-content-inner" id="list-data">


    <div class="page-content">
        <form method="post" action="">
            @csrf
            <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
                <h3>
                    <span class="hidden-320 ng-binding">Thêm Nhà Phân Phối</span>
                </h3>
                <div class="toolbar">
                    <button class="btn btn-success btn-primary" type="submit">
                        <i class="icon-plus white"></i>
                        <span class="hidden-480">Thêm</span>
                    </button>
                </div>
            </div>


            <div class="page-content">
                <div class="row ">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row clearfix">
                            @if ( @$message['status'] == 1 )
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>{{  $message['message'] }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif
                            @if ( @$message['status'] === 2 )
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>{{  $message['message'] }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active">
                                        <a data-toggle="tab" href="#home">
                                            <i class="green ace-icon fa fa-home bigger-120"></i>
                                            Thông Tin Cơ Bản
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#messages">
                                            <i class="green ace-icon fa fa-lemon-o bigger-120"></i>
                                            Kiểu Sản Phẩm
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active row clearfix">
                                        <div class="col-lg-6 col-md-12 relative">
                                            <div class="form-group c_form_group ">
                                                <label>Họ Tên</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Họ Và Tên"
                                                        aria-label="Họ Và Tên" name="name" value="{{@old('name')}}"
                                                        aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group ">
                                                <label>Nick Name</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Nick Name"
                                                        aria-label="Nick Name" name="nick_name"
                                                        value="{{@old('nick_name')}}" aria-describedby="basic-addon1"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group ">
                                                <label>Số Điện Thoại</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Số Điện Thoại"
                                                        name="phone" value="{{@old('phone')}}"
                                                        aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group ">
                                                <label>Địa Chỉ</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Địa Chỉ"
                                                        name="address" value="{{@old('address')}}"
                                                        aria-describedby="basic-addon1" required>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group">
                                                <label>Tỉnh</label>
                                                <div class="input-group">
                                                    <select class="custom-select" name="province_id" v-model="province"
                                                        @change="getDistricts()">
                                                        <option value="">Chọn Tỉnh Thành</option>
                                                        @foreach($listProvinces as $item)
                                                        <option value="{{$item->id}}" @if($item->id ==
                                                            @old('province_id')) selected
                                                            @endif>{{$item->province}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group">
                                                <label>Quận</label>
                                                <div class="input-group">
                                                    <select class="custom-select" name="district_id" v-model="district"
                                                        @change="getWards()">
                                                        <option value="">Chọn Quận</option>
                                                        <option v-for="item in district_list" v-bind:value="item.id">
                                                            ((item.district))</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group">
                                                <label>Phường</label>
                                                <div class="input-group">
                                                    <select class="custom-select" name="ward_id" v-model="ward">
                                                        <option value="">Chọn Phường</option>
                                                        <option v-for="item in ward_list" v-bind:value="item.id">
                                                            ((item.ward))
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-12 relative">
                                            
                                            <div class="form-group c_form_group ">
                                                <label>Ghi Chú</label>
                                                <div class="input-group">
                                                    <textarea name="note" class="form-control"
                                                        placeholder="Ghi Chú">{{@old('note')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group">
                                                <label>Trạng Thái</label>
                                                <div class="input-group">
                                                    <select class="custom-select" name="is_active">
                                                        <option value="1" @if(@old('is_active')==1) selected="selected"
                                                            @endif>Mở
                                                        </option>
                                                        <option value="0" @if(@old('is_active')==0) selected="selected"
                                                            @endif>Khóa
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group c_form_group">
                                                <label>Công Nợ</label>
                                                <div class="input-group">
                                                    <select class="custom-select" name="is_debt">
                                                        <option value="1" @if(@old('is_debt')==1) selected="selected"
                                                            @endif>Công Nợ
                                                        </option>
                                                        <option value="0" @if(@old('is_debt')==0) selected="selected"
                                                            @endif>Thanh Toán Ngay
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group c_form_group ">
                                                <label>Tiền Nhập Vào</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control"
                                                        placeholder="Tiền Nhập Vào" name="import_money"
                                                        value="{{@old('import_money')}}"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                            </div>

                                            <div class="form-group c_form_group ">
                                                <label>Đã Thanh Toán</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control"
                                                        placeholder="Đã Thanh Toán" name="paid_money"
                                                        value="{{@old('paid_money')}}" aria-describedby="basic-addon1">
                                                </div>
                                            </div>

                                            <div class="form-group c_form_group ">
                                                <label>Tiền Nợ</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" placeholder="Tiền Nợ"
                                                        name="debt_money" value="{{@old('debt_money')}}"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div id="messages" class="tab-pane fade row clearfix">

                                        @foreach($listProductTypes as $item)
                                        <div class="col-lg-2 col-md-6 relative">
                                            <div class="checkbox">
                                                <label>
                                                    <input name="type[{{$item->id}}]" @if(@old('type.'.$item->id) == 1) checked @endif type="checkbox" class="ace"
                                                        value="1" />
                                                    <span class="lbl"> {{$item->type}}</span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach



                                    </div>

                                </div>
                            </div>



                        </div>


                    </div><!-- /.col -->

                </div>
            </div><!-- /.row -->
        </form>


    </div>
</div>

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
        province: '{{@old("province_id")}}',
        district: '{{@old("district_id")}}',
        ward: '{{@old("ward_id")}}',
        district_list: [],
        ward_list: []
    },
    delimiters: ["((", "))"],
    mounted() {
        // this.onLoadPagination();
        if (this.province != '') {
            this.getDistricts();
            this.district = '{{@old("district_id")}}';
        }
        if (this.district != '') {
            this.getWards();
            this.ward = '{{@old("ward_id")}}';
        }
    },
    methods: {
        getWards() {
            const that = this;
            let id_ward = that.district;

            if (id_ward != '') {
                that.ward_list = [];
                that.ward = '';
                $.get("/admin/ward/list-by-district/" + id_ward).then(function(data, status) {
                    that.ward_list = data.data;
                });
            } else {
                that.ward_list = [];
                that.ward = '';
            }

        },
        getDistricts() {
            const that = this;
            let id_province = that.province;

            if (id_province != '') {
                that.ward_list = [];
                that.district_list = [];
                that.district = '';
                that.ward = '';
                $.get("/admin/district/list-by-province/" + id_province).then(function(data, status) {
                    that.district_list = data.data;
                });
            } else {
                that.ward_list = [];
                that.district_list = [];
                that.district = '';
                that.ward = '';
            }

        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getSuppliers')}}?page=" + this.page + "&name=" + this
                    .conditionName,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                    } else {
                        that.count = 0;
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
    },
});
</script>
@stop