<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 10/17/18
 * Time: 13:43
 */

namespace App\Services;

use App\Models\CategoryProduct;
use App\Repositories\InterfaceRepository\CategoryProductRepositoryInterface;
use App\Repositories\NestedRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;

class CategoryProductService
{
    protected $nestedRepository = null;
    protected $modelCategory = null;
    protected $categoryProductRepository;
    private $infoBasic;
    private $_limit = 15;

    public function __construct(CategoryProductRepositoryInterface $categoryProductRepository)
    {
        $this->_limit = env('LIMIT_SHOW_LIST', $this->_limit);
        $this->modelCategory = new CategoryProduct();
        $this->categoryProductRepository = $categoryProductRepository;
        $this->infoBasic = $this->categoryProductRepository->getInfoBasic();
        $this->nestedRepository = new NestedRepository(array(
            'table' => 'categories_product',
            'model' => 'CategoryProduct'
        ));
    }

    public function indexConfirm($params)
    {
        $data = $this->categoryProductRepository->getCategoryProductNeedConfirm($params);
        $dataAll = $this->categoryProductRepository->getAll();

        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataAll' => $dataAll
        ];
    }

    public function editConfirm($id)
    {
        $listCategories = $this->categoryProductRepository->getTree();

        $data = $this->categoryProductRepository->getCategoryProductConfirm($id);
        $dataNew = json_decode($data->data_update, true);
        $category['new'] = $this->categoryProductRepository->find($dataNew[0]['parent']);
        $category['old'] = $this->categoryProductRepository->find($data->parent);
        if ($category['new'] == null) {
            $category['new'] = '';
        }
        if ($category['old'] == null) {
            $category['old'] = '';
        }

        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataNew' => $dataNew,
            'category' => $category
        ];
    }

    public function updateConfirmCancel($request, $id)
    {
        $categoryProduct = $this->categoryProductRepository->getCategoryProductConfirm($id);
        if ($categoryProduct->confirm_action === 'add') {
            $this->categoryProductRepository->destroyHidden($id);
        } elseif ($categoryProduct->confirm_action === 'update') {
            $data['data_update'] = NULL;
            $data['confirm_action'] = NULL;
            $this->categoryProductRepository->updateHidden($data, $id);
        } elseif ($categoryProduct->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->categoryProductRepository->updateHidden($data, $id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function updateConfirmApply($request, $id)
    {
        $categoryProduct = $this->categoryProductRepository->getCategoryProductConfirm($id);
        if ($categoryProduct->confirm_action === 'add') {
            $data['confirm_action'] = NULL;
            $data = json_decode($categoryProduct->data_update, true);
            $this->categoryProductRepository->destroyHidden($id);
            $this->nestedRepository->insertNode($data[0], $data[1], $data[2]);

            $this->categoryProductRepository->updateHidden($data, $id);
        } elseif ($categoryProduct->confirm_action === 'update') {
            $dataResetConfirm['confirm_action'] = NULL;
            $dataResetConfirm['data_update'] = NULL;
            $this->categoryProductRepository->updateHidden($dataResetConfirm, $id);
            $data = json_decode($categoryProduct->data_update, true);
            $data[0]['confirm_action'] = NULL;
            $data[0]['data_update'] = NULL;
            $this->updateNodeCategoryProduct($data[0], $data[1], $data[2]);

        } elseif ($categoryProduct->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->categoryProductRepository->updateHidden($data, $id);
            $this->nestedRepository->removeNode($id, ['type' => 'only']);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function index($params)
    {
        $data = $this->categoryProductRepository->getCategoryProduct($params);
        $dataAll = $this->categoryProductRepository->getAll();
        $dataAllHidden = $this->categoryProductRepository->getAllCategoryProductConfirm();
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataAll' => $dataAll,
            'dataAllHidden' => $dataAllHidden,
        ];
    }

    public function create()
    {
        $listCategories = $this->categoryProductRepository->getTree();
        $category[0] = 'Chọn danh mục';
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }
        return $category;
    }

    public function store($request)
    {
        $data = $this->categoryProductRepository->mapsDataDefault($request->all());
        $parent = intval($request->get('parent'));

        if (Gate::allows('editor', Auth::user())) {
            $confirm = 'add';
        } else if (Gate::allows('admin', Auth::user())) {
            $confirm = NULL;
        }

        $dataAdd = [$data, $parent, array('position' => 'right')];
        $json_data = json_encode($dataAdd);
        $data['confirm_action'] = $confirm;
        $data['data_update'] = $json_data;

        if (Gate::allows('editor', Auth::user())) {
            $this->categoryProductRepository->store($data);
        } else if (Gate::allows('admin', Auth::user())) {
            $this->nestedRepository->insertNode($data, $parent, array('position' => 'right'));
        }

        return redirect()
            ->route('category-product.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
    }

    public function edit($id)
    {
        $listCategories = $this->categoryProductRepository->getTree();
        $category[0] = 'Chọn danh mục';
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }

        $data = $this->categoryProductRepository->find($id);
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'categories' => $category
        ];
    }

    public function update($request, $id)
    {
        $data = $this->categoryProductRepository->mapsDataDefault($request->all());
        if (Gate::allows('editor', Auth::user())) {
            $confirm = 'update';
        } else if (Gate::allows('admin', Auth::user())) {
            $confirm = NULL;
        }
        $dataUpdate = [$data, $id, $data['parent']];
        $json_data = json_encode($dataUpdate);
        $data['confirm_action'] = $confirm;

        if (Gate::allows('editor', Auth::user())) {
            $dataNew['data_update'] = $json_data;
            $dataNew['confirm_action'] = $confirm;
            $this->categoryProductRepository->update($dataNew, $id);
        } else if (Gate::allows('admin', Auth::user())) {
            $this->updateNodeCategoryProduct($data, $id, $data['parent']);
        }
        return redirect()
            ->route('category-product.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function changeStatus($request)
    {
        $ids = $request->ids;
        $to_status = $request->type;
        if (!in_array($to_status, array('to-active', 'to-inactive')) || empty($ids)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.ERROR_MESSAGE.ERROR')));
            die();
        } else {
            if (!is_array($ids)) {
                $ids = array($ids);
            }
            $status = ($to_status == 'to-active') ? 'active' : 'inactive';
            $this->categoryProductRepository->changeStatus($ids, $status);
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.CHANGE_STATUS')));
            die();
        }
    }

    public function delete($request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            echo json_encode(array('status' => 0, 'msg' => Config::get('constants.ERROR_MESSAGE.ERROR')));
            die();
        } else {
            if (!is_array($ids)) {
                $ids = array($ids);
            }
            if (Gate::allows('editor', Auth::user())) {
                $data = [
                    'confirm_action' => 'delete'
                ];
                $this->categoryProductRepository->update($data, $ids);
            } else {
                foreach ($ids as $id) {
                    $this->nestedRepository->removeNode($id, ['type' => 'only']);
                }
            }
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }

    protected function updateNodeCategoryProduct($data, $nodeID, $nodeParentID = null)
    {
        if (isset($nodeParentID)) {
            $nodeParentInfo = $this->nestedRepository->findById($this->modelCategory, $nodeParentID);
            $nodeInfo = $this->nestedRepository->findById($this->modelCategory, $nodeID);
            if (!empty($nodeParentInfo) && $nodeInfo->parent != $nodeParentInfo->id) {
                $this->nestedRepository->moveRight($nodeID, $nodeParentID);
            }
        }

        $dataUpdate = array();
        foreach ($data as $k => $v) {
            if ($v != null) {
                $dataUpdate[$k] = $v;
            }
        }

        $this->categoryProductRepository->update($dataUpdate, $nodeID);
    }

    public function moveNode($request) {
        $this->nestedRepository->moveItem($request);
        echo json_encode(array('status' => 1, 'msg' => 'Chuyển vị trí thành công.'));
        die();
    }
}