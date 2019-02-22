<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface ProductRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getProduct($params);

    public function getProductNeedConfirm($params);

    public function getProductConfirm($id);

    public function getAllProductConfirm();

    public function incrementView($id);

    public function getProductViewHighestOnSite();

    public function getProductNewOnSite();

    public function getProductRelatedOnSite($category_id);

    public function getProductByIdOnSite($id);

    public function getProductByListIdOnSite($listId);

    public function getAllProductOnSite($params);

    public function getAllProductByCategoryOnSite($id, $params);

    public function getListProduct();

    public function getWishlistProduct($ids);

    public function getBestSellerProduct();

    public function getShortestPriceProductOnSite();

    public function getRandomProductOnSite();
}