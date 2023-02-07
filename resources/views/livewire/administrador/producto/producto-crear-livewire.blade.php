<div>
    <!--SEO-->
    @section('tituloPagina', 'CREAR PRODUCTO')

    <!--CONTENEDOR CABECERA-->
    <div class="contenedor_administrador_cabecera">
        <!--CONTENEDOR TITULO-->
        <div class="contenedor_titulo_admin">
            <h2>Crear producto</h2>
        </div>

        <!--CONTENEDOR BOTONES-->
        <div class="contenedor_botones_admin">
            <a href="{{ route('administrador.producto.index') }}">
                <i class="fa-solid fa-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <!--CONTENEDOR CONTENIDO-->
    <div class="contenedor_administrador_contenido" x-data>

        <!--FORMULARIO-->
        <form wire:submit.prevent="crearProducto" x-data class="formulario">

            <!--ESTADO-->
            <div class="contenedor_panel_producto_admin">
                <div class="contenedor_2_elementos">
                    <div class="contenedor_elemento_item">
                        <p>Estado del producto: <span class="campo_opcional">(Opcional)</span> </p>
                        <div>
                            <label>
                                <input type="radio" value="0" name="estado"  wire:model.defer="estado">
                                Desactivado
                            </label>
                            <label>
                                <input type="radio" value="1" name="estado"  wire:model.defer="estado">
                                Activado
                            </label>
                        </div>
                        @error('estado')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!--INFORMACIÓN-->
            <div class="contenedor_panel_producto_admin">
                <!--PROVEEDOR Y CATEGORIAS-->
                <div class="contenedor_2_elementos">
                    <!--PROVEEDOR-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Proveedores: <span class="campo_obligatorio">(Obligatorio)</span>
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
                        <p class="estilo_nombre_input">Categorias: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <select wire:model="categoria_id">
                            <option value="" selected disabled>Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id')
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
                        <select wire:model="subcategoria_id">
                            <option value="" selected disabled>Seleccione una subcategoría</option>
                            @foreach ($subcategorias as $subcategoria)
                                <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                            @endforeach
                        </select>
                        @if ($subcategoria_id)
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
                        @error('subcategoria_id')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>

                    <!--MARCAS-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Marcas: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <select wire:model="marca_id">
                            <option value="" selected disabled>Seleccione una marca</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                        @error('marca_id')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--NOMBRE Y SLUG-->
                <div class="contenedor_2_elementos">
                    <!--NOMBRE-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Nombre: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="text" wire:model="nombre">
                        @error('nombre')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>

                    <!--SLUG-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Slug: <span class="campo_obligatorio">(Obligatorio)</span></p>
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
                        <p class="estilo_nombre_input">Precio real: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <input type="number" wire:model="precio_real">
                        @error('precio_real')
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
                        <input type="number" wire:model="precio_venta">
                        <br>
                        @if ($precio_venta)
                            @if ($precio_venta == $precio_real)
                                <code>No tiene descuento.</code>
                            @elseif($precio_real > $precio_venta)
                                <code>Tiene un descuento de: %{{ 100 - (100 * $precio_venta) / $precio_real }}</code>
                            @else
                                <code>El precio de Oferta tiene que ser menor al precio Real.</code>
                            @endif
                        @endif
                        @error('precio_venta')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>

                    <!--STOCK TOTAL-->
                    @if ($this->subcategoria)
                        <!--Propiedad computada-->
                        @if (!$this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida)
                            <!--Stock-->
                            <div class="contenedor_elemento_item">
                                <label class="label_principal">
                                    <p class="estilo_nombre_input">Stock: <span
                                            class="campo_obligatorio">(Obligatorio)</span> </p>
                                    <input type="number" wire:model="stock_total">
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
                        <textarea rows="3" wire:model="descripcion"></textarea>
                        @error('descripcion')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--INFORMACIÓN-->
                <div class="contenedor_1_elementos_100" wire:ignore>
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Información: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <textarea rows="3"wire:model="informacion" x-data x-init="ClassicEditor.create($refs.miEditor, {
                                toolbar: ['bold', 'italic', 'link', 'undo', 'redo', 'bulletedList', 'uploadImage'],
                                simpleUpload: {
                                    uploadUrl: '{{ route('administrador.ckeditor.upload') }}'
                                }
                            })
                            .then(function(editor) {
                                editor.model.document.on('change:data', () => {
                                    @this.set('informacion', editor.getData())
                                })
                            })
                            .catch(error => {
                                console.error(error);
                            });" x-ref="miEditor">
                                </textarea>
                    </div>
                </div>
                @error('informacion')
                    <span class="campo_obligatorio">{{ $message }}</span>
                @enderror

                <!--PUNTOS-->
                <div class="contenedor_2_elementos">
                    <!--Puntos a ganar-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Puntos a ganar: <span class="campo_opcional">(Opcional)</span>
                        </p>
                        <input type="number" wire:model="puntos_ganar">
                        @error('puntos_ganar')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!--TAGS-->
            <div class="contenedor_panel_producto_admin">
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Etiquetas: <span class="campo_opcional">(Opcional)</span>
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

            <!--LINK VIDEO-->
            <div class="contenedor_panel_producto_admin">
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Link video youtube embed: <span
                                class="campo_opcional">(Opcional)</span> </p>
                        <textarea rows="1" wire:model="link_video"></textarea>
                        @error('link_video')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>


            <!--TIENE DETALLE-->
            <div class="contenedor_panel_producto_admin">
                <div class="contenedor_1_elementos">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">¿Tiene detalle?: <span class="campo_opcional">(Opcional)</span>
                        </p>
                        <div>
                            <label>
                                <input type="radio" value="0" name="tiene_detalle"
                                    wire:model.defer="tiene_detalle" x-on:click="$wire.tiene_detalle = false">
                                No
                            </label>
                            <label>
                                <input type="radio" value="1" name="tiene_detalle"
                                    wire:model.defer="tiene_detalle" x-on:click="$wire.tiene_detalle = true">
                                Si
                            </label>
                        </div>
                        @error('tiene_detalle')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--DETALLE-->
                <div class="contenedor_1_elementos_100" wire:ignore x-show="$wire.tiene_detalle">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Detalle: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <textarea rows="3" wire:model="detalle" id="detalle" x-data x-init="ClassicEditor.create($refs.miEditor2, {
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

            <!--TIENE IGV-->
            <div class="contenedor_panel_producto_admin">
                <div class="contenedor_1_elementos">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">¿Tiene IGV?: <span class="campo_opcional">(Opcional)</span></p>

                        <div>
                            <label>
                                <input type="radio" value="0" wire:model.defer="incluye_igv"
                                    x-on:click="$wire.incluye_igv = 0">
                                No
                            </label>
                            <label>
                                <input type="radio" value="1" wire:model.defer="incluye_igv"
                                    x-on:click="$wire.incluye_igv = 1">
                                Si
                            </label>
                        </div>
                        @error('incluye_igv')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!--IMAGENES-->
            <div class="contenedor_panel_producto_admin">
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Imagenes: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <div class="contenedor_subir_imagen_sola">
                            <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                            <div class="opcion_cambiar_imagen">
                                <label for="imagenes">
                                    <div style="cursor: pointer;">
                                        Subir <i class="fa-solid fa-camera"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <input type="file" wire:model="imagenes" multiple style="display: none" id="imagenes">
                        @error('imagenes')
                            <span class="campo_obligatorio">{{ $message }} </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!--Imagenes-->
            <div class="contenedor_panel_producto_admin"  id="sortableimagenes">
                @if ($imagenes)
                    <div class="contenedor_1_elementos_imagen">
                        <div class="contenedor_imagenes_subidas_dropzone">
                            @foreach ($imagenes as $key => $imagen)
                                <div wire:key="{{ $loop->index }}" data-id="{{ $key }}">
                                    <img class="handle2 cursor-grab" src="{{ $imagen->temporaryUrl() }}">
                                    <span class="imagen_dropzone_eliminar" wire:click="eliminarImagen({{ $loop->index }})">
                                        <i class="fa-solid fa-xmark"style="color: white;"></i>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!--ENVIAR-->
            <div class="contenedor_1_elementos">
                <input type="submit" value="Crear Producto">
            </div>
        </form>

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
                    Livewire.emitTo('administrador.producto.producto-crear-livewire',
                        'cambiarPosicionImagenes', sorts);
                },
                onStart: function(evt) {
                    console.log(evt.oldIndex);
                },
            }
        });

        $(document).ready(function() {
            $('.select_categorias_producto').select2();
        });

        $(document).ready(function() {
            $('.select_subcategorias_producto').select2();
        });

        $(document).ready(function() {
            $('.select_proveedores_producto').select2();
        });

        $(document).ready(function() {
            $('.select_tags_producto').select2();
        });
    </script>
@endpush
