@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '立替金申請ビュー')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header')	
	
    <div id="list-data">
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3 background_sub_1" target="_blank" href="/admin/billprepay-pdf/{{$id}}">
                <i class="fa fa-file-pdf"><span class="labelButton">{{ trans('label.billprepay_pdf') }}</span></i>
            </a>
            @if (Auth::guard('admin')->user()->type == 1)
            <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/billprepay-update/{{$id}}">
                <i class="fas fa-edit"><span class="labelButton">{{ trans('label.edit') }}</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="deleteRecore('{{$id}}')">
                <i class="fas fa-trash-alt"><span class="labelButton">{{ trans('label.delete') }}</span></i>
            </a> 
            @endif      
        </div>
        <div class="container page__container page-section page_container_custom">
            <div class="gridControl3">
                <div class="d-flex" style="width:100%;">
                    <div class="col-lg-auto cardTopViewArea">
                        <div class="card cardTopView">
                            <table>
                                <tr>
                                    <td>{{ trans('label.submited_by') }}:</td>
                                    <td>{{@$data->employee_depname}} {{@$data->employee_name}} ({{@$data->employee_code}})</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('label.submited_on') }}:</td>
                                    <td>{{@$data->submited_on}}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('label.content') }}:</td>
                                    <td>{{@$data->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('label.money') }}:</td>
                                    <td>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(sumprice) ))</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="width:100%;text-align:left !important;">

                    </div>
                    <div class="col-lg-auto">
                        <table class="signTable" style="width:270px;">
                            <tr>
                                <td class="signTableThCreator">{{ trans('label.created_by') }}</td>
                                <td class="signTableThChecker">{{ trans('label.submited_by') }}</td>
                                <td class="signTableThChecker">{{ trans('label.checked_by') }}</td>
                                <td class="signTableThApprover">{{ trans('label.approved_by') }}</td>
                            </tr>    
                            <tr>
                                <td class="signTableDate approveDateGroup">
                                {{@$data->created_on}}
                                </td>
                                <td class="signTableDate approveDateGroup">
                                {{@$data->submited_on}}
                                </td>
                                <td class="signTableDate approveDateGroup">
                                {{@$data->checked_on}}
                                </td>
                                <td class="signTableDate approveDateGroup">
                                {{@$data->approved_on}}
                                </td>
                            </tr> 
                            <tr>
                                <td class="signTableTd">
                                    <div class="plusRed">
                                        <div class="circle">{{@$data->created_by_sign}}</div>
                                    </div>
                                </td>
                                <td class="signTableTd">
                                    <a type="button" class="btn btn-outline-secondary signButtonSubmit" @click="promoteSubmit('{{$id}}')" v-if="'{{@$data->submited_on}}' == ''">
                                        {{ trans('label.submit') }}
                                    </a> 
                                    <div class="plusRed" v-if="'{{@$data->submited_on}}' != ''">
                                        <div class="circle">{{@$data->submited_by_sign}}</div>
                                    </div>
                                </td>
                                <td class="signTableTd">
                                    <div class="plusRed" v-if="'{{@$data->checked_on}}' != ''">
                                        <div class="circle">{{@$data->checked_by_sign}}</div>
                                    </div>
                                </td>
                                <td class="signTableTd">
                                    <div class="plusRed" v-if="'{{@$data->approved_on}}' != ''">
                                        <div class="circle">{{@$data->approved_by_sign}}</div>
                                    </div>
                                </td>
                            </tr>     
                        </table>
                    </div>
                </div>
            </div>    
            <div class="col-lg-12">
                <div class="card dashboard-area-tabs p-relative o-hidden projectView">
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
                                                <td>{{ trans('label.request_cost_id') }}</td>
                                                <td>
                                                    {{@$data->id}}
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.submited_on') }}</td>
                                                <td>
                                                {{@$data->submited_on}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.submited_by') }}</td>
                                                <td>
                                                {{@$data->employee_depname}} (( parseName('{{@$data->employee_name}}') )) ({{@$data->employee_code}})
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.content') }}</td>
                                                <td>
                                                {{@$data->name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.money') }}</td>
                                                <td>
                                                (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(sumprice) ))
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.note') }}</td>
                                                <td>
                                                    <div class="text-block" v-html="">
                                                    <p>{!! @$data->note !!}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>  
                                <div class="col-lg-12">
                                    <div class="page-separator">
                                        <div class="page-separator__text bgWhite">{{ trans("label.system_properties") }}</div>
                                    </div>
                                    <div class="card">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.status') }}</td>
                                                <td>
                                                    @if ( @$data->status == 0 )
                                                        <span>{{ trans('label.status0') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 1 )
                                                        <span>{{ trans('label.status1') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 2 )
                                                        <span>{{ trans('label.status2') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 3 )
                                                        <span>{{ trans('label.status3') }}</span>
                                                    @endif
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.created_on') }}</td>
                                                <td>
                                                {{@$data->created_on}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.created_by') }}</td>
                                                <td>
                                                {{@$data->created_by_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.checked_on') }}</td>
                                                <td>
                                                {{@$data->checked_on}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.checked_by') }}</td>
                                                <td>
                                                {{@$data->checked_by_name}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.approved_on') }}</td>
                                                <td>
                                                {{@$data->approved_on}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.approved_by') }}</td>
                                                <td>
                                                {{@$data->approved_by_name}}
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
                                    <div class="card">
                                        <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th  @click="sort('date')" >
                                                        <div v-bind:class="[sortBy === 'date' ? sortDirection : '']">{{ trans('label.cost_date') }}</div>
                                                    </th>
                                                    <th click="sort('place_from')" >
                                                        <div v-bind:class="[sortBy === 'place_from' ? sortDirection : '']">{{ trans('label.costprepay_place') }}</div>
                                                    </th>
                                                    <th  @click="sort('name')" >
                                                        <div v-bind:class="[sortBy === 'name' ? sortDirection : '']">{{ trans('label.costprepay_name') }}</div>
                                                    </th>
                                                    <th @click="sort('price')" class="moneyCol">
                                                        <div v-bind:class="[sortBy === 'price' ? sortDirection : '']">{{ trans('label.price2') }}</div>
                                                    </th>
                                                    <th   @click="sort('note')">
                                                        <div v-bind:class="[sortBy === 'note' ? sortDirection : '']">{{ trans('label.note') }}</div>
                                                    </th>
                                                    <th   style="width: 100%; "></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="search">
                                                <tr v-for="item in sortedProducts">
                                                    <td >
                                                    (( item.date ))
                                                    </td>
                                                    <td  >
                                                    (( item.place_from ))
                                                    </td>
                                                    <td>
                                                    (( item.name ))
                                                    </td>
                                                    <td class="moneyCol">
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(item.price) ))
                                                    
                                                    </td>
                                                    <td>
                                                        <span class="text-block" v-html="item.note">
                                                        (( item.note ))
                                                        </span>
                                                    </td>
                                                    <td style="width: 100%; "></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th  @click="sort('id')" >
                                                        <div v-bind:class="[sortBy === 'id' ? sortDirection : '']">{{ trans('label.file_no') }}</div>
                                                    </th>
                                                    <th @click="sort('url')" >
                                                        <div v-bind:class="[sortBy === 'url' ? sortDirection : '']">{{ trans('label.url') }}</div>
                                                    </th>
                                                    <th   style="width: 100%; "></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="search">
                                                <tr v-for="item in sortedProducts2">
                                                    <td >
                                                    (( item.id ))
                                                    </td>
                                                    <td >
                                                        <a :href="item.url" target="blank">
                                                            (( item.url ))
                                                        </a>
                                                    </td>
                                                    <td style="width: 100%; "></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
        sumprice: 0,
        listProject2: [],
        daycount: 0,
        worktimecount: 0,
        overworktimecount: 0,
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
        this.onLoadPagination();
        this.onLoadPagination2();
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
        },
        sortedProducts2: function(){
            return this.listProject2.sort((p1,p2) => {

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
                    url: "/admin/costtransportsubmit/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "提出の処理が終わりました。"
                        });
                        location.href = "/admin/costtransport-view/" + _i;
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
                title: "\確認済みでよろしいですか？",
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
                    url: "/admin/costtransportcheck/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "確認の処理が終わりました。"
                        });
                        location.href = "/admin/costtransport-view/" + _i;
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
                    url: "/admin/costtransportapprove/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "承認の処理が終わりました。"
                        });
                        location.href = "/admin/costtransport-view/" + _i;
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
                    url: "/admin/costtransport-delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/costtransport";
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
            const that = this;
            let conditionSearch = '';
            conditionSearch += '&doc_id=' + this.item_id;
            this.conditionSearch = conditionSearch;    
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListCostTransportDetail')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.listProject = data.data;
                        that.sumprice = data.sumprice;
                    } else {
                        that.listProject = [];
                        that.sumprice = 0;
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
        onLoadPagination2() {
            const that = this;
            let conditionSearch = '';
            conditionSearch += '&item_id=' + this.item_id;
            conditionSearch += '&table_name=' + 'cost_doc'; 
            this.conditionSearch = conditionSearch;    
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListDocFile')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.listProject2 = data.data;
                    } else {
                        that.listProject2 = [];
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
    },
});
</script>

@stop
