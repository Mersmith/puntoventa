<div>
    <!--SEO-->
    @section('tituloPagina', 'PRODUCTOS')

    <!--CONTENEDOR CABECERA-->
    <div class="contenedor_administrador_cabecera">
        <!--CONTENEDOR TITULO-->
        <div class="contenedor_titulo_admin">
            <h2>Productos</h2>
        </div>

        <!--CONTENEDOR BOTONES-->
        <div class="contenedor_botones_admin">
            <a href="{{ route('administrador.producto.crear') }}">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div class="contenedor_administrador_contenido">
        @if ($productos->count())

            <!--BUSCADOR-->
            <div class="contenedor_panel_producto_admin formulario">
                <div class="contenedor_elemento_item">
                    <p class="estilo_nombre_input">Buscar producto: <span class="campo_opcional">(Opcional)</span> </p>
                    <input type="text" wire:model="buscarProducto"
                        placeholder="Ingrese el nombre del producto que quiere buscar.">
                </div>
            </div>

            <!--TABLA-->
            <div class="contenedor_panel_producto_admin">
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
                                        Categoría</th>
                                    <th>
                                        Estado</th>
                                    <th>
                                        Precio</th>
                                    <th>
                                        Proveedor</th>
                                    <th>
                                        Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>
                                            <div class="tabla_imagen">
                                                @if ($producto->imagenes->count())
                                                    <img src="{{ Storage::url($producto->imagenes->first()->imagen_ruta) }}"
                                                        alt="" />
                                                @else
                                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            {{ $producto->nombre }}
                                        </td>
                                        <td>
                                            {{ $producto->slug }}
                                        </td>
                                        <td>
                                            {{ $producto->subcategoria->categoria->nombre }}
                                        </td>
                                        <td>
                                            @switch($producto->estado)
                                                @case(0)
                                                    <label class="tabla_switch">
                                                        <input type="checkbox" disabled>
                                                        <span class="slider redondo"></span>
                                                    </label>
                                                @break

                                                @case(1)
                                                    <label class="tabla_switch">
                                                        <input type="checkbox" checked disabled>
                                                        <span class="slider redondo"></span>
                                                    </label>
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $producto->precio_venta }}
                                        </td>
                                        <td>
                                            {{ $producto->proveedor->nombre }}
                                        </td>
                                        <td>
                                            <a class="tabla_editar"
                                                href="{{ route('administrador.producto.editar', $producto) }}">
                                                <i class="fa-solid fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            @if ($productos->hasPages())
                <div>
                    {{ $productos->links('pagination::tailwind') }}
                </div>
            @endif
        @else
            <div class="contenedor_no_existe_elementos">
                <p>No hay elementos</p>
                <i class="fa-solid fa-spinner"></i>
            </div>
        @endif

    </div>

</div>
