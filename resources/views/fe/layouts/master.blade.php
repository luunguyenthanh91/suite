<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', config('app.name'))">
    <meta name="author" content="@yield('meta_author', config('app.name'))">

    <link href="{{ asset('fe/assets/images/favicon.ico') }}" type="img/x-icon" rel="shortcut icon">

    @yield('meta')
    @stack('before-styles')
    <link rel="stylesheet" href="{{ asset('fe/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fe/assets/css/iconfont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fe/assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('fe/assets/css/helper.css') }}">
    <link rel="stylesheet" href="{{ asset('fe/assets/css/style.css') }}">

    <script src="{{ asset('fe/assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/angular.js') }}"></script>
    @stack('after-styles')
    @if (trim($__env->yieldContent('page-styles')))    
    @yield('page-styles')
    @endif    

<!-- Custom Css -->
</head>


<body>

<div id="main-wrapper">
    @include('fe.layouts.sidebar')
</div>
    
    
    <script src="{{ asset('fe/assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('fe/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('fe/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('fe/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('fe/assets/js/main.js') }}"></script>
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

    @stack('after-scripts')

    <!-- vendor js file -->
    @yield('vendor-script')

    <!-- project main Scripts js-->

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
