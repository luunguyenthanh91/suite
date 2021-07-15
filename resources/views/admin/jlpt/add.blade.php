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
                    <h1 class="h2 mb-0">Thêm Bài Học</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="/admin/jlpt">問題マスター</a></li>
                        <li class="breadcrumb-item active">Thêm</li>
                    </ol>

                </div>

            </div>

        </div>

        <div class="container page__container page-section">
            <form action="" method="POST" class="p-0 mx-auto form-data">
                @csrf
                <div class="row mb-32pt">
                    
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="flex" style="max-width: 100%">
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
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <div class="search-form" >
                                    <input type="text" autocomplete="off" name="name" class="form-control" required>
                                </div>
                            </div>
                            

                            <div class="form-group">
                                <label class="form-label">レベル</label>
                                <select class="form-control" name="type_n">
                                    <option value=""></option>
                                    <option value="1">N1</option>
                                    <option value="2">N2</option>
                                    <option value="3">N3</option>
                                    <option value="4">N4</option>
                                    <option value="5">N5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">種類</label>
                                <select class="form-control" name="type_unit_n">
                                    <option value=""></option>
                                    <option value="1">言語知識（文字・語彙・文法）</option>
                                    <option value="2">言語知識（文字・語彙）</option>
                                    <option value="3">言語知識（文法)</option>
                                    <option value="4">読解</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">問題</label>
                                <select class="form-control" name="unit">
                                    <option value=""></option>
                                    <option value="1">問題1</option>
                                    <option value="2">問題2</option>
                                    <option value="3">問題3</option>
                                    <option value="4">問題4</option>
                                    <option value="5">問題5</option>
                                    <option value="6">問題6</option>
                                    <option value="7">問題7</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">タイプ</label>
                                <select class="form-control" name="type_bai_hoc">
                                    <option value="1">シングル</option>
                                    <option value="2">複数</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label class="form-label">問題</label>
                                <textarea type="text" name="debai" class="form-control textarea ckeditor" rows="4" ></textarea>
                            </div> -->
                        </div>
                    </div>
                </div>


                <div class="row mb-32pt" style="display:none">
                    <div class="col-lg-12">
                        <div class="page-separator">
                            <div class="page-separator__text">Câu Hỏi</div>
                        </div>
                        <div class="row" role="tablist">
                            <div class="col-auto">
                                <a @click="addBankAccount()" class="btn btn-outline-secondary">追加</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 align-items-center">
                        <div class="flex mb-5 style-group-add" v-for="(item, index) in listBankAccount" :class="item.type != 'delete' ? '' : 'hidden' ">
                            
                            <div class="form-group">
                                <label class="form-label">Câu hỏi</label>
                                <textarea type="text" v-bind:name="'banklist['+index+'][cauhoi]'"
                                                                            class="form-control" v-model="item.cauhoi" rows="4" ></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Câu Trả Lời 1</label>
                                <input type="text" v-bind:name="'banklist['+index+'][traloi_1]'" class="form-control"
                                    v-model="item.traloi_1"  >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Câu Trả Lời 2</label>
                                <input type="text" v-bind:name="'banklist['+index+'][traloi_2]'" class="form-control"
                                    v-model="item.traloi_2"  >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Câu Trả Lời 3</label>
                                <input type="text" v-bind:name="'banklist['+index+'][traloi_3]'" class="form-control"
                                    v-model="item.traloi_3"  >
                            </div>
                            <div class="form-group">
                                <label class="form-label">Câu Trả Lời 4</label>
                                <input type="text" v-bind:name="'banklist['+index+'][traloi_4]'" class="form-control"
                                    v-model="item.traloi_4"  >
                            </div>


                            <div class="form-group">
                                <label class="form-label">Đáp án</label>
                                <select class="form-control custom-select"
                                    v-bind:name="'banklist['+index+'][dap_an]'" v-model="item.dap_an">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                
                            </div>
                            <div class="form-group">
                                <label class="form-label">Chú thích</label>
                                <textarea type="text" v-bind:name="'banklist['+index+'][chu_thich]'"
                                                                            class="form-control" v-model="item.chu_thich" rows="4" ></textarea>
                            </div>
                            
                            <button @click="removeBankAccount(item)" type="button" class="btn btn-danger">削除</button>
                        </div>
                    </div>
                </div>

                <button type="submit" style="float:right;" class="btn btn-primary mb-5 btn-submit">保存</button>

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
        long: '',
        lat: '',
        kinh_vido: '',
        address: '',
        zipcode: '',
        address_pd: '',
        ga_gannhat: ''
    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        addBankAccount() {
            this.listBankAccount.push({
                id: 'new',
                type : 'new',
                cauhoi: '',
                traloi_1: '',
                traloi_2: '',
                traloi_3: '',
                traloi_4: '',
                dap_an: 1,
                chu_thich: ''
            });
        },
        removeBankAccount(i) {
            i.type = 'delete';
        }
    },
});
</script>

@stop