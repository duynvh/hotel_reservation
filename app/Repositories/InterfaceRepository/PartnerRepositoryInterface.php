<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface PartnerRepositoryInterface
{
    /**
     * Get Partner
     * @return mixed
     */
    public function getPartner($params);

    public function getPartnerNeedConfirm($params);

    public function getPartnerConfirm($id);

    public function getAllPartnerConfirm();

    public function getPartnerOnSite();

}