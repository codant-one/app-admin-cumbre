//Componentes donde escribir la respuesta del Google Maps Place API
//al escribir una direccion.
var componentForm = {
    locality: 'long_name',
    postal_code: 'short_name'
};


/**
 * Procesa la respuesta del Google Maps Place API al escribir
 * una direccion.
 */    
function fillInAddress() {
    $("#address").val($("#addr").val());
        
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
        component = (component == 'locality') ? 'city' : component;
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            addressType = (addressType == 'locality') ? 'city' : addressType;
            
            $("#"+addressType).val(val);
            if (KTCreateTransaction !== undefined)
                KTCreateTransaction.getValidations()[1].revalidateField(addressType);
            else if (validator !== undefined)
                validator.revalidateField(addressType);
          }
    }

}

/**
 * Inicializa el componente Google Maps Place API.
 */
async function initMap() {

    const inputTal = document.getElementById("addr");

    const options = {
      fields: ["address_components"],
      types: ["address"],
      strictBounds: false,
    };

    await google.maps.importLibrary("places");

    autocomplete = new google.maps.places.Autocomplete(inputTal, options);

    autocomplete.addListener('place_changed', fillInAddress);

    //Para inicializar el pais para usar el Google Map Place API
    if ($('#country_id').val() != '')
        setCountryRestrictions( $('#country_id').val() );

}


//Se inicializa el Google Map Place API
initMap();