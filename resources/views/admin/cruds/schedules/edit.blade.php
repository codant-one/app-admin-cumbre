@extends('admin.layouts.master', [
    'title' => 'Agendas',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('schedules.index') => 'Agendas',
        route('schedules.create') => 'Editar',
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
            {!!  Form::open(['route' => ['schedules.update', ['schedule' => $schedule->id]], 'method' => 'PUT', 'id' => 'kt_dropzonejs_example_1', 'files' => true]) !!}
                @csrf
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('name_es', old('name_es', $schedule->name_es),
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
                        {!! Form::text('name_en', old('name_en', $schedule->name_en),
                            ['required',
                            'id' => 'name_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en ingles'])
                        !!}
                    </div>
                </div>

				<div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6 required">Imagen Principal</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @include('commons.image-field', [
                            'required' => '',
                            'name' => 'image',
                            'default' => asset('storage/'.$schedule->image),
                        ])
                    </div>
                </div>

			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('schedules.index') }}" class="btn btn-light me-2">Regresar</a>
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