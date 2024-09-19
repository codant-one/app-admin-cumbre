@extends('admin.layouts.public')

@section('page-content')
<style>
	 @media (max-width: 991px){
 #columnare{
    display: none!important;
 }
}
</style>
<div class="d-flex flex-column flex-root">
	<div class="d-flex flex-column flex-lg-row flex-column-fluid">
		<div class="bg-radial d-none d-md-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative">
			<div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px">
				<div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-18">
					<a href="{{route('auth.admin.login')}}">
						<img src="{{ asset(env('DOMAIN_LOGO_URL')) }}" alt="" width="200px">
					</a>
					<h1 class="fw-bolder fs-2qx mt-8 pb-5 pb-md-10 text-white">Bienvenido</h1>
					<p class="fw-bold fs-2 text-white">Panel administrativo general
					<br />con excelentes herramientas de construcción</p>
				</div>
				<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-150px min-h-lg-350px" style="background-image: url(images/peoples.png)"></div>
			</div>
		</div>
		<div class="bg-white d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed py-10">
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<div class="w-lg-500px bg-body-public p-10 p-lg-20 mx-auto ">
					{!! Form::open(['route' => 'auth.admin.authenticate','id'=>'kt_sign_in_form', 'class' => 'w-100', 'method' => 'POST']) !!}
					<div class="text-center mb-5">
						<a href="{{route('auth.admin.login')}}">
							<img src="{{ asset(env('DOMAIN_LOGO_URL')) }}" alt="" width="200px">
						</a>
						<div class="text-white fw-bold fs-4">
							Ingresar al panel administrativo
						</div>
					</div>
					<div class="row">
						<div class="fv-row col-md-12 mb-10">
							<label class="form-label fs-6 fw-bolder text-white">Correo electrónico</label>
							<input class="form-control form-control-lg form-control-solid" type="email" name="email" id="email" autocomplete="off" required />
							@error('email')
								<span class="invalid-feedback d-block">{{ $message }}</span>
							@enderror
						</div>
						<div class="fv-row mb-5" data-kt-password-meter="true">
							<div class="mb-1">
								<label class="form-label fw-bolder text-white fs-6">Contraseña</label>
								<div class="position-relative mb-3">
									<input class="form-control form-control-solid" type="password" placeholder="" name="password" id="password" autocomplete="off" />
									<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
										<i class="bi bi-eye-slash fs-2"></i>
										<i class="bi bi-eye fs-2 d-none"></i>
									</span>
								</div>
								@error('password')
									<span class="invalid-feedback d-block">{{ $message }}</span>
								@enderror							
							</div>
							<div class="d-none align-items-center mb-3" data-kt-password-meter-control="highlight">
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
							</div>
						</div>

					</div>
					<!--remember me-->
					
					<div class="row fw-bolder-auth mb-10">
						<span class="fv-row col-md-6  col-7 text-start">
							<a href="{{route('auth.admin.forgot.password')}}" class="text-link">¿Olvido su contraseña?</a>
						</span>
						<span class="fv-row col-md-2" id="columnare"></span>
						<span class="fv-row col-md-4 col-5 text-end p-0 px-md-3">
							<label class="form-check form-check-custom form-check-solid justify-end">
								<span class="form-check-label fw-bolder-auth auth-text text-link">Recuerdame</span>
								<input class="form-check-input h-20px w-20px ms-1 ms-md-3 me-5 me-md-0" type="checkbox" id="remember-admin"/>
							</label>
						</span>
					</div>
					
					<!--Fin remember me-->
					<div class="text-center">
						<button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-info w-100 mb-5" open-on-click>
							<span class="indicator-label">Ingresar</span>
								<span class="indicator-progress">
								<span class="spinner-border spinner-border-md align-middle ms-2"></span>
							</span>
						</button>
					</div>
					{{ Form::close() }}
				</div>
			</div>
			<div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
				<div class="d-flex flex-center fw-bold fs-6">
					<a href="https://keenthemes.com" class="text-link-public px-2" target="_blank">Términos y condiciones</a>
					<a href="https://keenthemes.com/support" class="text-link-public px-2" target="_blank">Política y privacidad</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page-js')
