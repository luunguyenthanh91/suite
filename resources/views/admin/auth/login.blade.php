@extends('admin.layouts.authentication')
@section('title', 'Login')
@section('content')

<div class="page-content navbarfotter" >
    <div class="vertical-center">
        <div class="container page__container">
            <div class="textAlignCenter">
                <img class="loginIcon" src="{{ asset('assets/images/fvc2_.png') }}" />
            </div>
            <div class="styleHeaderTitleText2 mb-40pt textAlignCenter">{{ trans('label.login_header') }}</div>
            <form id="login-form" action="{{route('post-login')}}" method="POST" class="col-md-3 p-0 mx-auto">
                @csrf
                <div class="col-lg-12">
                    <div class="form-group">
                        @if ( Session::has('success-logout') )
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>{{ Session::get('success-logout') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                        @endif
                        @if ( Session::has('success') )
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>{{ Session::get('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                        @endif
                        @if ( Session::has('error') )
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>{{ Session::get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <span class="sr-only">Close</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label styleHeaderLogoText" for="email">{{ trans('label.email') }}</label>
                        <input type="text" class="form-control" autofocus="" data-val="true" data-val-required="{{ trans('label.msg1', ['arg' => 'email']) }}" id="Username" name="email" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-label styleHeaderLogoText" for="password">{{ trans('label.pass') }}</label>
                        <input id="password" type="password" class="form-control" autocomplete="off" data-val="true" data-val-required="{{ trans('label.msg1', ['arg' => 'pass']) }}" id="Password" name="password">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-warning">{{ trans('label.login') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop