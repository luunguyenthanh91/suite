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
                    <h1 class="h2 mb-0">経費詳細</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">ホーム</a></li>
                        <li class="breadcrumb-item"><a href="/admin/chi">経費</a></li>
                        <li class="breadcrumb-item active">詳細</li>
                    </ol>

                </div>
            </div>

        </div>
        <form action="" method="POST" class="p-0 mx-auto">
        @csrf
            <div class="container page__container page-section">
                <div class="row mb-32pt">
                    
                    <div class="col-lg-12 d-flex">
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
                                <label class="form-label" >月:</label>
                                <input type="month" name="date" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">保存</button>
                            
                        </div>
                    </div>
                    <!-- <div class="col-lg-12">
                        <a @click="addRecord()" class="btn btn-outline-secondary">Thêm Ngày</a>

                        <div class="flex mb-5 style-group-add">
                            <div class="form-custom-table">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Ngày Thanh Toán</th>
                                            <th scope="col">Loại</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Giá Tiền</th>
                                            <th scope="col">File</th>
                                            <th scope="col">Note</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in listAdd" v-bind:class='item.type != "delete" ? "" : "hidden" '>
                                        
                                            <td>
                                                <div class="form-group">
                                                    <div class="search-form" >
                                                        <input type="date" v-bind:name="'jobsConnect['+index+'][date]'"
                                                            class="form-control" v-model="item.date">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="search-form" >
                                                        <select class="form-control search" v-bind:name="'jobsConnect['+index+'][typeLog]'"
                                                            class="form-control" v-model="item.typeLog">
                                                            <option value=""></option>
                                                            <option value="1">租税公課</option>
                                                            <option value="2">修繕費</option>
                                                            <option value="3">水道光熱費</option>
                                                            <option value="4">保険料</option>
                                                            <option value="5">消耗品費</option>
                                                            <option value="6">法定福利費</option>
                                                            <option value="7">給料賃金</option>
                                                            <option value="8">地代家賃</option>
                                                            <option value="9">外注工賃</option>
                                                            <option value="10">支払手数料</option>
                                                            <option value="11">旅費交通費</option>
                                                            <option value="12">開業費/創立費/社債発行費など</option>
                                                            <option value="13">通信費</option>
                                                            <option value="14">接待交際費</option>
                                                            <option value="15">その他</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <th scope="row">
                                                <div class="form-group">
                                                    <div class="search-form" >
                                                        <input type="text" v-bind:name="'jobsConnect['+index+'][name]'"
                                                            class="form-control" v-model="item.name">
                                                    </div>
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][id]'"
                                                        class="form-control" v-model="item.id">
                                                    <input type="hidden" v-bind:name="'jobsConnect['+index+'][type]'"
                                                        class="form-control" v-model="item.type">
                                                </div>
                                            </th>
                                            <td>
                                                <div class="form-group">
                                                    <div class="search-form" >
                                                        <input type="number" v-bind:name="'jobsConnect['+index+'][price]'"
                                                            class="form-control" v-model="item.price">
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <div class="form-group">
                                                    <li id="images">   
                                                        <div class="search-form" >
                                                            <input v-bind:name="'jobsConnect['+index+'][file]'"
                                                        class="form-control"  type="text" v-bind:id="'chooseImage_inputfile'+index" v-model="item.file">
                                                        </div>
                                                        <a v-if="item.file != '' " :href="item.file"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">file_download</span></a>
                                                    
                                                        <br/>
                                                        <div >
                                                            <a  onclick="chooseFile(this)"  :rel="'file'+index"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                                            | 
                                                            <a onclick="clearFile(this)" :rel="'file'+index"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                                        </div>
                                                    </li>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="search-form" >
                                                            <textarea v-model="item.note" v-bind:name="'jobsConnect['+index+'][note]'" class="form-control"  ></textarea>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <button @click="removeRecord(item)" type="button" class="btn btn-danger">削除</button>
                                            </td>
                                            
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        
                    </div> -->
                </div>
            </div>
        </form>
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
        listAdd : []
    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        addRecord(){
            this.listAdd.push(
                {
                    'id' : 'new',
                    'name' : '',
                    'price' : 0,
                    'date' : '',
                    'file' : '',
                    'note' : '',
                    'typeLog' : '',
                    'type' : 'add'
                }
            );
        },
        removeRecord(i) {
            i.type = 'delete';
        }
    },
});
</script>

@stop