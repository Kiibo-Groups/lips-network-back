@inject('admin', 'App\Models\Admin')
@php($page = Request::segment(2))
 

<div class="admin-sidebar-brand">
	<!-- begin sidebar branding-->
	<span class="admin-brand-content font-secondary">
		<a href="{{ Asset(env('admin').'/home') }}">  
			<img src="{{ asset('assets/img/logo_black.png') }}" alt="logo" style="max-width: 50%;">
		</a>
	</span>
	<!-- end sidebar branding-->
	 
</div>

<div class="admin-sidebar-wrapper js-scrollbar">
	<ul class="menu">
		<!-- Dashboard -->
		<li class="menu-item @if($page === 'home' || $page == 'setting') active opened @endif">
			<a href="#" class="open-dropdown menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-shape-outline "></i>
				</span>

				<span class="menu-label">
					<span class="menu-name">
						Dashboard
						<span class="menu-arrow"></span>
					</span>
				</span>
			</a>
			<!--submenu-->
			<ul class="sub-menu" @if($page === 'home' || $page == 'setting') style="display: block;" @endif>
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
			</ul>
		</li>
		<!-- Dashboard -->

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
  
		<!-- Banners  
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
	 	 Banners -->
 
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

		

		<!-- Negocios  
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
		  Negocios -->
  
		
		<!-- Tickets --> 
		<li class="menu-item @if($page === 'tickets') active @endif">
			<a href="{{ Asset(env('admin').'/tickets') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-ticket"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Gestion de Ticket's</span>
				</span>
			</a>
		</li> 
		<!-- Tickets -->
  
		<!-- LeaderBoard --> 
		<li class="menu-item @if($page === 'leaderboard') active @endif">
			<a href="{{ Asset(env('admin').'/leaderboard') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-ticket"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Tabla de Clasificaciones</span>
				</span>
			</a>
		</li> 
		<!-- LeaderBoard -->

		
		<!-- LeaderBoard --> 
		<li class="menu-item @if($page === 'rewards') active @endif">
			<a href="{{ Asset(env('admin').'/rewards') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-cash"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Recompensas</span>
				</span>
			</a>
		</li> 
		<!-- LeaderBoard -->

		<!-- Solicitudes de retiro --> 
		<li class="menu-item @if($page === 'withdrawal') active @endif">
			<a href="{{ Asset(env('admin').'/withdrawal') }}" class="menu-link">
				<span class="menu-icon">
					<i class="icon-placeholder mdi mdi-cash"></i>
				</span>
				<span class="menu-label">
					<span class="menu-name">Solicitudes de retiro</span>
				</span>
			</a>
		</li> 
		<!-- Solicitudes de retiro -->


 
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

				{{-- <li class="menu-item ">
					<a href="{{ Asset(env('admin').'/report_users') }}" class=" menu-link">
						<span class="menu-icon">
							<i class="icon-placeholder  mdi mdi-image"></i>
						</span>
						<span class="menu-label">
							<span class="menu-name">Reportes</span>
						</span>
					</a>
				</li> --}}
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
