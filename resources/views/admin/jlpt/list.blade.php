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
                    <h1 class="h2 mb-0">Danh Sách Bài Học</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">問題マスター</li>
                    </ol>

                </div>
            </div>

            <div class="row" role="tablist">
                <div class="col-auto">
                    <a href="/admin/jlpt/add" class="btn btn-outline-secondary">Thêm Bài Học</a>
                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    
                    <div class="form-group">
                        <label class="form-label m-0">日本語能力試験（JLPT）の資格</label>
                        <select class="form-control search" v-model="jplt" @change="onSearch()">
                            <option value=""></option>
                            <option value="1">N1</option>
                            <option value="2">N2</option>
                            <option value="3">N3</option>
                            <option value="4">N4</option>
                            <option value="5">N5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary col-lg-12" type="button" @click="onSearch()">絞り込み</button>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-danger col-lg-12" type="button" @click="clearSearch()">クリア</button>
                    </div>

                    

                </div>


                <div class="col-lg-8 ">
                    <div class="flex mb-32pt" style="max-width: 100%">

                        <div class="card m-0">

                            <div class="table-responsive">

                                <table class="table mb-0 thead-border-top-0 table-nowrap">
                                    <tbody class="list " id="search">
                                        <tr v-for="item in list">
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div style="display: flex; justify-content: flex-start; align-items: center;">
                                                        <a  style="display: flex; justify-content: center; align-items: center; float: left;" :href="'/admin/jlpt/edit/' + item.id" >
                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                    ((item.name)) - ((item.number)) - (( getJlpt(item.type_n) ))
                                                            </strong>
                                                            </p>
                                                        </a>
                                                        <a @click="deleteRecore(item.id)"  class="btn btn-danger">削除</a>
                                                    </div>
                                                </div>
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
        <div id="error-details" style="display:none">
            <span id="copyName"></span><br>
            <span id="copyFurigana"></span><br>
            <span id="copyPhone"></span><br>
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
<link href="{{ asset('assets/charts/jquery.jqplot.min.css') }}" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="{{ asset('assets/charts/shCoreDefault.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ asset('assets/charts/shThemejqPlot.min.css') }}" />
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jquery.jqplot.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/charts/shCore.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/charts/shBrushJScript.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/charts/shBrushXml.min.js') }}"></script>
<!-- Additional plugins go here -->

<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.barRenderer.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.pieRenderer.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.categoryAxisRenderer.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('assets/charts/jqplot.pointLabels.min.js') }}"></script>
<script language="javascript" type="text/javascript" src="{{ asset('assets/charts/jqplot.canvasOverlay.min.js') }}"></script>


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
        conditionAddress: '',
        conditionPhone: '',
        lever_nihongo: '',
        jplt: '',
        male: '',
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        conditionLocation: '',
        status_ctv: '1',
        district: '',
        groups: [],
        itemCopy : {}
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
        getJlpt(idGet) {
            if (idGet == 1) {
                return "N1"
            } else if (idGet == 2) {
                return "N2"
            } else if (idGet == 3) {
                return "N3"
            } else if (idGet == 4) {
                return "N4"
            } else if (idGet == 5) {
                return "N5"
            }
        },
        clearSearch() {
            this.conditionName = '';
            this.conditionLocation = '';
            this.conditionAddress = '';
            this.conditionPhone = '';
            this.lever_nihongo = '';
            this.jplt = '';
            this.male = '';
            this.status_ctv = '';
            this.district = '';
            this.onSearch();
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
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/jlpt/delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        that.loadingTable = 0;
                        that.onLoadPagination();
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",

                        });
                    }
                });

            })
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';
            if (this.jplt != '') {
                conditionSearch += '&jplt=' + this.jplt;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/jlpt/get-list?page=" + this.page + conditionSearch,
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