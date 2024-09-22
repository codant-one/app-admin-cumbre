@extends('admin.layouts.master', [
    'title' => 'Traducciones',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('translations') => 'Traducciones',
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Traducciones del sistema</div>
			</div>
            <div class="card-body border-top p-9">
            {!!  Form::open(['route' => 'translationsUpdate', 'method' => 'POST']) !!}
                @csrf
                <input type="hidden" id="id" name="id" value="{{ is_null($translation) ? 0 : $translation->id }}" />
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Enlace español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('link_es', old('link_es', $translation->link_es ?? null),
                            ['required',
                            'id' => 'link_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Enlace español'])
                        !!}
                    </div>
                </div>
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Enlace ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('link_en', old('link_en', $translation->link_en ?? null),
                            ['required',
                            'id' => 'link_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Enlace ingles'])
                        !!}
                    </div>
                </div>
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-info">
                    <span class="indicator-label">Guardar</span>
                    <span class="indicator-progress">Cargando...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
			</div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

