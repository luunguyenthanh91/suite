@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')
@section('contentTitle', '源泉徴収リスト')

<div class="mdk-drawer-layout__content page-content page-notscrool">
    <!-- Header -->
    @include('admin.component.header')
    
    <!-- content -->
    <div id="list-data">

        <!-- button control -->
        <div class="bodyButtonLeft" v-if='isMobile == false'>
            <a target="_blank" :href="'/admin/company/pdf-taxpd?' + conditionSearch"
                class="btn btn-warning">出力</a>
            <a target="_blank" href="" class="btn btn-success">グラフ</a></div>        
        </div>
        <div class="bodyButtonTop" v-if='isMobile == true'>
            
        </div>


        <div class="container page__container page-section" :style="'margin-top: ' + marginTop + 'margin-left: ' + marginLeft + 'margin-right: '+marginRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="flex bodayRightContentGrid">
                        <!-- grid control -->
                        <div class="gridControl">
                            <label class="form-label">表示件数</label>
                            <select id="showCount" @change="someHandlerChangeShowCount()" v-model="showCount" >
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="0">全て</option>
                            </select>
                            <label class="form-label">of ((sumCount)) 件</label> 
                            <br>
                            <label class="form-label">支給額合計：</label>
                             (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumPhiPD) ))
                            <br>
                            <label class="form-label">税額合計：</label>
                            (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumTaxPD) ))
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
                            <div class="bodyContentLeft">
                                <div>
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
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label">支払い月</label>
                                                    <input type="month" class="form-control search"  @change="someHandlerChange()" v-on:keyup.enter="someHandlerChange()" v-model="thang_chuyen_khoan" min="2021-03">
                                                </div>
                                            </div>


                <div class="col-lg-2">
                    <div @click="showLeftBar()" style="text-decoration: underline">源泉徴収リスト</div>
                    <div class="form-label m-10">(パートナー通訳給与)</div>
                </div>
                <div class="col-lg-7">
                <center>
                    <div><label class="form-label m-10">表示件数： ((list.length)) 件</label><div>
                    <div style="margin-top:-10px"><label class="form-label">支給額合計：<label>
                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumPhiPD) ))
                    </label></label>
                    </div>
                    <div style="margin-top:-15px"><label class="form-label">税額合計：<label style="color:red">
                    (( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(sumTaxPD) ))
                    </label></label>
                    </div>
                    </center>
                </div>
                <div class="col-lg-3">
                    <div style="text-align:right; margin:10px">
                    <a target="_blank" :href="'/admin/company/pdf-taxpd?' + conditionSearch"
                      class="btn btn-warning">出力</a>
                    <a target="_blank" href="" class="btn btn-success">グラフ</a></div>
                </div>
            </div>
        </h1>
    </div>

        <div class="container page__container page-section" style="margin-top:-40px">
            
            <div class="row mb-32pt" >
            
            <div class="col-lg-2">
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">給与支給月</label>
                        <input type="month" class="form-control search"  @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="thang_chuyen_khoan" min="2021-03">
                            
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">通訳月</label>
                        <input type="month" class="form-control search"  @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="thang_phien_dich" min="2021-03">
                            
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">通訳者</label>
                        <input type="text" class="form-control search" @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="ctv_pd">
                            
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">受注番号</label>
                        <input type="text" class="form-control search" @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="codeJobs">
                            
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">ステータス</label>
						<button type="button" @click="clearSearchStatus()"　style="background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;">全てOFF</button>
						
						<button type="button" @click="setSearchStatus()" 　style="background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;">全てON</button>
                        <div class="form-group" >
                            <!-- <div class="col-lg-12 p-0">
                                <input type="checkbox" id="0" value="0" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="0">受注</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="1" value="1" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="1">通訳者選定</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="2" value="2" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="2">通訳待機</label>
                            </div> -->
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="3" value="3" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="3">客様の入金確認</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="4" value="4" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="4">通訳給与支払い</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="5" value="5" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="5">営業報酬支払い</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="8" value="8" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="8">手配料金入金確認</label>
                            </div>
                            <div class="col-lg-12 p-0">
                                <input type="checkbox" id="6" value="6" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="6">クローズ</label>
                            </div>
                            <!-- <div class="col-lg-12 p-0">
                                <input type="checkbox" id="7" value="7" v-model="checkedNames" @change="someHandlerChange()">
                                <label for="7">キャンセル</label>
                            </div> -->
                        </div>
                            
                    </div>
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">通訳日</label>
                        <input type="date" class="form-control search" @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="ngay_phien_dich">
                    </div>
					
                    <div class="form-group col-lg-12" style="display : none">
                        <label class="form-label m-0">住所</label>
                        <input type="text" class="form-control search" @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="conditionAddress">
                            
                    </div>
                    
                    <div class="form-group col-lg-12">
                        <label class="form-label m-0">受注日</label>
                        <input type="date" class="form-control search" @change="someHandlerChange()"
                                v-on:keyup.enter="someHandlerChange()" v-model="dateOrder">
                            
                    </div>
                    <div class="form-group col-lg-12 btn-center">
                        <button class="btn btn-primary col-lg-12" type="button" @click="someHandlerChange()">検索</button>
                    </div>
                    <div class="form-group col-lg-12 btn-center">
                        <button class="btn btn-danger col-lg-12 mt-2" type="button" @click="clearSearch()">クリア</button>
                    </div>

                </div>

                <div class="col-lg-10 d-flex ">
					
                    <div class="flex" style="max-width: 100%">

                        <div class="card m-0">

                            <div class="table-responsive">

                                <table class="table mb-0 thead-border-top-0 table-nowrap">
									<thead class="thead-light">
										<tr>
											<!-- <th scope="col"></th> -->
											<th scope="col">
                                            <center @click="sortJobID()" style="text-decoration: underline">受注番号</center>
                                            </th>
											<th scope="col">
                                            <center @click="sortNgayPD()" style="text-decoration: underline">通訳日</center>
                                            </th>
											<!-- <th scope="col">住所</th> -->
											<th scope="col">通訳者</th>
											<!--<th scope="col">受注日</th>-->
											<th scope="col">ステータス</th>
											<!-- <th scope="col">通訳者</th>
											<th scope="col" style="text-align:center">売上</th> -->
											<!-- <th scope="col" style="text-align:center">振込金額</th>
											<th scope="col" style="text-align:center">手数料</th> -->
											<th scope="col">給与支給日</th>
											<th scope="col" style="text-align:center">給与支給合計額</th>
											<th scope="col">納付先</th>
											<th scope="col">納税日</th>
											<th scope="col" style="text-align:center">課税対象額</th>
											<th scope="col" style="text-align:center">税額</th>
											<th scope="col" style="text-align:center">納税済み</th>
											<!-- <th scope="col" style="text-align:center">交通費</th>
											<th scope="col" style="text-align:center">純利益</th> -->
											<th scope="col" style="width: 100%; "></th>
										</tr>
									</thead>
								
                                    <tbody class="list" id="search">
                                        <tr v-for="item in list">
											<!-- <td>
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;">
															 <a target="_blank" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
																<i class="fas fa-info-circle"></i>
															</a>
														</td>
														</tr>
													</table>
                                                </div>
                                            </td> -->
                                            <td>
                                                
                                                <div class="d-flex flex-column">
                                                    <table cellspacing="0" cellpadding="0" style="border:0;">
                                                        <tr style="border:0;">
                                                        <td style="border:0;padding: 2px;">
                                                        <!--
                                                        <p style="color:grey" v-if='item.status == 0 || item.status == 1 || item.status == 2 || item.status == ""' class="mb-0 btn btn-outline-secondary">((item.codejob))</p>
                                                        <p style="color:grey" v-if='item.status == 3 || item.status == 8' class="mb-0 btn btn-outline-secondary">((item.codejob))</p>
                                                        <p style="color:grey" v-if='item.status == 4 || item.status == 5' class="mb-0 btn btn-outline-secondary">((item.codejob))</p>
                                                        <p style="color:grey" v-if='item.status == 6 || item.status == ""' class="mb-0 btn btn-outline-secondary">((item.codejob))</p>
                                                        -->
                                                        <p style="color:grey" v-if='item.status == 7'><s>
                                                            <a target="_blank" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
                                                            ((item.codejob))
                                                            </a>
                                                        </s></p>
                                                        <p style="color:red" v-if='item.tong_kimduocdukien < 0 && item.status != 7'>
                                                        <a target="_blank" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
                                                        ((item.codejob))
                                                        </a>
                                                        </p>
                                                        <p v-if='item.tong_kimduocdukien >= 0 && item.status != 7'>
                                                        <a target="_blank" :href="'/admin/projectview/' + item.id" class="js-lists-values-employee-name">
                                                        ((item.codejob))
                                                        </a>
                                                        </p>
                                                        </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                
                                               
                                                
                                            
                                        </td>
                                            
                                         <td >
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;;table-layout: fixed;width:100px;">
														<tr style="border:0;">
														<td style="white-space: normal;border:0;padding: 2px;">((item.ngay_pd))</td>
														</tr>
													</table>
                                                </div>
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;table-layout: fixed;width:200px;">
														<tr style="border:0;">
														<td style="white-space: normal;border:0;padding: 2px;">((item.address_pd))</td>
														</tr>
													</table>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;text-transform: uppercase;">
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                            <a  target="_blank" :href="'/admin/collaborators/edit/' + itemCTV.user_id" >
                                                            ((itemCTV.name))
                                                            </a>
														</p></td>
														</tr>
													</table>
                                                </div>
                                            </td>
											
											<!--
											<td>
                                                <div class="d-flex flex-column">
                                                    
													
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0; height:10px">
														<td style="border:0;padding: 2px;">((item.date_start))</td>
														</tr>
													</table>
                                                </div>
                                            </td>
											-->
											<td>
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;">
															<p class="mb-0" v-if='item.status == 0 || item.status == ""'>受注</p>
															<p class="mb-0" v-if='item.status == 1'>通訳者選定</p>
															<p class="mb-0" v-if='item.status == 2'>通訳待機</p>
															<p class="mb-0" v-if='item.status == 3'>客様の入金確認</p>
															<p class="mb-0" v-if='item.status == 4'>通訳給与支払い</p>
															<p class="mb-0" v-if='item.status == 5'>営業報酬支払い</p>
															<p class="mb-0" v-if='item.status == 6'>クローズ</p>
															<p class="mb-0" v-if='item.status == 7'>キャンセル</p>
															<p class="mb-0" v-if='item.status == 8'>手配料金入金確認</p>
														</td>
														</tr>
													</table>
                                                </div>
                                            </td>
											<!-- <td>
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;text-transform: uppercase;">
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
														<a  target="_blank" :href="'/admin/collaborators/edit/' + itemCTV.id" >
														((itemCTV.name))
														</a>
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
														<td style="border:0;padding: 2px;">(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_thu_du_kien) ))</td>
														</tr>
													</table>
                                                </div>
                                            </td> -->
                                            <td style="text-align:right">
                                                <div class="d-flex flex-column">
                                                     <table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;text-transform: uppercase;">
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        ((itemCTV.ngay_chuyen_khoan))
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
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
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
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        ((itemCTV.paytaxplace))
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
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        ((itemCTV.paytaxdate))
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
                                            <td style="text-align:center">
                                                <div class="d-flex flex-column">
													<table cellspacing="0" cellpadding="0" style="border:0;">
														<tr style="border:0;">
														<td style="border:0;padding: 2px;text-transform: uppercase;">
                                                        <p class="mb-0" v-for="itemCTV in item.ctv_list" >
                                                        ((itemCTV.paytaxstatusChecked))
														</p>
                                                        </td>
														</tr>
													</table>
                                                </div>
                                            </td>
											<!-- <td style="text-align:right">
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
											<td>
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
											<td>
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
														<td style="border:0;padding: 2px;">
														<p style="color:red" class="mb-0" v-if='item.tong_kimduocdukien < 0'>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_kimduocdukien) ))</p>
														<p class="mb-0" v-if='item.tong_kimduocdukien >= 0'>(( new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.tong_kimduocdukien) ))</p>
														</td>
														</tr>
													</table>
                                                </div>
                                            </td> -->
                                            <td></td>
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
    <div id="error-details" style="display:none">
        <span id="copyName"></span><br>
        <span id="copyFurigana"></span><br>
        <span id="copyPhone"></span><br>
    </div>
    <!-- // END Page Content -->

    

    <!-- Footer -->


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
new Vue({
    el: '#list-data',
    data: {
        message: '',
        loadingTable: 0,
        count: 0,
        page: 1,
        conditionSearch: '',
        list: [],
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
        thang_chuyen_khoan: '',
        name_kh: '',
        ctv_pd: '',
        ctv_sale: '',
        dateOrder: '',
        type_jobs: '',
        codeJobs: '',
        checkedNames: [3,4,5,6,8],
		checkedTypes: [1]
    },
    delimiters: ["((", "))"],
    mounted() {
        this.onLoadPagination();
    },
    methods: {
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
			this.checkedTypes = [1,2,3];
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
            this.conditionSearch = conditionSearch;

            $.ajax({
                type: 'GET',
                url: "{{route('admin.getAllCompanyTaxPD')}}?page=" + this.page  + conditionSearch ,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
                        that.sumTaxPD = data.sumTaxPD;
                        that.sumPhiPD = data.sumPhiPD;
                    } else {
                        that.count = 0;
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