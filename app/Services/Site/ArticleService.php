<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/4/2018
 * Time: 10:59 AM
 */

namespace App\Services\Site;

use App\Repositories\InterfaceRepository\ArticleRepositoryInterface;
use App\Repositories\InterfaceRepository\CategoryArticleRepositoryInterface;

class ArticleService
{
    private $articleRepository;
    private $categoryArticleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository, CategoryArticleRepositoryInterface $categoryArticleRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->categoryArticleRepository = $categoryArticleRepository;
    }

    public function index(){
        $allArticle = $this->articleRepository->getAllArticleOnSite();

        return [
            'allArticle'    => $allArticle,
        ];
    }

//    public function search($request){
//        $allProduct = $this->articleRepository->getAllProductOnSite();
//
//        return [
//            'allProduct'    => $allProduct,
//        ];
//    }
//
    public function showDetail($slug, $id){
        $articleSingle = $this->articleRepository->getArticleByIdOnSite($id);
        $articleList = $this->articleRepository->getArticleViewHighestOnSite($id);

        if($articleSingle->slug !== $slug){
            abort(404);
        }
        return [
            'articleSingle'     => $articleSingle,
            'articleList'       => $articleList,
        ];
    }

    public function showArticleByCatetory($slug, $id)
    {
        $category = $this->categoryArticleRepository->getCategoryArticleByIdOnSite($id);
        if ($category->slug !== $slug || $category == null) {
            abort(404);
        } else {
            $articleList = $this->articleRepository->getAllArticleByCategoryOnSite($category->id);
            return [
                'allArticle' => $articleList,
            ];
        }
    }
//
//    public function searchProductByKeyword($keyword) {
//        $data = $this->productRepository->searchProductByKeyword($keyword);
//        return [
//            'data'  => $data
//        ];
//    }
}