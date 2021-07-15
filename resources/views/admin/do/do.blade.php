@extends('admin.layouts.main')

@section('parentPageTitle', 'Admin')
@section('title', 'Đồ')


@section('content')
<div class="main-content-inner" id="list-data">


    <div class="page-content">
        <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
            <h3>
                <span class="hidden-320 ng-binding">Đồ</span>
            </h3>

            <div class="toolbar">
                <button class="btn btn-success btn-primary" type="button" @click="toggleAdd">
                    <i class="icon-plus white"></i>
                    <span class="hidden-480">Thêm</span>
                </button>
            </div>
        </div>


        <div class="page-content" >
            <div class="row ">
                <div class="search-box">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-6 no-padding-left">
                            <div class="input-group">

                                <input type="text" placeholder="Nhập Tên Cần Tìm" v-on:keyup.enter="onSearch" class="width-100" v-model="conditionName" >
                                <span class="input-group-btn">
                                    <!-- <select  class="form-control hidden-768 ng-scope ng-pristine ng-valid"
                                        style="margin-left: 5px; width: 145px;">
                                        <option value="0" selected="selected">Đơn hàng</option>
                                        <option value="1">Đơn hàng đã xóa</option>
                                        <option value="2">Đơn hàng còn nợ</option>
                                        <option value="3">Đơn xuất trả NCC</option>
                                    </select> -->
                                    <button class="btn btn-primary" type="button" @click="onSearch" style="margin-left: 5px; z-index: 10;" title="Tìm kiếm">
                                        <i class="icon-search icon-on-right bigger-110"></i>
                                        <span class="hidden-1200"> Tìm kiếm</span>
                                    </button>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12 relative">
                            <div class="loadding-table" v-if="loadingTable == 1">
                                <img src="{{ asset('assets/img/loading.gif') }}" />
                            </div>
                            <table id="simple-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="center"></th>
                                        <th>Hình Ảnh</th>
                                        <th>Tên</th>
                                        <th>Nội Dung</th>
                                        <th>Giá</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="item in list">
                                        <td class="center">((item.id))</td>
                                        <td class="center">
                                            <img src="{{ asset('templates/images/cafe.png') }}" v-if="!item.image && item.edit == 1" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="rounded-circle w35">
                                            <img v-bind:src="((item.image))" v-if="item.image && item.edit == 1" data-toggle="tooltip" data-placement="top" title="Avatar Name" alt="Avatar" class="rounded-circle w35">
                                            <div v-if="item.edit == 2" class="input-group">
                                                <ul id="images">
                                                    <li>   
                                                        <input class="input_image" type="hidden" v-bind:id="'chooseImage_input'+item.id+''" v-model="item.image" >
                                                        <div v-bind:id="'chooseImage_div'+item.id+''" v-bind:style="item.image != null ? '' : 'display: none;'" >
                                                            <img v-bind:src="item.image" v-bind:id="'chooseImage_img'+item.id+''" style="max-width: 150px; max-height:150px; border:dashed thin;"></img>
                                                        </div>
                                                        <div v-bind:id="'chooseImage_noImage_div'+item.id+''" v-bind:style="item.image == null ? '' : 'display: none;'" style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                                            No image
                                                        </div>
                                                        <br/>
                                                        <a onclick="chooseImage(this)"  v-bind:rel="item.id">Choose image</a>
                                                        | 
                                                        <a onclick="clearImage(this)" v-bind:rel="item.id">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        
                                        </td>
                                        <td>
                                            <p v-if="item.edit == 1" >((item.name))</p>
                                            <input type="text" v-if="item.edit == 2" placeholder="Tên" class="col-xs-12 col-sm-12" v-model="item.name">
                                        </td>
                                       
                                        <td>
                                            <p v-if="item.edit == 1" >((item.description))</p>
                                            <textarea v-if="item.edit == 2" v-model="item.description" class="autosize-transition form-control"></textarea>
                                        </td>
                                        <td>
                                            <p v-if="item.edit == 1" >((item.cost))</p>
                                            <input type="text" v-if="item.edit == 2" placeholder="Giá" class="col-xs-12 col-sm-12" v-model="item.cost">
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs btn-group">
                                                <button class="btn btn-xs btn-success" @click="confirmEditData(item)" v-if="item.edit == 2">
                                                    <i class="ace-icon fa fa-check bigger-120"></i>
                                                </button>
                                                <button class="btn btn-xs btn-danger" @click="cancleEditRecore(item)" v-if="item.edit == 2">
                                                    <i class="ace-icon fa fa-undo  bigger-120"></i>
                                                </button>

                                                <button class="btn btn-xs btn-info" @click="editRecore(item)" v-if="item.edit == 1">
                                                    <i class="ace-icon fa fa-pencil bigger-120"></i>
                                                </button>

                                                <button class="btn btn-xs btn-danger" @click="deleteRecore(item)" v-if="item.edit == 1">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </button>

                                                <button class="btn btn-xs btn-warning" @click="togglePermission(item)" v-if="item.edit == 1">
                                                    <i class="ace-icon fa fa-list bigger-120"></i>
                                                    Ghép Đồ
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div><!-- /.span -->
                    </div><!-- /.row -->

                    <div class="hr hr-18 dotted hr-double"></div>
                    <div class="row" v-if="count > 1">
                        <div class="col-xs-12">
                            <div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button previous" v-bind:class="page <= 1 ? 'hidden' : ''"
                                        aria-controls="dynamic-table" tabindex="0" @click="onPrePage()">
                                        <a>Previous</a>
                                    </li>

                                    <li class="paginate_button" v-for="item in listPage" @click="onPageChange(item)"
                                        v-bind:class="page == item ? 'active' : ''">
                                        <a>((item))</a>
                                    </li>

                                    <li @click="onNextPage()" class="paginate_button next"
                                        v-bind:class="page > count - 1 ? 'hidden' : ''">
                                        <a>Next</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div><!-- /.col -->
                
                <!-- modal Custom -->
                <div class="modal-container" v-if="addModal == 2">
                    <div class="container-popup  col-xs-4">
                        <div class="breadcrumbs">
                            <h3>
                                <span class="hidden-320 ng-binding">Thêm Phép</span>
                            </h3>

                            <div class="toolbar">
                                <button class="btn btn-primary btn-primary" @click="confirmAddData" type="button" >
                                    <i class="icon-check white"></i>
                                    <span class="hidden-480">Lưu Lại</span>
                                </button>
                                <button @click="toggleAdd" type="button" class="btn btn-danger btn-primary">
                                    <i class="icon-undo white"></i>
                                    <span class="hidden-480">Hủy</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-horizontal col-xs-12 mt-10">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" > Hình Ảnh </label>
                                <div class="col-sm-10">
                                    <ul id="images">
                                        <li>   
                                            <input class="input_image" type="hidden" id="chooseImage_inputnew" v-model="avatarAddData">
                                            <div id="chooseImage_divnew" style="display: none;">
                                                <img src="" id="chooseImage_imgnew" style="max-width: 150px; max-height:150px; border:dashed thin;"></img>
                                            </div>
                                            <div id="chooseImage_noImage_divnew" style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                                No image
                                            </div>
                                            <br/>
                                            <a onclick="chooseImage(this)"  rel="new">Choose image</a>
                                            | 
                                            <a onclick="clearImage(this)" rel="new">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" > Tên Đồ </label>
                                <div class="col-sm-10">
                                    <input type="text" placeholder="Tên Phép" v-model="nameAddData" class="col-xs-12 col-sm-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" > Nội Dung </label>
                                <div class="col-sm-10">
                                    <textarea v-model="desAddData" class="autosize-transition form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" > Giá </label>
                                <div class="col-sm-10">
                                    <input type="number" v-model="costAddData" placeholder="Giá" v-model="nameAddData" class="col-xs-12 col-sm-12">
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>


                <div class="modal-container" v-if="permission == 2">
                    <div class="container-popup col-xs-4">
                        <div class="breadcrumbs">
                            <h3>
                                <span class="hidden-320 ng-binding">((setPeri.name))</span>
                            </h3>

                            <div class="toolbar">
                                <button class="btn btn-primary btn-primary" @click="confirmPermission" type="button" >
                                    <i class="icon-check white"></i>
                                    <span class="hidden-480">Lưu Lại</span>
                                </button>
                                <button @click="disablePermission" type="button" class="btn btn-danger btn-primary">
                                    <i class="icon-undo white"></i>
                                    <span class="hidden-480">Hủy</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-horizontal col-xs-12 mt-10">
                            <div v-for="e in listPermission" class="col-xs-4 relative">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" v-model="e.checked" class="ace" true-value="1" false-value="0">
                                        <span class="lbl"> ((e.name))</span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->


    </div>
