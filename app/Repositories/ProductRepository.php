<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use DB;
use App\Models\Product;
use App\Repositories\InterfaceRepository\ProductRepositoryInterface;

class ProductRepository extends EloquentRepository implements ProductRepositoryInterface
{

    public function getProduct($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if ($params['category_product_id'] != '') {
            $model->where('category_product_id', '=', $params['category_product_id']);
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }

    public function getProductNeedConfirm($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if ($params['category_product_id'] != '') {
            $model->where('category_product_id', '=', $params['category_product_id']);
        }

        if ($params['confirm_action'] !== 'all') {
            $model->where('confirm_action', $params['confirm_action']);
        }

        return $model->skip($params['offset'])
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', "<>", NULL)
            ->take($params['limit'])
            ->get();
    }

    public function getProductConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllProductConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }

    public function getModel()
    {
        return Product::class;
    }

    public function incrementView($id)
    {
        return $this->_model->where('id', $id)->increment('view', 1);
    }

    public function getProductViewHighestOnSite()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->orderBy('products.view', 'desc')
            ->paginate(8);
    }

    public function getProductNewOnSite()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->orderBy('products.created_at', 'desc')
            ->paginate(8);
    }

    public function getProductRelatedOnSite($category_id)
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->select(['products.*'])
            ->orderBy('products.created_at', 'desc')
            ->where('products.confirm_action', null)
            ->where('products.category_product_id', $category_id)
            ->orderBy('products.created_at', 'desc')
            ->paginate(8);
    }

    public function getProductByIdOnSite($id)
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->where('products.id', $id)
            ->first();
    }

    public function getProductByListIdOnSite($listId)
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->find($listId)
            ->keyBy('id');
    }

    public function getAllProductOnSite($params = null)
    {
        $model = $this->_model
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->select(['products.*']);

        if ($params['q'] != '') {
            $model->where('products.name', 'like', '%' . $params['q'] . '%');
        }
        if ($params['price'] != '') {
            $model->where('products.price', '>=', $params['price']['start'] . "000")
                ->where('products.price', '<=', $params['price']['end'] . "000");
        }
        if ($params['orderBy'] != '') {
            $model->orderBy('products.' . $params['orderBy']['key'], $params['orderBy']['value']);
        }

        return $model->withoutGlobalScope('confirm')
            ->where('products.confirm_action', null)
            ->orderBy('products.created_at', 'desc')
            ->paginate(9);
    }

    public function getAllProductByCategoryOnSite($id, $params = null)
    {
        $model = $this->_model
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->select(['products.*']);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if ($params['price'] != '') {
            $model->where('products.price', '>=', $params['price']['start'] . "000")
                ->where('products.price', '<=', $params['price']['end'] . "000");
        }
        if ($params['orderBy'] != '') {
            $model->orderBy('products.' . $params['orderBy']['key'], $params['orderBy']['value']);
        }

        return $model->withoutGlobalScope('confirm')
            ->where('products.confirm_action', null)
            ->where('products.category_product_id', $id)
            ->orderBy('products.created_at', 'desc')
            ->paginate(9);
    }


    public function getListProduct()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->pluck('products.color', 'id')
            ->all();
    }

    public function getWishlistProduct($ids)
    {
        return $this->_model->whereIn('id', $ids)
            ->withoutGlobalScope('confirm')
            ->where('products.confirm_action', null)
            ->get();
    }

    public function getBestSellerProduct()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->join('bill_details', 'products.id', '=', 'bill_details.product_id')
            ->where('products.confirm_action', null)
            ->select(DB::raw('products.*, COUNT(products.id) as total'))
            ->groupBy('products.id')
            ->orderBy('total', 'desc')
            ->paginate(3);
    }

    public function getShortestPriceProductOnSite()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->orderBy('products.price', "asc")
            ->orderBy('products.updated_at', 'desc')
            ->get(3);
    }
    public function getRandomProductOnSite()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->join('categories_product', 'products.category_product_id', '=', 'categories_product.id')
            ->where('categories_product.status', "active")
            ->where('products.status', "active")
            ->where('products.confirm_action', null)
            ->select(['products.*'])
            ->inRandomOrder()
            ->get(3);
    }
}