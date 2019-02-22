<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AboutConfigService;
use Illuminate\Http\Request;

class AboutConfigController extends Controller
{
    private $aboutConfigService;

    public function __construct(AboutConfigService $aboutConfigService) {
        $this->aboutConfigService = $aboutConfigService;
    }

    public function index() {
        $variables = $this->aboutConfigService->index();
        $view = "admin.pages.about-config";
        return view("$view.index",[
            'aboutConfig'  => $variables['data'],
        ]);
    }

    public function save(Request $request) {
        $this->aboutConfigService->save($request);
    }
}