<div>
    <!--Formulario-->
    @if (!$algo)
        <div class="formulario">
            <!--Stock-->
            <div class="contenedor_2_elementos">
                <div class="contenedor_elemento_item">
                    <p class="estilo_nombre_input">Stock: </p>
                    <input type="number" wire:model.defer="stock" step="1" placeholder="Ingrese el stock.">
                    @error('stock')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="contenedor_elemento_item">
                    <input type="button" value=" Agregar stock" wire:loading.attr="disabled" wire:target="guardarPivot"
                        wire:click="guardarPivot">
                </div>
            </div>
        </div>
    @endif

    <!--Tabla-->
    @if ($algo)
        <div class="tabla_administrador py-4 overflow-x-auto">
            <div class="inline-block min-w-full overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th>Stock</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>
                                {{ $algo->stock }} unidad(es)
                            </td>
                            <td>
                                <a style="color: green;" wire:click="editarPivotModal()"
                                    wire:loading.attr="disabled"
                                    wire:target="editarPivotModal()">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                |
                                <a style="color: red;" wire:click="eliminarVariaMedida({{ $algo->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!--Modal editar -->
    @if ($algo)
        <x-jet-dialog-modal wire:model="abierto" wire:key="modal-varia-medida-stock{{ $medida->id }}">
            <!--Titulo Modal-->
            <x-slot name="title">
                <div class="contenedor_titulo_modal">
                    <div>
                        <h2 style="font-weight: bold">Editar stock 2</h2>
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
                    <button style="background-color: #009eff;" wire:click="$set('abierto', false)"
                        wire:loading.attr="disabled" type="submit">Cancelar</button>

                    <button style="background-color: #ffa03d;" wire:click="actualizarPivot" wire:loading.attr="disabled"
                        wire:target="actualizarPivot" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

</div>
