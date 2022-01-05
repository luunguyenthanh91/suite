@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '立替金申請更新')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')

    <!-- content -->
    <div id="list-data">
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="onSubmit()">
                <i class="fas fa-save"><span class="labelButton">{{ trans('label.save') }}</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:red" href="/admin/costtransport-view/{{$id}}">
                <i class="fas fa-window-close"><span class="labelButton">{{ trans('label.cancel') }}</span></i>
            </a>
        </div>
        <div class="container page__container page-section page_container_custom">
            <form action="" method="POST" class="p-0 mx-auto form-data">
                @csrf
                <div class="col-lg-12">
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
                                    <div class="col-auto border-left border-right">
                                        <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab3">
                                            <span class="flex d-flex flex-column">
                                                <strong class="card-title">{{ trans('label.detail_request') }}</strong>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-auto border-left border-right">
                                        <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab4">
                                            <span class="flex d-flex flex-column">
                                                <strong class="card-title">{{ trans('label.receipt') }}</strong>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body tab-content">
                                <div class="tab-pane active" id="detailtab1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">
                                                    <tr>
                                                        <td>{{ trans('label.content') }}</td>
                                                        <td>
                                                            <input type="text" name="name" value="{{$data->name}}" class="form-control">
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
                                <div class="tab-pane" id="detailtab3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="addRecordCostTransportDetail()">
                                                <i class="fas fa-plus"><span class="labelButton">{{ trans('label.addRecord') }}</span></i>
                                            </a>
                                            <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th @click="sort('date')" class="textAlignCenter">
                                                            <div v-bind:class="[sortBy === 'date' ? sortDirection : '']">{{ trans('label.cost_date') }}</div>
                                                        </th>
                                                        <th click="sort('place_from')" class="textAlignCenter">
                                                            <div v-bind:class="[sortBy === 'place_from' ? sortDirection : '']">{{ trans('label.costprepay_place') }}</div>
                                                        </th>
                                                        <th @click="sort('name')" class="textAlignCenter">
                                                            <div v-bind:class="[sortBy === 'name' ? sortDirection : '']">{{ trans('label.costprepay_name') }}</div>
                                                        </th>
                                                        <th @click="sort('price')" class="moneyCol">
                                                            <div v-bind:class="[sortBy === 'price' ? sortDirection : '']">{{ trans('label.price2') }}</div>
                                                        </th>
                                                        <th @click="sort('note')">
                                                            <div v-bind:class="[sortBy === 'note' ? sortDirection : '']">{{ trans('label.note') }}</div>
                                                        </th>
                                                        <th style="width: 100%; "></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="search">
                                                    <tr v-bind:class="[item.action == 'delete' ? 'hidden' : '']" v-for="(item,key) in sortedProducts">
                                                        <td>
                                                            <input　class="form-control" type="date" v-model="item.date" :name="'transport['+key+'][date]'" />
                                                            <input type="hidden" v-model="item.id" :name="'transport['+key+'][id]'" />
                                                            <input type="hidden" v-model="item.action" :name="'transport['+key+'][action]'" />
                                                        </td>
                                                        <td class="textAlignCenter">
                                                            <div class="d-flex ">
                                                                <input style="min-width:150px;"　class="form-control" type="text" v-model="item.place_from" :name="'transport['+key+'][place_from]'" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input style="min-width:200px;"　class="form-control" type="text" v-model="item.name" :name="'transport['+key+'][name]'" />
                                                        </td>
                                                        <td class="moneyCol">
                                                            <input　 style="min-width:100px;" class="form-control moneyCol" type="text" v-model="item.price" style="text-align:right;width:70px;" :name="'transport['+key+'][price]'" />
                                                        </td>
                                                        <td>
                                                            <span class="text-block">
                                                                <input style="min-width:200px;"　class="form-control" type="text" v-model="item.note" :name="'transport['+key+'][note]'" />
                                                            </span>
                                                        </td>
                                                        <td style="width: 100%; ">
                                                            <a type="button" class="btn btn-outline-secondary3" style="background:red; margin-top:-2px;" @click="deleteRecordCostTransportDetail(item)">
                                                                <i class="fas fa-window-close"><span class="labelButton">{{ trans('label.delete') }}</span></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="detailtab4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="addDocFile()">
                                                <i class="fas fa-plus"><span class="labelButton">{{ trans('label.add') }}</span></i>
                                            </a>
                                            <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="textAlignCenter">
                                                        </th>
                                                        <th class="textAlignCenter">
                                                            <div>{{ trans('label.url') }}</div>
                                                        </th>
                                                        <th style="width: 100%; "></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="search">
                                                    <tr v-bind:class="[item.action == 'delete' ? 'hidden' : '']" v-for="(item,key) in listDocFile">
                                                        <td>
                                                            <!-- <input style="min-width:150px;"　class="form-control" type="text" v-model="item.file_name" :name="'docs['+key+'][file_name]'" /> -->
                                                            <input type="hidden" v-model="item.id" :name="'docs['+key+'][id]'" />
                                                            <input type="hidden" v-model="item.action" :name="'docs['+key+'][action]'" />
                                                            <input type="hidden" v-model="item.table_name" :name="'docs['+key+'][table_name]'" />
                                                            <a onclick="chooseImage(this)"  v-bind:rel="'_file'+key">{{ trans('label.select_file') }}</a>
                                                            | 
                                                            <a onclick="clearImage(this)" v-bind:rel="'_file'+key">{{ trans('label.delete_file') }}</a>
                                                        </td>
                                                        <td class="center" style="min-width:500px;">
                                                            <div class="input-group">
                                                                <ul id="images">
                                                                    <li>
                                                                        <input class="input_image" type="hidden" :name="'docs['+key+'][url]'" v-bind:id="'chooseImage_input_file'+key" v-model="item.url" >
                                                                        <div style="margin-top:-10px;" v-bind:id="'chooseImage_div_file'+key" v-bind:style="item.url != null ? '' : 'display: none;'" >
                                                                            <a v-bind:src="item.url" v-bind:id="'chooseImage_img_file'+key" style="max-width: 150px; max-height:150px; border:dashed thin;">((item.url))</a>
                                                                        </div>
                                                                        <div style="margin-top:-10px;" v-bind:id="'chooseImage_noImage_div_file'+key" v-bind:style="item.url == null ? '' : 'display: none;'" style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                                                            No File
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        
                                                        </td>
                                                        <td style="width: 100%; ">
                                                            <a type="button" class="btn btn-outline-secondary3" style="background:red; margin-top:-2px;" @click="deleteDocfile(item)">
                                                                <i class="fas fa-window-close"><span class="labelButton">{{ trans('label.delete') }}</span></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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

        $('#listDate').datepick({ 
            multiSelect: 999, 
            dateFormat: 'yyyy-mm-dd',
            monthsToShow: 1
        });
        
        $(window).keydown(function(event){
            if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3]) && ($(event.target)[0]!=$("textarea")[4]) ) {
                event.preventDefault();
                return false;
            }
        });

    });
    var imgId;

    function chooseImage(event)
    {   
        id= event.rel;
        imgId = id;
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        finder.basePath = '/lib_upload/ckfinder/'; // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.selectActionFunction = setFileField;
        finder.popup();
    } 
    // This is a sample function which is called when a file is selected in CKFinder.
    function setFileField( fileUrl )
    {
        document.getElementById( 'chooseImage_img' + imgId ).src = fileUrl;
        // document.getElementById( 'chooseImage_input' + imgId).value = fileUrl;
        document.getElementById( 'chooseImage_div' + imgId).style.display = '';
        document.getElementById( 'chooseImage_noImage_div' + imgId ).style.display = 'none';
        $("#chooseImage_input"+ imgId).val(fileUrl)[0].dispatchEvent(new Event('input'));

    }
    function clearImage(event)
    {
        imgId= event.rel;
        document.getElementById( 'chooseImage_img' + imgId ).src = '';
        document.getElementById( 'chooseImage_input' + imgId ).value = '';
        document.getElementById( 'chooseImage_div' + imgId).style.display = 'none';
        document.getElementById( 'chooseImage_noImage_div' + imgId).style.display = '';
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
    #images li { margin: 10px; float: left; text-align: center; }
    .modal-backdrop {
        display: none !important;
    }
</style>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function (){

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
        month: '{{@$data->month}}',
        user_id: '{{@$data->user_id}}',
        groups: [],
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
        showCount: 20,
        isMobile : ( viewPC )? false : true,
        type_show: ( viewPC )? 1 : 2,
        checkAkaji: 0,
        marginTop: "30px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classBodayRightContentGrid: (viewPC)? "bodayRightContentGrid" : "",
        classColLG12: (viewPC)? "col-lg-12" : "colLg12Mobile",
        item_id: '{{@$data->id}}',
        conditionSearch: '',
        sumCount: 0,
        sortBy: 'codejob',
        sortDirection: 'desc',
        sumTienPhienDich: 0,
        sumTongThuDuKien: 0,
        sumCost:0 ,
        sumCostSale: 0,
        sumCostInterpreter: 0,
        sumCostIncomeTax: 0,
        sumCostMoveFee: 0,
        sumCostBankFee: 0,
        sumEarning: 0,
        sumBenefit: 0,
        sumDeposit: 0,
        sumTongKimDuocDuKien: 0,
        listProject: [],
        listDocFile: [],
        daycount: 0,
        worktimecount: 0,
        overworktimecount: 0,
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
        this.onLoadPagination();
    },
    computed: {
        sortedProducts: function(){
            return this.listProject.sort((p1,p2) => {

                let modifier = 1;
                if(this.sortDirection === 'desc') modifier = -1;
                if (this.sortBy == 'ctv_sales_list' || this.sortBy == 'ctv_list') {
                    if(p1[this.sortBy].length == 0 && p2[this.sortBy].length > 0) return -1 * modifier; 
                    if(p1[this.sortBy].length > 0 && p2[this.sortBy].length == 0) return 1 * modifier;
                    if(p1[this.sortBy].length == 0 && p2[this.sortBy].length == 0) return 0;

                    if(p1[this.sortBy][0]['name'] < p2[this.sortBy][0]['name']) return -1 * modifier; 
                    if(p1[this.sortBy][0]['name'] > p2[this.sortBy][0]['name']) return 1 * modifier;
                    return 0;
                } else {
                    if(p1[this.sortBy] < p2[this.sortBy]) return -1 * modifier; 
                    if(p1[this.sortBy] > p2[this.sortBy]) return 1 * modifier;
                    return 0;
                }
            });
        }
    },
    methods: {
        
        removeTime (value) {
            return this.isNull(value)? S_HYPEN : (value.split(' ')[0]);
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
        copyClipboadCTV(_i) {
            $('#copyName').html(this.parseName(_i.name));
            $('#copyFurigana').html(_i.address);
            $('#copyPhone').html(this.parsePhone(_i.phone));

            this.execCopyClipboad();
        },
        copyClipboadCTVpd(_i) {
            $('#copyName').html(this.parseName(_i.name));
            $('#copyFurigana').html(_i.furigana);
            $('#copyPhone').html(this.parsePhone(_i.phone));

            this.execCopyClipboad();
        },
        copyClipboad(_i) {
            $('#copyName').html(_i.codejob);
            $('#copyFurigana').html(_i.ngay_pd);
            $('#copyPhone').html(_i.address_pd);

            this.execCopyClipboad();
        },
        copyClipboadLink(_i) {
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            var url = baseUrl + "/partner-sale-view/" + _i.id;
            $('#copyName').html(url);
            $('#copyFurigana').html("");
            $('#copyPhone').html("");

            this.execCopyClipboad();
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
            // if ('{{@$data->address_pd}}' !=  this.address_pd) {
            //     const that = this;
            //     $.ajax({
            //         type: 'GET',
            //         url: "http://api.positionstack.com/v1/forward?access_key=d4eb3bcee90d3d0a824834770881ce70&query=" + this.address_pd,
            //         success: function(data) {
            //             that.long = data.data[0].latitude;
            //             that.lat = data.data[0].longitude;
            //             setTimeout(function(){ $('.form-data').submit(); }, 1000);

            //         },
            //         error: function(xhr, textStatus, error) {
            //             Swal.fire({
            //                 title: "Có lỗi dữ liệu nhập vào!",
            //                 type: "warning",

            //             });
            //         }
            //     });
            // } else {
            //     setTimeout(function(){ $('.form-data').submit(); }, 1000);
            // }
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
            if (isNaN(value)) {
                return "";
            }
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
        parseMonth (value) {
            return this.isNull(value)? S_HYPEN : 
            value.replace("-", "年")+"月度";
        },
        parseAddr(value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
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
        onSendEmail() {
            let arrSendMail = [];
            this.list.map(item => {
                if (item.send_mail == 1) {
                    if (!arrSendMail.includes(item.id)) {
                        arrSendMail.push(item.id);
                    }
                }
            });
            if (arrSendMail.length > 0) {
                let listId = arrSendMail.join(',');
                $.ajax({
                    type: 'GET',
                    url: "/admin/company/send-mail?id={{$id}}&list=" + listId,
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
            }
        },
        cancleEdit() {
            this.edit_form = 0;
        },
        openEdit() {
            this.edit_form = 1;
        },
        onOpenLoction() {
            window.open("http://maps.google.com/maps?q="+this.ga_gannhat, '_blank');
        },
        onOpenLoctionAddress() {
            window.open("http://maps.google.com/maps?q="+this.address_pd, '_blank');
        },
        onGetSales() {
            this.pageSales = 1;
            this.loadingTableSale = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSale != '') {
                conditionSearch += '&name=' + this.conditionNameSale;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCtvJobs')}}?page=" + this.pageSales  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countSales = data.pageTotal;
                        that.listSales = data.data;
                    } else {
                        that.countSales = 0;
                        that.listSales = [];
                    }
                    that.loadingTableSale = 0;
                    let pageArr = [];
                    if (that.pageSales - 2 > 0) {
                        pageArr.push(that.pageSales - 2);
                    }
                    if (that.pageSales - 1 > 0) {
                        pageArr.push(that.pageSales - 1);
                    }
                    pageArr.push(that.pageSales);
                    if (that.pageSales + 1 <= that.count) {
                        pageArr.push(that.pageSales + 1);
                    }
                    if (that.pageSales + 2 <= that.countSales) {
                        pageArr.push(that.pageSales + 2);
                    }
                    that.listPageSales = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        promoteSubmit(_i) {
            const that = this;
            Swal.fire({
                title: "提出でよろしいでしょうか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/payslipsubmit/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "提出の処理が終わりました。"
                        });
                        location.href = "/admin/payslip-view/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        sendmailpayslip(_i) {
            const that = this;
            Swal.fire({
                title: "\給与明細発行通知メールを送信します。<br>よろしいですか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/sendmail-payslip/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "通知メールを送信しました。"
                        });
                        location.href = "/admin/payslip-view/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        sendmailpayslipcheck(_i) {
            const that = this;
            Swal.fire({
                title: "\給与入金確認依頼メールを送信します。<br>よろしいですか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/sendmail-payslip-check/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "依頼メールを送信しました。"
                        });
                        location.href = "/admin/payslip-view/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        promoteCheck(_i) {
            const that = this;
            Swal.fire({
                title: "\確認が終わりましたか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/payslipcheck/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "確認の処理が終わりました。"
                        });
                        location.href = "/admin/payslip-view/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        promoteApprove(_i) {
            const that = this;
            Swal.fire({
                title: "\承認でよろしいでしょうか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/payslipapprove/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "承認の処理が終わりました。"
                        });
                        location.href = "/admin/payslip-view/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
        },
        promoteReceive(_i) {
            const that = this;
            Swal.fire({
                title: "\受領済みでよろしいでしょうか？",
                // text: "\案件入力のチェックが終わりましたか？",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "はい",
                cancelButtonText: "いいえ",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/payslipreceive/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "受領の処理が終わりました。"
                        });
                        location.href = "/admin/payslip-view/" + _i;
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "エラーが発生しました!",
                            type: "warning",
                        });
                    }
                });
            })
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
                    url: "/admin/payslip-delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/payslip";
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
        deleteDocfile(item) {
            item.action = "delete";
        },
        addDocFile() {
            this.listDocFile.push(
                {
                    item_id: "{{$id}}",
                    id: "new",
                    action: "update",
                    file_name: '',
                    table_name: 'cost_doc',
                    url: ''
                }
            );
        },
        deleteRecordCostTransportDetail(item) {
            item.action = "delete";
        },
        addRecordCostTransportDetail() {
            this.listProject.push(
                {
                    date: "{{date('Y-m-d')}}",
                    doc_id: "{{$id}}",
                    id: "new",
                    name: "",
                    note: "",
                    place_from: "",
                    place_to: "",
                    price: 0,
                    type: 1,
                    action: "update"
                }
            );
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';
            conditionSearch += '&doc_id=' + this.item_id;
            conditionSearch += '&showcount=' + this.showCount; 
            this.conditionSearch = conditionSearch;    
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListCostTransportDetail')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.listProject = [];
                        data.data.map(item => {
                            that.listProject.push(
                                {
                                    date: item.date,
                                    doc_id: item.doc_id,
                                    id: item.id,
                                    name: item.name,
                                    note: item.note,
                                    place_from: item.place_from,
                                    place_to: item.place_to,
                                    price: item.price,
                                    type: item.type,
                                    action: "update"
                                }
                            );
                        });
                        that.daycount = data.daycount;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.listProject = [];
                        that.daycount = 0;
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
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListDocFile')}}?item_id="+ this.item_id + "&table_name=cost_doc",
                success: function(data) {
                    if (data.count > 0) {
                        that.listDocFile = [];
                        data.data.map(item => {
                            that.listDocFile.push(
                                {
                                    id: item.id,
                                    action: "update",
                                    file_name: item.file_name,
                                    item_id: item.item_id,
                                    table_name: item.table_name,
                                    url: item.url
                                }
                            );
                        });
                    } else {
                        that.listProject = [];
                    }
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
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
        },
        onPrePageSales() {
            if (this.pageSales > 1) {
                this.pageSales = this.pageSales - 1;
            }
            this.onGetSalesPage();
        },
        onNextPageSales() {
            if (this.pageSales < this.countSales) {
                this.pageSales = this.pageSales + 1;
            }
            this.onGetSalesPage();
        },
        
        onPageChangeSales(_p) {
            this.pageSales = _p;
            this.onGetSalesPage();
        },
        onGetSalesPage() {
            this.loadingTableSale = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSale != '') {
                conditionSearch += '&name=' + this.conditionNameSale;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCtvJobs')}}?page=" + this.pageSales  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countSales = data.pageTotal;
                        that.listSales = data.data;
                    } else {
                        that.countSales = 0;
                        that.listSales = [];
                    }
                    that.loadingTableSale = 0;
                    let pageArr = [];
                    if (that.pageSales - 2 > 0) {
                        pageArr.push(that.pageSales - 2);
                    }
                    if (that.pageSales - 1 > 0) {
                        pageArr.push(that.pageSales - 1);
                    }
                    pageArr.push(that.pageSales);
                    if (that.pageSales + 1 <= that.count) {
                        pageArr.push(that.pageSales + 1);
                    }
                    if (that.pageSales + 2 <= that.countSales) {
                        pageArr.push(that.pageSales + 2);
                    }
                    that.listPageSales = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        },
        
        onPrePageCustomer() {
            if (this.pageCustomer > 1) {
                this.pageCustomer = this.pageCustomer - 1;
            }
            this.onGetCustomerPage();
        },
        onNextPageCustomer() {
            if (this.pageCustomer < this.countCustomer) {
                this.pageCustomer = this.pageCustomer + 1;
            }
            this.onGetCustomerPage();
        },
        
        onPageChangeCustomer(_p) {
            this.pageCustomer = _p; 
            this.onGetCustomerPage();
        },
        onGetCustomerPage() {
            this.loadingTableCustomer = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionNameSCustomer != '') {
                conditionSearch += '&name=' + this.conditionNameCustomer;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.pageCustomer  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.countCustomer = data.pageTotal;
                        that.listCustomer = data.data;
                    } else {
                        that.countCustomer = 0;
                        that.listCustomer = [];
                    }
                    that.loadingTableCustomer = 0;
                    let pageArr = [];
                    // if (that.pageCustomer - 2 > 0) {
                    //     pageArr.push(that.pageCustomer - 2);
                    // }
                    // if (that.pageCustomer - 1 > 0) {
                    //     pageArr.push(that.pageCustomer - 1);
                    // }
                    // pageArr.push(that.pageCustomer);
                    // if (that.pageCustomer + 1 <= that.count) {
                    //     pageArr.push(that.pageCustomer + 1);
                    // }
                    // if (that.pageCustomer + 2 <= that.countCustomer) {
                    //     pageArr.push(that.pageCustomer + 2);
                    // }
                    for (let index = 1; index <= data.pageTotal; index++) {
                        pageArr.push(index);
                        
                    }
                    that.listPageCustomer = pageArr;
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        }


    },
});
</script>

@stop
