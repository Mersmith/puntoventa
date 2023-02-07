<div>
    <div class="contenedor_icono_favorito">
        <x-jet-dropdown>
            <x-slot name="trigger">
                <div style="display: flex;">
                    <div style="position: relative;">
                        @if (Cart::instance('wishlist')->count() > 0)
                            <p class="cantidad_favorito">{{ Cart::instance('wishlist')->count() }}</p>
                        @endif
                        <i class="fa-solid fa-heart" style="color: #ffa03d;"></i>
                    </div>
                </div>
            </x-slot>
            <x-slot name="content">
                <div class="contenedor_menu_favorito">
                    @if (Cart::instance('wishlist')->count())
                        <div class="menu_favorito_productos">
                            @foreach (Cart::instance('wishlist')->content() as $item)
                                <div class="menu_favorito_item">
                                    <img class="object-cover mr-4" src="{{ $item->options->imagen }}" alt="">
                                    <article>
                                        <h2><strong>{{ $item->name }}</strong></h2>
                                        <p>Cantidad: {{ $item->qty }} </p>
                                        <p>${{ number_format($item->price, 2) }} </p>
                                        @isset($item->options['color'])
                                            <p>Color: {{ $item->options['color'] }} </p>
                                        @endisset
                                        @isset($item->options['medida'])
                                            <p>Medida: {{ $item->options['medida'] }} </p>
                                        @endisset
                                    </article>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                        <div class="contenedor_ir_favoritos">
                            <a href="#">
                                Ir favoritos
                            </a>
                        </div>
                    @else
                        <div>
                            <p>No eligió ningún producto :( .</p>
                        </div>
                    @endif
                </div>
            </x-slot>
        </x-jet-dropdown>
    </div>
</div>
