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

    <div class="pt-32pt">
        <div
            class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h2 class="mb-0">Dashboard</h2>

                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>

                        <li class="breadcrumb-item active">

                            Dashboard

                        </li>

                    </ol>

                </div>
            </div>

        </div>
    </div>

    <!-- BEFORE Page Content -->

    <!-- // END BEFORE Page Content -->

    <!-- Page Content -->

    <div class="page-section border-bottom-2">
        <div class="container page__container">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-1 border-left-3 border-left-accent text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0">&dollar;1,569.00</h4>
                            <div>Earnings this month</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0">&dollar;3,917.80</h4>
                            <div>Account Balance</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card text-center mb-lg-0">
                        <div class="card-body">
                            <h4 class="h2 mb-0">&dollar;10,211.50</h4>
                            <div>Total Sales</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Earnings</div>
        </div>
        <div class="card card-body mb-32pt">
            <div id="legend" class="chart-legend mt-0 mb-24pt justify-content-start"></div>
            <div class="chart" style="height: 320px;">
                <canvas id="earningsChart" class="chart-canvas js-update-chart-bar" data-chart-legend="#legend"
                    data-chart-line-background-color="gradient:primary,gray" data-chart-prefix="$" data-chart-suffix="k"
                    data-chart-dark-mode="true"></canvas>
            </div>
        </div>

        <div class="row mb-8pt">
            <div class="col-lg-6">

                <div class="page-separator">
                    <div class="page-separator__text">Transactions</div>
                </div>
                <div class="card">
                    <div data-toggle="lists" data-lists-values='[
      "js-lists-values-course", 
      "js-lists-values-document",
      "js-lists-values-amount",
      "js-lists-values-date"
    ]' data-lists-sort-by="js-lists-values-date" data-lists-sort-desc="true" class="table-responsive">
                        <table class="table table-flush table-nowrap">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-course">Course</a>
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-document">Document</a>
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-amount">Amount</a>
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-date">Date</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="list">

                                <tr>
                                    <td>
                                        <div class="d-flex flex-nowrap align-items-center">
                                            <a href="instructor-edit-course.html"
                                                class="avatar avatar-4by3 overlay overlay--primary mr-12pt">
                                                <img src="{{ asset('assets/images/paths/angular_routing_200x168.png') }}"
                                                    alt="course" class="avatar-img rounded">
                                                <span class="overlay__content"></span>
                                            </a>
                                            <div class="flex">
                                                <a class="card-title js-lists-values-course"
                                                    href="instructor-edit-course.html">Angular Routing In-Depth</a>
                                                <small class="text-muted mr-1">
                                                    Invoice
                                                    <a href="invoice.html" style="color: inherit;"
                                                        class="js-lists-values-document">#8734</a> -
                                                    &dollar;<span class="js-lists-values-amount">89</span> USD
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <small class="text-muted text-uppercase js-lists-values-date">12 Nov
                                            2018</small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex flex-nowrap align-items-center">
                                            <a href="instructor-edit-course.html"
                                                class="avatar avatar-4by3 overlay overlay--primary mr-12pt">
                                                <img src="{{ asset('assets/images/paths/angular_testing_200x168.png') }}"
                                                    alt="course" class="avatar-img rounded">
                                                <span class="overlay__content"></span>
                                            </a>
                                            <div class="flex">
                                                <a class="card-title js-lists-values-course"
                                                    href="instructor-edit-course.html">Angular Unit Testing</a>
                                                <small class="text-muted mr-1">
                                                    Invoice
                                                    <a href="invoice.html" style="color: inherit;"
                                                        class="js-lists-values-document">#8735</a> -
                                                    &dollar;<span class="js-lists-values-amount">89</span> USD
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <small class="text-muted text-uppercase js-lists-values-date">13 Nov
                                            2018</small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex flex-nowrap align-items-center">
                                            <a href="instructor-edit-course.html"
                                                class="avatar avatar-4by3 overlay overlay--primary mr-12pt">
                                                <img src="{{ asset('assets/images/paths/typescript_200x168.png') }}" alt="course"
                                                    class="avatar-img rounded">
                                                <span class="overlay__content"></span>
                                            </a>
                                            <div class="flex">
                                                <a class="card-title js-lists-values-course"
                                                    href="instructor-edit-course.html">Introduction to TypeScript</a>
                                                <small class="text-muted mr-1">
                                                    Invoice
                                                    <a href="invoice.html" style="color: inherit;"
                                                        class="js-lists-values-document">#8736</a> -
                                                    &dollar;<span class="js-lists-values-amount">89</span> USD
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <small class="text-muted text-uppercase js-lists-values-date">14 Nov
                                            2018</small>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex flex-nowrap align-items-center">
                                            <a href="instructor-edit-course.html"
                                                class="avatar avatar-4by3 overlay overlay--primary mr-12pt">
                                                <img src="{{ asset('assets/images/paths/angular_200x168.png') }}" alt="course"
                                                    class="avatar-img rounded">
                                                <span class="overlay__content"></span>
                                            </a>
                                            <div class="flex">
                                                <a class="card-title js-lists-values-course"
                                                    href="instructor-edit-course.html">Learn Angular Fundamentals</a>
                                                <small class="text-muted mr-1">
                                                    Invoice
                                                    <a href="invoice.html" style="color: inherit;"
                                                        class="js-lists-values-document">#8737</a> -
                                                    &dollar;<span class="js-lists-values-amount">89</span> USD
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <small class="text-muted text-uppercase js-lists-values-date">15 Nov
                                            2018</small>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">

                <div class="page-separator">
                    <div class="page-separator__text">Comments</div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-left mr-12pt">
                                <a href="#" class="avatar avatar-sm">
                                    <!-- <img src="../../public/images/people/110/guy-9.jpg" alt="Guy" class="avatar-img rounded-circle"> -->
                                    <span class="avatar-title rounded-circle">LB</span>
                                </a>
                            </div>
                            <div class="media-body d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <a href="profile.html" class="card-title">Laza Bogdan</a>
                                    <small class="ml-auto text-muted">27 min ago</small><br>
                                </div>
                                <span class="text-muted">on <a href="instructor-edit-course.html" class="text-50"
                                        style="text-decoration: underline;">Data Visualization With Chart.js</a></span>
                                <p class="mt-1 mb-0 text-70">How can I load Charts on a page?</p>
                            </div>
                        </div>
                        <div
                            class="media ml-sm-32pt mt-3 border rounded p-3 card mb-0 d-inline-flex measure-paragraph-max">
                            <div class="media-left mr-12pt">
                                <a href="#" class="avatar avatar-sm">
                                    <!-- <img src="../../public/images/people/110/guy-6.jpg" alt="Guy" class="avatar-img rounded-circle"> -->
                                    <span class="avatar-title rounded-circle">FM</span>
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="d-flex align-items-center">
                                    <a href="profile.html" class="card-title">FrontendMatter</a>
                                    <small class="ml-auto text-muted">just now</small>
                                </div>
                                <p class="mt-1 mb-0 text-70">Hi Bogdan,<br> Thank you for purchasing our course!
                                    <br><br>Please have a look at the charts library documentation <a href="#"
                                        class="text-underline">here</a> and follow the instructions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="#" id="message-reply">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control form-control-appended" required=""
                                    placeholder="Quick Reply">
                                <div class="input-group-append">
                                    <div class="input-group-text pr-2">
                                        <button class="btn btn-flush" type="button"><i
                                                class="material-icons">tag_faces</i></button>
                                    </div>
                                    <div class="input-group-text pl-0">
                                        <div class="custom-file custom-file-naked d-flex"
                                            style="width: 24px; overflow: hidden;">
                                            <input type="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" style="color: inherit;" for="customFile">
                                                <i class="material-icons">attach_file</i>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group-text pl-0">
                                        <button class="btn btn-flush" type="button"><i
                                                class="material-icons">send</i></button>
                                    </div>
                                </div>
                            </div>
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
    <!-- UI Charts Page JS -->
    <script src="{{ asset('assets/js/chartjs-rounded-bar.js') }}"></script>
    <script src="{{ asset('assets/js/chartjs.js') }}"></script>
    <!-- Chart.js Samples -->
    <script src="{{ asset('assets/js/page.instructor-dashboard.js') }}"></script>

