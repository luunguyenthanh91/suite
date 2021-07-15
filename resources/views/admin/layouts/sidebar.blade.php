<div id="left-sidebar" class="sidebar">
    <!-- <a href="javascript:void(0);" class="menu_toggle"><i class="fa fa-angle-left"></i></a> -->
    <div class="navbar-brand">
        <a href="{{route('dashboard.index')}}"><img src="{{ asset('assets/images/icon.svg') }}" alt="Mooli Logo" class="img-fluid logo"><span>Mooli</span></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="fa fa-close"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
            @if(Auth::guard('admin')->user()->avatar != '')
                <img src="{{ Auth::guard('admin')->user()->avatar }}" class="user-photo" alt="User Profile Picture">
            @else
                <img src="{{ asset('assets/images/user.png') }}" class="user-photo" alt="User Profile Picture">
            @endif
            </div>
            <div class="dropdown">
                <span>Xin Chào,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{Auth::guard('admin')->user()->name}}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <!-- <li><a href="{{route('pages.profile')}}"><i class="fa fa-user"></i>My Profile</a></li> -->
                    <!-- <li><a href="{{route('apps.inbox')}}"><i class="fa fa-envelope"></i>Messages</a></li> -->
                    <li><a href="{{route('admin.listSettings')}}"><i class="fa fa-gear"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="{{route('admin-logout')}}"><i class="fa fa-power-off"></i>Logout</a></li>
                </ul>
            </div>
        </div>  
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu animation-li-delay">

                <li class="{{ @$menu_parent_active === 'setting-groups' ? 'active' : null }} parent-list">
                    <a class="has-arrow"><i class="fa fa-cog"></i><span>Hệ Thống</span></a>
                    <ul>
                        <li class="{{ @$menu_active === 'dashboard' ? 'active' : null }}"><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> <span>Thống Kê</span></a></li>
                        <li class="{{ @$menu_active === 'banners' ? 'active' : null }}">
                            <a href="{{route('admin.listBanners')}}">
                                <i class="fa fa-file-image-o"></i> <span>Banners</span>
                            </a>
                        </li>
                        <li class="{{ @$menu_active === 'deliveries' ? 'active' : null }}">
                            <a href="{{route('admin.listDeliveries')}}">
                                <i class="fa fa-truck"></i> <span>Deliveries</span>
                            </a>
                        </li>
                        <li class="{{ @$menu_active === 'settings' ? 'active' : null }}">
                            <a href="{{route('admin.listSettings')}}">
                                <i class="fa fa-cog"></i> <span>Cài Đặt</span>
                            </a>
                        </li>
                        <li class="{{ @$menu_active === 'notifications' ? 'active' : null }}">
                            <a href="{{route('admin.listNotifications')}}">
                                <i class="fa fa-bell"></i> <span>Cấu Hình Notifications</span>
                            </a>
                        </li>
                        <li class="{{ @$menu_active === 'origins' ? 'active' : null }}">
                            <a href="{{route('admin.listOrigins')}}">
                                <i class="fa fa-globe"></i> <span>Quốc Gia</span>
                            </a>
                        </li>
                        <li class="{{ @$menu_active === 'trademarks' ? 'active' : null }}">
                            <a href="{{route('admin.listTrademarks')}}">
                                <i class="fa fa-trademark"></i> <span>Nhãn Hiệu</span>
                            </a>
                        </li>
                        <li class="{{ @$menu_active === 'promotions' ? 'active' : null }}">
                            <a href="{{route('admin.listPromotions')}}">
                                <i class="fa fa-barcode"></i> <span>Mã Giảm Giá</span>
                            </a>
                        </li>
                    </ul>
                </li>

                
                
                
                <li class="header">Thành Viên</li>
                
                <li class="{{ @$menu_active === 'levels' ? 'active' : null }}">
                    <a href="{{route('admin.listLevel')}}">
                        <i class="fa fa-level-up"></i> <span>Cấp Thành Viên</span>
                    </a>
                </li>

                <li class="{{ @$menu_active === 'users' ? 'active' : null }}">
                    <a href="{{route('admin.listUser')}}">
                        <i class="fa fa-users"></i> <span>Thành Viên</span>
                    </a>
                </li>

                <li class="header">Sản Phẩm</li>
                <li class="{{ @$menu_active === 'categorys' ? 'active' : null }}">
                    <a href="{{route('admin.listCategory')}}">
                        <i class="fa fa-object-group"></i> <span>Danh Mục Sản Phẩm</span>
                    </a>
                </li>
                <li class="{{ @$menu_active === 'products' ? 'active' : null }}">
                    <a href="{{route('admin.listProducts')}}">
                        <i class="fa fa-codepen"></i> <span>Sản Phẩm</span>
                    </a>
                </li>
                <li class="{{ @$menu_active === 'history-import' ? 'active' : null }}">
                    <a href="{{route('admin.historyImport')}}">
                        <i class="fa fa-history"></i> <span>Lịch Sử Nhập Hàng</span>
                    </a>
                </li>
                <li class="{{ @$menu_active === 'history-export' ? 'active' : null }}">
                    <a href="{{route('admin.historyExport')}}">
                        <i class="fa fa-history"></i> <span>Lịch Sử Xuất Hàng</span>
                    </a>
                </li>

                <li class="{{ @$menu_active === 'orders' ? 'active' : null }}">
                    <a href="{{route('admin.listOrders')}}">
                        <i class="fa fa-shopping-basket"></i> <span>Đơn Đặt Hàng</span>
                    </a>
                </li>

                <li class="header">Blog</li>

                <li class="{{ @$menu_active === 'categorys-post' ? 'active' : null }}">
                    <a href="{{route('admin.listCategoryPost')}}">
                        <i class="fa fa-object-group"></i> <span>Danh Mục Bài Viết</span>
                    </a>
                </li>
                <li class="{{ @$menu_active === 'posts' ? 'active' : null }}">
                    <a href="{{route('admin.listPosts')}}">
                        <i class="fa fa-newspaper-o"></i> <span>Bài Viết</span>
                    </a>
                </li>


                <!-- <li class="{{ Request::segment(2) === 'inbox' ? 'active' : null }}"><a href="{{route('apps.inbox')}}"><i class="fa fa-envelope"></i> <span>Email</span> <span class="badge badge-default mr-0">12</span></a></li>
                <li class="{{ Request::segment(2) === 'chat' ? 'active' : null }}"><a href="{{route('apps.chat')}}"><i class="fa fa-comments"></i> <span>Chat</span></a></li>
                <li class="{{ Request::segment(2) === 'apps' ? 'active' : null }}"><a href="{{route('apps.calendar')}}"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
                <li class="{{ Request::segment(2) === 'todolist' ? 'active' : null }}"><a href="{{route('apps.todolist')}}"><i class="fa fa-th-list"></i> <span>Todo List</span></a></li>
                <li class="{{ Request::segment(2) === 'filemanager' ? 'active' : null }}"><a href="{{route('apps.filemanager')}}"><i class="fa fa-folder"></i> <span>File Manager</span></a></li>
                <li class="{{ Request::segment(2) === 'contacts' ? 'active' : null }}"><a href="{{route('apps.contacts')}}"><i class="fa fa-address-book"></i> <span>Contacts</span></a></li>                    
                <li class="{{ Request::segment(2) === 'scrumboard' ? 'active' : null }}"><a href="{{route('apps.scrumboard')}}"><i class="fa fa-tasks"></i> <span>Scrumboard</span></a></li>
                <li class="{{ Request::segment(2) === 'blog' ? 'active' : null }}"><a href="{{route('apps.blog')}}"><i class="fa fa-globe"></i> <span>Blog</span></a></li>
                <li class="{{ Request::segment(2) === 'social' ? 'active' : null }}"><a href="{{route('apps.social')}}"><i class="fa fa-share-alt-square"></i> <span>Social</span></a></li> -->
                
                <!-- <li class="header">Vendors</li>
                <li class="{{ Request::segment(1) === 'elements' ? 'active' : null }}">
                    <a href="#uiElements" class="has-arrow"><i class="fa fa-diamond"></i><span>ui Elements</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'helperclass' ? 'active' : null }}"><a href="{{route('elements.helperclass')}}">Helper Classes</a></li>
                        <li class="{{ Request::segment(2) === 'bootstrap' ? 'active' : null }}"><a href="{{route('elements.bootstrap')}}">Bootstrap UI</a></li>
                        <li class="{{ Request::segment(2) === 'typography' ? 'active' : null }}"><a href="{{route('elements.typography')}}">Typography</a></li>
                        <li class="{{ Request::segment(2) === 'tabs' ? 'active' : null }}"><a href="{{route('elements.tabs')}}">Tabs</a></li>
                        <li class="{{ Request::segment(2) === 'buttons' ? 'active' : null }}"><a href="{{route('elements.buttons')}}">Buttons</a></li>
                        <li class="{{ Request::segment(2) === 'icons' ? 'active' : null }}"><a href="{{route('elements.icons')}}">Icons</a></li>
                        <li class="{{ Request::segment(2) === 'notifications' ? 'active' : null }}"><a href="{{route('elements.notifications')}}">Notifications</a></li>
                        <li class="{{ Request::segment(2) === 'colors' ? 'active' : null }}"><a href="{{route('elements.colors')}}">Colors</a></li>
                        <li class="{{ Request::segment(2) === 'dialogs' ? 'active' : null }}"><a href="{{route('elements.dialogs')}}">Dialogs</a></li>
                        <li class="{{ Request::segment(2) === 'listgroup' ? 'active' : null }}"><a href="{{route('elements.listgroup')}}">List Group</a></li>
                        <li class="{{ Request::segment(2) === 'mediaobject' ? 'active' : null }}"><a href="{{route('elements.mediaobject')}}">Media Object</a></li>
                        <li class="{{ Request::segment(2) === 'modals' ? 'active' : null }}"><a href="{{route('elements.modals')}}">Modals</a></li>
                        <li class="{{ Request::segment(2) === 'nestable' ? 'active' : null }}"><a href="{{route('elements.nestable')}}">Nestable</a></li>
                        <li class="{{ Request::segment(2) === 'progressbars' ? 'active' : null }}"><a href="{{route('elements.progressbars')}}">Progress Bars</a></li>
                        <li class="{{ Request::segment(2) === 'rangesliders' ? 'active' : null }}"><a href="{{route('elements.rangesliders')}}">Range Sliders</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'forms' ? 'active' : null }}">
                    <a href="#forms" class="has-arrow"><i class="fa fa-pencil"></i><span>Forms Elements</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'formsbasic' ? 'active' : null }}"><a href="{{route('forms.formsbasic')}}">Basic Elements</a></li>
                        <li class="{{ Request::segment(2) === 'advanced' ? 'active' : null }}"><a href="{{route('forms.advanced')}}">Advanced Elements</a></li>
                        <li class="{{ Request::segment(2) === 'validation' ? 'active' : null }}"><a href="{{route('forms.validation')}}">Form Validation</a></li>
                        <li class="{{ Request::segment(2) === 'wizard' ? 'active' : null }}"><a href="{{route('forms.wizard')}}">Form Wizard</a></li>
                        <li class="{{ Request::segment(2) === 'dragdropupload' ? 'active' : null }}"><a href="{{route('forms.dragdropupload')}}">Drag &amp; Drop Upload</a></li>
                        <li class="{{ Request::segment(2) === 'cropping' ? 'active' : null }}"><a href="{{route('forms.cropping')}}">Image Cropping</a></li>
                        <li class="{{ Request::segment(2) === 'summernote' ? 'active' : null }}"><a href="{{route('forms.summernote')}}">Summernote</a></li>
                        <li class="{{ Request::segment(2) === 'editors' ? 'active' : null }}"><a href="{{route('forms.editors')}}">CKEditor</a></li>
                        <li class="{{ Request::segment(2) === 'markdown' ? 'active' : null }}"><a href="{{route('forms.markdown')}}">Markdown</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'tables' ? 'active' : null }}">
                    <a href="#Tables" class="has-arrow"><i class="fa fa-table"></i><span>Tables</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'normal' ? 'active' : null }}"><a href="{{route('tables.normal')}}">Normal Tables</a></li>
                        <li class="{{ Request::segment(2) === 'datatable' ? 'active' : null }}"><a href="{{route('tables.datatable')}}">Jquery Datatables</a></li>
                        <li class="{{ Request::segment(2) === 'editable' ? 'active' : null }}"><a href="{{route('tables.editable')}}">Editable Tables</a></li>
                        <li class="{{ Request::segment(2) === 'tablecolor' ? 'active' : null }}"><a href="{{route('tables.tablecolor')}}">Tables Color</a></li>
                        <li class="{{ Request::segment(2) === 'filter' ? 'active' : null }}"><a href="{{route('tables.filter')}}">Table Filter</a></li>
                        <li class="{{ Request::segment(2) === 'dragger' ? 'active' : null }}"><a href="{{route('tables.dragger')}}">Table dragger</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'charts' ? 'active' : null }}">
                    <a href="#charts" class="has-arrow"><i class="fa fa-pie-chart"></i><span>Charts</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'apex' ? 'active' : null }}"><a href="{{route('charts.apex')}}">Apex Charts</a></li>
                        <li class="{{ Request::segment(2) === 'c_chart' ? 'active' : null }}"><a href="{{route('charts.c_chart')}}">C3 Charts</a></li>
                        <li class="{{ Request::segment(2) === 'morris' ? 'active' : null }}"><a href="{{route('charts.morris')}}">Morris Charts</a></li>
                        <li class="{{ Request::segment(2) === 'flot' ? 'active' : null }}"><a href="{{route('charts.flot')}}">Flot Charts</a></li>
                        <li class="{{ Request::segment(2) === 'chartjs' ? 'active' : null }}"><a href="{{route('charts.chartjs')}}">ChartJS Charts</a></li>
                        <li class="{{ Request::segment(2) === 'knob' ? 'active' : null }}"><a href="{{route('charts.knob')}}">Knob Charts</a></li>
                        <li class="{{ Request::segment(2) === 'sparkline' ? 'active' : null }}"><a href="{{route('charts.sparkline')}}">Sparkline Charts</a></li>
                    </ul>
                </li>
                
                <li class="header">More Pages</li>
                <li class="{{ Request::segment(2) === 'widget' ? 'active' : null }}"><a href="{{route('widgets.widget')}}"><i class="fa fa-puzzle-piece"></i><span>Widgets</span></a></li>
                
                <li class="{{ Request::segment(1) === 'pages' ? 'active' : null }}">
                    <a href="#Pages" class="has-arrow"><i class="fa fa-folder"></i><span>Pages</span></a>
                    <ul>
                        <li><a href="{{route('login')}}">Login</a></li>
                        <li><a href="{{route('authentication.register')}}">Register</a></li>
                        <li><a href="{{route('authentication.forgotpassword')}}">Forgot Password</a></li>
                        <li><a href="{{route('authentication.error404')}}">Page 404</a></li>
                        <li class="{{ Request::segment(2) === 'blank' ? 'active' : null }}"><a href="{{route('pages.blank')}}">Blank Page</a></li>
                        <li class="{{ Request::segment(2) === 'settings' ? 'active' : null }}"><a href="{{route('pages.settings')}}">Settings</a></li>
                        <li class="{{ Request::segment(2) === 'searchresults' ? 'active' : null }}"><a href="{{route('pages.searchresults')}}">Search Results</a></li>
                        <li class="{{ Request::segment(2) === 'profile' ? 'active' : null }}"><a href="{{route('pages.profile')}}">Profile</a></li>
                        <li class="{{ Request::segment(2) === 'invoices' ? 'active' : null }}"><a href="{{route('pages.invoices')}}">Invoices</a></li>
                        <li class="{{ Request::segment(2) === 'gallery' ? 'active' : null }}"><a href="{{route('pages.gallery')}}">Image Gallery</a></li>
                        <li class="{{ Request::segment(2) === 'timeline' ? 'active' : null }}"><a href="{{route('pages.timeline')}}">Timeline</a></li>
                        <li class="{{ Request::segment(2) === 'pricing' ? 'active' : null }}"><a href="{{route('pages.pricing')}}">Pricing</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'vectormap' ? 'active' : null }}"><a href="{{route('map.vectormap')}}"><i class="fa fa-map"></i> <span>jVector Maps</span></a></li>

                <li class="extra_widget">
                    <div class="form-group">
                        <label class="d-block">Traffic this Month <span class="float-right">77%</span></label>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%;"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Server Load <span class="float-right">50%</span></label>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
                        </div>
                    </div>
                </li> -->
            </ul>
        </nav>     
    </div>
</div>