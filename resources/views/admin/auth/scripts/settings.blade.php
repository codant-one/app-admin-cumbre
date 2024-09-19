<script>
    //Detalles del listado de paises.
    let countriesDetails = @json( (isset($countriesDetails)) ? $countriesDetails : false);
    var auth = `{!! isset(auth()->user()->userDetail) ? addslashes(auth()->user()->userDetail) : 'false' !!}`;
    var userDetail = (auth !== 'false') ? JSON.parse(auth) : null;
    var country_id = (auth !== 'false' && userDetail.province !== null) ? userDetail.province.country.id : 0;
    validator = null;
    var KTCreateTransaction = undefined;

    $(document).ready(function () {
        $("#phone").numeric();
        $('.countries').select2();
        $('.provinces').select2();
        $('.occupations').select2();


        const form = document.getElementById('profileForm');

        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'firstname': {
                        validators: {
                            notEmpty: {
                                message: 'El Primer Nombre es requerido'
                            }
                        }
                    },
                    'lastname': {
                        validators: {
                            notEmpty: {
                                message: 'El Primer Apellido es requerido'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'El Email es requerido'
                            }
                        }
                    },
                    'birthday': {
                        validators: {
                            notEmpty: {
                                message: 'La Fecha de Nacimiento es requerida'
                            }
                        }
                    },
                    'birthcountry_id': {
                        validators: {
                            notEmpty: {
                                message: 'El Pais de Nacimiento es requerido'
                            }
                        }
                    },
                    'nationality_id': {
                        validators: {
                            notEmpty: {
                                message: 'La Nacionalidad es requerida'
                            }
                        }
                    },
                    'occupation_id': {
                        validators: {
                            notEmpty: {
                                message: 'La Ocupacion es requerida'
                            }
                        }
                    },
                    'country_id': {
                        validators: {
                            notEmpty: {
                                message: 'El Pais es requerido'
                            }
                        }
                    },
                    'province_id': {
                        validators: {
                            notEmpty: {
                                message: 'La Provincia es requerida'
                            }
                        }
                    },
                    'phone': {
                        validators: {
                            notEmpty: {
                                message: 'El teléfono es requerido'
                            }
                        }
                    },
                    'address': {
                        validators: {
                            notEmpty: {
                                message: 'Los datos de Domicilio son requeridos'
                            }
                        }
                    },
                    'street': {
                        validators: {
                            notEmpty: {
                                message: 'Los datos de Domicilio son requeridos'
                            }
                        }
                    },
                    'postal_code': {
                        validators: {
                            notEmpty: {
                                message: 'El Codigo Postal es requerido'
                            }
                        }
                    },
                    'city': {
                        validators: {
                            notEmpty: {
                                message: 'La Ciudad es requerida'
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


        const submitButton = document.getElementById('form_submit');
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
                                    form.submit();
                                }
                            });
                            
                        }, 2000);
                    } else {
                        Swal.fire({
                            text: "Lo sentimos, algunos datos son errados, por favor intente de nuevo.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Entendido!",
                            customClass: {
                                confirmButton: "btn btn-info rounded-pill"
                            }
                        })
                    }
                });
            }
        });

 
        if(userDetail !== null){

            if (country_id !== 0){
                $.ajax({
                    url: `{{ route("dashboard.index", ["id" => 'here']) }}`.replace('here', country_id),
                    type: 'GET',                       
                    success: function (data) {
                        // drawProvinces(data, 0);
                        // drawPhone(country_id);
                    }
                });
            }

            if (userDetail.reason_occupation !== null && userDetail.occupation_id == 1 ){
                $("#reason_occupation_label").show();
                $("#reason_occupation_div").show();
            }
        }

        $("#birthday").daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            maxDate: moment().format("YYYY-MM-DD"),
            maxYear: moment().format('YYYY'),
            locale: {
                daysOfWeek: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_'),
                monthNames: 'Ene._Feb._Mar._Abr._May._Jun._Jul._Ago._Sept._Oct._Nov._Dec.'.split('_'),
                format: 'YYYY-MM-DD'
            },
        });

        $('input[name="birthday"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            validator.revalidateField('birthday');
        });   


        $("#occupation_id").on("change", function(){
            // if ( $('#'+this.id+' option:selected').html() == "Otros" ){
            if ( this.value == "1" ){
                $("#reason_occupation_label").show();
                $("#reason_occupation_div").show();
                $("#reason_occupation_div").addClass("fv-row");
                $('input[name="reason_occupation"]').prop('required',true);
                validator.addField(
                    'reason_occupation', 
                    {
                        validators: {
                            notEmpty: {
                                message: 'Otra Ocupacion es requerida'
                            }
                        }
                    }
                );

            } else {
                $("#reason_occupation_label").hide();
                $("#reason_occupation_div").hide();
                $("#reason_occupation_div").removeClass("fv-row");
                $('input[name="reason_occupation"]').prop('required',false);
                $('input[name="reason_occupation"]').val("");
                if (validator.getFields().reason_occupation !== undefined)
                    validator.removeField('reason_occupation');
            }

            validator.revalidateField('occupation_id');
        });

        $('#province_id').on('change', function() {
            validator.revalidateField('province_id');
        });

        $('#country_id').on('change', function() {
            var country_id = this.value;
            $("#province_id").html('<option value="">Seleccione</option>');
            $("#phone").val("");
            $("#phonecode").html("");
            $("#phone").prop("readonly", true);
            $("#address").val("");
            $("#addr").val("");
            $("#city").val("");
            $("#postal_code").val("");
            $("#street").val("");

            if(country_id != ''){
                setCountryRestrictions(country_id);
                $('#loader').show();
                $.ajax({
                    url: `{{ route("dashboard.index", ["id" => 'here']) }}`.replace('here', country_id),
                    type: 'GET',                       
                    success: function (data) {
                        // drawProvinces(data, 0);
                        // drawPhone(country_id);
                        // $('#loader').hide();
                    }
                });
            }

            validator.revalidateField('country_id');
        });


        $('#birthcountry_id').on('change', function() {
            validator.revalidateField('birthcountry_id');
        });

        $('#nationality_id').on('change', function() {
            validator.revalidateField('nationality_id');
        });


        $("#address").on("keyup", function(){
            $("#addr").val($(this).val());
            $("#addr").focus();
        });

        $("#addr").on("keyup focusout", function(){
            $("#address").val($(this).val());
        });
    });

    

    function drawProvinces(data, province_id){
        Object.keys(data).forEach (key => {
            var selected = (key == province_id) ? 'selected' : '';
            var html = `<option value="${key}" ${selected}>${data[key]}</option>`;
            $("#province_id").append(html);
        });

        if (validator.getFields().province_id !== undefined)
            validator.removeField('province_id');
                
        validator.addField(
            'province_id', 
            {
                validators: {
                    notEmpty: {
                        message: 'La Provincia es requerida'
                    }
                }
            }
        );
    }

    function drawPhone(country_id){
        var countriesPhoneCodes = []
        var element = false;
        var countriesDetails = []

        if (countriesDetails.length > 0){
            element = countriesDetails.find(function(element) {
                return element.id == country_id;
            });

            if (element){
                $("#phone").prop("minLength", 0);
                $("#phone").prop("maxLength", 0);
                $("#phone").prop("maxLength", element.phone_digits);
                $("#phone").prop("minLength", element.phone_digits);
                var phonePrefix = '+' + element.phonecode;
                $("#phonecode").html(phonePrefix);
                $("#phone").prop("readonly", false);

                if(userDetail !== null && userDetail.phone !== null)
                    $("#phone").val(userDetail.phone.replace(phonePrefix, ''));

                var mask = ""

                for(var i = 0; i < element.phone_digits; i++)
                    mask = mask + '9'

                Inputmask({
                    "mask" : mask
                }).mask("#phone");   
                

                if (validator.getFields().phone !== undefined)
                    validator.removeField('phone');
                
                validator.addField(
                    'phone', 
                    {
                        validators: {
                            stringLength: {
                                min: element.phone_digits,
                                max: element.phone_digits,
                                message: 'Debe introducir la longitud correcta para el número de teléfono'
                            },
                            digits: {
                                message: 'Debe introducir la longitud correcta para el número de teléfono'
                            },
                            notEmpty: {
                                message: 'El teléfono es requerido'
                            }
                        }
                    }
                );
            }
        }
    }

    function editProfile(){
        $('#settingsTab')[0].click();
    }


    /**
     * Fija el pais sobre el cual actuara el Google Javascript Map
     * con su Place API.
     */  
    function setCountryRestrictions(country_id){
        var element = countriesDetails.find(function(element, index) {
        if (element.id == country_id)
            return true;
        });

        //Se configura el Google MAP Javascript API con su Place API.
        if (element != undefined){
            var iso = element.iso.toLowerCase();
            autocomplete.setComponentRestrictions({
                "country": iso
            });

        }
    }
</script>