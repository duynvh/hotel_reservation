<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/3/2018
 * Time: 10:03 AM
 */

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Services\Site\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $_articleService;

    public function __construct(ArticleService $_articleService)
    {
        $this->_articleService = $_articleService;
    }

    public function index() {
        $variables = $this->_articleService->index();
        return view('frontend.pages.article.list_article',[
            'articles'        => $variables['allArticle'],
        ]);
    }

    public function show($slug,$id) {
        $variables = $this->_articleService->showDetail($slug,$id);
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        return view('frontend.pages.article.detail_article',[
           'articleSingle'         => $variables['articleSingle'],
           'articleList'           => $variables['articleList'],
           'url'                   => $url
        ]);
    }
    public function showArticleByCatetory($slug,$id) {
        $variables = $this->_articleService->showArticleByCatetory($slug,$id);
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        return view('frontend.pages.article.list_article',[
            'articles'           => $variables['allArticle'],
            'url'                   => $url
        ]);
    }
//
//    public function search(Request $request) {
//        $variables = $this->_productService->search($request);
//
//        return view('frontend.pages.product.search_product',[
//            'products'        => $variables['allProduct'],
//        ]);
//    }
//
//    public function searchProductByKeyword(Request $request) {
//        $keyword = $request->keyword;
//        $variables = $this->_productService->searchProductByKeyword($keyword);
//        return response()->json([
//            'products'  => $variables['data']
//        ]);
//    }
}