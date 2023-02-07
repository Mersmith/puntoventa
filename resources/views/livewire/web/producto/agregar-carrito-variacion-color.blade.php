<div x-data class="contenedor_producto_variacion_color">
    {{--@dump($colores)--}}
    <!--CONTENEDOR VARIACION COLOR-->
    <p>Tiene {{ $producto->stock }} variedad de productos</p>

    <p><strong>Seleccione color:</strong></p>

    <!--VARIACION COLOR PRODUCTO-->
    <div class="variacion_color_producto">
        @foreach ($colores as $key => $color)
            <label style="display: {{ $color->nombre == 'ninguno' ? 'none' : '' }};">
                <!--ITEM COLOR PRODUCTO-->
                <div class="item_color_producto">
                    <input type="radio" name="color_id" wire:model="color_id" value="{{ $color->id }}">
                    <span>
                        <i style="background-color: {{ $color->codigo }};"></i>
                    </span>
                    {{ $color->nombre }}
                </div>
            </label>
        @endforeach
    </div>
    @if ($color_id)
        <div>
            <p><strong>Stock disponible:</strong>
                @if ($stockProducto)
                    {{ $stockProducto }}
                @else
                    0
                    {{-- $producto->stock --}}
                @endif
            </p>
        </div>
    @endif

    <!--ESTILOS CONTROLES-->
    <div class="controles_variacion_color">
        <div>
            <x-jet-secondary-button disabled x-bind:disabled="$wire.cantidadCarrito <= 1" wire:loading.attr="disabled"
                wire:target="disminuir" wire:click="disminuir">-
            </x-jet-secondary-button>
            <span>{{ $cantidadCarrito }} </span>
            <x-jet-secondary-button x-bind:disabled="$wire.cantidadCarrito >= $wire.stockProducto"
                wire:loading.attr="disabled" wire:target="aumentar" wire:click="aumentar">+
            </x-jet-secondary-button>
        </div>
        <button x-bind:disabled="$wire.cantidadCarrito > $wire.stockProducto" x-bind:disabled="!$wire.stockProducto"
            wire:click="agregarProducto" wire:loading.attr="disabled" wire:target="agregarProducto"
            class="variacion_color_boton_agregar">
            Agregar al carrito
        </button>
    </div>
</div>
