@extends('admin.layouts.public')

@section('page-content')

<div class="bg-dark d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
	<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
		<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-20 mx-auto" style="border-radius: 16px !important">
			{!! Form::open(['route' => 'auth.admin.confirm', 'id'=>'formSubmit', 'class' => 'w-100', 'method' => 'POST']) !!}
            <div class="text-center mb-10">
                <a href="{{route('auth.admin.login')}}">
                    <img src="{{ asset(env('DOMAIN_LOGO_URL_WHITE')) }}" alt="" width="100px">
                </a>
                <div class="text-gray-400 fw-bold fs-4">
                    Restablecer Contraseña
                </div>
            </div>
            <div class="text-start mb-md-10 mb-5">                            
                @if ($errors->any())
                <div class="mt-6 mb-6">
                    <span class="alert alert-danger" id="error-input">
                        {{ $errors->first() }}
                    </span>
                </div>
                @endif
                <div class="mt-6 mb-6">
                    <span class="alert alert-danger w-100" id="error-message" style="display: none;">
                        Por favor, ingrese un correo electrónico válido.
                    </span>
                </div>
            </div>
            <div class="fv-row mb-5">
                <label class="form-label fw-bolder-auth auth-text" style="font-weight:bold">Correo Electrónico</label>
                <input class="form-control form-control-solid auth-text" type="email" placeholder="" name="email" id="email" autocomplete="off" required/>
                @error('email')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
                <small>Ingrese su correo electrónico y enviaremos un link para reiniciar su contraseña</small>
            </div>
            <input type="hidden" name="route" id="hidden-route" value="auth.admin.forgot.password">
            <div class="d-flex justify-content-center pb-10 mb-7">
                <div class="col-12 mb-10">
                    <button type="submit" id="submit-btn" class="btn btn-lg btn-info w-100 mb-10">
                        <span class="indicator-label">Enviar</span>
                        <span class="indicator-progress">
                        <span class="spinner-border spinner-border-md align-middle ms-2"></span></span>
                    </button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script>    
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const submitBtn = document.getElementById('submit-btn');
        const formSubmit = document.getElementById('formSubmit');
        const errorMessage = document.getElementById('error-message');
        const errorInput = document.getElementById('error-input');

        emailInput.addEventListener('input', function() {
            errorMessage.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif
        });

        submitBtn.addEventListener('click', function(event) {
          
            if (!emailInput.checkValidity()) {
                event.preventDefault(); // Detener cualquier acción predeterminada, si existiera
                errorMessage.style.display = 'block'; // Mostrar mensaje de error si el campo no es válido
            } else {

                submitBtn.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click 
                submitBtn.disabled = true;

                // Simulate ajax request
                setTimeout(function() {
                    // Hide loading indication
                    submitBtn.removeAttribute('data-kt-indicator');

                    // Enable button
                    submitBtn.disabled = false;
                    formSubmit.submit();
                }, 1000);
            }
        });
    });
</script>
@endsection