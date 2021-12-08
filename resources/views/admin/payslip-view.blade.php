@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '給与明細ビュー')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header')	
	
    <div id="list-data">
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:#FF8C00" target="_blank" href="/admin/payslip-pdf/{{$id}}">
                <i class="fa fa-file-pdf"><span class="labelButton">{{ trans('label.payslip_pdf') }}</span></i>
            </a>  
            @if (Auth::guard('admin')->user()->id == 1 || $data->status == 0 || $data->status == 1)
            <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/payslip-update/{{$id}}">
                <i class="fas fa-edit"><span class="labelButton">{{ trans('label.edit') }}</span></i>
            </a>
            @endif  
            @if (Auth::guard('admin')->user()->id == 1 || $data->status == 0 || $data->status == 1)
            <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="deleteRecore('{{$id}}')">
                <i class="fas fa-trash-alt"><span class="labelButton">{{ trans('label.delete') }}</span></i>
            </a> 
            @endif      
        </div>
        <div class="container page__container page-section page_container_custom">
            <div class="gridControl3">
                <div class="d-flex" style="width:100%;">
                    <div style="width:100%;text-align:left !important;">
                        <div class="col-lg-12" >
                            <label>
                            <u>
                                {{ trans('label.payslip_id') }}{{@$data->id}} (
                                <span v-if='{{@$data->status}} == 0 || {{@$data->status}} == ""'>{{ trans('label.ws_status1') }}</span>
                                <span v-if='{{@$data->status}} == 1'>{{ trans('label.ws_status2') }}</span>
                                <span v-if='{{@$data->status}} == 2'>{{ trans('label.ws_status3') }}</span>
                                <span v-if='{{@$data->status}} == 3'>{{ trans('label.ws_status4') }}</span>
                                <span v-if='{{@$data->status}} == 4'>{{ trans('label.ws_status5') }}</span>
                                )
                            </u>
                            </label>
                            <br>
                            <label>(( parseMonth('{{@$data->month}}') )) {{@$data->employee_depname}} {{@$data->employee_name}} ({{@$data->user_id}})</label>
                            <br>
                            <label>{{ trans('label.pay_day') }}: {{@$data->pay_day}}</label>
                            <br>
                            <label>{{ trans('label.pay_total') }}: (( parseMoney({{@$data->pay_total}}) ))</label>
                            </div>
                    </div>
                    <div class="col-lg-auto">
                        <table class="signTable">
                            <tr>
                                <td class="signTableThCreator">{{ trans('label.created_by') }}</td>
                                <td class="signTableThChecker">{{ trans('label.checked_by') }}</td>
                                <td class="signTableThApprover">{{ trans('label.approved_by') }}</td>
                            </tr>    
                            <tr>
                                <td class="signTableDate approveDateGroup">
                                {{@$data->created_on}}
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
                                    <a type="button" class="btn btn-outline-secondary signButtonCheck" @click="promoteCheck('{{$id}}')" v-if="'{{@$data->checked_on}}' == ''">
                                        {{ trans('label.check') }}
                                    </a> 
                                    <div class="plusRed" v-if="'{{@$data->checked_on}}' != ''">
                                        <div class="circle">{{@$data->checked_by_sign}}</div>
                                    </div>
                                </td>
                                <td class="signTableTd">
                                    <a type="button" class="btn btn-outline-secondary signButton" @click="promoteApprove('{{$id}}')" v-if="'{{@$data->approved_on}}' == ''">
                                    {{ trans('label.approve') }}
                                    </a> 
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
                                        <strong class="card-title">{{ trans('label.ws') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab4">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.plus') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab5">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.minus') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab6">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.pay_sum') }}</strong>
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
                                                <td>{{ trans('label.payslip_id') }}</td>
                                                <td>
                                                    {{@$data->id}}
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.status') }}</td>
                                                <td>
                                                    @if ( @$data->status == 0 )
                                                        <span>{{ trans('label.ws_status1') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 1 )
                                                        <span>{{ trans('label.ws_status2') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 2 )
                                                        <span>{{ trans('label.ws_status3') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 3 )
                                                        <span>{{ trans('label.ws_status4') }}</span>
                                                    @endif
                                                    @if ( @$data->status == 4 )
                                                        <span>{{ trans('label.close2') }}</span>
                                                    @endif
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td>{{ trans('label.month') }}</td>
                                                <td>
                                                {{$data->month}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.employee_depname') }}</td>
                                                <td>
                                                (( parseName('{{@$data->employee_depname}}') ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.user_id') }}</td>
                                                <td>
                                                (( parseName('{{@$data->user_id}}') ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.user_name') }}</td>
                                                <td>
                                                (( parseName('{{@$data->employee_name}}') ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.pay_day') }}</td>
                                                <td>
                                                {{@$data->pay_day}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.pay_total') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->pay_total}}) ))
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
                                        <div class="page-separator__text bgWhite">{{ trans("label.approve_col") }}</div>
                                    </div>
                                    <div class="card">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
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
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                        
                                            <tr>
                                                <td>{{ trans('label.worksheet_id') }}</td>
                                                <td>
                                                <a target="_blank" href="/admin/worksheet-view/{{@$data->worksheet_id}}">
                                                    {{@$data->worksheet_id}}
                                                </a>
                                                </td>
                                            </tr>    
                                            <tr>
                                                <td>{{ trans('label.work_day_count') }}</td>
                                                <td>
                                                {{@$data->daycount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.work_time_count') }}</td>
                                                <td>
                                                {{@$data->worktimecount}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.work_overtime_count') }}</td>
                                                <td>
                                                {{@$data->overworktimecount}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.kihonkyu') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->kihonkyu}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.zangyou_teate') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->zangyou_teate}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.tsukin_teate') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->tsukin_teate}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.plus_zei_total') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->plus_zei_total}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.plus_nozei_total') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->plus_nozei_total}}) ))
                                                </td>
                                            </tr>
                                            <tr>                                                
                                                <td>{{ trans('label.plus_total') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->plus_total}}) ))
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab5">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.kenkouhoken') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->kenkouhoken}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.koseinenkin') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->koseinenkin}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.koyohoken') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->koyohoken}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.shotokuzei') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->shotokuzei}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.juminzei') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->juminzei}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.minus_total') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->minus_total}}) ))
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                            <tr>
                                                <td>{{ trans('label.pay_total1') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->sum_pay}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.pay_total4') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->sum_shakaihoken}}) ))
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ trans('label.pay_total3') }}</td>
                                                <td>
                                                (( parseMoney({{@$data->sum_tax}}) ))
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

        
    
    });
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
        sale_id: '{{@$data->id}}',
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
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            // if (this.ctv_pd != '') {
            //     conditionSearch += '&ctv_pd=' + this.ctv_pd;
            // }
            
            conditionSearch += '&month=' + this.month;
            conditionSearch += '&user_id=' + this.user_id;
            conditionSearch += '&showcount=' + this.showCount; 
            this.conditionSearch = conditionSearch;          

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListWorkDays')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.listProject = data.data;
                        that.daycount = data.daycount;
                        that.worktimecount = data.worktimecount;
                        that.overworktimecount = data.overworktimecount;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.listProject = [];
                        that.daycount = 0;
                        that.worktimecount = 0;
                        that.overworktimecount = 0;
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
