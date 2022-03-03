<?php

namespace App\Http\Middleware;

use App\UseCases\Cart\CartService;
use Closure;
use Illuminate\Http\Request;

class CheckIsEmptyCart
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cartService = app(CartService::class)->getCart();
        if (!$cartService) {
            return redirect()->route('cart');
        }
        return $next($request);
    }
}
