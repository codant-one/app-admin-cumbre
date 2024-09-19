<div class="d-flex align-items-center" id="kt_header_nav">
    <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
		<h1 class="d-flex align-items-center text-primary fw-bolder fs-3 my-1">{{ $title }}</h1>
		<span class="h-20px border-gray-200 border-start mx-4"></span>
		<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
            @foreach ($breadcrumbs as $route => $item)
                @if($loop->last)
                <li class="breadcrumb-item text-primary">{{ $item }}</li>
                @else
                <li class="breadcrumb-item text-muted">
                    <a href="{{ $route }}" class="text-muted">{{ $item }}</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                @endif
            @endforeach
    	</ul>
	</div>
</div>
