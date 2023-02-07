<div>
    <!--SEO-->
    @section('tituloPagina', 'CREAR CLIENTE')

    <!--TITULO-->
    <h1>CREAR CLIENTE</h1>

    <!--BOTONES-->
    <a href="{{ route('administrador.cliente.index') }}">
        <i class="fa-solid fa-arrow-left-long"></i> Regresar</a>

    <!--FORMULARIO-->
    <form wire:submit.prevent="crearCliente" x-data>
        <!--EMAIL-->
        <div>
            <p>Email: </p>
            <input type="email" wire:model="email">
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PASSWORD-->
        <div>
            <p>Contraseña: </p>
            <input type="password" wire:model="password">
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="nombre">
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--APELLIDO-->
        <div>
            <p>Apellido: </p>
            <input type="text" wire:model="apellido">
            @error('apellido')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DNI-->
        <div>
            <p>DNI: </p>
            <input type="number" wire:model="dni">
            @error('dni')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--RUC-->
        <div>
            <p>RUC: </p>
            <input type="number" wire:model="ruc">
            @error('ruc')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--CELULAR-->
        <div>
            <p>Celular: </p>
            <input type="tel" wire:model="celular">
            @error('celular')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DIRECCIÓN-->
        <div>
            <p>Dirección: </p>
            <input type="text" wire:model="direccion">
            @error('direccion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--PUNTOS-->
        <div>
            <p>Puntos: </p>
            <input type="number" wire:model="puntos">
            @error('puntos')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <br>

        <!--IMAGEN-->
        <div>
            <p>Imagen: </p>
            <div style="width: 100px; height: 100px;">
                @if ($imagen)
                    <img style="width: 100px; height: 100px;" src="{{ $imagen->temporaryUrl() }}">
                @else
                    <img style="width: 100px; height: 100px;"
                        src="{{ asset('imagenes/perfil/sin_foto_perfil.png') }}">
                @endif
                <label for="imagen">
                    <div>
                        Editar <i class="fa-solid fa-camera"></i>
                    </div>
                </label>
                <div wire:click="$set('imagen', null)">
                    Cancelar <i class="fa-solid fa-trash"></i>
                </div>
            </div>
            <input type="file" wire:model="imagen" style="display: none" id="imagen">
            @error('imagen')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <br>
        <br>

        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Cliente">
        </div>
    </form>


</div>
