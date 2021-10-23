@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', 'PO更新')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <!-- content -->
    <div id="list-data">
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="onSubmit()">
                    <i class="fas fa-save"><span class="labelButton">{{ trans('label.save') }}</span></i>
                </a>
                <a type="button" class="btn btn-outline-secondary3" style="background:red" href="/admin/po-view/{{$id}}">
                    <i class="fas fa-window-close"><span class="labelButton">{{ trans('label.cancel') }}</span></i>
                </a>  
            </div>
        </div>
        <div class="container page__container page-section page_container_custom">
            <form action="" method="POST" class="p-0 mx-auto form-data" >
                @csrf
                <div>
                    @if ( @$message && @$message['status'] === 1 )
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <strong>{{ $message['message'] }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    @endif
                    @if ( @$message && @$message['status'] === 2 )
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong>{{ $message['message'] }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    <div class="card dashboard-area-tabs p-relative o-hidden poViewMobile">
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
                                                <div class="search-form" >
                                                    <select class="form-control" name="status">
                                                        <option value="0" @if(@$data->status == 0) selected @endif>{{ trans('label.po_status1') }}</option>
                                                        <option value="1" @if(@$data->status == 1) selected @endif>{{ trans('label.po_status2') }}</option>
                                                        <option value="2" @if(@$data->status == 2) selected @endif>{{ trans('label.cancel') }}</option>
                                                    </select>
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.id') }}</td>
                                                <td>
                                                    <input type="text" name="project_id" class="form-control" value="{{@$data->project_id}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.ngay_phien_dich') }}</td>
                                                <td>
                                                <input type="text" autocomplete="off" name="ngay_pd" id="listDatePo" class="form-control"  required value="{{@$data->ngay_pd}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.count_day') }}</td>
                                                <td>
                                                <div id="txtCountDayPo">{{@$data->count_ngay_pd}}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.address_pd') }}</td>
                                                <td>
                                                <div class="search-form" >
                                                    <input type="text" id="address"  name="address_pd" class="form-control" value="{{@$data->address_pd}}">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.sale2') }}</td>
                                                <td>
                                                <div class="search-form" >
                                                    <input type="text" name="name" class="form-control" style="text-transform: uppercase;"  required  value="{{@$data->name}}">
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.contract_money') }}</td>
                                                <td>
                                                <input type="text" class="form-control money_parse" name="price" value="{{@$data->price}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.move_fee') }}</td>
                                                <td>
                                                    <div class="custom-controls-stacked">
                                                        <div class="custom-control custom-radio">
                                                            <input id="radiomale1" name="type_train" type="radio" class="custom-control-input" @if(0==@$data->type_train) checked @endif value="0">
                                                            <label for="radiomale1" class="custom-control-label">{{ trans('label.include') }}</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input id="radiomale2" name="type_train" type="radio" class="custom-control-input" @if(1==@$data->type_train) checked @endif value="1">
                                                            <label for="radiomale2" class="custom-control-label">{{ trans('label.exclude') }}</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.sale_cost') }}</td>
                                                <td>
                                                <input type="text" class="form-control money_parse" name="sale_price" value="{{@$data->sale_price}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.note') }}</td>
                                                <td>
                                                <textarea type="text" name="note" class="form-control" rows="10">{{@$data->note}}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="error-details" style="display:none">
        <span id="copyName"></span><br>
        <span id="copyFurigana"></span><br>
        <span id="copyPhone"></span><br>
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
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });
        $('#listDatePo').datepick({ 
            multiSelect: 999, 
            minDate: 0,
            dateFormat: 'yyyy-mm-dd',
            monthsToShow: 1,
            onSelect: function(dateText, inst) {
                $(this).change();
            }
        });
        $('#listDatePo').change(function(event) {
            $cntDay = this.value.split(',').length;
            $('#txtCountDayPo').text($cntDay);
        });
    });
//]]>
</script>
<style type="text/css">
    #images { list-style-type: none; margin: 0; padding: 0;}
    #images li { margin: 10px; float: left; text-align: center;  height: 190px;}
    .modal-backdrop {
        display: none !important;
    }
</style>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

