<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tituloPagina')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @include('layouts.administrador.componentes.css')
</head>

<body class="font-sans antialiased">
    {{-- Sirve para crear los flash.banner --}}
    <x-jet-banner />

    <div class="min-h-screen">

        <!-- Menu Administración -->
        @livewire('administrador.menu.menu-principal')

        <!-- Contenido de páginas -->
        <main class="contenedor_layout_administrador">
            <!--Mensaje alerta-->
            @if (session('crear'))
                <div id="mensaje_alerta_crear" class="mensaje_alerta">
                    <p>{{ session('crear') }}</p>
                    <i class="fa-solid fa-circle-check"></i>
                    <script>
                        window.onload = function() {
                            mensajeCreado();
                        };
                    </script>
                </div>
            @endif
            @if (session('editar'))
                <div id="mensaje_alerta_editar" class="mensaje_alerta">
                    <p>{{ session('editar') }}</p>
                    <i class="fa-solid fa-circle-check"></i>
                    <script>
                        window.onload = function() {
                            mensajeActualizado();
                        };
                    </script>
                </div>
            @endif
            @if (session('eliminar'))
                <div class="mensaje_alerta">
                    <p>{{ session('eliminar') }}</p>
                    <i class="fa-solid fa-circle-check"></i>
                    <script>
                        window.onload = function() {
                            mensajeEliminado();
                        };
                    </script>
                </div>
            @endif

            @if (session('error'))
                <div class="mensaje_alerta">
                    <p>{{ session('error') }}</p>
                    <i class="fa-solid fa-circle-check"></i>
                    <script>
                        window.onload = function() {
                            mensajeError();
                        };
                    </script>
                </div>
            @endif
            {{ $slot }}

            <button onClick="window.scrollTo(0, 0);" class="contenedor_boton_scroll_top">
                <i class="fa-solid fa-arrow-up"></i>
            </button>

            <button onClick="window.scrollTo(0, document.body.scrollHeight);" class="contenedor_boton_scroll_abajo">
                <i class="fa-solid fa-arrow-down"></i>
            </button>
        </main>
    </div>

    @include('layouts.administrador.componentes.js')
    @stack('modals')
    @livewireScripts
    @stack('script')
    <script>
        Livewire.on('mensajeCreado', mensaje => {
            Swal.fire({
                icon: 'success',
                title: mensaje,
                showConfirmButton: false,
                timer: 2500
            })
        })

        Livewire.on('mensajeActualizado', mensaje => {
            Swal.fire({
                icon: 'success',
                title: mensaje,
                showConfirmButton: false,
                timer: 2500
            })
        })

        Livewire.on('mensajeEliminado', mensaje => {
            Swal.fire({
                icon: 'error',
                title: mensaje,
                showConfirmButton: false,
                timer: 2500
            })
        })

        Livewire.on('mensajeError', mensaje => {
            Swal.fire({
                icon: 'error',
                title: '¡Alto!',
                text: mensaje,
                showConfirmButton: false,
                timer: 2500
            })
        })

        function mensajeActualizado() {
            event.preventDefault();
            Swal.fire({
                icon: 'success',
                title: "Actualizado",
                showConfirmButton: false,
                timer: 2500
            })
        }

        function mensajeCreado() {
            event.preventDefault();
            Swal.fire({
                icon: 'success',
                title: "Creado correctamente",
                showConfirmButton: false,
                timer: 2500
            })
        }

        function mensajeEliminado() {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: "Eliminado correctamente",
                showConfirmButton: false,
                timer: 2500
            })
        }

        function mensajeError() {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: '¡Alto!',
                text: "Rebice bien.",
                showConfirmButton: false,
                timer: 2500
            })
        }
    </script>
</body>

</html>
