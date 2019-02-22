<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/17/18
 * Time: 13:37
 */

namespace App\Repositories;

use App\Models\CategoryProduct;
use App\Repositories\InterfaceRepository\CategoryProductRepositoryInterface;

class CategoryProductRepository extends EloquentRepository implements CategoryProductRepositoryInterface
{
    public function getCategoryProduct($params) {
        $model = $this->_model->where('left', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->orderBy('left', 'ASC')
            ->get();
    }
    public function getCategoryProductNeedConfirm($params) {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['confirm_action']) && $params['confirm_action'] != 'all') {
            $model->where('confirm_action', $params['confirm_action']);
        }

        return $model->skip($params['offset'])
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', "<>", NULL)
            ->take($params['limit'])
            ->orderBy('left', 'ASC')
            ->get();
    }

    public function getCategoryProductConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllCategoryProductConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getAll() {
        return $this->_model->where('left', '>', 0)
            ->orderBy('left', 'ASC')
            ->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }

    public function getModel()
    {
        return CategoryProduct::class;
    }

    public function lists() {
        return $this->_model->where('status', '<>', 'delete')->pluck('name', 'id')->all();
    }

    public function getTree() {
        return $this->_model->where('left', '>', 0)
                            ->where('status', '=', 'active')
                            ->orderBy('left', 'ASC')
                            ->get();
    }

    public function mapsDataDefault($data)
    {
        return array(
            'name' => isset($data['name']) ? $data['name'] : null,
            'slug' => isset($data['slug']) ? AliasString($data['slug']) : AliasString($data['name']),
            'status' => isset($data['status']) ? $data['status'] : 'active',
            'parent' => isset($data['parent']) ? $data['parent'] : 0,
            'show_frontend' => isset($data['show_frontend']) ? $data['show_frontend'] : 'show',
            'description' => isset($data['description']) ? $data['description'] : null
        );
    }

    public function getCategoryProductBySlugOnSite($slug){
        return $this->_model->where('status',"active")->where('slug',$slug)->first();
    }
    public function getCategoryProductByIdOnSite($id){
        return $this->_model->where('status',"active")->where('id',$id)->first();
    }
}