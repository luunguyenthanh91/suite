@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '給与明細')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    @include('admin.component.header')

    <div id="list-data">
        <div class="modal fade" id="createPayslip">
            <form method="POST" class="modal-dialog char-w-new" action="/admin/new-payslip">
                @csrf
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.new_payslip') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.month') }}</label>
                            <input type="month" name="month" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.user_id') }}</label>
                            <input type="text" name="user_id" class="form-control"  required>
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.note') }}</label>
                            <textarea type="text" class="form-control" name="note" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                    <button type="submit" class="btn btn-success">
                            <span class="labelButton">{{ trans('label.ok') }}</span>
                        </button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">
                            <span class="labelButton">{{ trans('label.cancel') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog  char-w-new">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.search') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.payslip_id') }}</label>
                            <input type="text" class="form-control search" v-model="item_id">
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.month') }}</label>
                            <input type="month" class="form-control search" v-model="month">
                        </div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.month_from') }}</label>
                                <input type="month" class="form-control search" v-model="month_from">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.month_to') }}</label>
                                <input type="month" class="form-control search" v-model="month_to">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.user_id') }}</label>
                            <input type="text" class="form-control search" v-model="user_id">
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.user_name') }}</label>
                            <input type="text" class="form-control search" v-model="user_name">
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="form-group">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.status') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="0" value="0" v-model="checkedNames">
                                <label class="status2" for="0">{{ trans('label.ws_status1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames">
                                <label class="status3" for="1">{{ trans('label.ws_status2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames">
                                <label class="status4" for="2">{{ trans('label.ws_status3') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="3" value="3" v-model="checkedNames">
                                <label class="status5" for="3">{{ trans('label.ws_status4') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="4" value="4" v-model="checkedNames">
                                <label class="status6" for="4">{{ trans('label.close2') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.created_on') }}</label>
                                <input type="date" class="form-control search" v-model="created_on" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">                        
                                <label class="form-label">{{ trans('label.created_on_month') }}</label>
                                <input type="month" class="form-control search"  v-model="created_on_month"  min="2021-03">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.created_on_from') }}</label>
                                <input type="date" class="form-control search" v-model="created_on_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.created_on_to') }}</label>
                                <input type="date" class="form-control search" v-model="created_on_to" min="2021-03-17">
                            </div>                            
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.created_by') }}</label>
                            <input type="text" class="form-control search" v-model="created_by">
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.checked_on') }}</label>
                                <input type="date" class="form-control search" v-model="checked_on" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">                        
                                <label class="form-label">{{ trans('label.checked_on_month') }}</label>
                                <input type="month" class="form-control search"  v-model="checked_on_month"  min="2021-03">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.checked_on_from') }}</label>
                                <input type="date" class="form-control search" v-model="checked_on_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.checked_on_to') }}</label>
                                <input type="date" class="form-control search" v-model="checked_on_to" min="2021-03-17">
                            </div>                            
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.checked_by') }}</label>
                            <input type="text" class="form-control search" v-model="checked_by">
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.approved_on') }}</label>
                                <input type="date" class="form-control search" v-model="approved_on" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">                        
                                <label class="form-label">{{ trans('label.approved_on_month') }}</label>
                                <input type="month" class="form-control search"  v-model="approved_on_month"  min="2021-03">
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.approved_on_from') }}</label>
                                <input type="date" class="form-control search" v-model="approved_on_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="form-label">{{ trans('label.approved_on_to') }}</label>
                                <input type="date" class="form-control search" v-model="approved_on_to" min="2021-03-17">
                            </div>                            
                        </div>
                        <div class="form-group col-lg-12">
                            <label class="form-label">{{ trans('label.approved_by') }}</label>
                            <input type="text" class="form-control search" v-model="approved_by">
                        </div>
                    </div>
                    <div class="modal-footer">
                    <a type="button" class="btn btn-outline-secondary3 clearButtonBg" @click="clearSearch()">
                            <span class="labelButton">{{ trans('label.clear_search') }}</span>
                        </a>
                        <a type="button" class="btn btn-outline-secondary3 searchButtonBg" @click="someHandlerChange()" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.search2') }}</span>
                        </a>
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="splitter" >
            <div id="first" class="leftPanel">
                <div class="col-lg-12" style="margin-top:35px;">
                    <div class="page-separator">
                        <div class="page-separator__text bgWhite">{{ trans("label.search2") }}</div>
                    </div>
                    <div class="card">
                        <div class="col-lg-12">
                            <div class="row" style="margin-top:15px;">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">{{ trans('label.payslip_id') }}</label>
                                    <input type="text" class="form-control search" v-model="item_id" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">{{ trans('label.month') }}</label>
                                    <input type="month" class="form-control search" v-model="month" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                </div>
                            </div> 
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">{{ trans('label.user_id') }}</label>
                                    <input type="text" class="form-control search" v-model="user_id" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="form-label">{{ trans('label.user_name') }}</label>
                                    <input type="text" class="form-control search" v-model="user_name" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                </div>
                            </div>                             
                        </div>
                    </div>
                </div>
            </div>
            <div id="separator" ></div>
            <div id="second" class="rightPanel">

            <div class="bodyButtonTop">
                    <a type="button" class="btn btn-outline-secondary3 newButtonBg" data-toggle="modal" data-target="#createPayslip">
                        <i class="fa fa-plus-square"><span class="labelButton">{{ trans('label.new') }}</span></i>
                    </a> 
                    <a type="button" class="btn btn-outline-secondary3 searchButtonBg" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-search"><span class="labelButton">{{ trans('label.search') }}</span></i>
                    </a>     
                    <!-- <a type="button" class="btn btn-outline-secondary3" style="background:#1E90FF" target="_blank" @click="refresh()">
                        <i class="fas fa-sync-alt"><span class="labelButton">リフレッシュ</span></i>
                    </a> -->
                </div>
                <div class="container page__container page-section page_container_custom">
                    <div class="row page_container_custom_marginright">
                        <div style="margin-left:2px;width:100%;padding-right:15px;">
                            <div :class="'' + classBodayRightContentGrid">
                                <div class="d-flex ">
                                    <div class="d-flex fullWidth">
                                        <input class="checkboxHor2" type="checkbox" id="po_status1" value="0" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status2" for="po_status1">{{ trans('label.ws_status1') }}</label>

                                        <input class="checkboxHor" type="checkbox" id="po_status2" value="1" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status3" for="po_status2">{{ trans('label.ws_status2') }}</label>

                                        <input class="checkboxHor" type="checkbox" id="cancel" value="2" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status4" for="cancel">{{ trans('label.ws_status3') }}</label>
                                    
                                        <input class="checkboxHor" type="checkbox" id="approved" value="3" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status5" for="approved">{{ trans('label.ws_status4') }}</label>

                                        <input class="checkboxHor" type="checkbox" id="received" value="4" v-model="checkedNames" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label class="labelFontSize10 status6" for="received">{{ trans('label.close2') }}</label>
                                    </div>
                                    <div class="d-flex rightGridMenu">
                                        <div class="gridControl2">
                                            <label class="form-label">{{ trans('label.number_show') }}</label>
                                            <select id="showCount" @change="someHandlerChangeShowCount()" v-model="showCount" >
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="0">全て</option>
                                            </select>
                                            <label class="form-label">of ((sumCount)) {{ trans('label.ken') }}</label>
                                        </div>
                                        <div class="vl"></div>
                                        <a @click="resetSearch()" type="button" class="btn btn-outline-secondary updateButton updateButtonWidth">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="bodyContent">
                                    <div class="bodyContentRight tableFixHead wrapper">
                                        <table class="table thead-border-top-0 table-nowrap mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="sticky-col fix-col1" scope="col" @click="sort('id')">
                                                        <div v-bind:class="[sortBy === 'id' ? sortDirection : '']">{{ trans('label.payslip_id') }}</div>
                                                    </th>
                                                    <th class="sticky-col fix-col2" scope="col" @click="sort('month')">
                                                        <div v-bind:class="[sortBy === 'month' ? sortDirection : '']">{{ trans('label.month') }}</div>
                                                    </th>
                                                    <th class="sticky-col fix-col3" scope="col" @click="sort('user_name')">
                                                        <div v-bind:class="[sortBy === 'user_name' ? sortDirection : '']">{{ trans('label.user_name') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('user_id')">
                                                        <div v-bind:class="[sortBy === 'user_id' ? sortDirection : '']">{{ trans('label.user_id') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('employee_depname')">
                                                        <div v-bind:class="[sortBy === 'employee_depname' ? sortDirection : '']">{{ trans('label.employee_depname') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('status')" >
                                                        <div v-bind:class="[sortBy === 'status' ? sortDirection : '']">{{ trans('label.status') }}</div>
                                                    </th>
                                                    <th scope="col"  @click="sort('pay_day')">
                                                        <div v-bind:class="[sortBy === 'pay_day' ? sortDirection : '']">{{ trans('label.pay_day') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('pay_total')">
                                                        <div v-bind:class="[sortBy === 'pay_total' ? sortDirection : '']">{{ trans('label.pay_total') }}</div>
                                                    </th>
                                                    <th scope="col"  @click="sort('created_on')">
                                                        <div v-bind:class="[sortBy === 'created_on' ? sortDirection : '']">{{ trans('label.created_on') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('created_by')">
                                                        <div v-bind:class="[sortBy === 'created_by' ? sortDirection : '']">{{ trans('label.created_by') }}</div>
                                                    </th>
                                                    <th scope="col"  @click="sort('checked_on')">
                                                        <div v-bind:class="[sortBy === 'checked_on' ? sortDirection : '']">{{ trans('label.checked_on') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('checked_by')">
                                                        <div v-bind:class="[sortBy === 'checked_by' ? sortDirection : '']">{{ trans('label.checked_by') }}</div>
                                                    </th>
                                                    <th scope="col"  @click="sort('approved_on')">
                                                        <div v-bind:class="[sortBy === 'approved_on' ? sortDirection : '']">{{ trans('label.approved_on') }}</div>
                                                    </th>
                                                    <th scope="col" @click="sort('approved_by')">
                                                        <div v-bind:class="[sortBy === 'approved_by' ? sortDirection : '']">{{ trans('label.approved_by') }}</div>
                                                    </th>
                                                    <th scope="col"  @click="sort('note')">
                                                        <div v-bind:class="[sortBy === 'note' ? sortDirection : '']">{{ trans('label.note') }}</div>
                                                    </th>
                                                    <th scope="col"  style="width: 100%; "></th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="search">
                                                <tr v-for="item in sortedProducts">
                                                    <td :class="item.classStyle  + ' sticky-col fix-col1-detail'" style="left:0px">
                                                    <a target="_blank" :href="'/admin/payslip-view/' + item.id">
                                                    ((item.id))
                                                    </a>
                                                    </td>
                                                    <td :class="item.classStyle  + ' sticky-col fix-col2-detail'">
                                                    (( removeTime(item.month) ))
                                                    </td>
                                                    <td :class="item.classStyle  + ' sticky-col fix-col3-detail'">
                                                    (( item.employee_name ))                                                  
                                                    </td>
                                                    <td>
                                                    (( item.user_id ))                                                  
                                                    </td>
                                                    <td>
                                                    (( item.employee_depname ))                                                    
                                                    </td>
                                                    <td>
                                                    <span v-if="item.status==0">{{ trans('label.ws_status1') }}</span>
                                                    <span v-if="item.status==1">{{ trans('label.ws_status2') }}</span>   
                                                    <span v-if="item.status==2">{{ trans('label.ws_status3') }}</span>    
                                                    <span v-if="item.status==3">{{ trans('label.ws_status4') }}</span>   
                                                    </td>
                                                    <td>
                                                    ((item.pay_day)) 
                                                    </td>
                                                    <td class="moneyCol" >
                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY',currencyDisplay: 'name' }).format(item.pay_total) ))
                                                    </td>
                                                    <td>
                                                    ((item.created_on)) 
                                                    </td>
                                                    <td>
                                                    ((item.created_by_name)) 
                                                    </td>
                                                    <td>
                                                    ((item.checked_on)) 
                                                    </td>
                                                    <td>
                                                    ((item.checked_by_name)) 
                                                    </td>
                                                    <td>
                                                    ((item.approved_on)) 
                                                    </td>
                                                    <td>
                                                    ((item.approved_by_name)) 
                                                    </td>
                                                    <td >
                                                    <span class="text-block" v-html="item.note">
                                                    (( item.note ))
                                                    </span>
                                                    </td>
                                                    <td></td>
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
<link rel="stylesheet" href="{{ asset('assets/fixed-columns/bootstrap-table-fixed-columns.css') }}">
<script src="{{ asset('assets/fixed-columns/bootstrap-table-fixed-columns.js') }}"></script>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function (){
    function dragElement(element, direction)
    {
        var   md; // remember mouse down info
        const first  = document.getElementById("first");
        const second = document.getElementById("second");

        element.onmousedown = onMouseDown;

        function onMouseDown(e)
        {
            //console.log("mouse down: " + e.clientX);
            md = {e,
                offsetLeft:  element.offsetLeft,
                offsetTop:   element.offsetTop,
                firstWidth:  first.offsetWidth,
                secondWidth: second.offsetWidth
                };

            document.onmousemove = onMouseMove;
            document.onmouseup = () => {
                //console.log("mouse up");
                document.onmousemove = document.onmouseup = null;
            }
        }

        function onMouseMove(e)
        {
            //console.log("mouse move: " + e.clientX);
            var delta = {x: e.clientX - md.e.clientX,
                        y: e.clientY - md.e.clientY};

            if (direction === "H" ) // Horizontal
            {
                // Prevent negative-sized elements
                delta.x = Math.min(Math.max(delta.x, -md.firstWidth),
                        md.secondWidth);

                element.style.left = md.offsetLeft + delta.x + "px";
                first.style.width = (md.firstWidth + delta.x) + "px";
                second.style.width = (md.secondWidth - delta.x) + "px";
            }
        }
    }


    dragElement( document.getElementById("separator"), "H" );

    $('#link-map-po').on('click',function() {
        var addressPo = $('#address-po').val();
        if (addressPo.trim() == '') {
            alert("通訳会場のフィールドは入力必須です。");
            return false;
        }
        var win = window.open('https://www.google.com/maps/place/'+addressPo, '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }
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
        $('#txtCountDayPo').text("（日数: " + $cntDay + "）");
    });
    CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
});

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        item_id:'{{ Request::get("keyword") }}',
        type_train_search: '',
        project_id_search:'',
        name_search: '',

        user_id: '',
        user_name:'',

        created_by: '',
        checked_by: '',
        approved_by: '',

        
        created_on: '',
        created_on_from: '',
        created_on_to: '',
		created_on_month: '',
        
        checked_on: '',
        checked_on_from: '',
        checked_on_to: '',
		checked_on_month: '',

        
        approved_on: '',
        approved_on_from: '',
        approved_on_to: '',
		approved_on_month: '',

        checkedNames: [0,1,2,3,4],
        month: '',
        month_from: '',
        month_to: '',
        
        sumPrice:0,
        sumSalePrice:0,


        conditionSearch: '',
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
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        codeJobs: '{{ Request::get("keyword") }}',
		checkedTypes: [1,2,3,4],
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
        classColLG12: (viewPC)? "col-lg-12" : "colLg12Mobile",
        classRightGrid: "col-lg-10",
        classLefttGrid: "col-lg-2",
        sortBy: 'codejob',
        sortDirection: 'desc',
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
    },
    computed: {
        sortedProducts: function(){
            return this.list.sort((p1,p2) => {
                let modifier = 1;
                if(this.sortDirection === 'desc') modifier = -1; 
                
                if(p1[this.sortBy] == undefined && p2[this.sortBy] != undefined) return -1 * modifier; 
                if(p1[this.sortBy] != undefined && p2[this.sortBy] == undefined) return 1 * modifier;
                if(p1[this.sortBy] == undefined && p2[this.sortBy] == undefined) return 0;

                if(p1[this.sortBy].length == 0 && p2[this.sortBy].length > 0) return -1 * modifier; 
                if(p1[this.sortBy].length > 0 && p2[this.sortBy].length == 0) return 1 * modifier;
                if(p1[this.sortBy].length == 0 && p2[this.sortBy].length == 0) return 0;
                
                if (this.sortBy == 'ctv_sales_list' || this.sortBy == 'ctv_list') {
                    if(p1[this.sortBy][0]['name'] < p2[this.sortBy][0]['name']) return -1 * modifier; 
                    if(p1[this.sortBy][0]['name'] > p2[this.sortBy][0]['name']) return 1 * modifier;
                    return 0;
                } else {
                    if (!Number.isNaN(parseInt(p1[this.sortBy])) && !Number.isNaN(parseInt(p2[this.sortBy])) ) {
                        if (p1[this.sortBy].indexOf && p2[this.sortBy].indexOf && p1[this.sortBy].indexOf("-") == -1 && p2[this.sortBy].indexOf("-") == -1) {
                            return (p1[this.sortBy] - p2[this.sortBy])* modifier;
                        }
                    }
                    
                    if(p1[this.sortBy] < p2[this.sortBy]) return -1 * modifier; 
                    if(p1[this.sortBy] > p2[this.sortBy]) return 1 * modifier;
                    return 0;
                }
            });
        }
    },
    methods: {  
        getToday: function() {
            let d = new Date();

            let year = d.getFullYear()
            let month = String(d.getMonth() + 1)
            let day = String(d.getDate())

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
                month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            return `${year}-${month}-${day}`;
        },
        getThisYear: function() {
            let d = new Date();
            
            let year = d.getFullYear();
            return `${year}`;
        },
        getThisMonth: function () {
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth() + 1)
            let day = String(d.getDate());

            month = month.length == 1 ? month.padStart('2', '0') : month;
            return `${year}-${month}`;
        },
        getLastMonth: function () {
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth());
            let day = String(d.getDate());

            month = month.length == 1 ? month.padStart('2', '0') : month;
            return `${year}-${month}`;
        },
        HideLeft: function() {
            if (this.classRightGrid == "col-lg-12") {
                this.classRightGrid = "col-lg-10";
                this.classLefttGrid = "col-lg-2";
                this.hiddenMenu = "displayNone";
            } else {
                this.classRightGrid = "col-lg-12";
                this.classLefttGrid = "col-lg-0 displayNone";
                this.hiddenMenu = "";
            }
        },
        sort: function(s){
            if(s === this.sortBy) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            }
            this.sortBy = s;
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
            $('#copyFurigana').html("");
            $('#copyPhone').html("");

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
        notRegister: function() {
            this.clearSearchCondition();
            this.checkedNames = [0];
            this.sortName = 'create_at';  
            this.sortType = "ASC";  
            this.sortBy= 'create_at',
            this.sortDirection= 'ASC',
            this.onSearch();
        },
        refresh: function() {
            this.clearSearchCondition();
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
            
            var sName = "company.id";
            var sType = "DESC";
            var lblOrderNumber = "受注番号";
            var lblOrderStatus = "ステータス";
            var lblOrderDate = "通訳日";
            switch (selVal) {
                case "1":
                    sName = "company.codejob";
                    sType = "DESC";
                    lblOrderNumber = "受注番号 ▼";
                    break;
                case "2":
                    sName = "company.codejob";
                    sType = "ASC";
                    lblOrderNumber = "受注番号 ▲";
                    break;
                case "3":
                    sName = "company.ngay_pd";
                    sType = "DESC";
                    lblOrderDate = "通訳日 ▼";
                    break;
                case "4":
                    sName = "company.ngay_pd";
                    sType = "ASC";
                    lblOrderDate = "通訳日 ▲";
                    break;
                case "5":
                    sName = "company.status";
                    sType = "DESC";
                    lblOrderStatus = "ステータス ▼";
                    break;
                case "6":
                    sName = "company.status";
                    sType = "ASC";
                    lblOrderStatus = "ステータス ▲";
                    break;
            }

            this.sortName = sName;
            this.sortType = sType;
            $("#lblOrderNumber").text(lblOrderNumber);   
            $("#lblOrderStatus").text(lblOrderStatus); 
            $("#lblOrderDate").text(lblOrderDate);
            
            this.page = 1;
            this.onLoadPagination();
        },
        switchView: function() {
            this.type_show = (this.type_show == 1) ? 2 : 1;
        },
        resetSearch() {
            this.item_id = '';
            this.type_train_search = '';
            this.project_id_search = '';
            this.name_search = '';
            this.created_by = '';
            this.checked_by = '';
            this.approved_by = '';

            this.user_id='';
            this.user_name='';

            this.checkedNames = [0,1,2,3,4];
            this.month = '';
            this.month_from = '';
            this.month_to = '';

            this.created_on = '';
            this.created_on_from = '';
            this.created_on_to = '';
            this.created_on_month = '';

            this.checked_on = '';
            this.checked_on_from = '';
            this.checked_on_to = '';
            this.checked_on_month = '';

            this.approved_on = '';
            this.approved_on_from = '';
            this.approved_on_to = '';
            this.approved_on_month = '';

            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";    
            this.checkAkaji= 0;   
            
            this.onLoadPagination();
        },
        clearSearchCondition() {
            this.item_id = '';
            this.project_id_search = '';
            this.type_train_search = '';
            this.name_search = '';
            this.created_by = '';
            this.checked_by = '';
            this.approved_by = '';

            this.user_id='';
            this.user_name='';

            this.checkedNames = [0,1,2,3,4];
            this.month = '';
            this.month_from = '';
            this.month_to = '';

            this.created_on = '';
            this.created_on_from = '';
            this.created_on_to = '';
            this.created_on_month = '';

            this.checked_on = '';
            this.checked_on_from = '';
            this.checked_on_to = '';
            this.checked_on_month = '';

            this.approved_on = '';
            this.approved_on_from = '';
            this.approved_on_to = '';
            this.approved_on_month = '';

            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
			this.checkedTypes = [1,2,3];
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;     
            
            this.onLoadPagination();    
        },
        clearSearch() { 
            this.clearSearchCondition();
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            this.onLoadPagination();
		},
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [0,1,2,3,4];
		},
		clearSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [];
            // this.onLoadPagination();
		},
		setSearchTypeJob() {
			this.page = 1;
            this.checkedTypes = [1,2,3];
            // this.onLoadPagination();
		},
        isNull (value) {
            return (value == null || value == undefined || value == "") ? true : false;
        },
        parseName (value) {
            return this.isNull(value)? S_HYPEN : value.toUpperCase();
        },
        removeTime (value) {
            return this.isNull(value)? S_HYPEN : (value.split(' ')[0]);
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
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.item_id != '') {
                conditionSearch += '&item_id=' + this.item_id;
            }
            if (this.user_id != '') {
                conditionSearch += '&user_id=' + this.user_id;
            }
            if (this.user_name != '') {
                conditionSearch += '&user_name=' + this.user_name;
            }

            if (this.created_by != '') {
                conditionSearch += '&created_by=' + this.created_by;
            }    
            if (this.checked_by != '') {
                conditionSearch += '&checked_by=' + this.checked_by;
            } 
            if (this.approved_by != '') {
                conditionSearch += '&approved_by=' + this.approved_by;
            }         

            if (this.created_on != '') {
                conditionSearch += '&created_on=' + this.created_on;
            }
            if (this.created_on_from != '') {
                conditionSearch += '&created_on_from=' + this.created_on_from;
            }
            if (this.created_on_to != '') {
                conditionSearch += '&created_on_to=' + this.created_on_to;
            }
            if (this.created_on_month != '') {
                conditionSearch += '&created_on_month=' + this.created_on_month;
            }         

            if (this.checked_on != '') {
                conditionSearch += '&checked_on=' + this.checked_on;
            }
            if (this.checked_on_from != '') {
                conditionSearch += '&checked_on_from=' + this.checked_on_from;
            }
            if (this.checked_on_to != '') {
                conditionSearch += '&checked_on_to=' + this.checked_on_to;
            }
            if (this.checked_on_month != '') {
                conditionSearch += '&checked_on_month=' + this.checked_on_month;
            }

            if (this.approved_on != '') {
                conditionSearch += '&approved_on=' + this.approved_on;
            }
            if (this.approved_on_from != '') {
                conditionSearch += '&approved_on_from=' + this.approved_on_from;
            }
            if (this.approved_on_to != '') {
                conditionSearch += '&approved_on_to=' + this.approved_on_to;
            }
            if (this.approved_on_month != '') {
                conditionSearch += '&approved_on_month=' + this.approved_on_month;
            }

            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.month != '') {
                conditionSearch += '&month=' + this.month;
            }
            if (this.month_from != '') {
                conditionSearch += '&month_from=' + this.month_from;
            }
            if (this.month_to != '') {
                conditionSearch += '&month_to=' + this.month_to;
            }
            conditionSearch += '&showcount=' + this.showCount; 
            this.conditionSearch = conditionSearch;          

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListPayslip')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                    } else {
                        that.count = 0;
                        that.list = [];
                        that.sumCount = data.count;
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

                    // fixed 1
                    setTimeout(function() { 
                        $('.fix-col1').attr("style","z-index:10;left:0px;background:#CCCCCC");
                        $('.fix-col2').attr("style","z-index:10;left:90px;background:#CCCCCC");
                        $('.fix-col3').attr("style","z-index:10;left:"+(70 + 90)+"px;background:#CCCCCC");


                        $('.fix-col1-detail').attr("style","z-index:9;left:0px;");
                        $('.fix-col2-detail').attr("style","z-index:9;left:90px;");
                        $('.fix-col3-detail').attr("style","z-index:9;left:"+(70 + 90)+"px;");
                    }, 100);
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