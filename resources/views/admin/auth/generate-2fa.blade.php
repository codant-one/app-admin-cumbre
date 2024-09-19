@extends('admin.layouts.public')

@section('page-content')

<div class="bg-dark d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
	<div class="d-flex flex-center flex-column flex-column-fluid p-10">
		<div class="w-lg-500px bg-body rounded shadow-sm p-15 mx-auto" style="border-radius: 16px !important">
			<div class="text-center"> {!! $qr !!} </div>
            {!! Form::open(['route' => 'auth.admin.2fa.validate', 'id' => 'formSubmit', 'method' => 'POST']) !!}
			<div class="text-center mb-10">
				<h1 class="text-dark mb-3">Escanee el código QR</h1>
				<div class="text-muted fw-bold fs-5 mb-5">
                    Configure su autenticación de dos factores escaneando el código QR a continuación.
                    Alternativamente, puede usar el código <strong>{{ $token }}</strong><br>
                    Debe configurar su aplicación Google Authenticator antes de continuar. De lo contrario, no podrá iniciar sesión.
                </div>
                @if ($errors->any())
                <span class="alert alert-danger" id="error-input">
                    {{ $errors->first() }}
                </span>
                @endif
                <span class="alert alert-danger" id="error-message" style="display: none;">
                    Por favor, complete el campo de código.
                </span>
			</div>
			<div class="mb-5 px-md-2">
                <div class="fw-bolder text-center text-dark fs-6 mb-1 ms-1">Escriba su código de seguridad de 6 dígitos</div>
                <div class="d-flex justify-content-center align-center">
                    <input type="tel" 
                        class="form-control form-control-custom mx-0 my-2" 
                        maxlength="7"
                        id="token_2fa" 
                        name="token_2fa"
                        name="___-___"
                        required />
                    <input type="hidden" name="route" id="hidden-route" value="auth.admin.2fa.generate">
                </div>
            </div>
            <div class="d-flex flex-center">
                <button type="submit" class="btn btn-lg btn-info w-100 mb-5" id="submit-btn">
                    <span class="indicator-label">ENVIAR</span>
                    <span class="indicator-progress">
                        <span class="spinner-border spinner-border-md align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            {!! Form::close() !!}
		</div>
	</div>
</div>
@endsection

@section('page-js')
<script>    
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('token_2fa');
        const submitBtn = document.getElementById('submit-btn');
        const errorMessage = document.getElementById('error-message');
        const errorInput = document.getElementById('error-input');
        const formSubmit = document.getElementById('formSubmit');

        input.addEventListener('focus', function() {
            // Cuando el input está enfocado, manten la máscara de inputmask
            Inputmask({
                "mask": "999-999",
                "placeholder": "___-___",  // Placeholder vacío para que no interfiera con el inputmask
                "showMaskOnHover": false,   // No mostrar la máscara al pasar el mouse
                "showMaskOnFocus": true     // Mostrar la máscara solo al enfocar
            }).mask(input);
        });

        input.addEventListener('blur', function() {
            // Cuando el input pierde el foco, si está vacío, muestra el placeholder manual
            if (input.value === '') {
                input.placeholder = '___-___';
            }
        });

        input.addEventListener('input', function() {
            errorMessage.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif
        });

        // Iniciar con placeholder manual
        input.placeholder = '___-___';

        // Validación al hacer clic en el botón de enviar
        submitBtn.addEventListener('click', function(event) {
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif

            // Prevenir el envío del formulario si el campo no está completo
            if (input.value.includes('_') || input.value === '') {
                event.preventDefault(); // Detener el envío del formulario
                errorMessage.style.display = 'block'; // Mostrar mensaje de error

            } else {
                submitBtn.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click 
                submitBtn.disabled = true;

                errorMessage.style.display = 'none'; // Ocultar mensaje de error
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