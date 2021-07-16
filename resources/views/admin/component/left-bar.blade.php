<div class="mdk-drawer js-mdk-drawer" id="default-drawer"> 
    <div class="mdk-drawer__content" style="margin-bottom:-2px;">
        <div id="headerContent" class="sidebar sidebar-black-dodger-blue sidebar-left" data-perfect-scrollbar>
            <ul class="sidebar-menu ">
                <li class="sidebar-menu-item {{ (request()->is('admin')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button" href="/admin" style="margin-left:-5px;">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
                        ホーム
                    </a>
                </li>

                <!-- <li class="sidebar-menu-item active open
                {{ (request()->is('*company*')) ? 'active open' : '' }}
                {{ (request()->is('*calendar*')) ? 'active open' : '' }}
                {{ (request()->is('*projectnew*')) ? 'active open' : '' }}
                "> -->
                <li class="sidebar-menu-item active open">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#report-col" aria-expanded="false">
                        <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                        1 - 経費管理
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="report-col" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*expenses*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/expenses">
                                <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                <span class="sidebar-menu-text">1- 経費支払月管理表</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>



