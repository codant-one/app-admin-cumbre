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
					<a class="menu-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                        <span class="menu-icon">
							<i class="fa fa-home fs-4"></i>
                        </span>
                        <span class="menu-title">Inicio</span>
					</a>
				</div>

				<div class="menu-item mt-1">
					<a class="menu-link {{ request()->routeIs('clients.index') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                        <span class="menu-icon">
							<i class="fa fa-user-tie fs-4"></i>
                        </span>
                        <span class="menu-title">Clientes</span>
					</a>
				</div>

				<!-- ADMINISTRACIÓN -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">ADMINISTRACIÓN</span>
					</div>
				</div>

				<!-- USUARIOS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('users.create') || request()->routeIs('users.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-users fs-4"></i>
						</span>
						<span class="menu-title">Usuarios</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
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

				<!-- TIPOS DE CATEGORIAS -->
				<div data-kt-menu-trigger="click" 
					class="menu-item menu-accordion mt-1 {{ request()->routeIs('category-types.create') || request()->routeIs('category-types.index') || request()->routeIs('categories.create') || request()->routeIs('categories.index') ? 'hover show' : '' }}">	
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-sitemap fs-4"></i>
						</span>
						<span class="menu-title">Categorías</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
					<!-- TIPOS DE CATEGORIAS -->
						<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('category-types.create') || request()->routeIs('category-types.index') ? 'hover show' : '' }}">
							<span class="menu-link">
								<span class="menu-icon">
									<i class="fa fa-sitemap fs-4"></i>
								</span>
								<span class="menu-title">Tipos de categorías</span>
								<span class="menu-arrow"></span>
							</span>

							<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
								<div class="menu-item">
									<a class="menu-link {{ request()->routeIs('category-types.create') ? 'active' : '' }}" href="{{ route('category-types.create') }}">
										<span class="menu-icon">
											<i class="fa fa-plus-circle"></i>
										</span>
										<span class="menu-title">Agregar Nuevo</span>
									</a>
								</div>
								<div class="menu-item mt-1">
									<a class="menu-link {{ request()->routeIs('category-types.index') ? 'active' : '' }}" href="{{ route('category-types.index') }}">
										<span class="menu-icon">
											<i class="fa fa-list-ol"></i>
										</span>
										<span class="menu-title">Ver Todos</span>
									</a>
								</div>
							</div>
						</div>

						<!-- CATEGORIAS -->
						<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('categories.create') || request()->routeIs('categories.index') ? 'hover show' : '' }}">
							<span class="menu-link">
								<span class="menu-icon">
									<i class="fa fa-shapes fs-4"></i>
								</span>
								<span class="menu-title">Categorías</span>
								<span class="menu-arrow"></span>
							</span>

							<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
								<div class="menu-item">
									<a class="menu-link {{ request()->routeIs('categories.create') ? 'active' : '' }}" href="{{ route('categories.create') }}">
										<span class="menu-icon">
											<i class="fa fa-plus-circle"></i>
										</span>
										<span class="menu-title">Agregar Nuevo</span>
									</a>
								</div>
								<div class="menu-item mt-1">
									<a class="menu-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">
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

				<!--CARGOS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('positions.create') || request()->routeIs('positions.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-user-tie fs-4"></i>
						</span>
						<span class="menu-title">Cargos</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('positions.create') ? 'active' : '' }}" href="{{ route('positions.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('positions.index') ? 'active' : '' }}" href="{{ route('positions.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!--AGENDA -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('schedules.create') || request()->routeIs('schedules.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-calendar-alt fs-4"></i>
						</span>
						<span class="menu-title">Agenda</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('schedules.create') ? 'active' : '' }}" href="{{ route('schedules.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('schedules.index') ? 'active' : '' }}" href="{{ route('schedules.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!--CHARLAS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('talks.create') || request()->routeIs('talks.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-podium-star fs-4"></i>
						</span>
						<span class="menu-title">Charlas</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('talks.create') ? 'active' : '' }}" href="{{ route('talks.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('talks.index') ? 'active' : '' }}" href="{{ route('talks.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!-- CONFIGURACIÓN -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">CONFIGURACIÓN</span>
					</div>
				</div>

				<!--NOTIFICACIONES -->
				<div class="menu-item mt-1">
					<a class="menu-link {{ request()->routeIs('publicNotifications') ? 'active' : '' }}" href="{{ route('publicNotifications') }}">
                        <span class="menu-icon">
							<i class="fa fa-comment-alt fs-4"></i>
                        </span>
                        <span class="menu-title">Notificaciones Publicas</span>
					</a>
				</div>

				<div class="menu-item mt-1">
					<a class="menu-link {{ request()->routeIs('notifications') ? 'active' : '' }}" href="{{ route('notifications') }}">
                        <span class="menu-icon">
							<i class="fa fa-comment-alt-edit fs-4"></i>
                        </span>
                        <span class="menu-title">Notificaciones Personalizadas</span>
					</a>
				</div>


				<div class="menu-item">
					<a class="menu-link {{ request()->routeIs('map') ? 'active' : '' }}" href="{{ route('map') }}">
                        <span class="menu-icon">
							<i class="fa fa-map-marked fs-4"></i>
                        </span>
                        <span class="menu-title">Mapa</span>
					</a>
				</div>

				<div class="menu-item mt-1">
					<a class="menu-link {{ request()->routeIs('translations') ? 'active' : '' }}" href="{{ route('translations') }}">
                        <span class="menu-icon">
							<i class="fa fa-language fs-4"></i>
                        </span>
                        <span class="menu-title">Traducciones</span>
					</a>
				</div>

				<!-- MÓDULOS -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">MÓDULOS</span>
					</div>
				</div>

				<!--LUGARES -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('places.create') || request()->routeIs('places.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-map-marker-alt fs-4"></i>
						</span>
						<span class="menu-title">Lugares</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('places.create') ? 'active' : '' }}" href="{{ route('places.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('places.index') ? 'active' : '' }}" href="{{ route('places.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!--NOTICIAS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('news.create') || request()->routeIs('news.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-newspaper fs-4"></i>
						</span>
						<span class="menu-title">Noticias</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('news.create') ? 'active' : '' }}" href="{{ route('news.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('news.index') ? 'active' : '' }}" href="{{ route('news.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!--PATROCINADORES -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('sponsors.create') || request()->routeIs('sponsors.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-handshake fs-4"></i>
						</span>
						<span class="menu-title">Patrocinadores</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('sponsors.create') ? 'active' : '' }}" href="{{ route('sponsors.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('sponsors.index') ? 'active' : '' }}" href="{{ route('sponsors.index') }}">
								<span class="menu-icon">
									<i class="fa fa-list-ol"></i>
								</span>
								<span class="menu-title">Ver Todos</span>
							</a>
						</div>
					</div>
				</div>

				<!--PANELISTAS -->
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-1 {{ request()->routeIs('speakers.create') || request()->routeIs('speakers.index') ? 'hover show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="fa fa-user-chart fs-4"></i>
						</span>
						<span class="menu-title">Panelistas</span>
						<span class="menu-arrow"></span>
					</span>

					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('speakers.create') ? 'active' : '' }}" href="{{ route('speakers.create') }}">
								<span class="menu-icon">
									<i class="fa fa-plus-circle"></i>
								</span>
								<span class="menu-title">Agregar Nuevo</span>
							</a>
						</div>
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('speakers.index') ? 'active' : '' }}" href="{{ route('speakers.index') }}">
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
