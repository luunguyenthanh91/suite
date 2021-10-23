@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '営業者ビュー')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header_mobile')
    @include('admin.component.footer_mobile')
	
    <div id="list-data">
        <div class="modal fade" id="leftMenu">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.menu') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="page-separator">
                            <div class="page-separator__text">{{ trans("label.submit_approve") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12" style="margin-top:15px;margin-bottom:15px;">
                                <table class="signTable">
                                    <tr>
                                        <td class="signTableThCreator">{{ trans('label.create_user') }}</td>
                                        <td class="signTableThChecker">{{ trans('label.checker') }}</td>
                                        <td class="signTableThApprover">{{ trans('label.approver') }}</td>
                                    </tr>    
                                    <tr>
                                        <td class="signTableDate approveDateGroup">
                                        {{@$data->created_at}}
                                        </td>
                                        <td class="signTableDate approveDateGroup">
                                        {{@$data->checked_date}}
                                        </td>
                                        <td class="signTableDate approveDateGroup">
                                        {{@$data->date_update}}
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td class="signTableTd">
                                            <div class="plusRed">
                                                <div class="circle">{{@$data->creator}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="signTableTd">
                                            <a type="button" class="btn btn-outline-secondary signButtonCheck" @click="promoteCheck('{{$id}}')" v-if="'{{@$data->checked_date}}' == ''">
                                                {{ trans('label.sign') }}
                                            </a> 
                                            <div class="plusRed" v-if="'{{@$data->checked_date}}' != ''">
                                                <div class="circle">{{@$data->checker}}</div>
                                            </div>
                                        </td>
                                        <td class="signTableTd">
                                            <a type="button" class="btn btn-outline-secondary signButton" @click="promoteApprove('{{$id}}')" v-if="'{{@$data->date_update}}' == ''">
                                            {{ trans('label.sign') }}
                                            </a> 
                                            <div class="plusRed" v-if="'{{@$data->date_update}}' != ''">
                                                <div class="circle">{{@$data->approver}}</div>
                                            </div>
                                        </td>
                                    </tr>     
                                </table>   
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                <a type="button" class="btn btn-outline-secondary3"  style="background:#9863ed" @click="copyClipboadCTV(data)">
                    <i class="fa fa-clipboard"><span class="labelButton">{{ trans('label.copy_clipboard') }}</span></i>
                </a>
                <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/partner-sale-update/{{$id}}">
                    <i class="fas fa-edit"><span class="labelButton">{{ trans('label.edit') }}</span></i>
                </a>
                @if (Auth::guard('admin')->user()->id == 1 )
                <a type="button" class="btn btn-outline-secondary3" style="background:red" @click="deleteRecore('{{$id}}')">
                    <i class="fas fa-trash-alt"><span class="labelButton">{{ trans('label.delete') }}</span></i>
                </a> 
                @endif  
                <div class="vl3"></div> 
                <a type="button" class="btn btn-outline-secondary3 menuButtonMobile" data-toggle="modal" data-target="#leftMenu">
                    <i class="fas fa-th-large"></i>
                </a> 
            </div>
        </div>
        <div class="col-lg-12">
            <div style="col-lg-auto">
                <div style="width:100%;text-align:left !important;">
                <label>
                    {{ trans('label.id_intepreter') }}{{@$data->id}} (
                    <span v-if='{{@$data->status}} == 0 || {{@$data->status}} == ""'>{{ trans('label.status_not') }}</span>
                    <span v-if='{{@$data->status}} == 1'>{{ trans('label.status_yes') }}</span>
                    <span v-if='{{@$data->status}} == 2'>{{ trans('label.status_cancel') }}</span>
                    )
                </label>
                <br>
                <label><u>(( parseName('{{@$data->name}}') ))</u></label>
                <br>
                <label>{{@$data->address}}</label><br>
                <label>{{ trans('label.tel2') }}: (( parsePhone('{{@$data->phone}}') ))</label>
                </div>
            </div>
        </div>
        <div class="container page__container page-section page_container_custom">
            <div class="col-lg-12">
                <div class="card dashboard-area-tabs p-relative o-hidden projectViewMobile">
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
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab2">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.bank_name1') }}</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a data-toggle="tab" role="tab" aria-selected="false" class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab3">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">{{ trans('label.project') }}</strong>
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
                                            <td>{{ trans('label.id_intepreter') }}</td>
                                            <td>
                                                {{@$data->id}}
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.status') }}</td>
                                            <td>
                                                @if ( @$data->status == 0 )
                                                    <span>{{ trans('label.status_not') }}</span>
                                                @endif
                                                @if ( @$data->status == 1 )
                                                    <span>{{ trans('label.status_yes') }}</span>
                                                @endif
                                                @if ( @$data->status == 2 )
                                                    <span>{{ trans('label.status_cancel') }}</span>
                                                @endif
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>{{ trans('label.name') }}</td>
                                            <td>
                                            (( parseName('{{@$data->name}}') ))
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.address') }}</td>
                                            <td>
                                            (( parseAddr('{{$data->address}}') ))
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.tel') }}</td>
                                            <td>
                                            (( parsePhone('{{@$data->phone}}') ))
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('label.email') }}</td>
                                            <td>
                                            {{@$data->email}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >{{ trans('label.id_customer') }}</td>
                                            <td>
                                                @if ( @$data->customer_id != '' )
                                                    <a target="_blank" href="/admin/customer-view/{{@$data->customer_id}}">
                                                    {{@$data->customer_id}} ( {{@$data->customer_name}} )
                                                    </a>
                                                @endif
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
                        <div class="tab-pane" id="detailtab2">
                            <div class="row">     
                            <table class="table thead-border-top-0 table-nowrap table-mobile propertiesTables">   
                                        <tr>
                                            <td>{{ trans('label.bank_account_name') }}</td>
                                            <td>
                                            {{@$data->ten_bank}} @if(@$data->ms_nganhang)<span>({{ trans('label.bank_account_code') }}:{{@$data->ms_nganhang}})</span>@endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >{{ trans('label.bank_branch_name') }}</td>
                                            <td>
                                            {{@$data->chinhanh}} @if(@$data->ms_chinhanh)({{ trans('label.bank_branch_code') }}:{{@$data->ms_chinhanh}})@endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >{{ trans('label.bank_number') }}</td>
                                            <td>
                                            {{@$data->stk}} 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td >{{ trans('label.bank_sign') }}</td>
                                            <td>
                                            {{@$data->ten_chutaikhoan}} 
                                            </td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="detailtab3">
                            <div class="gridControl">
                                <label class="form-label">{{ trans('label.number_show') }}</label>
                                <select id="showCount" @change="someHandlerChangeShowCount()" v-model="showCount" >
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="0">全て</option>
                                </select>
                                <label class="form-label">of ((sumCount)) {{ trans('label.ken') }}</label>
                            </div>
                            <div class="row">
                                <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                            <th scope="col" @click="sort('id')" >
                                                <div v-bind:class="[sortBy === 'id' ? sortDirection : '']">{{ trans('label.project') }}</div>
                                            </th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="search">
                                            <tr v-for="item in sortedProducts">
                                                <td :class="item.classStyle  + ' sticky-col fix-col1-detail'" style="left:0px">
                                                    <div v-for="itemCTV in item.ctv_sales_list">
                                                        <u><b>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}</b></u><br>
                                                    </div>
                                                    <a target="_blank" :href="'/admin/projectview/' + item.id">
                                                    {{ trans('label.id') }}((item.id)) (<span v-if='item.status == 0 || item.status == ""'>{{ trans('label.status0') }}</span>
                                                        <span v-if='item.status == 1'>{{ trans('label.status1') }}</span>
                                                        <span v-if='item.status == 2'>{{ trans('label.status2') }}</span>
                                                        <span v-if='item.status == 3'>{{ trans('label.status3') }}</span>
                                                        <span v-if='item.status == 8'>{{ trans('label.status8') }}</span>
                                                        <span v-if='item.status == 4'>{{ trans('label.status4') }}</span>
                                                        <span v-if='item.status == 5'>{{ trans('label.status5') }}</span>
                                                        <span v-if='item.status == 6'>{{ trans('label.status6') }}</span>
                                                        <span v-if='item.status == 7'>{{ trans('label.status7') }}</span>
                                                        )
                                                    </a>
                                                    <div v-for="ngayPD in item.ngay_pd_list">
                                                        (( ngayPD )) ((item.address_pd))
                                                    </div>
                                                    <div v-for="itemCTV in item.ctv_list">
                                                        <div >(( parseName(itemCTV.name) ))</div>
                                                    </div>
                                                    {{ trans('label.sale_cost') }}: (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(item.sumPhiSale) ))<br>
                                                    <span v-for="itemCTV in item.ctv_sales_list" >
                                                    {{ trans('label.bank_date') }}: ((itemCTV.ngay_chuyen_khoan)) (<span v-for="itemCTV in item.ctv_list" >
                                                            (( convertStatusBank(itemCTV.status) ))
                                                        </span>)
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>      
                                    <div class="card-footer p-8pt">
                                        <ul class="pagination justify-content-start pagination-xsm m-0">
                                            <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''"
                                                @click="onPrePage()">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                    <span>{{ trans('label.pre_page') }}</span>
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
                                                    <span>{{ trans('label.next_page') }}</span>
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
                    url: "/admin/salecheck/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "更新しました!"
                        });
                        location.href = "/admin/partner-sale-view/" + _i;
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
                    url: "/admin/saleapprove/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "更新しました!"
                        });
                        location.href = "/admin/partner-sale-view/" + _i;
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
                    url: "/admin/partner-sale-delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/partner-sale";
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
            
            conditionSearch += '&ctv_sale_id=' + this.sale_id;
            conditionSearch += '&showcount=' + this.showCount; 
            this.conditionSearch = conditionSearch;          

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListProject')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.listProject = data.data;
                        that.sumCount = data.count;

                        that.sumTienPhienDich= data.sumTienPhienDich ;
                        that.sumTongThuDuKien = data.sumTongThuDuKien;
                        that.sumCost=data.sumCost ;
                        that.sumCostSale= data.sumCostSale ;
                        that.sumCostInterpreter= data.sumCostInterpreter ;
                        that.sumCostIncomeTax= data.sumCostIncomeTax ;
                        that.sumCostMoveFee= data.sumCostMoveFee ;
                        that.sumCostBankFee= data.sumCostBankFee ;
                        that.sumEarning= data.sumEarning ;
                        that.sumBenefit= data.sumBenefit ;
                        that.sumDeposit= data.sumDeposit ;
                        that.sumTongKimDuocDuKien = data.sumTongKimDuocDuKien;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.listProject = [];

                        this.sumTienPhienDich= 0;
                        this.sumTongThuDuKien =0;
                        this.sumCost=0;
                        this.sumCostSale= 0;
                        this.sumCostInterpreter= 0;
                        this.sumCostIncomeTax= 0;
                        this.sumCostMoveFee= 0;
                        this.sumCostBankFee= 0;
                        this.sumEarning= 0;
                        this.sumBenefit= 0;
                        this.sumDeposit= 0;
                        this.sumTongKimDuocDuKien =0;
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
