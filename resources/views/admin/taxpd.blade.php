@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '源泉徴収リスト')

<div class="mdk-drawer-layout__content page-content page-notscrool3">
    <!-- Header -->
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
                                    <label class="form-label">支払い月</label>
                                    <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_chuyen_khoan" min="2021-03">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">納税状態</label>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox" id="type1" value="0" v-model="checkedPayStatus" @change="someHandlerChange()">
                                    <label for="type1">未</label>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox" id="type0" value="1" v-model="checkedPayStatus" @change="someHandlerChange()">
                                    <label for="type0">済み</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">納付月</label>
                                    <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="pay_tax_month" min="2021-03">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label m-0">納付日</label>
                                    <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="pay_tax_date" min="2021-03-17">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">受注番号</label>
                                    <input type="text" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="codeJobs">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label class="form-label">ステータス</label>
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
                                        <button type="button" @click="clearSearchStatus()" class="linkCheckboxAll">全てOFF</button>
                                        <button type="button" @click="setSearchStatus()" class="linkCheckboxAll">全てON</button>
                                    </div>
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">通訳月</label>
                                    <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich" min="2021-03">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label m-0">通訳日</label>
                                    <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_phien_dich" min="2021-03-17">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label m-0">住所</label>
                                    <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="conditionAddress">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">営業者</label>
                                    <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_sale">
                                </div>
                            </div>
                            <div class="page-separator-line"></div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">通訳者</label>
                                    <input type="text" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_pd">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="form-label">性別</label>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox" id="sexMale" value="1" v-model="checkedCTVSex" @change="someHandlerChange()">
                                    <label for="sexMale">男性</label>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox" id="sexFemale" value="2" v-model="checkedCTVSex" @change="someHandlerChange()">
                                    <label for="sexFemale">女性</label>
                                </div>
                            </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer  bgTotal" style="text-align:center">
                        <center>
                            <a @click="clearSearch()">
                                <i class="fas fa-backspace" style="color:white;font-size: 22px;"></i><br>
                                <label style="font-size:12px;color:white">クリア</label>
                            </a>
                        </center>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- button control -->
        <!-- <div class="bodyButtonLeft" v-if='isMobile == false'>
            <a type="button" class="btn btn-outline-secondary2" style="background:green" :href="'/admin/pdf-taxpd?' + conditionSearch">
                <i class="fa fa-plus-square"><div class="labelButton">出力</div></i>
            </a>        
        </div> -->
        <div class="bodyButtonTop">
            <a type="button" class="btn btn-outline-secondary3" style="background:green" :href="'/admin/pdf-taxpd?' + conditionSearch">
                <i class="fas fa-file-pdf"><span class="labelButton">源泉徴収納付票(PDF)</span></i>
            </a> 
            <a type="button" class="btn btn-outline-secondary3" style="background:#F119D4" data-toggle="modal" data-target="#myModal" >
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
                        <h5 class="threadLabelCenter">税額合計：(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumTaxPD) ))</h5>
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
                                <option value="1" >受注番号の降順</option>
                                <option value="2" >受注番号の昇順</option>
                                <option value="5" >ステータスの降順</option>
                                <option value="6" >ステータスの昇順</option>
                                <option value="3" >通訳日の降順</option>
                                <option value="4" >通訳日の昇順</option>
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
                                                        <label class="form-label">支払い月</label>
                                                        <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_chuyen_khoan" min="2021-03">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">納税状態</label>
                                                    </div>
                                                    <div class="form-group col-lg-12">
                                                        <input type="checkbox" id="type1" value="0" v-model="checkedPayStatus" @change="someHandlerChange()">
                                                        <label for="type1">未</label>
                                                    </div>
                                                    <div class="form-group col-lg-12">
                                                        <input type="checkbox" id="type0" value="1" v-model="checkedPayStatus" @change="someHandlerChange()">
                                                        <label for="type0">済み</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">納付月</label>
                                                        <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="pay_tax_month" min="2021-03">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label m-0">納付日</label>
                                                        <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="pay_tax_date" min="2021-03-17">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">受注番号</label>
                                                        <input type="text" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="codeJobs">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label">ステータス</label>
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
                                                            <button type="button" @click="clearSearchStatus()" class="linkCheckboxAll">全てOFF</button>
                                                            <button type="button" @click="setSearchStatus()" class="linkCheckboxAll">全てON</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">通訳月</label>
                                                        <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich" min="2021-03">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label m-0">通訳日</label>
                                                        <input type="date" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ngay_phien_dich" min="2021-03-17">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label m-0">住所</label>
                                                        <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="conditionAddress">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">営業者</label>
                                                        <input type="text" class="form-control search" @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_sale">
                                                    </div>
                                                </div>
                                                <div class="page-separator-line"></div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">通訳者</label>
                                                        <input type="text" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="ctv_pd">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label">性別</label>
                                                    </div>
                                                    <div class="form-group col-lg-12">
                                                        <input type="checkbox" id="sexMale" value="1" v-model="checkedCTVSex" @change="someHandlerChange()">
                                                        <label for="sexMale">男性</label>
                                                    </div>
                                                    <div class="form-group col-lg-12">
                                                        <input type="checkbox" id="sexFemale" value="2" v-model="checkedCTVSex" @change="someHandlerChange()">
                                                        <label for="sexFemale">女性</label>
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
                            <div class="bodyContentRight tableFixHead">
                            <table id="gridTable" class="table thead-border-top-0 table-nowrap">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width:100%;" v-if='type_show == 2'>
                                                    <div class="threadLabelCenter">案件</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div id="lblOrderNumber">受注番号 ▼</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div id="lblOrderStatus">ステータス</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div id="lblOrderDate">通訳日</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div>営業者</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div>通訳者</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="threadLabelCenter">支給日</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="threadLabelCenter">支給金額</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="threadLabelCenter">納税日</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                <div class="threadLabelCenter">納付先</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="threadLabelCenter textAlignR">税額</div>
                                                </th>
                                                <th scope="col" v-if='type_show == 1'>
                                                    <div class="threadLabelCenter">納税状態</div>
                                                </th>
                                                <th scope="col"  v-if='type_show == 1' style="width: 100%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="search">
                                            <tr v-for="item in list">
                                                <td v-if='type_show == 2' class="p-0 pl-2 pb-2 fullWidth">
                                                    <p class="rowContent">
                                                        <table class="m-0 table thead-border-top-0 table-nowrap table-mobile">
                                                            <tr>
                                                                <td class="titleTd">受注番号：</td>
                                                                <td>
                                                                    <p class="rowContent">
                                                                        <span> ((item.codejob)) </span><br>
                                                                        <a type="button" class="btn btn-outline-secondary2" style="background:#F36C1F" target="_blank" :href="'/admin/projectview/' + item.id">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </a>
                                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#9863ed" @click="copyClipboad(item)">
                                                                            <i class="fa fa-clipboard"></i>
                                                                        </a>
                                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#57BFFF" @click="copyClipboadLink(item)">
                                                                            <i class="fa fa-link"></i>
                                                                        </a>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">ステータス：</td>
                                                                <td>
                                                                    <p class="rowContent">
                                                                        <span v-if='item.status == 0 || item.status == ""'>受注</span>
                                                                        <span v-if='item.status == 1'>通訳者選定</span>
                                                                        <span v-if='item.status == 2'>通訳待機</span>
                                                                        <span v-if='item.status == 3'>客様の入金確認</span>
                                                                        <span v-if='item.status == 8'>手配料金入金確認</span>
                                                                        <span v-if='item.status == 4'>通訳給与支払い</span>
                                                                        <span v-if='item.status == 5'>営業報酬支払い</span>
                                                                        <span v-if='item.status == 6'>クローズ</span>
                                                                        <span v-if='item.status == 7'>キャンセル</span>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  class="titleTd">通訳日：</td>
                                                                <td>
                                                                    <p class="rowContent">
                                                                        ((item.ngay_pd))
                                                                        <br>
                                                                        ((item.address_pd))
                                                                        <a target="_blank" :href="'https://www.google.co.jp/maps/place/'+item.address_pd">
                                                                            <i class="fas fa-map-marked-alt"></i>
                                                                        </a>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td  class="titleTd">営業者：</td>
                                                                <td>
                                                                    <span v-for="itemCTV in item.ctv_sales_list" >
                                                                        <p class="rowContent">
                                                                            <span>(( parseName(itemCTV.name) ))</span><br>
                                                                            <span>(( parseAddr(itemCTV.address) ))</span><br>
                                                                            <span>(( parsePhone(itemCTV.phone) ))</span><br>
                                                                            <a type="button" class="btn btn-outline-secondary2" style="background:#f9c0f2" target="_blank" :href="'/admin/ctvjobs/edit/' + itemCTV.ctv_jobs_id">
                                                                                <i class="fas fa-info-circle"></i>
                                                                            </a>
                                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:#2362af" @click="copyClipboadCTV(itemCTV)">
                                                                                <i class="fa fa-clipboard"></i>
                                                                            </a>
                                                                        </p>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">通訳者：</td>
                                                                <td>
                                                                    <span v-for="itemCTV in item.ctv_list">
                                                                        <p class="rowContent">
                                                                            (( parseName(itemCTV.name) ))
                                                                            <i v-if="itemCTV.male == 1" class="fa fa-male"></i>
                                                                            <i v-if="itemCTV.male == 2" class="fa fa-female"></i>
                                                                            <br>
                                                                            <span>(( parseAddr(itemCTV.address) )) </span>
                                                                            <a target="_blank" :href="'https://www.google.co.jp/maps/place/'+itemCTV.address">
                                                                                <i class="fas fa-map-marked-alt"></i>
                                                                            </a>
                                                                            <br>
                                                                            <span>(( parsePhone(itemCTV.phone) )) </span>
                                                                            <a :href="'tel:'+itemCTV.phone">
                                                                                <i class="fas fa-phone-square"></i>
                                                                            </a>
                                                                            <br>
                                                                            <a type="button" class="btn btn-outline-secondary2" style="background:#f4d000" target="_blank" :href="'/admin/collaborators/edit/' + itemCTV.user_id">
                                                                                <i class="fas fa-info-circle"></i>
                                                                            </a>
                                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:#b3f791" @click="copyClipboadCTVpd(itemCTV)">
                                                                                <i class="fa fa-clipboard"></i>
                                                                            </a>
                                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:#B8054E" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+itemCTV.address+'&s=1&fl=1&to='+item.address_pd">
                                                                                <i class="fa fa-train"></i>
                                                                            </a>
                                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:green" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+itemCTV.address+'/'+item.address_pd">
                                                                                <i class="fa fa-map"></i>
                                                                            </a>
                                                                        </p>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">支給日：</td>
                                                                <td>
                                                                <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                    ((itemCTV.ngay_chuyen_khoan))
                                                                </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">支給金額：</td>
                                                                <td>
                                                                <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumPhPhienDich) ))
                                                                </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">納税日：</td>
                                                                <td>
                                                                <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                    ((itemCTV.paytaxdate))
                                                                </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">納付先：</td>
                                                                <td>
                                                                    <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                        (( convertTaxPlace(itemCTV.paytaxplace) ))
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">税額：</td>
                                                                <td>
                                                                    <p lass="moneyCol">
                                                                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumThuePhienDich) ))
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="titleTd">納税状態：</td>
                                                                <td>
                                                                    <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                                        (( convertStatusBank(itemCTV.paytaxstatusChecked) ))
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </p>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <p class="rowContent">
                                                        <span> ((item.codejob)) </span><br>
                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#F36C1F" target="_blank" :href="'/admin/projectview/' + item.id">
                                                            <i class="fas fa-info-circle"></i>
                                                        </a>
                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#9863ed" @click="copyClipboad(item)">
                                                            <i class="fa fa-clipboard"></i>
                                                        </a>
                                                        <a type="button" class="btn btn-outline-secondary2"  style="background:#57BFFF" @click="copyClipboadLink(item)">
                                                            <i class="fa fa-link"></i>
                                                        </a>
                                                    </p>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <p class="rowContent">
                                                        <span v-if='item.status == 0 || item.status == ""'>受注</span>
                                                        <span v-if='item.status == 1'>通訳者選定</span>
                                                        <span v-if='item.status == 2'>通訳待機</span>
                                                        <span v-if='item.status == 3'>客様の入金確認</span>
                                                        <span v-if='item.status == 8'>手配料金入金確認</span>
                                                        <span v-if='item.status == 4'>通訳給与支払い</span>
                                                        <span v-if='item.status == 5'>営業報酬支払い</span>
                                                        <span v-if='item.status == 6'>クローズ</span>
                                                        <span v-if='item.status == 7'>キャンセル</span>
                                                    </p>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <p class="rowContent">
                                                        ((item.ngay_pd))
                                                        <br>
                                                        ((item.address_pd))
                                                        <a target="_blank" :href="'https://www.google.co.jp/maps/place/'+item.address_pd">
                                                            <i class="fas fa-map-marked-alt"></i>
                                                        </a>
                                                    </p>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <span v-for="itemCTV in item.ctv_sales_list" >
                                                        <p class="rowContent">
                                                            <span>(( parseName(itemCTV.name) ))</span><br>
                                                            <span>(( parseAddr(itemCTV.address) ))</span><br>
                                                            <span>(( parsePhone(itemCTV.phone) ))</span><br>
                                                            <a type="button" class="btn btn-outline-secondary2" style="background:#f9c0f2" target="_blank" :href="'/admin/ctvjobs/edit/' + itemCTV.ctv_jobs_id">
                                                                <i class="fas fa-info-circle"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:#2362af" @click="copyClipboadCTV(itemCTV)">
                                                                <i class="fa fa-clipboard"></i>
                                                            </a>
                                                        </p>
                                                    </span>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <span v-for="itemCTV in item.ctv_list">
                                                        <p class="rowContent">
                                                            (( parseName(itemCTV.name) ))
                                                            <i v-if="itemCTV.male == 1" class="fa fa-male"></i>
                                                            <i v-if="itemCTV.male == 2" class="fa fa-female"></i>
                                                            <br>
                                                            <span>(( parseAddr(itemCTV.address) )) </span>
                                                            <a target="_blank" :href="'https://www.google.co.jp/maps/place/'+itemCTV.address">
                                                                <i class="fas fa-map-marked-alt"></i>
                                                            </a>
                                                            <br>
                                                            <span>(( parsePhone(itemCTV.phone) )) </span>
                                                            <a :href="'tel:'+itemCTV.phone">
                                                                <i class="fas fa-phone-square"></i>
                                                            </a>
                                                            <br>
                                                            <a type="button" class="btn btn-outline-secondary2" style="background:#f4d000" target="_blank" :href="'/admin/collaborators/edit/' + itemCTV.user_id">
                                                                <i class="fas fa-info-circle"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:#b3f791" @click="copyClipboadCTVpd(itemCTV)">
                                                                <i class="fa fa-clipboard"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-outline-secondary2"  style="background:#B8054E" target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+itemCTV.address+'&s=1&fl=1&to='+item.address_pd">
                                                                <i class="fa fa-train"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-outline-secondary2" style="background:green" target="_blank" :href="'https://www.google.co.jp/maps/dir/'+itemCTV.address+'/'+item.address_pd">
                                                                <i class="fa fa-map"></i>
                                                            </a>
                                                        </p>
                                                    </span>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        ((itemCTV.ngay_chuyen_khoan))
                                                    </p>
                                                </td>
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumPhPhienDich) ))
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        ((itemCTV.paytaxdate))
                                                    </p>
                                                </td>
                                                <td v-if='type_show == 1'>
                                                    <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        (( convertTaxPlace(itemCTV.paytaxplace) ))
                                                    </p>
                                                </td>
                                                <td class="moneyCol" v-if='type_show == 1'>
                                                (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.sumThuePhienDich) ))
                                                </td>
                                                <td style="text-align:center" v-if='type_show == 1'>
                                                    <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                    (( convertStatusBank(itemCTV.paytaxstatusChecked) ))
                                                    </p>
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


