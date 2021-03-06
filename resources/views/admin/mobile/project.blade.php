@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件')

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
                            <div class="page-separator__text bgWhite">{{ trans("label.search2") }}</div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12" style="margin-top:15px;">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <input type="checkbox" value="0" id="lef_akaji" v-model="checkAkaji"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                        <label for="lef_akaji" class="statusMinus">{{ trans('label.akaji') }}</label>
                                    </div>
                                </div>
                                <div class="page-separator-line"></div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.id') }}</label>
                                        <input type="text" class="form-control search" v-model="project_id" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                                        <input type="date" class="form-control search" v-model="ngay_phien_dich" min="2021-03-17"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.sale') }}</label>
                                        <input type="text" class="form-control search" v-model="ctv_sale"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.interpreter') }}</label>
                                        <input type="text" class="form-control search" v-model="ctv_pd"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                                <div class="page-separator-line"></div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">{{ trans('label.employee_id') }}</label>
                                        <input type="text" class="form-control search" v-model="employee_id"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text">
                            {{ trans("label.sum_search") }}
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px;">
                                    <div class="form-group col-lg-12">
                                        <a class="dropdown-item" target="_blank" @click="todayProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.today_interpreter2') }}<span>(</span>(( getToday() ))<span>)</span></span>
                                        </a>  
                                        <a class="dropdown-item" target="_blank" @click="tomorrowProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.tomorrow_interpreter2') }}<span>(</span>(( getNextDay() ))<span>)</span></span>
                                        </a>
                        <div class="page-separator-line"></div>
                                        <a class="dropdown-item" target="_blank" @click="lastMonthProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.lastmonth2') }}<span>(</span>(( getLastMonth() ))<span>)</span></span>
                                        </a>  
                                        <a class="dropdown-item" target="_blank" @click="thisMonthProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.thismonth2') }}<span>(</span>(( getThisMonth() ))<span>)</span></span>
                                        </a>  
                                        <a class="dropdown-item" target="_blank" @click="thisYearProject()">
                                        <i class="fas fa-search-plus"></i><span class="labelButtonDropMenu">{{ trans('label.thisyear2') }}<span>(</span>(( getThisYear() ))<span>)</span></span>
                                        </a>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-separator">
                            <div class="page-separator__text">
                            {{ trans("label.graph") }}( {{ trans("label.list_count_order") }})
                            </div>
                        </div>
                        <div class="card">
                            <div class="col-lg-12">
                                <div class="row" style="margin-top:15px;">
                                    <div class="form-group col-lg-12">
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChart" data-target="#myModalChartToday">
                                        <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.list_count_order_day2') }}</span>
                                        </a> 
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChartMonth" data-target="#myModalChartMonth">
                                        <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.list_count_order_month2') }}</span>
                                        </a>       
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChartYear" data-target="#myModalChartYear">
                                        <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.this10YearGraph_count2') }}</span>
                                        </a>
                                        <a class="dropdown-item" data-toggle="modal" @click="onLoadChartArea" data-target="#myModalChartArea">
                                        <i class="fas fa-chart-bar"></i><span class="labelButtonDropMenu">{{ trans('label.areaGraph_count') }}</span>
                                        </a>  
                                    </div>
                                </div>
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
        <div class="modal fade" id="myModalChartToday">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.list_count_order_day') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center class="col-lg-12">
                            <div class="d-flex col-lg-3">
                                <input type="month" class="form-control search" id="chart_today" @change="onLoadChart"  min="2021-03" value="{{ date('Y-m') }}">
                            </div>
                        </center>
                        <div class="flex" id="chart5" style="max-width: 100%;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartMonth">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.list_count_order_month') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <center class="col-lg-12">
                            <div class="d-flex col-lg-2">
                                <select id="selLang" @change="onLoadChartMonth()" class="form-control search" v-model="thisYear" >
                                    <option value="2021" selected>2021年</option>
                                    <option value="2022">2022年</option>
                                    <option value="2023">2023年</option>
                                    <option value="2024">2024年</option>
                                    <option value="2025">2025年</option>
                                    <option value="2026">2026年</option>
                                    <option value="2027">2027年</option>
                                    <option value="2028">2028年</option>
                                    <option value="2029">2029年</option>
                                    <option value="2030">2030年</option>                        
                                </select>
                            </div>
                        </center>
                        <div class="flex" id="chart6" style="max-width: 100%;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartYear">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.this10YearGraph_count') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="flex" id="chart7" style="max-width: 100%;margin-top:20px;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalChartArea">
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.areaGraph') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="flex" id="chart4" style="max-width: 100%;"></div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-outline-secondary3"  style="background:gray" data-dismiss="modal">
                            <span class="labelButton">{{ trans('label.close') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createProject">
            <form method="POST" class="modal-dialog char-h-mobile" action="/admin/projectnew">
                @csrf
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.add_project') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group ">
                            <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                            <input type="text" autocomplete="off" id="listDateProj" name="ngay_pd" class="form-control" required >
                        </div>
                        <div class="form-group countDateLabel">
                            <div id="txtCountDay">（{{ trans('label.count_day') }}: - ）</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.address_pd') }}</label>
                            <div class="search-form" >
                                <input id="addressProj" type="text" required class="form-control" name="address_pd" >
                                <a id="link-map-proj" type="button" class="btn btn-warning" style="background:blue">{{ trans('label.google_map3') }}</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.contract_money') }}</label> 
                            <div class="search-form">
                                <input type="text" class="form-control money_parse" name="tienphiendich">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{ trans('label.note') }}</label>
                            <textarea type="text" name="description" class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
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
            <div class="modal-dialog char-h-mobile">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('label.search_header') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.id') }}</label>
                                <input type="text" class="form-control search" v-model="project_id">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.date_start') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.date_start_month') }}</label>
                                <input type="month" class="form-control search" v-model="dateOrder_month">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.date_start_from') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.date_start_to') }}</label>
                                <input type="date" class="form-control search" v-model="dateOrder_to" min="2021-03-17">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-12">                        
                                <label class="form-label">{{ trans('label.thang_phien_dich') }}</label>
                                <input type="month" class="form-control search"  v-model="thang_phien_dich"  min="2021-03">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_from') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_from" min="2021-03-17">
                            </div>
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.ngay_phien_dich_to') }}</label>
                                <input type="date" class="form-control search" v-model="ngay_phien_dich_to" min="2021-03-17">
                            </div>                            
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label m-0">{{ trans('label.address_pd') }}</label>
                                <input type="text" class="form-control search" v-model="conditionAddress">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="checkbox" value="0" id="akaji" v-model="checkAkaji">
                                <label for="akaji" class="statusMinus">{{ trans('label.akaji') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.status') }}</label>
                            </div>
                            <!-- <div class="form-group col-lg-12">
                                <input type="checkbox" id="0" value="0" v-model="checkedNames">
                                <label class="statusOther" for="0">{{ trans('label.status0') }}</label>
                            </div> -->
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames">
                                <label class="statusOther" for="1">{{ trans('label.status1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames">
                                <label class="status2" for="2">{{ trans('label.status2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="3" value="3" v-model="checkedNames">
                                <label class="status3" for="3">{{ trans('label.status3') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="8" value="8" v-model="checkedNames">
                                <label class="status8" for="8">{{ trans('label.status8') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="4" value="4" v-model="checkedNames">
                                <label class="status4" for="4">{{ trans('label.status4') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="5" value="5" v-model="checkedNames">
                                <label class="status5" for="5">{{ trans('label.status5') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="6" value="6" v-model="checkedNames">
                                <label class="status6" for="6">{{ trans('label.status6') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="7" value="7" v-model="checkedNames">
                                <label class="status7" for="7">{{ trans('label.status7') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="button" @click="clearSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_off') }}</button>
                                <button type="button" @click="setSearchStatus()" class="linkCheckboxAll">{{ trans('label.all_on') }}</button>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sale') }}</label>
                                <input type="text" class="form-control search" v-model="ctv_sale">
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.interpreter') }}</label>
                                <input type="text" class="form-control search" v-model="ctv_pd">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.sex') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="sexMale" value="1" v-model="checkedCTVSex">
                                <label for="sexMale">{{ trans('label.male') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="sexFemale" value="2" v-model="checkedCTVSex">
                                <label for="sexFemale">{{ trans('label.female') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.type') }}</label>  
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type0" value="1" v-model="checkedTypes">
                                <label for="type0">{{ trans('label.type1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type1" value="2" v-model="checkedTypes">
                                <label for="type1">{{ trans('label.type2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type2" value="3" v-model="checkedTypes">
                                <label for="type2">{{ trans('label.type3') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.type_trans') }}</label>  
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_trans0" value="1" v-model="checkedTypeTrans">
                                <label for="type_trans0">{{ trans('label.type_trans1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_trans1" value="2" v-model="checkedTypeTrans">
                                <label for="type_trans1">{{ trans('label.type_trans2') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_trans2" value="3" v-model="checkedTypeTrans">
                                <label for="type_trans2">{{ trans('label.type_trans3') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.language') }}</label>  
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_lang0" value="VNM" v-model="checkedTypeLang">
                                <label for="type_lang0">{{ trans('label.type_lang1') }}</label>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="checkbox" id="type_lang1" value="PHL" v-model="checkedTypeLang">
                                <label for="type_lang1">{{ trans('label.type_lang2') }}</label>
                            </div>
                        </div>
                        <div class="page-separator-line"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label class="form-label">{{ trans('label.employee_id') }}</label>
                                <input type="text" class="form-control search" v-model="employee_id">
                            </div>
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
        <div class="row">
            <div class="bodyButtonTopMobile fullWidthMobile">
                @if (Auth::guard('admin')->user()->id == 1 )
                <a type="button" class="btn btn-outline-secondary3 newButtonBg" data-toggle="modal" data-target="#createProject">
                    <i class="fa fa-plus-square"><span class="labelButton">{{ trans('label.new') }}</span></i>
                </a> 
                @endif  
                <a type="button" :href="'/admin/project-excel?' + conditionSearch" class="btn btn-outline-secondary3 excelButtonBg">
                    <i class="fas fa-file-excel"><span class="labelButton">{{ trans('label.excel') }}</span></i>
                </a>
                <a type="button" class="btn btn-outline-secondary3 searchButtonBg" data-toggle="modal" data-target="#myModal">
                    <i class="fas fa-search"><span class="labelButton">{{ trans('label.search') }}</span></i>
                </a>   
                <div class="vl3"></div> 
                <a type="button" class="btn btn-outline-secondary3 menuButtonMobile" data-toggle="modal" data-target="#leftMenu">
                    <i class="fas fa-th-large"></i>
                </a> 
            </div>
        </div>
        <div class="row">
            <div class="d-flex fullWidthMobile">
                <div class="gridControl3">
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
                <a @click="refresh()" type="button" class="btn btn-outline-secondary updateButton">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </div>
        
        <div class="container page__container page-section page_container_custom">
            <div class="bodyContent">
                <div class="bodyContentRight tableFixHead">
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
                                <td :class="item.classStyle  + ' '">
                                    <a type="button" class="btn btn-outline-secondary" target="_blank" :href="'/admin/projectview/' + item.id">
                                        {{ trans('label.id') }}((item.id)) (<span v-if='item.status == 1'>{{ trans('label.status1') }}</span>
                                                            <span v-if='item.status == 2'>{{ trans('label.status2') }}</span>
                                                            <span v-if='item.status == 3'>{{ trans('label.status3') }}</span>
                                                            <span v-if='item.status == 8'>{{ trans('label.status8') }}</span>
                                                            <span v-if='item.status == 4'>{{ trans('label.status4') }}</span>
                                                            <span v-if='item.status == 5'>{{ trans('label.status5') }}</span>
                                                            <span v-if='item.status == 6'>{{ trans('label.status6') }}</span>
                                                            <span v-if='item.status == 7'>{{ trans('label.status7') }}</span>)
                                    </a><br>
                                    <span v-for="itemCTV in item.ctv_sales_list">
                                        <u><b>(( parseName(itemCTV.name) )) {{ trans('label.sama') }}</b></u><br>
                                    </span>
                                    (( item.ngay_pd )) ((item.address_pd))<br>
                                    <div v-for="itemCTV in item.ctv_list">
                                        <div>
                                            <i v-if="itemCTV.male == 1" class="fa fa-male maleClass"></i>
                                            <i v-if="itemCTV.male == 2" class="fa fa-female femaleClass"></i>  
                                            (( parseName(itemCTV.name) )) (<span>
                                                <a target="_blank" :href="'tel:'+itemCTV.phone">
                                                (( parsePhone(itemCTV.phone) ))
                                                </a>
                                                </span>)
                                        </div>
                                    </div>
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
    $('#link-map-proj').on('click',function() {
        var addressPo = $('#addressProj').val();
        if (addressPo.trim() == '') {
            alert("Nhập địa chỉ.");
            return false;
        }
        var win = window.open('https://www.google.com/maps/place/'+addressPo, '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }
    });

    $('#listDateProj').datepick({ 
        multiSelect: 999, 
        // minDate: 0,
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1,
        onSelect: function(dateText, inst) {
            $(this).change();
        }
    });

    $('#listDateProj').change(function(event) {
        $cntDay = this.value.split(',').length;
        $('#txtCountDay').text("（日数: " + $cntDay + "）");
    });

    CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
    
});

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var S_HYPEN = "-";
var viewPC = !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
let d = new Date();
let year = d.getFullYear();
let month = String(d.getMonth() + 1);
let day = String(d.getDate());

new Vue({
    el: '#list-data',
    data: {
        thisMonth: month,
        thisYear: year,
        thisDay: day,
        selYear: '',
        selMonth: '',
        selDay: '',
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        list: [],
        conditionSearch: '',
        sumCount: 0,
        rowCount: 0,
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
        ngay_phien_dich_from: '',
        ngay_phien_dich_to: '',
		thang_phien_dich: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        dateOrder_from: '',
        dateOrder_to: '',
        dateOrder_month: '',
        codeJobs: '',
        project_id: '{{ Request::get("keyword") }}',
        checkedNames: [0,1,2,3,4,5,6,8],
		checkedTypes: [1,2,3],
        checkedTypeTrans: [1,2,3],
        checkedTypeLang: ["VNM","PHL"],
        employee_id: '',
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
        hiddenMenu: "displayNone",
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
        dayCount: [],
        yearReportCount: [],
        everyYearReportCount: [],
        ReportArea: [],

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
        onLoadChartArea() {
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartChartArea')}}",
                success: function(data) {
                    that.ReportArea = data.ReportArea;
                    that.loadChartArea();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChartArea() {
            var ticks4 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];

            const that = this;
            Object.keys(this.ReportArea).map(function(key , value) {
                s9.unshift(that.ReportArea[key][0]);
                var prefecture = that.ReportArea[key][1];
                var name = '';
                for (var i = 0; i < prefecture.length; i++) {
                    name = name + prefecture.charAt(i) + "<br>";
                }
                ticks4.unshift(name);
            });
            setTimeout(function(){ 
                plot4 = $.jqplot('chart4', [s9], {
                // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                animate: !$.jqplot.use_excanvas,
                cursor: {
                    show: true,
                    showTooltip: true,
                    showTooltipGridPosition: true,
                    //  showTooltipDataPosition: false,
                    showTooltipUnitPosition: false,
                    useAxesFormatters: false,
                    // showVerticalLine : true,
                    followMouse: true
                },
                title: '',
                seriesDefaults:{
                    renderer:$.jqplot.DateAxisRenderer,
                    pointLabels: { show: true , escapeHTML: false },
                    markerOptions: {color: 'red'}
                },
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks4,
                        // label: '{{ trans("label.area") }}'
                    },
                    yaxis: {
                        min:0,
                        max:100,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: '{{ trans("label.list_count_order") }}'
                    }
                },
                highlighter: { show: false },
                height: document.getElementById('myModalChartArea').clientHeight * 0.7,
                canvasOverlay: {
                    show: false,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 160,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }},
                    ]
                }});
                $('#chart4').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info6').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                $('#chart4').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info6').html('Nothing');
                    }
                );
            }, 100);
        },
        onLoadChart() {
            var selDate = document.getElementById("chart_today").value;
            this.selYear = selDate.split('-')[0];
            this.selMonth = selDate.split('-')[1];
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartProjectDate')}}?year=" + that.selYear  + "&month=" + that.selMonth,
                success: function(data) {
                    that.dayCount = data.dayCount;
                    that.loadChart();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChart() {
            var selDate = document.getElementById("chart_today").value;
            this.selYear = selDate.split('-')[0];
            this.selMonth = selDate.split('-')[1];
            var ticks5 = [];
            $.jqplot.config.enablePlugins = true;
            var s7 = [];
            const that = this;
            var d = new Date(this.thisYear, this.thisMonth, 0);
            let lastday = String(d.getDate());
            Object.keys(this.dayCount).map(function(key , value) {
                s7.unshift(that.dayCount[key][0]);
                var d = new Date(that.dayCount[key][1]);
                year = d.getFullYear();
                month = '' + (d.getMonth() + 1);
                day = '' + d.getDate();
                // ticks5.unshift(month + '/' + day);
                // if (d.getDate() == lastday) {
                    day = day +'日';
                // }
                if (d.getDate() == that.thisDay && month == that.thisMonth && year == that.thisYear) {
                    day = '<span style="color:red;border-bottom:1px solid red">'+day+'</span>';
                }
                ticks5.unshift(day);
            });
            setTimeout(function(){ 
                plot5 = $.jqplot('chart5', [s7], {
                    // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                    animate: !$.jqplot.use_excanvas,
                    cursor: {
                        show: true,
                        showTooltip: true,
                        showTooltipGridPosition: true,
                        //  showTooltipDataPosition: false,
                        showTooltipUnitPosition: false,
                        useAxesFormatters: false,
                        // showVerticalLine : true,
                        followMouse: true
                    },
                    // title: that.selYear + "年" + that.selMonth+"月",
                    seriesDefaults:{
                        renderer:$.jqplot.DateAxisRenderer,
                        pointLabels: { show: true , escapeHTML: false },
                        markerOptions: {color: 'red'}
                    },
                    axes: {
                        xaxis: {
                            renderer: $.jqplot.CategoryAxisRenderer,
                            ticks: ticks5
                        },
                        yaxis: {
                            min:0,
                            max:15,
                            tickOptions: { 
                                formatString: '%d' 
                            },
                            label: '{{ trans("label.list_count_order") }}'
                        }
                    },
                    highlighter: { show: false },
                    height: document.getElementById('myModalChartToday').clientHeight * 0.5,
                    canvasOverlay: {
                        show: true,
                        objects: [
                            {horizontalLine: {
                                linePattern: 'dashed',
                                name: 'pebbles',
                                y: 10,
                                lineWidth: 1,
                                xOffset: 0.2,
                                color: 'red',
                                shadow: false
                            }}
                        ]
                    }}
                );
                plot5.replot();
                $('#chart5').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info5').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                $('#chart5').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info5').html('Nothing');
                    }
                );
            }, 100);
        },
        onLoadChartMonth() {
            this.selYear = document.getElementById("selLang").value;
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartProjectMonth')}}?year=" + that.selYear,
                success: function(data) {
                    that.yearReportCount = data.yearReportCount;
                    that.loadChartMonth();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChartMonth() {
            var ticks6 = [];
            $.jqplot.config.enablePlugins = true;
            var s9 = [];

            const that = this;
            Object.keys(this.yearReportCount).map(function(key , value) {
                s9.unshift(that.yearReportCount[key][0]);
                var month = that.yearReportCount[key][1];
                // if (that.yearReportCount[key][1] == 12) {
                    month = month +'月';
                // }
                if (that.yearReportCount[key][1] == that.thisMonth) {
                    month = '<span style="color:red;border-bottom:1px solid red">'+month+'</span>';
                }
                ticks6.unshift(month);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart6', [s9], {
                // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                animate: !$.jqplot.use_excanvas,
                cursor: {
                    show: true,
                    showTooltip: true,
                    showTooltipGridPosition: true,
                    //  showTooltipDataPosition: false,
                    showTooltipUnitPosition: false,
                    useAxesFormatters: false,
                    // showVerticalLine : true,
                    followMouse: true
                },
                // title: that.thisYear + "年",
                seriesDefaults:{
                    renderer:$.jqplot.DateAxisRenderer,
                    pointLabels: { show: true , escapeHTML: false },
                    markerOptions: {color: 'red'}
                },
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks6
                    },
                    yaxis: {
                        min:0,
                        max:300,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: '{{ trans("label.list_count_order") }}'
                    }
                },
                highlighter: { show: false },
                height: document.getElementById('myModalChartMonth').clientHeight * 0.5,
                canvasOverlay: {
                    show: true,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 200,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }},
                    ]
                }});
                plot6.replot();
                $('#chart6').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info6').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                $('#chart6').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info6').html('Nothing');
                    }
                );
            }, 100);
        },        
        onLoadChartYear() {
            const that = this;
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getChartProjectYear')}}",
                success: function(data) {
                    that.everyYearReportCount = data.everyYearReportCount;
                    that.loadChartYear();
                },
                error: function(xhr, textStatus, error) {
                    Swal.fire({
                        title: "システムエラーが発生しました。 大変お手数ですが、サイト管理者までご連絡ください。",
                        type: "warning",

                    });
                }
            });
        },
        loadChartYear() {
            var ticks7 = [];
            $.jqplot.config.enablePlugins = true;
            var s_year_1 = [];
            const that = this;
            Object.keys(this.everyYearReportCount).map(function(key , value) {
                s_year_1.unshift(that.everyYearReportCount[key][0]);
                var y = that.everyYearReportCount[key][1];
                // if (that.everyYearReportCount[key][1] == 2030) {
                    y = y + "年";
                // }
                if (that.everyYearReportCount[key][1] == that.thisYear) {
                    y = '<span style="color:red;border-bottom:1px solid red">'+y+'</span>';
                }
                ticks7.unshift(y);
            });
            setTimeout(function(){ 
                plot6 = $.jqplot('chart7', [s_year_1], {
                // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
                animate: !$.jqplot.use_excanvas,
                cursor: {
                    show: true,
                    showTooltip: true,
                    showTooltipGridPosition: true,
                    //  showTooltipDataPosition: false,
                    showTooltipUnitPosition: false,
                    useAxesFormatters: false,
                    // showVerticalLine : true,
                    followMouse: true
                },
                title: "2021年～2030年",
                seriesDefaults:{
                    renderer:$.jqplot.DateAxisRenderer,
                    pointLabels: { show: true , escapeHTML: false },
                    markerOptions: {color: 'red'}
                },
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks7
                    },
                    yaxis: {
                        min:0,
                        max:3000,
                        tickOptions: { 
                            formatString: '%d' 
                        },
                        label: '{{ trans("label.list_count_order") }}'
                    }
                },
                highlighter: { show: false },
                height: document.getElementById('myModalChartYear').clientHeight * 0.5,
                canvasOverlay: {
                    show: true,
                    objects: [
                        {horizontalLine: {
                            linePattern: 'dashed',
                            name: 'pebbles',
                            y: 2400,
                            lineWidth: 1,
                            xOffset: 0.2,
                            color: 'red',
                            shadow: false
                        }},
                    ]
                }});
                $('#chart7').bind('jqplotDataHighlight', 
                    function (ev, seriesIndex, pointIndex, data) {
                        $('#info6').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
                    }
                );
                $('#chart7').bind('jqplotDataUnhighlight', 
                    function (ev) {
                        $('#info6').html('Nothing');
                    }
                );
            }, 100);
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
        thisYearProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
            let d = new Date();
            let year = d.getFullYear();

            this.ngay_phien_dich_from = `${year}-01-01`;
            this.ngay_phien_dich_to = `${year}-12-31`;
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        thisMonthProject: function() {
            this.clearSearchCondition();

            // Creating the date instance
            let d = new Date();

            let year = d.getFullYear();
            let month = String(d.getMonth() + 1);
            let day = String(d.getDate());

            // Adding leading 0 if the day or month
            // is one digit value
            month = month.length == 1 ? 
            month.padStart('2', '0') : month;

            day = day.length == 1 ? 
            day.padStart('2', '0') : day;

            this.thang_phien_dich = `${year}-${month}`;
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },     
        getNextDay: function () {
            // Creating the date instance
            let d = new Date();
            
            // Adding one date to the present date
            d.setDate(d.getDate() + 1);

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
        lastMonthProject: function() {
            this.clearSearchCondition();
            this.thang_phien_dich = this.getLastMonth();
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        todayProject: function() {
            this.clearSearchCondition();

            // // Creating the date instance
            // let d = new Date();

            // let year = d.getFullYear()
            // let month = String(d.getMonth() + 1)
            // let day = String(d.getDate())

            // // Adding leading 0 if the day or month
            // // is one digit value
            // month = month.length == 1 ? 
            //     month.padStart('2', '0') : month;

            // day = day.length == 1 ? 
            // day.padStart('2', '0') : day;

            this.ngay_phien_dich = this.getToday();
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
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
        tomorrowProject: function() {
            this.clearSearchCondition();

            // // Creating the date instance
            // let d = new Date();
            
            // // Adding one date to the present date
            // d.setDate(d.getDate() + 1);

            // let year = d.getFullYear()
            // let month = String(d.getMonth() + 1)
            // let day = String(d.getDate())

            // // Adding leading 0 if the day or month
            // // is one digit value
            // month = month.length == 1 ? 
            //     month.padStart('2', '0') : month;

            // day = day.length == 1 ? 
            // day.padStart('2', '0') : day;

            this.ngay_phien_dich = this.getNextDay();
            this.sortName = 'ngay_pd';  
            this.sortType = "ASC";  
            this.sortBy= 'ngay_pd';
            this.sortDirection= 'ASC';
            this.showCount=0;
            this.onSearch();
        },
        refresh: function() {
            this.clearSearchCondition();
            this.onLoadPagination();
        },
        clearSearchCondition() {
            this.conditionName = '';
            this.conditionStatus = '';
            this.conditionAddress = '';
            this.dateOrder = '';
            this.dateOrder_from = '';
            this.dateOrder_to = '';
            this.dateOrder_month = '';
            this.ngay_phien_dich = '';
            this.ngay_phien_dich_from = '';
            this.ngay_phien_dich_to = '';
			this.thang_phien_dich = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.project_id = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1,2,3];
            this.checkedTypeTrans = [1,2,3];
            this.checkedTypeLang = ["VNM","PHL"];
            this.employee_id = '';
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
            this.checkAkaji= 0;  

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
        },
        clearSearch() {
            this.clearSearchCondition();
            this.onLoadPagination();    
        },
		clearSearchStatus() {
			this.page = 1;
            this.checkedNames = [];
            // this.onLoadPagination();
		},
        clearSearchStatusReload() {
            this.clearSearchStatus();
            this.onLoadPagination();
        },
		setSearchStatus() {
			this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
            // this.onLoadPagination();
		},
		setSearchStatusReload() {
			this.setSearchStatus();
            this.onLoadPagination();
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
        convertStatus (value) {
            return (value == "1")? "済み" : "";
        },
        parseNgayPD(value) {
            return value.split(',').join('<br />');
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
        onLoadPagination() {
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';

            if (this.conditionAddress != '') {
                conditionSearch += '&address=' + this.conditionAddress;
            }
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.ctv_sale != '') {
                conditionSearch += '&ctv_sale=' + this.ctv_sale;
            }
            if (this.conditionStatus != '') {
                conditionSearch += '&status=' + this.conditionStatus;
            }
            if (this.dateOrder != '') {
                conditionSearch += '&date_start=' + this.dateOrder;
            }
            if (this.dateOrder_from != '') {
                conditionSearch += '&date_start_from=' + this.dateOrder_from;
            }
            if (this.dateOrder_to != '') {
                conditionSearch += '&date_start_to=' + this.dateOrder_to;
            }
            if (this.dateOrder_month != '') {
                conditionSearch += '&date_start_month=' + this.dateOrder_month;
            }
            if (this.ngay_phien_dich != '') {
                conditionSearch += '&ngay_phien_dich=' + this.ngay_phien_dich;
            }
            if (this.ngay_phien_dich_from != '') {
                conditionSearch += '&ngay_phien_dich_from=' + this.ngay_phien_dich_from;
            }
            if (this.ngay_phien_dich_to != '') {
                conditionSearch += '&ngay_phien_dich_to=' + this.ngay_phien_dich_to;
            }
            if (this.thang_phien_dich != '') {
                conditionSearch += '&thang_phien_dich=' + this.thang_phien_dich;
            }
            if (this.name_kh != '') {
                conditionSearch += '&name_kh=' + this.name_kh;
            }
            if (this.ctv_pd != '') {
                conditionSearch += '&ctv_pd=' + this.ctv_pd;
            }
            if (this.codeJobs != '') {
                conditionSearch += '&code_jobs=' + this.codeJobs;
            }
            if (this.employee_id != '') {
                conditionSearch += '&employee_code=' + this.employee_id;
            }
            if (this.project_id != '') {
                conditionSearch += '&project_id=' + this.project_id;
            }
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.checkedTypes.length > 0) {
                conditionSearch += '&loai_job_multi=' + this.checkedTypes.join();
            }
            if (this.checkedTypeTrans.length > 0) {
                conditionSearch += '&type_trans_multi=' + this.checkedTypeTrans.join();
            }
            if (this.checkedTypeLang.length > 0) {
                conditionSearch += '&type_lang_multi=' + this.checkedTypeLang.join();
            }
            if (this.checkedCTVSex.length > 0) {
                conditionSearch += '&ctv_sex=' + this.checkedCTVSex.join();
            }
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;                
            }
            if (this.checkAkaji != 0) {
                conditionSearch += '&check_akaji=' + this.checkAkaji;
            }
            conditionSearch += '&showcount=' + this.showCount; 
            this.conditionSearch = conditionSearch;          

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getListProject')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                        that.rowCount = data.count;

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

                        that.dayCount = data.dayCount;
                        that.yearReportCount = data.yearReportCount;
                        that.everyYearReportCount = data.everyYearReportCount;
                        that.ReportArea = data.ReportArea;
                    } else {
                        that.count = 0;
                        that.sumCount = data.count;
                        that.rowCount = data.count;
                        that.list = [];

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

                        that.dayCount = [];
                        that.yearReportCount = [];
                        that.everyYearReportCount = [];
                        that.ReportArea = [];
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
                        $('.fix-col1').attr("style","z-index:100;left:0px;background:#CCCCCC");
                        $('.fix-col2').attr("style","z-index:100;left:80px;background:#CCCCCC");
                        $('.fix-col3').attr("style","z-index:100;left:"+(94.63 + 80)+"px;background:#CCCCCC");


                        $('.fix-col1-detail').attr("style","z-index:99;left:0px;");
                        $('.fix-col2-detail').attr("style","z-index:99;left:80px;");
                        $('.fix-col3-detail').attr("style","z-index:99;left:"+(94.63 + 80)+"px;");
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