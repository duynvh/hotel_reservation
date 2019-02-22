<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SeoConfigService;
use Illuminate\Http\Request;

class SeoConfigController extends Controller
{
    private $seoConfigService;

    public function __construct(SeoConfigService $seoConfigService) {
        $this->seoConfigService = $seoConfigService;
    }

    public function index() {
        $variables = $this->seoConfigService->index();
        $view = "admin.pages.seo-config";
        return view("$view.index",[
            'seoConfig'  => (object)$variables['data'],
        ]);
    }

    public function save(Request $request) {
        $this->seoConfigService->save($request);
    }
}