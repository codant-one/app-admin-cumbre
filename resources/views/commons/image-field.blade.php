<div class="{{ $classImage ?? 'rounded border p-10' }}">
   @if($default !== null)
   @php
      $default.='?'.rand(10000,99999);
   @endphp
   <div class="image-input image-input-outline" data-kt-image-input="true"
      style="background-image: url( '{{ asset('images/avatars/blank.png') }}' )">

      <div id="bg_{{$name}}" class="image-input-wrapper w-125px h-125px remove-image-event" style="background-image: url('{{ $default }}'); @isset($style) {{ $style }} @endisset"></div>
   @else
   <div class="image-input image-input-empty" data-kt-image-input="true"
      style="background-image: url( '{{ asset('images/avatars/blank.png') }}' )">

      <div id="bg_{{$name}}" class="image-input-wrapper w-125px h-125px"></div>
   @endif
   
      <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow btn-change"
         data-kt-image-input-action="change"
         data-bs-toggle="tooltip"
         data-bs-dismiss="click"
         title="Actualizar imagen">
   
         <i class="bi bi-pencil-fill fs-7"></i>
   
         <input type="file" id="{{ $name }}" name="{{ $name }}" accept=".png, .jpg, .jpeg" {{ $required ?? '' }}/>
         <input type="hidden" name="{{ $name }}_remove" />
   
      </label>
   
      <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow btn-cancel"
         data-kt-image-input-action="cancel"
         data-bs-toggle="tooltip"
         data-bs-dismiss="click"
         title="Remover imagen">
         <i class="bi bi-x fs-2"></i>
      </span>
   
      <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow btn-remove"
         data-kt-image-input-action="remove"
         data-bs-toggle="tooltip"
         data-bs-dismiss="click"
         title="Remover imagen"
         id="{{ $name }}_remove">
         <i class="bi bi-x fs-2"></i>
      </span>
   
   </div>
</div>