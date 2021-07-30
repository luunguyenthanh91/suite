
<div class="mdk-drawer js-mdk-drawer" id="default-drawer"> 
    <div class="mdk-drawer__content">
        <div id="headerContent" class="sidebar sidebar-black-dodger-blue sidebar-left" data-perfect-scrollbar>
            <ul class="sidebar-menu ">
                <li class="sidebar-menu-item {{ (request()->is('admin')) ? 'active open' : '' }} ">
                    <a class="sidebar-menu-button" href="/admin" style="margin-left:-5px;">
                        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">home</span>
                            ホーム
                    </a>
                </li>
                <li class="sidebar-menu-item 
                    {{ (request()->is('*expenses')) ? 'active open' : '' }}
                    {{ (request()->is('*expenseslist')) ? 'active open' : '' }}
                    {{ (request()->is('*expensesitemnew')) ? 'active open' : '' }}
                    ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#expense-col" aria-expanded="false">
                      1 - 経費管理
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="expense-col" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*expenses')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/expenses">
                                <span class="sidebar-menu-text">A- 支払月報</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*expenseslist*')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/expenseslist">
                                <span class="sidebar-menu-text">B- 科目一覧</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*expensesitemnew')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/expensesitemnew">
                                <span class="sidebar-menu-text">C- 科目登録</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-menu-item 
                    {{ (request()->is('*project*')) ? 'active open' : '' }}
                    {{ (request()->is('calendar')) ? 'active open' : '' }}
                    ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-project" aria-expanded="false">
                        2 - 売上管理
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-project" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*project')) ? 'active open' : '' }} ">
                            <a class="sidebar-menu-button" href="/admin/project">
                                <span class="sidebar-menu-text">A - 案件一覧表</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*/projectnew')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" data-toggle="modal" data-target="#createProject">
                                <span class="sidebar-menu-text">B - 新規登録</span>
                            </a>
                        </li>
                        <li class="sidebar-menu-item {{ (request()->is('*/calendar')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/calendar">
                                <span class="sidebar-menu-text">C - カレンダー</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="sidebar-menu-item 
                    {{ (request()->is('*user*')) ? 'active open' : '' }}
                    ">
                    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#col-cost" aria-expanded="false">
                        3 - 人事管理
                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                    </a>
                    <ul class="sidebar-submenu sm-indent collapse" id="col-cost" style="">
                        <li class="sidebar-menu-item {{ (request()->is('*/user*')) ? 'active open' : '' }}">
                            <a class="sidebar-menu-button" href="/admin/user/list">
                            <span class="sidebar-menu-text">A - 従業員一覧</span>
                            </a>
                        </li> 
                    </ul>
                </li>

                <div class="logout-btn" style="border-top:1px solid gray;margin-left:0px;">
                    <a href="{{route('admin-logout')}}" class="btn btn-outline-secondary" style="margin-top:10px;">
                    <i class="fas fa-sign-out-alt"></i><span class="labelButtonDropMenu">ログアウト</span>
                    </a>
                </div>
            </ul>
        </div>
    </div>
</div>



<script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function (){
        $('#link-map-address').on('click',function() {
            var address = $('#address').val();
            if (address.trim() == '') {
                alert("Nhập địa chỉ.");
                return false;
            }
            var win = window.open('https://www.google.com/maps/place/'+address, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        });
        $('#link-map-po').on('click',function() {
            var addressPo = $('#address-po').val();
            if (addressPo.trim() == '') {
                alert("Nhập địa chỉ.");
                return false;
            }
            var win = window.open('https://www.google.com/maps/place/'+addressPo, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        });
        $('#link-map-proj').on('click',function() {
            var addressPo = $('#addressProj').val();
            if (addressPo.trim() == '') {
                alert("Nhập địa chỉ.");
                return false;
            }
            var win = window.open('https://www.google.com/maps/place/'+addressPo, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        });
        $("#sale_price_po").on("change", function() {
            var flagPrice = $('#sale_price_po').val();
            flagPrice = parseInt(flagPrice.replace('￥' , '').replace(',', '').replace('.',''));
            if (flagPrice) {
                flagPrice = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(flagPrice);
            } else {
                flagPrice = '';
            }
            $('#sale_price_po').val(flagPrice);
        });

        $("#tienphiendich").on("change", function() {
            var flagPrice = $('#tienphiendich').val();
            flagPrice = parseInt(flagPrice.replace('￥' , '').replace(',', '').replace('.',''));
            $('#tienphiendichdata').val(flagPrice);
            if (flagPrice) {
                $('#tienphiendichdata').val(flagPrice);
                flagPrice = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(flagPrice);
            } else {
                flagPrice = '';
                $('#tienphiendichdata').val(flagPrice);
            }
            $('#tienphiendich').val(flagPrice);
        });

        $("#price_po").on("change", function() {
            var flagPrice = $('#price_po').val();
            flagPrice = parseInt(flagPrice.replace('￥' , '').replace(',', '').replace('.',''));
            if (flagPrice) {
                flagPrice = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(flagPrice);
            } else {
                flagPrice = '';
            }
            $('#price_po').val(flagPrice);
        });
        
        $('#listDatePo').datepick({ 
            multiSelect: 999, 
            minDate: 0,
            dateFormat: 'yyyy-mm-dd',
            monthsToShow: 1,
            onSelect: function(dateText, inst) {
                $(this).change();
            }
        });
        $('#listDatePo').change(function(event) {
            $cntDay = this.value.split(',').length;
            $('#txtCountDayPo').text("（日数: " + $cntDay + "）");
        });

        $('#listDateProj').datepick({ 
            multiSelect: 999, 
            minDate: 0,
            dateFormat: 'yyyy-mm-dd',
            monthsToShow: 1,
            onSelect: function(dateText, inst) {
                $(this).change();
            }
        });
        $('#listDateProj').change(function(event) {
            $cntDay = this.value.split(',').length;
            $('#txtCountDay').text("（日数: " + $cntDay + "）");
        });

        CKFinder.setupCKEditor( null, '/lib_upload/ckfinder/' );
        
    });
</script>
