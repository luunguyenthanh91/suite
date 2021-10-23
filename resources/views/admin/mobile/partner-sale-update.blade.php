@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '営業者更新')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')

    <div id="list-data">
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="onSubmit()">
                    <i class="fas fa-save"><span class="labelButton">{{ trans('label.save') }}</span></i>
                </a>
                <a type="button" class="btn btn-outline-secondary3" style="background:red" href="/admin/partner-sale-view/{{$id}}">
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
                                            <strong class="card-title">{{ trans('label.sale') }}</strong>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                        <span class="flex d-flex flex-column">
                                            <strong class="card-title">{{ trans('label.bank_name1') }}</strong>
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
                                                <td>{{ trans('label.sale_id') }}</td>
                                                <td>
                                                    {{@$data->id}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.status') }}</td>
                                                <td>
                                                    <select class="form-control" name="status">
                                                        <option value="0" @if(@$data->status == 0) selected @endif>{{ trans('label.status_not') }}</option>
                                                        <option value="1" @if(@$data->status == 1) selected @endif>{{ trans('label.status_yes') }}</option>
                                                        <option value="2" @if(@$data->status == 2) selected @endif>{{ trans('label.status_cancel') }}</option>
                                                    </select>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.name') }}</td>
                                                <td>
                                                <input type="text" name="name" class="form-control" style="text-transform: uppercase;"  required  value="{{@$data->name}}">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.address') }}</td>
                                                <td>
                                                    <input type="text" name="address" class="form-control" style="text-transform: uppercase;"  value="{{@$data->address}}">
                                                    <a id="link-map-po" type="button" class="btn btn-warning googleMapButtonBg">{{ trans('label.google_map3') }}</a>
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td>{{ trans('label.tel') }}</td>
                                                <td>
                                                <input type="text" name="phone" class="form-control" style="text-transform: uppercase;"  value="{{@$data->phone}}">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.email') }}</td>
                                                <td>
                                                    <input type="text" name="email" class="form-control" value="{{@$data->email}}">
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.id_customer') }}</td>
                                                <td>
                                                    <input type="text" name="customer_id" class="form-control" value="{{@$data->customer_id}}">
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
                            <div class="tab-pane" id="detailtab2">
                                <div class="row">     
                                    <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                        <tr>
                                            <td>{{ trans('label.bank_account_name') }}</td>
                                            <td>
                                                <input type="text" name="ten_bank" class="form-control" style="text-transform: uppercase;"  value="{{@$data->ten_bank}}">
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.bank_account_code') }}</td>
                                            <td>
                                                <input type="text" name="ms_nganhang" class="form-control" style="text-transform: uppercase;"  value="{{@$data->ms_nganhang}}">
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.bank_branch_name') }}</td>
                                            <td>
                                                <input type="text" name="chinhanh" class="form-control" style="text-transform: uppercase;"  value="{{@$data->chinhanh}}">
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.bank_branch_code') }}</td>
                                            <td>
                                                <input type="text" name="ms_chinhanh" class="form-control" style="text-transform: uppercase;"  value="{{@$data->ms_chinhanh}}">
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.bank_number') }}</td>
                                            <td>
                                                <input type="text" name="stk" class="form-control" style="text-transform: uppercase;"  value="{{@$data->stk}}">
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.bank_sign') }}</td>
                                            <td>
                                                <input type="text" name="ten_chutaikhoan" class="form-control" style="text-transform: uppercase;"  value="{{@$data->ten_chutaikhoan}}">
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

</div>
@include('admin.component.left-bar')
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
        $("#price").on("change", function() {
            var flagPrice = $('#price').val();
            flagPrice = parseInt(flagPrice.replace('￥' , '').replace(',', '').replace('.',''));
            $('#pricedata').val(flagPrice);
            if (flagPrice) {
                $('#pricedata').val(flagPrice);
                flagPrice = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(flagPrice);
            } else {
                flagPrice = '';
                $('#pricedata').val(flagPrice);
            }
            $('#price').val(flagPrice);
        });

        $('#listDate').datepick({ 
        multiSelect: 999, 
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1});

        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
            jQuery(this).toggle();
        });

        $(window).keydown(function(event){
            if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3]) && ($(event.target)[0]!=$("textarea")[4]) ) {
                event.preventDefault();
                return false;
            }
        });

    });
    var imgId;

    function chooseImage(id) {
        imgId = id;
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileField;
        finder.popup();
    }
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileField(fileUrl) {
        document.getElementById('chooseImage_img' + imgId).src = fileUrl;
        document.getElementById('chooseImage_input' + imgId).value = fileUrl;
        document.getElementById('chooseImage_div' + imgId).style.display = '';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = 'none';
    }

    function clearImage(imgId) {
        document.getElementById('chooseImage_img' + imgId).src = '';
        document.getElementById('chooseImage_input' + imgId).value = '';
        document.getElementById('chooseImage_div' + imgId).style.display = 'none';
        document.getElementById('chooseImage_noImage_div' + imgId).style.display = '';
    }


    function chooseFile(event)
    {   
        id= event.rel;
        imgId = id;
        console.log('chooseImage_input' + imgId);
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileFieldFile;
        finder.popup();
    } 
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileFieldFile( fileUrl )
    {
        document.getElementById( 'chooseImage_input' + imgId).value = fileUrl;
        $("#chooseImage_input"+ imgId).val(fileUrl)[0].dispatchEvent(new Event('input'));

    }
    function clearFile(event)
    {
        imgId= event.rel;
        document.getElementById( 'chooseImage_input' + imgId ).value = '';
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
