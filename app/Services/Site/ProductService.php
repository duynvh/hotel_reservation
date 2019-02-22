<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/4/2018
 * Time: 10:59 AM
 */

namespace App\Services\Site;


use App\Repositories\InterfaceRepository\CategoryProductRepositoryInterface;
use App\Repositories\InterfaceRepository\PartnerRepositoryInterface;
use App\Repositories\InterfaceRepository\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService
{
    private $productRepository;
    private $partnerRepository;
    private $categoryProductRepository;

    public function __construct(ProductRepositoryInterface $productRepository,
                                CategoryProductRepositoryInterface $categoryProductRepository, PartnerRepositoryInterface $partnerRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryProductRepository = $categoryProductRepository;
        $this->partnerRepository = $partnerRepository;
    }

    public function index($request)
    {
        $sortQuery = $this->getSortQuery($request);
        $query = isset($request->q) ? $request->q : "";
        $priceFilter = $this->getFilterPriceProduct($request);
        $params = [
            'q' => $query,
            'price' => $priceFilter,
            'orderBy' => $sortQuery
        ];
        $allProduct = $this->productRepository->getAllProductOnSite($params);

        return [
            'allProduct' => $allProduct,
            'query' => $query,
        ];
    }

    public function getFilterPriceProduct($request)
    {
        if ($request->filterPrice != null) {
            $price = explode('-', $request->filterPrice);

        } else if ($request->filterPrice == 'khac') {
            $price = [500, 10000];
        } else {
            $price = '';
        }
        $arrayDataFilter = $price;

        return $arrayDataFilter;
    }

    public function getSortQuery($request)
    {
        if (!isset($request->sortP)) {
            return '';
        }

        $sort = $request->sortP;
        $sortQuery = [];

        if ($sort == "nameasc") {
            $sortQuery['key'] = "name";
            $sortQuery['value'] = "asc";
        } elseif ($sort == "namedesc") {
            $sortQuery['key'] = "name";
            $sortQuery['value'] = "desc";
        } elseif ($sort == "priceasc") {
            $sortQuery['key'] = "price";
            $sortQuery['value'] = "asc";
        } elseif ($sort == "pricedesc") {
            $sortQuery['key'] = "price";
            $sortQuery['value'] = "desc";
        }

        return $sortQuery;
    }


    public function showDetail($slug, $id)
    {
        $arraySlug = explode('-', $id);
        for ($i = 0; $i < count($arraySlug) - 1; $i++) {
            $slug .= '-' . $arraySlug[$i];
        }
        $id = $arraySlug[count($arraySlug) - 1];

        $productSingle = $this->productRepository->getProductByIdOnSite($id);

        $image_detail = json_decode($productSingle->image_detail, true);
        $productRelated = $this->productRepository->getProductRelatedOnSite($productSingle->category_product_id);
        if ($productSingle->slug != $slug) {
            abort(404);
        }
        $this->productRepository->incrementView($id);
        $partner = $this->partnerRepository->getPartnerOnSite();
        return [
            'partner' => $partner,
            'productSingle' => $productSingle,
            'imageDetail' => $image_detail,
            'productRelated' => $productRelated,
        ];
    }

    public function searchProductByKeyword($keyword)
    {
        $data = $this->productRepository->searchProductByKeyword($keyword);
        return [
            'data' => $data
        ];
    }

    public function showProductByCatetory($category, $id, $request)
    {
        $arraySlug = explode('-', $id);
        for ($i = 0; $i < count($arraySlug) - 1; $i++) {
            $category .= '-' . $arraySlug[$i];
        }
        $id = $arraySlug[count($arraySlug) - 1];

        $sortQuery = $this->getSortQuery($request);
        $query = isset($request->q) ? $request->q : "";
        $priceFilter = $this->getFilterPriceProduct($request);
        $params = [
            'q' => $query,
            'price' => $priceFilter,
            'orderBy' => $sortQuery
        ];

        $allProduct = $this->productRepository->getAllProductByCategoryOnSite($id,$params);

        if (count($allProduct) > 0) {
            $categorySingle = $this->categoryProductRepository->getCategoryProductByIdOnSite($allProduct[0]->category_product_id);
            if ($categorySingle->slug != $category) {
                abort(404);
            }
        }
        return [
            'allProduct' => $allProduct,
        ];

    }
}