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
				<div class="card-title fs-3 fw-bolder">Cargar archivo</div>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => ['clients.uploadPost'], 'method' => 'POST', 'files' => true]) !!}
                    
                    <div class="row mb-7">
                        <div class="fv-row col-md-6">
                            <input type="file" name="file" class="form-control" required>
                            
                        </div>
                    </div>
            </div>
                <div class="card-footer d-flex justify-content-center">
                    <button type="reset" class="btn btn-light me-3 form-modal-dismiss w-300px dismiss-create">Descartar</button>
                    <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-info w-300px">
                        <span class="indicator-label">Cargar</span>
                        <span class="indicator-progress">Cargando...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection