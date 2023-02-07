<div>
    <form action="" method="POST">
        @csrf
        @if (Session::has('email-contacto-correcto'))
            <span style="color: white;">{{ Session::get('email-contacto-correcto') }}</span>
        @endif
        <div>
            <input type="text" name="nombre" placeholder="Nombres" required>
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror

        </div>
        <div class="contenedor_inputs_dos">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
            <input type="tel" name="celular" placeholder="Celular" required>
            @error('celular')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div class="contenedor_input_checkbox">
            <label>
                <input type="checkbox" required value="1">
                Acepto <a href="/sp/terminos-y-condiciones" target="_blank">términos y
                    condiciones</a> y la <a href="/sp/privacidad" target="_blank">Política
                    de Privacidad.</a>
            </label>
        </div>

        <div class="contenedor_input_checkbox">
            <label>
                <input type="checkbox" required value="1">
                Autorizo el uso de mi información para <a href="/sp/terminos-y-condiciones" target="_blank">
                    fines adicionales.</a>
            </label>
        </div>

        <div>
            <button type="submit">Enviar</button>
        </div>
    </form>
</div>
