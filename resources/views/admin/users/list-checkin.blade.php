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
                    <h1 class="h2 mb-0">List Check In / Check Out</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">List Check In / Check Out</li>
                    </ol>

                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">Tên Nhân Viên</label>
                        <input type="text" class="form-control search" @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="conditionName">
                            
                    </div>

                    <div class="form-group" >
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="1">Vào Làm</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="2">Ra Về</label>
                            </div>
                    </div>
                </div>
                <div class="col-lg-8 d-flex">

                    <div class="flex" style="max-width: 100%">

                        <div class="card m-0">

                            <div class="table-responsive">
                                <table class="table mb-0 thead-border-top-0 table-nowrap">
                                    <thead >
                                        <th>
                                            <p class="mb-2">
                                               No.
                                            </p>
                                        </th>
                                        <th>
                                            <p class="mb-2">
                                               Tên Nhân Viên
                                            </p>
                                        </th>
                                        
                                        <th>
                                            <p class="mb-2">
                                               Giờ Check
                                            </p>
                                        </th>
                                        <th>
                                            <p class="mb-2">
                                               Ngày
                                            </p>
                                        </th>
                                        <th>
                                            <p class="mb-2">
                                               Kiểu
                                            </p>
                                        </th>
                                    </thead>
                                    <tbody class="list" id="search">
                                        <tr v-for="(item, index) in list">
                                            <td>
                                                <p class="mb-2">
                                                    ((item.id))
                                                </p>

                                            </td>
                                            <td>
                                                <p class="mb-2">
                                                    ((item.user_profile.name))<br/>
                                                    ((item.user_profile.email))<br/>
                                                    ((item.user_profile.phone))
                                                </p>

                                            </td>
                                            <td>
                                                <p class="mb-2">
                                                    ((item.time))
                                                </p>

                                            </td>
                                            <td>
                                                <p class="mb-2">
                                                    ((item.date))
                                                </p>

                                            </td>
                                            <td>
                                            ((item.type == 1 ? 'Vào' : 'Ra'))
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer p-8pt">

                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                    <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''"
                                        @click="onPrePage()">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                            <span>Prev</span>
                                        </a>
                                    </li>

                                    <li class="page-item disabled" v-if="page > 3 ">
                                        <a class="page-link" href="#">
                                            <span>...</span>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="item in listPage"
                                        v-if="page > (item - 3) && page < (item + 3) " @click="onPageChange(item)"
                                        v-bind:class="page == item ? 'active' : ''">
                                        <a class="page-link" href="#" aria-label="Page 1">
                                            <span>((item))</span>
                                        </a>
                                    </li>
                                   

                                    <li class="page-item" @click="onNextPage()"
                                        v-bind:class="page > count - 1 ? 'disabled' : ''">
                                        <a class="page-link" href="#">
                                            <span>Next</span>
                                            <span aria-hidden="true" class="material-icons">chevron_right</span>
                                        </a>
                                    </li>
                                </ul>

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


<script type="text/javascript">
$( document ).ready(function() {
    $('.upload-file').on('click', function(){
        $('#fileToUpload').click();
    });
    $('#fileToUpload').on('change', function(){ 
        //setTimeout(function(){
            //window.location.reload();
        //}, 3000);
        $('#formUpload').submit();    
    });
});

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
        addModal: 1,
        nameAddData: '',
        conditionType : '',
        guardAddData: '',
        groupAddData: '',
        checkedNames: [1,2],
        groups: []
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
    },
    methods: {
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        removeHistory(_i) {
            const that = this;
            Swal.fire({
                title: "Confirm",
                text: "Do you agree to delete this value?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/customer/deleteFile/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Delete success!"
                        });
                        that.loadingTable = 0;
                        that.onLoadPagination();
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "There was an error in the input data!",
                            type: "warning",

                        });
                    }
                });

            })
        },
        deleteRecore(_i) {
            const that = this;
            Swal.fire({
                title: "Confirm",
                text: "Do you agree to delete this value??",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/user/delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Delete Success!"
                        });
                        that.loadingTable = 0;
                        that.onLoadPagination();
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "There is an error in the input data!",
                            type: "warning",

                        });
                    }
                });

            })
        },
        someHandlerChange: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&type=' + this.checkedNames.join();
            }

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListCheckIn')}}?page=" + this.page + conditionSearch,
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
                        title: "There is an error in the input data!",
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