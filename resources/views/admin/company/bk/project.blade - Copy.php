@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '案件一覧')

<div class="mdk-drawer-layout__content page-content">
    @include('admin.component.header')
    <div id="list-data">
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                
                    <!-- Modal Header -->
                    <div class="modal-header bgTotal">
                        <h5 class="modal-title" style="color:white; text-align:center">検索詳細</h5>
                        <!-- <span class="material-icons" style="color:white"　data-dismiss="modal">&times;</span> -->
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                                <table class="table mb-0 thead-border-top-0 table-nowrap">
                                    <tr>
                                        <td id="searchTr">
                                            <div class="row">
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label m-0">受注月</label>
                                                    <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="dateOrder_month">
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label m-0">受注日</label>
                                                    <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="dateOrder">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-6">                        
                                                    <label class="form-label m-0">通訳月</label>
                                                    <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich"  min="2021-03">
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label m-0">通訳日</label>
                                                    <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_phien_dich" min="2021-03-17">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="akaji" value="0" v-model="checkAkaji" @change="someHandlerChange()">
                                                    <label for="akaji">赤字</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">受注番号</label>
                                                    <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="codeJobs">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">住所</label>
                                                    <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="conditionAddress">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">ステータス</label>
                                                    <button  type="button" @click="clearSearchStatus()"　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てOFF</button>
                                                    <button  type="button" @click="setSearchStatus()" 　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てON</button>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="0" value="0" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="0">受注</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="1" value="1" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="1">通訳者選定</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="2" value="2" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="2">通訳待機</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="3" value="3" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="3">客様の入金確認</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="8" value="8" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="8">手配料金入金確認</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="4" value="4" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="4">通訳給与支払い</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="5" value="5" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="5">営業報酬支払い</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="6" value="6" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="6">クローズ</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="7" value="7" v-model="checkedNames" @change="someHandlerChange()">
                                                    <label for="7">キャンセル</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">営業者</label>
                                                    <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_sale">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">通訳者</label>
                                                    <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_pd">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">種類</label>
                                                    <button type="button" @click="clearSearchTypeJob()"　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てOFF</button>
                                                    <button type="button" @click="setSearchTypeJob()" 　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てON</button>
                                                    
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="type0" value="1" v-model="checkedTypes" @change="someHandlerChange()">
                                                    <label for="type0">パートナー対応</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="type1" value="2" v-model="checkedTypes" @change="someHandlerChange()">
                                                    <label for="type1">通訳手配料のみ</label>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <input type="checkbox" id="type2" value="3" v-model="checkedTypes" @change="someHandlerChange()">
                                                    <label for="type2">従業員対応</label>
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label m-0">並び替え</label>
                                                    <select class="form-control search" id="sortNameSelect" @change="someHandlerChangeSortName()" v-model="sortNameSelect" >
                                                        <option value="1" >受注番号の降順</option>
                                                        <option value="2" >受注番号の昇順</option>
                                                        <option value="3" >通訳日の降順</option>
                                                        <option value="4" >通訳日の昇順</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <!-- <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label">表示切替</label>
                                                    <div class="custom-controls-stacked">
                                                        <div class="custom-control custom-radio">
                                                            <input id="radiotype1" @change="showView()"　type="radio" class="custom-control-input"
                                                                v-model="type_show" value="1">
                                                            <label for="radiotype1" class="custom-control-label">グリッド</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input id="radiotype2" @change="showView()" type="radio" class="custom-control-input"
                                                            v-model="type_show" value="2">
                                                            <label for="radiotype2" class="custom-control-label">ビュー</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer  bgTotal" style="text-align:center">
                        <table style="width:100%">
                            <tr>
                                <td>
                                    <center>
                                        <a @click="clearSearch()">
                                            <span class="material-icons" style="color:white;font-size: 32px;">layers_clear</span><br>
                                            <label style="font-size:12px;color:white">クリア</label>
                                        </a>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a @click="resetSearch()">
                                            <span class="material-icons" style="color:white;font-size: 32px;">reset_tv</span><br>
                                            <label style="font-size:12px;color:white">リセット</label>
                                        </a>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a data-dismiss="modal">
                                            <span class="material-icons" style="color:white;font-size: 32px;">close</span><br>
                                            <label style="font-size:12px;color:white">閉じる</label>
                                        </a>
                                    </center>
                                </td>
                            </tr>  
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="container page__container page-section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex" style="max-width: 100%">
                        <div class="col-auto group_flex">
                            <a type="button" class="btn btn-primary" href="/admin/projectnew" >
                                <span class="material-icons" style="font-size:20px;">add</span>新規登録
                            </a>
                            <a type="button" class="btn btn-info" href="/admin/calendar">
                                <span class="material-icons" style="font-size:20px;">event</span>予定表
                            </a>
                            <a id="searchButton" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success">
                                <span class="material-icons" style="font-size:20px;">search</span>検索
                            </a>
                        </div>
                        
                        <div style="text-align:right;">
                            <label class="form-label">表示件数</label>
                            <select id="showCount" @change="someHandlerChangeShowCount()" v-model="showCount" >
                                <option value="20" >20</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="0" >全て</option>
                            </select>
                            <label class="form-label m-10">of ((sumCount)) 件</label> 
                            <br>
                            <label class="form-label m-0">並び替え</label>
                            <select id="sortNameSelect" @change="someHandlerChangeSortName()" v-model="sortNameSelect" style="margin-bottom:10px;">
                                 <option value="1" >受注番号の降順</option>
                                <option value="2" >受注番号の昇順</option>
                                <option value="5" >ステータスの降順</option>
                                <option value="6" >ステータスの昇順</option>
                                <option value="3" >通訳日の降順</option>
                                <option value="4" >通訳日の昇順</option>
                            </select>
                            <label class="form-label" style="margin-left: 10px;">表示切替</label>
                            <a @click="showView()"><i class="material-icons">fullscreen</i></a>
                            <a @click="showGrid()"><i class="material-icons">view_headline</i></a>
                        </div>
                        <div class="bodyContent">
                            <div class="bodyContentLeft">
                                <div class="table-responsive">
                                    <table class="table mb-0 thead-border-top-0 table-nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100%; ">
                                                    <center>検索</center>
                                                </th>
                                            </tr>
                                        </thead>
                                            <tr>
                                                <td>
                                                <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label class="form-label m-0">受注月</label>
                                                <input type="month" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="dateOrder_month">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="form-label m-0">受注日</label>
                                                <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="dateOrder">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">                        
                                                <label class="form-label m-0">通訳月</label>
                                                <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich"  min="2021-03">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="form-label m-0">通訳日</label>
                                                <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_phien_dich" min="2021-03-17">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="akaji" value="0" v-model="checkAkaji" @change="someHandlerChange()">
                                                <label for="akaji">赤字</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">受注番号</label>
                                                <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="codeJobs">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">住所</label>
                                                <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="conditionAddress">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">ステータス</label>
                                                <button  type="button" @click="clearSearchStatus()"　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てOFF</button>
                                                <button  type="button" @click="setSearchStatus()" 　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てON</button>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="0" value="0" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="0">受注</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="1" value="1" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="1">通訳者選定</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="2" value="2" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="2">通訳待機</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="3" value="3" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="3">客様の入金確認</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="8" value="8" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="8">手配料金入金確認</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="4" value="4" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="4">通訳給与支払い</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="5" value="5" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="5">営業報酬支払い</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="6" value="6" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="6">クローズ</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="7" value="7" v-model="checkedNames" @change="someHandlerChange()">
                                                <label for="7">キャンセル</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">営業者</label>
                                                <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_sale">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">通訳者</label>
                                                <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_pd">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">種類</label>
                                                <button type="button" @click="clearSearchTypeJob()"　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てOFF</button>
                                                <button type="button" @click="setSearchTypeJob()" 　style="background: none!important;border: none;text-decoration: underline;cursor: pointer;">全てON</button>
                                                
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="type0" value="1" v-model="checkedTypes" @change="someHandlerChange()">
                                                <label for="type0">パートナー対応</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="type1" value="2" v-model="checkedTypes" @change="someHandlerChange()">
                                                <label for="type1">通訳手配料のみ</label>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <input type="checkbox" id="type2" value="3" v-model="checkedTypes" @change="someHandlerChange()">
                                                <label for="type2">従業員対応</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table style="width:100%">
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <a type="button" class="btn btn-warning" @click="resetSearch()">
                                                                <span class="material-icons" style="font-size:20px;">reply</span>デフォルトに戻す
                                                            </a>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <a type="button" class="btn btn-danger" @click="clearSearch()">
                                                                <span class="material-icons" style="font-size:20px;">layers_clear</span>すべてクリア
                                                            </a>
                                                        </center>
                                                    </td>
                                                </tr>  
                                            </table>
                                        </div>

                                        <!-- <div class="page-separator">
                                            <div class="page-separator__text" style="background:none">表示</div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label m-0">並び替え</label>
                                                <select class="form-control search" id="sortNameSelect" @change="someHandlerChangeSortName()" v-model="sortNameSelect" >
                                                    <option value="0" >標準</option>
                                                    <option value="1" >受注番号の降順</option>
                                                    <option value="2" >受注番号の昇順</option>
                                                    <option value="3" >通訳日の降順</option>
                                                    <option value="4" >通訳日の昇順</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row">
                                            <div class="form-group col-lg-12">
                                                <label class="form-label">表示切替</label>
                                                <div class="custom-controls-stacked">
                                                    <div class="custom-control custom-radio">
                                                        <input id="radiotype1" @change="showView()"　type="radio" class="custom-control-input"
                                                            v-model="type_show" value="1">
                                                        <label for="radiotype1" class="custom-control-label">グリッド</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input id="radiotype2" @change="showView()" type="radio" class="custom-control-input"
                                                        v-model="type_show" value="2">
                                                        <label for="radiotype2" class="custom-control-label">ビュー</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="bodyContentRight">
                                <div class="table-responsive">
                                    <table id="gridTable" class="table mb-0 thead-border-top-0 table-nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="text-align:center">
                                                    <div id="lblOrderNumber">受注番号 ▼</div>
                                                </th>
                                                <th scope="col" style="text-align:center">
                                                    <div  id="lblOrderStatus">ステータス</div>
                                                </th>
                                                <th scope="col" style="text-align:center">
                                                    <div id="lblOrderDate">通訳日</div>
                                                </th>
                                                <th scope="col" style="text-align:center">営業者</th>
                                                <th scope="col" style="text-align:center">通訳者</th>
                                                <th scope="col" style="text-align:center">売上予測</th>
                                                <th scope="col" style="text-align:center">利益予測</th>
                                                <th scope="col" style="text-align:center">営業報酬</th>
                                                <th scope="col" style="text-align:center">通訳給与</th>
                                                <th scope="col" style="text-align:center">源泉所得税</th>
                                                <th scope="col" style="text-align:center">交通費</th>
                                                <th scope="col" style="text-align:center">振込手数料</th>
                                                <th scope="col" style="width: 100%; "></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="search">
                                            <tr v-for="item in list">
                                                
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <p style="color:grey" v-if='item.status == 7'>
                                                            <s>
                                                                <a style="color:red" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                <img style="margin:3px" border="0" src="/assets/images/cancel.png" width="16" height="16">
                                                                ((item.codejob))
                                                                </a>
                                                            </s>
                                                        </p>
                                                        <p v-if='item.tong_kimduocdukien < 0 && item.status != 7'>
                                                            <a style="color:red" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name btn btn-outline-secondary">
                                                            <img style="margin:3px" border="0" src="/assets/images/warning-emoji.png" width="16" height="16">
                                                            ((item.codejob))
                                                            </a>
                                                        </p>
                                                        <p v-if='item.tong_kimduocdukien >= 0 && item.status != 7'>
                                                            <a :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name btn btn-outline-secondary">
                                                            ((item.codejob))
                                                            </a>
                                                         </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <p style="color:grey" v-if='item.status == 7'>
                                                            <span class="mb-0" v-if='item.status == 0 || item.status == ""'>受注</span>
                                                            <span class="mb-0" v-if='item.status == 1'>通訳者選定</span>
                                                            <span class="mb-0" v-if='item.status == 2'>通訳待機</span>
                                                            <span class="mb-0" v-if='item.status == 3'>客様の入金確認</span>
                                                            <span class="mb-0" v-if='item.status == 8'>手配料金入金確認</span>
                                                            <span class="mb-0" v-if='item.status == 4'>通訳給与支払い</span>
                                                            <span class="mb-0" v-if='item.status == 5'>営業報酬支払い</span>
                                                            <span class="mb-0" v-if='item.status == 6'>クローズ</span>
                                                            <span class="mb-0" v-if='item.status == 7'>キャンセル</span>
                                                        </p>
                                                        <p v-if='item.tong_kimduocdukien < 0 && item.status != 7'>
                                                            <span class="mb-0" v-if='item.status == 0 || item.status == ""'>受注</span>
                                                            <span class="mb-0" v-if='item.status == 1'>通訳者選定</span>
                                                            <span class="mb-0" v-if='item.status == 2'>通訳待機</span>
                                                            <span class="mb-0" v-if='item.status == 3'>客様の入金確認</span>
                                                            <span class="mb-0" v-if='item.status == 8'>手配料金入金確認</span>
                                                            <span class="mb-0" v-if='item.status == 4'>通訳給与支払い</span>
                                                            <span class="mb-0" v-if='item.status == 5'>営業報酬支払い</span>
                                                            <span class="mb-0" v-if='item.status == 6'>クローズ</span>
                                                            <span class="mb-0" v-if='item.status == 7'>キャンセル</span>
                                                        </p>
                                                        <p v-if='item.tong_kimduocdukien >= 0 && item.status != 7'>
                                                            <span class="mb-0" v-if='item.status == 0 || item.status == ""'>受注</span>
                                                            <span class="mb-0" v-if='item.status == 1'>通訳者選定</span>
                                                            <span class="mb-0" v-if='item.status == 2'>通訳待機</span>
                                                            <span class="mb-0" v-if='item.status == 3'>客様の入金確認</span>
                                                            <span class="mb-0" v-if='item.status == 8'>手配料金入金確認</span>
                                                            <span class="mb-0" v-if='item.status == 4'>通訳給与支払い</span>
                                                            <span class="mb-0" v-if='item.status == 5'>営業報酬支払い</span>
                                                            <span class="mb-0" v-if='item.status == 6'>クローズ</span>
                                                            <span class="mb-0" v-if='item.status == 7'>キャンセル</span>
                                                         </p>
                                                    </div>
                                                </td>
                                                <td >
                                                    <p class="rowContent">((item.ngay_pd))<br>((item.address_pd))</p>
                                                </td>
                                                <td>
                                                    <span class="mb-0" v-for="itemCTV in item.ctv_sales_list" >
                                                        <p class="rowContent upperCase">
                                                            <a  :href="'/admin/ctvjobs/edit/' + itemCTV.ctv_jobs_id" >((itemCTV.name))</a> <br>
                                                                (( parseAddr(itemCTV.address) )) <br>
                                                                (( parsePhone(itemCTV.phone) ))
                                                        </p>
                                                    </span>
                                                </td>
                                                <td >
                                                    <span class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        <p class="rowContent upperCase">
                                                            <img v-if="itemCTV.male == 2" style="color:red;width:14px;height:16px;margin-bottom:8px" src="{{ asset('assets/images/women.png') }}"></img>
                                                                <img v-if="itemCTV.male == 1" style="color:red;width:14px;height:16px;margin-bottom:8px" src="{{ asset('assets/images/men.png') }}"></img>
                                                                <a  :href="'/admin/collaborators/edit/' + itemCTV.user_id" >((itemCTV.name))</a> <br>
                                                                (( parseAddr(itemCTV.address) )) <br>
                                                                (( parsePhone(itemCTV.phone) ))  
                                                        </p>
                                                    </span>
                                                </td>
                                                <td style="text-align:right">
                                                    <div class="d-flex flex-column">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_thu_du_kien) ))</div>
                                                </td>
                                                <td style="text-align:right">
                                                    <div class="d-flex flex-column">
                                                        <p style="color:red" class="mb-0" v-if='item.tong_kimduocdukien < 0'>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_kimduocdukien) ))</p>
                                                        <p class="mb-0" v-if='item.tong_kimduocdukien >= 0'>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_kimduocdukien) ))</p>
                                                    </div>
                                                </td>
                                                <td style="text-align:right">
                                                    <div class="d-flex flex-column">
                                                        <table cellspacing="0" cellpadding="0" style="border:0;">
                                                            <tr style="border:0;">
                                                            <td style="border:0;padding: 2px;text-transform: uppercase;">
                                                            <p class="mb-0" v-for="itemCTV in item.ctv_sales_list" >
                                                            (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(itemCTV.price_total) ))
                                                            </p>
                                                            </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td style="text-align:right">
                                                    <div class="d-flex flex-column">
                                                        <table cellspacing="0" cellpadding="0" style="border:0;">
                                                            <tr style="border:0;">
                                                            <td style="border:0;padding: 2px;text-transform: uppercase;">
                                                            <p class="mb-0" v-for="itemCTV in item.ctv_sales_list" >
                                                            (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumPhPhienDich) ))
                                                            </p>
                                                            </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td style="text-align:right">
                                                    <div class="d-flex flex-column">
                                                        <table cellspacing="0" cellpadding="0" style="border:0;">
                                                            <tr style="border:0;">
                                                            <td style="border:0;padding: 2px;text-transform: uppercase;">
                                                            <p class="mb-0" v-for="itemCTV in item.ctv_sales_list" >
                                                            (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumThuePhienDich) ))
                                                            </p>
                                                            </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td style="text-align:right">
                                                <div class="d-flex flex-column">
                                                        <table cellspacing="0" cellpadding="0" style="border:0;">
                                                            <tr style="border:0;">
                                                            <td style="border:0;padding: 2px;text-transform: uppercase;">
                                                            <p class="mb-0" v-for="itemCTV in item.ctv_sales_list" >
                                                            (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumPhiGiaoThong) ))
                                                            </p>
                                                            </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td style="text-align:right">
                                                    <div class="d-flex flex-column">
                                                        <table cellspacing="0" cellpadding="0" style="border:0;">
                                                            <tr style="border:0;">
                                                            <td style="border:0;padding: 2px;text-transform: uppercase;">
                                                            (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumPhiChuyenKhoanSale) ))
                                                            </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        <div class="col-auto group_flex2">
                                                            <a type="button" class="btn btn-warning" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+itemCTV.address+'&s=1&fl=1&to='+item.address_pd">
                                                                <i class="fa fa-train"></i> 乗換案内
                                                            </a>
                                                            <a type="button" class="btn btn-warning" style="background:green" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+itemCTV.address+'/'+item.address_pd">
                                                                <i class="fa fa-map"></i> Google Maps
                                                            </a>
                                                            <a type="button" class="btn btn-warning" style="background:purple" @click="copyClipboad(item)">
                                                                <i class="fa fa-clipboard"></i> クリップボードコピー
                                                            </a>
                                                            <a type="button" class="btn btn-warning" style="background:pink" @click="copyClipboad2(item)">
                                                                <i class="fa fa-link"></i> リンクコピー
                                                            </a>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="viewTable" class="table mb-0 thead-border-top-0 table-nowrap" style="display:none">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100%; ">
                                                    <center>内容</center>
                                                </th>
                                                <th scope="col" style="width: 100%; "></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="search">
                                            <tr v-for="item in list">
                                                <td >
                                                    <div class="d-flex flex-column">
                                                        <table class="table mb-0 thead-border-top-0 table-nowrap table-mobile">
                                                            
                                                            <tr >
                                                                <td class="titleTd">受注番号：</td>
                                                                <td >
                                                                    <span style="color:grey" v-if='item.status == 7'>
                                                                        <s>
                                                                            <a style="color:red" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
                                                                            <img style="margin-bottom:3px" border="0" src="/assets/images/cancel.png" width="16" height="16">
                                                                            ((item.codejob))
                                                                            </a>
                                                                        </s>
                                                                    </span>
                                                                    <span v-if='item.tong_kimduocdukien < 0 && item.status != 7'>
                                                                        <a style="color:red" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
                                                                        <img style="margin-bottom:7px" border="0" src="/assets/images/warning-emoji.png" width="16" height="16">
                                                                        ((item.codejob))
                                                                        </a>
                                                                    </span>
                                                                    <span v-if='item.tong_kimduocdukien >= 0 && item.status != 7'>
                                                                        <a :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
                                                                        ((item.codejob))
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">ステータス：</td>
                                                                <td>
                                                                    <span class="rowContent" v-if='item.status == 0 || item.status == ""'>受注</span>
                                                                    <span class="rowContent" v-if='item.status == 1'>通訳者選定</span>
                                                                    <span class="rowContent" v-if='item.status == 2'>通訳待機</span>
                                                                    <span class="rowContent" v-if='item.status == 3'>客様の入金確認</span>
                                                                    <span class="rowContent" v-if='item.status == 8'>手配料金入金確認</span>
                                                                    <span class="rowContent" v-if='item.status == 4'>通訳給与支払い</span>
                                                                    <span class="rowContent" v-if='item.status == 5'>営業報酬支払い</span>
                                                                    <span class="rowContent" v-if='item.status == 6'>クローズ</span>
                                                                    <span class="rowContent" v-if='item.status == 7'>キャンセル</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  class="titleTd">通訳日：</td>
                                                                <td >
                                                                    <span class="rowContent">((item.ngay_pd))<br>((item.address_pd))</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  class="titleTd">営業者：</td>
                                                                <td>
                                                                    <span class="mb-0" v-for="itemCTV in item.ctv_sales_list" >
                                                                        <span class="rowContent upperCase">
                                                                            <a  :href="'/admin/ctvjobs/edit/' + itemCTV.ctv_jobs_id" >((itemCTV.name))</a> <br>
                                                                            (( parseAddr(itemCTV.address) )) <br>
                                                                                (( parsePhone(itemCTV.phone) ))
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  class="titleTd">通訳者：</td>
                                                                <td>
                                                                    <span class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                        <span class="rowContent upperCase">
                                                                            <img v-if="itemCTV.male == 2" style="color:red;width:14px;height:16px;margin-bottom:8px" src="{{ asset('assets/images/women.png') }}"></img>
                                                                                <img v-if="itemCTV.male == 1" style="color:red;width:14px;height:16px;margin-bottom:8px" src="{{ asset('assets/images/men.png') }}"></img>
                                                                                <a  :href="'/admin/collaborators/edit/' + itemCTV.user_id" >((itemCTV.name))</a> <br>
                                                                                (( parseAddr(itemCTV.address) )) <br>
                                                                                (( parsePhone(itemCTV.phone) ))
                                                                        </span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td   class="titleTd">売上予測：</td>
                                                                <td >
                                                                <span class="rowContent" >(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_thu_du_kien) ))</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  class="titleTd">利益予測：</td>
                                                                <td >
                                                                    <span class="rowContent" style="color:red" class="mb-0" v-if='item.tong_kimduocdukien < 0'>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_kimduocdukien) ))</span>
                                                                    <span class="rowContent" v-if='item.tong_kimduocdukien >= 0'>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_kimduocdukien) ))</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <span class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                        <div class="col-auto group_flex2">
                                                                            <a type="button" class="btn btn-warning" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+itemCTV.address+'&s=1&fl=1&to='+item.address_pd">
                                                                                <i class="fa fa-train"></i> 乗換案内
                                                                            </a>
                                                                            <a type="button" class="btn btn-warning" style="background:green" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+itemCTV.address+'/'+item.address_pd">
                                                                                <i class="fa fa-map"></i> Google Maps
                                                                            </a>
                                                                            <a type="button" class="btn btn-warning" style="background:purple" @click="copyClipboad(item)">
                                                                                <i class="fa fa-clipboard"></i> クリップボードコピー
                                                                            </a>
                                                                            <a type="button" class="btn btn-warning" style="background:pink" @click="copyClipboad2(item)">
                                                                                <i class="fa fa-link"></i> リンクコピー
                                                                            </a>
                                                                        </div>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>                       
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
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$leftBarVal = 0;
$leftSearchVal = 0;
new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
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
        type_jobs: '',
        codeJobs: '',
        checkedNames: [0,1,2,3,4,5,6,8],
		checkedTypes: [1,2,3],
        sortName: '',
        sortType:"DESC",
        nosearchBar: 0,
        sortNameSelect : '1',
        showCount: '20',
        type_show: 1,
        checkAkaji: 0
    },
    delimiters: ["((", "))"],
    mounted() {
        if( !/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $("#searchLeftBar").css("display","block");
            $("#searchButton").css("display","none");
        } else {
            $("#searchLeftBar").css("display","none");
            $("#searchButton").css("display","block");
            this.showView();
        }
        this.onLoadPagination();
    },
    methods: {
        copyClipboad(_i) {
            $('#copyName').html(_i.codejob);
            $('#copyFurigana').html(_i.ngay_pd);
            $('#copyPhone').html(_i.address_pd);

            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();

        },
        copyClipboad2(_i) {
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            baseUrl = baseUrl + "/projectview/" + _i.id;

            $('#copyName').html(baseUrl);

            var $temp = $("<textarea>");
            var brRegex = /<br\s*[\/]?>/gi;
            $("body").append($temp);
            var str = $("#error-details").html().replace(brRegex, "\r");
            str = str.replace(/<\/?span[^>]*>/g,"");
            $temp.val(str).select();
            document.execCommand("copy");
            $temp.remove();

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
            this.type_jobs = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1,2,3];
            this.sortName = '';  
            this.sortType = "DESC";     
            this.type_show= 1;  
            this.checkAkaji= 0;   
            
            this.onLoadPagination();
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
        someHandlerChangeSortName () {
            if (this.sortNameSelect == 0) {
                this.sortName = "company.id";
                this.sortType = "DESC";
                $("#lblOrderNumber").text("受注番号");   
                $("#lblOrderStatus").text("ステータス"); 
                $("#lblOrderDate").text("通訳日");                 
            } else if (this.sortNameSelect == 1) {
                this.sortName = "company.codejob";
                this.sortType = "DESC";
                $("#lblOrderNumber").text("bb");
                $("#lblOrderNumber").text("受注番号 ▼");
                $("#lblOrderStatus").text("ステータス"); 
                $("#lblOrderDate").text("通訳日");       
            } else if (this.sortNameSelect == 2) {
                this.sortName = "company.codejob";
                this.sortType = "ASC";
                $("#lblOrderNumber").text("受注番号 ▲"); 
                $("#lblOrderDate").text("通訳日");     
                $("#lblOrderStatus").text("ステータス");   
            } else if (this.sortNameSelect == 3) {
                this.sortName = "company.ngay_pd";
                this.sortType = "DESC";
                $("#lblOrderNumber").text("受注番号");   
                $("#lblOrderDate").text("通訳日 ▼"); 
                $("#lblOrderStatus").text("ステータス");       
            } else if (this.sortNameSelect == 4) {
                this.sortName = "company.ngay_pd";
                this.sortType = "ASC";
                $("#lblOrderNumber").text("受注番号");   
                $("#lblOrderDate").text("通訳日 ▲");  
                $("#lblOrderStatus").text("ステータス");      
            } else if (this.sortNameSelect == 5) {
                this.sortName = "company.status";
                this.sortType = "DESC";
                $("#lblOrderNumber").text("受注番号");   
                $("#lblOrderDate").text("通訳日");
                $("#lblOrderStatus").text("ステータス ▼");    
            } else if (this.sortNameSelect == 6) {
                this.sortName = "company.status";
                this.sortType = "ASC";
                $("#lblOrderNumber").text("受注番号");   
                $("#lblOrderDate").text("通訳日");
                $("#lblOrderStatus").text("ステータス ▲");    
            }
            this.page = 1;
            this.onLoadPagination();
        },
        sortNgayPD: function() {
            this.sortName = "company.ngay_pd";
            this.onLoadPagination();
        },
        sortJobID: function() {
            this.sortName = "company.codejob";
            this.onLoadPagination();
        },
        showSearchTr: function() {
            if (this.nosearchBar == 0) {
                $("#searchTr").css("display","block");
                this.nosearchBar = 1; 
            } else {
                $("#searchTr").css("display","none");
                this.nosearchBar = 0;
            }
        },
        showGrid: function() {
            $("#viewTable").css("display","none");
            $("#gridTable").css("display","block");
        },
        showView: function() {
            $("#gridTable").css("display","none");
            $("#viewTable").css("display","block");
        },
        showSearch: function() {
            if (this.nosearchBar == 0) {
                $("#searchRow").css("display","none"); 
                $("#searchRow2").css("display","none");
                $("#nosearchRow").css("display","block");
                this.nosearchBar = 1; 
            } else {
                $("#searchRow2").css("display","block");
                $("#searchRow").css("display","block"); 
                $("#nosearchRow").css("display","none");
                this.nosearchBar = 0;
            }
        },
        showLeftBar: function() {
            if ($leftBarVal == 0) {
                $("#default-drawer").css("display","none");
                $leftBarVal = 1;
            } else {
                $("#default-drawer").css("display","block");
                $leftBarVal = 0;
            }
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
            this.type_jobs = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.checkedNames = [0,1,2,3,4,5,6,7,8];
			this.checkedTypes = [1,2,3];
            this.sortName = '';  
            this.sortType = "DESC";     
            this.type_show= 1;    
            this.checkAkaji= 0;     
            
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
                    url: "/admin/company/delete/" + _i.id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        that.loadingTable = 0;
                        that.onLoadPagination();
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
        // ham thi de day 
        parseAddr(value) {
            if (value == null || value == undefined || value == "") {
                return '-';
            }
            return value;
        },
        parsePhone(value) {
            if (value == null || value == undefined || value == "") {
                return '-';
            }
            value = new String(value); 
            value.replaceAll('-', '');
            value.replaceAll(' ', '');
            if (value.length == 11) {
                value = value.substr(0, 3) + "-" + value.substr(3, 4) + "-" + value.substr(6, 4);
            } else if (value.length == 10) {
                value = value.substr(0, 3) + "-" + value.substr(3, 4) + "-" + value.substr(6, 3);
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
            if (this.type_jobs != '') {
                conditionSearch += '&type_jobs=' + this.type_jobs;
            }
            if (this.dateOrder != '') {
                conditionSearch += '&date_start=' + this.dateOrder;
            }
            if (this.dateOrder_month != '') {
                conditionSearch += '&date_start_month=' + this.dateOrder_month;
            }
            if (this.ngay_phien_dich != '') {
                conditionSearch += '&ngay_phien_dich=' + this.ngay_phien_dich;
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
            if (this.checkedNames.length > 0) {
                conditionSearch += '&status_multi=' + this.checkedNames.join();
            }
            if (this.checkedTypes.length > 0) {
                conditionSearch += '&loai_job_multi=' + this.checkedTypes.join();
            }
            if (this.sortName != '') {
                conditionSearch += '&sortname=' + this.sortName;
                conditionSearch += '&sorttype=' + this.sortType;                
            }
            if (this.checkAkaji != 0) {
                conditionSearch += '&check_akaji=' + this.checkAkaji;
            }
            conditionSearch += '&showcount=' + this.showCount;           

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCompany')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
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
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",

                    });
                }
            });
        
			
		},
        hideSearch() {
            if ($leftSearchVal == 0) {
                $("#default-drawer").css("display","none");
                $leftSearchVal = 1;
            } else {
                $("#default-drawer").css("display","block");
                $leftSearchVal = 0;
            }
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