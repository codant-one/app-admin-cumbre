$(document).ready(function(){

    var currentURL = $(location).attr("href");
    var url_route;

    if(currentURL.indexOf('users') > -1) {
        url_route = "users/delete";  
    } else if(currentURL.indexOf('roles') > -1){
        url_route = "roles/delete";
    } else if(currentURL.indexOf('permissions') > -1){
        url_route = "permissions/delete";
    } else if(currentURL.indexOf('places') > -1){
        url_route = "places/delete";
    } else if(currentURL.indexOf('news') > -1){
        url_route = "news/delete";
    } else if(currentURL.indexOf('category-types') > -1){
        url_route = "category-types/delete";
    } else if(currentURL.indexOf('categories') > -1){
        url_route = "categories/delete";
    } else if(currentURL.indexOf('positions') > -1){
        url_route = "positions/delete";
    } else if(currentURL.indexOf('sponsors') > -1){
        url_route = "sponsors/delete";
    } else if(currentURL.indexOf('speakers') > -1){
        url_route = "speakers/delete";
    }
    
    $('.deleteAll').click(function(){
        var ids = [];

        $("input[type=checkbox]:checked").each(function(){
            ids.push($(this).val());
        }); 

        //Validate is selected rows
        if(ids.length <= 0) {    
            alert("¡Por favor selecciona al menos una columna!");    
        }  else {

            var url = url_route;
            var check_deleted = confirm("¿Seguro que deseas eliminar estos elementos?");   
                
            //Confirm delete rows 
            if(check_deleted == true){ 
                $.ajax({
                    url: url,
                    type: 'POST',                       
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { ids: ids },               
                    success: function (data) {

                        setTimeout(() => {
                            toastr.success(data.message, data.title);
                        },500);

                        $('#kt_datatable_example_1').DataTable().draw();
                    }
                });
            }   
        }
    });
});  