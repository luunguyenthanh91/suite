@extends('admin.layouts.main')
@section('title', '通訳報告')
@section('content')

<div class="mdk-drawer-layout__content page-content flex-center " >
    <div id="list-data" class="mw-600"> 
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
        @if ( @$message && @$message['status'] !== 1 )
        <form action="" method="POST" class="" enctype="multipart/form-data" >
            @csrf
            <h2 class="title_form">{{ trans('label.report_form') }}</h2>
            
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    {{ trans('label.msg5') }}
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12"  style="border-bottom: 1px solid #CCC">
                    <label class="form-label">{{ trans('label.id') }}{{@$id}}</label><br>
                    <label class="form-label">{{ trans('label.ngay_phien_dich') }}: {{@$ngay_pd}}</label><br>
                    <label class="form-label">{{ trans('label.address_pd') }}: {{@$address_pd}}</label>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <label class="form-label">{{ trans('label.begin_time') }}</label>
                    <div class="d-flex search-form" >
                        <input type="date" name="ngay_phien_dich_begin" class="form-control" required value="{{@$ngay_pd}}">
                        <input type="time" name="gio_phien_dich" class="form-control" required value="09:00">
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <label class="form-label">{{ trans('label.end_time') }}</label>
                    <div class="d-flex search-form" >
                        <input type="date" name="ngay_phien_dich_end" class="form-control" required value="{{@$ngay_pd}}">
                        <input type="time" name="gio_ket_thuc" class="form-control" required value="17:00">
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <label class="form-label">{{ trans('label.route_move') }}
                    </label>
                    <div>
                        (記入例)<br>
                        行き：電車で、船橋駅 => 東京駅 <br>
                        帰り：徒歩
                    </div>
                    <div class="search-form" >
                        <textarea name="gio_tang_ca" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <label class="form-label">{{ trans('label.move_fee') }}</label>
                    <div class="search-form" >
                        <input type="text" name="phi_giao_thong" class="form-control money_parse">
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <label class="form-label">{{ trans('label.receipt') }} (※画像ファイル)</label>
                    <div class="search-form" >
                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <label class="form-label">{{ trans('label.report_content') }} (※ベトナム語でもOK)</label>
                    <div>
                    (記入例)<br>
実習生の数： 5 人<br>
■ 日程・業務内容<br>
　　+ 7:00 姉ヶ崎駅で企業の担当者に待ち合わせ<br>
　　+ 8:00-11:00 労働安全法の講習に参加<br>
　　+ 11:00-13:00 事故などの説明会に参加<br>
■ 所感<br>
　　+ 実習生の日本語が上手<br>
　　+ 企業様と実習生の良い関係<br>
                    </div>
                    <div class="search-form" >
                        <textarea type="text" name="note" class="form-control" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-12">
                <div class="form-group col-lg-12">
                    <div style="background:#fff;border: 1px solid #CCCCCC;height: 100px; overflow-y: scroll; padding:5px 20px;border-radius: 5px;margin:0 -20px; margin-left: 0px;margin-right: 0px;">
                    <div style="text-align:center;">
                    個人情報のお取り扱いについて<br>
                    ～以下の内容をお読みになり、同意の上送信下さい～
                    </div>
                    <p><br><br>
                    株式会社ＡｌｐｈａＣｅｐ（以下「当社」）は、以下のとおり個人情報保護方針を定め、個人情報保護の仕組みを構築し、全従業員に個人情報保護の重要性の認識と取組みを徹底させることにより、個人情報の保護を推進致します。</p>
                    <p><b>個人情報の管理</b></p>
                    <p>当社は、お客さまの個人情報を正確かつ最新の状態に保ち、個人情報への不正アクセス・紛失・破損・改ざん・漏洩などを防止するため、セキュリティシステムの維持・管理体制の整備・社員教育の徹底等の必要な措置を講じ、安全対策を実施し個人情報の厳重な管理を行ないます。</p>
                    <p><b>個人情報の利用目的</b></p>
                    <p>お客さまからお預かりした個人情報は、当社からのご連絡や業務のご案内やご質問に対する回答として、電子メールや資料のご送付に利用致します。</p>
                    <p><b>個人情報の第三者への開示・提供の禁止</b></p>
                    <p>当社は、お客さまよりお預かりした個人情報を適切に管理し、次のいずれかに該当する場合を除き、個人情報を第三者に開示致しません。</p>
                    <p>1. お客さまの同意がある場合<br>
                    2. お客さまが希望されるサービスを行なうために当社が業務を委託する業者に対して開示する場合<br>
                    3. 法令に基づき開示することが必要である</p>
                    <p><b>個人情報の安全対策</b></p>
                    <p>当社は、個人情報の正確性及び安全性確保のために、セキュリティに万全の対策を講じています。</p>
                    <p><b>ご本人の照会</b></p>
                    <p>お客さまがご本人の個人情報の照会・修正・削除などをご希望される場合には、ご本人であることを確認の上、対応させていただきます。</p>
                    <p><b>法令、規範の遵守と見直し</b></p>
                    <p>当社は、保有する個人情報に関して適用される日本の法令、その他規範を遵守するとともに、本ポリシーの内容を適宜見直し、その改善に努めます。</p>
                    <p><b>お問い合せ</b></p>
                    <p>当社の個人情報の取扱に関するお問い合せは下記までご連絡ください。<br>
                    ●○●○●○●○●○●○●○●○●○●○●○●○●○●<br>
                    株式会社AlphaCep(アルファセプ)<br>
                    〒273-0111 千葉県鎌ケ谷市北中沢 1-18-22 スカラビル3F<br>
                    TEL: 0474-022-022<br>
                    Website: https://www.alphacep.co.jp<br>
                    Email: support@alphacep.co.jp<br>
                    </p></div>
                </div>
            </div>
            <div class="form-group col-lg-12" style="text-align:center">
                <div class="flex-full-center">
                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"><label style="margin-left: 5px;margin-right: 5px" for="vehicle1">「個人情報のお取り扱い」について同意する <span style="background:red;font-size:x-small;color:white;text-align:center;width:30px;">必須</span></label>
                </div>
            </div>
            <div class="form-group col-lg-12" style="text-align:center">
                <button type="submit" id="btnSubmit" disabled class="btn btn-primary">{{ trans('label.send') }}</button>
            </div>
        </form>
        @endif
    </div>
   
    @include('admin.component.footer')
</div>
@include('admin.component.left-bar')

@stop

@section('page-script')
<link href="{{ asset('js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/pages/sweet-alerts.init.js') }}"></script>
<link href="{{ asset('js/lib/main.css') }}" rel='stylesheet' />
<script src="{{ asset('js/lib/main.js') }}"></script>


<script type="text/javascript">
    var calendar;
    jQuery(document).ready(function (){
        $('.tab_click').on('click', function (){
            $('.tab_click').removeClass('active');
            $(this).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#detail'+$(this).attr('id')).addClass('active');
        });
        $('#vehicle1').on('click', function() {
            if (document.getElementById('vehicle1').checked) {
                $('#btnSubmit').prop('disabled', false);
            } else {
                $('#btnSubmit').prop('disabled', true);
            }
        });
    });
</script>

<script type="text/javascript">
new Vue({
    el: '#list-data',
    data: {
        
    },
    delimiters: ["((", "))"],
    mounted() {
    },
    methods: {
		
    },
});
</script>

@stop