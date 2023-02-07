<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedidaProducto extends Model
{
    use HasFactory;

    protected $table = "medida_producto";

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
