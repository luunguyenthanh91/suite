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
                    <h1 class="h2 mb-0">都道府県集計</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item active">通訳者管理</li>
                    </ol>

                </div>
            </div>

            <!-- <div class="row" role="tablist">
                <div class="col-auto">
                    <a href="/admin/collaborators/add" class="btn btn-outline-secondary">新規登録</a>
                </div>
            </div> -->

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                
                <div class="col-lg-12 ">
                    <div class="flex mb-32pt" style="max-width: 100%">

                        <div class="card m-0 p-5">
                            <!-- <div class="col-lg-12">
                                <div class="page-separator">
                                    <div class="page-separator__text">都道府県別の集計</div>
                                </div>
                            </div> -->
                            <div class="col-lg-12 d-flex align-items-center">
                                <div class="flex"  style="max-width: 100%;">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">都道府県</th>
                                            <th scope="col">通訳者数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allDistricts as $key=>$item)
                                                <tr>
                                                    <th scope="row">{{$key + 1}}</th>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{$item->person}}人</td>
                                                </tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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