<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SocialConfigService;
use Illuminate\Http\Request;

class SocialConfigController extends Controller
{
    private $socialConfigService;

    public function __construct(SocialConfigService $socialConfigService) {
        $this->socialConfigService = $socialConfigService;
    }

    public function index() {
        $variables = $this->socialConfigService->index();
        $view = "admin.pages.social-config";
        return view("$view.index",[
            'socialConfig'  => $variables['data'],
        ]);
    }

    public function save(Request $request) {
        $this->socialConfigService->save($request);
    }
}