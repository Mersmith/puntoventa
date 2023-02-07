<header class="contenedor_navbar">
    <!-- GRID MENU -->
    <nav class="navbar" x-data="sidebar" x-on:click.away="cerrarSidebar()">
        <!-- HAMBURGUESA -->
        <div x-on:click="abrirSidebar" class="contenedor_hamburguesa">
            <i class="fa-solid fa-bars" style="color: #666666;"></i>
        </div>
        <!-- LOGO -->
        <div class="contenedor_logo">
            <a href="{{ route('inicio') }}">
                <img src="{{ asset('imagenes/empresa/logo.png') }}" alt="" />
            </a>
        </div>
        <!-- BUSCADOR -->
        <div class="contenedor_menu_link" :class="{ 'block': abiertoSidebar, 'block': !abiertoSidebar }">
            <div class="sidebar_logo">
                <img src="{{ asset('imagenes/empresa/logo.png') }}" alt="" />
                <i x-on:click="cerrarSidebar" style="cursor: pointer; color: #666666;" class="fa-solid fa-xmark"></i>
            </div>
            <hr>
            @livewire('web.menu.menu-buscador')
            @include('web.menu.menu-pie')
        </div>
        <!-- ICONOS -->
        <div class="contenedor_iconos" x-data="iconos" x-on:click.away="cerrarCategorias(); cerrarCarrito()"
            @resize.window="anchoPantalla = window.innerWidth">

            <a x-on:click="abrirCategorias">
                <i class="fa-solid fa-bars-progress" style="color: #666666;"></i>
            </a>

            @include('web.menu.menu-login')

            @livewire('web.menu.menu-favorito')

            @livewire('web.menu.menu-carrito')
        </div>
    </nav>
    @include('web.menu.menu-pie')
    @include('web.menu.menu-categoria')

</header>

@push('script')
    <script>
        function sidebar() {
            return {
                abiertoSidebar: false,
                toggleSidebar() {
                    this.abiertoSidebar = !this.abiertoSidebar
                },
                abrirSidebar() {
                    if (this.abiertoSidebar) {
                        this.abiertoSidebar = false;
                        document.querySelector(".contenedor_menu_link").style.left = "-100%";
                    } else {
                        this.abiertoSidebar = true;
                        document.querySelector(".contenedor_menu_link").style.left = "0";
                    }
                },
                cerrarSidebar() {
                    this.abiertoSidebar = false;
                    document.querySelector(".contenedor_menu_link").style.left = "-100%";
                }
            }
        }

        function iconos() {

            var width = window.innerWidth;
            return {
                abiertoCategorias: false,
                abiertoCarrito: false,
                anchoPantalla: width,

                cerrarCategorias() {
                    this.abiertoCategorias = false;
                    if (width > 900) {
                        document.querySelector(".contenedor_menu_categorias").style.top = "-100%";
                    } else {
                        document.querySelector(".contenedor_menu_categorias").style.left = "-100%";
                    }
                },
                cerrarCarrito() {
                    this.abiertoCarrito = false;
                    document.querySelector(".contenedor_menu_carrito").style.right = "-100%";
                },

                toggleCategorias() {
                    this.abiertoCategorias = !this.abiertoCategorias
                },
                toggleCarrito() {
                    this.abiertoCarrito = !this.abiertoCarrito
                },
                abrirCategorias() {
                    if (width > 900) {
                        if (this.abiertoCategorias) {
                            this.abiertoCategorias = false;
                            document.querySelector(".contenedor_menu_categorias").style.top = "-100%";
                        } else {
                            this.abiertoCategorias = true;
                            document.querySelector(".contenedor_menu_categorias").style.top = "150px";
                        }
                        this.cerrarCarrito();
                    } else {
                        if (this.abiertoCategorias) {
                            this.abiertoCategorias = false;
                            document.querySelector(".contenedor_menu_categorias").style.left = "-100%";
                        } else {
                            this.abiertoCategorias = true;
                            document.querySelector(".contenedor_menu_categorias").style.left = "0";
                        }
                        this.cerrarCarrito();
                    }
                },
                abrirCarrito() {
                    if (this.abiertoCarrito) {
                        this.abiertoCarrito = false;
                        document.querySelector(".contenedor_menu_carrito").style.right = "-100%";
                    } else {
                        this.abiertoCarrito = true;
                        document.querySelector(".contenedor_menu_carrito").style.right = "0";
                    }
                    this.cerrarCategorias();
                }
            }
        }
    </script>
@endpush
