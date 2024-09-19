@extends('admin.layouts.public')

@section('page-content')

<div class="bg-dark d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
	<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
		<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-20 mx-auto ">
			{!! Form::open(['route' => 'auth.admin.change','id'=>'formCreate', 'class' => 'w-100', 'method' => 'POST']) !!}
            <div class="text-center mb-10">
                <a href="{{route('auth.admin.login')}}">
                    <img src="{{ asset(env('DOMAIN_LOGO_URL')) }}" alt="" width="200px">
                </a>
                <div class="text-gray-400 fw-bold fs-4">
                    Restablecer Contraseña
                </div>
            </div>

            <div class="text-center mb-md-10 mb-5">                        
                @if ($errors->any())
                <div class="mt-6 mb-6">
                    <span class="alert alert-danger">
                        {{ $errors->first() }}
                    </span>
                </div>
                @endif
            </div>
            <div class="mb-10 fv-row" data-kt-password-meter="true">
                <div class="mb-1">
                    <label class="form-label fw-bolder-auth auth-text" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('auth.combination_password')" style="font-weight:bold">
                        Contraseña
                        <i class="fa fa-info-circle fs-5"></i>
                    </label>
                    <div class="position-relative mb-2">
                        <input class="form-control form-control-solid auth-text" type="password" placeholder="Nueva Contraseña" name="password" id="password" autocomplete="off" required disabled/>
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>
                            <i class="bi bi-eye fs-2 d-none"></i>
                        </span>
                    </div>      
                    <div class="d-flex align-items-center mb-1" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                </div>
            </div>
            <div class="mb-md-10 mb-5 fv-row" data-kt-password-meter="true">
                <div class="mb-1">
                    <label class="form-label fw-bolder-auth auth-text" style="font-weight:bold">Confirmar Contraseña</label>
                    <div class="position-relative mb-2">
                        <input class="form-control form-control-solid auth-text" type="password" placeholder="Confirmar Contraseña" id="password2" name="password2" autocomplete="off" required disabled/>
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>
                            <i class="bi bi-eye fs-2 d-none"></i>
                        </span>
                    </div>     
                    <div class="" data-kt-password-meter-control="highlight" style="display: none;">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div> 
                </div>
            </div>
            <input type="hidden" id="token" name="token">
            <div class="d-flex justify-content-center pb-5">
                <div class="col-12">
                    <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-info w-100 mb-5">
                        <span class="indicator-label">Enviar</span>
                        <span class="indicator-progress">Espere..
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
// $(document).ready(function(){ 

    var token = @json($token);

    $.ajax({
        url: `{{ route("password.find", ['token' => $token]) }}`,
        type: 'GET',
        success: function (response) {
            $("#password").prop("disabled",false);
            $("#password2").prop("disabled",false);
            $("#token").val(token);
        },
        error: function (response) {
            Swal.fire({
             text: "Token invalido",
             icon: "error",
             buttonsStyling: !1,
             confirmButtonText: "Entendido",
             customClass: {
                 confirmButton: "btn btn-danger rounded-pill"
             }
            }).then((function(t) {
                window.location.href = "{{route('auth.admin.forgot.password')}}";
            }
            ));
        }
    });


    "use strict";
    var KTSignupGeneral = function() {
        var e, t, a, s, r = function() {
            return 100 === s.getScore()
        };

        return {
            init: function() {
                e = document.querySelector("#formCreate"),
                t = document.querySelector("#kt_sign_up_submit"),
                s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')),
                a = FormValidation.formValidation(e, {
                    fields: {
                        "password": {
                            validators: {
                                notEmpty: {
                                    message: "Contraseña requerida"
                                },
                            }
                        },
                        "password2": {
                            validators: {
                                notEmpty: {
                                    message: "Confirmación de contraseña requerida"
                                },
                                identical: {
                                    compare: function() {
                                        return e.querySelector('[name="password"]').value
                                    },
                                    message: "las contraseñas no son iguales"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
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
                            $("#formCreate").submit();
                        }
                        ), 1500)) : Swal.fire({
                            text: "Lo sentimos, algunos datos son errados, por favor intente de nuevo.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Entendido",
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


</script>

@endsection