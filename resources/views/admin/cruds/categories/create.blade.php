@extends('admin.layouts.master', [
    'title' => 'Categorías',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('categories.index') => 'Categorías',
        route('categories.create') => 'Agregar Nuevo'
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
            {!! Form::open(['route' => ['categories.store'], 'method' => 'POST']) !!}
                @csrf
                <div class="row mb-7">
                    <div class="col-md-12">
                        <label class="required fw-bold fs-6 mb-2">Tipo de categorías</label>
                        <select class="form-select form-select-solid category_types"
                            name="category_type_id"
                            id="category_type_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($category_types as $key => $type)
                                <option value="{{ $key}}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Nombre en español</label>
                        {!! Form::text('name_es', old('name_es'),
                            ['required',
                            'id' => 'name_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en español'])
                        !!}
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2 ">Nombre en ingles</label>
                        {!! Form::text('name_en', old('name_en'),
                            ['required',
                            'id' => 'name_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en ingles'])
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

    $('.category_types').select2();

</script>
@endsection