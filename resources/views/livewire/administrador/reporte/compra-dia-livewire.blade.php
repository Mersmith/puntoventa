<div>
    <!--SEO-->
    @section('tituloPagina', 'COMPRAS')

    <!--TITULO-->
    <h1>COMPRAS</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.compra.crear') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Nueva compra</a>


    @if ($compras->count())
        <!--SUBTITULO-->
        <h2>Lista Compras</h2>

        <div>
            <p>Fecha Consulta: {{ date('m/d/Y') }}</p>

            <p>Cantidad: {{ $compras->count() }}</p>

            <p>Total ingreso: {{ $compras->sum('total'); }}</p>
        </div>

        <!--BUSCADOR-->
        <div>
            <input type="text" wire:model="buscarProducto" placeholder="Buscar compra">
        </div>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
                    <th>
                        Fecha</th>
                    <th>
                        Total</th>
                    <th>
                        Impuesto</th>
                    <th>
                        Proveedor</th>
                    <th>
                        Personal</th>
                    <th>
                        Estado</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($compras as $compra)
                    <tr>
                        <td>
                            {{ $compra->created_at }}
                        </td>
                        <td>
                            {{ $compra->total }}
                        </td>
                        <td>
                            {{ $compra->impuesto }}
                        </td>
                        <td>
                            {{ $compra->proveedor->nombre }}
                        </td>
                        <td>
                            {{ $compra->user->email }}
                        </td>
                        <td>
                            @switch($compra->estado)
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
                        </td>
                        <td>
                            <a href="{{ route('administrador.compra.editar', $compra) }}">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay compras.</p>
    @endif
    @if ($compras->hasPages())
        <div>
            {{ $compras->links() }}
        </div>
    @endif
</div>