$leftBarVal = 0;
new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        conditionSearch: '',
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
        thang_chuyen_khoan: "",
        // thang_chuyen_khoan: "{{date('Y-m')}}",
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        type_jobs: '',
        codeJobs: '',
        checkedNames: [3,4,5,6,8],
        checkedCTVSex: [1,2],
        sortName: '',
        sortType:"DESC",
        sortNameSelect : '1',
		checkedTypes: [1],
        checkedPayStatus: [1],
        pay_tax_month: '',
        pay_tax_date: '',
        showCount: '0',
        isMobile : ( viewPC )? false : true,
        type_show: ( viewPC )? 1 : 2,
        marginTop: "30px;",
        marginLeft: ( viewPC )? "30px;" : "0px;",
        classBodayRightContentGrid: (viewPC)? "bodayRightContentGrid" : "",
        classColLG12: (viewPC)? "col-lg-12" : "",
        sumPhiPD: 0,
        sumTaxPD: 0
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
        sortNgayPD: function() {
            this.sortName = "company.ngay_pd";
            this.onLoadPagination();
        },
        sortJobID: function() {
            this.sortName = "company.codejob";
            this.onLoadPagination();
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
            this.ngay_phien_dich = '';
			this.thang_phien_dich = '';
            this.thang_chuyen_khoan = '';
            this.name_kh = '' ;
            this.ctv_pd = '' ;
            this.type_jobs = '' ;
            this.ctv_sale = '' ;
            this.codeJobs = '';
            this.page = 1;
            this.conditionSearch = "";
            this.checkedNames = [0,1,2,3,4,5,6,8];
			this.checkedTypes = [1];
            this.checkedPayStatus = [0,1];
            this.pay_tax_month = '';
            this.pay_tax_date = '';
            this.checkedCTVSex = [1,2];
            this.sortName = '';  
            this.sortType = "DESC";  
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
        convertStatusBank (value) {
            return (value == "1")? "済み" : "";
        },
        convertTaxPlace (value) {
            return (value == "0")? "" : value;
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
            if (this.ngay_phien_dich != '') {
                conditionSearch += '&ngay_phien_dich=' + this.ngay_phien_dich;
            }
            if (this.thang_phien_dich != '') {
                conditionSearch += '&thang_phien_dich=' + this.thang_phien_dich;
            }
            if (this.thang_chuyen_khoan != '') {
                conditionSearch += '&thang_chuyen_khoan=' + this.thang_chuyen_khoan;
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
            if (this.checkedPayStatus.length > 0) {
                conditionSearch += '&loai_statusbank_multi=' + this.checkedPayStatus.join();
            }
            if (this.pay_tax_month.length > 0) {
                conditionSearch += '&pay_tax_month=' + this.pay_tax_month;
            }
            if (this.pay_tax_date.length > 0) {
                conditionSearch += '&pay_tax_date=' + this.pay_tax_date;
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
                url: "{{route('admin.getListTaxPD')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumCount = data.count;
                        that.sumTaxPD = data.sumTaxPD;
                        that.sumPhiPD = data.sumPhiPD;
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