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
                    <h1 class="h2 mb-0">経費リスト</h1>
<!--
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">経費</li>
                    </ol>
-->
                </div>
            </div>

            <div class="row" role="tablist">
				<div class="col-auto">
                    <a href="/admin/chi/add" class="btn btn-primary col-lg-12">新規登録</a>
                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-2">
                    <!-- <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">Tổng Chi : <b>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(totalThuChi) ))</b> </label>
                            
                    </div> -->
                    <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">月</label>
                        <input type="month" class="form-control search" 
                                v-on:keyup.enter="onSearch()" v-model="ngay_bat_dau">
                            
                    </div>
                    <!-- <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">Ngày Kết Thúc</label>
                        <input type="date" class="form-control search" 
                                v-on:keyup.enter="onSearch()" v-model="ngay_ket_thuc">
                            
                    </div> -->
                    <div class="form-group">
                        <button class="btn btn-primary col-lg-12" type="button" @click="onSearch()">検索</button>
                    </div>
                    <div class="form-group ">
                        <button class="btn btn-danger col-lg-12 mt-2" type="button" @click="clearSearch()">クリア</button>
                    </div>
                </div>
				
				
				 <div class="col-lg-10 d-flex ">
                    <div class="flex" style="max-width: 100%">

                        <div class="card m-0">

                            <div class="table-responsive">

                                <table class="table mb-0 thead-border-top-0 table-nowrap">
									<thead class="thead-light">
										<tr>
											<th scope="col"></th>
											<th scope="col">月</th>
											<th scope="col" style="text-align:right">費用合計</th>
											
											<th scope="col">租税公課</th>
											<th scope="col">修繕費</th>
											<th scope="col">水道光熱費</th>
											<th scope="col">保険料</th>
											<th scope="col">消耗品費</th>
											<th scope="col">法定福利費</th>
											<th scope="col">給料賃金</th>
											<th scope="col">地代家賃</th>
											<th scope="col">外注工賃</th>
											<th scope="col">支払手数料</th>
											<th scope="col">旅費交通費</th>
											<th scope="col">開業費/創立費/社債発行費など</th>
											<th scope="col">接待交際費</th>
											<th scope="col">その他</th>
											
											<th scope="col" style="width: 100%; "></th>
										</tr>
									</thead>
								
                                    <tbody class="list" id="search">
                                        <tr v-for="item in list">
											<td>
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;">
															 <a target="_blank" :href="'/admin/chi/edit/'+item.id" class="js-lists-values-employee-name">
																<i class="fas fa-info-circle"></i>
															</a>
														</td>
														</tr>
													</table>
                                                </div>
                                            </td>
                                            <td>
												<div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;">
															 <div class="flex title-edit mb-0  ">
															 <a target="_blank" :href="'/admin/chi/edit/'+item.id" class="js-lists-values-employee-name">
																((item.date))
															</a></div>
														</td>
														</tr>
													</table>
												</div>
                                            </td>
											<td style="text-align:right">
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;;table-layout: fixed;width:100px;">
														<tr style="border:0;">
														<td style="white-space: normal;border:0;padding: 2px;">
															<p class="mb-2 text-50">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price) ))</p>
														</td>
														</tr>
													</table>
                                                </div>
                                            </td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											
										<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
											</td>
											<td >
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
                                            <span>前のページ</span>
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
                                            <span>次のページ</span>
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
        guardAddData: '',
        groupAddData: '',
        ngay_bat_dau : '',
        ngay_ket_thuc : '',
        totalThuChi : 0,
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
                    url: "/admin/chi/delete/" + _i,
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
        clearSearch() {
            this.ngay_bat_dau = '';
            this.ngay_ket_thuc = '';
            this.onLoadPagination();
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            
            if (this.ngay_bat_dau != '') {
                conditionSearch += '&ngay_bat_dau=' + this.ngay_bat_dau;
            }
            if (this.ngay_ket_thuc != '') {
                conditionSearch += '&ngay_ket_thuc=' + this.ngay_ket_thuc;
            }

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChi')}}?page=" + this.page  + conditionSearch ,
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
                    that.totalThuChi = data.totalPrice;
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