</div>

@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Sweet Alerts js -->
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sweet alert init js-->
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

<script type="text/javascript" src="{{ asset('lib_upload/ckeditor/ckeditor.js') }}"></script> 
<script type="text/javascript" src="{{ asset('lib_upload/ckfinder/ckfinder.js') }}"></script>  
<link href="{{ asset('lib_upload/jquery-ui/css/ui-lightness/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('lib_upload/jquery-ui/js/jquery-ui.js') }}"></script>
<script src="{{ asset('lib_upload/jquery.slug.js') }}"></script>


<script type="text/javascript">
    //<![CDATA[

    jQuery(document).ready(function (){
        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        // jQuery( "#images" ).sortable();
        // jQuery( "#images" ).disableSelection();
        //Display images
        jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
            jQuery(this).toggle();
        });
        
            
    });
    var imgId;
    function chooseImage(event)
    {   
        id= event.rel;
        imgId = id;
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileField;
        finder.popup();
    } 
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileField( fileUrl )
    {
        document.getElementById( 'chooseImage_img' + imgId ).src = fileUrl;
        // document.getElementById( 'chooseImage_input' + imgId).value = fileUrl;
        document.getElementById( 'chooseImage_div' + imgId).style.display = '';
        document.getElementById( 'chooseImage_noImage_div' + imgId ).style.display = 'none';
        $("#chooseImage_input"+ imgId).val(fileUrl)[0].dispatchEvent(new Event('input'));

    }
    function clearImage(event)
    {
        imgId= event.rel;
        document.getElementById( 'chooseImage_img' + imgId ).src = '';
        document.getElementById( 'chooseImage_input' + imgId ).value = '';
        document.getElementById( 'chooseImage_div' + imgId).style.display = 'none';
        document.getElementById( 'chooseImage_noImage_div' + imgId).style.display = '';
        $("#chooseImage_input"+ imgId).val('')[0].dispatchEvent(new Event('input'));
    }

    function addMoreImg()
    {
        jQuery("ul#images > li.hidden").filter(":first").removeClass('hidden');
    }

