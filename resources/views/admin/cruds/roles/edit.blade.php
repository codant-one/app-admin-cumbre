@extends('admin.layouts.master', [
'title' => 'Roles',
'breadcrumbs' => [
route('dashboard.index') => 'Inicio',
route('users.index') => 'Usuarios',
route('roles.index') => 'Roles',
route('roles.create') => 'Editar',
]
])

@section('content')

<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Editar</div>
			</div>
            <div class="card-body d-flex flex-center flex-column pt-12 p-9 px-0">
                {!!  Form::open(['route' => ['roles.update', ['role' => $rol->id]], 'method' => 'PUT', 'style'=>'width:80%']) !!}     
                <div class="d-flex flex-column  me-n7 pe-7" >
                    <div class="form-group row px-6 py-5">
                        <label class="col-6 col-form-label required">Nombre</label>
                        <div class="col-6">
                            <input class="form-control" type="text" name="name" value="{{ $rol->name }}" placeholder="Nombre del ROL" autocomplete="off">
                        </div>
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    </div>
        
                    <div class="accordion accordion-flush" id="accordionPermissionRol">
                        <div class="accordion-item">
                            <h2 class="accordion-header" class="headingUser">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#itemUser" aria-expanded="false" aria-controls="itemUser">
                                    <span>Ver permisos</span>
                                </button>
                            </h2>
                            <div id="itemUser" class="accordion-collapse collapse" aria-labelledby="headingUser" data-bs-parent="#accordionPermissionRol">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-5">
                                            <div class="form-group">
                                                <label class="checkbox">
                                                <input type="checkbox" id="check-all">
                                                <span></span>Seleccionar todos</label>
                                            </div>
                                        </div>
                                            
                                        @foreach ($permissions as $permission)

                                            @php $id_permission = $permission->id; @endphp

                                            <div class="col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label class="checkbox">
                                                    <input type="checkbox" class="checkbox-permission" name="permissions[]" value="{{ $permission->id }}" @if(in_array( $id_permission , $current_permissions)) checked @endif>
                                                    <span></span>{{ $permission->description }}</label>
                                                </div>
                                            </div>
                                                
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-danger px-15 py-5">{{ $errors->first('permissions') }}</p>
                </div>
            </div>
            <div class="card-footer p-9 px-md-20">
                <div class="row text-center p-9 px-md-20">
                    <div class="col-12 col-md-6">
                        <a class="btn btn-light me-3 w-100 mt-2" href="{{ route('roles.index') }}">Descartar</a>
                    </div>
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-info w-100 mt-2">
                            <span class="indicator-label">Actualizar</span>
                        </button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function(){

        $('#check-all').on('change', function(){

            if( $(this).is(':checked') ){

                $('.checkbox-permission').prop('checked', true);

            } else {

                $('.checkbox-permission').prop('checked', false);

            }
        });
    });

</script>
    
@endsection