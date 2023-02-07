<div>
    @php
        $witems = Cart::instance('wishlist')
            ->content()
            ->pluck('id');
    @endphp

    @if ($witems->contains($producto->id))
        <span wire:click="eliminarFavorito({{ $producto->id }})" wire:loading.attr="disabled"
            wire:target="eliminarFavorito" class="agregar_favorito"> <i class="fa-solid fa-heart"
                style="color: blue; cursor: pointer;"></i></span>
    @else
        <span wire:click="agregarFavorito" wire:loading.attr="disabled" wire:target="agregarFavorito"
            class="agregar_favorito"> <i class="fa-solid fa-heart" style="color: #ffa03d; cursor: pointer;"></i></span>
    @endif
</div>
