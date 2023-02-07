<div class="contenedor_slider_categoria">
    <div class="gliderSliderCategoria">
        @foreach ($categorias as $categoriaItem)
            <div class="slider_categoria_item">
                <a href="{{ $categoriaItem->slug }}">
                    @if ($categoriaItem->imagen)
                        <img src="{{ Storage::url($categoriaItem->imagen->imagen_ruta) }}"
                            class="slider_principal_imagen">
                    @else
                        <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                    @endif

                </a>
            </div>
        @endforeach
    </div>
</div>

<script>
    new Glider(document.querySelector('.gliderSliderCategoria'), {
        slidesToShow: 6,
        slidesToScroll: 6,
        draggable: true,
        responsive: [{
            breakpoint: 300,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }, {
            breakpoint: 640,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4
            }
        }, {
            breakpoint: 1024,
            settings: {
                slidesToShow: 6,
                slidesToScroll: 6
            }
        }]
    })
</script>
