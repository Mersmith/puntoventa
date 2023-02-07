<div class="contenedor_slider_principal">
    <div class="gliderSliderPrincipal">
        @foreach ($sliders as $slider)
            <div class="slider_slider_item">
                @if ($slider->link)
                    <a href="//{{ $slider->link }}" target="_blank">
                        <img src="{{ Storage::url($slider->imagen->imagen_ruta) }}" class="slider_principal_imagen">
                    </a>
                @else
                    <a>
                        <img src="{{ Storage::url($slider->imagen->imagen_ruta) }}" class="slider_principal_imagen">
                    </a>
                @endif
            </div>
        @endforeach
    </div>
    @if ($sliders->count() )
        <button class="slider_principal_boton gliderSliderPrincipal-prev-1">
            <i class="fa-solid fa-angle-left"></i>
        </button>
        <button class="slider_principal_boton gliderSliderPrincipal-next-1">
            <i class="fa-solid fa-angle-right"></i>
        </button>
        <div class="slider_principal_pie dots"></div>
    @endif
</div>

<script>
    gliderAutoplay(
        new Glider(document.querySelector('.gliderSliderPrincipal'), {
            slidesToShow: 1,
            slidesToScroll: 1,
            draggable: true,
            dots: ".dots",
            arrows: {
                prev: '.gliderSliderPrincipal-prev-1',
                next: '.gliderSliderPrincipal-next-1'
            },
        }), {
            interval: 5000,
        }
    );
</script>
