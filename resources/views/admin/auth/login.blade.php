@extends('admin.layouts.authentication')
@section('title', 'Login')
@section('content')



<div class="mdk-drawer-layout__content page-content">

    @include('admin.component.login-header')

    <div class="pt-32pt pt-sm-64pt pb-32pt">
        <div class="container page__container" style="margin-top:100px;">
            <form id="login-form" action="{{route('post-login')}}" method="POST" class="col-md-5 p-0 mx-auto">
                @csrf
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
                    <label class="form-label" for="email">メールアドレス</label>
                    <input type="text" class="form-control" autofocus="" data-val="true" data-val-required="メールアドレスを入力してください。" id="Username" name="email" value="">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">パスワード</label>
                    <input id="password" type="password" class="form-control" autocomplete="off" data-val="true" data-val-required="パスワードを入力してください。" id="Password" name="password">
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">ログイン</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop