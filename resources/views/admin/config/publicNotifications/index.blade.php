@extends('admin.layouts.master', [
    'title' => 'Notificaciones',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('publicNotifications') => 'Notificaciones',
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
            {!!  Form::open(['route' => 'publicNotificationsStore', 'method' => 'POST']) !!}
                @csrf

                <div class="row mb-6">
                    <div class="col-lg-12">
                        <label class="col-form-label required fw-bold fs-6">Título de la notificación</label>
                        <div class="fv-row fv-plugins-icon-container">
                            {!! Form::text('title', old('title'),
                                ['required',
                                'id' => 'title',
                                'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                                'placeholder' => 'Título de la notificación'])
                            !!}
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        <label class="col-form-label fw-bold fs-6">Mensaje</label>
                        {!! Form::textarea('body', old('body'), [
                                'required',
                                'id' => 'body',
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

