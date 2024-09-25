{{-- Global --}}
<script src="/js/lang.js"></script>
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
<script>
    @if(session()->has('feedback'))
        @php $feedback = session()->get('feedback'); @endphp

        @if(session()->get('feedback.type') == 'toastr')
            toastr.{{ $feedback['action'] }}('{{ $feedback["message"] }}')
        @else
            swal(
                '{{ $feedback["message"] }}',
                '{{ $feedback["action"] }}'
            )
        @endif
    @endif
</script>

{{-- Quill --}}
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

{{-- Custom --}}
<script src="{{ asset('/js/custom/widgets.js') }}"></script>
<script src="{{ asset('/js/custom/modals.js') }}"></script>
<script src="{{ asset('/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('/js/custom/modals/create-app.js') }}"></script>

{{-- File Input --}}
<script src="{{ asset('/js/vendor/piexif.min.js') }}"></script>
<script src="{{ asset('/js/vendor/sortable.min.js') }}"></script>
<script src="{{ asset('/js/vendor/fileinput.min.js') }}"></script>
<script src="{{ asset('/js/vendor/theme.min.js') }}"></script>
<script src="{{ asset('/js/vendor/fileinput.es.js') }}"></script>

{{-- Dual Listbox --}}
<script src="{{ asset('/js/vendor/jquery.bootstrap-duallistbox.min.js?v=') . env('APP_VERSION') }}"></script>

{{-- TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/zdx5vskla3myqmynl0na54nbzn6lesrfzailifp7b305app3/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

{{-- DataTables --}}
<!-- <script>var HOST_URL = "/metronic/theme/html/tools/preview";</script> -->
<script src="{{ asset('/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('/js/pages/crud/datatables/extensions/index.js') }}"></script>

<!-- <script src="{{ asset('/js/pages/crud/datatables/extensions/buttons.js') }}"></script> -->
<script>

    $.extend( true, $.fn.dataTable.defaults, {
        dom:  $(location).attr("href").indexOf('dashboard') > -1 ? 'Brtip' : 'B<"toolbar"><"mt-6" l>rtip',
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        language: {
          lengthMenu: "Mostrar _MENU_ registros",
          loadingRecords:"Cargando...",
          processing:"Procesando...",
          search:"Buscar:",
          // sSearchPlaceholder:"",
          // sUrl:"",
          paginate:{
            first:"Primero",
            last:"Ultimo",
            next:"Proximo",
            previous:"Anterior"
          },
          emptyTable:"No hay datos por mostrar",
          info:"Mostrando _START_ a _END_ de _TOTAL_",
          infoEmpty:"Mostrando 0 a 0 de 0",
          infoFiltered:"(filtrado de _TOTAL_ resultados)"
        },
        buttons: [
				        { extend: 'excelHtml5',
                  className: 'export_excel btn-bg-light btn-color-muted',
                  init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                  }
                },
                { extend: 'csvHtml5',
                  className: 'export_csv btn-bg-light btn-color-muted',
                  init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                  }
                },
                { extend: 'pdfHtml5',
                  className: 'export_pdf btn-bg-light btn-color-muted',
                  init: function(api, node, config) {
                    $(node).removeClass('btn-secondary')
                  }
                }
			],
      fnInitComplete: function(){
          const params = new URLSearchParams(window.location.search)
          const toRoute = params.get("route")

          let route = ''
            route = window.location.pathname + '/create'

          if($(location).attr("href").indexOf('dashboard') == -1 && $(location).attr("href").indexOf('clients') == -1)
            $('#kt_datatable_example_1_wrapper > div.toolbar').html("<a href='"+route+"' class='btn btn-info'><span><i class='fa fa-plus-circle'></i></span>Agregar Nuevo</a>");
          if($(location).attr("href").indexOf('dashboard') == -1 && $(location).attr("href").indexOf('clients') > -1)
            $('#kt_datatable_example_1_wrapper > div.toolbar').html(
              "<a href='"+window.location.pathname + '/upload/users'+"' class='btn btn-info mr-2'><span><i class='fa fa-upload'></i></span>Cargar Excel</a>" +
              "<a href='"+route+"' class='btn btn-info'><span><i class='fa fa-plus-circle'></i></span>Agregar Nuevo</a>"
            );
      }
    } );

    $('#export_excel').on('click', function(e) {
		e.preventDefault();
        $('.export_excel').click();
	});

	$('#export_csv').on('click', function(e) {
		e.preventDefault();
		$('.export_csv').click();
	});

	$('#export_pdf').on('click', function(e) {
		e.preventDefault();
		$('.export_pdf').click();
	});

</script>

{{-- Custom Scripts --}}
<script src="{{ asset('custom/js/main.js') }}"></script>
<script src="{{ asset('custom/js/fakit.js') }}"></script>

<!-- LOADER -->
<script>
  window.addEventListener('load', function () {
      // Ocultar el loader una vez que la página haya cargado completamente
      document.getElementById('loader').style.display = 'none';
  });
</script>

<!-- GOOGLE MAPS -->
<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "{{env('API_KEY_GOOGLE_MAPS')}}",
        v: "weekly"
    });
</script>
