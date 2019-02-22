@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Sản phẩm </h3>
    </div>
    @include('admin.blocks.notify.notify_notice')
@endsection

@section('content')
    @include('admin.layouts.partial.filter', array(
        'confirm_action' => array(
            'all' => 'Lọc theo hành động',
            'add' => 'Thêm',
            'update' => 'Chỉnh sửa',
            'delete' => 'Xóa',
        ),
        'categoryArticle'  => $categories,
        'action' => route('product.indexConfirm')
    ))
    {{--Danh sach--}}
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a class="collapse-link" data-toggle="tooltip" data-placement="bottom"
                               data-original-title="Show/Hide">
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
                                <th class="column-title">Hình ảnh</th>
                                <th class="column-title">Tên sản phẩm</th>
                                <th class="column-title">Danh mục</th>
                                <th class="column-title">Giá bán đầu</th>
                                <th class="column-title">Giá hiện tại</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="column-title">Quản lý</th>
                                <th class="bulk-actions" colspan="5">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                                <th class="column-title">ID</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($products))
                                @foreach ( $products as $product )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records"
                                                   value="{{$product->id}}">
                                        </td>
                                        <td class="td-content gallery-rebox">
                                            <a href="{{ asset('public/upload/images/product/' . $product->image) }}">
                                                <img alt="{{ $product->name  }}"
                                                     src="{{ asset('public/upload/images/product/75x50/' . $product->image) }}"
                                                     class="thumb"/>
                                            </a>
                                        </td>
                                        <td class="td-content">{{$product->name}}</td>
                                        <td class="td-content">
                                            <p>{{$product->categoryProduct->name}}</p>
                                        </td>
                                        <td class="td-content">{{ number_format($product->price_old) }} đ</td>
                                        <td class="td-content">{{ number_format($product->price) }} đ</td>
                                        <td class="td-content">
                                            <?php
                                            if ($product->confirm_action == 'add') {
                                                $labelAction = 'primary';
                                            } elseif ($product->confirm_action == 'update') {
                                                $labelAction = 'warning';
                                            } elseif ($product->confirm_action == 'delete') {
                                                $labelAction = 'danger';
                                            }
                                            ?>
                                            <button type="button" class="btn btn-<?php echo $labelAction; ?> btn-xs">
                                                <?php
                                                if ($product->confirm_action == 'add') {
                                                    echo "Thêm";
                                                } elseif ($product->confirm_action == 'update') {
                                                    echo "Sửa";
                                                } elseif ($product->confirm_action == 'delete') {
                                                    echo "Xóa";
                                                }
                                                ?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('product.confirm', $product->id)}}" class="btn btn-info btn-xs"
                                               data-toggle="tooltip" data-placement="bottom"
                                               data-original-title="Chỉnh sửa thông tin">
                                                <i class="glyphicon glyphicon-eye-open"></i> Xem
                                            </a>
                                        </td>
                                        <td class="td-content">{{$product->id}}</td>
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

@section('js_content')

@endsection