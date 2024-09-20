@extends('admin.layouts.master', [
    'title' => 'Noticias',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('news.index') => 'Noticias',
        route('news.create') => 'Agregar Nuevo'
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
            {!! Form::open(['route' => ['news.store'], 'method' => 'POST', 'id' => 'kt_dropzonejs_example_1', 'files' => true]) !!}
                @csrf
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Categoría</label>
                        <select class="form-select form-select-solid categories"
                            name="category_id"
                            id="category_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key}}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Enlace</label>
                            {!! Form::text('link', old('link'),
                                ['required',
                                'id' => 'link',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Enlace'])
                            !!}
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Título en español</label>
                        {!! Form::text('title_es', old('title_es'),
                            ['required',
                            'id' => 'title_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en español'])
                        !!}
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2 ">Título en ingles</label>
                        {!! Form::text('title_en', old('title_en'),
                            ['required',
                            'id' => 'title_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en ingles'])
                        !!}
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Contenido en español</label>
                        {!! Form::textarea('content_es', old('content_es'),
                            ['required',
                            'id' => 'content_es',
                            'rows' => '4',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0 tinymce',
                            'placeholder' => 'Título en español'])
                        !!}
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2 ">Contenido en ingles</label>
                        {!! Form::textarea('content_en', old('content_en'),
                            ['required',
                            'id' => 'content_en',
                            'rows' => '4',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en ingles'])
                        !!}
                    </div>
                </div>
                <div class="row mb-7">
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
                            <label class="fw-bold fs-6 form-check-label mt-2 me-16 ms-0" for="shipping_submit">Imagen Principal</label>  
                            @include('commons.image-field', [
                                'required' => 'required',
                                'name' => 'image',
                                'default' =>  asset('images/avatars/blank.png')
                            ])
                        </div>
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

    $('.categories').select2();

    tinymce.init({
        selector: 'textarea#content_es', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>

@endsection