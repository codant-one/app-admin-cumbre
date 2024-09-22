@extends('admin.layouts.master', [
    'title' => 'Mapa',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('map') => 'Mapa',
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Mapa del sitio</div>
			</div>
            <div class="card-body border-top p-9">
            {!!  Form::open(['route' => 'mapUpdate', 'method' => 'POST', 'files' => true]) !!}
                @csrf
                <input type="hidden" id="id" name="id" value="{{ is_null($map) ? 0 : $map->id }}" />
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Imagen</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @include('commons.image-field', [
                            'required' => is_null($map) ? 'required' : '',
                            'name' => 'image',
                            'default' => is_null($map) ? asset('images/avatars/blank.png') : asset('storage/'.$map->image),
                        ])
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

