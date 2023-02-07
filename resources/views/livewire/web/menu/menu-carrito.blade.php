<div class="contenedor_icono_menu_carrito">
    <div style="display: flex;">
        <div style="position: relative;" x-on:click="abrirCarrito">
            @if (Cart::instance('shopping')->count() > 0)
                <p class="cantidad_carrito">{{ Cart::instance('shopping')->count() }} </p>
            @endif
            <i class="fa-solid fa-cart-shopping" style="color: #ffa03d;"></i>
        </div>
    </div>

    <div :class="{ 'block': abiertoCarrito, 'block': !abiertoCarrito }" class="contenedor_menu_carrito">
        @if (Cart::instance('shopping')->count() > 0)
            <div class="menu_carrito_productos">
                @foreach (Cart::instance('shopping')->content() as $item)
                    <div class="menu_carrito_item">
                        <img class="object-cover mr-4" src="{{ $item->options->imagen }}"
                            alt="">
                        <article>
                            <h3><strong>{{ $item->name }}</strong></h3>
                            <p>Cantidad: {{ $item->qty }} </p>
                            <p>${{ number_format($item->price, 2) }} </p>
                            @isset($item->options['color'])
                                <p>Color: {{ $item->options['color'] }} </p>
                            @endisset
                            @isset($item->options['medida'])
                                <p>Medida: {{ $item->options['medida'] }} </p>
                            @endisset
                            <a wire:click="eliminarProducto('{{ $item->rowId }}')"
                                wire:loading.class="text-red-600 opacity-25"
                                wire:target="eliminarProducto('{{ $item->rowId }}')">
                                <i class="fas fa-trash"></i>Eliminar Producto
                            </a>
                        </article>
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="menu_carrito_detalles">
                @if (Cart::instance('shopping')->count())
                    <div class="contenedor_ir_carrito">
                        <p><strong>Total: </strong> ${{ Cart::instance('shopping')->subtotal(2, '.', ',') }}
                        </p>
                        <a href="#">
                            Ir al carrito
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div>
                <p>No eligió ningún producto :( .</p>
            </div>
        @endif
    </div>
</div>
