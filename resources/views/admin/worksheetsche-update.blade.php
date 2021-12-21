@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '勤務予定表更新')

<div class="mdk-drawer-layout__content page-content">
    <!-- Header -->
    @include('admin.component.header')

    <!-- content -->
    <div id="list-data">
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:green" @click="onSubmit()">
                <i class="fas fa-save"><span class="labelButton">{{ trans('label.save') }}</span></i>
            </a>
            <a type="button" class="btn btn-outline-secondary3" style="background:red" href="/admin/worksheet-view/{{$id}}">
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
                                                <strong class="card-title">{{ trans('label.worksheet') }}</strong>
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
                                                    <td>{{ trans('label.worksheet_id') }}</td>
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('label.month') }}</td>
                                                    <td>
                                                        (( parseMonth('{{$data->month}}') ))
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
                                                    <td>{{ trans('label.note') }}</td>
                                                    <td>
                                                        <textarea type="text" name="note" class="form-control" rows="10">{{@$data->note}}</textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="detailtab3">
                                    <div class="gridControl">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table id="gridTable" class="table thead-border-top-0 table-nowrap mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" @click="sort('year')">
                                                            <div v-bind:class="[sortBy === 'year' ? sortDirection : '']">{{ trans('label.year') }}</div>
                                                        </th>
                                                        <th @click="sort('month')">
                                                            <div v-bind:class="[sortBy === 'month' ? sortDirection : '']">{{ trans('label.month') }}</div>
                                                        </th>
                                                        <th scope="col" @click="sort('date')">
                                                            <div v-bind:class="[sortBy === 'date' ? sortDirection : '']">{{ trans('label.date') }}</div>
                                                        </th>
                                                        <th scope="col" @click="sort('day')">
                                                            <div v-bind:class="[sortBy === 'day' ? sortDirection : '']">{{ trans('label.day') }}</div>
                                                        </th>
                                                        <th scope="col" @click="sort('ws_type')">
                                                            <div v-bind:class="[sortBy === 'ws_type' ? sortDirection : '']">{{ trans('label.ws_type') }}</div>
                                                        </th>
                                                        <th scope="col" @click="sort('time_start')" class="textAlignCenter">
                                                            <div v-bind:class="[sortBy === 'time_start' ? sortDirection : '']" style="text-align:center">{{ trans('label.time_start') }}</div>
                                                        </th>
                                                        <th scope="col" @click="sort('time_end')" class="textAlignCenter">
                                                            <div v-bind:class="[sortBy === 'time_end' ? sortDirection : '']" style="text-align:center">{{ trans('label.time_end') }}</div>
                                                        </th>
                                                        <th scope="col" @click="sort('note')">
                                                            <div v-bind:class="[sortBy === 'note' ? sortDirection : '']">{{ trans('label.note') }}</div>
                                                        </th>
                                                        <th scope="col" style="width: 100%; "></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="search">
                                                    <tr v-for="item in sortedProducts">
                                                        <td :class="item.classStyle  + ' '">
                                                            (( item.year ))
                                                        </td>
                                                        <td :class="item.classStyle  + ' '">
                                                            (( item.month ))
                                                        </td>
                                                        <td :class="item.classStyle  + ' '">
                                                            (( item.day ))
                                                        </td>
                                                        <td :class="item.classStyle  + ' '">
                                                            (( item.date ))<span v-if="item.offdaytitle"><span class="spaceLabel">(</span>(( item.offdaytitle ))<span>)</span></span>
                                                        </td>
                                                        <td class="textAlignCenter">
                                                            <select style="width:100px;" class="form-control custom-select" :name="'childUpdate['+item.dayid+'][ws_type]'" v-model="item.ws_type">
                                                                <option value="1">{{ trans('label.work_day') }}</option>
                                                                <option value="2">{{ trans('label.do_off_day') }}</option>
                                                            </select>
                                                        </td>
                                                        <td class="textAlignCenter">
                                                            <div v-if="item.ws_type==1">
                                                                <input style="width:70px;text-align:center;" maxlength="2" type="number" v-model="item.starttime_h" :name="'childUpdate['+item.dayid+'][starttime_h]'" />
                                                                <span>:</span>
                                                                <input style="width:70px;text-align:center;" maxlength="2" type="number" v-model="item.starttime_m" :name="'childUpdate['+item.dayid+'][starttime_m]'" />
                                                            </div>
                                                        </td>
                                                        <td class="textAlignCenter">
                                                            <div v-if="item.ws_type==1">
                                                                <input style="width:70px;text-align:center" maxlength="2" type="number" v-model="item.endtime_h" :name="'childUpdate['+item.dayid+'][endtime_h]'" />
                                                                <span>:</span>
                                                                <input style="width:70px;text-align:center;" maxlength="2" type="number" v-model="item.endtime_m" :name="'childUpdate['+item.dayid+'][endtime_m]'" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input v-if="item.starttime || item.ws_type==1" type="text" v-model="item.note" :name="'childUpdate['+item.dayid+'][note]'" />
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
    jQuery(document).ready(function() {
        $('.tab_click').on('click', function() {
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail' + $(this).attr('id')).addClass('active');
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
    #images {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    #images li {
        margin: 10px;
        float: left;
        text-align: center;
        height: 190px;
    }

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
            month: '{{@$data->month}}',
            user_id: '{{@$data->user_id}}',
            loadingTable: 0,
            count: 0,
            page: 1,
            list: [],
            listPage: [],
            conditionName: '',
            jplt: '',
            male: '',
            sortBy: 'codejob',
            sortDirection: 'desc',
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
            objSendMail: [],
            listSendMail: [],
            showListPD: 0,
            showListCus: 0,
            showListCtv: 0,
            isMobile: (viewPC) ? false : true,
            marginTop: "100px;",
            marginLeft: (viewPC) ? "30px;" : "0px;",
            classRowContent: (viewPC) ? "" : "rowContent ",
            price: '',
            listProject: [],
        },
        delimiters: ["((", "))"],
        mounted() {
            const that = this;
            this.onLoadPagination();
        },

        computed: {
            sortedProducts: function() {
                return this.listProject.sort((p1, p2) => {

                    let modifier = 1;
                    if (this.sortDirection === 'desc') modifier = -1;
                    if (this.sortBy == 'ctv_sales_list' || this.sortBy == 'ctv_list') {
                        if (p1[this.sortBy].length == 0 && p2[this.sortBy].length > 0) return -1 * modifier;
                        if (p1[this.sortBy].length > 0 && p2[this.sortBy].length == 0) return 1 * modifier;
                        if (p1[this.sortBy].length == 0 && p2[this.sortBy].length == 0) return 0;

                        if (p1[this.sortBy][0]['name'] < p2[this.sortBy][0]['name']) return -1 * modifier;
                        if (p1[this.sortBy][0]['name'] > p2[this.sortBy][0]['name']) return 1 * modifier;
                        return 0;
                    } else {
                        if (p1[this.sortBy] < p2[this.sortBy]) return -1 * modifier;
                        if (p1[this.sortBy] > p2[this.sortBy]) return 1 * modifier;
                        return 0;
                    }
                });
            }
        },
        methods: {
            update(i) {
                i.edit = 1;
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
                    url: "{{route('admin.getListWorkDays')}}?sche=1&page=" + this.page + conditionSearch,
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
            execCopyClipboad() {
                var $temp = $("<textarea>");
                var brRegex = /<br\s*[\/]?>/gi;
                $("body").append($temp);
                var str = $("#error-details").html().replace(brRegex, "\r");
                str = str.replace(/<\/?span[^>]*>/g, "");
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
                alert("営業者報酬 : " + (totalAlerMessage * 10 / 100));
            },
            copyClipboad(_i) {
                $('#copyName').html(_i.name);
                $('#copyFurigana').html(_i.furigana);
                $('#copyPhone').html(_i.phone);

                var $temp = $("<textarea>");
                var brRegex = /<br\s*[\/]?>/gi;
                $("body").append($temp);
                var str = $("#error-details").html().replace(brRegex, "\r");
                str = str.replace(/<\/?span[^>]*>/g, "");
                $temp.val(str).select();
                document.execCommand("copy");
                $temp.remove();

            },
            onSubmit() {
                $('.btn-submit').prop('disabled', true);
                setTimeout(function() {
                    $('.form-data').submit();
                }, 1000);
            },

            isNull(value) {
                return (value == null || value == undefined || value == "") ? true : false;
            },
            convertStatusBank(value) {
                return (value == "1") ? "済み" : "";
            },
            convertTaxPlace(value) {
                return (value == "0") ? "" : value;
            },
            parseMoney(value) {
                value = (isNaN(value)) ? 0 : value;
                const formatter = new Intl.NumberFormat('ja-JP', {
                    style: 'currency',
                    currency: 'JPY',
                    currencyDisplay: 'name'
                });
                return formatter.format(value);
            },
            parseMoneyMinus(value) {
                value = this.parseMoney(value);
                return (value == 0) ? value : (S_HYPEN + " " + value);
            },
            parseBank(itemBank) {
                var value = itemBank["name_bank"];
                return value;
            },
            parseName(value) {
                return this.isNull(value) ? S_HYPEN : value.toUpperCase();
            },
            parseMonth(value) {
                return this.isNull(value) ? S_HYPEN :
                    value.replace("-", " 年 ") + " 月度";
            },
            parseAddr(value) {
                return this.isNull(value) ? S_HYPEN : value;
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
                    _token: CSRF_TOKEN,
                    mail_cc: this.objSendMail.mail_cc,
                    title: this.objSendMail.title,
                    body: this.objSendMail.body,
                    userId: this.userCustomerId
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