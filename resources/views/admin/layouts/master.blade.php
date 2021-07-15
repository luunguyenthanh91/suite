<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
<title>@yield('title') - {{ config('app.name') }}</title>
<meta name="description" content="@yield('meta_description', config('app.name'))">
<meta name="author" content="@yield('meta_author', config('app.name'))">

@yield('meta')
@stack('before-styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">    
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">    
<link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">
<!-- <script type="text/javascript" src="{{ asset('lib_upload/jquery.js') }}"></script> -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> -->
<script src="{{ asset('js/angular.js') }}"></script>
@stack('after-styles')
@if (trim($__env->yieldContent('page-styles')))    
@yield('page-styles')
@endif    

<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/css/mooli.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body data-theme="light" ng-app="app-manager">
    
<div id="body" class="theme-cyan">
    
    <!-- Theme setting div -->
    @include('layout.themesetting')

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <div id="wrapper">
        
        <!-- main page header -->
        @include('layout.navbar')

        <!-- project main left menubar -->
        @include('layout.sidebar')

        <!-- Rightbar chat  -->
        @include('layout.rightbar')    

        <!-- sticky note rightbar div -->
        @include('layout.stickynote')

        <div id="main-content">
            <div class="container-fluid">          

                @yield('content')

            </div>
        </div>        
    </div>

    @yield('popup')
    
</div>

<script>
        var customInterpolationApp = angular.module('app-manager', []);

        customInterpolationApp.config(function($interpolateProvider) {
          $interpolateProvider.startSymbol('((');
          $interpolateProvider.endSymbol('))');
        });
        
</script>
@yield('script')
<!-- main jquery and bootstrap Scripts -->
@stack('before-scripts')
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
@stack('after-scripts')

<!-- vendor js file -->
@yield('vendor-script')

<!-- project main Scripts js-->
<script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

<!-- page Scripts ja -->
@yield('page-script')

<script>
    $( document ).ready(function() {
        $('.parent-list').on('click',function () {
            $(this).toggleClass('active');
        });
    });
    
</script>


<!--End of Tawk.to Script-->

</body>
</html>
