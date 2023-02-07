<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Gloudemans\Shoppingcart\Facades\Cart;

class MergeTheCartLogout
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
     * @param  \App\Providers\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        Cart::instance('shopping')->erase(auth()->user()->id);
        Cart::instance('shopping')->store(auth()->user()->id);

        Cart::instance('wishlist')->erase(auth()->user()->id);
        Cart::instance('wishlist')->store(auth()->user()->id);
    }
}
