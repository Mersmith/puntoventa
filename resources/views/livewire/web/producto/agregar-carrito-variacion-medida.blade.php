<div x-data class="contenedor_producto_variacion_sin">
    <p>Tiene {{ $producto->stock }} variedad de productos</p>

    @if ($medida_id)
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

    @if (!$medida_id)
        <p>Seleccione medida:</p>
    @endif

    <table>
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medidas as $key => $itemMedida)
                <tr>
                    <td><label style="display: flex;" for="medida_id-{{ $key }}">
                            <input style="cursor: pointer;" type="radio" value="{{ $itemMedida->id }}" name="medida_id"
                                wire:model="medida_id" id="medida_id-{{ $key }}"> {{ $itemMedida->nombre }}
                            {{-- $itemMedida->colores->first()->pivot->stock --}}
                        </label>
                    </td>

                    <td x-bind:class=" $wire.medida_id != {{ $itemMedida->id }} ? 'hidden' : ''">
                        <div class="contenedor_producto_variacion_controles_sin">
                            <div>
                                <x-jet-secondary-button disabled x-bind:disabled="$wire.cantidadCarrito <= 1"
                                    wire:loading.attr="disabled" wire:target="disminuir" wire:click="disminuir">-
                                </x-jet-secondary-button>

                                @if ($medida_id == $itemMedida->id)
                                    <span>{{ $cantidadCarrito }}</span>
                                @else
                                    <span>1</span>
                                @endif

                                <x-jet-secondary-button x-bind:disabled="$wire.cantidadCarrito >= $wire.stockProducto"
                                    wire:loading.attr="disabled" wire:target="aumentar" wire:click="aumentar">+
                                </x-jet-secondary-button>

                            </div>

                            <button x-bind:disabled="$wire.cantidadCarrito > $wire.stockProducto"
                                x-bind:disabled="!$wire.stockProducto" wire:click="agregarProducto"
                                wire:loading.attr="disabled" wire:target="agregarProducto"
                                class="contenedor_producto_variacion_boton">
                                Agregar al carrito
                            </button>
                        </div>
                    </td>

                    @if (!$medida_id)
                        <td>
                            <div class="contenedor_producto_variacion_controles_sin">
                                <div>
                                    <x-jet-secondary-button disabled>-</x-jet-secondary-button>
                                    <span>1</span>
                                    <x-jet-secondary-button disabled>+</x-jet-secondary-button>
                                </div>
                                <button disabled class="contenedor_producto_variacion_boton_disabled">
                                    Agregar al carrito
                                </button>
                            </div>
                        </td>
                    @endif

                    @if ($medida_id)
                        @if ($medida_id == $itemMedida->id)
                        @else
                            <td>
                                <div class="contenedor_producto_variacion_controles_sin">
                                    <div>
                                        <x-jet-secondary-button disabled>-</x-jet-secondary-button>
                                        <span>1</span>
                                        <x-jet-secondary-button disabled>+</x-jet-secondary-button>
                                    </div>
                                    <button disabled class="contenedor_producto_variacion_boton_disabled">
                                        Agregar al carrito
                                    </button>
                                </div>
                            </td>
                        @endif
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
