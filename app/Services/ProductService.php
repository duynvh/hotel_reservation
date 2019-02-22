<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use App\Repositories\InterfaceRepository\ProductRepositoryInterface;
use App\Repositories\InterfaceRepository\CategoryProductRepositoryInterface;
use App\Helper\ImageOption;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ProductService
{
    private $productRepository;
    private $categoryProductRepository;
    private $imageOption;
    private $infoBasic;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryProductRepositoryInterface $categoryProductRepository, ImageOption $imageOption)
    {
        $this->productRepository = $productRepository;
        $this->categoryProductRepository = $categoryProductRepository;
        $this->imageOption = $imageOption;
        $this->infoBasic = $this->productRepository->getInfoBasic();
    }

    public function indexConfirm($params)
    {
        $data = $this->productRepository->getProductNeedConfirm($params);
        $dataAll = $this->productRepository->getAll();
        $listCategories = $this->categoryProductRepository->getTree();
        $category[''] = 'Chọn danh mục';
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }

        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'infoBasic' => $this->infoBasic,
            'categories' => $category,
        ];
    }

    public function editConfirm($id)
    {
        $data = $this->productRepository->getProductConfirm($id);
        $dataNew = json_decode($data->data_update, true);
        $listCategories = $this->categoryProductRepository->getTree();
        $category[''] = 'Chọn danh mục';
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }

        $image_detail = json_decode($data->image_detail, true);
        if ($dataNew['image_detail'] !== []) {
            $image_detail_new = json_decode($dataNew['image_detail'], true);

        } else {
            $image_detail_new = [];
        }
        $image_remove = $dataNew['image_remove'];
        $image_merge = array_unique(array_merge($image_detail, $image_detail_new));

        foreach ($image_remove as $key => $value) {
            $position = array_search($value, $image_merge);
            unset($image_merge[$position]);
        }
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'dataNew' => $dataNew,
            'categories' => $category,
            'image_detail' => $image_detail,
            'image_detail_new' => $image_merge,

        ];
    }

    public function updateConfirmCancel($request, $id)
    {
        $product = $this->productRepository->getProductConfirm($id);
        if ($product->confirm_action === 'add') {
            $image_product = 'upload/images/' . $this->infoBasic['route'] . '/' . $product->image;
            $image_product_small = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $product->image;
            if (File::exists($image_product)) {
                File::delete($image_product);
            }
            if (File::exists($image_product_small)) {
                File::delete($image_product_small);
            }
            $image_detail = json_decode($product->image_detail, true);
            if ($image_detail !== []) {
                foreach ($image_detail as $image) {
                    $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $image;
                    $image_small_old = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $image;
                    if (File::exists($image_old)) {
                        File::delete($image_old);
                    }
                    if (File::exists($image_small_old)) {
                        File::delete($image_small_old);
                    }
                }
            }
            $this->productRepository->destroyHidden($id);
        } elseif ($product->confirm_action === 'update') {
            $data_new = json_decode($product->data_update, true);
            if ($data_new['image_detail'] !== []) {
                $image_detail_new = json_decode($data_new['image_detail'], true);
            } else {
                $image_detail_new = [];
            }
            if ($data_new['image'] != $product->image) {
                $image_new = 'upload/images/' . $this->infoBasic['route'] . '/' . $data_new['image'];
                $image_new_small = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $data_new['image'];
                if (File::exists($image_new)) {
                    File::delete($image_new);
                }
                if (File::exists($image_new_small)) {
                    File::delete($image_new_small);
                }
            }
            if ($image_detail_new !== []) {
                foreach ($image_detail_new as $image) {
                    $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $image;
                    $image_small_old = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $image;
                    if (File::exists($image_old)) {
                        File::delete($image_old);
                    }
                    if (File::exists($image_small_old)) {
                        File::delete($image_small_old);
                    }
                }
            }
            $data['data_update'] = NULL;
            $data['confirm_action'] = NULL;
            $this->productRepository->updateHidden($data, $id);
        } elseif ($product->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->productRepository->updateHidden($data, $id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function updateConfirmApply($request, $id)
    {
        $product = $this->productRepository->getProductConfirm($id);
        if ($product->confirm_action === 'add') {
            $data['confirm_action'] = NULL;

            $this->productRepository->updateHidden($data, $id);
        } elseif ($product->confirm_action === 'update') {
            $data = json_decode($product->data_update, true);

            $image_detail = json_decode($product->image_detail, true);
            if ($data['image_detail'] !== []) {
                $image_detail_new = json_decode($data['image_detail'], true);
            } else {
                $image_detail_new = [];
            }
            $image_remove = $data['image_remove'];

            $image_merge = array_unique(array_merge($image_detail, $image_detail_new));
            if ($image_remove !== null) {
                foreach ($image_remove as $key => $value) {
                    $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $value;
                    $image_small_old = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $value;
                    if (File::exists($image_old)) {
                        File::delete($image_old);
                    }
                    if (File::exists($image_small_old)) {
                        File::delete($image_small_old);
                    }

                    $position = array_search($value, $image_merge);
                    unset($image_merge[$position]);
                }
            }
            if ($data['image'] !== $product->image) {
                $image_new = 'upload/images/' . $this->infoBasic['route'] . '/' . $product->image;
                $image_new_small = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $product->image;
                if (File::exists($image_new)) {
                    File::delete($image_new);
                }
                if (File::exists($image_new_small)) {
                    File::delete($image_new_small);
                }
            }

            $data['confirm_action'] = NULL;
            $data['data_update'] = NULL;
            $image_merge = array_values($image_merge);
            $data['image_detail'] = json_encode($image_merge);
            unset($data['image_remove']);
//            dd($data);
            $this->productRepository->updateHidden($data, $id);
        } elseif ($product->confirm_action === 'delete') {
            $data['confirm_action'] = NULL;
            $this->productRepository->updateHidden($data, $id);
            $this->productRepository->destroyHidden($id);
        }
        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function index($params)
    {
        $data = $this->productRepository->getProduct($params);
        $dataAllHidden = $this->productRepository->getAllProductConfirm();
        $dataAll = $this->productRepository->getAll();
        $listCategories = $this->categoryProductRepository->getTree();
        $category[''] = 'Chọn danh mục';
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }
        return [
            'data' => $data,
            'dataAll' => $dataAll,
            'dataAllHidden' => $dataAllHidden,
            'infoBasic' => $this->infoBasic,
            'categories' => $category,
        ];
    }


    public function create()
    {
        $data = $this->categoryProductRepository->getInfoBasic();
        $listCategories = $this->categoryProductRepository->getTree();
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }
        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'categories' => $category,
        ];
    }

    public function store($request)
    {
        if ($request->image != null) {

            if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
                mkdir('upload/images/' . $this->infoBasic['route'], 0777, true);
            }

            $image_file = $request->file('image');
            $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
            $image_full_name = $prefixName . '.' . $image_file->getClientOriginalExtension();
            $move = $image_file->move('upload/images/' . $this->infoBasic['route'], $image_full_name);
            if ($move) {
                if (!is_dir('upload/images/' . $this->infoBasic['route'] . '/75x50')) {
                    mkdir('upload/images/' . $this->infoBasic['route'] . '/75x50', 0777, true);
                }

                $dataImage['path'] = 'upload/images/' . $this->infoBasic['route'];
                $dataImage['pathNew'] = 'upload/images/' . $this->infoBasic['route'] . '/75x50';
                $dataImage['name'] = $image_full_name;
                $dataImage['width'] = 75;
                $dataImage['height'] = 50;
                $this->imageOption->resizeImage($dataImage);


                $image_detail = $this->getJsonImages($request);
                if ($image_detail == []) {
                    $image_detail = "[]";
                }
                if (Gate::allows('editor', Auth::user())) {
                    $confirm = 'add';
                } else if (Gate::allows('admin', Auth::user())) {
                    $confirm = NULL;
                }
                $data = [
                    'name' => $request->name,
                    'status' => $request->status,
                    'new' => $request->new,
                    'check_item' => $request->check_item,
                    'price' => $request->price,
                    'price_old' => $request->price_old,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'content' => $request->content,
                    'category_product_id' => intval($request->category_product_id),
                    'image' => $image_full_name,
                    'image_detail' => $image_detail,
                    'confirm_action' => $confirm,
                ];

                $this->productRepository->store($data);

                return redirect()
                    ->route($this->infoBasic['route'] . '.index')
                    ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.ADD')]);
            } else {
                return redirect()
                    ->back()
                    ->with(['noticeMassage' => 'Lỗi upload hình thử lại sau']);
            }
        }
    }

