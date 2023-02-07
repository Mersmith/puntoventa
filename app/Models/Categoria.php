<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'icono', 'descripcion',];

    public function productos()
    {
        return $this->hasManyThrough(Producto::class, Subcategoria::class);
    }

    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class);
    }

    public function marcas()
    {
        return $this->belongsToMany(Marca::class);
    }

    public function imagen()
    {
        return $this->morphOne(Imagen::class, "imagenable");
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
