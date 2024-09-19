<div class="toolbar" id="kt_toolbar">
	<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
		<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
			<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
				@if($title == 'Dashboard')
					Panel
					<span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
						<small class="text-muted fs-7 fw-bold my-1 ms-1">{{ auth()->user()->getRoleNames()[0]  }}</small>
				@else
					@if(isset($filter) && $filter == 'all')
						<small class="text-muted fs-7 fw-bold my-1 ms-1">Todos los Obituarios</small>
					@elseif(isset($filter) && $filter != 'all')
						<small class="text-muted fs-7 fw-bold my-1 ms-1">Obituarios por {{ $filter }}</small>
					@endif
				@endif				
			</h1>
		</div>
		<div class="d-flex align-items-center py-1">			
			<a href="{{ route('dashboard.index') }}" id="today" class="btn btn-active-light-info btn-color-muted btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Día
            </a>
			<a href="{{ route('dashboard.index', ['filter' => 'current_month']) }}" id="current_month" class="btn btn-active-light-info btn-color-muted btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
				 Mes
            </a>
			<a href="{{ route('dashboard.index', ['filter' => 'current_year']) }}" id="current_year" class="btn btn-active-light-info btn-color-muted btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Año
            </a>
            <a href="#" id="reportrange" class="btn btn-active-light-info btn-color-muted btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </a>
		</div>
	</div>
</div>

