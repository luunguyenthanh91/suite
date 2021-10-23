<div class="navbar navbar-expand navbar-dark" id="default-navbar" data-primary>  
    <div style="width:100%"> 
        <form method="get" class="search-form" :action="'/admin/' + parseFormUrl(fielSearch)">
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary3 dropdown-toggle dropdown-toggle-split btn-style-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" @click="changeSearch(1)">
                        <i class="fas fa-bell"></i><span class="labelButtonDropMenu">{{ trans('label.search_po') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"  @click="changeSearch(2)">
                        <i class="fas fa-briefcase"></i><span class="labelButtonDropMenu">{{ trans('label.search_project') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"  @click="changeSearch(3)">
                    <i class="fas fa-user-shield"></i><span class="labelButtonDropMenu">{{ trans('label.search_sale') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"  @click="changeSearch(4)">
                        <i class="fas fa-user"></i><span class="labelButtonDropMenu">{{ trans('label.search_interpreter') }}</span>
                    </a>
                    <a class="dropdown-item" href="#"  @click="changeSearch(5)">
                        <i class="fas fa-key"></i><span class="labelButtonDropMenu">{{ trans('label.matching2') }}</span>
                    </a>
                </div>
            </div>
            <input type="text" name="keyword" required class="form-control" :placeholder="fieldPlaceHolder" >
            <input type="hidden" name="type" class="form-control" v-if="fielSearch == 5" value="address">
            <div class="btn-group">
                <button type="submit" class="btn btn-outline-secondary3 searchBtn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="btn-group group-menu-header" style="padding-left:10px;">
        <button type="button" class="btn btn-warning background6 toggle-menu">
            <i class="fas fa-bars" style="color:white">
            <br>
            <span style="font-size 2px;color:white">{{ trans('label.menu_header') }}</span></i>
        </button>
        <div class="box-menu hidden">
            <span class="arrow-up"></span>
            <ul class="sidebar-menu ">
                <li class="sidebar-menu-item {{ (request()->is('*dashboard')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button" href="/">
                    <i class="fas fa-home"></i><span class="labelButton">{{ trans('label.home') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*list-po')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button" href="/admin/po">
                    <span class="sidebar-menu-text">{{ trans('label.pomenu') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*project*')) ? 'active open' : '' }} {{ (request()->is('calendar')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-project" aria-expanded="false">
                    {{ trans('label.projectmenu') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-project" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">{{ trans('label.projectmenu1') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*/calendar')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/calendar">
                                <span class="sidebar-menu-text">{{ trans('label.projectmenu2') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*cost*')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-cost" aria-expanded="false">
                        {{ trans('label.costmenu') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-cost" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*/cost')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/cost">
                            <span class="sidebar-menu-text">{{ trans('label.costmenu1') }}</span>
                            </a>
                        </li> 

                        <li class="sidebar-menu-item {{ (request()->is('*/cost-sale')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/cost-sale">
                            <span class="sidebar-menu-text">{{ trans('label.costmenu2') }}</span>
                            </a>
                        </li>  
                        <li class="sidebar-menu-item {{ (request()->is('*/cost-interpreter')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/cost-interpreter">
                                <span class="sidebar-menu-text">{{ trans('label.costmenu3') }}</span>            
                            </a>
                        </li> 
                        <li class="sidebar-menu-item {{ (request()->is('*/cost-incometax')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/cost-incometax">
                            <span class="sidebar-menu-text">{{ trans('label.costmenu4') }}</span>
                            </a>
                        </li> 
                        <li class="sidebar-menu-item {{ (request()->is('*/cost-movefee')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/cost-movefee">
                                <span class="sidebar-menu-text">{{ trans('label.costmenu5') }}</span>
                            </a>
                        </li> 
                        <li class="sidebar-menu-item {{ (request()->is('*/cost-bankfee')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/cost-bankfee">
                                <span class="sidebar-menu-text">{{ trans('label.costmenu6') }}</span>
                            </a>
                        </li>   
                    </ul>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*/deposit')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button" href="/admin/deposit">
                        <span class="sidebar-menu-text">{{ trans('label.depositmenu') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*earnings')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button" href="/admin/earnings">
                        <span class="sidebar-menu-text">{{ trans('label.benefitmenu') }}</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ (request()->is('*partner-sale')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button" href="/admin/partner-sale">
                        <span class="sidebar-menu-text">{{ trans('label.salemenu') }}</span>
                    </a>
                </li>   
                <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-interpreter" aria-expanded="false">
                    {{ trans('label.interpretermenu') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-interpreter" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/partner-interpreter">
                            <span class="sidebar-menu-text">{{ trans('label.interpretermenu1') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter-vn')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/partner-interpreter-vn">
                            <span class="sidebar-menu-text"> {{ trans('label.interpretermenu2') }}</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*partner-interpreter-ph')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/partner-interpreter-ph">
                            <span class="sidebar-menu-text">{{ trans('label.interpretermenu3') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>     
                <li class="sidebar-menu-item {{ (request()->is('*customer')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button" href="/admin/customer">
                        <span class="sidebar-menu-text">{{ trans('label.customermenu') }}</span>
                    </a>
                </li>   
                <li class="sidebar-menu-item {{ (request()->is('*system*')) ? 'active open' : '' }} {{ (request()->is('*mailtemplate*')) ? 'active open' : '' }}">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-system" aria-expanded="false">
                    {{ trans('label.system_menu') }}
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-system" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*system_log*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/system_log">
                            <span class="sidebar-menu-text">{{ trans('label.log_menu') }}</span>
                            </a>
                        </li>
                    </ul>
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
        fieldPlaceHolder : "{{ trans('label.msg3') }}",
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