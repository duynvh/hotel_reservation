<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\InterfaceRepository\ArticleRepositoryInterface;

class ArticleRepository extends EloquentRepository implements ArticleRepositoryInterface
{
    public function getArticle($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if ($params['category_article_id'] != '') {
            $model->where('category_article_id', '=', $params['category_article_id']);
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }

    public function getArticleNeedConfirm($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if ($params['category_article_id'] != '') {
            $model->where('category_article_id', '=', $params['category_article_id']);
        }

        if (isset($params['confirm_action']) && $params['confirm_action'] != 'all') {
            $model->where('confirm_action', $params['confirm_action']);
        }

        return $model->skip($params['offset'])
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', "<>", NULL)
            ->take($params['limit'])
            ->get();
    }

    public function getArticleConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllArticleConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }

    public function getModel()
    {
        return Article::class;
    }

    public function getAllArticleOnSite()
    {
        return $this->_model
            ->join('categories_article', 'articles.category_article_id', '=', 'categories_article.id')
            ->where('categories_article.status', "active")
            ->where('articles.status', "active")
            ->select('articles.*')
            ->withoutGlobalScope('confirm')
            ->where('articles.confirm_action', null)
            ->paginate(1);
    }

    public function getAllArticleByCategoryOnSite($id)
    {
        return $this->_model
            ->join('categories_article', 'articles.category_article_id', '=', 'categories_article.id')
            ->where('categories_article.status', "active")
            ->where('articles.status', "active")
            ->select(['articles.*'])
            ->withoutGlobalScope('confirm')
            ->where('articles.confirm_action', null)
            ->where('articles.category_article_id', $id)
            ->orderBy('articles.created_at', 'desc')
            ->paginate(3);
    }

    public function getArticleByIdOnSite($id)
    {
        return $this->_model
            ->join('categories_article', 'articles.category_article_id', '=', 'categories_article.id')
            ->where('categories_article.status', "active")
            ->where('articles.status', "active")
            ->select(['articles.*'])
            ->where('articles.id', $id)
            ->withoutGlobalScope('confirm')
            ->where('articles.confirm_action', null)
            ->first();
    }

    public function getArticleViewHighestOnSite($id)
    {
        return $this->_model
            ->join('categories_article', 'articles.category_article_id', '=', 'categories_article.id')
            ->where('categories_article.status', "active")
            ->where('articles.status', "active")
            ->where('articles.id', '<>', $id)
            ->select(['articles.*'])
            ->withoutGlobalScope('confirm')
            ->where('articles.confirm_action', null)
            ->get();
    }
}