<div>
    <!--SEO-->
    @section('tituloPagina', 'EDITAR COMPRA')

    <!--TITULO-->
    <h1>EDITAR COMPRA</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.compra.index') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Regresar</a>
    <button wire:click="$emit('eliminarCompraModal')">
        Eliminar compra
    </button>
    <a href="{{ route('administrador.compra.crear') }}">Crear Nuevo Compra</a>

    <hr>

    <a href="{{ route('administrador.compra.pdf', $compra) }}">Descargar PDF</a>
    <a href="{{ route('administrador.compra.imprimir', $compra) }}">Imprimir</a>

    <hr>

    <!--FORMULARIO-->
    <div x-data>
        <!--FECHA-->
        <div>
            <p>Fecha: </p>
            <p>{{ $fecha }} </p>
        </div>

        <!--ESTADO-->
        <div>
            @switch($estado)
                @case(1)
                    <span>
                        PENDIENTE
                    </span>
                @break

                @case(2)
                    <span>
                        PAGADO
                    </span>
                @break

                @case(3)
                    <span>
                        ORDENADO
                    </span>
                @break

                @case(4)
                    <span>
                        ENVIADO
                    </span>
                @break

                @case(5)
                    <span>
                        ENTREGADO
                    </span>
                @break

                @case(6)
                    <span>
                        ANULADO
                    </span>
                @break

                @default
            @endswitch
        </div>

        <!--PROVEEDOR-->
        <div>
            <p>Proveedor: </p>
            <input type="text" wire:model="proveedor" disabled>
        </div>

        <!--PERSONAL-->
        <div>
            <p>Personal: </p>
            <input type="text" wire:model="personal" disabled>
        </div>

        <!--IMPUESTO-->
        <div>
            <p>Impuesto (%): </p>
            <input type="text" wire:model="impuesto" disabled>
        </div>

        <!--TOTAL-->
        <div>
            <p>Total: </p>
            <input type="text" wire:model="total" disabled>
        </div>

        <br>
        <hr>
        <br>

        @if (count($detalle_compra) > 0)
            <!--SUBTITULO-->
            <h2>Detalle:</h2>
            <!--TABLA-->
            <table>
                <thead>
                    <tr>
                        <th>
                            Imagen</th>
                        <th>
                            Producto</th>
                        <th>
                            Precio</th>
                        <th>
                            Cantidad</th>
                        <th>
                            SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalle_compra as $item)
                        <tr>
                            <td>
                                <div style="width: 20px; height: 20px;">
                                    @if ($item->producto->imagenes->count())
                                        <img src="{{ Storage::url($item->producto->imagenes->first()->imagen_ruta) }}"
                                            alt="" />
                                    @else
                                        <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                    @endif
                                </div>
                            </td>
                            <td>
                                {{ $item->producto->nombre }}
                            </td>
                            <td>
                                {{ $item->precio }}
                            <td>
                                {{ $item->cantidad }}
                            </td>
                            <td>
                                {{ $item->precio * $item->cantidad }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @php
                $subTotal = $total / (1 + $impuesto / 100);
            @endphp

            <p>
                SubTotal: {{ $subTotal }}
            </p>
            <p>Impuesto ({{ $impuesto }}): {{ ($subTotal * $impuesto) / 100 }}</p>
            <p>Total Pagar: {{ $total }} </p>
            <!--ENVIAR-->
        @else
            <p>No hay detalle de compra.</p>
        @endif

    </div>

</div>
