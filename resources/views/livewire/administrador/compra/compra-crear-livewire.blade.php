<div>
    <!--SEO-->
    @section('tituloPagina', 'NUEVA COMPRA')

    <!--TITULO-->
    <h1>NUEVA COMPRA</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.compra.index') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Regresar</a>

    <!--FORMULARIO-->
    <div x-data>
        <!--PROVEEDOR-->
        <div>
            <p>Proveedores: </p>
            <select wire:model="proveedor_id"  x-bind:disabled="$wire.proveedor_id !== ''">
                <option value="" selected disabled>Seleccione un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                @endforeach
            </select>
            @error('proveedor_id')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--IMPUESTO-->
        <div>
            <p>Impuesto (%): </p>
            <input type="number" wire:model="impuesto">
            @error('impuesto')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button wire:click="$set('proveedor_id', '')">Cancelar</button>
        <br>
        <hr>
        <br>

        <!--PRODUCTOS-->
        <div>
            <p>Productos: </p>
            <select wire:model="producto">
                <option value="" selected disabled>Seleccione un producto</option>
                @foreach ($productos as $productoItem)
                    <option value="{{ $productoItem }}">{{ $productoItem->nombre }}</option>
                @endforeach
            </select>
            @error('producto')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PRECIO REAL-->
        <div>
            <p>Precio: </p>
            <input type="number" wire:model="precio">
            @error('precio')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--CANTIDAD-->
        <div>
            <p>Cantidad: </p>
            <input type="number" wire:model="cantidad">
            @error('cantidad')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <br>
        <!--ENVIAR-->
        <div>
            <button x-bind:disabled="!$wire.producto" wire:loading.attr="disabled" wire:target="agregarCarrito"
                wire:click="agregarCarrito">
                Agregar producto
            </button>
        </div>

        @if (count($carrito) > 0)
            <!--TABLA-->
            <table>
                <thead>
                    <tr>
                        <th>
                            Nombre</th>
                        <th>
                            Precio</th>
                        <th>
                            Cantidad</th>
                        <th>
                            SubTotal</th>
                        <th>
                        <th>
                            Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrito as $carritoItem)
                        <tr>
                            <td>
                                {{ $carritoItem['nombre'] }}
                            </td>
                            <td>
                                {{ $carritoItem['precio'] }}
                            </td>
                            <td>
                                {{ $carritoItem['cantidad'] }}
                            </td>
                            <td>
                                {{ $carritoItem['subtotal_compra'] }}
                            </td>
                            <td>
                                <a wire:click="eliminarProductoCarrito({{ $loop->index }})"> <span><i
                                            class="fa-solid fa-pencil"></i></span>
                                    Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php
                $array_columna = 'subtotal_compra';
                $subTotal = array_sum(array_column($carrito, $array_columna));
            @endphp
            <p>
                SubTotal: {{ $subTotal }}
            </p>
            <p>Impuesto ({{ $impuesto }}): {{ ($subTotal * $impuesto) / 100 }}</p>
            <p>Total Pagar: {{ $subTotal + ($subTotal * $impuesto) / 100 }} </p>
            <!--ENVIAR-->
            <div>
                <button wire:loading.attr="disabled" wire:target="crearCompra" wire:click="crearCompra">
                    Crear compra
                </button>
            </div>
        @else
            <p>No hay productos.</p>
        @endif

    </div>

</div>
