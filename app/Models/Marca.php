<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'descripcion'];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class);
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
