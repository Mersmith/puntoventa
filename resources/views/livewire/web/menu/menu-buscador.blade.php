<div x-data class="contenedor_menu_buscador">
    <form autocomplete="off">
        <input wire:model="buscar" type="text" placeholder="Buscar.." name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
    @if ($productosBuscador)
        <div class="absolute mt-1 hidden" :class="{ 'hidden': !$wire.abierto }" @click.away="$wire.abierto = false">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="px-4  py-3 space-y-1">
                    @forelse ($productosBuscador as $producto)
                        <a href="{{ route('producto.index', $producto) }}" class="flex">
                            <img class="w-16 h-12 object-cover"
                                src="{{ Storage::url($producto->imagenes->first()->imagen_ruta) }}" alt="">
                            <div class="ml-4 text-gray-700">
                                <p class="text-lg font-semibold leading-5">{{ $producto->nombre }}</p>
                                <p>Categoria: {{ $producto->subcategoria->categoria->nombre }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-lg leading-5">
                            No existe ningún registro con los parametros especificados
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