//]]>
</script>
<style type="text/css">
    #images { list-style-type: none; margin: 0; padding: 0;}
    #images li { margin: 10px; float: left; text-align: center;  height: 190px;}
</style>




<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        listPage: [],
        conditionName: '',
        addModal : 1,
        nameAddData : '',
        avatarAddData : '',
        desAddData : '',
        permission : 1,
        costAddData : 0,
        listPermission : [],
        groups : []
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
    },
    methods: {
        toggleAdd() {
            this.addModal = this.addModal == 1 ? 2 : 1;
        },
        confirmPermission(){
            const that = this;
            that.permission = 1;
            Swal.fire({
                title: "Xác Nhận",
                text: "Bạn có đồng ý sửa đổi quyền không?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!",
                cancelButtonText: "Không!",
                allowOutsideClick: false,
                allowEscapeKey : false
            }).then(function(t) {
                if(t.dismiss == "cancel"){
                        that.permission = 2;
                        return;
                }
                var body = { 
                    _token: CSRF_TOKEN ,
                    id : that.setPeri.id,
                    data : that.listPermission,
                };
                $.ajax({
                    type: 'POST',
                    url: '/admin/do/update-permission-role/'+that.setPeri.id,
                    data: body,
                    success: function(data){
                        that.setPeri = '';
                        that.permission = 1;
                        that.listPermission = [];
                        Swal.fire({
                            title: "Thay đổi thành công!"
                        });
                    },
                    error: function(xhr, textStatus, error){
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",

                        });
                        that.permission = 2;
                    }
                });
                
            });
        },
        toggleTree(e){
            e.edit = e.edit == 0 ? 1 : 0;
        },
        disablePermission(){
            this.permission = 1;
        },
        togglePermission(_i) {
            const that = this;
            that.setPeri = _i;
            this.permission = this.permission == 1 ? 2 : 1;
            $.ajax({
                type: 'GET',
                url: "/admin/do/check-permission-role/"+ _i.id,
                success: function(data){
                    that.listPermission = data.data;
                },
                error: function(xhr, textStatus, error){
                    Swal.fire({
                        title: "Có lỗi dữ liệu!",
                        type: "warning",

                    });
                }
            });
        },
        confirmAddData() {
            const that = this;
            this.addModal = 1;
            Swal.fire({
                title: "Xác Nhận",
                text: "Bạn có đồng ý thêm giá trị này không?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!",
                cancelButtonText: "Không!",
                allowOutsideClick: false,
                allowEscapeKey : false
            }).then(function(t) {
                if(t.dismiss == "cancel"){
                        
                    that.addModal = 2;
                    return;
                }
                this.loadingTable = 1;
                var body = { 
                    _token: CSRF_TOKEN ,
                    name : that.nameAddData,
                    image : that.avatarAddData,
                    description : that.desAddData,
                    cost : that.costAddData
                };
                $.ajax({
                    type: 'POST',
                    url: '/admin/do/add',
                    data: body,
                    success: function(data){
                        that.loadingTable = 0;
                        that.nameAddData = '';
                        that.avatarAddData = '';
                        that.desAddData = '';
                        that.costAddData = '';
                        that.onLoadPagination();
                        Swal.fire({
                            title: "Thay đổi thành công!"
                        });
                    },
                    error: function(xhr, textStatus, error){
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",

                        });
                    }
                });
                
            });
        },
        editRecore(_i) {
            _i.edit = 2;
        },
        confirmEditData(_i) {
            const that = this;
            Swal.fire({
                title: "Xác Nhận",
                text: "Bạn có đồng ý thay đổi giá trị này không?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!",
                cancelButtonText: "Không!",
                allowOutsideClick: false,
                allowEscapeKey : false
            }).then(function(t) {
                if(t.dismiss == "cancel"){
                      return;
                }
                that.loadingTable = 1;
                var body = { 
                    _token: CSRF_TOKEN ,
                    id : _i.id,
                    name : _i.name,
                    image : _i.image,
                    description : _i.description,
                    cost : _i.cost
                };
                $.ajax({
                    type: 'POST',
                    url: '/admin/do/edit/'+_i.id,
                    data: body,
                    success: function(data){
                        _i.edit = 1;
                        that.loadingTable = 0;
                        that.onLoadPagination();
                        Swal.fire({
                            title: "Thay đổi thành công!"
                        });
                    },
                    error: function(xhr, textStatus, error){
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",

                        });
                    }
                });
                
            });
        },
        cancleEditRecore(_i) {
            _i.edit = 1;
        },
        deleteRecore(_i) {
            const that = this;
            Swal.fire({
                title: "Xác Nhận",
                text: "Bạn có đồng ý xóa giá trị này không?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có!",
                cancelButtonText: "Không!",
                allowOutsideClick: false,
                allowEscapeKey : false
            }).then(function(t) {
                if(t.dismiss == "cancel"){
                      return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/do/delete/"+_i.id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        that.loadingTable = 0;
                        that.onLoadPagination();
                    },
                    error: function(xhr, textStatus, error){
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",

                        });
                    }
                });

            })
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getDo')}}?page=" + this.page + "&name=" + this.conditionName,
                success: function(data){
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
                error: function(xhr, textStatus, error){
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onPrePage() {
            if (this.page > 1) {
                this.page = this.page - 1;
            }
            this.onLoadPagination();
        },
        onNextPage() {
            if (this.page < this.count) {
                this.page = this.page + 1;
            }
            this.onLoadPagination();
        }
    },
});
</script>
@stop