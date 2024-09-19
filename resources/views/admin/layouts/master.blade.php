<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@include('admin.layouts.partials.header')

@if(isset($toolbar) && $toolbar)
<body class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
@else
<body class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
@endif
    <div id="loader">
        <div class="spinner-border text-loader" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="d-flex flex-column flex-root">

        <div class="page d-flex flex-row flex-column-fluid">

            @include('admin.layouts.partials.sidebar')

            <div class="wrapper d-flex flex-column flex-row-fluid">
                @include('admin.layouts.partials.navbar', ['title' => $title, 'breadcrumbs' => $breadcrumbs] )
                <!-- header top menu end -->

                <!-- ============ Body content start ============= -->
                <div class="content d-flex flex-column flex-column-fluid">
                    @if(isset($toolbar) && $toolbar)
                        @include('admin.layouts.partials.toolbar')
                    @endif
                    <div class="post d-flex flex-column-fluid">
                        @yield('content')
                    </div>
                </div>
                <!-- ============ Body content End ============= -->

                <!-- ============ Footer start ============= -->
                <div class="footer py-4 d-flex flex-lg-column">
                    @include('admin.layouts.partials.footer')
                </div>
                <!-- ============ Footer End ============= -->
            </div>
        </div>
    </div>
    <!--=============== End app-admin-wrap ================-->

    <!-- ============ Search UI Start ============= -->
    {{-- @include('admin.layouts.partials.search') --}}
    <!-- ============ Search UI End ============= -->

    @include('admin.layouts.partials.scripts')

    @yield('scripts')
</body>

</html>
