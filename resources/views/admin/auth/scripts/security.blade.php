<script>
    "use strict";

    var KTUsersUpdatePassword = function () {
        const element = document.getElementById('update_password');
        const form = element.querySelector('#kt_modal_update_password_form');
        const modal = new bootstrap.Modal(element);

        var initUpdatePassword = () => {

            var validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'current_password': {
                            validators: {
                                notEmpty: {
                                    message: 'La contraseña actual es requerida'
                                }
                            }
                        },
                        'new_password': {
                            validators: {
                                notEmpty: {
                                    message: 'La contraseña es requerida'
                                },
                                callback: {
                                    message: 'Por favor ingrese una contraseña válida',
                                    callback: function (input) {
                                        if (input.value.length > 0) {
                                            return validatePassword();
                                        }
                                    }
                                }
                            }
                        },
                        'confirm_password': {
                            validators: {
                                notEmpty: {
                                    message: 'La confirmacion de contraseña es requerida'
                                },
                                identical: {
                                    compare: function () {
                                        return form.querySelector('[name="new_password"]').value;
                                    },
                                    message: 'La contraseña y su confirmación no son lo mismo.'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Submit button handler
            const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (validator) {
                    validator.validate().then(function (status) {

                        if (status == 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            setTimeout(function () {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                Swal.fire({
                                    text: "¡Los datos han sido llenados con éxito!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Enviar",
                                    customClass: {
                                        confirmButton: "btn btn-info rounded-pill"
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        form.submit(); // Submit form
                                    }
                                });

                                
                            }, 2000);
                        }
                    });
                }
            });
        }

        return {
            // Public functions
            init: function () {
                initUpdatePassword();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function () {
        KTUsersUpdatePassword.init();
    });
</script>