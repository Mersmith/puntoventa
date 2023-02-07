<div>
    <!--SEO-->
    @section('tituloPagina', 'PERFIL')

    <!--CONTENEDOR CABECERA-->
    <div class="contenedor_administrador_cabecera">
        <!--CONTENEDOR TITULO-->
        <div class="contenedor_titulo_admin">
            <h2>Perfil</h2>
        </div>
    </div>

    <div class="contenedor_administrador_contenido">
        <!--FORMULARIO-->
        <div x-data class="formulario">
            <div class="contenedor_panel_producto_admin">

                <!--EMAIL Y NOMBRE-->
                <div class="contenedor_2_elementos">
                    <!--EMAIL-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Email: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="email" wire:model="email" disabled>
                        @error('email')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <!--NOMBRE-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Nombres: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="text" wire:model="nombre">
                        @error('nombre')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="contenedor_2_elementos">
                    <!--APELLIDO-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Apellidos: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <input type="text" wire:model="apellido">
                        @error('apellido')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>

                    <!--CELULAR-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Celular: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="tel" wire:model="celular">
                        @error('celular')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="contenedor_panel_producto_admin">
                <!--IMAGEN-->
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Imagen: <span class="campo_opcional">(Opcional)</span></p>
                        <div class="contenedor_subir_imagen_sola">
                            @if ($editarImagen)
                                <img src="{{ $editarImagen->temporaryUrl() }}">
                                <span class="boton_imagen_eliminar" wire:click="$set('editarImagen', null)">
                                    <i class="fa-solid fa-xmark"></i>
                                </span>
                            @elseif($imagen)
                                <img src="{{ Storage::url($administrador->imagen->imagen_ruta) }}">
                                <span class="boton_imagen_borrar" wire:click="$set('imagen', null)">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                            @else
                                <img src="{{ asset('imagenes/perfil/sin_foto_perfil.png') }}">
                            @endif
                            <div class="opcion_cambiar_imagen">
                                <label for="imagen">
                                    <div style="cursor: pointer;">
                                        Editar <i class="fa-solid fa-camera"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <input type="file" wire:model="editarImagen" style="display: none" id="imagen">
                        @error('editarImagen')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!--ENVIAR-->
            <div class="contenedor_1_elementos">
                <button wire:loading.attr="disabled" wire:target="editarAdministrador" wire:click="editarAdministrador">
                    Actualizar administrador
                </button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        Livewire.on('eliminarAdministradorModal', () => {
            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás recuparlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('administrador.perfil.perfil-livewire',
                        'eliminarAdministador');
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    )
                }
            })
        })
    </script>
@endpush
