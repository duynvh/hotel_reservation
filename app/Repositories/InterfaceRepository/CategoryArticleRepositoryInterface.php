<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface CategoryArticleRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getCategoryArticle($params);

    public function getCategoryArticleNeedConfirm($params);

    public function getCategoryArticleConfirm($id);

    public function getAllCategoryArticleConfirm();

    public function getTree();

    public function mapsDataDefault($data);

    public function getAllCategoryArticleOnSite();

    public function getCategoryArticleByIdOnSite($id);

    public function lists();
}