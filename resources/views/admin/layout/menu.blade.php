@inject('admin', 'App\Admin')
@php($page = Request::segment(2))
 

<div class="admin-sidebar-brand">
	<!-- begin sidebar branding-->
	<span class="admin-brand-content font-secondary">
		<a href="{{ Asset(env('admin').'/home') }}">  
			<img src="{{ asset('assets/img/logo_black.png') }}" alt="">
		</a>
	</span>
	<!-- end sidebar branding-->
	 
</div>

<div class="admin-sidebar-wrapper js-scrollbar">
	<ul class="menu">
		<!-- Dashboard -->
		<li class="menu-item @if($page === 'home' || $page == 'setting' || $page == 'category' || $page == 'text' || $page == 'page') active opened @endif">
			<a href="#" class="open-dropdown menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-shape-outline "></i>
				</span>

				<span class="menu-label">
					<span class="menu-name">
						Dashboard {{$page}}
						<span class="menu-arrow"></span>
					</span>
				</span>
			</a>
			<!--submenu-->
			<ul class="sub-menu" @if($page === 'home' || $page == 'setting' || $page == 'category' || $page == 'text' || $page == 'page') style="display: block;" @endif>
				@if($admin->hasPerm('Dashboard - Inicio'))
				<li class="menu-item @if($page === 'home') active @endif">
					<a href="{{ Asset(env('admin').'/home') }}" class=" menu-link">
						<span class="menu-icon">
							<i class="icon-placeholder  mdi mdi-home"></i>
						</span>
						<span class="menu-label">
							<span class="menu-name">Inicio</span>
						</span>
					</a>
				</li>
				@endif

				@if($admin->hasPerm('Dashboard - Configuraciones'))
				<li class="menu-item @if($page === 'setting') active @endif">
					<a href="{{ Asset(env('admin').'/setting') }}" class=" menu-link">
						<span class="menu-icon">
							<i class="icon-placeholder  mdi mdi-message-settings-variant"></i>
						</span>
						<span class="menu-label">
							<span class="menu-name">Configuraciones</span>
						</span>
					</a>
				</li>
				@endif

				@if($admin->hasPerm('Dashboard - Categorias'))
				<li class="menu-item @if($page === 'category') active @endif">
					<a href="{{ Asset(env('admin').'/category') }}" class=" menu-link">
						<span class="menu-icon">
							<i class="icon-placeholder  mdi mdi-message-settings-variant"></i>
						</span>
						<span class="menu-label">
							<span class="menu-name">Categorias</span>
						</span>
					</a>
				</li>
				@endif
 
				@if($admin->hasPerm('Paginas de la aplicacion'))
				<li class="menu-item @if($page === 'page') active @endif">
					<a href="{{ Asset(env('admin').'/page/add') }}" class="menu-link">
						<span class="menu-icon">
							<i class="mdi mdi-file"></i>
						</span>
						<span class="menu-label"><span class="menu-name">Páginas de aplicaciones</span></span>
					</a>
				</li>
				@endif
			</ul>
		</li>
		<!-- Dashboard -->
  
		<!-- Banners -->
		@if($admin->hasPerm('Banners'))
		<li class="menu-item @if($page === 'banner') active @endif">
			<a href="{{ Asset(env('admin').'/banner') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-image-filter "></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">
						Banners
					</span>
				</span> 
			</a>
		</li>
		@endif
	 	<!-- Banners -->
 
		<!-- Negocios -->
		@if($admin->hasPerm('Adminisrtar Restaurantes'))
		<li class="menu-item @if($page === 'user') active @endif">
			<a href="{{ Asset(env('admin').'/user') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-home"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Administrar Restaurantes</span>
				</span>
			</a>
		</li>
		@endif
		<!-- Negocios -->
  
		<!-- Notificaciones push -->
		@if($admin->hasPerm('Notificaciones push'))
		<li class="menu-item @if($page === 'push') active @endif">
			<a href="{{ Asset(env('admin').'/push') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-send "></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">
						Notificaciones
					</span>
				</span>
			</a>
		</li>
		@endif
		<!-- Notificaciones push -->

		<!-- Usuarios -->
		@if($admin->hasPerm('Usuarios Registrados'))
		<li class="menu-item @if($page === 'appUser' || $page == 'report_users') active @endif">
			<a href="#" class="open-dropdown menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-account"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Usuarios Registrados
						<span class="menu-arrow"></span>
					</span>
				</span>
			</a>
			<!--submenu-->
			<ul class="sub-menu">
				<li class="menu-item">
					<a href="{{ Asset(env('admin').'/appUser') }}" class=" menu-link">
						<span class="menu-icon">
							<i class="icon-placeholder  mdi mdi-image-filter"></i>
						</span>
						<span class="menu-label">
							<span class="menu-name">Listado</span>
						</span>
					</a>
				</li>

				<li class="menu-item ">
					<a href="{{ Asset(env('admin').'/report_users') }}" class=" menu-link">
						<span class="menu-icon">
							<i class="icon-placeholder  mdi mdi-image"></i>
						</span>
						<span class="menu-label">
							<span class="menu-name">Reportes</span>
						</span>
					</a>
				</li>
			</ul>
		</li>
		@endif
		<!-- Usuarios -->

		<!-- Cerrar Sesión -->
		<li class="menu-item">
			<a href="{{ Asset(env('admin').'/logout') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-logout"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Cerrar Sesion</span>
				</span>
				
			</a>
		</li>
		<!-- Cerrar Sesión -->
	</ul>
</div>
