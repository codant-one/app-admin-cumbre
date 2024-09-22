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
                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Fecha</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <div class="d-flex mt-8">
                            <div class="form-check form-switch form-check-custom form-check-solid align-items-start">
                                <div class="position-relative d-flex align-items-center">
                                    <div class="symbol symbol-20px me-4 position-absolute ms-4">
                                        <span class="symbol-label bg-secondary">
                                            <span class="svg-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1" />
                                                        <path d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    {!! Form::text('date', old('date', $new->date), 
                                        ['required', 
                                        'readonly', 
                                        'id' => 'date', 
                                        'class' => 'form-control form-control-solid ps-12', 
                                        'placeholder' => 'yyyy-mm-dd'
                                        ])
                                    !!}
                                </div>
                            </div>
                        </div>
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

    $("#date").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        locale: {
            daysOfWeek: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_'),
            monthNames: 'Ene._Feb._Mar._Abr._May._Jun._Jul._Ago._Sept._Oct._Nov._Dec.'.split('_'),
            format: 'YYYY-MM-DD'
        },
    });

    $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });
</script>
@endsection