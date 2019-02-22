<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface ArticleRepositoryInterface
{
    /**
     * Get Article
     * @return mixed
     */
    public function getArticle($params);

    public function getArticleNeedConfirm($params);

    public function getArticleConfirm($id);

    public function getAllArticleConfirm();

    public function getAllArticleOnSite();

    public function getAllArticleByCategoryOnSite($id);

    public function getArticleByIdOnSite($id);

    public function getArticleViewHighestOnSite($id);
}