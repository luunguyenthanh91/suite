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
                    <h1 class="h2 mb-0">通訳者管理 新規</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="/admin/collaborators">通訳者管理</a></li>
                        <li class="breadcrumb-item active">新規</li>
                    </ol>

                </div>

            </div>

        </div>

        <div class="container page__container page-section">
            <form action="" method="POST" class="p-0 mx-auto form-data">
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
                            <label class="form-label">Image Cộng Tác Viên</label>
                            
                            <li id="images" >
                                <input class="input_image" type="hidden" name="image_ctv" id="chooseImage_inputimage_ctv"
                                    value="">
                                <div id="chooseImage_divimage_ctv" style="display: none;">
                                    <img src=""
                                        id="chooseImage_imgimage_ctv"
                                        style="max-width: 150px; max-height:150px; border:dashed thin;"></img>
                                </div>
                                <div id="chooseImage_noImage_divimage_ctv"
                                    style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                    No image
                                </div>
                                <br />
                                <a href="javascript:chooseImage('image_ctv');" ><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                <a href="javascript:clearImage('image_ctv');" ><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                
                            </li>
                            
                        </div> -->

                        <div class="form-group" style="display:none;">
                            <label class="form-label">ステータス</label>
                            
                            <select class="form-control" name="status"  >
                                <option value="0">未承認</option>
                                <option value="1">承認済</option>
                                <option value="2">停止中</option>
                            </select>
                        </div>
                        
                        
                        <!-- <div class="form-group">
                            <label class="form-label">Mật Khẩu Đăng Nhập:</label>
                            <input type="password" name="password" class="form-control" >
                        </div> -->
                        
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <div class="form-group">
                                <label class="form-label">名前</label>
                                <input type="text" name="name" class="form-control" style="text-transform: uppercase;" required >
                            </div>
                            <div class="form-group">
                                <label class="form-label">ふりがな</label>
                                <input type="text" name="furigana" class="form-control" required >
                            </div>
                            <div class="form-group">
                                <label class="form-label">性別</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiomale1" name="male" type="radio" class="custom-control-input"
                                            value="1">
                                        <label for="radiomale1" class="custom-control-label">男性</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiomale2" name="male" type="radio" class="custom-control-input"
                                            value="2">
                                        <label for="radiomale2" class="custom-control-label">女性</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">住所</label>
                                <div class="search-form">
                                    <input type="text" name="address" class="form-control" required v-model="address" >
                                    <a target="_blank" :href="'http://maps.google.com/maps?q='+address" style="background-color: #5567ff;" class="btn btn-primary " >Get Location</a>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="form-label">Location Map</label>
                                <input type="text" name="location"  v-model="location" class="form-control" >
                            </div>
                            <div class="form-group" >
                                <label class="form-label">Kinh Độ</label>
                                <input type="text" name="longitude"  v-model="long" class="form-control" readonly>
                            </div>
                            <div class="form-group" >
                                <label class="form-label">Vĩ Độ</label>
                                <input type="text" name="latitude" class="form-control"  v-model="lat" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">電話番号</label>
                                <input type="text" name="phone" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label class="form-label">メール</label>
                                <input type="text" name="email" class="form-control" required >
                            </div>
                            
                            <!-- <div class="form-group">
                                <label class="form-label">Quốc Tịch:</label>
                                <div class="search-form" >
                                    <select class="form-control" name="quoctich" >
                                        <option value=""></option>
                                        <option value="1">Việt Nam</option>
                                        <option value="2">Nhật Bản</option>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label class="form-label">Bằng Lái:</label>
                                <div class="custom-controls-stacked">
                                    <div class="custom-control custom-radio">
                                        <input id="radiobanglai1" name="banglai" type="radio" class="custom-control-input" value="1">
                                        <label for="radiobanglai1" class="custom-control-label">Không</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="radiobanglai2" name="banglai" type="radio" class="custom-control-input" value="2">
                                        <label for="radiobanglai2" class="custom-control-label">Có</label>
                                    </div>
                                </div>
                            </div> -->
                            
                        </div>
                    </div>
                </div>
                <div style="display: none;" class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">Thông Tin Liên Lạc</div>
                        </div>
                        
                       
                        <!-- <div class="form-group">
                            <label class="form-label">Line Barcode:</label>
                            
                            <li id="images" >
                                <input class="input_image" type="hidden" name="line_barcode" id="chooseImage_inputBarcode"
                                    value="">
                                <div id="chooseImage_divBarcode" style="display: none;">
                                    <img src=""
                                        id="chooseImage_imgBarcode"
                                        style="max-width: 150px; max-height:150px; border:dashed thin;"></img>
                                </div>
                                <div id="chooseImage_noImage_divBarcode"
                                    style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                    No image
                                </div>
                                <br />
                                <a href="javascript:chooseImage('Barcode');" ><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                <a href="javascript:clearImage('Barcode');" ><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                
                            </li>
                            
                        </div> -->

                       
                        
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">


                            <!-- <div class="form-group">
                                <label class="form-label">Mã Bưu Điện:</label>
                                <div class="search-form">
                                    <input type="text" name="zipcode" class="form-control" required v-model="zipcode" >
                                    
                                </div>
                            </div> -->
                            
                           

                            <!-- <div class="form-group">
                                <label class="form-label">Tên Ga Gần Nhất:</label>

                                <div class="search-form" >
                                    <input type="text" name="ga_gannhat" v-model="ga_gannhat" class="form-control"  >
                                    
                                </div>

                            </div> -->

                            <!-- <div class="form-group">
                                <label class="form-label">Những Nơi Có Thể Làm Việc:</label>
                                @foreach($district as $item_district)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="list_di_dich[]" class="form-check-input" value="{{$item_district->id}}">
                                        {{$item_district->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div> -->
                            
                        </div>
                    </div>
                </div>
                <div class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">語学力</div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
                            <!-- <div class="form-group">
                                <label class="form-label">Biết Các Ngôn Ngữ:</label>
                                @foreach($language as $item_lang)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="ngon_ngu[]"  class="form-check-input" value="{{$item_lang->id}}">
                                        {{$item_lang->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div> -->
                            
                            <!-- <div class="form-group">
                                <label class="form-label">Thời Gian Sống Ở Nhật:</label>
                                <input type="text" name="songonhat_year" class="form-control">
                            </div> -->
                            
                            <div class="form-group">
                                <label class="form-label">日本語レベル</label>
                                <select class="form-control" name="lever_nihongo">
                                    <option value=""></option>
                                    <option value="1">N1</option>
                                    <option value="2">N2</option>
                                    <option value="3">N3</option>
                                    <option value="4">N4</option>
                                    <option value="5">N5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">日本語能力試験（JLPT）の資格</label>
                                <select class="form-control" name="jplt">
                                    <option value=""></option>
                                    <option value="1">N1</option>
                                    <option value="2">N2</option>
                                    <option value="3">N3</option>
                                    <option value="4">N4</option>
                                    <option value="5">N5</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label class="form-label">File 1:</label>
                                <li id="images" >   
                                    <input class="input_image" name="file1" type="text" id="chooseImage_inputfile1">
                                    <br/>
                                    
                                    <a onclick="chooseFile(this)"  rel="file1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                    | 
                                    <a onclick="clearFile(this)" rel="file1"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                </li>
                            </div>
                            <div class="form-group">
                                <label class="form-label">File 2:</label>
                                <li id="images"  >   
                                    <input class="input_image" name="file2" type="text" id="chooseImage_inputfile2">
                                    <br/>
                                    
                                    <a onclick="chooseFile(this)"  rel="file2"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                    | 
                                    <a onclick="clearFile(this)" rel="file2"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                </li>
                            </div> -->
                            

                            
                            <!-- <div class="form-group">
                                <label class="form-label">Trình Độ Tiếng Nhật:</label>
                                <input type="text" name="trinhdo_tiengnhat" class="form-control">
                            </div> -->
                            
                            

                            
                        </div>
                    </div>
                </div>


                <div class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">銀行振込の口座情報</div>
                        </div>
                        <div class="row" role="tablist" v-if="listBankAccount.length < 1">
                            <div class="col-auto">
                                <a @click="addBankAccount()" class="btn btn-outline-secondary">追加</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 align-items-center">
                        <div class="flex mb-5 style-group-add" v-for="(item, index) in listBankAccount">
                            <div class="form-group">
                                <label class="form-label" for="tenNganHang">金融機関名</label>
                                <input type="text" v-bind:name="'banklist['+index+'][ten_bank]'" class="form-control"
                                    v-model="item.ten_bank" id="tenNganHang" required >
                            </div>
                            <div class="form-group">
                                <label class="form-label" >金融機関コード</label>
                                <input type="text" v-bind:name="'banklist['+index+'][ms_nganhang]'" class="form-control"
                                    v-model="item.ms_nganhang"  required >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chiNhanhNganHang">支店名</label>
                                <input type="text" v-bind:name="'banklist['+index+'][chinhanh]'" class="form-control"
                                    v-model="item.chinhanh" id="chiNhanhNganHang"  >
                            </div>
                            <div class="form-group">
                                <label class="form-label" >支店コード</label>
                                <input type="text" v-bind:name="'banklist['+index+'][ms_chinhanh]'" class="form-control"
                                    v-model="item.ms_chinhanh"   >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="typeAccount">貯金の種類</label>
                                <input type="text" v-bind:name="'banklist['+index+'][loai_taikhoan]'"
                                    class="form-control" v-model="item.loai_taikhoan" id="typeAccount"  >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="soTaiKhoan">口座番号</label>
                                <input type="text" v-bind:name="'banklist['+index+'][stk]'" class="form-control"
                                    v-model="item.stk" id="soTaiKhoan" >
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="chuTaiKhoan">口座名義</label>
                                <input type="text" v-bind:name="'banklist['+index+'][ten_chutaikhoan]'"
                                    v-model="item.ten_chutaikhoan" class="form-control" id="chuTaiKhoan" required >
                                <input type="hidden" v-bind:name="'banklist['+index+'][id]'" v-model="item.id">
                            </div>
                            <!-- <button @click="removeBankAccount(item)" type="button" class="btn btn-danger">削除</button> -->
                        </div>
                    </div>
                </div>
                <div class="row mb-32pt">
                    <div class="col-lg-6">
                        <div class="page-separator">
                            <div class="page-separator__text">備考</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="flex mb-5" >
                                
                            <div class="form-group">

                                <label class="form-label" >備考</label>
                                <div class="search-form" >
                                    <textarea type="text" name="note" class="form-control"  rows="10" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button"  @click="onSubmit()" style="float:right;" class="btn btn-primary mb-5 btn-submit">保存</button>

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
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYGxyRPEonFu5qi3zw_h2C1IyWvAULAL0" type="text/javascript"></script> -->

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
        long: '',
        lat: '',
        kinh_vido: '',
        address: '',
        zipcode: '',
        address_pd: '',
        location : '',
        ga_gannhat: ''
    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        onSubmit(){
            $('.btn-submit').prop('disabled', true);
            if (this.location != '') {
                this.location = this.location.trim();
                this.location = this.location.replace("(", "");
                this.location = this.location.replace(")", "");
                var res = this.location.split(",");
                this.long = res[0];
                this.lat = res[1];
                setTimeout(function(){ $('.form-data').submit(); }, 1000);
            } else {
                setTimeout(function(){ $('.form-data').submit(); }, 1000);
            }

            // $('.form-data').submit();
            // $('.btn-submit').prop('disabled', true);
            // if (this.address != '') {
            //     const that = this;
            //     geocoder = new google.maps.Geocoder();
            //     var address = this.address;
            //     geocoder.geocode( { 'address': address}, function(results, status) {
            //         if (status == google.maps.GeocoderStatus.OK) {
            //             that.long = results[0].geometry.location.lat();
            //             that.lat = results[0].geometry.location.lng();
            //             setTimeout(function(){ $('.form-data').submit(); }, 1000);
            //         } 
            //         else {
            //             Swal.fire({
            //                 title: "Có lỗi dữ liệu nhập vào!",
            //                 type: "warning",
            //             });
            //         }
            //     });

                // $.ajax({
                //     type: 'GET',
                //     url: "http://api.positionstack.com/v1/forward?access_key=d4eb3bcee90d3d0a824834770881ce70&query=" + this.address,
                //     success: function(data) {
                //         that.long = data.data[0].latitude;
                //         that.lat = data.data[0].longitude;
                //         setTimeout(function(){ $('.form-data').submit(); }, 1000);
                //     },
                //     error: function(xhr, textStatus, error) {
                //         Swal.fire({
                //             title: "Có lỗi dữ liệu nhập vào!",
                //             type: "warning",

                //         });
                //     }
                // });
            // } else {
            //     setTimeout(function(){ $('.form-data').submit(); }, 1000);
            // }
            

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
        addBankAccount() {
            this.listBankAccount.push({
                id: 'new',
                ten_bank: '',
                stk: '',
                chinhanh: '',
                ten_chutaikhoan: '',
                ms_nganhang: '',
                ms_chinhanh: '',
                loai_taikhoan: ''
            });
        },
        removeBankAccount(i) {
            this.listBankAccount.splice(this.listBankAccount.indexOf(i), 1);
        }
    },
});
</script>

@stop