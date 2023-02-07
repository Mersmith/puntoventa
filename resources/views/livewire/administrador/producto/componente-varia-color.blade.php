<div>
    <div class="contenedor_panel_producto_admin">
        <!--CONTENEDOR SUBTITULO-->
        <div class="contenedor_subtitulo_admin">
            <h3>Nuevo color</h3>
        </div>
        <div class="contenedor_botones_admin">
            <button wire:loading.attr="disabled" wire:target="guardarColor" wire:click="guardarColor">
                Crear <i class="fa-solid fa-square-plus"></i>
            </button>
            <button onClick="window.scrollTo(0, document.body.scrollHeight);">
                Abajo <i class="fa-solid fa-arrow-down"></i>
            </button>
        </div>
        <!--FORMULARIO-->
        <div class="formulario">
            <!--Colores-->
            <div class="contenedor_1_elementos_100">
                <div class="contenedor_elemento_item">
                    <p class="estilo_nombre_input">Colores: <span class="campo_obligatorio">(Obligatorio)</span></p>
                    <div>
                        @foreach ($colores as $key => $color)
                            <label style="display: {{ $color->nombre == 'ninguno' ? 'none' : '' }};">
                                <input type="radio" name="color_id" wire:model.defer="color_id"
                                    value="{{ $color->id }}">
                                <span>
                                    {{ $color->nombre }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('color_id')
                        <span class="campo_obligatorio">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!--STOCK Y ENVIAR-->
            <div class="contenedor_2_elementos">
                <!--Stock-->
                <div class="contenedor_elemento_item">
                    <p class="estilo_nombre_input">Stock por color: <span class="campo_obligatorio">(Obligatorio)</span>
                    </p>
                    <input type="number" wire:model.defer="stock" step="1" placeholder="Ingrese stock.">
                    @error('stock')
                        <span class="campo_obligatorio">{{ $message }}</span>
                    @enderror
                </div>
                <!--Enviar-->
                <div class="contenedor_elemento_item">
                    <input type="button" value="Agregar color" wire:loading.attr="disabled" wire:target="guardarColor"
                        wire:click="guardarColor">
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor_panel_producto_admin">
        <!--TABLA-->
        @if ($producto_colores->count())
            <div class="tabla_administrador py-4 overflow-x-auto">
                <div class="inline-block min-w-full overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Stock</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producto_colores as $producto_color)
                                <tr wire:key="producto_color-{{ $producto_color->pivot->id }}">
                                    <td>
                                        {{ $colores->find($producto_color->pivot->color_id)->nombre }}
                                    </td>
                                    <td>
                                        {{ $producto_color->pivot->stock }} unidad(es)
                                    </td>
                                    <td>
                                        <a style="color: green;"
                                            wire:click="editarPivot({{ $producto_color->pivot->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="editarPivot({{ $producto_color->pivot->id }})">
                                            <i class="fa-solid fa-pencil"></i></a> |
                                        <a style="color: red;"
                                            wire:click="$emit('eliminarPivotColorModal', {{ $producto_color->pivot->id }})">
                                            <i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!--MODAL-->
    @if ($pivot)
        <x-jet-dialog-modal wire:model="abierto" wire:key="modal-componente-color-{{ $producto->id }}">
            <!--Titulo Modal-->
            <x-slot name="title">
                <div class="contenedor_titulo_modal">
                    <div>
                        <h2 style="font-weight: bold">Editar color</h2>
                    </div>
                    <div>
                        <button wire:click="$set('abierto', false)" wire:loading.attr="disabled">
                            <i style="cursor: pointer; color: #666666;" class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </x-slot>
            <!--Contenido Modal-->
            <x-slot name="content">
                <div class="formulario">
                    <!--Stock-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Stock por color: <span
                                    class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="number" wire:model="pivot_stock" step="1"
                                placeholder="Ingrese el stock.">
                            @error('pivot_stock')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-slot>
            <!--Pie Modal-->
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button style="background-color: #009eff;" wire:click="$set('abierto', false)"
                        wire:loading.attr="disabled" type="submit">Cancelar</button>

                    <button style="background-color: #ffa03d;" wire:click="actualizarPivot" wire:loading.attr="disabled"
                        wire:target="actualizarPivot" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

</div>
