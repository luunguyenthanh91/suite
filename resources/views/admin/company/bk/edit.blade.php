@extends('admin.layouts.main')
@section('title', 'Dashboard')
@section('content')



<div class="mdk-drawer-layout__content page-content">

    <!-- Header -->

    @include('admin.component.header')

    <!-- // END Header -->

    <!-- BEFORE Page Content -->

    <!-- // END BEFORE Page Content -->
	
	
    <!-- Page Content -->
    <div id="list-data">
        <div
            class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
            <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">

                <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                    <h1 class="h2 mb-0">通訳案件</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="/admin/company">通訳案件リスト</a></li>
						<li class="breadcrumb-item active">詳細</li>
                    </ol>

                </div>
            </div>

            <div class="row ml-2" role="tablist" v-if="edit_form == 0">
                <div class="col-auto">
                    <a @click="openEdit()" class="btn btn-primary">編集</a>
                </div>
            </div>
            
            <div class="row ml-2" role="tablist"　v-if="edit_form == 0">
                <div class="col-auto">
                    <a @click="deleteRecore('{{$id}}')"  class="btn btn-danger">削除</a>
                </div>
            </div>

			<button type="button"  @click="onSubmit()"  style="float:right; margin-bottom : 20px" class="btn btn-primary mb-5 mr-2  mt-5 btn-submit" v-if="edit_form == 1">保存</button>
			<button type="button" @click="cancleEdit()" style="float:right;" class="btn btn-danger mb-5 mt-5 " v-if="edit_form == 1">キャンセル</button>

        </div>
        
        <div class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
			<div class="row ml-2" role="tablist" v-if="edit_form == 0">
				<div class="col-auto">
					<a href="/admin/company/pdf-type-new/{{$id}}" class="btn btn-info">受注書</a>
				</div>
			</div>

			<div class="row ml-2" role="tablist" v-if="edit_form == 0">
				<div class="col-auto">
					<a href="/admin/company/pdf/{{$id}}" class="btn btn-warning">支払明細書</a>
				</div>
			</div>

			<div class="row ml-2" role="tablist" v-if="edit_form == 0">
				<div class="col-auto">
					<a href="/admin/company/pdf-type/{{$id}}" class="btn btn-success">受領書</a>
				</div>
			</div>
		</div>

        <div class="container page__container page-section">
            <form action="" method="POST" class="p-0 mx-auto form-data" >
                @csrf
                <div class="row mb-32pt">
                    <div class="col-lg-12">
                        <div class="form-group">
                            @if ( @$message && @$message['status'] === 1 )
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>{{ $message['message'] }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif
                            @if ( @$message && @$message['status'] === 2 )
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>{{ $message['message'] }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                            </div>
                            @endif
                            
							<div class="row mb-32pt">
								<div class="col-lg-2">
							
							 <div class="form-group">
											<label class="form-label">受注番号</label>
											<div class="search-form" >
												<input type="text" name="codejob" class="form-control" v-if="edit_form == 1" value="{{@$data->codejob}}">
												<input type="text" name="codejob" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->codejob}}">
											</div>
										</div>
										
							<div class="form-group">
                                <label class="form-label">種類</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiotype1" @change="changeTypeJobs()" :disabled="edit_form == 0" name="loai_job" type="radio" class="custom-control-input"
                                            v-model="loai_job" value="1">
                                        <label for="radiotype1" class="custom-control-label">パートナー対応</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiotype2" @change="changeTypeJobs()" :disabled="edit_form == 0" name="loai_job" type="radio" class="custom-control-input"
                                        v-model="loai_job" value="2">
                                        <label for="radiotype2" class="custom-control-label">通訳手配料のみ</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiotype3" @change="changeTypeJobs()"  :disabled="edit_form == 0" name="loai_job" type="radio" class="custom-control-input"
                                        v-model="loai_job" value="3">
                                        <label for="radiotype3" class="custom-control-label">従業員対応</label>
                                    </div>
                                    
                                </div>
                                
                            </div>							
								
                            <div class="form-group">
                                <label class="form-label">ステータス</label>
                                <div class="search-form" >
								
                                    <select class="form-control custom-select" name="status" v-if="edit_form == 1">
                                        <option value="" ></option>
                                        <option value="0" @if(@$data->status == 0) selected @endif>受注</option>
                                        <option value="1" @if(@$data->status == 1) selected @endif>通訳者選定</option>
                                        <option value="2" @if(@$data->status == 2) selected @endif>通訳待機</option>
                                        <option value="3" @if(@$data->status == 3) selected @endif>客様の入金確認</option>
                                        <option value="4" v-bind:class='loai_job == 1 ? "" : "hidden" ' @if(@$data->status == 4) selected @endif>通訳給与支払い</option>
                                        <option value="5" @if(@$data->status == 5) selected @endif>営業報酬支払い</option>
                                        <option value="8" v-bind:class='loai_job == 2 ? "" : "hidden" ' @if(@$data->status == 8) selected @endif>手配料金入金確認</option>
                                        <option value="6" @if(@$data->status == 6) selected @endif>クローズ</option>
                                        <option value="7" @if(@$data->status == 7) selected @endif>キャンセル</option>
                                    </select>
                                    <select class="form-control custom-select" name="status" v-if="edit_form == 0" disabled>
                                        <option value="" ></option>
                                        <option value="0" @if(@$data->status == 0) selected @endif>受注</option>
                                        <option value="1" @if(@$data->status == 1) selected @endif>通訳者選定</option>
                                        <option value="2" @if(@$data->status == 2) selected @endif>通訳待機</option>
                                        <option value="3" @if(@$data->status == 3) selected @endif>客様の入金確認</option>
                                        <option value="4" @if(@$data->status == 4) selected @endif>通訳給与支払い</option>
                                        <option value="5" @if(@$data->status == 5) selected @endif>営業報酬支払い</option>
                                        <option value="8" @if(@$data->status == 8) selected @endif>手配料金入金確認</option>
                                        <option value="6" @if(@$data->status == 6) selected @endif>クローズ</option>
                                        <option value="7" @if(@$data->status == 7) selected @endif>キャンセル</option>
                                    </select>
                                </div>
                            </div>
                            
							
								
								</div>
								<div class="col-lg-6">
								
								
							<div class="form-group">
								<label class="form-label">通訳日</label>
								<div class="search-form" >
									<input type="text" autocomplete="off" name="ngay_pd" id="listDate" class="form-control" :readonly="edit_form == 0" required value="{{@$data->ngay_pd}}">
								</div>
							</div>
							
							<div class="form-group">
								<label class="form-label">住所</label>
								<div class="search-form" >
									<input type="text" name="address_pd" v-if="edit_form == 1" class="form-control" required  v-model="address_pd" >
									<input type="text" name="address_pd" v-if="edit_form == 0" readonly class="form-control" required  v-model="address_pd" >
									
								</div>
							</div>
							
							<div class="form-group">
								<label class="form-label">営業者</label>
								<div v-for="(item, index) in listAcountSale"　v-bind:class='item.type !== "delete" ? "" : "hidden" '>
									<div class="form-group">
										<div style="display: flex; justify-content: flex-start; align-items: center;">
											<a  target="_blank" :href="'/admin/ctvjobs/edit/' + item.info.id" >
												<p class="m-0" style="text-transform: uppercase;" ><strong
														class="js-lists-values-employee-name btn btn-outline-secondary">
														((item.info.name))
													</strong>
												</p>
											</a>
										</div>
									</div>
								</div>
							</div>
								
							<div class="form-group">
								<label class="form-label">通訳者</label>
								
								<div v-for="(item, index) in listBankAccount"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
									<div class="form-group">
										<div style="display: flex; justify-content: flex-start; align-items: center;">
										<a  target="_blank" :href="'/admin/collaborators/edit/' + item.info.id" >
											<p class="m-0" style="text-transform: uppercase;" ><strong
													class="js-lists-values-employee-name btn btn-outline-secondary">
													<i v-if="item.info.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
													<i v-if="item.info.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
													((item.info.name))
													
												</strong>
											</p>
										</a>
									</div>
									</div>
								</div>
								
							</div>
								
								
								</div>
								
								<div class="col-lg-2">
								
								<div class="form-group">
                                        <label class="form-label">売上(予測)</label>
                                        <!-- <input type="text" name="tong_thu_du_kien" id="totalIWill" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' readonly value="{{@$data->tong_thu_du_kien}}" > -->
										<input type="text"  class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_thu_du_kien ? @$data->tong_thu_du_kien : 0}})" >
                                        
                                    </div>
								
								<div class="form-group">
                                        <label class="form-label">純利益(予測)</label>
                                        <!-- <input type="text" name="tong_kimduocdukien" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' readonly value="{{@$data->tong_kimduocdukien}}" > -->
                                        <input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_kimduocdukien ? @$data->tong_kimduocdukien : 0}})" >
                                        
                                    </div>
								</div>
								
								<div class="col-lg-2">
									<div class="form-group">
                                        <label class="form-label">受領額</label>
                                        <div >
                                            <!-- <input type="text" name="tong_thu" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->tong_thu}}" > -->
                                            <input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_thu ? @$data->tong_thu : 0}})" >
                                        </div>
                                    </div>
									<div class="form-group">
										<label class="form-label">純利益</label>
										<div >
											<input type="number" name="price_nhanduoc_sauphivanhanh" readonly class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->price_nhanduoc_sauphivanhanh}}" >
											<input type="text"  class="form-control"  v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->price_nhanduoc_sauphivanhanh ? @$data->price_nhanduoc_sauphivanhanh : 0}}) " >
										</div>
									</div>
									<div class="form-group">
										<label class="form-label">営業利益</label>
										<div >
											<input type="number" name="price_nhanduoc" readonly class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->price_nhanduoc}}" >
											<input type="text"  class="form-control"  v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->price_nhanduoc ? @$data->price_nhanduoc : 0}}) " >
										</div>
									</div>
									<div class="form-group">
                                        <label class="form-label">入金日</label>
                                        <div >
                                            <!-- <input type="date" name="date_company_pay" class="form-control" v-if="edit_form == 1" value="{{@$data->date_company_pay}}" > -->
                                            <input type="date" name="date_company_pay" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->date_company_pay}}" >
                                        </div>
                                    </div>
									</div>
							</div>
							
                        </div>
                    </div>
                </div>
				
				
				
                <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                    <div class="card-header p-0 nav">
                        <div class="row no-gutters"
                                role="tablist">
                            <div class="col-auto">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab1">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">基本情報</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="true"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active tab_click" id="tab2">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">予算</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab3">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">顧客</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab4">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">営業者</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab5">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">通訳者</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab6">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">入金</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab9">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">支給明細</strong>
                                    </span>
                                </a>
                            </div>
                            <div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab8">
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">実績</strong>
                                    </span>
                                </a>
                            </div>
							<div class="col-auto border-left border-right">
                                <a 
                                    data-toggle="tab"
                                    role="tab"
                                    aria-selected="false"
                                    class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start tab_click" id="tab7">
                                    
                                    <span class="flex d-flex flex-column">
                                        <strong class="card-title">備考</strong>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body tab-content">
                        <div class="tab-pane text-70" id="detailtab1">
                            <div class="row mb-32pt">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                       
                                       
                                      
                                        <div class="form-group">
                                            <label class="form-label">受注日:</label>
                                            <div class="search-form" >
                                                <input type="date" name="date_start" class="form-control" v-if="edit_form == 1" required value="{{@$data->date_start}}">
                                                <input type="date" name="date_start" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->date_start}}">
                                            </div>
                                        </div>
										<!--
                                        <div class="form-group">
                                            <label class="form-label">通訳日:</label>
                                            <div class="search-form" >
                                                <input type="text" autocomplete="off" name="ngay_pd" id="listDate" class="form-control" :readonly="edit_form == 0" required value="{{@$data->ngay_pd}}">
                                            </div>
                                        </div>
										-->
                                        <div class="form-group ">
                                            <label class="form-label">通訳稼働日数:</label>
                                            <input type="number" readonly class="form-control" value="{{@$data->total_day_pd}}">
                                        </div>
                                       

                                        <!-- <div class="form-group">
                                            <label class="form-label">Tình Trạng Cộng Tác Viên:</label>
                                            <div class="search-form" >
                                                <select class="form-control custom-select" name="status_ctv_pd" v-if="edit_form == 1" >
                                                    <option value="" ></option>
                                                    <option value="1" @if(@$data->status_ctv_pd == 1) selected @endif>通訳者から連絡待ち（依頼メール送信済）</option>
                                                    <option value="2" @if(@$data->status_ctv_pd == 2) selected @endif>通訳対応待ち</option>
                                                    <option value="3" @if(@$data->status_ctv_pd == 3) selected @endif>通訳対応中</option>
                                                    <option value="4" @if(@$data->status_ctv_pd == 4) selected @endif>AlphaCepは、通訳</option>
                                                    <option value="5" @if(@$data->status_ctv_pd == 5) selected @endif>料金の入金待ち</option>
                                                    <option value="6" @if(@$data->status_ctv_pd == 6) selected @endif>報酬の入金確認中</option>
                                                    <option value="7" @if(@$data->status_ctv_pd == 7) selected @endif>済み</option>
                                                    <option value="8" @if(@$data->status_ctv_pd == 8) selected @endif>キャンセル</option>
                                                </select>
                                                <select class="form-control custom-select" name="status_ctv_pd" v-if="edit_form == 0" disabled>
                                                    <option value="" ></option>
                                                    <option value="1" @if(@$data->status_ctv_pd == 1) selected @endif>通訳者から連絡待ち（依頼メール送信済）</option>
                                                    <option value="2" @if(@$data->status_ctv_pd == 2) selected @endif>通訳対応待ち</option>
                                                    <option value="3" @if(@$data->status_ctv_pd == 3) selected @endif>通訳対応中</option>
                                                    <option value="4" @if(@$data->status_ctv_pd == 4) selected @endif>AlphaCepは、通訳</option>
                                                    <option value="5" @if(@$data->status_ctv_pd == 5) selected @endif>料金の入金待ち</option>
                                                    <option value="6" @if(@$data->status_ctv_pd == 6) selected @endif>報酬の入金確認中</option>
                                                    <option value="7" @if(@$data->status_ctv_pd == 7) selected @endif>済み</option>
                                                    <option value="8" @if(@$data->status_ctv_pd == 8) selected @endif>キャンセル</option>
                                                </select>
                                            </div>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label class="form-label">Tình Trạng Cộng Tác Viên Sale:</label>
                                            <div class="search-form" >
                                                <select class="form-control custom-select" name="status_ctv" v-if="edit_form == 1" >
                                                    <option value="" ></option>
                                                    <option value="1" @if(@$data->status_ctv == 1) selected @endif>通訳件の掲載中</option>
                                                    <option value="2" @if(@$data->status_ctv == 2) selected @endif>AlphaCepは、確認待ち</option>
                                                    <option value="3" @if(@$data->status_ctv == 3) selected @endif>AlphaCepは、通訳手配準備中</option>
                                                    <option value="4" @if(@$data->status_ctv == 4) selected @endif>AlphaCepは、通訳手配中</option>
                                                    <option value="5" @if(@$data->status_ctv == 5) selected @endif>AlphaCepは、通訳料金の入金待ち</option>
                                                    <option value="6" @if(@$data->status_ctv == 6) selected @endif>報酬の入金確認中</option>
                                                    <option value="7" @if(@$data->status_ctv == 7) selected @endif>済み</option>
                                                    <option value="8" @if(@$data->status_ctv == 8) selected @endif>キャンセル</option>
                                                </select>
                                                <select class="form-control custom-select" name="status_ctv" v-if="edit_form == 0" disabled>
                                                    <option value="" ></option>
                                                    <option value="1" @if(@$data->status_ctv == 1) selected @endif>通訳件の掲載中</option>
                                                    <option value="2" @if(@$data->status_ctv == 2) selected @endif>AlphaCepは、確認待ち</option>
                                                    <option value="3" @if(@$data->status_ctv == 3) selected @endif>AlphaCepは、通訳手配準備中</option>
                                                    <option value="4" @if(@$data->status_ctv == 4) selected @endif>AlphaCepは、通訳手配中</option>
                                                    <option value="5" @if(@$data->status_ctv == 5) selected @endif>AlphaCepは、通訳料金の入金待ち</option>
                                                    <option value="6" @if(@$data->status_ctv == 6) selected @endif>報酬の入金確認中</option>
                                                    <option value="7" @if(@$data->status_ctv == 7) selected @endif>済み</option>
                                                    <option value="8" @if(@$data->status_ctv == 8) selected @endif>キャンセル</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        
                                        <div style="display:none;" class="form-group" v-if="edit_form == 1">
                                            <label class="form-label">Kinh Độ Nơi Phiên Dịch:</label>
                                            <div class="search-form" >
                                                <input type="text" name="longitude" v-model="long" class="form-control" value="{{@$data->longitude}}" readonly>
                                            </div>
                                        </div>
                                        <div style="display:none;" class="form-group" v-if="edit_form == 1">
                                            <label class="form-label">Vĩ Độ Nơi Phiên Dịch:</label>
                                            <div class="search-form" >
                                                <input type="text" name="latitude" v-model="lat"  class="form-control" value="{{@$data->latitude}}" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-8 d-flex align-items-center">
                                    <div class="flex" style="max-width: 100%">

										<!--
                                        <div class="form-group">
                                            <label class="form-label">住所:</label>
                                            <div class="search-form" >
                                                <input type="text" name="address_pd" v-if="edit_form == 1" class="form-control" required  v-model="address_pd" >
                                                <input type="text" name="address_pd" v-if="edit_form == 0" readonly class="form-control" required  v-model="address_pd" >
                                                
                                            </div>
                                        </div>
                                        -->
                                        <!-- <div class="form-group">
                                            <label class="form-label">Ga Gần Nơi Phiên Dịch Nhất:</label>
                                            <div class="search-form" >
                                                <input type="text" name="ga" v-if="edit_form == 1" class="form-control" v-model="ga_gannhat" >
                                                <input type="text" name="ga"  v-if="edit_form == 0" readonly class="form-control" v-model="ga_gannhat" >
                                                
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label class="form-label">通訳内容:</label>
                                            
                                            @foreach($typesList as $item_type)
                                                <div class="form-check" v-if="edit_form == 1">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="types[]" @if(in_array( $item_type['id'] ,@$data->type_jobs)) checked @endif class="form-check-input" value="{{$item_type['id']}}">
                                                        {{ $item_type['name'] }}
                                                    </label>
                                                </div>
                                                @if(in_array( $item_type['id'] ,@$data->type_jobs))
                                                <div class="form-check" v-if="edit_form == 0">
                                                    <label class="form-check-label">
                                                        {{ $item_type['name'] }}
                                                    </label>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <!-- <div class="form-group">
                                            <label class="form-label">Phí Giao Thông tối đa ( Nếu có):</label>
                                            <div class="search-form" >
                                                <input type="number" name="price_giaothong" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->price_giaothong}}" >
                                                <input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->price_giaothong ? @$data->price_giaothong : 0}})" >
                                            </div>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label class="form-label">Yêu Cầu Hóa Đơn Chi Phí Giao Thông :</label>
                                            <div class="custom-controls-stacked" v-if="edit_form == 1">
                                                <div class="custom-control custom-radio">
                                                    <input id="radiostatus_fax1" name="status_fax" type="radio"
                                                        class="custom-control-input" @if(@$data->status_fax == 0) checked @endif
                                                    value="0">
                                                    <label for="radiostatus_fax1" class="custom-control-label">Không</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input id="radiostatus_fax2" name="status_fax" type="radio"
                                                        class="custom-control-input" @if(@$data->status_fax == 1) checked @endif
                                                    value="1">
                                                    <label for="radiostatus_fax2" class="custom-control-label">Có</label>
                                                </div>
                                            </div>
                                            <p v-if="edit_form == 0" class="page-separator__text">
                                            @if(@$data->status_fax == 0)
                                                Không
                                            @else
                                                Có
                                            @endif
                                            </p>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label class="form-label">Có Thể Ở Nhà TTS Nếu PD Ở Xa :</label>
                                            <div class="custom-controls-stacked" v-if="edit_form == 1">
                                                <div class="custom-control custom-radio">
                                                    <input id="radiohouse_tts1" name="house_tts" type="radio"
                                                        class="custom-control-input" @if(@$data->house_tts == 0) checked @endif
                                                    value="0">
                                                    <label for="radiohouse_tts1" class="custom-control-label">Không</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input id="radiohouse_tts2" name="house_tts" type="radio"
                                                        class="custom-control-input" @if(@$data->house_tts == 1) checked @endif
                                                    value="1">
                                                    <label for="radiohouse_tts2" class="custom-control-label">Có</label>
                                                </div>
                                            </div>
                                            <p v-if="edit_form == 0" class="page-separator__text">
                                            @if(@$data->house_tts == 0)
                                                Không
                                            @else
                                                Có
                                            @endif
                                            </p>
                                        </div> -->
                                        <!-- <div class="form-group">
                                            <label class="form-label">Chiết Khấu Hoa Hồng Cho CTV Sale:</label>
                                            <div class="custom-controls-stacked" v-if="edit_form == 1">
                                                <div class="custom-control custom-radio">
                                                    <input id="radiohoahong1" name="hoahong" type="radio"
                                                        class="custom-control-input" @if(@$data->hoahong == 0) checked @endif
                                                    value="0">
                                                    <label for="radiohoahong1" class="custom-control-label">Không</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input id="radiohoahong2" name="hoahong" type="radio"
                                                        class="custom-control-input" @if(@$data->hoahong == 1) checked @endif
                                                    value="1">
                                                    <label for="radiohoahong2" class="custom-control-label">Có</label>
                                                </div>
                                            </div>

                                            <p v-if="edit_form == 0" class="page-separator__text">
                                            @if(@$data->house_tts == 0)
                                                Không
                                            @else
                                                Có
                                            @endif
                                            </p>
                                        </div> -->
                                       
                                        <!-- <div class="form-group">
                                            <label class="form-label">Tổng Chi Dự Kiến:</label>
                                            <div class="search-form" >
                                                <input type="text" name="tong_chidukien" class="form-control" v-if="edit_form == 1" value="{{@$data->tong_chidukien}}" >
                                                <input type="text" name="tong_chidukien" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->tong_chidukien}}" >
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <label class="form-label">待合せ時間:</label>
                                            <div class="search-form" >
                                                <input type="text" name="phone_nguoilienlac" class="form-control" v-if="edit_form == 1" value="{{@$data->phone_nguoilienlac}}" >
                                                <input type="text" name="phone_nguoilienlac" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->phone_nguoilienlac}}" >
                                                <!-- <a href="tel:{{@$data->phone_nguoilienlac}}"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span></a> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">待合せ場所:</label>
                                            <div class="search-form" >
                                                <textarea type="text" name="ten_nguoilienlac" class="form-control" v-if="edit_form == 1" value="{{@$data->ten_nguoilienlac}}" ></textarea>
                                                <textarea type="text" name="ten_nguoilienlac" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->ten_nguoilienlac}}" ></textarea>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <!-- <div class="form-group">
                                            <label class="form-label">Có Thể Đổi PD Nếu Việc Kéo Dài Nhiều Ngày :</label>
                                            <div class="custom-controls-stacked" v-if="edit_form == 1">
                                                <div class="custom-control custom-radio">
                                                    <input id="radiochang_ctv1" name="chang_ctv" type="radio"
                                                        class="custom-control-input" @if(@$data->chang_ctv == 0) checked @endif
                                                    value="0">
                                                    <label for="radiochang_ctv1" class="custom-control-label">Không</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input id="radiochang_ctv2" name="chang_ctv" type="radio"
                                                        class="custom-control-input" @if(@$data->chang_ctv == 1) checked @endif
                                                    value="1">
                                                    <label for="radiochang_ctv2" class="custom-control-label">Có</label>
                                                </div>
                                            </div>
                                            <p v-if="edit_form == 0" class="page-separator__text">
                                            @if(@$data->chang_ctv == 0)
                                                Không
                                            @else
                                                Có
                                            @endif
                                            </p>
                                        </div> -->
                                        
                                        
                                    </div>
                                </div>
                                
								<div class="col-lg-2">

                                    <div class="form-group">
                                        <label class="form-label">契約金額</label>
                                        <div class="search-form" >
                                            <input type="text" name="tienphiendich" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->tienphiendich}}" >
                                            <input type="text"  class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tienphiendich ? @$data->tienphiendich : 0}})" >
                                        </div>
                                    </div>
									
									<div class="form-group">
										<label class="form-label">交通費上限額</label>
										<div class="search-form" >
                                            <input type="text" name="price_giaothong" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->price_giaothong}}" >
                                            <input type="text"  class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->price_giaothong ? @$data->price_giaothong : 0}})" >
                                        </div>
									</div>
								</div>
								<div class="col-lg-12 d-flex align-items-center">
                                    <div class="flex" style="max-width: 100%">
