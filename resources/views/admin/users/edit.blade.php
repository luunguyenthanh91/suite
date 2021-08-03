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
                    <h1 class="h2 mb-0">Update User</h1>

                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/user/list">User</a></li>
                    </ol>

                </div>
                
            </div>

        </div>

        <div class="container page__container page-section">
            <div class="row mb-32pt">
                <div class="col-lg-4">
                    <div class="page-separator">
                        <div class="page-separator__text">Basic information</div>
                    </div>
                </div>
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="flex" style="max-width: 100%">
                        <form action="" method="POST" class="p-0 mx-auto">
                            @csrf
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
                                @if(session('message-add'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong>{{session('message-add')}}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                    </div>
                                
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="form-label" >Name:</label>
                                <input type="text" name="name" class="form-control" value="{{$data->name}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" >Bộ Phận:</label>
                                <select class="form-control" name="bophan_id">
                                    @foreach($bophans as $item)
                                        <option value="{{$item->id}}" @if(@$data->item_district == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex">
                                <div class="form-group col-lg-12 p-0">
                                    <label class="form-label">Avatar:</label>
                                    
                                    <li id="images" >
                                        <input class="input_image" type="hidden" name="avatar" id="chooseImage_inputfile"
                                            value="{{@$data->avatar != '' ? @$data->avatar  : '' }}">
                                        <div id="chooseImage_divfile" style="display: none;">
                                            <img  src="{{@$data->avatar  != '' ? @$data->avatar : '' }}"
                                                id="chooseImage_imgfile"
                                                style="max-width: 150px; max-height:150px; border:dashed thin;" />
                                        </div>
                                        <div id="chooseImage_noImage_divfile"
                                            style="width: 150px; border: thin dashed; text-align: center; padding:70px 0px;">
                                            No image
                                        </div>
                                        <br />
                                        <a href="javascript:chooseImage('file');"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">library_add</span></a>
                                        <a href="javascript:clearImage('file');"><span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">delete</span></a>
                                        
                                    </li>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" >Code Check In:</label>
                                <input type="text" name="code" class="form-control" value="{{$data->code}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" >Email:</label>
                                <input type="text" name="email"  readonly class="form-control"  value="{{$data->email}}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" >Phone:</label>
                                <input type="text" name="phone"  class="form-control"  value="{{@$data->phone}}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" >Update Password:</label>
                                <input type="password" name="password"   class="form-control"  >
                            </div>
                            <div class="form-group">
                                <label class="form-label" >Repeat New Password:</label>
                                <input type="password" name="password_new"   class="form-control"  >
                            </div>
                            


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
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
    //<![CDATA[

    jQuery(document).ready(function (){
        

        $(window).keydown(function(event){
            if((event.which== 13) && ($(event.target)[0]!=$("textarea")[0])  && ($(event.target)[0]!=$("textarea")[1])  && ($(event.target)[0]!=$("textarea")[2])  && ($(event.target)[0]!=$("textarea")[3])) {
                event.preventDefault();
                return false;
            }
        });

    });
</script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#list-data',
    data: {

    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        deleteRecore(_i) {
            const that = this;
            Swal.fire({
                title: "Xác Nhận",
                text: "Do you agree to delete this value?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(t) {
                if (t.dismiss == "cancel") {
                    return;
                }
                that.loadingTable = 1;
                $.ajax({
                    url: "/admin/customer/delete/" + _i,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Delete successfuly!"
                        });
                        location.href = "/admin/customer";
                    },
                    error: function(xhr, textStatus, error) {
                        Swal.fire({
                            title: "There was an error in the input data!",
                            type: "warning",

                        });
                    }
                });

            })
        },
    },
});
</script>

@stop