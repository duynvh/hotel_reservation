<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/5/2018
 * Time: 9:52 AM
 */

namespace App\Services\Site;


use App\Repositories\InterfaceRepository\MailboxRepositoryInterface;

class ContactService
{
    private $mailboxRepository;

    public function __construct(MailboxRepositoryInterface $mailboxRepository)
    {
        $this->mailboxRepository = $mailboxRepository;
    }

    public function storeMailbox($request){
        $data = [
            'full_name' => $request->full_name,
            'email'     => checkInputString($request->email),
            'subject'   => checkInputString($request->subject),
            'message'   => checkInputString($request->message),
            'phone'     => checkInputSoKhongAm($request->phone),
        ];

        $this->mailboxRepository->store($data);

        return redirect()
            ->back()
            ->with('noticeMassage', 'Đã gửi liên hệ thành công');
    }
}