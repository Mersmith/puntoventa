<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ckeditor extends Model
{
    use HasFactory;

    protected $fillable = ['imagen_ruta', 'imagenable_id', 'imagenable_type'];

    public function ckeditorable()
    {
        return $this->morphTo();
    }

}
