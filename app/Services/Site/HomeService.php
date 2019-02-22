<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/4/2018
 * Time: 8:21 AM
 */

namespace App\Services\Site;

use App\Repositories\InterfaceRepository\BannerRepositoryInterface;
use App\Repositories\InterfaceRepository\BillDetailRepositoryInterface;
use App\Repositories\InterfaceRepository\PartnerRepositoryInterface;
use App\Repositories\InterfaceRepository\ProductRepositoryInterface;

class HomeService
{
    private $bannerRepository;
    private $productRepository;
    private $billDetailRepository;
    private $partnerRepository;
    private $infoBasic;

    public function __construct(ProductRepositoryInterface $productRepository, BannerRepositoryInterface $bannerRepository,
                                BillDetailRepositoryInterface $billDetailRepository, PartnerRepositoryInterface $partnerRepository)
    {
        $this->bannerRepository = $bannerRepository;
        $this->productRepository = $productRepository;
        $this->billDetailRepository = $billDetailRepository;
        $this->partnerRepository = $partnerRepository;
    }

    public function showIndex()
    {
        $banner = $this->bannerRepository->getBannerOnSite();
        $slider = $this->bannerRepository->getSliderOnSite();
        $partner = $this->partnerRepository->getPartnerOnSite();

        $productViewHighest = $this->productRepository->getProductViewHighestOnSite();
        $productNew = $this->productRepository->getProductNewOnSite();

        $productBestSeller = $this->productRepository->getBestSellerProduct();
        $productShortestPrice = $this->productRepository->getShortestPriceProductOnSite();
        $productRandom = $this->productRepository->getRandomProductOnSite();


        return [
            'banner' => $banner,
            'slider' => $slider,
            'partner' => $partner,
            'productViewHighest' => $productViewHighest,
            'productNew' => $productNew,
            'productBestSeller' => $productBestSeller,
            'productShortestPrice' => $productShortestPrice,
            'productRandom' => $productRandom,
        ];
    }

    public function getProductViewHighest()
    {

    }

    public function getWishlistProduct($ids)
    {
        $products = $this->productRepository->getWishlistProduct($ids);
        return $products;
    }

}