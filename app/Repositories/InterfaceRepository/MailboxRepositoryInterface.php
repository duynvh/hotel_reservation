<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/22/18
 * Time: 21:13
 */

namespace App\Repositories\InterfaceRepository;


interface MailboxRepositoryInterface
{
    /**
     * Get coupon
     * @return mixed
     */
    public function getAllMails();

    public function getMail($id);

    public function getAllTrashes();
}