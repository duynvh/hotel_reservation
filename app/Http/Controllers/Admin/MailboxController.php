<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailboxRequest;
use App\Http\Requests\ReplyMailboxRequest;
use App\Services\MailboxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class MailboxController extends Controller
{
    private $mailboxService;

    public function __construct(MailboxService $mailboxService)
    {
        $this->mailboxService = $mailboxService;
    }

    public function index()
    {
        $variables = $this->mailboxService->index();
        return view('admin.pages.mailbox.index', [
            'data_table' => $variables['data'],
            'infoBasic' => $variables['infoBasic'],
            'view' => 'index_table',
        ]);
    }

    public function show($id)
    {
        $variables = $this->mailboxService->show($id);
        return view('admin.pages.mailbox.read', [
            'data_one' => $variables['data'],
            'infoBasic' => $variables['infoBasic'],
            'view' => 'read_mail',
        ]);
    }

    public function showTrash()
    {
        $variables = $this->mailboxService->showTrash();
        return view('admin.pages.mailbox.trash', [
            'data_table' => $variables['data'],
            'infoBasic' => $variables['infoBasic'],
            'view' => 'trash_table',
        ]);
    }

    public function reply($id)
    {
        $variables = $this->mailboxService->replyMail($id);
        return view('admin.pages.mailbox.reply', [
            'data_one' => $variables['data'],
            'infoBasic' => $variables['infoBasic'],
        ]);
    }

    public function sendReply(ReplyMailboxRequest $request)
    {
        return $this->mailboxService->sendReply($request);
    }

    public function viewSend()
    {
        return view('admin.pages.mailbox.sendMail');
    }

    public function sendNewMail(Request $request)
    {
        $rules = [
            'toEmail' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ];

        $messages = [
            'toEmail.required' => Config::get('constants.VALIDATE_MESSAGE.EMAIL_REQUIRED'),
            'subject.required' => Config::get('constants.VALIDATE_MESSAGE.SUBJECT_REQUIRED'),
            'content.required' => Config::get('constants.VALIDATE_MESSAGE.MESSAGE_REQUIRED'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        } else {
            return $this->mailboxService->sendNewMail($request);
        }
    }

    public function deleteTrash(Request $request)
    {
        return $this->mailboxService->deleteTrash($request);
    }

    public function moveTrash(Request $request)
    {
        return $this->mailboxService->moveTrash($request);
    }

    public function destroy($id)
    {
        return $this->mailboxService->destroy($id);
    }

}
