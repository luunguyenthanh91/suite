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
                    <h1 class="h2 mb-0">通訳者一覧</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">通訳者管理</li>
                    </ol>

                </div>
            </div>

            <div class="row" role="tablist">
                <div class="col-auto">
                    <a href="/admin/collaborators/add" class="btn btn-outline-secondary">新規登録</a>
                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <!-- <div class="form-group ">
                        <label class="form-label m-0">Get location</label>
                        <div class="search-form " >
                            <input type="text" class="form-control search" v-model="valueAddress">
                            <a target="_blank" :href="'http://maps.google.com/maps?q='+valueAddress" style="background-color: #5567ff;" class="btn btn-primary " >Get Location</a>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="form-label m-0">住所</label>
                        <div class="search-form " >
                            <input type="text" class="form-control search locationSearchLongLat"
                                v-on:keyup.enter="onSearch" v-model="conditionAddress">
                            <button style="background-color: #5567ff;" class="btn btn-primary " type="button" @click="onSearch()">検索</button>
                        </div>
                    </div> -->
                    <div class="form-group ">
                        <label class="form-label m-0">住所</label>
                        <div class="search-form " >
                            <input type="text" class="form-control search"
                                v-on:keyup.enter="onSearch" v-model="conditionAddress">
                            <button style="background-color: #5567ff;" class="btn btn-primary " type="button" @click="onSearch()">検索</button>
                        </div>
                        
                        
                    </div>
                    <div class="page-separator">
                        <div class="page-separator__text">絞り込み</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label m-0">名前</label>
                        <input type="text" class="form-control search"
                            v-on:keyup.enter="onSearch" v-model="conditionName">
                    </div>
                    <div class="form-group">
                        <label class="form-label m-0">性別</label>
                        <select class="form-control search" v-model="male" @change="onSearch()">
                            <option value=""></option>
                            <option value="1">男性</option>
                            <option value="2">女性</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="form-label m-0">電話</label>
                        <div class="search-form" >
                            <input type="text" class="form-control search"
                                v-on:keyup.enter="onSearch" v-model="conditionPhone">
                        </div>
                        
                    </div>
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
                        <label class="form-label m-0">ステータス</label>
                        <select class="form-control search" v-model="status_ctv" @change="onSearch()">
                            <option value=""></option>
                            <option value="0">未承認</option>
                            <option value="1">承認済</option>
                            <option value="2">停止中</option>
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
                                                        <a  style="display: flex; justify-content: center; align-items: center; float: left;" :href="'/admin/collaborators/edit/' + item.id" >
                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                    <i v-if="item.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                    <i v-if="item.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                    ((item.name))
                                                                    
                                                            </strong>
                                                            </p>
                                                        </a>
                                                        <i class="fa fa-id-badge ml-3" style="font-size:26px;cursor: copy;" @click="copyClipboad(item)" aria-hidden="true"></i>
                                                        <a target="_blank" style="font-size:26px;margin-left : 10px" :href="'https://transit.yahoo.co.jp/search/result?from='+item.address+'&s=1&fl=1&to='+conditionAddress" v-if="conditionAddress != '' " class="text-50"><i class="fas fa-train"></i></a>
                                                    </div>
                                                    
                                                    <!-- <p class="mb-0">Furigana: ((item.furigana))</p> -->
                                                    <p class="mb-2"><a :href="'tel:'+item.phone"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.phone))</a></p>
                                                    <p class="mb-2 "><a :href="'mailto:'+item.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.email))</a></p>
                                                    <p class="mb-2 "><a :href="'http://maps.google.com/maps?q=' + item.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.address))</a></p>
                                                    <p class="mb-0" v-if="item.distance"><a href="#">(( parseInt(item.distance) )) KM</a></p>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmgpRGpKtjqZM4MRho4hHI-eYJbnGdbwY" type="text/javascript"></script>
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
        itemCopy : {},
        valueAddress : ''
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
            if (this.conditionAddress != '') {
                const that = this;
                geocoder = new google.maps.Geocoder();
                var address = this.conditionAddress;
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        that.conditionLocation = results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
                        console.log(that.conditionLocation);
                        that.page = 1;
                        that.onLoadPagination();
                    } 
                    else {
                        Swal.fire({
                            title: "Có lỗi dữ liệu nhập vào!",
                            type: "warning",
                        });
                        $('.btn-submit').prop('disabled', false);
                    }
                });
                
            } else {
                this.page = 1;
                this.onLoadPagination();
            }

            // if ( $('.locationSearchLongLat').val() != '') {
            //     this.conditionLocation = $('.locationSearchLongLat').val();
            //     console.log(this.conditionLocation);
            //     this.page = 1;
            //     this.onLoadPagination();
                
            // } else {
            //     this.page = 1;
            //     this.onLoadPagination();
            // }
            
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
                    url: "/admin/collaborators/delete/" + _i.id,
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
            
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCollaborators')}}?page=" + this.page + conditionSearch,
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