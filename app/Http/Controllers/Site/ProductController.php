<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/3/2018
 * Time: 10:03 AM
 */

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Services\Site\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $_productService;

    public function __construct(ProductService $_productService)
    {
        $this->_productService = $_productService;
    }

    public function index(Request $request)
    {
        $variables = $this->_productService->index($request);


        return view('frontend.pages.product.list_product', [
            'products' => $variables['allProduct'],
        ]);
    }

    public function show($slug, $id)
    {
        $variables = $this->_productService->showDetail($slug, $id);
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        return view('frontend.pages.product.detail_product', [
            'productSingle' => $variables['productSingle'],
            'partners' => $variables['partner'],
            'imageDetail' => $variables['imageDetail'],
            'productRelated' => $variables['productRelated'],
            'url' => $url
        ]);
    }

    public function search(Request $request)
    {
        $variables = $this->_productService->index($request);

        return view('frontend.pages.product.list_product', [
            'products' => $variables['allProduct'],
            'query' => $variables['query'],
        ]);
    }

    public function searchProductByKeyword(Request $request)
    {
        $keyword = $request->keyword;
        $variables = $this->_productService->searchProductByKeyword($keyword);
        return response()->json([
            'products' => $variables['data']
        ]);
    }

    public function showProductByCatetory($category, $id,Request $request){
        $variables = $this->_productService->showProductByCatetory($category, $id,$request);

        return view('frontend.pages.product.list_product', [
            'products' => $variables['allProduct'],
        ]);
    }
}