<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at', 'estado'];

    const PENDIENTE = 1;
    const PAGADO = 2;
    const ORDENADO = 3;
    const ENVIADO = 4;
    const ENTREGADO = 5;
    const ANULADO = 6;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function compraDetalle()
    {
        return $this->hasMany(CompraDetalle::class);
    }
}