<!--
                                        <div class="form-group">
                                            <label class="form-label">備考:</label>
                                            <div class="search-form" >
                                                <textarea type="text" name="description" class="form-control"  rows="10" v-if="edit_form == 1">{{@$data->description}}</textarea>
                                                <textarea type="text" name="description" class="form-control"  rows="10" v-if="edit_form == 0" readonly>{{@$data->description}}</textarea>
                                            </div>
                                        </div>
										-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active text-70" id="detailtab2">
                            <div class="row mb-32pt">
								
                                <div class="col-lg-2">

                                    
                                    <div class="form-group hidden">
                                        <label class="form-check-label" style="margin-left : 20px" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                            <input :disabled="edit_form == 0" @change="changeTypeHoaHong()" type="checkbox" name="typehoahong" v-model="typehoahong" class="form-check-input" value="1" true-value="1" false-value="0">
                                            手配報酬型 or 社員通訳
                                        </label>
                                    </div>
                                    
                                    

                                    <div class="form-group">
                                        <label class="form-label">売上額</label>
                                        <div class="search-form" >
                                            <input type="text" name="tong_thu_du_kien" id="totalIWill" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->tong_thu_du_kien}}" >
                                            <input type="text"  class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_thu_du_kien ? @$data->tong_thu_du_kien : 0}})" >
                                        </div>
                                    </div>
                                    
									<div class="form-group">
                                        <label class="form-label">運営費用</label>
                                        
                                        <div class="search-form" >
                                            <input type="text"  :readonly="edit_form == 0" id="priceDuyTri" name="price_company_duytri" class="form-control"  value="{{@$data->price_company_duytri}}">

                                        </div>
                                    </div>
									
                                    <div class="form-group">
                                        <label class="form-label">純利益</label>
                                        <input type="text" name="tong_kimduocdukien" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' readonly value="{{@$data->tong_kimduocdukien}}" >
                                        <input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_kimduocdukien ? @$data->tong_kimduocdukien : 0}})" >
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-lg-2">
                                    <!-- new -->
                                    <div class="form-group">
                                        <label class="form-label">営業報酬(※1)</label>
                                        
                                        <div class="search-form" >
                                            <input type="text" :readonly="edit_form == 0" name="price_sale" class="form-control" value="{{@$data->price_sale}}">
                                            <button type="button" @click="calculatorCheck()" style="background: #000080" class="btn btn-warning">営業者報酬計算</button>
                                        </div>
                                    </div>
                                    
                                    <!-- endnew -->
                                </div>
								<div class="col-lg-2"　v-bind:class='loai_job == 2  || loai_job == 1? "" : "hidden" '>
									<div class="form-group" v-bind:class='loai_job != 3 ? "" : "hidden" '>
                                        <label class="form-label">通訳給与（※2）</label>
                                        <div class="search-form" >
                                            <input type="text" :readonly="edit_form == 0" name="price_send_ctvpd" class="form-control" value="{{@$data->price_send_ctvpd}}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                        <label class="form-label">通訳者報酬源泉徴収税率</label>
                                        <input type="text"  name="percent_vat_ctvpd" v-model="percent_vat_ctvpd" readonly class="form-control">
                                        
                                    </div>
                                    <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                        <label class="form-label">通訳者報酬源泉徴収税</label>
                                        <input type="text"   name="price_vat_ctvpd"  readonly id="priceVat" class="form-control" value="{{@$data->price_vat_ctvpd}}">
                                    </div>
                                   
                                </div>
								
                                <div class="col-lg-2">

                                    
                                    <div class="form-group">
                                        <label class="form-label">交通費等(※3)</label>
                                        <div class="search-form" >
                                            <input type="text"  :readonly="edit_form == 0" id="priceOrther" name="ortherPrice" class="form-control"  value="{{@$data->ortherPrice}}">
                                        </div>
                                    </div>
                                    
                                </div>
								<!--
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">備考:</label>
                                        <div class="search-form" >
                                            <textarea type="text" name="descriptionPrice" class="form-control"  rows="10" v-if="edit_form == 1">{{@$data->descriptionPrice}}</textarea>
                                            <textarea type="text" name="descriptionPrice" class="form-control"  rows="10" v-if="edit_form == 0" readonly>{{@$data->descriptionPrice}}</textarea>
                                        </div>
                                    </div>
                                </div>
								-->
                            </div>
							<div class="row mb-32pt">
								<div class="col-lg-12">
									<div class="form-group">
											<label class="form-label ml-2 w-100">(※1) 営業報酬 = (受領 - 運営費用 - 交通費等 - 通訳給与源泉徴収税額 - 純利益500円) * 10%</label>
											<label class="form-label ml-2 w-100">(※2) 通訳給与 = 4時間以内（4,000円）、4時間以降（1,000円/1時間）</label>
											<label class="form-label ml-2 w-100">(※3) パートナー通訳者の交通費を含む</label>
										</div>
								</div>
							</div>
						</div>
                        <div class="tab-pane text-70" id="detailtab3">
                            <div class="row mb-32pt">
                                <a class="btnToggleShowList btn btn-success" @click="toggelCus()"  v-if="edit_form == 1">検索条件</a>
                                <div class="col-lg-11 overflow-auto">
                                    
                                    <div class="" role="tablist">
                                        <div class="col-lg-12" v-if="edit_form == 1 && showListCus == 1">
                                            <div class="form-group">
                                                <label class="form-label m-0">名前</label>
                                                <input type="text" class="form-control search" v-on:keyup.enter="onGetCustomer()"
                                                    v-model="conditionNameCustomer">
                                            </div>
                                            <div class="form-group">
                                                <a @click="onGetCustomer()"  class="btn btn-outline-secondary">検索</a>
                                            </div>
                                            <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                                <tbody class="list" id="search">
                                                    <tr v-for="item in listCustomer">
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <div class="flex title-edit">
                                                                    <p class="mb-2" style="text-transform: uppercase;" >
                                                                        <strong  class="js-lists-values-employee-name">((item.name))</strong>
                                                                    </p>
                                                                    <div class="form-group">
                                                                        <a @click="addRecordCustomer(item)" class="text-50"><i
                                                                        class="material-icons">library_add</i></a>
                                                                    </div>
                                                                </div>
                                                                <!-- <p class="mb-0">Furigana: ((item.furigana))</p> -->
                                                                <p class="mb-2"><a :href="'tel:'+item.phone"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.phone))</a></p>
                                                                <p class="mb-2"><a :href="'mailto:'+item.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.email))</a></p>
                                                                <p class="mb-2"><a :href="'http://maps.google.com/maps?q=' + item.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.address))</a></p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="card-footer p-8pt">
                                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                                    <li class="page-item" v-bind:class="pageCustomer <= 1 ? 'disabled' : ''" @click="onPrePageCustomer()">
                                                        <a class="page-link"  aria-label="Previous">
                                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                            <span>Prev</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item disabled" v-if="pageCustomer > 3 ">
                                                        <a class="page-link" >
                                                            <span>...</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" v-for="itemCustomer in listPageCustomer"
                                                        v-if="pageCustomer > (itemCustomer - 3) && pageCustomer < (itemCustomer + 3) " @click="onPageChangeCustomer(itemCustomer)"
                                                        v-bind:class="pageCustomer == itemCustomer ? 'active' : ''">
                                                        <a class="page-link"  aria-label="Page 1">
                                                            <span>((itemCustomer))</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" @click="onNextPageCustomer()"
                                                        v-bind:class="pageCustomer > count - 1 ? 'disabled' : ''">
                                                        <a class="page-link" >
                                                            <span>Next</span>
                                                            <span aria-hidden="true" class="material-icons">chevron_right</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                   
                                </div>
                                <div class="col-lg-12 align-items-center overflow-auto mt-5">
                                    
                                    <div class="flex mb-5 style-group-add" v-for="(item, index) in listAcountCustomer"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                        <button @click="removeRecordCustomer(item)" type="button" class="btn btn-danger" v-if="edit_form == 1" style="float:right">削除</button>
                                        <div class="form-group">
                                            <label class="form-label" for="chuTaiKhoan">((item.info.name))</label><br>
                                            <label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
                                            <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span> ((item.info.phone))</a></label><br>
                                            <label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
                                            <p class="mb-2"><a :href="'http://maps.google.com/maps?q=' + item.info.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.info.address))</a></p>
                                            <input type="hidden" v-bind:name="'jobsCustomer['+index+'][id]'" v-model="item.id">
                                            <input type="hidden" v-bind:name="'jobsCustomer['+index+'][cus_jobs_id]'"
                                                v-model="item.cus_jobs_id">
                                            <input type="hidden" v-bind:name="'jobsCustomer['+index+'][type]'" v-model="item.type">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="form-label">銀行口座</label><br>
                                            <label class="form-label" for="chuTaiKhoan">((item.info.ten_bank)) ( ((item.info.ms_nganhang)) ) - ((item.info.chinhanh)) ( ((item.info.ms_chinhanh)) ) - ((item.info.loai_taikhoan)) - ((item.info.stk)) - ((item.info.ten_chutaikhoan))</label><br>
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="form-label">振込日</label>
                                            <input type="date" v-bind:name="'jobsCustomer['+index+'][ngay_chuyen_khoan]'"
                                                class="form-control" v-model="item.ngay_chuyen_khoan">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="form-label">振込金額:</label>
                                            <input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsCustomer['+index+'][price_total]'"
                                                class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_total ? item.price_total : 0) ">
                                            <input type="number" v-if="edit_form != 0" v-bind:name="'jobsCustomer['+index+'][price_total]'"
                                            class="form-control" v-model="item.price_total">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="form-label">振込手数料</label>
                                            <input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsCustomer['+index+'][phi_chuyen_khoan]'"
                                                class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0) ">
                                            <input type="text" v-if="edit_form != 0" v-bind:name="'jobsCustomer['+index+'][phi_chuyen_khoan]'"
                                                class="form-control" v-model="item.phi_chuyen_khoan">
                                        </div>
                                        <div class="form-group" style="display:none;">
                                            <label class="form-label">ステータス</label>
                                            <label class="form-check-label" style="margin-left : 20px">
                                                <input  type="checkbox" v-bind:name="'jobsCustomer['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
                                                支給済み
                                            </label>
                                        </div>
                                        


                                        
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane text-70" id="detailtab4">
                            <div class="row mb-32pt">
								<div class="col-lg-12 align-items-center">
                                    
                                    <div v-for="(item, index) in listAcountSale"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
										<div class="row mb-32pt">
										
											<div class="col-lg-3 ">
												<label class="form-label">営業者</label>
												<div class="form-group">
													<div style="display: flex; justify-content: flex-start; align-items: center;">
														<a  target="_blank" :href="'/admin/ctvjobs/edit/' + item.info.id" >
															<p class="m-0" style="text-transform: uppercase;" ><strong
																	class="js-lists-values-employee-name btn btn-outline-secondary">
																	((item.info.name))
																</strong>
															</p>
														</a>
													</div>
													<br>
													<label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
													<span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span> ((item.info.phone))</a></label><br>
													<label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
													<input type="hidden" v-bind:name="'jobsSale['+index+'][id]'" v-model="item.id">
													<input type="hidden" v-bind:name="'jobsSale['+index+'][ctv_jobs_id]'"
														v-model="item.ctv_jobs_id">
													<input type="hidden" v-bind:name="'jobsSale['+index+'][type]'" v-model="item.type">
												</div>
											</div>
											<div class="col-lg-2 ">
												<div class="form-group">
														<label class="form-label">営業報酬</label>
														<div class="search-form" >
															<input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsSale['+index+'][price_total]'"
																class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_total ? item.price_total : 0) ">
															<input type="number" v-if="edit_form != 0" v-bind:name="'jobsSale['+index+'][price_total]'"
															class="form-control" v-model="item.price_total">
														</div>
													</div>
											</div>
											<!--
											<div class="col-lg-1 ">
											</div>
											<div class="col-lg-4 ">
												<div class="form-group">
													<label class="form-label">銀行口座</label><br>
													<label class="form-label" for="chuTaiKhoan">
														<span v-if=" item.info.ten_bank ">((item.info.ten_bank))</span> 
														<span v-if=" item.info.ms_nganhang ">( ((item.info.ms_nganhang)) ) </span> 
														<span v-if=" item.info.chinhanh ">- ((item.info.chinhanh)) </span>
														<span v-if=" item.info.ms_chinhanh ">( ((item.info.ms_chinhanh)) ) </span> 
														<span v-if=" item.info.loai_taikhoan ">- ((item.info.loai_taikhoan)) </span>
														<span v-if=" item.info.stk ">- ((item.info.stk))</span>
														<span v-if=" item.info.ten_chutaikhoan ">- ((item.info.ten_chutaikhoan))</span>
													</label><br>
												</div>
												<div class="form-group">
													<label class="form-label">振込日</label>
													<input type="date" v-bind:name="'jobsSale['+index+'][ngay_chuyen_khoan]'"
														class="form-control" v-model="item.ngay_chuyen_khoan">
												</div>
												<div class="form-group">
													<label class="form-label">振込手数料</label>
													<div class="search-form" >
														<input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
															class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0) ">
														<input type="text" v-if="edit_form != 0" v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
															class="form-control" v-model="item.phi_chuyen_khoan">
													</div>
												</div>
												<div class="form-group">
													<label class="form-check-label" style="margin-left : 20px">
														<input  type="checkbox" v-bind:name="'jobsSale['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
														振込済み
													</label>
												</div>
											</div>
											-->
											<div class="col-lg-12 ">
												<button @click="removeRecordSales(item)" type="button" class="btn btn-danger" v-if="edit_form == 1">営業者を削除</button>
											</div>
										</div>
									</div>
									
                                </div>
								<div class="col-lg-12 overflow-auto">
									<button @click="toggelCtv()" type="button" class="btn btn-primary  ml-12" v-if="edit_form == 1">営業者の追加</button>
								</div>
								
								<div class="flex mb-5 style-group-add" style="margin:14px" v-if="edit_form == 1　&& showListCtv == 1">
									<div class="col-lg-12 overflow-auto">
										
										<div class="" role="tablist" v-if="edit_form == 1 && showListCtv == 1">
											<div class="row mb-32pt">
												<div class="col-lg-2">
													<div class="form-group">
													<label class="form-label m-0">名前</label>
													<input type="text" class="form-control search" v-on:keyup.enter="onGetSales()"
														v-model="conditionNameSale">
												</div>
													<div class="form-group">
														<button class="btn btn-primary col-lg-12" type="button" @click="onGetSales()">検索</button>
													</div>

												</div>
												<div class="col-lg-10">
													
                                            <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                                <tbody class="list" id="search">
                                                    <tr v-for="item in listSales">
                                                        <td>
                                                            <div class="d-flex flex-column">
																<div class="flex title-edit">
                                                                    <div style="display: flex; justify-content: flex-start; align-items: left;">
                                                                        <a  target="_blank" :href="'/admin/ctvjobs/edit/' + item.id" >
                                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                                    ((item.name))
                                                                            </strong>
                                                                            </p>
                                                                        </a>
                                                                        <div class="form-group" style="margin: 0 0 0 10px;">
                                                                            <a @click="addRecordSale(item)" class="text-50"><i
                                                                            class="material-icons">library_add</i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
																
                                                                <!-- <p class="mb-0">Furigana: ((item.furigana))</p> -->
                                                                <p class="mb-2"><a :href="'tel:'+item.phone"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.phone))</a></p>
                                                                <p class="mb-2"><a :href="'mailto:'+item.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.email))</a></p>
                                                                <p class="mb-2"><a :href="'http://maps.google.com/maps?q=' + item.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.address))</a></p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="card-footer p-8pt">
                                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                                    <li class="page-item" v-bind:class="pageSales <= 1 ? 'disabled' : ''" @click="onPrePageSales()">
                                                        <a class="page-link"  aria-label="Previous">
                                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                            <span>前のページ</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item disabled" v-if="pageSales > 3 ">
                                                        <a class="page-link" >
                                                            <span>...</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" v-for="item in listPageSales"
                                                        v-if="pageSales > (item - 3) && pageSales < (item + 3) " @click="onPageChangeSales(item)"
                                                        v-bind:class="pageSales == item ? 'active' : ''">
                                                        <a class="page-link"  aria-label="Page 1">
                                                            <span>((item))</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" @click="onNextPageSales()"
                                                        v-bind:class="pageSales > count - 1 ? 'disabled' : ''">
                                                        <a class="page-link" >
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
                        <div class="tab-pane text-70" id="detailtab5">
                            <div class="row mb-32pt">
                                
                                <div class="col-lg-12 align-items-center">
                                    <!-- class="flex mb-5 style-group-add" -->
                                    <div v-for="(item, index) in listBankAccount"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                        <div class="row mb-32pt">
                                            
                                            <div class="col-lg-3">
												<label class="form-label">通訳者</label>
                                                <div class="form-group">
                                                    <div style="display: flex; justify-content: flex-start; align-items: center;">
                                                        <a  target="_blank" :href="'/admin/collaborators/edit/' + item.info.id" >
                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                    <i v-if="item.info.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                    <i v-if="item.info.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                    ((item.info.name))
                                                                    
                                                                </strong>
                                                            </p>
                                                        </a>
                                                        <i class="fa fa-id-badge ml-3" style="font-size:26px;cursor: copy;" @click="copyClipboad(item.info)" aria-hidden="true"></i>
                                                        <a target="_blank" style="font-size:26px;margin-left : 10px" :href="'https://transit.yahoo.co.jp/search/result?from='+item.info.address+'&s=1&fl=1&to='+address_pd" class="text-50"><i class="fas fa-train"></i></a>
                                                    </div>
                                                    <br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
                                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.info.phone))</a></label><br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'http://maps.google.com/maps?q=' + item.info.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.info.address))</a></label><br>
													
													
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][id]'" v-model="item.id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][collaborators_id]'"
                                                        v-model="item.collaborators_id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][type]'" v-model="item.type">
                                                </div>
                                            </div>
										<div class="col-lg-2">
												<div class="form-group">
                                                    <label class="form-label">通訳給与</label>
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_phien_dich_total ? item.phi_phien_dich_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.phi_phien_dich_total">
                                                </div>
												<div class="form-group">
                                                    <label class="form-label">交通費等</label>
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][phi_giao_thong_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_giao_thong_total ? item.phi_giao_thong_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][phi_giao_thong_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.phi_giao_thong_total">
                                                </div>
												<div class="form-group">
                                                    <label class="form-label">総支給額</label>
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][price_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_total ? item.price_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][price_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.price_total">
                                                </div>
											</div>
											<div class="col-lg-1">
											</div>
											<!--
                                            <div class="col-lg-3" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">銀行口座</label>
                                                    <div class="search-form" >
                                                        <select :readonly="edit_form == 0" class="form-control custom-select"
                                                            v-bind:name="'jobsConnect['+index+'][bank_id]'" v-model="item.bank_id">
                                                            <option value="">振込先口座を選択してください</option>
                                                            <option v-for="itemBank in item.listBank" v-bind:value='itemBank.id'>
                                                                <span v-if=" itemBank.ten_bank ">((itemBank.ten_bank))</span> 
                                                                <span v-if=" itemBank.chinhanh ">- ((itemBank.chinhanh)) </span>
                                                                <span v-if=" itemBank.loai_taikhoan ">- ((itemBank.loai_taikhoan)) </span>
                                                                <span v-if=" itemBank.stk ">- ((itemBank.stk))</span>
                                                                <span v-if=" itemBank.ten_chutaikhoan ">- ((itemBank.ten_chutaikhoan))</span>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">振込日</label>
                                                    <div class="search-form" >
                                                        <input type="date" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][ngay_chuyen_khoan]'"
                                                            class="form-control" v-model="item.ngay_chuyen_khoan">
                                                    </div>
                                                </div>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">振込手数料:</label>
                                                    <div class="search-form" >
                                                        <input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                                            class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0)">
                                                        <input type="text" v-if="edit_form != 0" v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                                            class="form-control" v-model="item.phi_chuyen_khoan">
                                                    </div>
                                                </div>
												<div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
													<div class="form-group">
														<label class="form-check-label" style="margin-left : 20px">
															<input  type="checkbox" v-bind:name="'jobsConnect['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
															振込済み
														</label>
													</div>
												</div>
                                            </div>
											-->
                                            <div class="col-lg-3">
												<div v-if="edit_form == 0"
													class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
													<div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
														<div class="mb-24pt mb-sm-0 mr-sm-24pt">
															@foreach($allMailTemplate as $indexMail => $itemMailTemplate)
																@if($itemMailTemplate->name == "通訳依頼通知")
																	<button type="button" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal"  class="btn btn-info" v-bind:class='loai_job != 3 ? "" : "hidden" '>{{$itemMailTemplate->name}}</button>
																@endif
															@endforeach
															
														</div>
													</div>
													
												</div>
												<div style="margin-top:5px" v-if="edit_form == 0"
													class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
													<div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
														<div class="mb-24pt mb-sm-0 mr-sm-24pt">
															@foreach($allMailTemplate as $indexMail => $itemMailTemplate)
																@if($itemMailTemplate->name == "通訳報告願い")
																	<button type="button" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal"  class="btn btn-info" v-bind:class='loai_job != 3 ? "" : "hidden" '>{{$itemMailTemplate->name}}</button>
																@endif
															@endforeach
															
														</div>
													</div>
													
												</div>
												<div style="margin-top:5px" v-if="edit_form == 0" v-bind:class='loai_job == 2 ? "" : "hidden" '
													class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
													<div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
														<div class="mb-24pt mb-sm-0 mr-sm-24pt">
															@foreach($allMailTemplate as $indexMail => $itemMailTemplate)
																@if($itemMailTemplate->name == "手配手数料請求")
																	<button type="button" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal"  class="btn btn-info" v-bind:class='loai_job != 3 ? "" : "hidden" '>{{$itemMailTemplate->name}}</button>
																@endif
															@endforeach
															
														</div>
													</div>
													
												</div>
												<div style="margin-top:5px" v-if="edit_form == 0" v-bind:class='loai_job == 2 ? "" : "hidden" '
													class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
													<div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
														<div class="mb-24pt mb-sm-0 mr-sm-24pt">
															@foreach($allMailTemplate as $indexMail => $itemMailTemplate)
																@if($itemMailTemplate->name == "入金確認完了通知")
																	<button type="button" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal"  class="btn btn-info" v-bind:class='loai_job != 3 ? "" : "hidden" '>{{$itemMailTemplate->name}}</button>
																@endif
															@endforeach
															
														</div>
													</div>
													
												</div>
												<div style="margin-top:5px" v-if="edit_form == 0" v-bind:class='loai_job == 1 ? "" : "hidden" '
													class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
													<div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
														<div class="mb-24pt mb-sm-0 mr-sm-24pt">
															@foreach($allMailTemplate as $indexMail => $itemMailTemplate)
																@if($itemMailTemplate->name == "給与振込完了通知")
																	<button type="button" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal"  class="btn btn-info" v-bind:class='loai_job != 3 ? "" : "hidden" '>{{$itemMailTemplate->name}}</button>
																@endif
															@endforeach
															
														</div>
													</div>
													
												</div>
											</div>
                                        </div>
                                        
                                            <div class="form-custom-table">
                                                <table class="table"　style="border: 1px solid #CCCCCC;  border-collapse: collapse;">
                                                    <thead class="thead-light" style="text-align:center">
                                                        <tr>
															<th scope="col">
															<a @click="addListRecord(item)" class="fas fa-plus-circle" v-if="edit_form == 1" style="font-size:14px;color:blue;width:40px;"></a>
															通訳日</th>
                                                            <th scope="col">開始時間</th>
                                                            <th scope="col">終了時間</th>
                                                            <th scope="col">延長時間</th>
                                                            <th scope="col">通訳給与</th>
                                                            <th scope="col">交通費</th>
															<!--
                                                            <th scope="col">報告ファイル</th>
															-->
                                                            <th scope="col">領収書等</th>
                                                            <th scope="col" >報告内容</th>
                                                            <th scope="col" style="width: 100%; "></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item1, index1) in item.dateList" v-bind:class='item1.type != "delete" ? "" : "hidden" '>
															
                                                            <th scope="row">
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <input type="date" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][ngay_phien_dich]'"
                                                                            class="form-control" v-model="item1.ngay_phien_dich">
                                                                    </div>
                                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][id]'"
                                                                        class="form-control" v-model="item1.id">
                                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][type]'"
                                                                        class="form-control" v-model="item1.type">
                                                                </div>
                                                            </th>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <input type="text" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_phien_dich]'"
                                                                            class="form-control" v-model="item1.gio_phien_dich">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <input type="text" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_ket_thuc]'"
                                                                            class="form-control" v-model="item1.gio_ket_thuc">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <input type="text" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_tang_ca]'"
                                                                            class="form-control" v-model="item1.gio_tang_ca">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <input style="width:100px" type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_phien_dich]'"
                                                                            class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item1.phi_phien_dich ? item1.phi_phien_dich : 0)">
                                                                        <input style="width:100px" type="text" v-if="edit_form != 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_phien_dich]'"
                                                                        class="form-control" v-model="item1.phi_phien_dich">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <input type="text" style="width:100px" v-if="edit_form == 0" readonly v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_giao_thong]'"
                                                                            class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item1.phi_giao_thong ? item1.phi_giao_thong : 0) ">
                                                                        <input type="text" style="width:100px" v-if="edit_form != 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_giao_thong]'"
                                                                            class="form-control" v-model="item1.phi_giao_thong">
                                                                    </div>
                                                                </div>
                                                            </td>
															<!--
                                                            <td>
                                                                <div class="form-group">
                                                                    <li id="images">   
                                                                        <div class="search-form" >
                                                                            <input :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][file_bao_cao]'"
                                                                        class="form-control"  type="text" v-bind:id="'chooseImage_inputfile'+index1" v-model="item1.file_bao_cao">
                                                                        </div>
                                                                        <a v-if="item1.file_bao_cao != '' " :href="item1.file_bao_cao"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">file_download</span></a>
                                                                    
                                                                        <br/>
                                                                        <div v-bind:class='edit_form == 0 ? "hidden" : "" ' >
                                                                            <a  onclick="chooseFile(this)"  :rel="'file'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                                                            | 
                                                                            <a onclick="clearFile(this)" :rel="'file'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                                                        </div>
                                                                    </li>
                                                                </div>
                                                            </td>
															-->
                                                            <td>
                                                                <div class="form-group">
                                                                    <li id="images">   
                                                                        <div class="search-form" >
                                                                            <input :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][file_hoa_don]'"
                                                                                class="form-control"  type="text" v-bind:id="'chooseImage_inputfilehd'+index1" v-model="item1.file_hoa_don">
                                                                        </div>
                                                                        <a v-if="item1.file_hoa_don != '' " :href="item1.file_hoa_don"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">file_download</span></a>
                                                                    
                                                                        <br/>
                                                                        <div v-bind:class='edit_form == 0 ? "hidden" : "" ' >
                                                                            <a onclick="chooseFile(this)"  :rel="'filehd'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                                                            | 
                                                                            <a onclick="clearFile(this)" :rel="'filehd'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                                                        </div>
                                                                    </li>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="search-form" >
                                                                        <textarea type="text" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][note]'"
                                                                            class="form-control" v-model="item1.note" rows="1" ></textarea>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="width: 100%; ">
																<a @click="removeListRecord(item1)" class="fas fa-trash-alt" v-if="edit_form == 1" style="font-size:20px;color:red; margin-top:8px;"></a>
                                                            </td>
                                                            
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            
											
											<!--
												<button @click="addListRecord(item)" type="button" class="btn btn-primary  ml-2" v-if="edit_form == 1">通訳日を追加</button>
												-->
												<button @click="removeRecord(item)" type="button" class="btn btn-danger ml-12" v-if="edit_form == 1">通訳者を削除</button>
                                           
											
											</div>
                                        
                                    </div>
                                </div>
