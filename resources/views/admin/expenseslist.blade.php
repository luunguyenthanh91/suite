@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '経費管理表')

<div class="mdk-drawer-layout__content page-content page-notscrool3">
    <!-- header    -->
    @include('admin.component.header')

    <!-- content -->
    <div id="list-data">
        <!-- mobile search bar     -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                    <!-- Modal Header -->
                    <div class="modal-header bgTotal">
                        <h5 class="modal-title" style="width:100%; text-align:center;">検索詳細</h5>
                        <span class="material-icons" style="color:white;z-index:10px;"　data-dismiss="modal">&times;</span>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <div class="row standardColorSearch">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">月</label>
                                    <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_bat_dau">
                                </div>
                            </div>
                            <div class="row standardColorSearch">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">月から</label>
                                    <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_bat_dau_from">
                                </div>
                            </div>
                            <div class="row standardColorSearch">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">月まで</label>
                                    <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_bat_dau_to">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12 textAlignCenter">
                                    <a type="button" class="btn btn-outline-secondary3" style="background:#673FF7" @click="someHandlerChange()">
                                        <i class="fas fa-search"><span class="labelButton">検索</span></i>
                                    </a> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer bgTotal">
                        <button type="button" @click="clearSearch()" class="btn btn-danger" >クリア</button>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- button control -->
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:green" href="/admin/expensesnew">
                <i class="fa fa-plus-square"><span class="labelButton">新規登録</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:DarkTurquoise" :href="'/admin/expenses-pdf?' + conditionSearch">
                <i class="fa fa-plus-square"><span class="labelButton">経費一覧表(PDF)</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:#F119D4" data-toggle="modal" data-target="#myModal">
                <i class="fas fa-search"><span class="labelButton">検索</span></i>
            </a>     
        </div>

        <!-- data content -->
        <div class="container page__container page-section page_container_custom" :style="'margin-top: ' + marginTop">
            <div class="row page_container_custom_marginright">
                <div :class="''+classColLG12">
                    <div :class="'' + classBodayRightContentGrid">
                        <!-- grid control -->
                        <div class="gridControl">
                            <h5 class="threadLabelCenter">経費合計：(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumPay) ))</h5>
                            <label class="form-label">表示件数</label>
                            <select id="showCount" @change="someHandlerChangeShowCount()" v-model="showCount" >
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="0">全て</option>
                            </select>
                            <label class="form-label">of ((sumCount)) 件</label> 
                            <br>
                            <label class="form-label">並び替え</label>
                            <select @change="someHandlerChangeSortName()" v-model="sortNameSelect">
                                <option value="1" >月の降順</option>
                                <option value="2" >月の昇順</option>
                            </select>
                            <label class="form-label labelSwitchShow">表示切替</label>
                            <a type="button" class="btn btn-outline-secondary2" style="background:#DB7C18" @click="switchView()" v-if='type_show == 1'>
                                <i class="fas fa-mobile-alt"></i>
                            </a>
                            <a type="button" class="btn btn-outline-secondary2" style="background:#DB7C18" @click="switchView()" v-if='type_show == 2'>
                                <i class="fas fa-desktop"></i>
                            </a>
                        </div>

                        <!-- grid content -->
                        <div class="bodyContent">
                            <!-- grid left bar -->
                            <div class="bodyContentLeft tableFixHead">
                            <table class="table mb-0 thead-border-top-0 table-nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="fullWidth flex-center">
                                                    <div class="threadLabelCenter">検索</div>
                                                    <i class="fas fa-undo-alt mt-1" @click="clearSearch()"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>
                                                <div class="row standardColorSearch">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">月</label>
                                                        <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_bat_dau">
                                                    </div>
                                                </div>
                                                <div class="row standardColorSearch">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">月から</label>
                                                        <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_bat_dau_from">
                                                    </div>
                                                </div>
                                                <div class="row standardColorSearch">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">月まで</label>
                                                        <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_bat_dau_to">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12 textAlignCenter">
                                                        <a type="button" class="btn btn-outline-secondary3" style="background:#673FF7" @click="someHandlerChange()">
                                                            <i class="fas fa-search"><span class="labelButton">検索</span></i>
                                                        </a> 
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                            </div>

                            <!-- grid right bar -->
                            <div class="bodyContentRight tableFixHead">
                            <table id="gridTable" class="table thead-border-top-0 table-nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width:100%;" v-if='type_show == 2'>
                                                    <div class="threadLabelCenter">経費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="threadLabelCenter" id="lblOrderNumber">月 ▼</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">経費合計</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">租税公課</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">修繕費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">水道光熱費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">保険料</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">消耗品費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">法定福利費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">給料賃金</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">地代家賃</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">外注工賃</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">支払手数料</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">旅費交通費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">開業費/創立費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">通信費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">接待交際費</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="textAlignR">その他</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1' style="width: 100%; "></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="search">
                                            <tr v-for="item in list">
                                                <td v-if='type_show == 2' :class="item.classStyle + ' p-0 pl-2 pb-2 fullWidth'">
                                                    <p class="rowContent">
                                                        <table class="m-0 table thead-border-top-0 table-nowrap table-mobile">
                                                            <tr>
                                                                <td class="titleTd">月：</td>
                                                                <td>
                                                                    ((item.date))<br>
                                                                    <a type="button" class="btn btn-outline-secondary3" style="background:purple" target="_blank" :href="'/admin/expenses-detail/' + item.id">
                                                                        <i class="fas fa-info-circle"><span class="labelButton">詳細</span></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">租税公課：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog1) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">修繕費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog2) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">水道光熱費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog3) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">保険料：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog4) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">消耗品費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog5) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">法定福利費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog6) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">給料賃金：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog7) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">地代家賃：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog8) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">外注工賃：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog9) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">支払手数料：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog10) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">旅費交通費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog11) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">開業費/創立費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog12) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">通信費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog13) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">接待交際費：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog14) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">その他：</td>
                                                                <td>
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog15) ))
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-top:1px solid #CCC" class="titleTd">費用合計：</td>
                                                                <td style="border-top:1px solid #CCC">
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price) ))
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td v-if='type_show == 1' style="background:Lavender">
                                                    ((item.date))<br>
                                                    <a type="button" class="btn btn-outline-secondary3" style="background:purple" target="_blank" :href="'/admin/expenses-detail/' + item.id">
                                                        <i class="fas fa-info-circle"><span class="labelButton">詳細</span></i>
                                                    </a>
                                                    <br>
                                                    <a type="button" class="btn btn-outline-secondary3" style="background:green" :href="'/admin/expenses-detail-pdf/' + item.id">
                                                        <i class="fa fa-file-pdf"><span class="labelButton">経費支払月報(PDF)</span></i>
                                                    </a>
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1' style="background:Lavender">
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog1) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog2) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog3) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog4) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog5) ))
                                                </td>
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog6) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog7) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog8) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog9) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog10) ))
                                                </td>
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog11) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog12) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog13) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog14) ))
                                                </td>
                                                
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.typeLog15) ))
                                                </td>
                                                <td v-if='type_show == 1'></td>
                                            </tr>
                                        </tbody>
                                    </table>                       
                                <div class="card-footer p-8pt">
                                    <ul class="pagination justify-content-start pagination-xsm m-0">
                                        <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''"
                                            @click="onPrePage()">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                <span>前のページ</span>
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
                                                <span>次のページ</span>
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
    
    <!-- copy clipboard -->
    <div id="error-details" style="display:none">
        <span id="copyName"></span><br>
        <span id="copyFurigana"></span><br>
        <span id="copyPhone"></span><br>
    </div>

    <!-- Footer -->
    @include('admin.component.footer')
