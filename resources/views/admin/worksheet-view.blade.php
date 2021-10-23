@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '勤怠ビュー')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')	
	
    <!-- content -->
    <div id="list-data">
        <div class="bodyButtonTop">
            @if (@$data->project_id)
            @else
            <a type="button" class="btn btn-outline-secondary3" style="background:purple" href="/admin/project-add-bypo/{{$id}}">
                <i class="fas fa-briefcase"><span class="labelButton">{{ trans('label.add_project') }}</span></i>
            </a>
            @endif
            <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/po-update/{{$id}}">
                <i class="fas fa-edit"><span class="labelButton">{{ trans('label.edit') }}</span></i>
            </a>
            @if (Auth::guard('admin')->user()->id == 1 )
            <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="deleteRecore('{{$id}}')">
                <i class="fas fa-trash-alt"><span class="labelButton">{{ trans('label.delete') }}</span></i>
            </a> 
            @endif      
        </div>

        <div class="container page__container page-section page_container_custom">
            <div class="gridControl3">
                <div class="d-flex" style="width:100%;">
                    <div style="width:100%;text-align:left !important;">
                        <div class="col-lg-12">                            
                            <label>{{ trans('label.order_id') }}{{@$data->id}} 
                                (
                                    @if ( @$data->status == 0 )
                                        <span>{{ trans('label.po_status1') }}</span>
                                    @endif
                                    @if ( @$data->status == 1 )
                                        <span>{{ trans('label.po_status2') }}</span>
                                    @endif
                                    @if ( @$data->status == 2 )
                                        <span>{{ trans('label.cancel') }}</span>
                                    @endif
                            )</label><br>
                            <label><b><u>(( parseName('{{@$data->name}}') ))  {{ trans('label.sama') }}</u></b></label>
                            <br>
                        <label>{{@$data->ngay_pd}} {{@$data->address_pd}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                    <div class="card-header p-0 nav">
                        <div class="row no-gutters" role="tablist">
                            <div class="col-auto">
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click active" id="tab1">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.property') }}</strong>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane active" id="detailtab1">
                            <div class="row">                                                
                                <div class="col-lg-12">
                                <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">
                                    <tr>
                                        <td>{{ trans('label.order_id') }}</td>
                                        <td>
                                        {{@$data->id}} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.status') }}</td>
                                        <td>
                                        @if ( @$data->status == 0 )
                                            <span>{{ trans('label.po_status1') }}</span>
                                        @endif
                                        @if ( @$data->status == 1 )
                                            <span>{{ trans('label.po_status2') }}</span>
                                        @endif
                                        @if ( @$data->status == 2 )
                                            <span>{{ trans('label.cancel') }}</span>
                                        @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.id') }}</td>
                                        <td>
                                            @if(@$data->project_id)
                                            <a target="_blank" href="/admin/projectview/{{@$data->project_id}}">{{@$data->project_id}}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.ngay_phien_dich') }}</td>
                                        <td>
                                        {{@$data->ngay_pd}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.count_day') }}</td>
                                        <td>
                                        {{@$data->count_ngay_pd}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.address_pd') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="fullWidth">{{@$data->address_pd}}</div>
                                                <div>
                                                    <a target="_blank" href="http://maps.google.com/maps?q={{@$data->address_pd}}" id="link-map-address" type="button" class="btn btn-outline-secondary">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.sale2') }}</td>
                                        <td>
                                        (( parseName('{{@$data->name}}') )) 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.contract_money') }}</td>
                                        <td>
                                        (( parseMoney({{@$data->price}}) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.move_fee') }}</td>
                                        <td>
                                            @if(@$data->type_train == 0)
                                                <span>{{ trans('label.include') }}</span>
                                            @endif
                                            @if(@$data->type_train == 1)
                                                <span>{{ trans('label.exclude') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.sale_cost') }}</td>
                                        <td>
                                        (( parseMoney({{@$data->sale_price}}) ))
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('label.note') }}</td>
                                        <td>
                                        {!! @$data->note !!}
                                        </td>
                                    </tr>
                                </table>
                                </div>
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

    @include('admin.component.footer')

    <!-- // END Footer -->

</div>

@include('admin.component.left-bar')
@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";

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
        jplt: '',
        male: '',
        addModal: 1,
        edit_form: 0,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        instan: 25,
        long: '{{@$data->longitude}}',
        lat: '{{@$data->latitude}}',
        kinh_vido: '',
        ga_gannhat: '{{@$data->ga}}',
        address_pd: '{{@$data->address_pd}}',
        groups: [],
        loai_job : '{{@$data->loai_job}}',
        listAcountSale: [],
        loadingTableSale: 0,
        countSales: 0,
        pageSales: 1,
        listSales: [],
        listPageSales: [],
        conditionNameSale: '',
        listAcountCustomer: [],
        loadingTableCustomer: 0,
        countCustomer: 0,
        pageCustomer: 1,
        listCustomer: [],
        listPageCustomer: [],
        conditionNameCustomer: '',
        objSendMail : [],
        listSendMail : [],
        showListPD : 0,
        showListCus : 0,
        showListCtv : 0,
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
    },
    methods: {
        execCopyClipboad() {
            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();
        },
        copyClipboad(_i) {
            $('#copyName').html("");
            $('#copyFurigana').html("");
            $('#copyPhone').html("");
            this.execCopyClipboad();
        },       
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        parseMoney (value) {
            value = (isNaN(value)) ? 0 : value;
            const formatter = new Intl.NumberFormat('ja-JP', {
                style: 'currency',
                currency: 'JPY',currencyDisplay: 'name'
            });
            return formatter.format(value);
        },
        parseMoneyMinus(value) {
            value = this.parseMoney(value);
            return (value == 0)? value : (S_HYPEN + " " +value);
        },
        parseName (value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        parseAddr(value) {
            return this.isNull(value)? S_HYPEN : value;
        },
        parsePhone(value) {
            if (this.isNull(value)) return S_HYPEN;

            value = (new String(value)).replaceAll(S_HYPEN, '').replaceAll(' ', ''); 
            var vLength = value.length;
            if (vLength == 11) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(7, 4);
            } else if (vLength == 10) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(7, 3);
            }
            return value;
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
                    url: "/admin/po-delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/po";
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
    },
});
</script>

@stop
