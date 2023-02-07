<x-web-layout>
    <!--SEO-->
    @section('tituloPagina', 'Producto | ' . $producto->nombre)

    <!--CONTENIDO PÁGINA-->
    <div class="contenedor_pagina_producto">
        <!--CENTRAR PÁGINA-->
        <div class="contenedor_centrar_pagina">
            <div class="migas_productos">
                <span>Inicio &nbsp;/&nbsp; {{ $producto->subcategoria->categoria->nombre }} &nbsp;/&nbsp;
                    {{ $producto->subcategoria->nombre }}</span>
            </div>
            <!--GRID PRODUCTO-->
            <div class="contenedor_info_producto">
                <!--Imagen-->
                <div class="contenedor_producto_imagen">
                    @php
                        $imagesOrdenadas = [];
                        $imagenesGaleria = $producto->imagenes->sortBy('posicion');
                        foreach ($imagenesGaleria as $item) {
                            $imagesOrdenadas[] = $item;
                        }
                        $cantidadImagenes = count($imagesOrdenadas); //4
                        //0, 1, 2, 3
                    @endphp

                    @if ($producto->imagenes->count())
                        <!--IMAGEN PRINCIPAL-->
                        <div x-data="{ total: {{ $producto->imagenes->count() }}, current: 0, open: true }">
                            <div x-show="open" class="contenedor_imagen_producto_principal">
                                @foreach ($imagesOrdenadas as $key2 => $imagen)
                                    <img src="{{ Storage::url($imagen->imagen_ruta) }}" alt=""
                                        x-show="current == {{ $key2 }}">
                                @endforeach


                                <div @click="
                            if(current > 0){ 
                                current = current - 1;
                            }else{ 
                                current = {{ $cantidadImagenes - 1 }};
                            }
                            "
                                    class="contenedor_imagen_pie_controles contenedor_imagen_pie_izquierdo">
                                    <span><i class="fa-solid fa-angle-left"></i></span>
                                </div>
                                <div @click="
                            if(current < total-1){ 
                                current = current + 1;
                            }else{ 
                                current = 0;
                            }
                            "
                                    class="contenedor_imagen_pie_controles contenedor_imagen_pie_derecho">
                                    <span><i class="fa-solid fa-angle-right"></i></span>
                                </div>
                            </div>
                            <!--PIE IMAGENES-->
                            <div class="contenedor_imagen_producto_pie">
                                <div class="contenedor_imagen_producto_item">
                                    @foreach ($imagesOrdenadas as $key => $imagen)
                                        <img @click="current = {{ $key }}"
                                            src="{{ Storage::url($imagen->imagen_ruta) }}" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="contenedor_imagen_producto_principal">
                            <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                            <span class="agregar_favorito"> <i class="fa-solid fa-heart"
                                    style="color: #ffa03d; cursor: pointer;"></i>
                            </span>
                        </div>
                    @endif
                </div>
                <!--Informacion-->
                <div class="contenedor_producto_info">
                    <img src="{{ Storage::url($producto->marca->imagen->imagen_ruta) }}" style="width: 80px;"
                        alt="">
                    <h1>{{ $producto->nombre }} </h1>
                    <p class="producto_info_sku">SKU: {{ $producto->sku }} </p>

                    @if (!Auth::check())

                        @if ($producto->precio_venta < $producto->precio_real)
                            <span>Antes
                                <span class="slider_producto_precio_anterior">
                                    S/. {{ number_format($producto->precio_real, 2, '.', ',') }}
                                </span>
                            </span>

                            <p class="producto_info_precio">
                                S/. {{ number_format($producto->precio_venta, 2, '.', ',') }}
                                @if ($producto->precio_venta < $producto->precio_real)
                                    <span>-%{{ round(100 - (100 * $producto->precio_venta) / $producto->precio_real) }}
                                        descuento</span>
                                @endif
                            </p>
                        @endif
                    @else
                        <p class="producto_info_precio">
                            $ {{ number_format($producto->precio_venta, 2, '.', ',') }}
                        </p>
                    @endif

                    @if ($producto->incluye_igv > 0)
                        <p><strong>Incluye IGV </strong></p>
                    @endif

                    @if ($producto->puntos_ganar > 0)
                        <p>Gana hasta {{ $producto->puntos_ganar }} CRD Puntos <span><i
                                    class="fa-solid fa-circle-question"
                                    style="color: #b3b3b3; cursor: pointer;"></i></span> </p>
                    @endif

                    <div class="contenedor_producto_envio">
                        <div class="contenedor_producto_envio_item">
                            <div>
                                <span><i class="fa-solid fa-truck"
                                        style="margin-top: 10px; color: #009eff; cursor: pointer;"></i></span>
                            </div>
                            <div>
                                <h2>Envio desde $10.00</h2>
                                <p>Según la ciudad puede variar.</p>
                            </div>
                        </div>
                        <br>
                        <div class="contenedor_producto_envio_item">
                            <div><span><i class="fa-solid fa-shop"
                                        style="margin-top: 10px; color: #009eff; cursor: pointer;"></i></span>
                            </div>
                            <div>
                                <h2>Recógelo gratis en Tienda.</h2>
                                <p>Tenemos diferentes sedes.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        @if ($producto->subcategoria->tiene_color && !$producto->subcategoria->tiene_medida)
                            @livewire('web.producto.agregar-carrito-variacion-color', ['producto' => $producto])
                        @elseif(!$producto->subcategoria->tiene_color && $producto->subcategoria->tiene_medida)
                            @livewire('web.producto.agregar-carrito-variacion-medida', ['producto' => $producto])
                        @elseif($producto->subcategoria->tiene_color && $producto->subcategoria->tiene_medida)
                            @livewire('web.producto.agregar-carrito-variacion-medida-color', ['producto' => $producto])
                        @else
                            @livewire('web.producto.agregar-carrito-sin-variacion', ['producto' => $producto])
                        @endif
                    </div>

                    <div class="informacion_producto">
                        <p style="margin-bottom: 5px;"><strong>Información del producto:</strong> </p>
                        <p>{!! html_entity_decode($producto->informacion) !!}</p>
                    </div>
                </div>
                <!--Detalle-->
                @if ($producto->tiene_detalle)
                    <div class="contenedor_producto_detalles">
                        <p style="margin-bottom: 5px;"><strong>Características del producto:</strong> </p>

                        <div class="tabla_infoproducto">{!! html_entity_decode($producto->detalle) !!}</div>
                    </div>
                @endif
                <!--Video-->
                @if ($producto->link_video)
                    <div class="contenedor_producto_video">
                        <iframe src="{{ $producto->link_video }}" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-web-layout>
