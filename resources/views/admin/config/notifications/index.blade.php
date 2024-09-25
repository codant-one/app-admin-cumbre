@extends('admin.layouts.master', [
    'title' => 'Notificaciones',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('notifications') => 'Notificaciones',
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Enviar notificaciones</div>
			</div>
            <div class="card-body border-top p-9">
            {!!  Form::open(['route' => 'notificationStore', 'method' => 'POST']) !!}
                @csrf
                <div class="row mb-6">
                    <div class="col-lg-6">
                        <label class="col-form-label fw-bold fs-6 required">Tipo de Notificación</label>
                        <select class="form-select form-select-solid notification_types"
                            name="notification_type_id"
                            id="notification_type_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($notification_types as $key => $notification_type)
                                <option value="{{ $key}}">{{ $notification_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6" id="schedules" style="display:none;">
                        <label class="col-form-label fw-bold fs-6 required">Agendas</label>
                        <select class="form-select form-select-solid schedules"
                            name="schedule_id"
                            id="schedule_id">
                            <option value="">Seleccione</option>
                            @foreach ($schedules as $key => $schedule)
                                <option value="{{ $key}}">{{ $schedule }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6" id="talks" style="display:none;">
                        <label class="col-form-label fw-bold fs-6 required">
                            <span>Charlas</span>
                            <span class="fs-8">(solo para usuarios que requieren notificación)</span>
                        </label>
                        <select class="form-select form-select-solid talks"
                            name="talk_id"
                            id="talk_id">
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6">
                        <label class="col-form-label required fw-bold fs-6">Título de la notificación (Español)</label>
                        <div class="fv-row fv-plugins-icon-container">
                            {!! Form::text('title_es', old('title_es'),
                                ['required',
                                'id' => 'title_es',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Título de la notificación (Español)'])
                            !!}
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label class="col-form-label required fw-bold fs-6">Título de la notificación (Ingles)</label>
                        <div class="fv-row fv-plugins-icon-container">
                            {!! Form::text('title_en', old('title_en'),
                                ['required',
                                'id' => 'title_en',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Título de la notificación (Ingles)'])
                            !!}
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-6">
                        <label class="col-form-label fw-bold fs-6">
                            <span class="required">Mensaje (Español)</span>
                            <span class="fs-8">(setear {{$user}} para hacer referencia al nombre completo del usuario)</span>
                        </label>
                        {!! Form::textarea('description_es', old('description_es'), [
                                'required',
                                'id' => 'description_es',
                                'rows' => '4',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Cuerpo del mensaje'
                            ])
                        !!}
                    </div>
                    <div class="col-lg-6">
                        <label class="col-lg-12 col-form-label fw-bold fs-6">
                            <span class="required">Mensaje (Ingles)</span>
                            <span class="fs-8">(setear {{$user}} para hacer referencia al nombre completo del usuario)</span>
                        </label>
                        {!! Form::textarea('description_en', old('description_en'), [
                                'required',
                                'id' => 'description_en',
                                'rows' => '4',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Cuerpo del mensaje'
                            ])
                        !!}
                    </div>
                </div>
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-info">
                    <span class="indicator-label">Enviar</span>
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

    $('.notification_types').select2();
    $('.schedules').select2();
    $('.talks').select2();

    $("#notification_type_id").on("change", function() {
        if ( this.value == "1" ){
            $("#schedules").show();
            $("#talks").show();
            $('#schedule_id').prop('required', true);
            $('#talk_id').prop('required', true);
        } else {
            $("#schedules").hide();
            $("#talks").hide();
            $('#schedule_id').prop('required', false);
            $('#talk_id').prop('required', false);
        }
    });

    $("#schedule_id").on("change", function() {
        var schedule_id = this.value;
        $("#talk_id").html('<option value="">Seleccione</option>');
        $('#loader').show();
        $.ajax({
            url: `{{ route("talks.talksByScheduleId", ["id" => 'here']) }}`.replace('here', schedule_id),
            type: 'GET',                       
            success: function (data) {
                Object.keys(data).forEach (key => {
                    var html = `<option value="${key}">${data[key]}</option>`;
                    $("#talk_id").append(html);
                    $('#loader').hide();
                });
            }
        });

    });
</script>
@endsection