new Vue({
    el: '#list-data',
    data: {
        listBankAccount: [],
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
        isMobile : ( viewPC )? false : true,
        marginTop: "100px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classRowContent: (viewPC)? "" : "rowContent ",
        price : ''
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
        
    },
    methods: {
        goGoogleMap() {
            var address = $('#address').val();
            if (address.trim() == '') {
                alert("Nhập địa chỉ.");
                return false;
            }
            var win = window.open('https://www.google.com/maps/place/'+address, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        },
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
        toggelPd() {
            this.showListPD = this.showListPD == 1 ? 0 : 1;
        },
        toggelCus() {
            this.showListCus = this.showListCus == 1 ? 0 : 1;
        },
        toggelCtv() {
            this.showListCtv = this.showListCtv == 1 ? 0 : 1;
        },
        calculatorCheck() {
            var totalAlerMessage = $('#totalIWill').val() - $('#priceDuyTri').val() - $('#priceOrther').val() - $('#priceVat').val() - 500;
            alert("営業者報酬 : "+ (totalAlerMessage * 10 / 100));
        },
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
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            setTimeout(function(){ $('.form-data').submit(); }, 1000);
        },
        
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        convertStatusBank (value) {
            return (value == "1")? "済み" : "";
        },
        convertTaxPlace (value) {
            return (value == "0")? "" : value;
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
        parseBank (itemBank) {
            var value = itemBank["name_bank"];
            return value;
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
        submitSendMail() {
            var body = { 
                _token: CSRF_TOKEN ,
                mail_cc : this.objSendMail.mail_cc,
                title : this.objSendMail.title,
                body : this.objSendMail.body,
                userId : this.userCustomerId
            };
            $.ajax({
                type: 'POST',
                url: '/admin/company/send-mail-template',
                data: body,
                success: function(data) {
                    if (data.code == 200) {
                        Swal.fire({
                            title: "Đã gửi Email!",
                            type: "success",

                        });
                    } else {
                        Swal.fire({
                            title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                            type: "warning",

                        });
                    }
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Hệ Thống Gặp Lỗi Không Thể Gửi Email!",
                        type: "warning",

                    });
                }
            });
            
        },
        cancleEdit() {
            this.edit_form = 0;
        },
        openEdit() {
            this.edit_form = 1;
        },
        addListRecord(i) {
            
            i.dateList.push({
                id: 'new',
                type: 'add',
                ngay_phien_dich: '',
                gio_phien_dich: '',
                gio_ket_thuc: '',
                gio_tang_ca: '',
                note: '',
                phi_phien_dich: '',
                phi_giao_thong: '',
                // file_bao_cao: '',
                file_hoa_don: ''
            });
        },
        removeListRecord(i) {
            i.type = 'delete';
        },
        removeRecordSales(i) {
            i.type = 'delete';
        },
        removeRecordCustomer(i) {
            i.type = 'delete';
        },
        addRecordSale(i) {
            this.listAcountSale.push({
                id: 'new',
                type: 'add',
                ctv_jobs_id: i.id,
                price_total: '',
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                payplace: 0,
                status: '',
                info: i
            });
        },
        addRecordCustomer(i) {
            this.listAcountCustomer.push({
                id: 'new',
                type: 'add',
                cus_jobs_id: i.id,
                price_total: '',
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                status: '',
                info: i
            });
        },
        addRecord(i) {
            let listDatePd = $('#listDate').val();
            let dateListCheck = [];
            if (listDatePd != '') {
                listDatePd = listDatePd.split(",");
                listDatePd.map(itemMap => {
                    dateListCheck.push({
                        id: 'new',
                        type: 'add',
                        ngay_phien_dich: itemMap,
                        gio_phien_dich: '',
                        gio_ket_thuc: '',
                        gio_tang_ca: '',
                        note: '',
                        phi_phien_dich: '',
                        phi_giao_thong: '',
                        // file_bao_cao: '',
                        file_hoa_don: ''
                    });
                });
            }
            this.listBankAccount.push({
                id: 'new',
                type: 'add',
                collaborators_id: i.id,
                price_total: '',
                bank_id: '',
                listBank: i.bank,
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                dateList: dateListCheck,
                paytaxplace: 0,
                info: i
            });
        },
        removeRecord(i) {
            i.type = 'delete';
        }

    },
});
</script>

@stop
