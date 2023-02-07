<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class MergeTheCartLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $carrito = DB::table('shoppingcart')
            ->where('identifier', auth()->user()->id)
            ->where('instance', "shopping")
            ->first();

        $favoritos = DB::table('shoppingcart')
            ->where('identifier', auth()->user()->id)
            ->where('instance', "wishlist")
            ->first();

        if ($carrito) {

            $carritoItems = unserialize(str_replace("~~NULL_BYTE~~", "\0", $carrito->content));

            foreach ($carritoItems as $cartItem) {
                //$optionsCarritoArray = $cartItem->options->toArray();
                //$optionsCarritoObjeto = json_decode($cartItem->options);
                //dd($optionsCarritoArray["cantidad"], $optionsCarritoObjeto->cantidad);

                Cart::instance('shopping')->add(
                    [
                        'id' => $cartItem->id,
                        'name' => $cartItem->name,
                        'qty' => $cartItem->qty,
                        'price' => $cartItem->price,
                        'weight' => 550,
                        'options' => $cartItem->options->toArray(),
                    ]
                );
            }
        }

        if ($favoritos) {

            $favoritosItems = unserialize(str_replace("~~NULL_BYTE~~", "\0", $favoritos->content));

            foreach ($favoritosItems as $favoritoItem) {

                Cart::instance('wishlist')->add(
                    [
                        'id' => $favoritoItem->id,
                        'name' => $favoritoItem->name,
                        'qty' => $favoritoItem->qty,
                        'price' => $favoritoItem->price,
                        'weight' => 550,
                        'options' => $favoritoItem->options->toArray(),
                    ]
                );
            }
        }
    }
}
