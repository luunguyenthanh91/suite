<div class="navbar navbar-expand navbar-dark" id="default-navbar" data-primary>  
    <div class="onlyPC headerIcon"> 
        <a class="btn-real-dent" data-toggle="sidebar" href="/">
            <img src="{{ asset('assets/images/fvc2__.png') }}" />
        </a>
    </div>  
    <div class="col-lg-auto">
        <div class="fullWidth">
            <div class="styleHeaderTitleText">{{ trans('label.login_header') }}</div>
            <div class="styleHeaderSubTitleText onlyPC">@yield('contentTitle')</div>
        </div>
    </div>  
    <center style="width:100%"> 
    </center>
    <div  class="col-lg-auto onlyPC" style="text-align:right"> 
        <div class="btn-group">
            <a type="button" class="btn btn-warning background4" href="/admin/worksheet">
            <i class="fab fa-bootstrap"></i><span class="labelButton">{{ trans('label.person_management2_label_1') }}</span>
            </a>
        </div>
        <div class="btn-group">
            <a type="button" class="btn btn-warning background5" href="/admin/payslip">
            <i class="fas fa-calculator"></i><span class="labelButton">{{ trans('label.person_management2_label_2') }}</span>
            </a>
        </div>
        <div class="btn-group">
            <a type="button" class="btn btn-warning background1" href="#">
                <i class="fas fas fa-calendar-alt"></i><span class="labelButton">{{ trans('label.person_management2_label_3') }}</span>
            </a>
        </div>
        <div class="btn-group">
            <a type="button" class="btn btn-warning background2" href="#">
            <i class="fas fa-balance-scale"></i><span class="labelButton">{{ trans('label.money_management_label_1') }}</span>
            </a>
        </div>
        <div class="btn-group">
            <a type="button" class="btn btn-warning background3" href="#">
                <i class="fas fa-dollar-sign"></i><span class="labelButton">{{ trans('label.money_management_label_2') }}</span>
            </a>
        </div>
    </div>
    <div class="btn-group group-menu-header">
        <button type="button" class="btn btn-warning toggle-menu background0">
            <i class="fas fa-bars"></i><span class="labelButton">{{ trans('label.menu_header') }}</span>
        </button>
        <div class="box-menu hidden">
            <span class="arrow-up"></span>
            <div style="border-bottom:1px solid #CCC;margin-left:0px;">
                <a class="sidebar-menu-button" href="/admin">
                    <i class="fas fa-home"></i><span class="sidebar-menu-text spaceLabel">{{ trans('label.home') }}</span>
                </a>
            </div>
            <ul class="sidebar-menu ">
                <li style="border-bottom:1px solid #CCC;margin-left:0px;"  class="sidebar-menu-item {{ (request()->is('*employee*')) ? 'active open' : '' }} {{ (request()->is('*bookname*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-workflow" aria-expanded="false">
                    <i class="fas fa-tasks"></i><span class="sidebar-menu-text spaceLabel">{{ trans('label.menu_workflow') }}</span>
                    <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-workflow" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*employee')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/employee">
                                <span class="sidebar-menu-text">{{ trans('label.menu_costdoc') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*bookname')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/bookname">
                                <span class="sidebar-menu-text">{{ trans('label.menu_approvedoc') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*bookname')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/bookname">
                                <span class="sidebar-menu-text">{{ trans('label.menu_approvedoc') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*employee*')) ? 'active open' : '' }} {{ (request()->is('*bookname*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-employee" aria-expanded="false">
                    {{ trans('label.person_management1') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-employee" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*employee')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/employee">
                                <span class="sidebar-menu-text">{{ trans('label.person_management1_1') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*bookname')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/bookname">
                                <span class="sidebar-menu-text">{{ trans('label.person_management1_2') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*worksheet*')) ? 'active open' : '' }} 
                                             {{ (request()->is('*worksheetsche*')) ? 'active open' : '' }} 
                                             {{ (request()->is('*payslip*')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-ws" aria-expanded="false">
                        {{ trans('label.person_management2') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-ws" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*/worksheetsche')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/worksheetsche">
                            <span class="sidebar-menu-text">{{ trans('label.person_management2_0') }}</span>
                            </a>
                        </li>  
                        <li class="sidebar-menu-item {{ (request()->is('*/worksheet')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/worksheet">
                            <span class="sidebar-menu-text">{{ trans('label.person_management2_1') }}</span>
                            </a>
                        </li>  
                        <li class="sidebar-menu-item {{ (request()->is('*/payslip')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/payslip">
                            <span class="sidebar-menu-text">{{ trans('label.person_management2_2') }}</span>
                            </a>
                        </li> 
                        <li class="sidebar-menu-item {{ (request()->is('*/payslip')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/payslip">
                            <span class="sidebar-menu-text">{{ trans('label.person_management2_4') }}</span>
                            </a>
                        </li>  
                        <li class="sidebar-menu-item {{ (request()->is('*/payslip')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/payslip">
                            <span class="sidebar-menu-text">{{ trans('label.person_management2_5') }}</span>
                            </a>
                        </li>  
                        <li class="sidebar-menu-item {{ (request()->is('*/payslip')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/costprepay">
                            <span class="sidebar-menu-text">{{ trans('label.menu_costprepay') }}</span>
                            </a>
                        </li> 
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-interpreter" aria-expanded="false">
                    {{ trans('label.service_management') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-interpreter" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/partner-interpreter">
                            <span class="sidebar-menu-text">{{ trans('label.service_management_1') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/partner-interpreter">
                            <span class="sidebar-menu-text">{{ trans('label.service_management_2') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>   
                <li class="sidebar-menu-item {{ (request()->is('*costtransport*')) ? 'active open' : '' }}
                    {{ (request()->is('payslip')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-project" aria-expanded="false">
                    {{ trans('label.money_management_4') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-project">
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_0') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*costtransport')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/costtransport">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_1') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*payslip')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/payslip">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_2') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_3') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_4') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_5') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_6') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_7') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_8') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.money_management_4_9') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*system*')) ? 'active open' : '' }} {{ (request()->is('*mailtemplate*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-system" aria-expanded="false">
                    {{ trans('label.money_management_1') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-system" style="">
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_1') }}</span>
                            </a>
                        </li>
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_2') }}</span>
                            </a>
                        </li>
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_3') }}</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>    
                <li class="sidebar-menu-item {{ (request()->is('*system*')) ? 'active open' : '' }} {{ (request()->is('*mailtemplate*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-system" aria-expanded="false">
                    {{ trans('label.money_management_2') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-system" style="">
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_1') }}</span>
                            </a>
                        </li>
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_2') }}</span>
                            </a>
                        </li>
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_3') }}</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*system*')) ? 'active open' : '' }} {{ (request()->is('*mailtemplate*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-system" aria-expanded="false">
                    {{ trans('label.money_management_3') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-system" style="">
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_1') }}</span>
                            </a>
                        </li>
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_2') }}</span>
                            </a>
                        </li>
                        <li class="pl-1 sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.money_management_3') }}</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="sidebar-menu-item ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-doc" aria-expanded="false">
                    {{ trans('label.doc_management') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                </li>        
            </ul>
            <div style="border-top:1px solid #CCC;margin-left:0px;">
                <div style="text-transform:uppercase;text-align:center;margin-top:10px;margin-bottom:-5px;">
                    <i class="fas fa-user" style="color:purple"></i><span class="labelButton">{{ Auth::guard('admin')->user()->name }}</span>
                </div>
                <div class="logout-btn" >
                    <a href="{{route('admin-logout')}}" class="btn btn-outline-secondary" style="margin-top:10px;">
                        <i class="fas fa-sign-out-alt"></i><span class="labelButton">{{ trans('label.logout') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
   
</div> 
<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

new Vue({
    el: '#default-navbar',
    data: {
        tienphiendich : '',
        address_pd: '',
        fieldPlaceHolder : "{{ trans('label.search2') }}",
        fielSearch : 2
    },
    delimiters: ["((", "))"],
    mounted() {},
    methods: {
        changeSearch(valueChange) {
            this.fielSearch = valueChange;
            this.fieldPlaceHolder = this.deValueSearch(valueChange);
        },
        deValueSearch (stringParse) {
            if (stringParse == 1) {
                return '受注Noで検索';
            } else if (stringParse == 2) {
                return '案件Noで検索';
            } else if (stringParse == 3) {
                return '営業者の氏名で検索';
            } else if (stringParse == 4) {
                return '通訳者の氏名で検索';
            } else if (stringParse == 5) {
                return '通訳会場で通訳者マッチング';
            }
        },
        parseFormUrl(stringParse) {
            if (stringParse == 1) {
                return 'po';
            } else if (stringParse == 2) {
                return 'project';
            } else if (stringParse == 3) {
                return 'partner-sale';
            } else if (stringParse == 4) {
                return 'partner-interpreter';
            } else if (stringParse == 5) {
                return 'partner-interpreter';
            }
        }
    },
});
</script>
<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function (){
        $('.toggle-menu').on('click',function() {
            $('.box-menu').toggleClass('hidden');
        });
    });

    $('form').submit(function() {
        window.location.href = "/admin/project";
    });
</script>