<script>

	$(document).ready(function(){

		$('#remember-admin').prop('checked', (localStorage.getItem('remember-admin') === 'true') ? true : false);
		$('#email').val(localStorage.getItem('email_admin') ?? null)
		$('#password').val(localStorage.getItem('password_admin') ?? null)

		$('#remember-admin').on('change', function(){

			if( $(this).is(':checked') ){
				localStorage.setItem('email_admin', $('#email').val());
        		localStorage.setItem('password_admin', $('#password').val());
				localStorage.setItem('remember-admin', ($('#remember-admin').val() === 'on') ? true : false);

			} else {
				localStorage.setItem('email_admin', '');
        		localStorage.setItem('password_admin', '');
				localStorage.setItem('remember-admin', false);
			}
		});
	});

	
    "use strict";
	
	var KTSignupGeneral = function() {
	    var e, t, a, s = function() {
	        return 100 === s.getScore()
	    };
		
	    return {
	        init: function() {
	            e = document.querySelector("#kt_sign_in_form"),
	            t = document.querySelector("#kt_sign_up_submit"),
	            s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')),
	            a = FormValidation.formValidation(e, {
	                fields: {
	                    "email": {
	                        validators: {
	                            notEmpty: {
	                                message: "Correo electrónico es requerido"
	                            },
								regexp: {
									regexp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
									message: "El formato del correo electrónico no es valido"
								}
	                        }
	                    },
	                    "password": {
	                        validators: {
	                            notEmpty: {
	                                message: "Contraseña requerida"
	                            },
	                            callback: {
	                                message: "Por favor ingrese una contraseña valida"
	                            }
	                        }
	                    }
	                },
	                plugins: {
	                    trigger: new FormValidation.plugins.Trigger({
	                        event: {
	                            password: !1
	                        }
	                    }),
	                    bootstrap: new FormValidation.plugins.Bootstrap5({
	                        rowSelector: ".fv-row",
	                        eleInvalidClass: "",
	                        eleValidClass: ""
	                    })
	                }
	            }),
	            t.addEventListener("click", (function(r) {
	                r.preventDefault(),
	                a.revalidateField("password"),
	                a.validate().then((function(a) {
	                    "Valid" == a ? (t.setAttribute("data-kt-indicator", "on"),
	                    t.disabled = !0,
	                    setTimeout((function() {
	                        t.removeAttribute("data-kt-indicator"),
	                        t.disabled = !1,

	                        $("#kt_sign_in_form").submit();

							if( $('#remember-admin').is(':checked') ){
								localStorage.setItem('email_admin', $('#email').val());
								localStorage.setItem('password_admin', $('#password').val());
								localStorage.setItem('remember-admin', ($('#remember-admin').val() === 'on') ? true : false);

							} else {
								localStorage.setItem('email_admin', '');
								localStorage.setItem('password_admin', '');
								localStorage.setItem('remember-admin', false);
							}
	                    }
	                    ), 1500)) : Swal.fire({
	                        text: "Lo sentimos, algunos datos son errados, por favor intente de nuevo.",
	                        icon: "error",
	                        buttonsStyling: !1,
	                        confirmButtonText: "¡Entendido!",
	                        customClass: {
	                            confirmButton: "btn btn-info rounded-pill"
	                        }
	                    })
	                }
	                ))
	            }
	            )),
	            e.querySelector('input[name="password"]').addEventListener("input", (function() {
	                this.value.length > 0 && a.updateFieldStatus("password", "NotValidated")
	            }
	            ))
	        }
	    }
	}();

	KTUtil.onDOMContentLoaded((function() {
	    KTSignupGeneral.init()
	}
	));

	@if (\Session::has('register_success'))
        Swal.fire({
            text: "{{ Session::get('register_success') }}",
            icon: "success",
            buttonsStyling: !1,
            confirmButtonText: "¡Entendido!",
            customClass: {
                confirmButton: "btn btn-info rounded-pill"
            }
        }).then((function(t) {
            window.location.replace("{{env('APP_URL')}}/admin");
            return true;
        }
        ));
    @endif
</script>
@endsection