@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$leftBarVal = 0;
new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        conditionSearch: '',
        list: [],
        listPage: [],
        conditionName: '',
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        groups: [],
        conditionStatus: '',
        conditionAddress: '',
        ngay_phien_dich: '',
		thang_chuyen_khoan: "{{date('Y-m')}}",
        thang_phien_dich: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        type_jobs: '',
        codeJobs: '',
        checkedNames: [4,5,6],
		checkedTypes: [1,2,3],
        sortName: '',
        sortType:"DESC",
        sumPay: 0,
        sumCount:0
    },
    delimiters: ["((", "))"],
    mounted() {

        this.onLoadPagination();
    },
    methods: {
        copyClipboad(_i) {
            $('#copyName').html(_i.name);
            $('#copyFurigana').html(_i.furigana);
            $('#copyPhone').html(_i.phone);

            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();

        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChange: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        sortNgayPD: function() {
            this.sortName = "company.ngay_pd";
            this.onLoadPagination();
        },
        sortJobID: function() {
            this.sortName = "company.codejob";
            this.onLoadPagination();
        },
        showLeftBar: function() {
            if ($leftBarVal == 0) {
                $("#default-drawer").css("display","none");
                $leftBarVal = 1;
            } else {
                $("#default-drawer").css("display","block");
                $leftBarVal = 0;
            }
        },
        clearSearch() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.ngay_phien_dich = '';
			this.thang_phien_dich = '';
            this.thang_chuyen_khoan = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.type_jobs = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.conditionSearch = "";
            this.checkedNames = [4,5,6];
			this.checkedTypes = [1,2,3];
            this.sortName = '';  
            this.sortType = "DESC";  
        this.sumPay= 0;
        this.sumCount=0;
            
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            this.onLoadPagination();
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [4,5,6];
            this.onLoadPagination();
		},
		clearSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [];
            this.onLoadPagination();
		},
		setSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [1,2,3];
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
                    url: "/admin/company/delete/" + _i.id,
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

            if (this.conditionAddress != '') {
                conditionSearch += '&address=' + this.conditionAddress;
            }
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.ctv_sale != '') {
                conditionSearch += '&ctv_sale=' + this.ctv_sale;
            }
            if (this.conditionStatus != '') {
                conditionSearch += '&status=' + this.conditionStatus;
            }
            if (this.type_jobs != '') {
                conditionSearch += '&type_jobs=' + this.type_jobs;
            }
            if (this.dateOrder != '') {
                conditionSearch += '&date_start=' + this.dateOrder;
            }
            if (this.ngay_phien_dich != '') {
                conditionSearch += '&ngay_phien_dich=' + this.ngay_phien_dich;
            }
            if (this.thang_phien_dich != '') {
                conditionSearch += '&thang_phien_dich=' + this.thang_phien_dich;
            }
            if (this.thang_chuyen_khoan != '') {
                conditionSearch += '&thang_chuyen_khoan=' + this.thang_chuyen_khoan;
            }
            if (this.name_kh != '') {
                conditionSearch += '&name_kh=' + this.name_kh;
            }
            if (this.ctv_pd != '') {
                conditionSearch += '&ctv_pd=' + this.ctv_pd;
            }
            if (this.codeJobs != '') {
                conditionSearch += '&code_jobs=' + this.codeJobs;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.checkedTypes.length > 0) {
                conditionSearch += '&loai_job_multi=' + this.checkedTypes.join();
            }
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;
                if (this.sortType == "DESC") {
                    this.sortType = "ASC";
                } else {
                    this.sortType = "DESC";
                }
            }
            this.conditionSearch = conditionSearch;
            

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListEarnings')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumPay = data.sumPay;
                        that.sumCount = data.count;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
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