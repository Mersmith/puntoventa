<div>
    <!--SEO-->
    @section('tituloPagina', 'CLIENTES')

    <!--TITULO-->
    <h1>CLIENTES</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.cliente.crear') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Crear cliente</a>

    @if ($clientes->count())
        <!--SUBTITULO-->
        <h2>Lista Clientes</h2>

        <!--BUSCADOR-->
        <div>
            <input type="text" wire:model="buscarCliente"
                placeholder="Ingrese el nombre del cliente que quiere buscar.">
        </div>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
                    <th>
                        Imagen</th>
                    <th>
                        Nombre</th>
                    <th>
                        Email</th>
                    <th>
                        Celular</th>
                    <th>
                        Puntos</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>
                            <div style="width: 20px; height: 20px;">
                                @if ($cliente->imagen)
                                    <img src="{{ Storage::url($cliente->imagen->imagen_ruta) }}"
                                        alt="" />
                                @else
                                    <img src="{{ asset('imagenes/perfil/sin_foto_perfil.png') }}">
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $cliente->nombre }}
                        </td>
                        <td>
                            {{ $cliente->email }}
                        </td>
                        <td>
                            {{ $cliente->celular }}
                        </td>
                        <td>
                            {{ $cliente->puntos }}
                        </td>
                        <td>
                            <a href="{{ route('administrador.cliente.editar', $cliente) }}">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay clientes.</p>
    @endif
    @if ($clientes->hasPages())
        <div>
            {{ $clientes->links() }}
        </div>
    @endif
</div>
