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
                    <h1 class="h2 mb-0">顧客情報</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="/admin/ctvjobs">顧客</a></li>
                        <li class="breadcrumb-item active">詳細</li>
                    </ol>

                </div>
            </div>
            <div class="row" role="tablist" v-if="edit_form == 0">
                <div class="col-auto">
                    <a @click="openEdit()" class="btn btn-primary">編集</a>
                </div>
            </div>
            <div class="row ml-2" role="tablist">
                <div class="col-auto">
                    <a @click="deleteRecore('{{$id}}')"  class="btn btn-danger">削除</a>
                </div>
            </div>

        </div>

        <div class="container page__container page-section">
            <form action="" method="POST" class="p-0 mx-auto">
                @csrf
                <div class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">基本情報</div>
                        </div>
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
                        </div>
                        <!-- <div class="form-group">
                            <label class="form-label">Image Cộng Tác Viên:</label>
                            
                            <li id="images" >
                                <input class="input_image" type="hidden" name="image_ctv" id="chooseImage_inputimage_ctv"
                                    value="{{$data->image_ctv != '' ? $data->image_ctv : '' }}">
                                <div id="chooseImage_divimage_ctv" style="display: none;">
                                    <img src="{{$data->image_ctv != '' ? $data->image_ctv : '' }}"
                                        id="chooseImage_imgimage_ctv"
                                        style="max-width: 150px; max-height:150px; border:dashed thin;"></img>
                                </div>
                                <div id="chooseImage_noImage_divimage_ctv"
                                    style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                    No image
                                </div>
                                <br />
                                <a href="javascript:chooseImage('image_ctv');" v-if="edit_form == 1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                <a href="javascript:clearImage('image_ctv');" v-if="edit_form == 1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                @if(@$data->image_ctv)
                                    <a href="{{@$data->image_ctv}}"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">file_download</span></a>
                                @endif
                            </li>
                            
                        </div> -->
                        <div class="form-group" >
                            <label class="form-label">ステータス</label>
                            <div class="search-form" >
                                <select class="form-control" name="status" v-if="edit_form == 0" disabled>
                                    <option value="" ></option>
                                    <option value="1" @if(@$data->status == 1) selected @endif>未営業</option>
                                    <option value="2" @if(@$data->status == 2) selected @endif>電話で断りました</option>
                                    <option value="3" @if(@$data->status == 3) selected @endif>電話で結果待ち</option>
                                    <option value="4" @if(@$data->status == 4) selected @endif>サービス利用中</option>
                                    <option value="5" @if(@$data->status == 5) selected @endif>会員</option>
                                    <option value="6" @if(@$data->status == 6) selected @endif>中止</option>
                                </select>
                                <select class="form-control" name="status" v-if="edit_form == 1">
                                    <option value="" ></option>
                                    <option value="1" @if(@$data->status == 1) selected @endif>未営業</option>
                                    <option value="2" @if(@$data->status == 2) selected @endif>電話で断りました</option>
                                    <option value="3" @if(@$data->status == 3) selected @endif>電話で結果待ち</option>
                                    <option value="4" @if(@$data->status == 4) selected @endif>サービス利用中</option>
                                    <option value="5" @if(@$data->status == 5) selected @endif>会員</option>
                                    <option value="6" @if(@$data->status == 6) selected @endif>中止</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="form-label">登録日</label>
                            <div class="search-form" >
                                <input type="date" name="created_at" class="form-control" v-if="edit_form == 1"  value="{{@$data->created_at}}">
                                <input type="date" name="created_at" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->created_at}}">
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="form-label">承認日</label>
                            <div class="search-form" >
                                <input type="date" name="date_update" class="form-control" v-if="edit_form == 1"  value="{{@$data->date_update}}">
                                <input type="date" name="date_update" class="form-control" v-if="edit_form == 0" readonly value="{{@$data->date_update}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">

                            

                        <div class="form-group">
                                <label class="form-label">名前</label>
                                <div class="search-form" >
                                    <input type="text" name="name" v-if="edit_form == 1" class="form-control" style="text-transform: uppercase;"    value="{{@$data->name}}">
                                    <input type="text" name="name" v-if="edit_form == 0" readonly class="form-control" style="text-transform: uppercase;"    value="{{@$data->name}}">
                                </div>
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">ふりがな</label>
                                <div class="search-form" >
                                    <input type="text" name="furigana" v-if="edit_form == 1"  class="form-control"   value="{{@$data->furigana}}">
                                    <input type="text" name="furigana" v-if="edit_form == 0" readonly class="form-control"   value="{{@$data->furigana}}">
                                </div>
                            </div>
                            <div class="form-group" style="display:none;">
                                <label class="form-label">性別</label>
                                <div class="custom-controls-stacked" v-if="edit_form == 1">
                                    <div class="custom-control custom-radio">
                                        <input id="radiomale1" name="male" type="radio" class="custom-control-input"
                                            @if(1==@$data->male) checked @endif value="1">
                                        <label for="radiomale1" class="custom-control-label">男性</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiomale2" name="male" type="radio" class="custom-control-input"
                                            @if(2==@$data->male) checked @endif value="2">
                                        <label for="radiomale2" class="custom-control-label">女性</label>
                                    </div>
                                </div>
                                <p v-if="edit_form == 0" class="page-separator__text">
                                @if (2 == @$data->male)
                                女性
                                @else
                                男性
                                @endif
                                </p>
                            </div>
                            <!-- <div class="form-group">
                                <label class="form-label">Quốc Tịch:</label>
                                <div class="search-form" >
                                    <select class="form-control" name="quoctich" v-if="edit_form == 0" disabled>
                                        <option value=""></option>
                                        <option value="1" @if(@$data->quoctich == 1) selected @endif>Việt Nam</option>
                                        <option value="2" @if(@$data->quoctich == 2) selected @endif>Nhật Bản</option>
                                    </select>
                                    <select class="form-control" name="quoctich" v-if="edit_form == 1" >
                                        <option value=""></option>
                                        <option value="1" @if(@$data->quoctich == 1) selected @endif>Việt Nam</option>
                                        <option value="2" @if(@$data->quoctich == 2) selected @endif>Nhật Bản</option>
                                    </select>
                                </div>
                            </div> -->

                            <!-- <div class="form-group">
                                <label class="form-label">Bằng Lái:</label>
                                <div class="custom-controls-stacked" v-if="edit_form == 1">
                                    <div class="custom-control custom-radio">
                                        <input id="radiobanglai1" name="banglai" type="radio" class="custom-control-input"
                                            @if(1==@$data->banglai) checked @endif value="1">
                                        <label for="radiobanglai1" class="custom-control-label">Không</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiobanglai2" name="banglai" type="radio" class="custom-control-input"
                                            @if(2==@$data->banglai) checked @endif value="2">
                                        <label for="radiobanglai2" class="custom-control-label">Có</label>
                                    </div>
                                </div>
                                <p v-if="edit_form == 0" class="page-separator__text">
                                @if (2 == @$data->banglai)
                                    Có
                                @else
                                    Không
                                @endif
                                </p>
                            </div> -->

                            <div class="form-group">
                                <label class="form-label">住所</label>
                                <div class="search-form" >
                                    <input type="text" name="address" v-if="edit_form == 1" class="form-control"   v-model="address" >
                                    <input type="text" name="address" v-if="edit_form == 0" readonly class="form-control"   v-model="address" >
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="form-label">電話番号</label>
                                <div class="search-form" >
                                    <input type="text"  name="phone" v-if="edit_form == 1" class="form-control"  value="{{@$data->phone}}">
                                    <input type="text"  name="phone" v-if="edit_form == 0" readonly class="form-control"  value="{{@$data->phone}}">
                                    <a href="tel:{{@$data->phone}}" v-if="edit_form == 0" ><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">phone</span></a>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="form-label">HP</label>
                                <div class="search-form" >
                                    <input type="text"  name="website" v-if="edit_form == 1" class="form-control"  value="{{@$data->website}}">
                                    <input type="text"  name="website" v-if="edit_form == 0" readonly class="form-control"  value="{{@$data->website}}">
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="form-label">顧客コード</label>
                                <div class="search-form" >
                                    <input type="text" name="email" class="form-control" v-if="edit_form == 1"  value="{{@$data->email}}">
                                    <input type="text" name="email" class="form-control" v-if="edit_form == 0" readonly  value="{{@$data->email}}">
                                    <a href="mailto:{{@$data->email}}" v-if="edit_form == 0"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">email</span></a>
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="form-label" >備考</label>
                                <div class="search-form" >
                                    <textarea type="text" name="note" class="form-control"  rows="10" v-if="edit_form == 1">{{@$data->note}}</textarea>
                                    <textarea type="text" name="note" class="form-control"  rows="10" v-if="edit_form == 0" readonly>{{@$data->note}}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mb-32pt" style="display:none;">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">語学力</div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            
                            <div class="form-group">
                                <label class="form-label">日本語レベル</label>
                                <div class="search-form" >
                                    <select class="form-control" name="lever_nihongo" v-if="edit_form == 1" >
                                        <option value=""></option>
                                        <option value="1" @if(@$data->lever_nihongo == 1) selected @endif>N1</option>
                                        <option value="2" @if(@$data->lever_nihongo == 2) selected @endif>N2</option>
                                        <option value="3" @if(@$data->lever_nihongo == 3) selected @endif>N3</option>
                                        <option value="4" @if(@$data->lever_nihongo == 4) selected @endif>N4</option>
                                        <option value="5" @if(@$data->lever_nihongo == 5) selected @endif>N5</option>
                                    </select>
                                    <select class="form-control" name="lever_nihongo"  v-if="edit_form == 0" disabled>
                                        <option value=""></option>
                                        <option value="1" @if(@$data->lever_nihongo == 1) selected @endif>N1</option>
                                        <option value="2" @if(@$data->lever_nihongo == 2) selected @endif>N2</option>
                                        <option value="3" @if(@$data->lever_nihongo == 3) selected @endif>N3</option>
                                        <option value="4" @if(@$data->lever_nihongo == 4) selected @endif>N4</option>
                                        <option value="5" @if(@$data->lever_nihongo == 5) selected @endif>N5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">日本語能力試験（JLPT）の資格</label>
                                <div class="search-form" >
                                    <select class="form-control" name="jplt" v-if="edit_form == 0" disabled>
                                        <option value=""></option>
                                        <option value="1" @if(@$data->jplt == 1) selected @endif>N1</option>
                                        <option value="2" @if(@$data->jplt == 2) selected @endif>N2</option>
                                        <option value="3" @if(@$data->jplt == 3) selected @endif>N3</option>
                                        <option value="4" @if(@$data->jplt == 4) selected @endif>N4</option>
                                        <option value="5" @if(@$data->jplt == 5) selected @endif>N5</option>
                                    </select>
                                    <select class="form-control" name="jplt" v-if="edit_form == 1" >
                                        <option value=""></option>
                                        <option value="1" @if(@$data->jplt == 1) selected @endif>N1</option>
                                        <option value="2" @if(@$data->jplt == 2) selected @endif>N2</option>
                                        <option value="3" @if(@$data->jplt == 3) selected @endif>N3</option>
                                        <option value="4" @if(@$data->jplt == 4) selected @endif>N4</option>
                                        <option value="5" @if(@$data->jplt == 5) selected @endif>N5</option>
                                    </select>
                                </div>
                            </div>
                            

                            

                        </div>
                    </div>
                </div>
                <div class="row mb-32pt" style="display:none;">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">銀行振込の口座情報</div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-items-center">
                        <div class="flex mb-5 style-group-add">
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">金融機関名</label>
                                <div class="search-form" >
                                    <input type="text" name="ten_bank" value="{{@$data->ten_bank}}"  class="form-control" id="tenNganHang"  v-if="edit_form == 1" >
                                    <input type="text" name="ten_bank" value="{{@$data->ten_bank}}" class="form-control" id="tenNganHang"  v-if="edit_form == 0" readonly >
                                </div>      
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">金融機関コード</label>
                                <div class="search-form" >
                                    <input type="text" name="ms_nganhang" value="{{@$data->ms_nganhang}}" class="form-control"  v-if="edit_form == 1" >
                                    <input type="text" name="ms_nganhang" value="{{@$data->ms_nganhang}}" class="form-control"  v-if="edit_form == 0" readonly >
                                </div>      
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chiNhanhNganHang">支店名</label>
                                <div class="search-form" >
                                    <input type="text" name="chinhanh" value="{{@$data->chinhanh}}" class="form-control" id="chiNhanhNganHang"  v-if="edit_form == 1" >
                                    <input type="text" name="chinhanh" value="{{@$data->chinhanh}}" class="form-control" id="chiNhanhNganHang"  v-if="edit_form == 0" readonly >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chiNhanhNganHang">支店コード</label>
                                <div class="search-form" >
                                    <input type="text" name="ms_chinhanh" value="{{@$data->ms_chinhanh}}"  class="form-control"  v-if="edit_form == 1" >
                                    <input type="text" name="ms_chinhanh" value="{{@$data->ms_chinhanh}}" class="form-control"  v-if="edit_form == 0" readonly >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="typeAccount">貯金の種類</label>
                                <div class="search-form" >
                                    <input type="text" name="loai_taikhoan" value="{{@$data->loai_taikhoan}}" class="form-control" id="typeAccount" v-if="edit_form == 1"    >
                                    <input type="text" name="loai_taikhoan" value="{{@$data->loai_taikhoan}}" class="form-control" id="typeAccount" v-if="edit_form == 0" readonly   >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="soTaiKhoan">口座番号</label>
                                <div class="search-form" >
                                    <input type="text" name="stk"  value="{{@$data->stk}}" class="form-control" id="soTaiKhoan"   v-if="edit_form == 1"  >
                                    <input type="text" name="stk"  value="{{@$data->stk}}" class="form-control" id="soTaiKhoan"  v-if="edit_form == 0" readonly >
                                </div>  
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chuTaiKhoan">口座名義</label>
                                <div class="search-form" >
                                    <input type="text" name="ten_chutaikhoan" value="{{@$data->ten_chutaikhoan}}" class="form-control" id="chuTaiKhoan"   v-if="edit_form == 1">
                                    <input type="text" name="ten_chutaikhoan" value="{{@$data->ten_chutaikhoan}}" class="form-control" id="chuTaiKhoan"   v-if="edit_form == 0" readonly>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                <button type="button" @click="cancleEdit()" style="float:right;" class="btn btn-danger mb-5 " v-if="edit_form == 1">キャンセル</button>
                <button type="submit" style="float:right;" class="btn btn-primary mb-5 mr-2" v-if="edit_form == 1">保存</button>
                

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