</div>

<!-- menu -->
@include('admin.component.left-bar')
@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        conditionSearch: '',
        count: 0,
        page: 1,
        list: [],
        sumCount: 0,
        listPage: [],
        conditionName: '',
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        groups: [],
        conditionStatus: '',
        conditionAddress: '',
        ngay_phien_dich: '',
		thang_phien_dich: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        dateOrder_month: "{{date('Y-m')}}",
        codeJobs: '',
        checkedNames: [0,1,2,3,4,5,6,7,8],
		checkedTypes: [1,2,3],
        checkedCTVSex: [1,2],
        sortName: '',
        sortType:"DESC",
        sortNameSelect : '1',
        showCount: '20',
        isMobile : ( viewPC )? false : true,
        type_show: ( viewPC )? 1 : 2,
        checkAkaji: 0,
        marginTop: "30px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classBodayRightContentGrid: (viewPC)? "bodayRightContentGrid" : "",
        classColLG12: (viewPC)? "col-lg-12" : "",
        ngay_bat_dau: '',
        ngay_bat_dau_from: '',
        ngay_bat_dau_to: '',
        sumPay: 0
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
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
            var url = baseUrl + "/projectview/" + _i.id;
            $('#copyName').html(url);
            $('#copyFurigana').html("");
            $('#copyPhone').html("");

            this.execCopyClipboad();
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChange: function() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChangeShowCount() {
            this.page = 1;
            this.onLoadPagination();
        },
        someHandlerChangeSortName: function () {
            var selVal = this.sortNameSelect;
            
            var sName = "parent_chitien.date";
            var sType = "DESC";
            var lblOrderNumber = "月";
            switch (selVal) {
                case "1":
                    sName = "parent_chitien.date";
                    sType = "DESC";
                    lblOrderNumber = "月 ▼";
                    break;
                case "2":
                    sName = "parent_chitien.date";
                    sType = "ASC";
                    lblOrderNumber = "月 ▲";
                    break;
            }

            this.sortName = sName;
            this.sortType = sType;
            $("#lblOrderNumber").text(lblOrderNumber);   
            
            this.page = 1;
            this.onLoadPagination();
        },
        switchView: function() {
            this.type_show = (this.type_show == 1) ? 2 : 1;
        },
        resetSearch() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.dateOrder_month = "{{date('Y-m')}}";
            this.ngay_phien_dich = '';
			this.thang_phien_dich = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,7,8];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";    
            this.checkAkaji= 0;   

            this.ngay_bat_dau = '';
            this.ngay_bat_dau_from = '';
            this.ngay_bat_dau_to = '';
            
            this.onLoadPagination();
        },
        clearSearch() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.dateOrder_month = '';
            this.ngay_phien_dich = '';
			this.thang_phien_dich = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,7,8];
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;     

            this.ngay_bat_dau = '';
            this.ngay_bat_dau_from = '';
            this.ngay_bat_dau_to = '';
            
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            this.onLoadPagination();
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,7,8];
            this.onLoadPagination();
		},
		clearSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [];
            this.onLoadPagination();
		},
		setSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [1,2,3];
            this.onLoadPagination();
		},
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
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
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(6, 4);
            } else if (vLength == 10) {
                value = value.substr(0, 3) + S_HYPEN + value.substr(3, 4) + S_HYPEN + value.substr(6, 3);
            }
            return value;
        },
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.ngay_bat_dau != '') {
                conditionSearch += '&ngay_bat_dau=' + this.ngay_bat_dau;
            }
            if (this.ngay_bat_dau_from != '') {
                conditionSearch += '&ngay_bat_dau_from=' + this.ngay_bat_dau_from;
            }
            if (this.ngay_bat_dau_to != '') {
                conditionSearch += '&ngay_bat_dau_to=' + this.ngay_bat_dau_to;
            }
            conditionSearch += '&showcount=' + this.showCount;  
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;                
            } 
            this.conditionSearch = conditionSearch; 

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListExpenses')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                        that.sumPay = data.totalPrice;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
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
        }
    },
});
</script>

@stop