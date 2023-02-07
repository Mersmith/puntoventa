<div>
    <!--SEO-->
    @section('tituloPagina', 'Categorias')

    <!--CONTENEDOR CABECERA-->
    <div class="contenedor_administrador_cabecera">
        <!--CONTENEDOR TITULO-->
        <div class="contenedor_titulo_admin">
            <h2>Categorias</h2>
        </div>
    </div>

    <!--CONTENEDOR CONTENIDO-->
    <div class="contenedor_administrador_contenido" x-data>
        <!--FORMULARIOS-->
        <div class="contenedor_panel_producto_admin">
            <!--CONTENEDOR SUBTITULO-->
            <div class="contenedor_subtitulo_admin">
                <h3>Nueva categoria</h3>
            </div>
            <form wire:submit.prevent="crearCategoria" class="formulario">
                <!--NOMBRE Y SLUG-->
                <div class="contenedor_2_elementos">
                    <!--NOMBRE-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Nombre: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="text" wire:model="crearFormulario.nombre">
                        @error('crearFormulario.nombre')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                    <!--SLUG-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Slug: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="text" wire:model="crearFormulario.slug">
                        @error('crearFormulario.slug')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--DESCRIPCIÓN-->
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Descripción: <span class="campo_opcional">(Opcional)</span>
                        </p>
                        <textarea rows="2" wire:model="crearFormulario.descripcion"></textarea>
                        @error('crearFormulario.descripcion')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--MARCAS-->
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Marcas: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        @if ($marcas->count())
                            <div>
                                @foreach ($marcas as $marca)
                                    <label>
                                        <input type="checkbox" name="marcas[]" wire:model.defer="crearFormulario.marcas"
                                            value="{{ $marca->id }}">
                                        <span> {{ $marca->nombre }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('crearFormulario.marcas')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        @endif
                    </div>
                </div>

                <!--IMAGEN-->
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">

                        <p class="estilo_nombre_input">Imagen: <span class="campo_opcional">(Opcional)</span></p>
                        <div class="contenedor_subir_imagen_sola">
                            @if ($imagenSubir)
                                <img src="{{ $imagenSubir->temporaryUrl() }}">
                            @else
                                <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                            @endif
                            <div class="opcion_cambiar_imagen">
                                <label for="imagenSubir">
                                    <div style="cursor: pointer;">
                                        Editar <i class="fa-solid fa-camera"></i>
                                    </div>
                                </label>
                            </div>
                            <span class="boton_imagen_eliminar" wire:click="$set('imagenSubir', null)">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                        </div>
                        <input type="file" wire:model="imagenSubir" style="display: none" id="imagenSubir">
                        @error('imagenSubir')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--ENVIAR-->
                <div class="contenedor_1_elementos">
                    <input type="submit" value="Crear Categoria">
                </div>
            </form>
        </div>

        <!--TABLA-->
        <div class="contenedor_panel_producto_admin">

            @if ($categorias->count())
                <!--CONTENEDOR SUBTITULO-->
                <div class="contenedor_subtitulo_admin">
                    <h3>Lista</h3>
                </div>

                <!--CONTENEDOR BOTONES-->
                <div class="contenedor_botones_admin">
                    <button>
                        PDF <i class="fa-solid fa-file-pdf"></i>
                    </button>
                    <button>
                        EXCEL <i class="fa-regular fa-file-excel"></i>
                    </button>
                    <button onClick="window.scrollTo(0, document.body.scrollHeight);">
                        Abajo <i class="fa-solid fa-arrow-down"></i>
                    </button>
                </div>


                <!--TABLA-->
                <div class="tabla_administrador py-4 overflow-x-auto">
                    <div class="inline-block min-w-full overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th>
                                        Imagen</th>
                                    <th>
                                        Nombre</th>
                                    <th>
                                        Ruta</th>
                                    <th>
                                        Descripción</th>
                                    <th>
                                        Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorias as $categoriaItem)
                                    <tr>
                                        <td>
                                            <div class="tabla_imagen">
                                                @if ($categoriaItem->imagen)
                                                    <img src="{{ Storage::url($categoriaItem->imagen->imagen_ruta) }}"
                                                        alt="" />
                                                @else
                                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{ $categoriaItem->nombre }}
                                        </td>
                                        <td>
                                            {{ $categoriaItem->slug }}
                                        </td>
                                        <td>
                                            {{ Str::limit($categoriaItem->descripcion, 20) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('administrador.subcategoria.index', $categoriaItem) }}">
                                                <i class="fa-solid fa-eye" style="color: #009eff;"></i>
                                            </a> |
                                            <a style="color: green;"
                                                wire:click="editarCategoria('{{ $categoriaItem->slug }}')">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a> |
                                            <a style="color: red;"
                                                wire:click="$emit('eliminarCategoriaModal', '{{ $categoriaItem->slug }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                </div>
            @else
                <div class="contenedor_no_existe_elementos">
                    <p>No hay elementos</p>
                    <i class="fa-solid fa-spinner"></i>
                </div>
            @endif
        </div>
    </div>

    @if ($categoria)
        <!--MODAL-->
        <x-jet-dialog-modal wire:model="editarFormulario.abierto">
            <!--TITULO-->
            <x-slot name="title">
                <div class="contenedor_titulo_modal">
                    <!--ENCABEZADO-->
                    <div>
                        <h2 style="font-weight: bold">Editar</h2>
                    </div>

                    <!--CERRAR-->
                    <div>
                        <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled">
                            <i style="cursor: pointer; color: #666666;" class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </x-slot>
            <!--CONTENIDO-->
            <x-slot name="content">
                <div class="formulario">
                    <!--IMAGEN-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Imagen: <span class="campo_opcional">(Opcional)</span></p>
                            <div class="contenedor_subir_imagen_sola">
                                @if ($editarImagen)
                                    <img src="{{ $editarImagen->temporaryUrl() }}">
                                @elseif($imagen)
                                    <img src="{{ Storage::url($categoria->imagen->imagen_ruta) }}">
                                    <span class="boton_imagen_borrar" wire:click="$set('imagen', null)">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                @else
                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                @endif
                                <div class="opcion_cambiar_imagen">
                                    <label for="imagen">
                                        <div style="cursor: pointer;">
                                            Editar <i class="fa-solid fa-camera"></i>
                                        </div>
                                    </label>
                                </div>
                                <span class="boton_imagen_eliminar" wire:click="$set('editarImagen', null)">
                                    <i class="fa-solid fa-xmark"></i>
                                </span>
                            </div>
                            <input type="file" wire:model="editarImagen" style="display: none" id="imagen">
                            @error('editarImagen')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--NOMBRE-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">

                            <p class="estilo_nombre_input">Nombre: <span
                                    class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="text" wire:model="editarFormulario.nombre">
                            @error('editarFormulario.nombre')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--SLUG-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">

                            <p class="estilo_nombre_input">Slug: <span class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="text" wire:model="editarFormulario.slug">
                            @error('editarFormulario.slug')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--DESCRIPCIÓN-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">

                            <p class="estilo_nombre_input">Descripción: <span class="campo_opcional">(Opcional)</span>
                            </p>
                            <textarea rows="2" wire:model="editarFormulario.descripcion"></textarea>
                            @error('editarFormulario.descripcion')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--MARCAS-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Marcas: <span class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            @if ($marcas->count())
                                <div>
                                    @foreach ($marcas as $marca)
                                        <label>
                                            <input type="checkbox" name="marcas[]"
                                                wire:model.defer="editarFormulario.marcas"
                                                value="{{ $marca->id }}">
                                            <span> {{ $marca->nombre }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('editarFormulario.marcas')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button style="background-color: #009eff;" wire:click="$set('editarFormulario.abierto', false)"
                        wire:loading.attr="disabled" type="submit">Cancelar</button>

                    <button style="background-color: #ffa03d;" wire:click="actualizarCategoria"
                        wire:loading.attr="disabled" wire:target="actualizarCategoria" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarCategoriaModal', categoriaId => {
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
                    Livewire.emitTo('administrador.categoria.categoria-livewire',
                        'eliminarCategoria', categoriaId);
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    );
                }
            })
        });
    </script>
@endpush