<script type="text/javascript" src="{{ asset('lib_upload/ckeditor/ckeditor.js') }}"></script> 
<script type="text/javascript" src="{{ asset('lib_upload/ckfinder/ckfinder.js') }}"></script>  
<link href="{{ asset('lib_upload/jquery-ui/css/ui-lightness/jquery-ui.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('lib_upload/jquery-ui/js/jquery-ui.js') }}"></script>
<script src="{{ asset('lib_upload/jquery.slug.js') }}"></script>

<script type="text/javascript">
    //<![CDATA[

    jQuery(document).ready(function (){
        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        jQuery(".input_image[value!='']").parent().find('div').each( function (index, element){
            jQuery(this).toggle();
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
        long: '{{@$data->longitude}}',
        lat: '{{@$data->latitude}}',
        address: '{{@$data->address}}',
        zipcode: '{{@$data->zipcode}}',
        edit_form: 0,
        kinh_vido: '',
        ga_gannhat: '{{@$data->ga_gannhat}}'
    },
    delimiters: ["((", "))"],
    mounted() {
        
    },
    methods: {
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
                    url: "/admin/cusjobs/delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Đã xóa!"
                        });
                        location.href = "/admin/cusjobs";
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
        cancleEdit() {
            this.edit_form = 0;
        },
        openEdit() {
            this.edit_form = 1;
        },
        onOpenLoctionZipcode() {
            window.open("http://maps.google.com/maps?q="+this.zipcode, '_blank');
        },
        onOpenLoctionAddress() {
            window.open("http://maps.google.com/maps?q="+this.address, '_blank');
        },
        onOpenLoction() {
            window.open("http://maps.google.com/maps?q="+this.ga_gannhat, '_blank');
        },
        onPaste (evt) {
            this.kinh_vido = evt.clipboardData.getData('text');
            this.onCutLongLat();
        },
        onCutLongLat() {
            this.kinh_vido = this.kinh_vido.replace("(", "");
            this.kinh_vido = this.kinh_vido.replace(")", "");
            let res = this.kinh_vido.split(",");
            if (res.length < 2) {
                Swal.fire({
                        title: "Có lỗi dữ liệu nhập vào!",
                        type: "warning",
                    });
            } else {
                this.long = res[0];
                this.lat = res[1];
                this.kinh_vido = '';
            }
        },
        addBankAccount() {
            this.listBankAccount.push({
                id: 'new',
                ten_bank: '',
                stk: '',
                chinhanh: '',
                ten_chutaikhoan: '',
                loai_taikhoan: '',
                ms_nganhang: '',
                ms_chinhanh: '',
                type: 'create'
            });
        },
        removeBankAccount(i) {
            i.type = 'delete';
        }
    },
});
</script>

@stop