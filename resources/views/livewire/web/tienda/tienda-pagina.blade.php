<div class="contenedor_pagina_tienda" x-data="sidebarTienda" x-on:click.away="cerrarSidebarTienda()"
    @resize.window="abiertoSidebarTienda = false > 900">
    <!--CONTENEDOR PAGINA TIENDA-->
    <!--CONTENEDOR FILTRO TIENDA-->
    <div class="contenedor_filtro_tienda">

        <!--TOGGLE-->
        <div x-on:click="toggleSidebarTienda" class="toogle_tienda">
            <i class="fa-solid fa-bars" style="color: #666666;"></i>
        </div>

        <!--CONTENEDOR FILTRO LIMPIAR-->
        <div class="item_filtro_tienda">
            <div class="contenedor_titulo_filtro">
                <p>Filtro</p>
                <button wire:click="limpiarFiltro">Limpiar</button>
            </div>
        </div>

        <!--CONTENEDOR BUSCAR-->
        <div class="item_filtro_tienda">
            <div class="contenedor_titulo_filtro">
                <p>Buscar</p>
                {{-- <button>Ocultar</button> --}}
            </div>
            <div class="contenedor_cuerpo_filtro">
                <input type="text" wire:model="buscarProducto" placeholder="Buscar producto..">

            </div>
        </div>

        <!--CONTENEDOR RANGO PRECIO-->
        <div class="item_filtro_tienda">
            <div class="contenedor_titulo_filtro">
                <p>Precio</p>
                {{-- <button>Ocultar</button> --}}
            </div>
            <div class="contenedor_cuerpo_filtro">
                <div x-data="range()" x-init="mintrigger();
                maxtrigger()" class="relative" style="width: 96%;">
                    <!--Rango-->
                    <div>
                        <input wire:model="minimo" type="range" step="0" x-bind:min="min"
                            x-bind:max="max" x-on:input="mintrigger" x-model="minprice"
                            class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                        <input wire:model="maximo" type="range" step="100" x-bind:min="min"
                            x-bind:max="max" x-on:input="maxtrigger" x-model="maxprice"
                            class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                        <div class="relative z-10 h-2">
                            <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                            <div class="absolute z-20 top-0 bottom-0 rounded-m color_filtro"
                                x-bind:style="'right:' + maxthumb + '%; left:' + minthumb + '%'"></div>

                            <div class="absolute z-30 w-6 h-6 top-0 left-0 rounded-full -mt-2 -ml-1 color_filtro"
                                x-bind:style="'left: ' + minthumb + '%'"></div>

                            <div class="absolute z-30 w-6 h-6 top-0 right-0  rounded-full -mt-2 -mr-3 color_filtro"
                                x-bind:style="'right: ' + maxthumb + '%'"></div>

                        </div>
                    </div>
                    <!--Precios-->
                    <div class="flex justify-between items-center pt-5">
                        <p class="px-3 py-2 border border-gray-200 rounded w-24 text-center">$<span
                                x-text="Number(parseFloat(minprice).toFixed(2)).toLocaleString('en')"></span></p>
                        <p class="px-3 py-2 border border-gray-200 rounded w-24 text-center">$<span
                                x-text="Number(parseFloat(maxprice).toFixed(2)).toLocaleString('en')"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!--CONTENEDOR CATEGORIAS-->
        <div class="item_filtro_tienda">
            <div class="contenedor_titulo_filtro">
                <p>Categorias</p>
                {{-- <button>Ocultar</button> --}}
            </div>
            <div class="contenedor_cuerpo_filtro">
                <ul>
                    @foreach ($categorias as $categoriaItem)
                        <li>
                            <a wire:click="$set('categoria', '{{ $categoriaItem->id }}')"
                                style="color: {{ $categoria == $categoriaItem->id ? '#ffa03d' : '' }}"
                                class="cursor-pointer hover:text-orange "><i class="fa-solid fa-box"></i>
                                {{ $categoriaItem->nombre }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!--CONTENEDOR SUBCATEGORIAS Y MARCAS-->
        @if ($categoria)
            <!--CONTENEDOR SUBCATEGORIAS-->
            <div class="item_filtro_tienda">
                <div class="contenedor_titulo_filtro">
                    <p>Subcategorias</p>
                    {{-- <button>Ocultar</button> --}}
                </div>
                <div class="contenedor_cuerpo_filtro">
                    <ul>
                        @foreach ($subcategorias as $subcategoriaItem)
                            <li>
                                <a wire:click="$set('subcategoria', '{{ $subcategoriaItem->id }}')"
                                    style="color: {{ $subcategoria == $subcategoriaItem->id ? '#ffa03d' : '' }}"
                                    class="cursor-pointer hover:text-orange "><i class="fa-solid fa-box"></i>
                                    {{ $subcategoriaItem->nombre }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!--CONTENEDOR MARCAS-->
            <div class="item_filtro_tienda">
                <div class="contenedor_titulo_filtro">
                    <p>Marcas</p>
                    {{-- <button>Ocultar</button> --}}
                </div>
                <div class="contenedor_cuerpo_filtro">
                    <ul>
                        @foreach ($marcas as $marcaItem)
                            <li>
                                <a wire:click="$set('marca', '{{ $marcaItem->nombre }}')"
                                    style="color: {{ $marca == $marcaItem->nombre ? '#ffa03d' : '' }}"
                                    class="cursor-pointer hover:text-orange"><i class="fa-solid fa-box"></i>
                                    {{ $marcaItem->nombre }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </div>
    <!--CONTENEDOR PRODUCTOS TIENDA-->
    <div class="contenedor_pagina_tienda_cuerpo">
        <!--BANNER CATEGORIA-->
        {{-- <div class="tienda_categoria">
            <p>Categoria</p>
        </div> --}}

        <!--FILTRO PRODUCTOS-->
        <div class="contenedor_filtro_productos">

            @if ($productos->count())
                @foreach ($productos as $producto)
                    <div class="slider_producto_item">
                        <!--CONTENEDOR IMAGEN-->
                        <div class="slider_producto_imagen">
                            <a href="{{ route('producto.index', $producto) }}">
                                @if ($producto->imagenes->count())
                                    <img src="{{ Storage::url($producto->imagenes->first()->imagen_ruta) }}"
                                        alt="" />
                                @else
                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                @endif
                            </a>

                            <!--CONTENEDOR OFERTA-->
                            @if ($producto->precio_venta < $producto->precio_real)
                                <div class="slider_producto_oferta">
                                    <div class="slider_producto_liston">OFERTA</div>
                                </div>
                            @endif

                            <!--CONTENEDOR FAVORITO-->
                            @livewire('web.inicio.agregar-favorito-producto', ['producto' => $producto], key('busqueda-producto-' . $producto->id))
                        </div>

                        <!--CONTENEDOR DESCRIPCION-->
                        <div class="slider_producto_descripcion">
                            <h3>{{ $producto->nombre }}</h3>
                            <p>{{ Str::limit($producto->descripcion, 35) }} </p>
                            @if ($producto->precio_venta < $producto->precio_real)
                                <span>
                                    <span class="slider_producto_precio_anterior">
                                        S/. {{ number_format($producto->precio_real, 2, '.', ',') }}
                                    </span>
                                    <span class="slider_producto_descuento">
                                        -%{{ round(100 - (100 * $producto->precio_venta) / $producto->precio_real) }}
                                    </span>
                                </span>
                            @endif
                            <h4>S/. {{ number_format($producto->precio_venta, 2, '.', ',') }}</h4>
                        </div>

                        <!--CONTENEDOR PIE-->
                        <div class="slider_producto_pie">
                            <a href="{{ route('producto.index', $producto) }}">Ver producto</a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="contenedor_no_existe_elementos">
                    <p>No hay productos</p>
                    <i class="fa-solid fa-spinner"></i>
                </div>
            @endif

        </div>

        <!--PAGINACIÓN-->
        @if ($productos->hasPages())
        <div>
            {{ $productos->links('pagination::tailwind') }}
        </div>
    @endif
    </div>
   
</div>

@push('script')
    <script>
        window.addEventListener("resize", function(event) {
            if (document.body.clientWidth < 900) {
                document.querySelector(".contenedor_filtro_tienda").style.left = "-300px";

            } else {
                document.querySelector(".contenedor_filtro_tienda").style.left = "0";
            }
        })

        function sidebarTienda() {
            return {
                abiertoSidebarTienda: false,
                toggleSidebarTienda() {
                    console.log("hola");
                    this.abiertoSidebarTienda = !this.abiertoSidebarTienda;
                    if (this.abiertoSidebarTienda) {
                        document.querySelector(".contenedor_filtro_tienda").style.left = "0";
                    } else {
                        document.querySelector(".contenedor_filtro_tienda").style.left = "-300px";
                    }
                },
                cerrarSidebarTienda() {
                    let anchoPantalla = (window.innerWidth > 0) ? window.innerWidth : screen.width;
                    if (anchoPantalla < 900) {
                        this.abiertoSidebarTienda = false;
                        document.querySelector(".contenedor_filtro_tienda").style.left = "-300px";
                    }
                }
            }
        }

        function range() {
            return {
                minprice: 0, //Minimo inicio
                maxprice: 200000, //Máximo inicio //7000
                min: 0, //Salto
                max: 200000, //Máximo fin
                minthumb: 0,
                maxthumb: 0,

                mintrigger() {
                    this.minprice = Math.min(this.minprice, this.maxprice - 500);
                    this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                },

                maxtrigger() {
                    this.maxprice = Math.max(this.maxprice, this.minprice + 500);
                    this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                },
            }
        }
    </script>
@endpush
