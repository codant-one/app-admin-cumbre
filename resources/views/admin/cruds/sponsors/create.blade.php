@extends('admin.layouts.master', [
    'title' => 'Patrocinadores',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('sponsors.index') => 'Patrocinadores',
        route('sponsors.create') => 'Agregar Nuevo'
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
            {!! Form::open(['route' => ['sponsors.store'], 'method' => 'POST', 'files' => true]) !!}
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
                        <label class="required fw-bold fs-6 mb-2">Orden</label>
                            {!! Form::number('order_id', old('order_id'),
                                ['required',
                                'id' => 'order_id',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Orden'])
                            !!}
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch form-check-custom form-check-solid align-items-start">
                            <label class="fw-bold fs-6 form-check-label mt-2 me-16 ms-0 required" for="shipping_submit">Logo</label>  
                            @include('commons.image-field', [
                                'required' => 'required',
                                'name' => 'logo',
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

</script>
@endsection