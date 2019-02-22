<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:07
 */

namespace App\Repositories;


interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function store(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update(array $attributes, $id);

    public function updateHidden(array $attributes, $id);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);


    public function destroyHidden($id);

    /**
     * Change Status
     * @param $ids
     * @param $status
     * @return mixed
     */
    public function changeStatus($ids, $status);
}