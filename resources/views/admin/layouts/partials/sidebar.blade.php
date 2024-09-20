<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
	<div class="aside-logo flex-column-auto" id="kt_aside_logo">
		<a href="{{ route('dashboard.index') }}" class="d-flex justify-content-start align-end">
			<img alt="Logo"  src="{{ asset(env('DOMAIN_LOGO_URL_WHITE')) }}" class="logo" style="height: 35px" />
			<span class="text-white logo ms-3 title-sidebar">VII CUMBRE<span/>
		</a>
		<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-info aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
			 <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
			</span>
		</div>
	</div>


	<div class="aside-menu flex-column-fluid">
		<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
			<div class="menu menu-column menu-title-gray-800 menu-state-title-info menu-state-icon-info menu-state-bullet-info menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
				<div class="menu-item">
					<div class="menu-content pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">Inicio</span>
					</div>
				</div>

                <div class="menu-item">
					<a class="menu-link active" href="{{ route('dashboard.index') }}">
                        <span class="menu-icon">
							<i class="fa fa-home fs-4"></i>
                        </span>
                        <span class="menu-title">Inicio</span>
					</a>
				</div>

				<!-- ADMINISTRACIÓN -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">ADMINISTRACIÓN</span>
					</div>
				</div>

				<!-- USUARIOS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-users fs-4"></i>
						</span>
						<span class="menu-title">Usuarios</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link" href="{{ route('users.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link" href="{{ route('users.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!-- ROLES Y PERMISOS -->
				<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion">	
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-users-cog fs-4"></i>
						</span>
						<span class="menu-title">Roles y permisos</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1"> -->
						<!-- ROLES -->
						<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-icon">
									<i class="fa fa-user-tie fs-4"></i>
								</span>
								<span class="menu-title">Roles</span>
								<span class="menu-arrow"></span>
							</span>

							<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
								<div class="menu-item">
									<a class="menu-link" href="{{ route('roles.create') }}">
										<span class="menu-icon">
											<i class="fa fa-plus-circle"></i>
										</span>
										<span class="menu-title">Agregar Nuevo</span>
									</a>
								</div>
								<div class="menu-item">
									<a class="menu-link" href="{{ route('roles.index') }}">
										<span class="menu-icon">
											<i class="fa fa-list-ol"></i>
										</span>
										<span class="menu-title">Ver Todos</span>
									</a>
								</div>
							</div>
						</div> -->

						<!-- PERMISOS -->
						<!--<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-icon">
									<i class="fa fa-user-lock fs-4"></i>
								</span>
								<span class="menu-title">Permisos</span>
								<span class="menu-arrow"></span>
							</span>

							<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
								<div class="menu-item">
									<a class="menu-link" href="{{ route('users.create') }}">
										<span class="menu-icon">
											<i class="fa fa-plus-circle"></i>
										</span>
										<span class="menu-title">Agregar Nuevo</span>
									</a>
								</div>
								<div class="menu-item">
									<a class="menu-link" href="{{ route('users.index') }}">
										<span class="menu-icon">
											<i class="fa fa-list-ol"></i>
										</span>
										<span class="menu-title">Ver Todos</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div> -->

				<!-- MÓDULOS -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">MÓDULOS</span>
					</div>
				</div>

				<!--LUGARES -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-map-marker-alt fs-4"></i>
						</span>
						<span class="menu-title">Lugares</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link" href="{{ route('places.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link" href="{{ route('places.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!--NOTICIAS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-newspaper fs-4"></i>
						</span>
						<span class="menu-title">Noticias</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link" href="{{ route('news.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item">
							<a class="menu-link" href="{{ route('news.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
