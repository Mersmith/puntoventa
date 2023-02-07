<footer class="contenedor_pie_pagina">
    <!--CONTENEDOR FORMULARIO-->
    <div class="contenedor_pie_contacto">
        <div class="contenedor_titulo">
            <h2>¡SUSCRÍBETE A NUESTRO NEWSLETTER!</h2>
        </div>
        <div class="contenedor_contacto">
            @livewire('web.inicio.suscribirse-correo')
        </div>
    </div>

    <!--CONTENEDOR INFORMACIÓN-->
    <div class="contenedor_pie_informacion">
        <div class="contenedor_titulo">
            <h2>¡CONTÁCTENOS!</h2>
        </div>
        <div class="contenedor_mapa">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d720815.078304992!2d-80.9492742135048!3d-3.592437273089929!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9033f3662874b48d%3A0x86a8e7d32ad3ea79!2sC.%20Hilario%20Carrasco%20422%2C%20Corrales%2024501!5e0!3m2!1ses-419!2spe!4v1672753232159!5m2!1ses-419!2spe"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="contenedor_redes_sociales">
            <div>
                <a href="tel:+51993 796 221"><i class="fa-solid fa-envelope"></i><span>993 796 221</span></a>
                &nbsp; - &nbsp;
                <a href="mailto:info@seragris.com"><i
                        class="fa-solid fa-envelope"></i><span>info@seragris.com</span></a>
            </div>
            <div>
                <p>Siguenos: </p>
                <a href="https://www.facebook.com/Seragris" target="_blank">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.instagram.com/seragrisperu/" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@seragrisperu" target="_blank">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                {{-- <a href="https://www.youtube.com/channel/UC0hDbqQceq3Taouih7vOL9g" class=" fa-brands fa-youtube" target="_blank"> </a> --}}
            </div>
        </div>
    </div>

    <!--CONTENEDOR DERECHOS-->
    <div class="contenedor_pie_derechos">
        <small> Todos los Derechos Reservados <strong> Ecommerce </strong> &copy; {{ date('Y') }} </small>
    </div>
</footer>
