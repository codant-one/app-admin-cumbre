@extends('admin.layouts.master', [
    'title' => 'Patrocinadores',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('sponsors.index') => 'Patrocinadores',
        route('sponsors.create') => 'Editar',
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
                {!!  Form::open(['route' => ['sponsors.update', ['sponsor' => $sponsor->id]], 'method' => 'PUT', 'files' => true]) !!}
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
                                <option value="{{ $key }}" {{ ($key == $sponsor->category_id) ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Enlace</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('link', old('link', $sponsor->link),
                            ['required',
                            'id' => 'link',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Enlace'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Orden</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::number('order_id', old('order_id', $sponsor->order_id),
                            ['required',
                            'id' => 'order_id',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Orden'])
                        !!}
                    </div>
                </div>

				<div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6 required">Logo</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @include('commons.image-field', [
                            'required' => '',
                            'name' => 'logo',
                            'default' => asset('storage/'.$sponsor->logo),
                        ])
                    </div>
                </div>

			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('sponsors.index') }}" class="btn btn-light me-2">Regresar</a>
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
