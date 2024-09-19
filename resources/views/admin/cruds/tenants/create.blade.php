@extends('admin.layouts.master', [
    'title' => 'Dominios',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('tenants.index') => 'Dominios',
        route('tenants.create') => 'Agregar Nuevo'
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
                {!! Form::open(['route' => ['tenants.store'], 'method' => 'POST', 'files' => true]) !!}
                    
                    <div class="row mb-7">
                        <div class="fv-row col-md-12">
                            <label class="required fw-bold fs-6 mb-2">Dominio</label>
                            {!! Form::text('domain', old('domain'),
                                ['required',
                                'id' => 'domain',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Dominio'])
                            !!}
                        </div>
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