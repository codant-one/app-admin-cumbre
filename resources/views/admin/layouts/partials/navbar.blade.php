<div id="kt_header" class="header align-items-stretch">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
			<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <span>
                    <i class="fas fa-bars"></i>
                </span>
			</div>
		</div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<a href="{{ route('dashboard.index') }}" class="d-lg-none">
		        <img alt="Logo" src="{{ asset(env('DOMAIN_LOGO_URL')) }}" style="height: 20px" />
			</a>
		</div>
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            @include('shared.breadcrumbs',['title' => $title, 'breadcrumbs' => $breadcrumbs] )
            <div class="d-flex align-items-stretch flex-shrink-0">
                <div class="d-flex align-items-stretch flex-shrink-0">                    
                    <!-- <div class="d-flex align-items-center ms-1 ms-lg-3">
					    <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px" id="kt_drawer_chat_toggle">
							<span>
                                <i class="fas fa-bell icon-10x"></i>
                            </span>
							<span class="bullet bullet-dot bg-info h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
						</div>
					</div> -->
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                            @if(is_null(auth()->user()->avatar))
                                <img alt="image" src="{{ asset('/images/placeholders/user.png') }}"/>
                            @else
                                <img alt="image" src="{{ asset('storage/uploads/'.auth()->user()->avatar) }}"/>
                            @endif
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        @if(is_null(auth()->user()->avatar))
                                            <img alt="image" src="{{ asset('/images/placeholders/user.png') }}"/>
                                        @else
                                            <img alt="image" src="{{ asset('storage/uploads/'.auth()->user()->avatar) }}"/>
                                        @endif
                                    </div>
                                    <!-- <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
										<div class="symbol-label fs-3 bg-light-primary text-primary">{{ auth()->user()->name[0] }}</div>
									</div> -->
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder d-flex align-items-center fs-5">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <span class="fw-bold text-muted fs-7" style="word-break: break-all;"> {{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
								<a href="{{ route('profile') }}" class="menu-link px-5">Mi Perfil</a>
							</div>
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
                                <a href="{{ route('auth.admin.logout') }}" class="menu-link px-5">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
	</div>
</div>
