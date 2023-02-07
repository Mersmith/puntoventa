<div>
    <!--FORMULARIO-->
    <div class="contenedor_panel_producto_admin">
        <!--CONTENEDOR SUBTITULO-->
        <div class="contenedor_subtitulo_admin">
            <h3>Nueva medida</h3>
        </div>
        <div class="contenedor_botones_admin">
            <button wire:click="guardarMedida" wire:loading.attr="disabled" wire:target="guardarMedida">
                Crear <i class="fa-solid fa-square-plus"></i>
            </button>
            <button onClick="window.scrollTo(0, document.body.scrollHeight);">
                Abajo <i class="fa-solid fa-arrow-down"></i>
            </button>
        </div>
        <!--FORMULARIO-->
        <div class="formulario">
            <!--NOMBRE Y CREAR-->
            <div class="contenedor_2_elementos">
                <div class="contenedor_elemento_item">
                    <p class="estilo_nombre_input">Nombre medida: <span class="campo_obligatorio">(Obligatorio)</span>
                    </p>
                    <input type="text" wire:model.defer="nombre" placeholder="Ingrese nombre de medida.">
                    @error('nombre')
                        <span class="campo_obligatorio">{{ $message }}</span>
                    @enderror
                </div>
                <div class="contenedor_elemento_item">
                    <input type="button" value="Agregar medida" wire:click="guardarMedida" wire:loading.attr="disabled"
                        wire:target="guardarMedida">
                </div>
            </div>
        </div>
    </div>
    <!--LISTA-->
    <div class="contenedor_panel_producto_admin">
        @if ($producto_medidas->count())
            <!--CONTENEDOR SUBTITULO-->
            <div class="contenedor_subtitulo_admin">
                <h3>Medidas 2</h3>
            </div>

            <!--FORMULARIO-->
            <div class="formulario">
                <!--Medidas-->
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Medidas: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <div>
                            @foreach ($producto_medidas as $key => $medidaItem)
                                <label>
                                    <input type="radio" name="medida_id" wire:model.defer="medida_id"
                                        value="{{ $medidaItem->id }}">
                                    <span>
                                        {{ $medidaItem->nombre }}
                                    </span>
                                    <div>
                                        <button wire:click="editarMedida({{ $medidaItem->id }})" wire:loading.attr="disabled"
                                            wire:target="editarMedida({{ $medidaItem->id }})"><span><i
                                                    class="fa-solid fa-pencil"
                                                    style="color: green;"></i></span>Editar</button> |
                                        <button wire:click="$emit('eliminarPivotMedidaColorModal', {{ $medidaItem->id }})">
                                            <span><i class="fa-solid fa-trash"
                                                    style="color: red;"></i></span>Eliminar</button>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('medida_id')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!--STOCK Y ENVIAR-->
                <div class="contenedor_2_elementos">
                    <!--Stock-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Stock por color: <span
                                class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <input type="number" wire:model.defer="stock" step="1" placeholder="Ingrese stock.">
                        @error('stock')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                    <!--Enviar-->
                    <div class="contenedor_elemento_item">
                        <input type="button" value="Relacionar medida" wire:loading.attr="disabled"
                            wire:target="relacionarMedida" wire:click="relacionarMedida">
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!--TABLA-->
   <div class="contenedor_panel_producto_admin">
        @if ($producto_medidas_stock->count())
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
                            @foreach ($producto_medidas_stock as $producto_color)
                                <tr wire:key="producto_color-{{ $producto_color->pivot->id }}">
                                    <td>
                                        {{ $producto_medidas->find($producto_color->pivot->medida_id)->nombre }}
                                    </td>
                                    <td>
                                        {{ $producto_color->pivot->stock }} unidad(es)
                                    </td>
                                    <td>
                                        <a style="color: green;"
                                            wire:click="editarMedida2({{ $producto_color->pivot->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="editarMedida2({{ $producto_color->pivot->id }})">
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
    @if ($medida)
        <x-jet-dialog-modal wire:model="abierto" wire:key="modal-componente-medida-{{ $medida->id }}">
            <!--Titulo Modal-->
            <x-slot name="title">
                <div class="contenedor_titulo_modal">
                    <div>
                        <h2 style="font-weight: bold">Editar medida</h2>
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
                    <!--Nombre-->
                    <div class="contenedor_1_elementos_100">
                        <p class="estilo_nombre_input">Nombre medida: <span
                                class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="text" wire:model.defer="nombre_editado" placeholder="Ingrese nombre medida.">
                        @error('nombre_editado')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </x-slot>
            <!--Pie Modal-->
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button style="background-color: #009eff;" wire:click="$set('abierto', false)"
                        wire:loading.attr="disabled" type="submit">Cancelar</button>

                    <button style="background-color: #ffa03d;" wire:click="actualizarMedida"
                        wire:loading.attr="disabled" wire:target="actualizarMedida" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

    <!--MODAL-->
    @if ($pivot)
        <x-jet-dialog-modal wire:model="abierto2" wire:key="modal-stock-medida-{{ $pivot->id }}">
            <!--Titulo Modal-->
            <x-slot name="title">
                <div class="contenedor_titulo_modal">
                    <div>
                        <h2 style="font-weight: bold">Editar medida</h2>
                    </div>
                    <div>
                        <button wire:click="$set('abierto2', false)" wire:loading.attr="disabled">
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
                        <p class="estilo_nombre_input">Stock por medida: <span
                                class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="number" wire:model="pivot_stock" step="1" placeholder="Ingrese el stock.">
                        @error('pivot_stock')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </x-slot>
            <!--Pie Modal-->
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button style="background-color: #009eff;" wire:click="$set('abierto2', false)"
                        wire:loading.attr="disabled" type="submit">Cancelar</button>

                    <button style="background-color: #ffa03d;" wire:click="actualizarPivot"
                        wire:loading.attr="disabled" wire:target="actualizarPivot" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

</div>
