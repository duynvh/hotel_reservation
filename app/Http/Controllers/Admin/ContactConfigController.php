<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactConfigService;
use Illuminate\Http\Request;

class ContactConfigController extends Controller
{
    private $contactConfigService;

    public function __construct(ContactConfigService $contactConfigService) {
        $this->contactConfigService = $contactConfigService;
    }

    public function index() {
        $variables = $this->contactConfigService->index();
        $view = "admin.pages.contact-config";
        return view("$view.index",[
            'contactConfig'  => $variables['data'],
        ]);
    }

    public function save(Request $request) {
        $this->contactConfigService->save($request);
    }
}