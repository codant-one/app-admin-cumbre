@extends('admin.layouts.master', [
    'title' => 'Agendas',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('schedules.index') => 'Agendas',
        route('schedules.create') => 'Agregar Nuevo'
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
            {!! Form::open(['route' => ['schedules.store'], 'method' => 'POST', 'id' => 'kt_dropzonejs_example_1', 'files' => true]) !!}
                @csrf
                <div class="row mb-7">
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Nombre en español</label>
                        {!! Form::text('name_es', old('name_es'),
                            ['required',
                            'id' => 'name_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en español'])
                        !!}
                    </div>
                    <div class="col-md-6">
                        <label class="required fw-bold fs-6 mb-2 ">Nombre en ingles</label>
                        {!! Form::text('name_en', old('name_en'),
                            ['required',
                            'id' => 'name_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en ingles'])
                        !!}
                    </div>
                </div>
                <div class="row mb-7">
                    <div class="col-md-6">
                        <div class="form-check form-switch form-check-custom form-check-solid align-items-start">
                            <label class="fw-bold fs-6 form-check-label me-16 ms-0 required" for="shipping_submit">Imagen Principal</label>  
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

    $("#date").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoApply: true,
        startDate: moment(),
        maxDate: moment().format("YYYY-MM-DD"),
        maxYear: moment().format('YYYY'),
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