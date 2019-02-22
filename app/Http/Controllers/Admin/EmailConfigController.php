<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EmailConfigService;
use Illuminate\Http\Request;

class EmailConfigController extends Controller
{
    private $emailConfigService;

    public function __construct(EmailConfigService $emailConfigService) {
        $this->emailConfigService = $emailConfigService;
    }

    public function index() {
        $variables = $this->emailConfigService->index();
        $view = "admin.pages.email-config";
        return view("$view.index",[
            'emailConfig'  => $variables['data'],
        ]);
    }

    public function save(Request $request) {
        $this->emailConfigService->save($request);
    }
}