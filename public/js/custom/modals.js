var BootstrapModalActions = (function(){
    return {
        init: function () {
            document.querySelector(".form-modal-dismiss") ?
                document.querySelectorAll(".form-modal-dismiss").forEach(function(item){
                    item.addEventListener("click", function (e) {
                        e.preventDefault(),
                        Swal.fire({
                            text: "¿Estás seguro de descartar el formulario?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Sí, salir",
                            cancelButtonText: "No, volver",
                            customClass: { confirmButton: "btn btn-info rounded-pill", cancelButton: "btn btn-light" },
                        }).then(function (t) {

                            const params = new URLSearchParams(window.location.search)
                            let replace = '';

                            if(params.has('affiliate'))
                                replace = '?affiliate=1#create';
                            else
                                replace = 'create';

                            if(t.value){
                                if ($(".form-modal-dismiss").hasClass('dismiss-create-beneficiary'))
                                    window.location.href = window.location.href.replace(replace, ''); 
                                else if ($(".form-modal-dismiss").hasClass('dismiss-create'))
                                    window.location.href = window.location.href.replace(replace, '');
                                else if ($(".form-modal-dismiss").hasClass('dismiss-incomes'))
                                    window.location.href = window.location.href.replace(/incomes_show\/\d+$/, '');
                                else if ($(".form-modal-dismiss").hasClass('dismiss-expenses'))
                                    window.location.href = window.location.href.replace(/expenses_show\/\d+$/, '');
                                else
                                    // $('.modal[id*="create"]').modal('hide');
                                    document.querySelector('.modal.show [data-bs-dismiss]').click()
                            }
                                //document.querySelector('.modal.show [data-bs-dismiss]').click()
                        });
                    });
                })
            : null
        }
    }
})();


$(document).ready(function () {
    BootstrapModalActions.init();
});

function modalShow(id, route){
    var myModalEl = document.querySelector(id);
    var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

    //Update the Form Action attribute.
    $(id).find("form").attr('action', route);
    //Open the Modal.
    modal.show();
}


// var KTModalActions = (function(){
// 	return {
// 		init: function () {
//             document.querySelector(".form-modal-dismiss") ?
//     			document.querySelector(".form-modal-dismiss").addEventListener("click", function (e) {
//     			 	e.preventDefault(),
//                     Swal.fire({
//                         text: "¿Estás seguro de descartar el formulario?",
//                         icon: "warning",
//                         showCancelButton: !0,
//                         buttonsStyling: !1,
//                         confirmButtonText: "Sí, salir",
//                         cancelButtonText: "No, volver",
//                         customClass: { confirmButton: "btn btn-info rounded-pill", cancelButton: "btn btn-light" },
//                     }).then(function (t) {

//                         const params = new URLSearchParams(window.location.search)
//                         let replace = '';

//                         if(params.has('affiliate'))
//                             replace = '?affiliate=1#create';
//                         else
//                             replace = 'create';

//                         if(t.value){
//                             if ($(".form-modal-dismiss").hasClass('dismiss-create-beneficiary'))
//                                 window.location.href = window.location.href.replace(replace, ''); 
//                             else if ($(".form-modal-dismiss").hasClass('dismiss-create'))
//                                 window.location.href = window.location.href.replace(replace, '');
//                             else if ($(".form-modal-dismiss").hasClass('dismiss-incomes'))
//                                 window.location.href = window.location.href.replace(/incomes_show\/\d+$/, '');
//                             else if ($(".form-modal-dismiss").hasClass('dismiss-expenses'))
//                                 window.location.href = window.location.href.replace(/expenses_show\/\d+$/, '');
//                             else
//                                 $('.modal[id*="create"]').modal('hide');
//                         }
            
//     						//document.querySelector('.modal.show [data-bs-dismiss]').click()

//                     });
//     			}) : null
// 		}
// 	}
// })()


// KTUtil.onDOMContentLoaded(function () {
//     KTModalActions.init()
// });