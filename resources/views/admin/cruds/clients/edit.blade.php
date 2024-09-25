@extends('admin.layouts.master', [
    'title' => 'Clientes',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('clients.index') => 'Clientes',
        route('clients.create') => 'Editar',
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Editar</div>
			</div>
            <div class="card-body border-top p-9">
                {!!  Form::open(['route' => ['clients.update', ['client' => $user->id]], 'method' => 'PUT']) !!}
                
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            {!! Form::text('name', old('name', $user->name),
                                ['required',
                                'id' => 'name',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Nombre'])
                            !!}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Apellido</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            {!! Form::text('last_name', old('last_name', $user->last_name),
                                ['id' => 'last_name',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Apellido'])
                            !!}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            {!! Form::email('email', old('email', $user->email),
                                [
                                    'id' => 'email',
                                    'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                    'placeholder' => 'Email',
                                    'readonly' => 'readonly',
                                ])
                            !!}
                        </div>
                    </div>				
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('clients.index') }}" class="btn btn-light me-2">Regresar</a>
                <button type="submit" class="btn btn-info">
                    <span class="indicator-label">Actualizar</span>
                </button>
			</div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection