<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 12/4/18
 * Time: 20:54
 */

namespace App\Providers;

use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\Setting;
use App\Models\Product;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*', function ($view) {
            $contactConfigItem = Setting::where('option_name', 'setting_contact')->first();
            $dataContact = json_decode($contactConfigItem->option_value);
            $socialConfigItem = Setting::where('option_name', 'setting_social')->first();
            $dataSocial = json_decode($socialConfigItem->option_value);
            $seoConfigItem = Setting::where('option_name', 'setting_seo')->first();
            $dataSeo = json_decode($seoConfigItem->option_value);


            $view->with([
                'contactConfig' => $dataContact, 
                'dataSocial' => $dataSocial,
                'seoConfig' => $dataSeo
            ]);
        });
//        'frontend.layouts.popup_cart'
        view()->composer('*', function ($view) {
            $products = "";
            $data = "";
            $coupon = "";
            if (Session::get("product_in_cart") !== null) {
                $data = Session::get("product_in_cart");
                $coupon = Session::get("coupon");
                $listId = array_keys($data);
                $products = Product::where('status', "active")
                    ->withoutGlobalScope('confirm')
                    ->where('products.confirm_action', null)
                    ->find($listId)->keyBy('id');


            }
//            dd($products);
            $view->with(['dataCartHeader' => $data, 'productsHeader' => $products, 'couponHeader' => $coupon]);
        });
//
//        view()->composer('frontend.blocks.partial.search_header', function ($view) {
//            $categories = CategoryProduct::where('status', 'active')->where('level', '1')->get();
//
//            $view->with('categoriesSearch', $categories);
//        });
//
//        view()->composer('*', function ($view) {
//            $seoConfigItem = Setting::where('option_name', 'setting_seo')->first();
//            $data = json_decode($seoConfigItem->option_value);
//            $view->with('seoConfig', $data);
//        });
//
        view()->composer('*', function ($view) {
            $categoriesLv1 = CategoryProduct::where('status', 'active')->orderBy('left', 'asc')->where('id', '>', '0')->withoutGlobalScope('confirm')->where('confirm_action', null)->where('level', '=', '1')->get();

            $view->with(['categoriesHeaderLv1' => $categoriesLv1]);
        });
//
        view()->composer('*', function ($view) {
            $attributeConfigItem = Setting::where('option_name', 'setting_attribute')->first();
            $data = json_decode($attributeConfigItem->option_value);
            $view->with('attributeConfig', $data);
        });

        view()->composer('frontend.blocks.box.sidebar_left_article', function ($view) {
            $categoriesArticle = CategoryArticle::where('status', 'active')->where('level', '1')->get();
            $articleNew = Article::join('categories_article', 'articles.category_article_id', '=', 'categories_article.id')
                ->where('categories_article.status',"active")
                ->where('articles.status', "active")
                ->select(['articles.*'])
                ->withoutGlobalScope('confirm')
                ->where('articles.confirm_action', null)
                ->orderBy('articles.created_at', 'desc')
                ->get(5);
            $articleViewHigher = Article::join('categories_article', 'articles.category_article_id', '=', 'categories_article.id')
                ->where('categories_article.status',"active")
                ->where('articles.status', "active")
                ->select(['articles.*'])
                ->withoutGlobalScope('confirm')
                ->where('articles.confirm_action', null)
                ->orderBy('articles.view', 'desc')
                ->get(5);
            $view->with(['categoriesArticle' => $categoriesArticle, 'articleNew' => $articleNew, 'articleViewHigher' => $articleViewHigher]);
        });

        view()->composer('frontend.blocks.box.sidebar_left_product', function ($view) {
            $categoriesProduct = CategoryProduct::where('status', 'active')->where('level', '1')->get();
            $productNew = Product::join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
                ->where('categories_product.status',"active")
                ->where('products.status', "active")
                ->select(['products.*'])
                ->withoutGlobalScope('confirm')
                ->where('products.confirm_action', null)
                ->orderBy('products.created_at', 'desc')
                ->get(3);
            $productViewHigher = Product::join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
                ->where('categories_product.status',"active")
                ->where('products.status', "active")
                ->select(['products.*'])
                ->withoutGlobalScope('confirm')
                ->where('products.confirm_action', null)
                ->orderBy('products.view', 'desc')
                ->orderBy('products.updated_at', 'desc')
                ->get(3);
            $productSale = Product::join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
                ->where('categories_product.status',"active")
                ->where('products.status', "active")
                ->select(['products.*'])
                ->withoutGlobalScope('confirm')
                ->where('products.confirm_action', null)
                ->orderBy('products.price', '<>','products.price_old')
                ->orderBy('products.updated_at', 'desc')
                ->get(3);
            $view->with(['categoriesProduct' => $categoriesProduct,'productNew'=>$productNew,'productViewHigher'=>$productViewHigher,'productSale'=>$productSale]);
        });
    }

    public function register()
    {
        //
    }
}