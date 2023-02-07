<div>
    <!--SEO-->
    @section('tituloPagina', 'Sliders')

    <!--TITULO-->
    <h1>Sliders</h1>

    <!--FORMULARIOS-->
    <form wire:submit.prevent="crearSlider">
        <!--LINK-->
        <div>
            <p>Link: </p>
            <input type="text" wire:model="crearFormulario.link">
            @error('crearFormulario.link')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--ESTADO-->
        <div>
            <p>Estado: </p>
            <div>
                <label>
                    <input type="radio" value="0" wire:model.defer="crearFormulario.estado">
                    Desactivado
                </label>
                <label>
                    <input type="radio" value="1" wire:model.defer="crearFormulario.estado">
                    Activado
                </label>
            </div>
            @error('crearFormulario.estado')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--IMAGEN-->
        <div>
            <p>Imagen: </p>
            <div style="width: 100px; height: 100px;">
                @if ($crearFormulario['imagen'])
                    <img style="width: 100px; height: 100px;" src="{{ $crearFormulario['imagen']->temporaryUrl() }}">
                @else
                    <img style="width: 100px; height: 100px;"
                        src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                @endif
                <label for="imagen">
                    <div>
                        Editar <i class="fa-solid fa-camera"></i>
                    </div>
                </label>
                <div wire:click="$set('crearFormulario.imagen', null)">
                    Cancelar <i class="fa-solid fa-trash"></i>
                </div>
            </div>
            <input type="file" wire:model="crearFormulario.imagen" style="display: none" id="imagen">
            @error('crearFormulario.imagen')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <br>
        <br>
        <br>
        <br>

        <!--ENVIAR-->
        <div>
            <input type="submit" value="Crear Slider">
        </div>
    </form>

    @if ($sliders->count())
        <!--SUBTITULO-->
        <h1>Lista Slider</h1>

        <!--TABLA-->
        <table>
            <thead>
                <tr>
                    <th>
                        Imagen</th>
                    <th>
                        Nombre</th>
                    <th>
                        Ruta</th>
                    <th>
                        Descripción</th>
                    <th>
                        Acción</th>
                </tr>
            </thead>
            <tbody id="sortablesliders">
                @foreach ($sliders as $sliderItem)
                    <tr data-id="{{ $sliderItem->id }}">
                        <td>
                            <div class="handleSlider cursor-grab" style="width: 20px; height: 20px; cursor: pointer;">
                                @if ($sliderItem->imagen)
                                    <img src="{{ Storage::url($sliderItem->imagen->imagen_ruta) }}" alt="" />
                                @else
                                    <img src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                                @endif
                            </div>
                        </td>
                        <td>
                            {{ $sliderItem->link }}
                        </td>
                        <td>
                            {{ $sliderItem->estado }}
                        </td>
                        <td>
                            <a wire:click="editarSlider('{{ $sliderItem->id }}')">
                                <span><i class="fa-solid fa-pencil"></i></span>
                                Editar</a> |
                            <a wire:click="$emit('eliminarSliderModal', '{{ $sliderItem->id }}')">
                                <span><i class="fa-solid fa-trash"></i></span>
                                Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay sliders.</p>
    @endif

    @if ($slider)
        <!--MODAL-->
        <x-jet-dialog-modal wire:model="editarFormulario.abierto">
            <!--TITULO-->
            <x-slot name="title">
                <div>
                    <!--ENCABEZADO-->
                    <div>
                        <h2>Editar</h2>
                    </div>

                    <!--CERRAR-->
                    <div>
                        <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </x-slot>
            <!--CONTENIDO-->
            <x-slot name="content">
                <!--IMAGEN-->
                <div>
                    <p>Imagen: </p>
                    <div style="width: 100px; height: 100px;">
                        @if ($editarImagen)
                            <img style="width: 100px; height: 100px;" src="{{ $editarImagen->temporaryUrl() }}">
                        @elseif($editarFormulario['imagen'])
                            <img style="width: 100px; height: 100px;"
                                src="{{ Storage::url($slider->imagen->imagen_ruta) }}">
                            <div wire:click="$set('editarFormulario.imagen', null)">
                                Eliminar <i class="fa-solid fa-trash"></i>
                            </div>
                        @else
                            <img style="width: 100px; height: 100px;"
                                src="{{ asset('imagenes/producto/sin_foto_producto.png') }}">
                        @endif
                        <label for="editarImagen">
                            <div>
                                Editar <i class="fa-solid fa-camera"></i>
                            </div>
                        </label>
                        <div wire:click="$set('editarImagen', null)">
                            Cancelar <i class="fa-solid fa-trash"></i>
                        </div>
                    </div>
                    <input type="file" wire:model="editarImagen" style="display: none" id="editarImagen">
                    @error('editarImagen')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <br>
                <br>
                <br>

                <!--LINK-->
                <div>
                    <p>Link: </p>
                    <input type="text" wire:model="editarFormulario.link">
                    @error('editarFormulario.link')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

                <!--ESTADO-->
                <div>
                    <p>Estado: </p>
                    <div>
                        <label>
                            <input type="radio" value="0" wire:model.defer="editarFormulario.estado">
                            Desactivado
                        </label>
                        <label>
                            <input type="radio" value="1" wire:model.defer="editarFormulario.estado">
                            Activado
                        </label>
                    </div>
                    @error('editarFormulario.estado')
                        <span>{{ $message }}</span>
                    @enderror
                </div>

            </x-slot>
            <x-slot name="footer">
                <div class="contenedor_pie_modal">
                    <button wire:click="$set('editarFormulario.abierto', false)" wire:loading.attr="disabled"
                        type="submit">Cancelar</button>

                    <button wire:click="actualizarSlider" wire:loading.attr="disabled" wire:target="actualizarSlider"
                        type="submit">Editar</button>
                </div>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

</div>


@push('script')
    <script>
        new Sortable(sortablesliders, {
            handle: '.handleSlider',
            animation: 150,
            ghostClass: 'bg-blue-100',
            store: {
                set: function(sortable) {
                    const sorts = sortable.toArray();
                    axios.post("{{ route('api.sort.sliders') }}", {
                        sorts: sorts
                    }).catch(function(error) {
                        console.log(error);
                    });
                }
            }
        });
    </script>

    <script>
        Livewire.on('eliminarSliderModal', sliderId => {
            Swal.fire({
                title: '¿Quieres eliminar?',
                text: "No podrás recupar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('administrador.slider.slider-livewire',
                        'eliminarSlider', sliderId);
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