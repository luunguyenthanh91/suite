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
                    <h1 class="h2 mb-0">通訳案件aaaa</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="/admin/company">通訳案件リスト</a></li>
                        <li class="breadcrumb-item active">新規</li>
                    </ol>

                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <form action="" method="POST" class="p-0 mx-auto form-data" >
                @csrf
                <div class="row mb-32pt">
                    <div class="col-lg-2">
                        <!-- <div class="page-separator">
                            <div class="page-separator__text">基本情報</div>
                        </div> -->
                        <!-- <div class="form-group">
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
                        </div> -->
                        <div class="flex" style="max-width: 100%">
                            
                            <div class="form-group" style="display: none">
                                <label class="form-label ml-2">1時間以内 ＝　3,000円</label>
                                <label class="form-label ml-2">2時間以内 ＝　4,000円</label>
                                <label class="form-label ml-2">3時間以内 ＝　5,000円</label>
                                <label class="form-label ml-2">4時間以内 ＝　6,000円</label>
                                <label class="form-label ml-2">5時間以内 ＝　7,000円</label>
                                <label class="form-label ml-2">6時間以内 ＝　8,000円</label>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">受注日</label>
                                <input type="date" name="date_start" class="form-control" value="{{date('Y-m-d')}}" required>
                            </div>
                            <div class="form-group ">
                                <label class="form-label">通訳日数</label>
                                <input type="number" readonly class="form-control" >
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">Tình Trạng Công Việc:</label>
                                <select class="form-control custom-select" name="status"  >
                                    <option value="0" selected>受注</option>
                                    <option value="1" >通訳者確定</option>
                                    <option value="2" >通訳当日</option>
                                    <option value="3" >入金確認</option>
                                    <option value="4" >通訳者へ支給</option>
                                    <option value="5" >営業者へ手数料支給</option>
                                    <option value="6" >クローズ</option>
                                    <option value="7" >キャンセル</option>
                                    <option value="8">手配料金入金確認</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label class="form-label">Tình Trạng Cộng Tác Viên:</label>
                                <div class="search-form" >
                                    <select class="form-control custom-select" name="status_ctv_pd" >
                                        <option value="" ></option>
                                        <option value="1">通訳者から連絡待ち（依頼メール送信済）</option>
                                        <option value="2">通訳対応待ち</option>
                                        <option value="3">通訳対応中</option>
                                        <option value="4">AlphaCepは、通訳</option>
                                        <option value="5">料金の入金待ち</option>
                                        <option value="6">報酬の入金確認中</option>
                                        <option value="7">済み</option>
                                        <option value="8">キャンセル</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label class="form-label">Tình Trạng Cộng Tác Viên Sale:</label>
                                <div class="search-form" >
                                    <select class="form-control custom-select" name="status_ctv">
                                        <option value="" ></option>
                                        <option value="1">通訳件の掲載中</option>
                                        <option value="2">AlphaCepは、確認待ち</option>
                                        <option value="3">AlphaCepは、通訳手配準備中</option>
                                        <option value="4">AlphaCepは、通訳手配中</option>
                                        <option value="5">AlphaCepは、通訳料金の入金待ち</option>
                                        <option value="6">報酬の入金確認中</option>
                                        <option value="7">済み</option>
                                        <option value="8">キャンセル</option>
                                    </select>
                                </div>
                            </div> -->
                            
                            <div  style="display:none;" class="form-group">
                                <label class="form-label">Kinh Độ Nơi Phiên Dịch:</label>
                                <input type="text" name="longitude" v-model="long" class="form-control" readonly>
                            </div>
                            <div  style="display:none;" class="form-group">
                                <label class="form-label">Vĩ Độ Nơi Phiên Dịch:</label>
                                <input type="text" name="latitude" v-model="lat"  class="form-control" readonly>
                            </div>

                            
                            
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex ">
                        <div class="flex" style="max-width: 100%">
                            
                            <div class="form-group ">
                                <label class="form-label">通訳日</label>
                                <input type="text" autocomplete="off" id="listDate" name="ngay_pd" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">住所</label>
                                <div class="search-form" >
                                    <input type="text" name="address_pd"  class="form-control" required  v-model="address_pd" >
                                </div>
                            </div>
                            
                            <!-- <div class="form-group">
                                <label class="form-label">Ga Gần Nơi Phiên Dịch Nhất:</label>
                                <div class="search-form" >
                                    <input type="text" name="ga" class="form-control" v-model="ga_gannhat" >
                                </div>
                            </div> -->
