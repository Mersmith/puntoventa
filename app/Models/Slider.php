<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['link', 'estado', 'posicion'];

    public function imagen()
    {
        return $this->morphOne(Imagen::class, "imagenable");
    }
}
