<div class="mdk-drawer js-mdk-drawer" id="default-drawer"> 
    <div class="mdk-drawer__content" style="margin-bottom:-2px;">
        <table style="background:#AF002A;height:100%;border:0px;margin:-1px;" cellspacing="0">
            <tr>
                <td style="width:27px; text-align: left ; vertical-align: top ; ">
                    <button class="btnToggleMenu" type="button" style="margin-left:-8px" >
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left" style="color:red;background:white;width:26px;height:26px;">dashboard</span>
                    </button>
                </td>
                <td  style="height:100%; " id="leftTD">
                    <div id="headerContent" class="sidebar sidebar-black-dodger-blue sidebar-left" data-perfect-scrollbar  style="margin-left:-27px">
                        <div class="sidebar-heading" style="margin-top:8px;margin-right:-20px;margin-left:-20px;">
                            <span class="rounded">
                                 <img style="width:26px;height:26px;" src="{{ asset('assets/images/alphacep_icon.png') }}" alt="logo" class="img-fluid"/>
                                <img style="width:180px;height:25px;" src="{{ asset('assets/images/logofinish-1-7-13.png') }}" alt="logo" class="img-fluid" />
                            </span>
                        </div>
                        <ul class="sidebar-menu ">
                            <li class="sidebar-menu-item {{ (request()->is('admin')) ? 'active open' : '' }} ">
                                <a class="sidebar-menu-button" href="/admin">
                                    
                                    ダッシュボード
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{ (request()->is('*company')) ? 'active open' : '' }} ">
                                <a class="sidebar-menu-button" href="/admin/project">
                                    <span class="sidebar-menu-text">1 - 案件一覧</span>
                                </a>
                            </li>


                            <li class="sidebar-menu-item
                            {{ (request()->is('*calendar*')) ? 'active open' : '' }}
                            {{ (request()->is('*projectnew*')) ? 'active open' : '' }}
                            ">
                                <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#report-col" aria-expanded="false">
                                    <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                    2 - 受注管理
                                    <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                </a>
                                <ul class="sidebar-submenu sm-indent collapse" id="report-col" style="">
                                    <li class="sidebar-menu-item {{ (request()->is('*/projectnew')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/projectnew">
                                            <span class="sidebar-menu-text">A - 案件登録</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*/calendar')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/calendar">
                                            <span class="sidebar-menu-text">B - カレンダー</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-menu-item
                            {{ (request()->is('*list-sale*')) ? 'active open' : '' }}
                            {{ (request()->is('*partner-interpreter*')) ? 'active open' : '' }}
                            {{ (request()->is('*move-fee*')) ? 'active open' : '' }}
                            {{ (request()->is('*bank-fee*')) ? 'active open' : '' }}
                            {{ (request()->is('*list-taxpd*')) ? 'active open' : '' }}
                            ">
                                <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#report-col2" aria-expanded="false">
                                    <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                    3 - 経費管理
                                    <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                </a>
                                <ul class="sidebar-submenu sm-indent collapse" id="report-col2" style="">
                                    <li class="sidebar-menu-item {{ (request()->is('*/company/list-sale')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/company/list-sale">
                                        <span class="sidebar-menu-text">A - 営業報酬支給</span>
                                        </a>
                                    </li>  
                                    <li class="sidebar-menu-item {{ (request()->is('*/partner-interpreter')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/partner-interpreter">
                                            <span class="sidebar-menu-text">B - 通訳給与支給</span>            
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*/move-fee')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/move-fee">
                                            <span class="sidebar-menu-text">C - 交通費</span>
                                        </a>
                                    </li> 
                                    <li class="sidebar-menu-item {{ (request()->is('*/bank-fee')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/bank-fee">
                                        <span class="sidebar-menu-text">D - 振込手数料</span>
                                        </a>
                                    </li> 
                                    <li class="sidebar-menu-item {{ (request()->is('*/company/list-taxpd')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/company/list-taxpd">
                                        <span class="sidebar-menu-text">E - 通訳所得源泉徴収</span>
                                        </a>
                                    </li>    
                                </ul>
                            </li>

                            <li class="sidebar-menu-item {{ (request()->is('*/company/list-pay')) ? 'active open' : '' }}">
                                <a class="sidebar-menu-button" href="/admin/company/list-pay">

                                    <span class="sidebar-menu-text">4 - 入金</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item
                            {{ (request()->is('*earnings*')) ? 'active open' : '' }}
                            {{ (request()->is('*cost*')) ? 'active open' : '' }}
                            {{ (request()->is('*benefit*')) ? 'active open' : '' }}
                            ">
                                <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#report-col4" aria-expanded="false">
                                    <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                    5 - 営業管理
                                    <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                </a>
                                <ul class="sidebar-submenu sm-indent collapse" id="report-col4" style="">
                                    <li class="sidebar-menu-item {{ (request()->is('*earnings')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/earnings">
                                            <span class="sidebar-menu-text">A - 売上</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*/cost')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/cost">
                                        <span class="sidebar-menu-text">B - 支給</span>
                                        </a>
                                    </li> 
                                    <li class="sidebar-menu-item {{ (request()->is('*benefit')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/benefit">
                                            <span class="sidebar-menu-text">C - 利益</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-menu-item
                            {{ (request()->is('*collaborators*')) ? 'active open' : '' }}
                            {{ (request()->is('*ctvjobs*')) ? 'active open' : '' }}
                            {{ (request()->is('*cusjobs*')) ? 'active open' : '' }}
                            ">
                                <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#report-col6" aria-expanded="false">
                                    <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                    6 - マスターデータ管理
                                    <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                </a>
                                <ul class="sidebar-submenu sm-indent collapse" id="report-col6" style="">

                                    <li class="sidebar-menu-item {{ (request()->is('*cusjobs*')) ? 'active open' : '' }} ">
                                        <a class="sidebar-menu-button" href="/admin/cusjobs">
                                            <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                            <span class="sidebar-menu-text">A - 顧客</span>
                                        
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*ctvjobs*')) ? 'active open' : '' }} ">
                                        <a class="sidebar-menu-button" href="/admin/ctvjobs">
                                            <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                        
                                        <span class="sidebar-menu-text">B - 営業者</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*collaborators')) ? 'active open' : '' }} ">
                                        <a class="sidebar-menu-button" href="/admin/collaborators">
                                        <span class="sidebar-menu-text">C - 通訳者</span>
                                    
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                        
                            <li class="sidebar-menu-item
                            {{ (request()->is('*chart-report-jobs*')) ? 'active open' : '' }}
                            {{ (request()->is('*report-day*')) ? 'active open' : '' }}
                            {{ (request()->is('*report-district*')) ? 'active open' : '' }}
                            ">
                                <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#report-col7" aria-expanded="false">
                                    <!-- <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left icon-image-preview">supervisor_account</span> -->
                                    7 - レポート
                                    <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                </a>
                                <ul class="sidebar-submenu sm-indent collapse" id="report-col7" style="">
                                    <li class="sidebar-menu-item {{ (request()->is('*chart-report-jobs*')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/chart-report-jobs">
                                            <span class="sidebar-menu-text">6 - 売上集計</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*report-day*')) ? 'active open' : '' }}">
                                            <a class="sidebar-menu-button" href="/admin/collaborators/report-day">

                                            <span class="sidebar-menu-text">B - 通訳者集計</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ (request()->is('*report-district*')) ? 'active open' : '' }}">
                                        <a class="sidebar-menu-button" href="/admin/collaborators/report-district">

                                            <span class="sidebar-menu-text">通訳者集計（都道府県集計）</span>
                                        </a>
                                    </li> 
                                </ul>
                            </li>
                        </ul>

                    <!-- // END Sidebar Content -->
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>



