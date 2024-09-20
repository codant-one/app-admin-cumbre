@extends('admin.layouts.master', [
    'title' => 'Noticias',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('news.index') => 'Noticias',
        route('news.create') => 'Editar',
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
            {!!  Form::open(['route' => ['news.update', ['news' => $new->id]], 'method' => 'PUT', 'id' => 'kt_dropzonejs_example_1', 'files' => true]) !!}
                @csrf
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Categoría</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select class="form-select form-select-solid categories"
                            name="category_id"
                            id="category_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key }}" {{ ($key == $new->category_id) ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Título en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('title_es', old('title_es', $new->title_es),
                            ['required',
                            'id' => 'title_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en español'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Contenido en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::textarea('content_es', old('content_es', $new->content_es),
                            ['id' => 'content_es',
                            'rows' => '4',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0 tinymce',
                            'placeholder' => 'Contenido en español'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Título en ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('title_en', old('title_en', $new->title_en),
                            ['required',
                            'id' => 'title_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en ingles'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Contenido en ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::textarea('content_en', old('content_en', $new->content_en),
                            ['required',
                            'id' => 'content_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0 tinymce',
                            'rows' => '4',
                            'placeholder' => 'Contenido en ingles'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <label class="col-lg-4 fw-bold fs-6 mb-2 form-check-label mr-2" for="shipping_submit">Es Popular?</label>
                        {!!
                            Form::checkbox('popular', null, $new->is_popular,
                            ['id' => 'popular',
                            'class' => 'form-check-input'
                            ])
                        !!}  
                    </div>
                </div>

				<div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6 required">Imagen Principal</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @include('commons.image-field', [
                            'required' => '',
                            'name' => 'image',
                            'default' => asset('storage/'.$new->image),
                        ])
                    </div>
                </div>

			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('news.index') }}" class="btn btn-light me-2">Regresar</a>
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