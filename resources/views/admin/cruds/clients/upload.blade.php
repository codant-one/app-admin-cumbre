@extends('admin.layouts.master', [
    'title' => 'Clientes',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('clients.index') => 'Clientes',
        route('clients.upload') => 'Cargar Clientes'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Agregar Nuevo</div>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => ['clients.store'], 'method' => 'POST', 'files' => true]) !!}
                    
                    <div class="row mb-7">
                        <div class="fv-row col-md-6">
                            <label class="required fw-bold fs-6 mb-2">Nombre</label>
                            {!! Form::text('name', old('name'),
                                ['required',
                                'id' => 'name',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Nombre'])
                            !!}
                        </div>
                        <div class="fv-row col-md-6">
                            <label class="fw-bold fs-6 mb-2">Apellido</label>
                            {!! Form::text('last_name', old('last_name'),
                                ['id' => 'last_name',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Apellido'])
                            !!}
                        </div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Email</label>
                        {!! Form::email('email', old('email'),
                            ['required',
                             'id' => 'email',
                             'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                             'placeholder' => 'Email'])
                        !!}
                    </div>
            </div>
                <div class="card-footer d-flex justify-content-center">
                    <button type="reset" class="btn btn-light me-3 form-modal-dismiss w-300px dismiss-create">Descartar</button>
                    <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-info w-300px">
                        <span class="indicator-label">Registrar</span>
                        <span class="indicator-progress">Cargando...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection