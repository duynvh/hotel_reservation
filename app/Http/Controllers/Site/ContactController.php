<?php
/**
 * Created by PhpStorm.
 * User: quocb
 * Date: 12/3/2018
 * Time: 11:00 AM
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailboxRequest;
use App\Services\Site\ContactService;
use App\Services\AboutConfigService;

class ContactController extends Controller
{
    private $_contactService;
    private $_aboutService;

    public function __construct(ContactService $contactService, AboutConfigService $aboutService)
    {
        $this->_contactService = $contactService;
        $this->_aboutService = $aboutService;
    }

    public function index() {
        return view('frontend.pages.contact');
    }

    public function about() {
        $variables = $this->_aboutService->index();
        return view('frontend.pages.about', [
            'content'  => $variables['data']['content'],
            'productBestSeller' => $variables['productBestSeller'],
            'productShortestPrice' => $variables['productShortestPrice'],
            'productRandom' => $variables['productRandom'],
        ]);
    }

    public function store(MailboxRequest $request){
        return $this->_contactService->storeMailbox($request);
    }
}