<!--
                            <div class="form-group">
                                <label class="form-label">通訳内容</label>
                                
                                @foreach($typesList as $item_type)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="types[]" class="form-check-input" value="{{$item_type['id']}}">
                                            {{ $item_type['name'] }}
                                        </label>
                                    </div>
                                    
                                @endforeach
                            </div>
							-->
                            
                            
                            <!-- <div class="form-group">
                                <label class="form-label">Yêu Cầu Hóa Đơn Chi Phí Giao Thông:</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiostatus_fax1" name="status_fax" type="radio"
                                            class="custom-control-input" value="0">
                                        <label for="radiostatus_fax1" class="custom-control-label">Không</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiostatus_fax2" name="status_fax" type="radio"
                                            class="custom-control-input" value="1">
                                        <label for="radiostatus_fax2" class="custom-control-label">Có</label>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label class="form-label">Có Thể Ở Nhà TTS Nếu PD Ở Xa:</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiohouse_tts1" name="house_tts" type="radio"
                                            class="custom-control-input" value="0">
                                        <label for="radiohouse_tts1" class="custom-control-label">Không</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiohouse_tts2" name="house_tts" type="radio"
                                            class="custom-control-input" value="1">
                                        <label for="radiohouse_tts2" class="custom-control-label">Có</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Chiết Khấu Hoa Hồng Cho CTV Sale:</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiohoahong1" name="hoahong" type="radio"
                                            class="custom-control-input" value="0">
                                        <label for="radiohoahong1" class="custom-control-label">Không</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiohoahong2" name="hoahong" type="radio"
                                            class="custom-control-input" value="1">
                                        <label for="radiohoahong2" class="custom-control-label">Có</label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group" style="display: none">
                                <label class="form-label">売上予測</label>
                                <input type="text" name="tong_thu_du_kien" class="form-control">
                            </div>
                            <!-- new -->
                            <div class="form-group" style="display: none">
                                <label class="form-label">通訳者給料</label>
                                <input type="text" name="price_send_ctvpd" class="form-control">
                            </div>
                            <div class="form-group" style="display: none">
                                <label class="form-label">通訳者給料税金率</label>
                                <input type="text" name="percent_vat_ctvpd" class="form-control" value='10.21'>
                            </div>
                            <div class="form-group" style="display: none">
                                <label class="form-label">通訳者給料税金</label>
                                <input type="text" name="price_vat_ctvpd" readonly class="form-control">
                            </div>
                            <div class="form-group" style="display: none">
                                <label class="form-label">営業者報酬</label>
                                <input type="text" name="price_sale" class="form-control">
                            </div>
                            <div class="form-group" style="display: none">
                                <label class="form-label">運営費用</label>
                                <input type="text" name="price_company_duytri" class="form-control" value='500'>
                            </div>
                            <div class="form-group" style="display: none">
                                <label class="form-label">他の出金（振込手数料など）</label>
                                <input type="text"  name="ortherPrice" class="form-control"  value="">
                            </div>
                            <!-- endnew -->
                            
                            <div class="form-group" style="display: none">
                                <label class="form-label">利益予測</label>
                                <input type="number" name="tong_kimduocdukien" readonly class="form-control">
                            </div>
                            <!-- <div class="form-group">
                                <label class="form-label">Tổng Chi Dự Kiến:</label>
                                <input type="text" name="tong_chidukien" class="form-control">
                            </div> 
                            <div class="form-group">
                                <label class="form-label">待合せ場所</label>
                                <input type="text" name="ten_nguoilienlac" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">待合せ時間</label>
                                <input type="text" name="phone_nguoilienlac" class="form-control" >
                            </div>
							-->
                            
                            <!-- <div class="form-group">
                                <label class="form-label">Có Thể Đổi PD Nếu Việc Kéo Dài Nhiều Ngày:</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiochang_ctv1" name="chang_ctv" type="radio"
                                            class="custom-control-input" checked value="0">
                                        <label for="radiochang_ctv1" class="custom-control-label">Không</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiochang_ctv2" name="chang_ctv" type="radio"
                                            class="custom-control-input" value="1">
                                        <label for="radiochang_ctv2" class="custom-control-label">Có</label>
                                    </div>
                                </div>
                            </div> -->
                            
                            
                        </div>
                    </div>

                    <div class="col-lg-4">
                        
                        <div class="flex" style="max-width: 100%">
                            
                        <div class="form-group">
                            <label class="form-label">通訳料金</label> 
                            <div class="search-form">
                                <input type="text" name="tienphiendich" class="form-control">
                            </div>
                        </div>
						<div class="form-group">
							<label class="form-label">交通費上限額</label>
                            <div class="search-form">
								<input type="text" name="price_giaothong" class="form-control">
                            </div>
						</div>
                        </div>
                    </div>


                </div>


                <!-- <div class="row mb-32pt">
                    <div class="col-lg-6 overflow-auto">
                        <div class="page-separator">
                            <div class="page-separator__text">Nhân Viên Làm Việc</div>
                        </div>
                        
                        <div class="" role="tablist">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label m-0">Họ Tên</label>
                                    <input type="text" class="form-control search" v-on:keyup.enter="onGetByAddress()"
                                        v-model="conditionName">
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0">Giới Tính</label>
                                    <select class="form-control search" v-model="male" @change="onGetByAddress()">
                                        <option value=""></option>
                                        <option value="1">Nam</option>
                                        <option value="2">Nữ</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label class="form-label m-0">JLPT</label>
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
                                    <a @click="onGetByAddress()" class="btn btn-outline-secondary">Tìm Theo Location</a>
                                </div>

                                <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                    <tbody class="list" id="search">
                                        <tr v-for="item in list">
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="flex title-edit">
                                                        <p class="mb-2" style="text-transform: uppercase;" ><strong
                                                                class="js-lists-values-employee-name"><a  :href="'/admin/collaborators/edit/' + item.id" >((item.name))</a></strong>
                                                        </p>
                                                        <div class="form-group">
                                                            <a @click="addRecord(item)" class="text-50"><i
                                                            class="material-icons">library_add</i></a>
                                                        </div>
                                                    </div>
                                                    <p class="mb-0">Furigana: ((item.furigana))</p>
                                                    <p class="mb-2"><a :href="'tel:'+item.phone"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span>((item.phone))</a></p>
                                                    <p class="mb-2"><a :href="'mailto:'+item.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.email))</a></p>
                                                    <p class="mb-2"><a :href="'http://maps.google.com/maps?q=' + item.address" target="_blank"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">location_on</span>((item.address))</a></p>
                                                    <p class="mb-0" v-if="item.distance"><a href="#">(( parseInt(item.distance) )) KM</a></p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="card-footer p-8pt">
                                    <ul class="pagination justify-content-start pagination-xsm m-0">
                                        <li class="page-item" v-bind:class="page <= 1 ? 'disabled' : ''" @click="onPrePage()">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                <span>Prev</span>
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
                                                <span>Next</span>
                                                <span aria-hidden="true" class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-items-center overflow-auto">
                        
                        <div class="flex mb-5 style-group-add" v-for="(item, index) in listBankAccount"
                            v-bind:class='item.type !== "delete" ? "" : "hidden" '>

                            <div class="form-group">
                                <label class="form-label" for="chuTaiKhoan">Tên Người Làm:
                                    ((item.info.name))</label><br>
                                <label class="form-label" for="chuTaiKhoan">Số Điện Thoại:<a :href="'tel:'+item.info.phone">
                                    ((item.info.phone))</a></label><br>
                                <label class="form-label" for="chuTaiKhoan">Email: <a :href="'mailto:'+item.info.email">((item.info.email))</a></label><br>
                                <label class="form-label" for="chuTaiKhoan">Địa Chỉ: ((item.info.address))</label><br>
                                <input type="hidden" v-bind:name="'jobsConnect['+index+'][id]'" v-model="item.id">
                                <input type="hidden" v-bind:name="'jobsConnect['+index+'][collaborators_id]'"
                                    v-model="item.collaborators_id">
                                <input type="hidden" v-bind:name="'jobsConnect['+index+'][type]'" v-model="item.type">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tổng Số Tiền Thanh Toán (Bao Gồm Phí GT):</label>
                                <input type="number" v-bind:name="'jobsConnect['+index+'][price_total]'"
                                    class="form-control" v-model="item.price_total">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phí Chuyển Khoản:</label>
                                <input type="text" v-bind:name="'jobsConnect['+index+'][phi_chuyen_khoan]'"
                                    class="form-control" v-model="item.phi_chuyen_khoan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Ngày Chuyển Khoản:</label>
                                <input type="date" v-bind:name="'jobsConnect['+index+'][ngay_chuyen_khoan]'"
                                    class="form-control" v-model="item.ngay_chuyen_khoan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Thông Tin Tài Khoản:</label>
                                <select class="form-control custom-select"
                                    v-bind:name="'jobsConnect['+index+'][bank_id]'" v-model="item.bank_id">
                                    <option value="">Chọn Tài Khoản</option>
                                    <option v-for="itemBank in item.listBank" v-bind:value='itemBank.id'>
                                        ((itemBank.ten_bank)) - ((itemBank.ten_chutaikhoan)) - ((itemBank.stk)) -
                                        ((itemBank.chinhanh)) </option>
                                </select>
                            </div>
                            <div class="flex mb-5 style-group-add" style="background: #ccc;" v-for="(item1, index1) in item.dateList" v-bind:class='item1.type !== "delete" ? "" : "hidden" '>
                                <label class="form-label">Ngày Dịch Thứ ((index1 + 1)) :</label>
                                <div class="form-group">
                                    <label class="form-label">Ngày Phiên Dịch:</label>
                                    <input type="date" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][ngay_phien_dich]'"
                                        class="form-control" v-model="item1.ngay_phien_dich">
                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][id]'"
                                        class="form-control" v-model="item1.id">
                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][type]'"
                                        class="form-control" v-model="item1.type">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Giờ Phiên Dịch:</label>
                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][gio_phien_dich]'"
                                        class="form-control" v-model="item1.gio_phien_dich">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nội Dung Phiên Dịch:</label>
                                    <textarea type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][note]'"
                                        class="form-control" v-model="item1.note" rows="10" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phí Phiên Dịch:</label>
                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_phien_dich]'"
                                        class="form-control" v-model="item1.phi_phien_dich">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phí Giao Thông:</label>
                                    <input type="text" v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][phi_giao_thong]'"
                                        class="form-control" v-model="item1.phi_giao_thong">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">File Báo Cáo Phiên Dịch:</label>
                                    <li id="images">   
                                        <input v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][file_bao_cao]'"
                                        class="form-control"  type="text" v-bind:id="'chooseImage_inputfile'+index1" v-model="item1.file_bao_cao">
                                        <a v-if="item1.file_bao_cao != '' " :href="item1.file_bao_cao"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">file_download</span></a>
                                       
                                        <br/>
                                        
                                        <a onclick="chooseFile(this)"  :rel="'file'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                        | 
                                        <a onclick="clearFile(this)" :rel="'file'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                    </li>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">File Hóa Đơn Giao Thông:</label>
                                    <li id="images">   
                                        <input v-bind:name="'jobsConnect['+index+'][dateList]['+index1+'][file_hoa_don]'"
                                        class="form-control"  type="text" v-bind:id="'chooseImage_inputfilehd'+index1" v-model="item1.file_hoa_don">
                                        <a v-if="item1.file_hoa_don != '' " :href="item1.file_hoa_don"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">file_download</span></a>
                                       
                                        <br/>
                                        
                                        <a onclick="chooseFile(this)"  :rel="'filehd'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                        | 
                                        <a onclick="clearFile(this)" :rel="'filehd'+index1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                    </li>
                                </div>
                                <button @click="removeListRecord(item1)" type="button" class="btn btn-danger">Xóa</button>
                            </div>



                            <button @click="removeRecord(item)" type="button" class="btn btn-danger">Xóa</button>
                            <button @click="addListRecord(item)" type="button" class="btn btn-primary">Thêm Lịch Phiên Dịch</button>
                        </div>
                    </div>

                </div> -->

                <div class="row mb-32pt" style="display: none">
                    <div class="col-lg-6 overflow-auto">
                        <div class="page-separator">
                            <div class="page-separator__text">営業者情報</div>
                        </div>
                        
                        <div class="" role="tablist">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label m-0">名前</label>
                                    <input type="text" class="form-control search" v-on:keyup.enter="onGetSales()"
                                        v-model="conditionNameSale">
                                </div>

                                <div class="form-group">
                                    <a @click="onGetSales()" class="btn btn-outline-secondary">検索</a>
                                </div>

                                <table class="table mb-0 thead-border-top-0 table-nowrap style-group-add">
                                    <tbody class="list" id="search">
                                        <tr v-for="item in listSales">
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="flex title-edit">
                                                        <p class="mb-2" style="text-transform: uppercase;" >
                                                            <strong  class="js-lists-values-employee-name">((item.name))</strong>
                                                        </p>
                                                        <div class="form-group">
                                                            <a @click="addRecordSale(item)" class="text-50"><i
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
                                        <li class="page-item" v-bind:class="pageSales <= 1 ? 'disabled' : ''" @click="onPrePageSales()">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                <span>Prev</span>
                                            </a>
                                        </li>
                                        <li class="page-item disabled" v-if="pageSales > 3 ">
                                            <a class="page-link" href="#">
                                                <span>...</span>
                                            </a>
                                        </li>
                                        <li class="page-item" v-for="item in listPageSales"
                                            v-if="pageSales > (item - 3) && pageSales < (item + 3) " @click="onPageChangeSales(item)"
                                            v-bind:class="pageSales == item ? 'active' : ''">
                                            <a class="page-link" href="#" aria-label="Page 1">
                                                <span>((item))</span>
                                            </a>
                                        </li>
                                        <li class="page-item" @click="onNextPageSales()"
                                            v-bind:class="pageSales > count - 1 ? 'disabled' : ''">
                                            <a class="page-link" href="#">
                                                <span>Next</span>
                                                <span aria-hidden="true" class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-items-center overflow-auto">
                        
                        <div class="flex mb-5 style-group-add" v-for="(item, index) in listAcountSale"
                            v-bind:class='item.type !== "delete" ? "" : "hidden" '>

                            <div class="form-group">
                                <label class="form-label" for="chuTaiKhoan">((item.info.name))</label><br>
                                <label class="form-label" for="chuTaiKhoan"><a :href="'tel:'+item.info.phone">
                                <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span> ((item.info.phone))</a></label><br>
                                <label class="form-label" for="chuTaiKhoan"><a :href="'mailto:'+item.info.email"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span>((item.info.email))</a></label><br>
                                <input type="hidden" v-bind:name="'jobsSale['+index+'][id]'" v-model="item.id">
                                <input type="hidden" v-bind:name="'jobsSale['+index+'][ctv_jobs_id]'"
                                    v-model="item.ctv_jobs_id">
                                <input type="hidden" v-bind:name="'jobsSale['+index+'][type]'" v-model="item.type">
                            </div>
                            <div class="form-group">
                                <label class="form-label">銀行口座情報</label><br>
                                <label class="form-label" for="chuTaiKhoan">((item.info.ten_bank)) ( ((item.info.ms_nganhang)) ) - ((item.info.chinhanh)) ( ((item.info.ms_chinhanh)) ) - ((item.info.loai_taikhoan)) - ((item.info.stk)) - ((item.info.ten_chutaikhoan))</label><br>
                            </div>
                            <div class="form-group">
                                <label class="form-label">振込日</label>
                                <input type="date" v-bind:name="'jobsSale['+index+'][ngay_chuyen_khoan]'"
                                    class="form-control" v-model="item.ngay_chuyen_khoan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">振込金額</label>
                                
                                <input type="number" v-bind:name="'jobsSale['+index+'][price_total]'"
                                class="form-control" v-model="item.price_total">
                            </div>
                            <div class="form-group">
                                <label class="form-label">振込手数料</label>
                                <input type="text" v-bind:name="'jobsSale['+index+'][phi_chuyen_khoan]'"
                                    class="form-control" v-model="item.phi_chuyen_khoan">
                            </div>
                            <div class="form-group">
                                <label class="form-label">ステータス</label>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input  type="checkbox" v-bind:name="'jobsSale['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
                                    支給済み
                                </label>
                            </div>


                            <button @click="removeRecordSales(item)" type="button" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>

                </div> 



                <div class="row mb-32pt" style="display: none">
                    <div class="col-lg-6 overflow-auto">
                        <div class="page-separator">
                            <div class="page-separator__text">顧客情報</div>
                        </div>
                        
                        <div class="" role="tablist">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label m-0">名前</label>
                                    <input type="text" class="form-control search" v-on:keyup.enter="onGetCustomer()"
                                        v-model="conditionNameCustomer">
                                </div>

                                <div class="form-group">
                                    <a @click="onGetCustomer()" class="btn btn-outline-secondary">検索</a>
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
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true" class="material-icons">chevron_left</span>
                                                <span>Prev</span>
                                            </a>
                                        </li>
                                        <li class="page-item disabled" v-if="pageCustomer > 3 ">
                                            <a class="page-link" href="#">
                                                <span>...</span>
                                            </a>
                                        </li>
                                        <li class="page-item" v-for="item in listPageCustomer"
                                            v-if="pageCustomer > (item - 3) && pageCustomer < (item + 3) " @click="onPageChangeCustomer(item)"
                                            v-bind:class="pageCustomer == item ? 'active' : ''">
                                            <a class="page-link" href="#" aria-label="Page 1">
                                                <span>((item))</span>
                                            </a>
                                        </li>
                                        <li class="page-item" @click="onNextPageCustomer()"
                                            v-bind:class="pageCustomer > count - 1 ? 'disabled' : ''">
                                            <a class="page-link" href="#">
                                                <span>Next</span>
                                                <span aria-hidden="true" class="material-icons">chevron_right</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-items-center overflow-auto">
                        
                        <div class="flex mb-5 style-group-add" v-for="(item, index) in listAcountCustomer"
                            v-bind:class='item.type !== "delete" ? "" : "hidden" '>

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
                                <label class="form-label">銀行口座情報</label><br>
                                <label class="form-label" for="chuTaiKhoan">((item.info.ten_bank)) ( ((item.info.ms_nganhang)) ) - ((item.info.chinhanh)) ( ((item.info.ms_chinhanh)) ) - ((item.info.loai_taikhoan)) - ((item.info.stk)) - ((item.info.ten_chutaikhoan))</label><br>
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">振込日</label>
                                <input type="date" v-bind:name="'jobsCustomer['+index+'][ngay_chuyen_khoan]'"
                                    class="form-control" v-model="item.ngay_chuyen_khoan">
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">振込金額</label>
                                
                                <input type="number" v-bind:name="'jobsCustomer['+index+'][price_total]'"
                                class="form-control" v-model="item.price_total">
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">振込手数料</label>
                                <input type="text" v-bind:name="'jobsCustomer['+index+'][phi_chuyen_khoan]'"
                                    class="form-control" v-model="item.phi_chuyen_khoan">
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">ステータス</label>
                                <label class="form-check-label" style="margin-left : 20px">
                                    <input  type="checkbox" v-bind:name="'jobsCustomer['+index+'][status]'" v-model="item.status" class="form-check-input" value="1" true-value="1" false-value="0">
                                    支給済み
                                </label>
                            </div>


                            <button @click="removeRecordCustomer(item)" type="button" class="btn btn-danger">Xóa</button>
                        </div>
                    </div>

                </div> 

                <div class="row mb-32pt" style="display: none">
                    

                    <!-- <div class="col-lg-4 ">
                        <div class="page-separator">
                            <div class="page-separator__text">Tổng Thu</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ngày Nhận Tiền Trong Tài Khoản Ngân Hàng:</label>
                            <input type="date" name="date_company_pay" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tài Khoản Ngân Hàng Nhận Tiền:</label>
                            <select class="form-control custom-select" name="stk_thanh_toan_id" required>
                                <option value=""></option>
                                @foreach($allMyBank as $itemBank)
                                <option value="{{$itemBank->id}}">{{$itemBank->name_bank}} - {{$itemBank->stk}} -
                                    {{$itemBank->ten_chusohuu}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tổng Thu:</label>
                            <input type="text" name="tong_thu" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Xác Nhận Thanh Toán:</label>

                                <div class="form-check" >
                                    <label class="form-check-label">
                                        <input  type="checkbox" name="status_bank" class="form-check-input" value="1">
                                        Đã Thanh Toán
                                    </label>
                                </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-4 ">
                        
                        <div class="page-separator">
                            <div class="page-separator__text">Tổng Chi</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tổng Chi:</label>
                            <input type="text" name="tong_chi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Xác Nhận Thanh Toán Chi:</label>

                                <div class="form-check" >
                                    <label class="form-check-label">
                                        <input  type="checkbox" name="status_chi" class="form-check-input" value="1">
                                        Đã Thanh Toán
                                    </label>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ">
                       
                        <div class="form-group">
                            <label class="form-label">Tổng Số Tiền Kiếm Được:</label>
                            <input type="number" name="price_nhanduoc" class="form-control">
                        </div>
                    </div> -->

                </div>

                <div class="row mb-32pt">
                    
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-group">
                                <label class="form-label">備考</label>
                                <textarea type="text" name="description" class="form-control" rows='10'>
                                </textarea>
                            </div>
                            
                        </div>
                    </div>
                </div>


                

                <button type="button"  @click="onSubmit()" style="float:right; margin-bottom : 30px" class="btn btn-primary btn-submit">保存</button>
            </form>

        </div>
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
        $('#listDate').datepick({ 
    multiSelect: 999, 
    dateFormat: 'yyyy-mm-dd',
    monthsToShow: 1});

        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
            jQuery(this).toggle();
        });
        $(window).keydown(function(event){
            if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3])) {
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
</style>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#list-data',
    data: {
        listBankAccount: [],
        listAcountSale: [],
        listAcountCustomer: [],
        message: '',
        loadingTable: 0,
        loadingTableSale: 0,
        loadingTableCustomer: 0,
        count: 0,
        countSales: 0,
        page: 1,
        pageSales: 1,
        pageCustomer: 1,
        list: [],
        listPage: [],
        listSales: [],
        listCustomer: [],
        listPageSales: [],
        listPageCustomer: [],
        addModal: 1,
        nameAddData: '',
        guardAddData: '',
        groupAddData: '',
        instan: 25,
        long: '',
        lat: '',
        ga_gannhat: '',
        address_pd: '',
        kinh_vido: '',
        conditionName: '',
        conditionNameSale: '',
        conditionNameCustomer : '',
        jplt: '',
        male: '',
        groups: []
    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            const that = this;
            // if (this.address_pd != '') {
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
                
            // }
            setTimeout(function(){ $('.form-data').submit(); }, 1000);
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
                url: "{{route('admin.getCtvJobs')}}?page=" + this.page  + conditionSearch ,
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
            if (this.conditionNameCustomer != '') {
                conditionSearch += '&name=' + this.conditionNameCustomer;
            }
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCusJobs')}}?page=" + this.page  + conditionSearch ,
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
                    if (that.pageCustomer - 2 > 0) {
                        pageArr.push(that.pageCustomer - 2);
                    }
                    if (that.pageCustomer - 1 > 0) {
                        pageArr.push(that.pageCustomer - 1);
                    }
                    pageArr.push(that.pageCustomer);
                    if (that.pageCustomer + 1 <= that.count) {
                        pageArr.push(that.pageCustomer + 1);
                    }
                    if (that.pageCustomer + 2 <= that.countCustomer) {
                        pageArr.push(that.pageCustomer + 2);
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
                url: "/admin/collaborators/list-collaborators-address-condition?long=" + this.long + "&lat=" + this.lat + conditionSearch,
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
        onOpenLoction() {
            window.open("http://maps.google.com/maps?q="+this.ga_gannhat, '_blank');
        },
        onOpenLoctionAddress() {
            window.open("http://maps.google.com/maps?q="+this.address_pd, '_blank');
        },
        addListRecord(i) {
            i.dateList.push({
                id: 'new',
                type: 'add',
                ngay_phien_dich: '',
                gio_phien_dich: '',
                note: '',
                phi_phien_dich: '',
                phi_giao_thong: '',
                file_bao_cao: '',
                file_hoa_don: ''
            });
        },
        removeListRecord(i) {
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
            this.listBankAccount.push({
                id: 'new',
                type: 'add',
                collaborators_id: i.id,
                price_total: '',
                bank_id: '',
                listBank: i.bank,
                ngay_chuyen_khoan: '',
                phi_chuyen_khoan: '',
                dateList: [],
                info: i
            });
        },
        removeRecord(i) {
            i.type = 'delete';
        },
        removeRecordSales(i) {
            i.type = 'delete';
        },
        removeRecordCustomer(i) {
            i.type = 'delete';
        },
        onPrePageSales() {
            if (this.pageSales > 1) {
                this.pageSales = this.pageSales - 1;
            }
            this.onGetSales();
        },
        onNextPageSales() {
            if (this.pageSales < this.countSales) {
                this.pageSales = this.pageSales + 1;
            }
            this.onGetSales();
        },
        onPageChangeSales(_p) {
            this.pageSales = _p;
            this.onGetSales();
        },

        onPrePageCustomer() {
            if (this.pageCustomer > 1) {
                this.pageCustomer = this.pageCustomer - 1;
            }
            this.onGetCustomer();
        },
        onNextPageCustomer() {
            if (this.pageCustomer < this.countCustomer) {
                this.pageCustomer = this.pageCustomer + 1;
            }
            this.onGetCustomer();
        },
        onPageChangeCustomer(_p) {
            this.pageCustomer = _p;
            this.onGetCustomer();
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
                    url: "/admin/collaborators/delete/" + _i.id,
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
            $.ajax({
                type: 'GET',
                url: "{{route('admin.getCollaborators')}}?page=" + this.page + "&name=" + this
                    .conditionName,
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
        
    },
});
</script>

@stop