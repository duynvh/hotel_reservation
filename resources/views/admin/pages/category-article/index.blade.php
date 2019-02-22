<?php
use App\Repositories\CategoryArticleRepository;
$model = new CategoryArticleRepository();
?>
@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Danh mục bài viết </h3>
    </div>
    @include('admin.blocks.notify.notify_notice')
@endsection

@section('content')
    @include('admin.layouts.partial.button', array(
        'router_add' => route('category-article.create'),
        'total_active' => '',
        'total_inactive' => '',
        'router_status' => route('category-article.status'),
        'router_delete' => route('category-article.delete'),
        'router_confirm' => route('category-article.indexConfirm')

    ))

    @include('admin.layouts.partial.filter', array(
        'status' => array(
            'all' => 'Lọc theo tình trạng',
            'inactive' => 'Không hoạt động',
            'active' => 'Hoạt động'
        ),
        'action' => route('category-article.index')
    ))
    {{--Danh sach--}}
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Show/Hide">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr class="headings a-center">
                                <th><input type="checkbox" id="check-all" class="flat"></th>
                                <th class="column-title">Tên</th>
                                <th class="column-title">Sắp xếp</th>
                                <th class="column-title">Thứ tự</th>
                                <th class="column-title">Chỉnh sửa</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="column-title">Quản lý</th>
                                <th class="bulk-actions" colspan="5">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($categories))
                                @foreach ( $categories as $category )
                                    @php
                                        $route = 'category-article';
                                        $id = $category->id;
                                        $childList[$category->parent][]	= $category->id;
                                        $orderingValue	= array_search($category->id, $childList[$category->parent]);

                                        $nodeParentInfo = $model->find($category->parent);
                                        $btnMoveUp		= showButtonMove($id, 'up', $category->left, $nodeParentInfo->left + 1, $route);
                                        $btnMoveDown	= showButtonMove($id, 'down', $category->right + 1, $nodeParentInfo->right, $route);
                                    @endphp
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records" value="{{$category->id}}">
                                        </td>
                                        @php
                                            $space = str_repeat('|-----', $category->level - 1);
                                        @endphp
                                        <td class="td-content">{{$space . $category->name}}</td>
                                        <td class="td-content">
                                            <?php echo $btnMoveUp . ' ' . $btnMoveDown?>
                                        </td>
                                        <td class="td-content">
                                            <input style="text-align:center; width: 50px;" id="ordering-<?php echo $category->id; ?>" type="text" class="center" name="ordering[<?php echo $category->id; ?>]" value="<?php echo $orderingValue + 1; ?>" />
                                        </td>
                                        <td class="td-content">
                                            <p>{{$category->updated_at}}</p>
                                        </td>
                                        <td class="td-content">
                                            <?php $labelStatus = ($category->status == 'active') ? 'success' : 'danger'; ?>
                                            <?php $toStatus = ($category->status == 'active') ? 'to-inactive' : 'to-active'; ?>
                                            <button onclick="changeStatusByIds('{{$category->id}}', '{{$toStatus}}')" type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo ($category->status == 'active') ? "Kích hoạt" : "Không kích hoạt";?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('category-article.edit', $category->id)}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Chỉnh sửa thông tin">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>
                                            <a href="javascript:deleteByIds('{{$category->id}}')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Xóa phần tử">
                                                <i class="fa fa-trash-o"></i> Xoá
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr class="pointer">
                                <td class="td-content" colspan="5">Không có dữ liệu nào</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Phan trang--}}
    @include('admin.layouts.partial.pagination', array('pagination' => $paginator))

@endsection
