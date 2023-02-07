<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $titulo }}</title>
</head>

<body>
    <h1>{{ $titulo }}</h1>
    <p>Fecha descarga: {{ $fecha_descarga }}</p>
    <p>Factura emitida por Smith</p>

    <hr>

    <div>
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
            <input type="text" value="{{ $proveedor }}" disabled>
        </div>

        <!--PERSONAL-->
        <div>
            <p>Personal: </p>
            <input type="text" value="{{ $personal }}" disabled>
        </div>

        <!--IMPUESTO-->
        <div>
            <p>Impuesto (%): </p>
            <input type="text" value="{{ $impuesto }}" disabled>
        </div>

        <!--TOTAL-->
        <div>
            <p>Total: </p>
            <input type="text" value="{{ $total }}" disabled>
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
</body>

</html>
