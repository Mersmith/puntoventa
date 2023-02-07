<div>
    <!--SEO-->
    @section('tituloPagina', 'ACTUALIZAR EMPRESA')

    <!--TITULO-->
    <h1>ACTUALIZAR EMPRESA</h1>

    <!--FORMULARIO-->
    <form wire:submit.prevent="actualizarEmpresa" x-data>
        <!--NOMBRE-->
        <div>
            <p>Nombre: </p>
            <input type="text" wire:model="editarFormulario.nombre">
            @error('editarFormulario.nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DESCRIPCIÓN-->
        <div>
            <p>Descripción: </p>
            <textarea rows="3" wire:model="editarFormulario.descripcion">
            </textarea>
            @error('editarFormulario.descripcion')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--EMAIL-->
        <div>
            <p>Email: </p>
            <input type="email" wire:model="editarFormulario.email">
            @error('editarFormulario.email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--RUC-->
        <div>
            <p>RUC: </p>
            <input type="number" wire:model="editarFormulario.ruc">
            @error('editarFormulario.ruc')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <!--DIRECCIÓN-->
        <div>
            <p>Dirección: </p>
            <input type="text" wire:model="editarFormulario.direccion">
            @error('editarFormulario.direccion')
                <span>{{ $message }}</span>
            @enderror
        </div>


        <!--ENVIAR-->
        <div>
            <input type="submit" value="Actualizar Empresa">
        </div>
    </form>

</div>
