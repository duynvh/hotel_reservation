@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Món hàng </h3>
    </div>
@endsection

@section('content')
    @include('admin.layouts.partial.button', array(
        'router_add' => route('item.create'),
        'total_active' => '',
        'total_inactive' => '',
        'router_status' => route('item.status'),
        'router_delete' => route('item.delete'),
        'router_confirm' => route('item.indexConfirm')
    ))

    @include('admin.layouts.partial.filter', array(
        'status' => array(
            'all' => 'Lọc theo tình trạng',
            'inactive' => 'Không hoạt động',
            'active' => 'Hoạt động'
        ),
        'action' => route('item.index')
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
                                <th class="column-title">Tên món hàng</th>
                                <th class="column-title">Hình ảnh</th>
                                <th class="column-title">Giá trị</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="column-title">Quản lý</th>
                                <th class="bulk-actions" colspan="6">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($items))
                                @foreach ( $items as $item )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records" value="{{$item->id}}">
                                        </td>
                                        <td class="td-content">{{$item->name}}</td>
                                        <td class="td-content gallery-rebox">
                                            <a href="{{ asset('public/upload/images/item/' . $item->image) }}">
                                                <img alt="{{ $item->name  }}"
                                                     src="{{ asset('public/upload/images/item/75x50/' . $item->image) }}"
                                                     class="thumb"/>
                                            </a>
                                        </td>
                                        <td class="td-content">
                                            <p>{{$item->price}}</p>
                                        </td>
                                        <td class="td-content">
                                            <?php $labelStatus = ($item->status == 'active') ? 'success' : 'danger'; ?>
                                            <?php $toStatus = ($item->status == 'active') ? 'to-inactive' : 'to-active'; ?>
                                            <button onclick="changeStatusByIds('{{$item->id}}', '{{$toStatus}}')" type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo ($item->status == 'active') ? "Kích hoạt" : "Không kích hoạt";?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('item.edit', $item->id)}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Chỉnh sửa thông tin">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>
                                            <a href="javascript:deleteByIds('{{$item->id}}')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Xóa phần tử">
                                                <i class="fa fa-trash-o"></i> Xoá
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr class="pointer">
                                <td class="td-content" colspan="6">Không có dữ liệu nào</td>
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