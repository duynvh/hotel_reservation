<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface CategoryProductRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getCategoryProduct($params);

    public function getCategoryProductNeedConfirm($params);

    public function getCategoryProductConfirm($id);

    public function getAllCategoryProductConfirm();

    public function getTree();

    public function mapsDataDefault($data);

    public function lists();

    public function getCategoryProductBySlugOnSite($slug);

    public function getCategoryProductByIdOnSite($id);
}