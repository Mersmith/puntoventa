<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug', 'descripcion'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
