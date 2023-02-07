<?php

namespace App\Http\Livewire\Administrador\Producto;

use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Subcategoria;
use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductoEditarLivewire extends Component
{
    use WithFileUploads;

    protected $listeners = ['cambiarPosicionImagenes', 'dropImagenes', 'eliminarProducto'];

    public $producto;

    public $categorias, $subcategorias, $marcas, $proveedores, $tagsDb;

    public $categoria_id,  $proveedor_id;

    public
        $slug,
        $sku,
        $stock_total,
        $link_video,
        $incluye_igv,
        $tiene_detalle,
        $detalle,
        $tags = [];

    protected $rules = [
        'categoria_id' => 'required',
        'producto.subcategoria_id' => 'required',
        'producto.marca_id' => 'required',
        'proveedor_id' => 'required',
        'producto.nombre' => 'required',
        'slug' => 'required|unique:productos',
        'sku' => 'required|unique:productos',
        'producto.precio_venta' => 'required',
        'producto.precio_real' => 'required',
        //'stock_total' => 'required',
        'producto.descripcion' => 'required',
        'producto.informacion' => 'required',
        'producto.puntos_ganar' => 'required',
        'producto.incluye_igv' => 'required',
        'producto.tiene_detalle' => 'required',
    ];

    protected $validationAttributes = [
        'categoria_id' => 'categoria',
        'producto.subcategoria_id' => 'subcategoria',
        'producto.marca_id' => 'marca',
        'proveedor_id' => 'proveedor',
        'producto.nombre' => 'nombre',
        'slug' => 'slug',
        'sku' => 'sku',
        'producto.precio_venta' => 'precio de venta',
        'producto.precio_real' => 'precio real',
        'stock_total' => 'stock',
        'producto.descripcion' => 'descripción',
        'producto.informacion' => 'información',
        'producto.puntos_ganar' => 'puntos a ganar',
        'link_video' => 'iframe del video',
        'producto.tiene_detalle' => 'detalle',
        'producto.detalle' => 'detalle',
        'producto.incluye_igv' => 'igv',
        'imagenes' => 'imagenes',
    ];

    protected $messages = [
        'categoria_id.required' => 'La :attribute es requerido.',
        'producto.subcategoria_id.required' => 'La :attribute es requerido.',
        'producto.marca_id.required' => 'La :attribute es requerido.',
        'proveedor_id.required' => 'El :attribute es requerido.',
        'producto.nombre.required' => 'El :attribute es requerido.',
        'slug.required' => 'El :attribute es requerido.',
        'sku.required' => 'El :attribute es requerido.',
        'producto.precio_venta.required' => 'El :attribute es requerido.',
        'producto.precio_real.required' => 'El :attribute es requerido.',
        'stock_total.required' => 'El :attribute es requerido.',
        'producto.descripcion.required' => 'La :attribute es requerido.',
        'producto.informacion.required' => 'La :attribute es requerido.',
        'producto.puntos_ganar.required' => 'Los :attribute es requerido.',
        'link_video.required' => 'El :attribute es requerido.',
        'producto.producto.tiene_detalle.required' => 'El :attribute es requerido.',
        'detalle.required' => 'El :attribute es requerido.',
        'producto.incluye_igv.required' => 'El :attribute es requerido.',
        'imagenes.required' => 'Las :attribute son requerido.',
    ];

    public function mount(Producto $producto)
    {
        $this->producto = $producto;

        $this->categorias = Categoria::all();
        $this->proveedores = Proveedor::all();
        $this->tagsDb = Tag::all();

        $this->categoria_id = $producto->subcategoria->categoria->id;
        $this->tags = $producto->tags->pluck('id');

        $this->subcategorias = Subcategoria::where('categoria_id', $this->categoria_id)->get();

        $this->proveedor_id = $producto->proveedor->id;

        $this->slug = $this->producto->slug;
        $this->sku = $this->producto->sku;
        $this->tiene_detalle = $this->producto->tiene_detalle;
        $this->incluye_igv = $this->producto->incluye_igv;
        $this->detalle = $this->producto->detalle;
        $this->link_video = $this->producto->link_video;
        $this->stock_total = $this->producto->stock_total;

        $this->marcas = Marca::whereHas('categorias', function (Builder $query) {
            $query->where('categoria_id', $this->categoria_id);
        })->get();
    }

    public function updatedCategoriaId($value)
    {
        $this->subcategorias = Subcategoria::where('categoria_id', $value)->get();

        $this->marcas = Marca::whereHas('categorias', function (Builder $query) use ($value) {
            $query->where('categoria_id', $value);
        })->get();

        $this->producto->subcategoria_id  = "";
        $this->producto->marca_id  = "";
    }

    public function updatedProductoNombre($value)
    {
        $this->slug = Str::slug($value);
        $this->sku = trim(strtoupper(substr($value, 0, 2)) . "-" . "S" . rand(1, 500) . strtoupper(substr($value, -2)));
    }

    public function getSubcategoriaProperty()
    {
        return Subcategoria::find($this->producto->subcategoria_id);
    }

    public function dropImagenes()
    {
        $this->producto = $this->producto->fresh();
    }

    public function cambiarPosicionImagenes($sorts)
    {
        $posicion = 1;

        foreach ($sorts as $sort) {

            $slider = Imagen::find($sort);
            $slider->posicion = $posicion;
            $slider->save();

            $posicion++;
        }

        $this->dropImagenes();
    }

    public function editarProducto()
    {
        if ($this->producto->imagenes->count()) {

            $rules = $this->rules;
            $rules['slug'] = 'required|unique:productos,slug,' . $this->producto->id;
            $rules['sku'] = 'required|unique:productos,sku,' . $this->producto->id;
            
            if ($this->producto->subcategoria_id) {
                if (!$this->subcategoria->tiene_color && !$this->subcategoria->tiene_medida) {
                    $rules['stock_total'] = 'required|numeric';
                    $this->producto->stock_total = $this->stock_total;
                }/*else{
                    $this->producto->stock_total = null;
                }*/
            }

            if ($this->tiene_detalle) {
                $rules['detalle'] = 'required';
            } else {
                $this->detalle = null;
            }

            $this->validate($rules);

            $this->producto->proveedor_id = $this->proveedor_id;
            $this->producto->slug = $this->slug;
            $this->producto->sku = $this->sku;
            $this->producto->link_video = $this->link_video;
            $this->producto->detalle = $this->detalle;

            $this->producto->update();

            $this->producto->tags()->sync($this->tags);

            $imagenes_antiguas = $this->producto->ckeditors->pluck('imagen_ruta')->toArray();

            $re_extractImages = '/src=["\']([^ ^"^\']*)["\']/ims';
            preg_match_all($re_extractImages, $this->producto->informacion, $matches);
            $imagenesCkeditors_nuevas = $matches[1];

            if ($imagenesCkeditors_nuevas) {
                foreach ($imagenesCkeditors_nuevas as  $imgckeditor) {
                    $urlImagenCkeditor = 'ckeditor/' . pathinfo($imgckeditor, PATHINFO_BASENAME);

                    $clave = array_search($urlImagenCkeditor, $imagenes_antiguas);

                    if ($clave === false) {
                        $this->producto->ckeditors()->create([
                            'imagen_ruta' => $urlImagenCkeditor
                        ]);
                    } else {
                        unset($imagenes_antiguas[$clave]);
                    }
                }

                foreach ($imagenes_antiguas as  $imagen_antigua) {
                    Storage::delete($imagen_antigua);
                    $this->producto->ckeditors()->where('imagen_ruta', $imagen_antigua)->delete();
                }
            }
            $this->emit('mensajeActualizado', "El producto ha sido actualizado.");
        } else {
            $this->emit('mensajeError', "Falta subir imagen.");
        }
    }

    public function eliminarImagen(Imagen $imagen)
    {
        Storage::delete([$imagen->imagen_ruta]);
        $imagen->delete();

        $this->producto = $this->producto->fresh();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function eliminarProducto()
    {
        $imagenes = $this->producto->imagenes;
        $ckeditors = $this->producto->ckeditors;

        if ($this->producto->imagenes->count()) {
            foreach ($imagenes as $imagen) {
                Storage::delete($imagen->imagen_ruta);
                $imagen->delete();
            }
        }

        if ($this->producto->ckeditors->count()) {
            foreach ($ckeditors as $ckeditor) {
                Storage::delete($ckeditor->imagen_ruta);
                $ckeditor->delete();
            }
        }

        $this->producto->delete();

        return redirect()->route('administrador.producto.index');
    }

    public function descargarQR()
    {
        $qr_codigo = QrCode::size(100)->generate(route('producto.redirigir.qr', $this->producto->slug));

        Storage::put('qrs/producto/' . $this->producto->slug . '.svg', $qr_codigo);

        return Storage::download('qrs/producto/' . $this->producto->slug . '.svg');
    }

    public function render()
    {
        return view('livewire.administrador.producto.producto-editar-livewire')->layout('layouts.administrador.index');
    }
}
