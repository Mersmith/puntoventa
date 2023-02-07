<div class="formulario">
    <!--ESTADO-->
    <div class="contenedor_2_elementos">
        <div class="contenedor_elemento_item">
            <p>Estado del producto: <span class="campo_opcional">(Opcional)</span> </p>
            <div>
                <label>
                    <input type="radio" value="0" name="estado" wire:model.defer="estado">
                    Desactivado
                </label>
                <label>
                    <input type="radio" value="1" name="estado" wire:model.defer="estado">
                    Activado
                </label>
            </div>
            @error('estado')
                <span class="campo_obligatorio">{{ $message }}</span>
            @enderror
        </div>

        <!--Enviar-->
        <div class="contenedor_elemento_item">
            <button wire:click="actualizarEstadoProducto" wire:loading.attr="disabled"
                wire:target="actualizarEstadoProducto">
                Actualizar estado
            </button>
        </div>

    </div>
</div>
