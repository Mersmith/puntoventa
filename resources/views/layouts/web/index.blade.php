<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Seragris - @yield('tituloPagina')</title>
    <meta name="description" content="@yield('descripcion')">
    <!--Facebook-->
    <meta property="og:site_name" content="Seragris">
    <meta property="og:title" content="@yield('tituloPagina')">
    <meta property="og:description" content="@yield('descripcion')">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es">
    <meta property="og:url" content="@yield('url')">
    <meta property="og:image" content="@yield('imagen')">

    <!--Twitter-->
    <meta name="twitter:title" content="@yield('tituloPagina')">
    <meta name="twitter:image" content="@yield('imagen')">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @include('layouts.web.componentes.css')
</head>

<body class="font-sans antialiased">
    {{-- Sirve para crear los flash.banner --}}
    <x-jet-banner />

    <div class="min-h-screen">

        <!-- Menu Principal-->
        @livewire('web.menu.menu-principal')

        <!-- Contenido de páginas-->
        <main>
            {{ $slot }}
        </main>
        
        <!-- Pie de pagina-->
        @include('layouts.web.componentes.pie-pagina')
    </div>

    @include('layouts.web.componentes.js')
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
    </script>
</body>

</html>
