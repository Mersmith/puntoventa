<div>
    <!--SEO-->
    @section('tituloPagina', 'Proveedores')

    <!--CONTENEDOR CABECERA-->
    <div class="contenedor_administrador_cabecera">
        <!--CONTENEDOR TITULO-->
        <div class="contenedor_titulo_admin">
            <h2>Proveedores</h2>
        </div>
    </div>

    <div class="contenedor_administrador_contenido">
        <!--FORMULARIOS-->
        <div class="contenedor_panel_producto_admin">
            <!--CONTENEDOR SUBTITULO-->
            <div class="contenedor_subtitulo_admin">
                <h3>Nuevo proveedor</h3>
            </div>
            <!--FORMULARIOS-->
            <form wire:submit.prevent="crearProveedor" class="formulario">
                <!--NOMBRE Y EMAIL-->
                <div class="contenedor_2_elementos">
                    <!--NOMBRE-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Nombre: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="text" wire:model="crearFormulario.nombre">
                        @error('crearFormulario.nombre')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                    <!--EMAIL-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Email: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="email" wire:model="crearFormulario.email">
                        @error('crearFormulario.email')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--RUC Y CELULAR-->
                <div class="contenedor_2_elementos">
                    <!--RUC-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">RUC: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="number" wire:model="crearFormulario.ruc">
                        @error('crearFormulario.ruc')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>

                    <!--CELULAR-->
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Celular: <span class="campo_obligatorio">(Obligatorio)</span></p>
                        <input type="tel" wire:model="crearFormulario.celular">
                        @error('crearFormulario.celular')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--DIRECCIÓN-->
                <div class="contenedor_1_elementos_100">
                    <div class="contenedor_elemento_item">
                        <p class="estilo_nombre_input">Dirección: <span class="campo_obligatorio">(Obligatorio)</span>
                        </p>
                        <textarea rows="2" wire:model="crearFormulario.direccion"></textarea>
                        @error('crearFormulario.direccion')
                            <span class="campo_obligatorio">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!--ENVIAR-->
                <div class="contenedor_1_elementos">
                    <input type="submit" value="Crear Proveedor">
                </div>
            </form>
        </div>

        <!--LISTA-->
        <div class="contenedor_panel_producto_admin">

            @if ($proveedores->count())
                <!--CONTENEDOR SUBTITULO-->
                <div class="contenedor_subtitulo_admin">
                    <h3>Lista</h3>
                </div>
                <!--CONTENEDOR BOTONES-->
                <div class="contenedor_botones_admin">
                    <button>
                        PDF <i class="fa-solid fa-file-pdf"></i>
                    </button>
                    <button>
                        EXCEL <i class="fa-regular fa-file-excel"></i>
                    </button>
                    <button onClick="window.scrollTo(0, document.body.scrollHeight);">
                        Abajo <i class="fa-solid fa-arrow-down"></i>
                    </button>
                </div>

                <!--TABLA-->
                <div class="tabla_administrador py-4 overflow-x-auto">
                    <div class="inline-block min-w-full overflow-hidden">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre</th>
                                    <th>
                                        Email</th>
                                    <th>
                                        RUC</th>
                                    <th>
                                        Dirección</th>
                                    <th>
                                        Celular</th>
                                    <th>
                                        Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedores as $proveedor)
                                    <tr>
                                        <td>

                                            {{ $proveedor->nombre }}
                                        </td>
                                        <td>
                                            {{ $proveedor->email }}
                                        </td>
                                        <td>
                                            {{ $proveedor->ruc }}
                                        </td>
                                        <td>
                                            {{ $proveedor->direccion }}
                                        </td>
                                        <td>
                                            {{ $proveedor->celular }}
                                        </td>
                                        <td>
                                            <a style="color: green;"
                                                wire:click="editarProveedor('{{ $proveedor->id }}')">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a> |
                                            <a style="color: red;"
                                                wire:click="$emit('eliminarProveedorModal', '{{ $proveedor->id }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="contenedor_no_existe_elementos">
                    <p>No hay elementos</p>
                    <i class="fa-solid fa-spinner"></i>
                </div>
            @endif
        </div>
    </div>

    @if ($proveedor)
        <!--MODAL-->
        <x-jet-dialog-modal wire:model="editarFormulario.abierto">
            <!--TITULO-->
            <x-slot name="title">
                <div class="contenedor_titulo_modal">
                    <!--ENCABEZADO-->
                    <div>
                        <h2 style="font-weight: bold">Editar</h2>
                    </div>

                    <!--CERRAR-->
                    <div>
                        <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled">
                            <i style="cursor: pointer; color: #666666;" class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </x-slot>
            <!--CONTENIDO-->
            <x-slot name="content">
                <div class="formulario">

                    <!--NOMBRE-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Nombre: <span class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="text" wire:model="editarFormulario.nombre">
                            @error('editarFormulario.nombre')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--EMAIL-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Email: <span class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="email" wire:model="editarFormulario.email">
                            @error('editarFormulario.email')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--RUC-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">RUC: <span class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="number" wire:model="editarFormulario.ruc">
                            @error('editarFormulario.ruc')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--DIRECCIÓN-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Dirección: <span
                                    class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <textarea rows="2" wire:model="editarFormulario.direccion"></textarea>
                            @error('editarFormulario.direccion')
                                <span class="campo_obligatorio">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!--CELULAR-->
                    <div class="contenedor_1_elementos_100">
                        <div class="contenedor_elemento_item">
                            <p class="estilo_nombre_input">Celular: <span
                                    class="campo_obligatorio">(Obligatorio)</span>
                            </p>
                            <input type="tel" wire:model="editarFormulario.celular">
                            @error('editarFormulario.celular')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button style="background-color: #009eff;" wire:click="$set('editarFormulario.abierto', false)"
                        wire:loading.attr="disabled" type="submit">Cancelar</button>

                    <button style="background-color: #ffa03d;" wire:click="actualizarProveedor"
                        wire:loading.attr="disabled" wire:target="actualizarProveedor" type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>

<!--SCRIPT-->
@push('script')
    <script>
        Livewire.on('eliminarProveedorModal', proveedorId => {
            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás recuparlo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('administrador.proveedor.proveedor-livewire',
                        'eliminarProveedor', proveedorId);
                    Swal.fire(
                        '¡Eliminado!',
                        'Eliminaste correctamente.',
                        'success'
                    );
                }
            })
        });
    </script>
@endpush
