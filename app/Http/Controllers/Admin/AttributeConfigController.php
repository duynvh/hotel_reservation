<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/15/18
 * Time: 16:33
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AttributeConfigService;
use Illuminate\Http\Request;

class AttributeConfigController extends Controller
{
    private $attributeConfigService;

    public function __construct(AttributeConfigService $attributeConfigService) {
        $this->attributeConfigService = $attributeConfigService;
    }

    public function index() {
        $variables = $this->attributeConfigService->index();
        $view = "admin.pages.attribute-config";
        return view("$view.index",[
            'attributeConfig'  => (object)$variables['data'],
        ]);
    }

    public function save(Request $request) {
        $this->attributeConfigService->save($request);
    }
}