@extends('admin.layouts.master', [
    'title' => 'Tipos de categorías',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('category-types.index') => 'Tipos de categorías',
        route('category-types.create') => 'Editar',
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
            {!!  Form::open(['route' => ['category-types.update', ['category_type' => $category_type->id]], 'method' => 'PUT']) !!}
                @csrf

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('name_es', old('name_es', $category_type->name_es),
                            ['required',
                            'id' => 'name_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en español'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre en ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('name_en', old('name_en', $category_type->name_en),
                            ['required',
                            'id' => 'name_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en ingles'])
                        !!}
                    </div>
                </div>

			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('category-types.index') }}" class="btn btn-light me-2">Regresar</a>
                <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-info">
                    <span class="indicator-label">Actualizar</span>
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

    $('.categories').select2();

</script>
@endsection