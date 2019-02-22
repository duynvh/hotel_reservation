<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/10/18
 * Time: 10:42
 */

namespace App\Repositories;

use App\Models\Banner;
use App\Repositories\InterfaceRepository\BannerRepositoryInterface;

class BannerRepository extends EloquentRepository implements BannerRepositoryInterface
{
    public function getModel()
    {
        return Banner::class;
    }

    public function getBanner($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['status']) && $params['status'] != 'all') {
            $model->where('status', $params['status']);
        }

        if (isset($params['type']) && $params['type'] != 'all') {
            $model->where('type', $params['type']);
        }

        return $model->skip($params['offset'])
            ->take($params['limit'])
            ->get();
    }

    public function getBannerNeedConfirm($params)
    {
        $model = $this->_model->where('id', '>', 0);

        if ($params['q'] != '') {
            $model->where('name', 'like', '%' . $params['q'] . '%');
        }

        if (isset($params['confirm_action']) && $params['confirm_action'] != 'all') {
            $model->where('confirm_action', $params['confirm_action']);
        }

        if (isset($params['type']) && $params['type'] != 'all') {
            $model->where('type', $params['type']);
        }

        return $model->skip($params['offset'])
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', "<>", NULL)
            ->take($params['limit'])
            ->get();
    }

    public function getBannerConfirm($id)
    {
        return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
    }

    public function getAllBannerConfirm()
    {
        return $this->_model->withoutGlobalScope('confirm')->where('confirm_action', "<>", NULL)->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }

    public function getBannerOnSite()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', null)
            ->where('status', "active")
            ->orderBy('created_at', 'desc')
            ->where('type', 0)->get();
    }

    public function getSliderOnSite()
    {
        return $this->_model
            ->withoutGlobalScope('confirm')
            ->where('confirm_action', null)
            ->where('status', "active")
            ->where('type', 1)
            ->get();
    }
}