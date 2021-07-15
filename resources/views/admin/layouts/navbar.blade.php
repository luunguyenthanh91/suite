<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="/admin" class="navbar-brand ">
						<small>
							<img class="logo_header" src="{{ asset('templates/images/favicon.ico') }}">
						</small>
					</a>
				</div>
				<div class="navbar-header hidden-768 col-xs-4 text-right" style="line-height:45px;height:45px;vertical-align:middle;">
						<a target="_blank" href="#">
							<span class="white ng-binding">Hỗ trợ&nbsp; | &nbsp;</span>
						</a>
						<a class="hidden-922" href="#">
							<span class="white ng-binding">Tải Teamviewer &nbsp; | &nbsp;</span>
						</a>
						<span class="white">Hotline: <span class="bolder orange-2">0932.755.722</span></span>
				</div>
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="{{ asset('assets/avatars/user.jpg') }}" alt="Jason's Photo" />
								<span class="user-info">
									<small>{{ Auth::guard('admin')->user()->name }}</small>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="/admin/authentication/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>