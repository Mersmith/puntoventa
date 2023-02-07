<?php

use App\Http\Livewire\Cliente\Perfil\PerfilLivewire;
use Illuminate\Support\Facades\Route;

Route::get('prueba-cliente', function () {
    return "Cliente";
});

Route::get('perfil', PerfilLivewire::class)->name('perfil');
