<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckExistCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = Session::get("product_in_cart");

        if($data != null)
        {
            return $next($request);
        }
        else{
            return redirect()->route('cart.checkout');
        }
    }
}
