@extends('admin.layouts.master', [
    'title' => 'Usuarios',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('users.index') => 'Usuarios',
        route('users.create') => 'Agregar Nuevo'
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
                {!! Form::open(['route' => ['users.store'], 'method' => 'POST', 'files' => true]) !!}
                    
                    <div class="row mb-7">
                        <div class="fv-row col-md-6">
                            <label class="required fw-bold fs-6 mb-2">Primer Nombre</label>
                            {!! Form::text('firstname', old('firstname'),
                                ['required',
                                'id' => 'firstname',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Primer Nombre'])
                            !!}
                        </div>
                        <div class="fv-row col-md-6">
                            <label class="fw-bold fs-6 mb-2">Segundo Nombre</label>
                            {!! Form::text('secondname', old('secondname'),
                                ['id' => 'secondname',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Segundo Nombre'])
                            !!}
                        </div>
                    </div>

                    <div class="row mb-7">
                        <div class="fv-row col-md-6">
                            <label class="required fw-bold fs-6 mb-2">Primer Apellido</label>
                            {!! Form::text('lastname', old('lastname'),
                                ['required',
                                'id' => 'lastname',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Primer Apellido'])
                            !!}
                        </div>
                        <div class="fv-row col-md-6">
                            <label class="fw-bold fs-6 mb-2">Segundo Apellido</label>
                            {!! Form::text('secondsurname', old('secondsurname'),
                                ['id' => 'secondsurname',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Segundo Apellido'])
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
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2 ">Password</label>
                        {!! Form::password('password', 
                            ['required', 
                             'id' => 'password', 
                             'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                             'placeholder' => 'Clave'])
                        !!}
                    </div>
                    <div class="mb-7">
                        <label class="required fw-bold fs-6 mb-5">Rol</label>

                        @foreach ($roles_ as $role )
                            @if($role['name'] !== 'SuperAdmin')
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid">
                                    {{ Form::radio('role', $role['id'], $role['id'] == 2 ? true : false,
                                        ['class'=>'form-check-input me-3'])
                                    }}
                                    <label class="form-check-label">
                                        <div class="fw-bolder text-gray-800">{{ $role['name'] }}</div>
                                    </label>
                                </div>
                            </div>
                            <div class='separator separator-dashed my-5'></div>
                            @endif
                        @endforeach
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

@section('scripts')
<script>
    $(document).ready(function () {

        //Initializate select2
        $('.roles').select2();
        $('.token').select2();
    });
</script>

@endsection