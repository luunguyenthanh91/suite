<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				

				<ul class="nav nav-list">
					<li class="{{ @$menu_active === 'dashboard' ? 'active' : null }}">
						<a href="/admin">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Tổng quan </span>
						</a>
					</li>
					<li class="{{ @$menu_active === 'phep' ? 'active' : null }}">
						<a href="{{route('admin.listPhep')}}">
							<i class="menu-icon fa fa-arrow-circle-right" aria-hidden="true"></i>
							<span class="menu-text"> Phép </span>
						</a>
					</li>
					<li class="{{ @$menu_active === 'do' ? 'active' : null }}">
						<a href="{{route('admin.listDo')}}">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Đồ </span>
						</a>
					</li>
					<li class="{{ @$menu_parent_active == 'users-group' ? 'active' : null }}">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text"> Bổ Trợ </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="{{ @$menu_active === 'roles' ? 'active' : null }}">
								<a href="{{route('admin.listPhep')}}">
									<i class="menu-icon fa fa-users"></i>
									Nhóm Bổ Trợ
								</a>

								<b class="arrow"></b>
							</li>
							<li class="{{ @$menu_active === 'users' ? 'active' : null }}">
								<a href="{{route('admin.listUser')}}">
									<i class="menu-icon fa fa-user"></i>
									Bổ Trợ
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					

					

				</ul>

				<!-- <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div> -->

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>