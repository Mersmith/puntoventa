<?php

namespace App\Http\Livewire\Web\Tienda;

use App\Models\Categoria;
use App\Models\Marca;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Database\Eloquent\Builder;

class TiendaPagina extends Component
{
    use WithPagination;
    public $search;
    public $buscarProducto;
    public $categorias, $subcategorias, $marcas;
    public $categoria, $subcategoria, $marca;
    public $vista = "grid";
    public $minimo = 0, $maximo = 200000; //7000

    protected $queryString = ['categoria', 'subcategoria', 'marca', 'search'];

    public function mount()
    {
        $this->categorias = Categoria::all();
        //$this->categoria = $this->categorias->first()->id;        
    }

    public function updatingBuscarProducto()
    {
        $this->resetPage();
    }

    public function updatedCategoria()
    {
        $this->reset(['subcategoria', 'marca', 'page', 'minimo', 'search']);
    }

    public function updatedSubcategoria()
    {
        //Palabra reservada para resetear la paginación
        $this->resetPage();
    }

    public function updatedMarca()
    {
        //Palabra reservada para resetear la paginación
        $this->resetPage();
    }

    //Page campo de WithPagination 
    public function limpiarFiltro()
    {
        $this->reset(['categoria', 'subcategoria', 'marca', 'page', 'search', 'buscarProducto']);
    }

    public function render()
    {
        $productosQuery = Producto::query();

        if ($this->search) {
            $porciones = explode("-", $this->search);
            $primera_letra = $porciones[0];
            $url_sin_guiones = str_replace("-", " ", $this->search);

            $productosQuery = $productosQuery->where('nombre', 'like', '%' . $primera_letra . '%');
        }

        if ($this->buscarProducto) {
            $productosQuery = $productosQuery->where('nombre', 'like', '%' . $this->buscarProducto . '%');
        }

        if ($this->categoria) {
            $productosQuery = $productosQuery->whereHas('subcategoria.categoria', function (Builder $query) {
                $query->where('id', $this->categoria);
            });

            $this->subcategorias = Subcategoria::where('categoria_id', $this->categoria)->get();

            $this->marcas = Marca::whereHas('categorias', function (Builder $query) {
                $query->where('categoria_id', $this->categoria);
            })->get();
        }

        if ($this->subcategoria) {
            $productosQuery = $productosQuery->whereHas('subcategoria', function (Builder $query) {
                $query->where('id', $this->subcategoria);
            });
        }

        if ($this->marca) {
            $productosQuery = $productosQuery->whereHas('marca', function (Builder $query) {
                $query->where('nombre', $this->marca);
            });
        }

        $productos = $productosQuery->whereBetween('precio_venta', [$this->minimo, $this->maximo])->orderBy('created_at', 'desc')->paginate(10);


        return view('livewire.web.tienda.tienda-pagina', compact('productos'))->layout('layouts.web.index');
    }
}
