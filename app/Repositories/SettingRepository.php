<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/18/18
 * Time: 22:20
 */

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\InterfaceRepository\SettingRepositoryInterface;

class SettingRepository extends EloquentRepository implements SettingRepositoryInterface
{

    public function getSettingByOptionName($name)
    {
        return $this->_model->where('option_name', '=', $name)->first();
    }

    public function getModel() {
        return Setting::class;
    }

    public function updated($data, $name) {
        $model = $this->_model->where('option_name', '=', $name)->first();
        return $model->update([
            'option_value'      => $data
        ]);
    }
}