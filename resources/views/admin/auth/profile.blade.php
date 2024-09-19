@extends('admin.layouts.master', [
    'title' => 'Mi Perfil',
    'breadcrumbs' => [
        route('dashboard.index') => 'Dashboard',
        route('profile') => 'Mi Perfil',
    ]
])

@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container">
            @include('admin.auth.partials.account')
            <div class="tab-content" id="myTabContent">
                @include('admin.auth.partials.overview')
                @include('admin.auth.partials.settings')
                @include('admin.auth.partials.security')	
            </div>	
		</div>
    </div>

    @include('admin.auth.partials.modal-update-password')

@endsection

@section('scripts')
    <script src="{{ asset('custom/js/customGoogleMaps.js') }}"></script>
    
    @include('admin.auth.scripts.settings')
    @include('admin.auth.scripts.security')
@endsection