<div>
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
        <!--Formulario-->
        <div class="formulario">
            <!--<form wire:submit.prevent="guardarMedida">-->
            <!--Nombre-->
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
                    <input type="button" value="Agregar medida"wire:click="guardarMedida" wire:loading.attr="disabled"
                        wire:target="guardarMedida">
                </div>
            </div>
        </div>
    </div>

    <div class="contenedor_panel_producto_admin">
        @if ($producto_medidas->count())
            <!--CONTENEDOR SUBTITULO-->
            <div class="contenedor_subtitulo_admin">
                <h3>Medidas</h3>
            </div>
            <br>
            <!--Lista-->
            <div>
                @foreach ($producto_medidas as $index => $medidaItem)
                    <div wire:key="medida-{{ $medidaItem->id }}" class="contenedor_panel_producto_admin">
                        <div class="contenedor_2_elementos">
                            <div class="contenedor_elemento_item contenedor_elemento_item_centrar">
                                <div>
                                    <p><strong>Medida: </strong> {{ $medidaItem->nombre }}</p>
                                </div>
                                <div class="tabla_controles">
                                    <button wire:click="editarMedida({{ $medidaItem->id }})" wire:loading.attr="disabled"
                                        wire:target="editarMedida({{ $medidaItem->id }})"><span><i
                                                class="fa-solid fa-pencil"
                                                style="color: green;"></i></span>Editar</button> |
                                    <button wire:click="$emit('eliminarPivotMedidaColorModal', {{ $medidaItem->id }})">
                                        <span><i class="fa-solid fa-trash"
                                                style="color: red;"></i></span>Eliminar</button>
                                </div>
                            </div>
                            <div class="contenedor_elemento_item">
                                @livewire('administrador.producto.stock-varia-medida-color', ['medida' => $medidaItem], key('varia-medida-color-stock-' . $medidaItem->id . '-' . $index))
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
    @if ($medida)
        <!--Modal editar -->
        <x-jet-dialog-modal wire:model="abierto" wire:key="modal-componente-medida-color-{{ $medida->id }}">
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
                    <div class="contenedor_elemento_formulario">
                        <label class="label_principal">
                            <p class="estilo_nombre_input">Nombre medida: </p>
                            <input type="text" wire:model.defer="nombre_editado"
                                placeholder="Ingrese nombre medida.">
                            @error('nombre_editado')
                                <span>{{ $message }}</span>
                            @enderror
                        </label>
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

</div>
