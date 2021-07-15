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
                    <h1 class="h2 mb-0">顧客一覧</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">顧客</li>
                    </ol>

                </div>
            </div>

            <div class="row" role="tablist">
                <div class="col-auto">
                    <a href="/admin/cusjobs/add" class="btn btn-outline-secondary">顧客</a>
                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">絞り込み</div>
                    </div>
                    <div class="form-group col-lg-12 p-0" >
                        <label class="form-label m-0">ステータス</label>
                        <select class="col-lg-12 form-control search" v-model="status_ctv" @change="onSearch()">
                            <option value="" ></option>
                            <option value="1" >未営業</option>
                            <option value="2" >電話で断りました</option>
                            <option value="3" >電話で結果待ち</option>
                            <option value="4" >サービス利用中</option>
                            <option value="5" >会員</option>
                            <option value="6" >中止</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">顧客コード</label>
                        <input type="text" class="col-lg-12 form-control search"
                            v-on:keyup.enter="onSearch" v-model="conditionEmail">
                    </div>
                    
                    <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">住所</label>
                        <div class="search-form" >
                            <input type="text" class=" form-control search"
                                v-on:keyup.enter="onSearch" v-model="conditionAddress">
                            <button type="button" class="btn ">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview" @click="onOpenLoctionAddress()">location_on</span>
                            </button>
                        </div>
                        
                    </div>
                    <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">名前</label>
                        <input type="text" class="col-lg-12 form-control search"
                            v-on:keyup.enter="onSearch" v-model="conditionName">
                    </div>
                    <div class="form-group col-lg-12 p-0">
                        <label class="form-label m-0">電話</label>
                        <input type="text" class="col-lg-12 form-control search"
                            v-on:keyup.enter="onSearch" v-model="conditionPhone">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary col-lg-12" type="button" @click="onSearch()">検索</button>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-danger col-lg-12" type="button" @click="clearSearch()">クリア</button>
                    </div>

                    

                    

                </div>
                <div class="col-lg-8 d-flex">
                    <div class="flex" style="max-width: 100%">

                        <div class="card m-0">

                            <div class="table-responsive">

                                <table class="table mb-0 thead-border-top-0 table-nowrap">
                                    <tbody class="list " id="search">
                                        <tr v-for="item in list">
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div style="display: flex; justify-content: flex-start; align-items: center;">
                                                        <a  style="display: flex; justify-content: center; align-items: center; float: left;" :href="'/admin/cusjobs/edit/' + item.id" >
                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                    <i v-if="item.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                    <i v-if="item.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                    ((item.name))
                                                                    
                                                            </strong>
                                                            </p>
                                                        </a>
                                                        <i class="fa fa-id-badge ml-3" style="font-size:26px;cursor: copy;" @click="copyClipboad(item)" aria-hidden="true"></i>

                                                    </div>
                                                    <p class="mb-2"><a :href="'tel:'+item.phone"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.phone))</a></p>
                                                    <p class="mb-2 "><a :href="item.website" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">website</span>((item.website))</a></p>
                                                    <p class="mb-2 "><a :href="'http://maps.google.com/maps?q=' + item.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.address))</a></p>
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
        conditionPhone : '',
        conditionAddress: '',
        conditionPhone: '',
        conditionEmail: '',
        lever_nihongo: '',
        jplt: '',
        male: '',
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        conditionLocation: '',
        status_ctv: '',
        district: '',
        groups: []
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
        onOpenLoctionAddress() {
            window.open("http://maps.google.com/maps?q="+this.conditionAddress, '_blank');
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        clearSearch() {
            this.conditionName = '';
            this.conditionLocation = '';
            this.conditionAddress = '';
            this.conditionPhone = '';
            this.lever_nihongo = '';
            this.conditionEmail = '';
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
                    url: "/admin/cusjobs/delete/" + _i.id,
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
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.conditionLocation != '') {
                this.conditionLocation = this.conditionLocation.replace("(", "");
                this.conditionLocation = this.conditionLocation.replace(")", "");
                conditionSearch += '&location=' + this.conditionLocation;
            }
            if (this.conditionAddress != '') {
                conditionSearch += '&address=' + this.conditionAddress;
            }
            if (this.conditionPhone != '') {
                conditionSearch += '&phone=' + this.conditionPhone;
            }
            if (this.lever_nihongo != '') {
                conditionSearch += '&lever_nihongo=' + this.lever_nihongo;
            }
            if (this.jplt != '') {
                conditionSearch += '&jplt=' + this.jplt;
            }
            if (this.male != '') {
                conditionSearch += '&male=' + this.male;
            }
            if (this.status_ctv != '') {
                conditionSearch += '&status=' + this.status_ctv;
            }
            if (this.district != '') {
                conditionSearch += '&district=' + this.district;
            }
            if (this.conditionEmail != '') {
                conditionSearch += '&email=' + this.conditionEmail;
            }
            
            
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.page + conditionSearch,
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