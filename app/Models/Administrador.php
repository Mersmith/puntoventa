<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nombre',
        'apellido',
        'email',
        'celular',
    ];

    public function imagen()
    {
        return $this->morphOne(Imagen::class, "imagenable");
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
