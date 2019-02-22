<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/3/2018
 * Time: 11:11 AM
 */

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CartRequest;
use App\Services\Site\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private $_cartService;

    public function __construct(CartService $_cartService)
    {
        $this->_cartService = $_cartService;
    }
    public function checkout()
    {
        $variables = $this->_cartService->checkout();
        return view('frontend.pages.cart.show_cart',[
            'dataCart'                    => $variables['dataCart'],
            'products'                    => $variables['products'],
            'coupon'                    => $variables['coupon'],
            'coupon_fail'                    => $variables['coupon_fail'],
        ]);
    }
    public function updateCart(Request $request)
    {
        return $this->_cartService->updateCart($request);
    }
    public function paying()
    {
        $variables = $this->_cartService->paying();
        return view('frontend.pages.cart.paying',[
            'dataCart'                    => $variables['dataCart'],
            'products'                    => $variables['products'],
            'coupon'                    => $variables['coupon'],
        ]);
    }
    public function confirmPaying(CartRequest $request)
    {
        $this->_cartService->confirm($request);
        return view('frontend.pages.cart.thank_you');
    }

    public function add(Request $request)
    {
        return $this->_cartService->add($request);
    }

    public function remove(Request $request)
    {
        return $this->_cartService->remove($request);
    }
}