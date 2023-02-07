<div wire:init="loadProductos">
    @if (count($productos))
        <!--TITULO-->
        <h2>Categorias</h2>

        <!--CONTENEDOR SLIDER-->
        <div class="glider-contain contenedor_slider_producto">
            <div class="gliderSliderProducto-{{ $slider1 }}">
                @foreach ($productos as $key => $producto)
                    <div class="slider_producto_item" wire:key="producto-{{ $producto->id }}">
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
                            @livewire('web.inicio.agregar-favorito-producto', ['producto' => $producto])
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
            </div>
            @if ($productos->count())
                <button class="slider_principal_boton gliderSliderProducto-prev">
                    <i class="fa-solid fa-angle-left"></i>
                </button>
                <button class="slider_principal_boton gliderSliderProducto-next">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
            @endif
        </div>
    @endif
</div>
