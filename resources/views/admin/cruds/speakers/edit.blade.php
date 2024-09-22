@extends('admin.layouts.master', [
    'title' => 'Panelistas',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('speakers.index') => 'Panelistas',
        route('speakers.create') => 'Editar',
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
                {!!  Form::open(['route' => ['speakers.update', ['speaker' => $speaker->id]], 'method' => 'PUT', 'files' => true]) !!}
                @csrf

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('name', old('name', $speaker->name),
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
                        {!! Form::text('last_name', old('last_name', $speaker->last_name),
                            ['required',
                            'id' => 'last_name',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Apellido'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Descripción en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::textarea('description_es', old('description_es', $speaker->description_es),
                            ['required',
                            'id' => 'description_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Descripción en español'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Descripción en ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::textarea('description_en', old('description_en', $speaker->description_en),
                            ['required',
                            'id' => 'description_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Descripción en ingles'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Cargo</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select class="form-select form-select-solid positions"
                            name="position_id"
                            id="position_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($positions as $key => $position)
                                <option value="{{ $key }}" {{ ($key == $speaker->position_id) ? 'selected' : '' }}>{{ $position }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <label class="col-lg-4 fw-bold fs-6 mb-2 form-check-label mr-2" for="shipping_submit">Es Popular?</label>
                        {!!
                            Form::checkbox('popular', null, $speaker->is_popular,
                            ['id' => 'popular',
                            'class' => 'form-check-input'
                            ])
                        !!}  
                    </div>
                </div>

				<div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6 required">Avatar</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @include('commons.image-field', [
                            'required' => '',
                            'name' => 'avatar',
                            'default' => asset('storage/'.$speaker->avatar),
                        ])
                    </div>
                </div>

                <div class="row my-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Facebook</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('facebook', old('facebook', $socials['facebook'] ?? null),
                            ['id' => 'facebook',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Facebook'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Instagram</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('instagram', old('instagram', $socials['instagram'] ?? null),
                            ['id' => 'instagram',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Instagram'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Twitter</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('twitter', old('twitter', $socials['twitter'] ?? null),
                            ['id' => 'twitter',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Twitter'])
                        !!}
                    </div>
                </div>
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('speakers.index') }}" class="btn btn-light me-2">Regresar</a>
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

    $('.positions').select2();

</script>
@endsection
