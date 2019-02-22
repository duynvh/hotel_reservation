<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/7/18
 * Time: 00:15
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\GroupService;
use App\Http\Requests\GroupRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
class GroupController extends Controller
{
    private $groupService;
    private $_limit = 15;

    public function __construct(GroupService $groupService) {
        $this->groupService = $groupService;
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
    }

    public function index(Request $request) {
        $params_default = array('q' => '', 'status' => 'all');
        $params = array_merge($params_default, $request->all());

        // Set page
        $page = intval($request->get('page', 1));
        $page = ($page > 0) ? $page : 1;
        $offSet = ($page - 1) * $this->_limit;
        $offSet = ($offSet > 0) ? $offSet : 0;

        // Load Data
        $paramsModel = array(
            'q' => !empty($params['q']) ? $params['q'] : '',
            'status' => !empty($params['status']) ? $params['status'] : '',
            'offset' => $offSet,
            'limit' => intval($this->_limit)
        );
        $variables = $this->groupService->index($paramsModel);

        // Pagination
        $paginator = new LengthAwarePaginator(array(), count($variables['dataAll']), $this->_limit, $page);
        $params_url = array(
            'q' => ($params['q'] != '') ? (string)$params['q'] : '',
            'status' => ($params['status'] != '') ? (string)$params['status'] : '',
        );
        foreach ($params_url as $k => $v) {
            if ($v == '') unset($params_url[$k]);
        }
        $paginator->setPath('/admin/group?' . http_build_query($params_url));

        return view('admin.pages.group.index', [
            'groups'  => $variables['data'],
            'paginator' => $paginator
        ]);
    }

    public function create() {
        return view('admin.pages.group.create');
    }

    public function store(GroupRequest $request) {
        return $this->groupService->store($request);
    }

    public function edit($id) {
        $variables = $this->groupService->edit($id);
        return view('admin.pages.group.edit', [
            'infoBasic'     => $variables['infoBasic'],
            'data'      => $variables['data'],
        ]);
    }

    public function update(GroupRequest $request, $id) {
        return $this->groupService->update($request, $id);
    }

    public function delete(Request $request) {
        return $this->groupService->delete($request);
    }

    public function changeStatus(Request $request) {
        return $this->groupService->changeStatus($request);
    }
}