<!--
								<div v-if="edit_form == 0"
                                    class="container page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
                                    <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
                                        <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                            @foreach($allMailTemplate as $indexMail => $itemMailTemplate)
                                                <button type="button" @click="sendMailTemplate('{{$indexMail}}')" data-toggle="modal" data-target="#myModal"  class="btn btn-warning" v-bind:class='loai_job != 3 ? "" : "hidden" '>{{$itemMailTemplate->name}}</button>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                    
                                </div>
								-->
								
								<div class="col-lg-12 overflow-auto">
									<button @click="toggelPd()" type="button" class="btn btn-primary  ml-12" v-if="edit_form == 1" style="margin-top:10px">通訳者の追加</button>
								</div>
								<!--
                                <a class="btnToggleShowList btn btn-success" @click="toggelPd()"  v-if="edit_form == 1">検索条件</a>
								-->
								<div class="flex mb-5 style-group-add" style="margin:14px" v-if="edit_form == 1　&& showListPD == 1">
                                <div class="col-lg-12 overflow-auto">
                                    
                                    <div class="" role="tablist" v-if="edit_form == 1 && showListPD == 1">
									<div class="row mb-32pt">
										<div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label m-0">名前</label>
                                                <input type="text" class="form-control search" v-on:keyup.enter="onGetByAddress()"
                                                    v-model="conditionName">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label m-0">性別</label>
                                                <select class="form-control search" v-model="male" @change="onGetByAddress()">
                                                    <option value=""></option>
                                                    <option value="1">男性</option>
                                                    <option value="2">女性</option>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <label class="form-label m-0">日本語能力試験（JLPT）の資格</label>
                                                <select class="form-control search" v-model="jplt" @change="onGetByAddress()">
                                                    <option value=""></option>
                                                    <option value="1">N1</option>
                                                    <option value="2">N2</option>
                                                    <option value="3">N3</option>
                                                    <option value="4">N4</option>
                                                    <option value="5">N5</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
												<button class="btn btn-primary col-lg-12" type="button" @click="onGetByAddress()">検索</button>
												<!--
                                                <a @click="onSendEmail()" class="btn btn-outline-primary">メール送信</a>
												-->
                                            </div>
										</div>
										<div class="col-lg-10">
											<div class="form-group">
											<table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                                <tbody class="list" id="search">
                                                    <tr v-for="item in list">
                                                    
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <input  type="checkbox"  v-model="item.send_mail" class="form-check-input" value="1" true-value="1" false-value="0">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <div class="flex title-edit">
                                                                    <div style="display: flex; justify-content: flex-start; align-items: left;">
                                                                        <a  target="_blank" :href="'/admin/collaborators/edit/' + item.id" >
                                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                                    <i v-if="item.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                                    <i v-if="item.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                                    ((item.name))
                                                                                    
                                                                            </strong>
                                                                            </p>
                                                                        </a>
																		
                                                                        <div class="form-group" style="margin: 0 0 0 10px;">
																			<i class="fa fa-id-badge ml-3" style="font-size:16px;cursor: copy;" @click="copyClipboad(item.info)" aria-hidden="true"></i>
																			</div>
                                                                        <div class="form-group" style="margin: 0 0 0 10px;">
                                                                            <a target="_blank" :href="'https://transit.yahoo.co.jp/search/result?from='+item.address+'&s=1&fl=1&to='+address_pd" class="text-50"><i class="fas fa-train"></i></a>
                                                                        </div>
                                                                        <div class="form-group" style="margin: 0 0 0 10px;">
                                                                            <a @click="addRecord(item)" class="text-50"><i
                                                                            class="material-icons">library_add</i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <p class="mb-0">Furigana: ((item.furigana))</p> -->
                                                                <p class="mb-2"><a :href="'tel:'+item.phone"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.phone))</a></p>
                                                                <p class="mb-2"><a :href="'mailto:'+item.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.email))</a></p>
                                                                <p class="mb-2"><a :href="'http://maps.google.com/maps?q=' + item.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.address))</a></p>
                                                                <!-- <p class="mb-0" v-if="item.distance"><a >(( parseInt(item.distance) )) KM</a></p> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="card-footer p-8pt">
                                                <ul class="pagination justify-content-start pagination-xsm m-0">
                                                    <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''" @click="onPrePage()">
                                                        <a class="page-link"  aria-label="Previous">
                                                            <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                            <span>前のページ</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item disabled" v-if="page > 3 ">
                                                        <a class="page-link" >
                                                            <span>...</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" v-for="item in listPage"
                                                        v-if="page > (item - 3) && page < (item + 3) " @click="onPageChange(item)"
                                                        v-bind:class="page == item ? 'active' : ''">
                                                        <a class="page-link"  aria-label="Page 1">
                                                            <span>((item))</span>
                                                        </a>
                                                    </li>
                                                    <li class="page-item" @click="onNextPage()"
                                                        v-bind:class="page > count - 1 ? 'disabled' : ''">
                                                        <a class="page-link" >
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
                        </div>
                        <div class="tab-pane text-70" id="detailtab6">
                            <div class="row mb-32pt">

                                <div class="col-lg-4">
                                    <!-- <div class="page-separator">
                                        <div class="page-separator__text">実績</div>
                                    </div> -->

                                    <div class="form-group">
                                        <label class="form-label">入金口座</label>
                                        <div class="search-form" >
                                            <select class="form-control custom-select" name="stk_thanh_toan_id" v-if="edit_form == 1">
                                                <option value=""></option>
                                                @foreach($allMyBank as $itemBank)
                                                <option value="{{$itemBank->id}}" @if(@$data->stk_thanh_toan_id == $itemBank->id)
                                                    selected @endif >
                                                    @if($itemBank->name_bank){{$itemBank->name_bank}}@endif
                                                    - @if($itemBank->stk){{$itemBank->stk}}@endif 
                                                    - @if($itemBank->ten_chusohuu){{$itemBank->ten_chusohuu}}@endif 
                                                </option>
                                                @endforeach
                                            </select>
                                            <select class="form-control custom-select" name="stk_thanh_toan_id" v-if="edit_form == 0" disabled>
                                                <option value=""></option>
                                                @foreach($allMyBank as $itemBank)
                                                <option value="{{$itemBank->id}}" @if(@$data->stk_thanh_toan_id == $itemBank->id)
                                                    selected @endif >{{$itemBank->name_bank}} - {{$itemBank->stk}} -
                                                    {{$itemBank->ten_chusohuu}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-label">入金日</label>
                                        <div class="search-form" >
                                            <input type="date" name="date_company_pay" class="form-control" v-if="edit_form == 1" value="{{@$data->date_company_pay}}" >
                                            <input type="date" name="date_company_pay" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->date_company_pay}}" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">受領額</label>
                                        <div class="search-form" >
                                            <input type="text" name="tong_thu" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->tong_thu}}" >
                                            <input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_thu ? @$data->tong_thu : 0}})" >
                                        </div>
                                    </div>
									</div>
									
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="status_bank" @if(@$data->status_bank == 1) checked @endif class="form-check-input" value="1">
                                                    入金確認済み
                                                </label>
                                            </div>
											<!--
                                            @if(@$data->status_bank == 1) 
                                            <div class="form-check" v-if="edit_form == 0">
                                                <label class="form-check-label">
                                                入金確認済み
                                                </label>
                                            </div>
                                            @else
                                            <div class="form-check" v-if="edit_form == 0">
                                                <label class="form-check-label">
                                                未支給
                                                </label>
                                            </div>
                                            @endif
											-->
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane text-70" id="detailtab7">
							<div class="row mb-32pt">
								<div class="col-lg-12">
									<div class="form-group">
										<!--
										<label class="form-label">備考:</label>
										-->
										<div class="search-form" >
											<textarea type="text" name="description" class="form-control"  rows="10" v-if="edit_form == 1">{{@$data->description}}</textarea>
											<textarea type="text" name="description" class="form-control"  rows="10" v-if="edit_form == 0" readonly>{{@$data->description}}</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane text-70" id="detailtab9">
							



							<div class="flex mb-5 style-group-add" v-for="(item, index) in listAcountSale"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
										<div class="row mb-32pt">
										
                                            <div class="col-lg-12">
                                                <div class="form-group" style="text-align:center">
												<label class="form-label ml-2 w-100" style="text-decoration: underline;font-size: 16pt; color:blue">営業報酬支払い</label>
												</div>
											</div>
											<div class="col-lg-3 ">
												<label class="form-label">営業者</label>
												<div class="form-group">
													<div style="display: flex; justify-content: flex-start; align-items: center;">
														<a  target="_blank" :href="'/admin/ctvjobs/edit/' + item.info.id" >
															<p class="m-0" style="text-transform: uppercase;" ><strong
																	class="js-lists-values-employee-name btn btn-outline-secondary">
																	((item.info.name))
																</strong>
															</p>
														</a>
													</div>
													<br>
													<label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
													<span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span> ((item.info.phone))</a></label><br>
													<label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
													<input type="hidden" v-bind:name="'jobsSale['+index+'][id]'" v-model="item.id">
													<input type="hidden" v-bind:name="'jobsSale['+index+'][ctv_jobs_id]'"
														v-model="item.ctv_jobs_id">
													<input type="hidden" v-bind:name="'jobsSale['+index+'][type]'" v-model="item.type">
												</div>
												</div>
											<div class="col-lg-5 ">
												<div class="form-group">
													<label class="form-label">銀行口座</label><br>
                                                    <select :readonly="edit_form == 0" class="form-control custom-select"
                                                            v-bind:name="'jobsSale['+index+'][payplace]'" v-model="item.payplace">
                                                        <option value="0"></option>
                                                        <option value="1">
                                                            <span v-if=" item.info.ten_bank ">((item.info.ten_bank))</span> 
                                                            <span v-if=" item.info.ms_nganhang ">( ((item.info.ms_nganhang)) ) </span> 
                                                            <span v-if=" item.info.chinhanh ">- ((item.info.chinhanh)) </span>
                                                            <span v-if=" item.info.ms_chinhanh ">( ((item.info.ms_chinhanh)) ) </span> 
                                                            <span v-if=" item.info.loai_taikhoan ">- ((item.info.loai_taikhoan)) </span>
                                                            <span v-if=" item.info.stk ">- ((item.info.stk))</span>
                                                            <span v-if=" item.info.ten_chutaikhoan ">- ((item.info.ten_chutaikhoan))</span>
                                                        </option>      
                                                        </option>
                                                        <option value="2">現金</option>
                                                    </select>
												</div>
												
												<div class="form-group">
													<label class="form-label">振込日</label>
													<input type="date" v-bind:name="'jobsSale['+index+'][ngay_chuyen_khoan]'"
														class="form-control" v-model="item.ngay_chuyen_khoan">
												</div>
												<div class="form-group">
														<label class="form-label">振込金額</label>
														<div class="form-group" >
															<input type="text" v-bind:name="'jobsSale['+index+'][price_total]'"
																class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_total ? item.price_total : 0) ">
															<input type="number" v-bind:name="'jobsSale['+index+'][price_total]'"
																class="form-control" readonly　v-if="edit_form != 0" v-model="item.price_total">
														</div>
													</div>
												<div class="form-group">
													<label class="form-label">手数料</label>
													<div class="search-form" >
														<input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
															class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0) ">
														<input type="text" v-if="edit_form != 0" v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
															class="form-control" v-model="item.phi_chuyen_khoan">
													</div>
												</div>
											</div>
											<div class="col-lg-4 ">
												<div class="form-group">
													<label class="form-check-label" style="margin-left : 20px">
														<input  type="checkbox" v-bind:name="'jobsSale['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
														振込済み
													</label>
												</div>
											</div>
										</div>
									</div>
									
						
							<div class="row mb-32pt"　v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                <div class="col-lg-12 align-items-center">
                                    
                                    <div class="flex mb-5 style-group-add" v-for="(item, index) in listBankAccount"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                        <div class="row mb-32pt">
                                            <div class="col-lg-12">
                                                <div class="form-group" style="text-align:center">
												<label class="form-label ml-2 w-100" style="text-decoration: underline;font-size: 16pt; color:orange">通訳給与支払い</label>
												</div>
											</div>
                                            <div class="col-lg-3">
												<label class="form-label">通訳者</label>
                                                <div class="form-group">
                                                    <div style="display: flex; justify-content: flex-start; align-items: center;">
                                                        <a  target="_blank" :href="'/admin/collaborators/edit/' + item.info.id" >
                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                    <i v-if="item.info.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                    <i v-if="item.info.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                    ((item.info.name))
                                                                    
                                                                </strong>
                                                            </p>
                                                        </a>
                                                    </div>
                                                    <br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
                                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.info.phone))</a></label><br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
                                                    <label class="form-label" for="chuTaiKhoan"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.info.address))</label><br>
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][id]'" v-model="item.id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][collaborators_id]'"
                                                        v-model="item.collaborators_id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][type]'" v-model="item.type">
                                                </div>
                                            </div>
                                            <div class="col-lg-5" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">銀行口座:</label>
                                                    <div class="search-form" >
                                                        <select :readonly="edit_form == 0" class="form-control custom-select"
                                                            v-bind:name="'jobsConnect['+index+'][bank_id]'" v-model="item.bank_id">
                                                            <option value="">振込先口座を選択してください</option>
                                                            <option v-for="itemBank in item.listBank" v-bind:value='itemBank.id'>
                                                                <span v-if=" itemBank.ten_bank ">((itemBank.ten_bank))</span> 
                                                                <span v-if=" itemBank.chinhanh ">- ((itemBank.chinhanh)) </span>
                                                                <span v-if=" itemBank.loai_taikhoan ">- ((itemBank.loai_taikhoan)) </span>
                                                                <span v-if=" itemBank.stk ">- ((itemBank.stk))</span>
                                                                <span v-if=" itemBank.ten_chutaikhoan ">- ((itemBank.ten_chutaikhoan))</span>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">振込日</label>
                                                    <div class="search-form" >
                                                        <input type="date" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][ngay_chuyen_khoan]'"
                                                            class="form-control" v-model="item.ngay_chuyen_khoan">
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label class="form-label">振込金額</label>
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][price_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_total ? item.price_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][price_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.price_total">
                                                </div>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">手数料:</label>
                                                    <div class="search-form" >
                                                        <input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                                            class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0)">
                                                        <input type="text" v-if="edit_form != 0" v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                                            class="form-control" v-model="item.phi_chuyen_khoan">
                                                    </div>
                                                </div>
											</div>
											<div class="col-lg-4 ">
												<div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
													<div class="form-group">
														<label class="form-check-label" style="margin-left : 20px">
															<input  type="checkbox" v-bind:name="'jobsConnect['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
															振込済み
														</label>
													</div>
												</div>
                                            </div>
										</div>
                                        
                                    </div>
                                </div>
								
								
								
                            </div>
						
							<div class="row mb-32pt"　v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                <div class="col-lg-12 align-items-center">
                                    
                                    <div class="flex mb-5 style-group-add" v-for="(item, index) in listBankAccount"
                                        v-bind:class='item.type !== "delete" ? "" : "hidden" '>
                                        <div class="row mb-32pt">
                                            <div class="col-lg-12">
                                                <div class="form-group" style="text-align:center">
												<label class="form-label ml-2 w-100" style="text-decoration: underline;font-size: 16pt; color:green">源泉所得税の納税</label>
												</div>
											</div>
                                            <div class="col-lg-3">
												<label class="form-label">通訳者</label>
                                                <div class="form-group">
                                                    <div style="display: flex; justify-content: flex-start; align-items: center;">
                                                        <a  target="_blank" :href="'/admin/collaborators/edit/' + item.info.id" >
                                                            <p class="m-0" style="text-transform: uppercase;" ><strong
                                                                    class="js-lists-values-employee-name btn btn-outline-secondary">
                                                                    <i v-if="item.info.male == 2" class="fas fa-female" style="font-size:20px;color:red; margin-right:10px"></i>
                                                                    <i v-if="item.info.male == 1" class="fas fa-male"  style="font-size:20px;color:blue; margin-right:10px"></i>
                                                                    ((item.info.name))
                                                                    
                                                                </strong>
                                                            </p>
                                                        </a>
                                                    </div>
                                                    <br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
                                                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.info.phone))</a></label><br>
                                                    <label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
                                                    <label class="form-label" for="chuTaiKhoan"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.info.address))</label><br>
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][id]'" v-model="item.id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][collaborators_id]'" v-model="item.collaborators_id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][type]'" v-model="item.type">
                                                </div>
                                            </div>
                                            <div class="col-lg-5" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">納税地</label>
                                                    <div class="search-form" >
                                                        <select :readonly="edit_form == 0" class="form-control custom-select"
                                                            v-bind:name="'jobsConnect['+index+'][paytaxplace]'" v-model="item.paytaxplace">
                                                            <option value=""></option>
                                                            <option value="松戸税務署">松戸税務署</option>
                                                        </select>


                                                    </div>
                                                </div>
                                                <div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <label class="form-label">納税日</label>
                                                    <div class="search-form" >
                                                        <input type="date" :readonly="edit_form == 0" v-bind:name="'jobsConnect['+index+'][paytaxdate]'"
                                                            class="form-control" v-model="item.paytaxdate">
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label class="form-label">課税対象額:</label>
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_phien_dich_total ? item.phi_phien_dich_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.phi_phien_dich_total">
                                                </div>
												<div class="form-group">
                                                    <label class="form-label">納税額</label>
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][thue_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.thue_phien_dich_total ? item.thue_phien_dich_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][thue_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.thue_phien_dich_total">
                                                </div>
											</div>
											<div class="col-lg-4 ">
												<div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
													<div class="form-group">
														<label class="form-check-label" style="margin-left : 20px">
															<input  type="checkbox" v-bind:name="'jobsConnect['+index+'][paytaxstatus]'" v-model="item.paytaxstatus" class="form-check-input" value="1" true-value="1" false-value="0">
															納税済み
														</label>
													</div>
												</div>
                                            </div>
                                            
										</div>
                                        
                                    </div>
                                </div>
								
								
								
                            </div>
						
						</div>
						<div class="tab-pane text-70" id="detailtab8">
							<div class="row mb-32pt">
									
								<div class="col-lg-4">
									<div class="form-group">
                                        <label class="form-label">受領額</label>
                                        <div >
                                            <!-- <input type="text" name="tong_thu" class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->tong_thu}}" > -->
                                            <input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_thu ? @$data->tong_thu : 0}})" >
                                        </div>
                                    </div>
								</div>
									
								<div class="col-lg-4">
									<div class="form-group">
										<label class="form-label">総支給額</label>
										<div >
											<input type="text" name="tong_chi" readonly class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->tong_chi}}" >
											<input type="text" class="form-control" v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->tong_chi ? @$data->tong_chi : 0}})" >
										</div>
									</div>
									
									
									<table border="1" width="500" cellspacing="0" cellpadding="5" bordercolor="#333333">
									<tr>
									<th bgcolor="#EE0000"><font color="#FFFFFF">支給内容</font></th>
									<th bgcolor="#EE0000"><font color="#FFFFFF">金額</font></th>
									</tr>
									<tr>
									<td bgcolor="#99CC00" nowrap>営業報酬</td>
									<td bgcolor="#FFFFFF" >
										<div v-for="(item, index) in listAcountSale"
											v-bind:class='item.type !== "delete" ? "" : "hidden" '>
											<div class="form-group">
												<div >
													<input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsSale['+index+'][price_total]'"
														class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.price_total ? item.price_total : 0) ">
													<input type="number" v-if="edit_form != 0" v-bind:name="'jobsSale['+index+'][price_total]'"
													class="form-control" v-model="item.price_total">
												</div>
											</div>
										</div>
									</td>
									</tr>
									<tr>
									<td bgcolor="#99CC00" nowrap>営業報酬振込の手数料</td>
									<td bgcolor="#FFFFFF" >
										<div v-for="(item, index) in listAcountSale"
											v-bind:class='item.type !== "delete" ? "" : "hidden" '>
											<div class="form-group">
												<div>
													<input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
														class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0) ">
													<input type="text" v-if="edit_form != 0" v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
														class="form-control" v-model="item.phi_chuyen_khoan">
												</div>
											</div>
										</div>
									</td>
									</tr>
									<tr v-bind:class='loai_job == 1 ? "" : "hidden" '>
									<td bgcolor="#99CC00" nowrap>通訳給与</td>
									<td bgcolor="#FFFFFF" >
										<div v-for="(item, index) in listBankAccount"
											v-bind:class='item.type !== "delete" ? "" : "hidden" '>
										
												<div class="form-group">
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_phien_dich_total ? item.phi_phien_dich_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][phi_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.phi_phien_dich_total">
                                                </div>
											</div>
									</td>
									</tr>
									<tr>
									<td bgcolor="#99CC00" nowrap>交通費等</td>
									<td bgcolor="#FFFFFF" >
										<div v-for="(item, index) in listBankAccount"
											v-bind:class='item.type !== "delete" ? "" : "hidden" '>
										
												<div class="form-group">
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][phi_giao_thong_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_giao_thong_total ? item.phi_giao_thong_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][phi_giao_thong_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.phi_giao_thong_total">
                                                </div>
											</div>
									</td>
									</tr>
									<tr v-bind:class='loai_job == 1 ? "" : "hidden" '>
									<td bgcolor="#99CC00" nowrap>通訳給与振込の手数料</td>
									<td bgcolor="#FFFFFF" >
										<div v-for="(item, index) in listBankAccount"
											v-bind:class='item.type !== "delete" ? "" : "hidden" '>
										
												<div class="form-group" v-bind:class='loai_job == 1 ? "" : "hidden" '>
                                                    <div >
                                                        <input type="text" v-if="edit_form == 0" readonly v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                                            class="form-control" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.phi_chuyen_khoan ? item.phi_chuyen_khoan : 0)">
                                                        <input type="text" v-if="edit_form != 0" v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                                            class="form-control" v-model="item.phi_chuyen_khoan">
                                                    </div>
                                                </div>
											</div>
									</td>
									</tr>
									<tr v-bind:class='loai_job == 1 ? "" : "hidden" '>
									<td bgcolor="#99CC00" nowrap>源泉所得税</td>
									<td bgcolor="#FFFFFF" >
										<div v-for="(item, index) in listBankAccount"
											v-bind:class='item.type !== "delete" ? "" : "hidden" '>
										
												<div class="form-group">
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][thue_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form == 0" :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(item.thue_phien_dich_total ? item.thue_phien_dich_total : 0)">
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][thue_phien_dich_total]'"
                                                            class="form-control" readonly v-if="edit_form != 0" v-model="item.thue_phien_dich_total">
                                                </div>
												</div>
									</td>
									</tr>
									</table>
									<!--
									<div class="form-group">
										<div class="form-check">
											<label class="form-check-label">
												<input   type="checkbox" name="status_chi" @if(@$data->status_chi == 1) checked @endif class="form-check-input" value="1">
												支払済み
											</label>
										</div>
									</div>
									-->
								</div>
								
								<div class="col-lg-4">
									<div class="form-group">
										<label class="form-label">営業利益:</label>
										<div >
											<input type="number" name="price_nhanduoc" readonly class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->price_nhanduoc}}" >
											<input type="text"  class="form-control"  v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->price_nhanduoc ? @$data->price_nhanduoc : 0}}) " >
										</div>
									</div>
									<div class="form-group">
										<label class="form-label">純利益:</label>
										<div >
											<input type="number" name="price_nhanduoc_sauphivanhanh" readonly class="form-control" v-bind:class='edit_form != 0 ? "" : "hidden" ' value="{{@$data->price_nhanduoc_sauphivanhanh}}" >
											<input type="text"  class="form-control"  v-bind:class='edit_form == 0 ? "" : "hidden" ' readonly :value="new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format({{@$data->price_nhanduoc_sauphivanhanh ? @$data->price_nhanduoc_sauphivanhanh : 0}}) " >
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
                </div>

				
							
										
                <button type="button" @click="cancleEdit()" style="float:right;" class="btn btn-danger mb-5 mt-5 " v-if="edit_form == 1">キャンセル</button>
                <button type="button"  @click="onSubmit()"  style="float:right; margin-bottom : 20px" class="btn btn-primary mb-5 mr-2  mt-5 btn-submit" v-if="edit_form == 1">保存</button>
                
            </form>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" >
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Mail Template</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-label">CC</label>
                                <div class="search-form" >
                                    <input type="text" class="form-control" v-model="objSendMail.mail_cc" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <div class="search-form" >
                                    <input type="text" class="form-control" v-model="objSendMail.title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Body</label>
                                <div class="search-form" >
                                <textarea type="text" class="form-control" v-model="objSendMail.body" rows="5" ></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" @click="submitSendMail()" class="btn btn-secondary" >Send</button>
                            <button type="button" data-dismiss="modal"  class="btn btn-danger" >Cancel</button>
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
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });

        
    
    });
    jQuery(document).ready(function (){
        $('#listDate').datepick({ 
        multiSelect: 999, 
        dateFormat: 'yyyy-mm-dd',
        monthsToShow: 1});
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
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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
        flagSendMail : '{{$flagSendMail}}',
        userCustomerId: '{{$flagCustomer}}',
        typehoahong: '{{$data->typehoahong}}',
        percent_vat_ctvpd: '{{$data->percent_vat_ctvpd}}',
        showListPD : 0,
        showListCus : 0,
        showListCtv : 0
    },
    delimiters: ["((", "))"],
    mounted() {
        const that = this;
        @foreach($dataColla as $itemConnect)

        $.ajax({
            url: "/admin/collaborators/get-detail-id/{{$itemConnect->collaborators_id}}",
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                that.listBankAccount.push({
                    id: '{{$itemConnect->id}}',
                    type: 'update',
                    collaborators_id: '{{$itemConnect->collaborators_id}}',
                    price_total: '{{$itemConnect->price_total}}',
                    phi_phien_dich_total: '{{$itemConnect->phi_phien_dich_total}}',
                    phi_giao_thong_total: '{{$itemConnect->phi_giao_thong_total}}',
                    thue_phien_dich_total: '{{$itemConnect->thue_phien_dich_total}}',
                    bank_id: '{{$itemConnect->bank_id}}',
                    listBank: res.data.bank,
                    ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                    phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                    dateList: @json($itemConnect['dateList']),
                    status: '{{$itemConnect->status}}',
                    paytaxdate: '{{$itemConnect->paytaxdate}}',
                    paytaxstatus: '{{$itemConnect->paytaxstatus}}',
                    paytaxplace: '{{$itemConnect->paytaxplace}}',
                    info: res.data
                });
            },
            error: function(xhr, textStatus, error) {
                Swal.fire({
                    title: "Có lỗi dữ liệu nhập vào!",
                    type: "warning",

                });
            }
        });

        @endforeach

        @foreach($allMailTemplate as $itemMailTemplate)
            that.listSendMail.push({
                title: '{{$itemMailTemplate->subject}}',
                mail_cc: '{{$itemMailTemplate->cc_mail}}',
                body: @json($itemMailTemplate->body) 
            });
        @endforeach

        @foreach($dataSales as $itemConnect)

      
            that.listAcountSale.push({
                id: '{{$itemConnect->id}}',
                type: 'update',
                ctv_jobs_id: '{{$itemConnect->ctv_jobs_id}}',
                price_total: '{{$itemConnect->price_total}}',
                ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                payplace: '{{$itemConnect->payplace}}',
                status: '{{$itemConnect->status}}',
                info: @json($itemConnect['userInfo']),
            });

        @endforeach
        @foreach($dataCustomer as $itemConnect)

      
            that.listAcountCustomer.push({
                id: '{{$itemConnect->id}}',
                type: 'update',
                cus_jobs_id: '{{$itemConnect->cus_jobs_id}}',
                price_total: '{{$itemConnect->price_total}}',
                ngay_chuyen_khoan: '{{$itemConnect->ngay_chuyen_khoan}}',
                phi_chuyen_khoan: '{{$itemConnect->phi_chuyen_khoan}}',
                status: '{{$itemConnect->status}}',
                info: @json($itemConnect['userInfo']),
            });

        @endforeach
    },
    methods: {
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
            alert("営業者報酬 : "+ (totalAlerMessage * 10 / 100));
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
        sendMailTemplate(_idMail) {
            if (this.flagSendMail == 0) {
                Swal.fire({
                    title: "Chọn thông dịch viên và lưu lại trước khi gửi mail.",
                    type: "warning",
                });
                return;
            }
            this.objSendMail = this.listSendMail[_idMail];
            
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
        changeTypeJobs() {
            if (this.loai_job != 1) {
                this.percent_vat_ctvpd  = 0;
            } else {
                if (this.loai_job == 3) {
                    this.price_send_ctvpd = 0;
                }
                this.percent_vat_ctvpd  = 10.21;
            }
        },
        changeTypeHoaHong() {
            if (this.typehoahong == 1) {
                this.percent_vat_ctvpd  = 0;
            } else {
                this.percent_vat_ctvpd  = 10.21;
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
        onGetCustomer() {
            this.pageCustomer = 1;
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
        },
        onGetByAddress() {
            this.page = 1;
            this.loadingTable = 1;
            const that = this;
            let conditionSearch = '';
            if (this.conditionName != '') {
                conditionSearch += '&name=' + this.conditionName;
            }
            if (this.jplt != '') {
                conditionSearch += '&jplt=' + this.jplt;
            }
            if (this.male != '') {
                conditionSearch += '&male=' + this.male;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/collaborators/get-list?" + conditionSearch,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
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
        },
        onPageChange(_p) {
            this.page = _p;
            this.onLoadPagination();
        },
        onSearch: function() {
            this.page = 1;
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
                    url: "/admin/company/delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/company";
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
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCollaborators')}}?page=" + this.page + "&name=" + this
                    .conditionName,
                success: function(data) {
                    if (data.count > 0) {
                        data.data.map(item => {
                            item.edit = 1;
                            item.send_mail = 0;
                        });
                        that.count = data.pageTotal;
                        that.list = data.data;
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
