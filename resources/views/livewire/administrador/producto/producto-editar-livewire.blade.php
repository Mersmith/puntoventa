<div>
    <!--SEO-->
    @section('tituloPagina', 'EDITAR PRODUCTO')

    <!--CONTENEDOR CABECERA-->
    <div class="contenedor_administrador_cabecera">
        <!--CONTENEDOR TITULO-->
        <div class="contenedor_titulo_admin">
            <h2>Actualizar producto</h2>
        </div>

        <!--CONTENEDOR BOTONES-->
        <div class="contenedor_botones_admin">
            <a href="{{ route('administrador.producto.index') }}">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
            <button wire:click="$emit('eliminarProductoModal')">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>
            <a href="{{ route('administrador.producto.crear') }}">
                Crear <i class="fa-solid fa-square-plus"></i></a>
            <a href="{{ route('producto.index', $producto) }}" target="_blank">
                Ver <i class="fa-solid fa-eye"></i></a>
        </div>
    </div>

    <!--CONTENEDOR CONTENIDO-->
    <div class="contenedor_administrador_contenido" x-data>
        <!--CONTENEDOR TAB-->
        <div class="contenedor_tab" x-data="{ activarTab: 2 }">
            <!--MENU TAB-->
            <div class="contenedor_tab_menu contenedor_panel_producto_admin">
                <label @click="activarTab = 0" class="menu_tab" :class="{ 'activo': activarTab === 0 }">Info</label>
                <label @click="activarTab = 1" class="menu_tab" :class="{ 'activo': activarTab === 1 }">Galeria</label>
                @if ($this->subcategoria)
                    @if ($this->subcategoria->tiene_medida && !$this->subcategoria->tiene_color)
                        <label @click="activarTab = 2" class="menu_tab"
                            :class="{ 'activo': activarTab === 2 }">Medida</label>
                    @elseif ($this->subcategoria->tiene_color && $this->subcategoria->tiene_medida)
                        <label @click="activarTab = 3" class="menu_tab" :class="{ 'activo': activarTab === 3 }">Medida y
                            Color</label>
                    @elseif($this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida)
                        <label @click="activarTab = 4" class="menu_tab"
                            :class="{ 'activo': activarTab === 4 }">Color</label>
                    @endif
                @endif
                <label @click="activarTab = 5" class="menu_tab" :class="{ 'activo': activarTab === 5 }">Código</label>
                <label @click="activarTab = 6" class="menu_tab" :class="{ 'activo': activarTab === 6 }">SEO</label>
                <label @click="activarTab = 7" class="menu_tab"
                    :class="{ 'activo': activarTab === 7 }">Estadística</label>
            </div>

            <!--CUERPO TAB-->
            <!--INFORMACIÓN-->
            <div class="tab_contenido" :class="{ 'activo': activarTab === 0 }"
                x-show.transition.in.opacity.duration.600="activarTab === 0">
                <div class="contenedor_panel_producto_admin">
                    <!--ESTADO-->
                    @livewire('administrador.producto.producto-estado-livewire', ['productoEstado' => $producto], key('producto-estado-livewire-' . $producto->id))
                </div>

                <div class="formulario">

                    <div class="contenedor_panel_producto_admin">

                        <!--PROVEEDOR Y CATEGORIAS-->
                        <div class="contenedor_2_elementos">
                            <!--PROVEEDOR-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Proveedores: <span
                                        class="campo_obligatorio">(Obligatorio)</span>
                                </p>
                                <select wire:model="proveedor_id">
                                    <option value="" selected disabled>Seleccione un proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>

                            <!--CATEGORIAS-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Categorias: <span
                                        class="campo_obligatorio">(Obligatorio)</span>
                                </p>
                                <select wire:model="categoria_id">
                                    <option value="" selected disabled>Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--SUBCATEGORIAS Y MARCAS-->
                        <div class="contenedor_2_elementos">
                            <!--SUBCATEGORIAS-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Subcategorias: <span
                                        class="campo_obligatorio">(Obligatorio)</span>
                                </p>
                                <select wire:model="producto.subcategoria_id">
                                    <option value="" selected disabled>Seleccione una subcategoría</option>
                                    @foreach ($subcategorias as $subcategoria)
                                        <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($this->subcategoria)
                                    <!--Propiedad computada-->
                                    @if ($this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida)
                                        <code>El producto varia en Color</code>
                                    @elseif(!$this->subcategoria->tiene_color && $this->subcategoria->tiene_medida)
                                        <code>El producto varia en Medida</code>
                                    @elseif($this->subcategoria->tiene_color && $this->subcategoria->tiene_medida)
                                        <code>El producto varia en Color y Medida</code>
                                    @else
                                        <code>El producto No tiene Variación</code>
                                    @endif
                                @endif
                                @error('producto.subcategoria_id')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                            <!--MARCAS-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Marcas: <span
                                        class="campo_obligatorio">(Obligatorio)</span>
                                </p>
                                <select wire:model="producto.marca_id">
                                    <option value="" selected disabled>Seleccione una marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('producto.marca_id')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--NOMBRE Y SLUG-->
                        <div class="contenedor_2_elementos">
                            <!--NOMBRE-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Nombre: <span
                                        class="campo_obligatorio">(Obligatorio)</span></p>
                                <input type="text" wire:model="producto.nombre">
                                @error('producto.nombre')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                            <!--SLUG-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Slug: <span
                                        class="campo_obligatorio">(Obligatorio)</span></p>
                                <input type="text" wire:model="slug">
                                @error('slug')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--SKU Y PRECIO REAL-->
                        <div class="contenedor_2_elementos">
                            <!--SKU-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">SKU: <span class="campo_obligatorio">(Obligatorio)</span>
                                </p>
                                <input type="text" wire:model="sku">
                                @error('sku')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                            <!--PRECIO REAL-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Precio real: <span
                                        class="campo_obligatorio">(Obligatorio)</span></p>
                                <input type="number" wire:model="producto.precio_real" step="0.01">
                                @error('producto.precio_real')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--PRECIO OFERTA Y STOCK -->
                        <div class="contenedor_2_elementos">
                            <!--PRECIO OFERTA-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Precio oferta: <span
                                        class="campo_obligatorio">(Obligatorio)</span></p>
                                <input type="number" wire:model="producto.precio_venta" step="0.01">
                                <br>
                                @if ($producto->precio_venta)
                                    @if ($producto->precio_venta == $producto->precio_real)
                                        <code>No tiene descuento.</code>
                                    @elseif($producto->precio_real > $producto->precio_venta)
                                        <code>Tiene un descuento de:
                                            %{{ 100 - (100 * $producto->precio_venta) / $producto->precio_real }}</code>
                                    @else
                                        <code>El precio de Oferta tiene que ser menor al precio Real.</code>
                                    @endif
                                @endif
                                @error('producto.precio_venta')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                            <!--STOCK-->
                            @if ($this->subcategoria)
                                <!--Propiedad computada-->
                                @if (!$this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida)
                                    <!--Stock-->
                                    <div class="contenedor_elemento_item">
                                        <label class="label_principal">
                                            <p class="estilo_nombre_input">Stock: <span
                                                    class="campo_obligatorio">(Obligatorio)</span> </p>
                                            <input type="number" wire:model="stock_total" step="1">
                                        </label>
                                    </div>
                                @endif
                            @endif
                            @error('stock_total')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>

                        <!--DESCRIPCIÓN CORTA-->
                        <div class="contenedor_1_elementos_100">
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Descripción corta: <span
                                        class="campo_obligatorio">(Obligatorio)</span> </p>
                                <textarea rows="3" wire:model="producto.descripcion"></textarea>
                                @error('producto.descripcion')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!--INFORMACIÓN-->
                        <div class="contenedor_1_elementos_100" wire:ignore>
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Información: <span
                                        class="campo_obligatorio">(Obligatorio)</span></p>
                                <textarea rows="3" wire:model="producto.informacion" x-data x-init="ClassicEditor.create($refs.miEditor, {
                                        toolbar: ['bold', 'italic', 'link', 'undo', 'redo', 'bulletedList', 'uploadImage'],
                                        simpleUpload: {
                                            uploadUrl: '{{ route('administrador.ckeditor.upload') }}'
                                        }
                                    })
                                    .then(function(editor) {
                                        editor.model.document.on('change:data', () => {
                                            @this.set('producto.informacion', editor.getData())
                                        })
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });" x-ref="miEditor">
                                </textarea>
                            </div>
                        </div>
                        @error('producto.informacion')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror

                        <!--PUNTOS-->
                        <div class="contenedor_2_elementos">
                            <!--Puntos a ganar-->
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Puntos a ganar: <span
                                        class="campo_opcional">(Opcional)</span> </p>
                                <input type="number" wire:model="producto.puntos_ganar" step="1">
                                @error('producto.puntos_ganar')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="contenedor_panel_producto_admin">
                        <!--TAGS-->
                        <div class="contenedor_1_elementos_100">
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Etiquetas: <span
                                        class="campo_opcional">(Opcional)</span>
                                </p>
                                @if ($tagsDb->count())
                                    <div>
                                        @foreach ($tagsDb as $tagsDbItem)
                                            <label>
                                                <input type="checkbox" name="tags[]" wire:model.defer="tags"
                                                    value="{{ $tagsDbItem->id }}">
                                                <span> {{ $tagsDbItem->nombre }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('tags')
                                        <span class="campo_obligatorio">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="contenedor_panel_producto_admin">
                        <!--LINK VIDEO-->
                        <div class="contenedor_1_elementos_100">
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Link video youtube embed: <span
                                        class="campo_opcional">(Opcional)</span> </p>
                                <textarea rows="1" wire:model="link_video"></textarea>
                                @error('link_video')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="contenedor_panel_producto_admin">
                        <!--TIENE DETALLE-->
                        <div class="contenedor_1_elementos">
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">¿Tiene detalle?: <span
                                        class="campo_opcional">(Opcional)</span> </p>
                                <div>
                                    <label>
                                        <input type="radio" value="0" name="producto.tiene_detalle"
                                            wire:model.defer="producto.tiene_detalle"
                                            x-on:click="$wire.tiene_detalle = 0">
                                        No
                                    </label>
                                    <label>
                                        <input type="radio" value="1" name="producto.tiene_detalle"
                                            wire:model.defer="producto.tiene_detalle"
                                            x-on:click="$wire.tiene_detalle = 1">
                                        Si
                                    </label>
                                </div>
                                @error('producto.tiene_detalle')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!--DETALLE-->
                        <div class="contenedor_1_elementos_100" wire:ignore x-show="$wire.tiene_detalle">
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">Detalle: <span
                                        class="campo_obligatorio">(Obligatorio)</span></p>
                                <textarea rows="3" wire:model="detalle" x-data x-init="ClassicEditor.create($refs.miEditor2, {
                                        toolbar: ['insertTable', 'bold'],
                                        table: {
                                            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                                        }
                                    })
                                    .then(function(editor2) {
                                        editor2.model.document.on('change:data', () => {
                                            @this.set('detalle', editor2.getData())
                                        })
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    });" x-ref="miEditor2">
                                </textarea>
                            </div>
                        </div>
                        @error('detalle')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="contenedor_panel_producto_admin">
                        <!--Tiene IGV-->
                        <div class="contenedor_1_elementos">
                            <div class="contenedor_elemento_item">
                                <p class="estilo_nombre_input">¿Tiene IGV?: <span
                                        class="campo_opcional">(Opcional)</span></p>
                                <div>
                                    <label>
                                        <input type="radio" value="0" name="producto.incluye_igv"
                                            wire:model.defer="producto.incluye_igv"
                                            x-on:click="$wire.incluye_igv = 0">
                                        No
                                    </label>
                                    <label>
                                        <input type="radio" value="1" name="producto.incluye_igv"
                                            wire:model.defer="producto.incluye_igv"
                                            x-on:click="$wire.incluye_igv = 1">
                                        Si
                                    </label>
                                </div>
                                @error('producto.incluye_igv')
                                    <span class="campo_obligatorio">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!--ENVIAR-->
                    <div class="contenedor_1_elementos">
                        <!--<input type="submit" value="Actualizar Producto">-->
                        <button wire:loading.attr="disabled" wire:target="editarProducto"
                            wire:click="editarProducto">
                            Actualizar producto
                        </button>
                    </div>
                </div>
            </div>
            <!--GALERIA-->
            <div class="tab_contenido" :class="{ 'activo': activarTab === 1 }"
                x-show.transition.in.opacity.duration.600="activarTab === 1">
                <!--Dropzone-->
                <div class="contenedor_panel_producto_admin">
                    <div class="contenedor_elemento_formulario" wire:ignore>
                        <form action="{{ route('administrador.producto.dropzone', $producto) }}" method="POST"
                            class="dropzone" id="my-awesome-dropzone"></form>
                    </div>
                </div>
                <!--Imagenes-->
                <div class="contenedor_panel_producto_admin">
                    @if ($producto->imagenes->count())
                        <div class="contenedor_1_elementos_imagen">
                            <div class="contenedor_imagenes_subidas_dropzone" id="sortableimagenes">
                                @foreach ($producto->imagenes->sortBy('posicion') as $key => $imagen)
                                    <div wire:key="imagen-{{ $imagen->id }}" data-id="{{ $imagen->id }}">
                                        <img class="handle2 cursor-grab"
                                            src="{{ Storage::url($imagen->imagen_ruta) }}" alt="">
                                        <span class="imagen_dropzone_eliminar"
                                            wire:click="eliminarImagen({{ $imagen->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="eliminarImagen({{ $imagen->id }})">
                                            <i class="fa-solid fa-xmark" style="color: white;"></i>
                                        </span>
                                        @if ($loop->first)
                                            <span class="imagen_dropzone_primero">
                                                <i class="fa-solid fa-1" style="color: white;"></i>
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!--VARIACIONES-->
            @if ($this->subcategoria)
                @if ($this->subcategoria->tiene_medida && !$this->subcategoria->tiene_color)
                    <!--VARIACÓN EN MEDIDAS-->
                    <div class="tab_contenido" :class="{ 'activo': activarTab === 2 }"
                        x-show.transition.in.opacity.duration.600="activarTab === 2">
                        @livewire('administrador.producto.componente-varia-medida', ['producto' => $producto], key('producto.componente-varia-medida-' . $producto->id))
                    </div>
                @elseif ($this->subcategoria->tiene_color && $this->subcategoria->tiene_medida)
                    <!--VARIACÓN EN MEDIDA Y COLOR-->
                    <div class="tab_contenido" :class="{ 'activo': activarTab === 3 }"
                        x-show.transition.in.opacity.duration.600="activarTab === 3">
                        @livewire('administrador.producto.componente-varia-medida-color', ['producto' => $producto], key('producto.componente-varia-medida-color-' . $producto->id))
                    </div>
                @elseif($this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida)
                    <!--VARIACÓN EN COLOR-->
                    <div class="tab_contenido" :class="{ 'activo': activarTab === 4 }"
                        x-show.transition.in.opacity.duration.600="activarTab === 4">
                        @livewire('administrador.producto.componente-varia-color', ['producto' => $producto], key('producto.componente-varia-color-' . $producto->id))
                    </div>
                @endif
            @endif
            <!--CÓDIGO-->
            <div class="tab_contenido" :class="{ 'activo': activarTab === 5 }"
                x-show.transition.in.opacity.duration.600="activarTab === 5">
                <!--CODIGO DE BARRA-->
                <div class="contenedor_panel_producto_admin">
                    <!--CONTENEDOR SUBTITULO-->
                    <div class="contenedor_subtitulo_admin">
                        <h3>Código de barra</h3>
                    </div>
                    <!--CONTENEDOR BOTONES-->
                    <div class="contenedor_botones_admin">
                        <a download="{{ $this->producto->sku . '.png' }}"
                            href="data:image/png;base64,{{ DNS1D::getBarcodePNG($producto->sku, 'C128', 2, 33) }}">Descargar
                            <i class="fa-solid fa-square-plus"></i></a>
                    </div>
                    {!! DNS1D::getBarcodeSVG($producto->sku, 'C128', 2, 45, true) !!}
                    {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($producto->sku, 'C128', 2, 33) }}" alt=""> --}}
                </div>

                <!--CODIGO QR-->
                <div class="contenedor_panel_producto_admin">
                    <div class="contenedor_subtitulo_admin">
                        <h3>Código de QR</h3>
                    </div>
                    <!--CONTENEDOR BOTONES-->
                    <div class="contenedor_botones_admin">
                        <button wire:click="descargarQR">
                            Descargar <i class="fa-solid fa-download"></i>
                        </button>
                        <a href="{{ route('producto.index', $producto->slug) }}" target="_blank">
                            Ver <i class="fa-solid fa-eye"></i></a>

                        <a href="{{ route('producto.redirigir.qr', $producto->slug) }}" target="_blank">
                            Redirigir <i class="fa-solid fa-qrcode"></i></a>
                    </div>
                    {!! QrCode::size(200)->generate(route('producto.redirigir.qr', $producto->slug)) !!}
                </div>
            </div>
            <!--SEO-->
            <div class="tab_contenido" :class="{ 'activo': activarTab === 6 }"
                x-show.transition.in.opacity.duration.600="activarTab === 6">
            </div>
            <!--ESTADÍSTICA-->
            <div class="tab_contenido" :class="{ 'activo': activarTab === 7 }"
                x-show.transition.in.opacity.duration.600="activarTab === 7">
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        new Sortable(sortableimagenes, {
            handle: '.handle2',
            animation: 150,
            ghostClass: 'bg-blue-100',
            store: {
                set: function(sortable) {
                    const sorts = sortable.toArray();
                    //console.log(sorts);
                    Livewire.emitTo('administrador.producto.producto-editar-livewire',
                        'cambiarPosicionImagenes', sorts);
                },
                onStart: function(evt) {
                    console.log(evt.oldIndex);
                },
            }
        });

        let mensajeDropZone =
            "<div class='mensaje_dropzone'><i class='fa-solid fa-cloud-arrow-up'></i><span>Suelte las imagenes aquí o haga clic para subir.</span></div>";

        Dropzone.options.myAwesomeDropzone = {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            dictDefaultMessage: mensajeDropZone,
            acceptedFiles: 'image/*',
            paramName: "file",
            maxFilesize: 2,
            complete: function(file) {
                this.removeFile(file);
            },
            queuecomplete: function() {
                Livewire.emit('dropImagenes');
            }
        };

        Livewire.on('eliminarProductoModal', () => {
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
                    Livewire.emitTo('administrador.producto.producto-editar-livewire',
                        'eliminarProducto');
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    )
                }
            })
        })

        Livewire.on('eliminarPivotColorModal', colorPivotId => {
                Swal.fire({
                    title: '¿Quieres eliminar?',
                    text: "No podrás recupar esta medida.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('administrador.producto.componente-varia-color',
                            'eliminarPivotColor', colorPivotId);
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
</div>
