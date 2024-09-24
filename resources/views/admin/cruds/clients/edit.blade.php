@extends('admin.layouts.master', [
    'title' => 'Usuarios',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('users.index') => 'Usuarios',
        route('users.create') => 'Editar',
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
                {!!  Form::open(['route' => ['users.update', ['user' => $user->id]], 'method' => 'PUT']) !!}
                
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

                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Password</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            <input disabled type="password" value="{{ $user->password }} " name="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" required/>
                        </div>
                    </div>
					
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Rol</label>
                        <div class="col-lg-8 fv-row fv-plugins-icon-container">
                            @foreach ($roles as $role )
                                @if($role['name'] !== 'SuperAdmin')
                                <div class="d-flex fv-row">
                                    <div class="form-check form-check-custom form-check-solid">
                                        {{ Form::radio('role', $role['id'], $role['name'] == $user->getRoleNames()[0] ? true : false,
                                            ['class'=>'form-check-input me-3'])
                                        }}
                                        <label class="form-check-label">
                                            <div class="fw-bolder text-gray-800">{{ $role['name']}}</div>
                                        </label>
                                    </div>
                                </div>
                                <div class='separator separator-dashed my-5'></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
				
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('users.index') }}" class="btn btn-light me-2">Regresar</a>
                <button type="submit" class="btn btn-info">
                    <span class="indicator-label">Actualizar</span>
                </button>
			</div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection