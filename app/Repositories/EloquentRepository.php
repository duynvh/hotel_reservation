<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 20:52
 */

namespace App\Repositories;


abstract class EloquentRepository implements RepositoryInterface
{
    protected $_model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {

        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function store(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update(array $attributes, $id)
    {
        if(!is_array($id)) {
            $result = $this->find($id);
            if ($result) {
                $result->update($attributes);
                return $result;
            }
        }
        else {
            $this->_model->whereIn('id', $id)->update($attributes);
            return true;
        }

        return false;
    }

    public function updateHidden(array $attributes, $id)
    {
        if(!is_array($id)) {
            $result = $this->_model->withoutGlobalScope('confirm')->where('id', $id)->first();
            if ($result) {
                return $this->_model->withoutGlobalScope('confirm')->where('id', $id)->update($attributes);
            }
        }
        else {
            $this->_model->withoutGlobalScope('confirm')->whereIn('id', $id)->update($attributes);
            return true;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        if(!is_array($id)) {
            $result = $this->find($id);
            if ($result) {
                $result->delete();

                return true;
            }
        }
        else {
            $this->_model->whereIn('id', $id)->delete();
            return true;
        }

        return false;
    }

    public function destroyHidden($id)
    {
        return $this->_model->where('id',$id)->forcedelete();
    }

    /**
     * Change Status
     *
     * @param $ids
     * @param $status
     * @return bool
     */

    public function changeStatus($ids, $status) {
        return $this->_model->whereIn('id', $ids)->update(['status' => $status]);
    }
}