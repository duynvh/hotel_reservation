<?php

namespace App\Repositories;
use App\Models\Mailbox;
use App\Repositories\InterfaceRepository\MailboxRepositoryInterface;

class MailboxRepository extends EloquentRepository implements MailboxRepositoryInterface
{
    public function getAllMails()
    {
        return $this->_model->where('trash',0)->orderBy('created_at','desc')->get();
    }
    public function getMail($id)
    {
        return $this->find($id);
    }

    public function getAllTrashes()
    {
        return $this->_model->where('trash',1)->orderBy('created_at','desc')->get();
    }

    public function getInfoBasic()
    {
        return $this->_model->getInfo();
    }

    public function getModel()
    {
        return Mailbox::class;
    }
}