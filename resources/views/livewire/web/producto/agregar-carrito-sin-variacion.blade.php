<div x-data class="contenedor_producto_sin_variacion">
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
    <div class="controles_sin_varicion">
        <div>
            <x-jet-secondary-button disabled x-bind:disabled="$wire.cantidadCarrito <= 1" wire:loading.attr="disabled"
                wire:target="disminuir" wire:click="disminuir">-
            </x-jet-secondary-button>
            <span>{{ $cantidadCarrito }} </span>
            <x-jet-secondary-button x-bind:disabled="$wire.cantidadCarrito >= $wire.stockProducto"
                wire:loading.attr="disabled" wire:target="aumentar" wire:click="aumentar">+
            </x-jet-secondary-button>
        </div>
        <button x-bind:disabled="$wire.cantidadCarrito > $wire.stockProducto" wire:click="agregarProducto"
            wire:loading.attr="disabled" wire:target="agregarProducto" class="sin_variacion_boton_agregar">
            Agregar al carrito
        </button>
    </div>
</div>
