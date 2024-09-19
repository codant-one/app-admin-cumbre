@extends('admin.layouts.master', [
    'toolbar' => true,
    'title' => 'Inicio',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio'
    ]
])

@section('content')

<div class="container">
   DASHBOARD ADMIN TENANT
</div>
   
@endsection
