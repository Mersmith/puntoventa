<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'producto_id'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function colores()
    {
        return $this->belongsToMany(Color::class)->withPivot('stock', 'id');
    }
}