//
    public function edit($id)
    {
        $data = $this->productRepository->find($id);
        $listCategories = $this->categoryProductRepository->getTree();
        if (!empty($listCategories)) {
            foreach ($listCategories as $cate) {
                $space = str_repeat('|-----', $cate->level - 1);
                $category[$cate->id] = $space . $cate->name;
            }
        }
//        dd($category);
        $image_detail = json_decode($data->image_detail, true);

        return [
            'infoBasic' => $this->infoBasic,
            'data' => $data,
            'image_detail' => $image_detail,
            'categories' => $category,
        ];
    }

    public function update($request, $id)
    {
        $product = $this->productRepository->find($id);
        if ($product != null) {
            $image_detail_product = $product->image_detail;
            $image_detail_product = $this->getJsonImageNew($image_detail_product);

            $image_remove = $image_detail_product["remove"];
            $image_full_name = $this->getNameImage($request);
            if ($image_full_name == null) {
                $image_full_name = $product->image;
            }
            if (Gate::allows('admin', Auth::user())) {
                if ($image_full_name == "") {
                    $image_full_name = $product->image;
                }
            }
            $image_detail_new = $this->getJsonImages($request);
            if ($image_detail_new == []) {
                if (Gate::allows('admin', Auth::user())) {
                    $image_detail_new = $image_detail_product["new"];
                    $image_detail_new = json_encode($image_detail_new);
                }
            } else {
                if (Gate::allows('admin', Auth::user())) {
                    $image_detail_new = json_decode($image_detail_new, true);
                    $image_detail_new = array_unique(array_merge($image_detail_new, $image_detail_product["new"]));
                    $image_detail_new = json_encode($image_detail_new);
                }
            }

        }

        $dataNew = [
            'name' => $request->name,
            'status' => $request->status,
            'new' => $request->new,
            'check_item' => $request->check_item,
            'price' => $request->price,
            'price_old' => $request->price_old,
            'slug' => $request->slug,
            'description' => $request->description,
            'content' => $request->content,
            'category_product_id' => intval($request->category_product_id),
            'image' => $image_full_name,
            'image_detail' => $image_detail_new,
        ];
        if (Gate::allows('editor', Auth::user())) {
            $confirm = 'update';
            $dataNew['image_remove'] = $image_remove;
            $json_data = json_encode($dataNew);
            $data['data_update'] = $json_data;
        } else if (Gate::allows('admin', Auth::user())) {
            $data = $dataNew;
            $confirm = NULL;
        }
        $data['confirm_action'] = $confirm;
        if (Gate::allows('admin', Auth::user())) {
            if ($image_remove != null) {
                foreach ($image_remove as $image) {
                    $image_old = 'upload/images/' . $this->infoBasic['route'] . '/' . $image;
                    $image_small_old = 'upload/images/' . $this->infoBasic['route'] . '/75x50/' . $image;
                    if (File::exists($image_old)) {
                        File::delete($image_old);
                    }
                    if (File::exists($image_small_old)) {
                        File::delete($image_small_old);
                    }
                }
            }
        }
//        dd($data);
        $this->productRepository->update($data, $id);

        return redirect()
            ->route($this->infoBasic['route'] . '.index')
            ->with(['noticeMessage' => Config::get('constants.SUCCESSFUL_MESSAGE.EDIT')]);
    }

    public function destroy($id)
    {
        $data = [
            'status' => 'deleted'
        ];

        $this->productRepository->update($data, $id);
        return redirect()
            ->route($this->infoBasic['route'] . '.index');
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
            $this->productRepository->changeStatus($ids, $status);
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
                $this->productRepository->update($data, $ids);
            } else {
                $this->productRepository->delete($ids);
            }
            echo json_encode(array('status' => 1, 'data' => $ids, 'msg' => Config::get('constants.SUCCESSFUL_MESSAGE.DELETE')));
            die();
        }
    }

    public function setArrayImageRemove($request)
    {
        if ($request->ajax()) {
            if ($request->has('emptyItem')) {
                $checkEmpty = $request->emptyItem;
                if ($checkEmpty === "false") {
                    $arrayImage = $request->arrayImage;
                    Session::flash('imageRemove', $arrayImage);
                    return "IMG-" . $arrayImage;
                }
                return "false1";
            }
            return "false2";
        } else {
            return "false3";
        }
    }

    public function getJsonImageNew($image_detail_product)
    {
        if (Session::has("imageRemove")) {
            $arrayImageRemove = Session::pull("imageRemove");
            $arrayImageRemove = explode(",", $arrayImageRemove);
            $arrayImageOld = json_decode($image_detail_product, true);
            foreach ($arrayImageRemove as $key => $value) {
                if (($position = array_search($value, $arrayImageOld)) !== false) {
                    unset($arrayImageOld[$position]);
                }
            }
            $arrayImageOld = array_values($arrayImageOld);
            $image["new"] = $arrayImageOld;
            $image["remove"] = $arrayImageRemove;
            return $image;
        } else {
            $arrayImageOld = json_decode($image_detail_product, true);
            if (null == $arrayImageOld) {
                $arrayImageOld = array();
            }
            $arrayImageOld = array_values($arrayImageOld);
            $image["new"] = $arrayImageOld;
            $image["remove"] = [];
            return $image;
        }
    }

    public function getNameImage($request)
    {
        if ($request->image != null) {
            if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
                mkdir('upload/images/' . $this->infoBasic['route']);
            }

            $image_file = $request->file('image');
            $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
            $image_full_name = $prefixName . '.' . $image_file->getClientOriginalExtension();
            $move = $image_file->move('upload/images/' . $this->infoBasic['route'], $image_full_name);

            if ($move) {
                if (!is_dir('upload/images/' . $this->infoBasic['route'] . '/75x50')) {
                    mkdir('upload/images/' . $this->infoBasic['route'] . '/75x50', 0777, true);
                }

                $dataImage['path'] = 'upload/images/' . $this->infoBasic['route'];
                $dataImage['pathNew'] = 'upload/images/' . $this->infoBasic['route'] . '/75x50';
                $dataImage['name'] = $image_full_name;
                $dataImage['width'] = 75;
                $dataImage['height'] = 50;
                $this->imageOption->resizeImage($dataImage);

                return $image_full_name;
            } else {
                return "";
            }
        }
    }

    public function getJsonImages($request)
    {
        $json_image = [];
        if ($request->image_detail != null) {
            if (!is_dir('upload/images/' . $this->infoBasic['route'])) {
                mkdir('upload/images/' . $this->infoBasic['route'], 0777, true);
            }
            $test[] = null;
            $array_image_file = $request->file('image_detail');
            foreach ($array_image_file as $key => $value) {
                $prefixName = time() . "_" . rand(0, 9999999) . "_" . md5(rand(0, 9999999));
                $image_full_name = $prefixName . '.' . $value->getClientOriginalExtension();
                $test[] = $image_full_name;
                $move = $value->move('upload/images/' . $this->infoBasic['route'], $image_full_name);
                if ($move) {
                    if (!is_dir('upload/images/' . $this->infoBasic['route'] . '/75x50')) {
                        mkdir('upload/images/' . $this->infoBasic['route'] . '/75x50', 0777, true);
                    }

                    $dataImage['path'] = 'upload/images/' . $this->infoBasic['route'];
                    $dataImage['pathNew'] = 'upload/images/' . $this->infoBasic['route'] . '/75x50';
                    $dataImage['name'] = $image_full_name;
                    $dataImage['width'] = 75;
                    $dataImage['height'] = 50;
                    $this->imageOption->resizeImage($dataImage);

                    $json_image[] = $image_full_name;
                }
            }
            $json_image = array_values($json_image);
            $images = json_encode($json_image);
            return $images;
        } else {
            return [];
        }
    }
}