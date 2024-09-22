@extends('admin.layouts.master', [
    'title' => 'Panelistas',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('speakers.index') => 'Panelistas',
        route('speakers.create') => 'Agregar Nuevo'
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
            {!! Form::open(['route' => ['speakers.store'], 'method' => 'POST', 'files' => true]) !!}
                @csrf
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Nombre</label>
                        {!! Form::text('name', old('name'),
                            ['required',
                            'id' => 'name',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre'])
                        !!}
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Apellido</label>
                        {!! Form::text('last_name', old('last_name'),
                            ['required',
                            'id' => 'last_name',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Apellido'])
                        !!}
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Descripción en español</label>
                        {!! Form::textarea('description_es', old('description_es'),
                            ['required',                                
                            'id' => 'description_es',
                            'rows' => '4',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Descripción en español'])
                        !!}
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2 ">Descripción en ingles</label>
                        {!! Form::textarea('description_en', old('description_en'),
                            ['required',
                            'id' => 'description_en',
                            'rows' => '4',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Descripción en ingles'])
                        !!}
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Cargo</label>
                        <select class="form-select form-select-solid positions"
                            name="position_id"
                            id="position_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($positions as $key => $position)
                                <option value="{{ $key}}">{{ $position }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <label class="fw-bold fs-6 form-check-label" style="margin-left: 0; margin-right: 10px" for="shipping_submit">Es Popular?</label>
                            {!!
                                Form::checkbox('popular', null, '0',
                                ['id' => 'popular',
                                'class' => 'form-check-input'
                                ])
                            !!}  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch form-check-custom form-check-solid align-items-start">
                            <label class="fw-bold fs-6 form-check-label mt-2 me-16 ms-0 required" for="shipping_submit">Avatar</label>  
                            @include('commons.image-field', [
                                'required' => 'required',
                                'name' => 'avatar',
                                'default' =>  asset('images/avatars/blank.png')
                            ])
                        </div>
                    </div>
                </div>
                <div class="row mb-7">
                    
                </div>
                <div class="row my-7">
                    <div class="col-md-4">
                        <label class="fw-bold fs-6 mb-2">Facebook</label>
                        {!! Form::text('facebook', old('facebook'),
                            ['id' => 'facebook',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Facebook'])
                        !!}
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold fs-6 mb-2 ">Instagram</label>
                        {!! Form::text('instagram', old('instagram'),
                            ['id' => 'instagram',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Instagram'])
                        !!}
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold fs-6 mb-2 ">twitter</label>
                        {!! Form::text('twitter', old('twitter'),
                            ['id' => 'twitter',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'twitter'])
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

@section('scripts')
<script>

    $('.positions').select2();

</script>
@endsection