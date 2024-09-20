@extends('admin.layouts.master', [
    'title' => 'Lugares',
    'breadcrumbs' => [
        route('dashboard.index') => 'Inicio',
        route('places.index') => 'Lugares',
        route('places.create') => 'Editar',
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Editar</div>
			</div>
            <div class="card-body border-top p-9">
                {!!  Form::open(['route' => ['places.update', ['place' => $place->id]], 'method' => 'PUT', 'id' => 'kt_dropzonejs_example_1', 'files' => true]) !!}
                @csrf
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6 required">Categoría</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <select class="form-select form-select-solid categories"
                            name="category_id"
                            id="category_id"
                            required>
                            <option value="">Seleccione</option>
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key }}" {{ ($key == $place->category_id) ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Enlace</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('link', old('link', $place->link),
                            ['required',
                            'id' => 'link',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Enlace'])
                        !!}
                    </div>
                </div>
                
                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Título en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('title_es', old('title_es', $place->title_es),
                            ['required',
                            'id' => 'title_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en español'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Descripción en español</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::textarea('description_es', old('description_es', $place->description_es),
                            ['required',
                            'id' => 'description_es',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'rows' => '4',
                            'placeholder' => 'Descripción en español'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Título en ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('title_en', old('title_en', $place->title_en),
                            ['required',
                            'id' => 'title_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'placeholder' => 'Título en ingles'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Descripción en ingles</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::textarea('description_en', old('description_en', $place->description_en),
                            ['required',
                            'id' => 'description_en',
                            'class' => 'form-control form-control-solid mb-3 mb-lg-0',
                            'rows' => '4',
                            'placeholder' => 'Descripción en ingles'])
                        !!}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <label class="col-lg-4 fw-bold fs-6 mb-2 form-check-label mr-2" for="shipping_submit">Es Popular?</label>
                        {!!
                            Form::checkbox('popular', null, $place->is_popular,
                            ['id' => 'popular',
                            'class' => 'form-check-input'
                            ])
                        !!}  
                    </div>
                </div>

				<div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6 required">Imagen Principal</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @include('commons.image-field', [
                            'required' => '',
                            'name' => 'image',
                            'default' => asset('storage/'.$place->image),
                        ])
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Galería de imágenes</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <div class="dropzone h-100 d-flex justify-content-center align-center" id="gallery-dropzone">
                            <div class="dz-message needsclick">
                                <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Arrastre los archivos aquí o haga clic para cargarlos.</h3>
                                    <span class="fs-7 fw-bold text-gray-400">Subir hasta 2 archivos</span>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('places.index') }}" class="btn btn-light me-2">Regresar</a>
                <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-info">
                    <span class="indicator-label">Actualizar</span>
                    <span class="indicator-progress">Cargando...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
			</div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('.categories').select2();

    $(document).ready(function() {
        var existingImages = @json($images);
        Dropzone.autoDiscover = false; // Deshabilita la auto-detección de Dropzone

        var myDropzone = new Dropzone("#gallery-dropzone", {
            url: "{{ route('places.update', ['place' => $place->id]) }}",    // Ruta a la que se enviarán las imágenes
            method: "POST",
            autoProcessQueue: false,              // Deshabilita la subida automática
            uploadMultiple: true,                 // Permitir subir múltiples archivos en una sola solicitud
            parallelUploads: 2,                   // Número máximo de archivos que se pueden subir simultáneamente
            maxFiles: 2,                          // Máximo de 2 archivos
            maxFilesize: 2,                       // Tamaño máximo de 2MB por archivo
            acceptedFiles: 'image/jpeg,image/png', // Solo archivos JPG y PNG
            addRemoveLinks: true,                 // Permitir eliminar archivos antes de subir
            dictDefaultMessage: "Arrastra hasta 2 imágenes aquí para subirlas (solo JPG/PNG)",
            paramName: "images",                  // El nombre del campo para enviar los archivos
            
            init: function() {
                var submitButton = document.querySelector("#kt_modal_create_api_key_submit");
                var myDropzone = this;

                existingImages.forEach(function(image) {
                    // Crea un objeto simulado para la imagen
                    var mockFile = { name: image.filename, size: 12345, type: 'image/jpeg' };  // Usa un tamaño ficticio si no lo conoces

                    // Emitir el evento "addedfile" para simular que se ha añadido la imagen
                    myDropzone.emit("addedfile", mockFile);

                    // Emitir el evento "thumbnail" para mostrar la miniatura de la imagen
                    myDropzone.emit("thumbnail", mockFile, image.url);  // La URL de la imagen actual en el servidor

                    // Marca el archivo como subido exitosamente
                    myDropzone.emit("complete", mockFile);

                    // Añadir la clase para imágenes ya subidas
                    mockFile.previewElement.classList.add('dz-success', 'dz-complete');
                });

                // Prevenir el comportamiento normal del formulario
                submitButton.addEventListener("click", function(e) {
                    e.preventDefault();  // Evita el envío inmediato del formulario

                    // Validar los campos del formulario HTML antes de procesar Dropzone
                    var form = document.querySelector("#kt_dropzonejs_example_1"); // Selector del formulario
                    if (!form.checkValidity()) {
                        form.reportValidity();  // Mostrar los mensajes de validación nativos de HTML
                        return;  // Detener la ejecución si hay campos no válidos
                    }

                    // Si hay archivos en cola, procesar la subida
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();  // Procesar la cola de archivos
                    } else {
                        // Si no hay archivos, enviar el formulario directamente
                        $("#kt_dropzonejs_example_1")[0].submit();
                    }
                });

                // Subir los archivos después de procesar la cola
                this.on("sendingmultiple", function(file, xhr, formData) {
                    // Agregar otros campos del formulario a la solicitud de Dropzone
                    formData.append("_token", `{{ csrf_token() }}`);
                    formData.append("_method", "PUT")
                    formData.append("category_id", $("#category_id").val());
                    formData.append("link", $("#link").val());
                    formData.append("title_es", $("#title_es").val());
                    formData.append("title_en", $("#title_en").val());
                    formData.append("description_es", $("#description_es").val());
                    formData.append("description_en", $("#description_en").val());
                    formData.append("popular", $("#popular").val());

                    var image = document.querySelector('#image').files[0];
                    if (image) {
                        formData.append('image', image);  // Añadir la imagen al FormData
                    }
                });

                // Si se suben exitosamente todos los archivos
                this.on("successmultiple", function(files, response) {
                    console.log("Archivos subidos exitosamente.");
                    
                    // Mostrar el mensaje de éxito usando Toastr o cualquier otra librería
                    toastr.success(response.message);

                    // Redirigir después de mostrar el mensaje
                    setTimeout(function() {
                        window.location.href = response.redirect;  // Redirigir a la URL devuelta por el servidor
                    }, 2000);  // Redirigir después de 2 segundos para mostrar el mensaje
                });

                // Si hay un error al subir los archivos
                this.on("errormultiple", function(files, response) {
                    console.error("Error al subir los archivos.");
                });
            }
        });
    });
</script>

@endsection

<style>
    /* Ajustar las imágenes dentro del contenedor de Dropzone */
.dropzone .dz-preview .dz-image {
    width: 100%;        /* Asegura que ocupe el 100% del contenedor */
    height: auto;       /* Ajusta la altura de manera proporcional */
    max-height: 125px;   /* Altura máxima para la imagen */
    max-width: 125px;    /* Ancho máximo para la imagen */
    overflow: hidden;   /* Oculta cualquier parte desbordante */
}

.dropzone .dz-preview .dz-image img {
    width: 100%;        /* Ajusta el ancho de la imagen al 100% del contenedor */
    height: 100%;       /* Mantiene la proporción de la imagen */
    object-fit: cover;  /* Asegura que la imagen se ajuste bien al contenedor */
    max-width: 125px;   /* Define un ancho máximo para la imagen */
    max-height: 125px;  /* Define una altura máxima para la imagen */
}

</style>