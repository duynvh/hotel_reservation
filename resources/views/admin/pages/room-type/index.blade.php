@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Loại phòng </h3>
    </div>
@endsection

@section('content')
    @include('admin.layouts.partial.button', array(
        'router_add' => route('room-type.create'),
        'total_active' => '',
        'total_inactive' => '',
        'router_status' => route('room-type.status'),
        'router_delete' => route('room-type.delete'),
        'router_confirm' => route('room-type.indexConfirm')
    ))

    @include('admin.layouts.partial.filter', array(
        'status' => array(
            'all' => 'Lọc theo tình trạng',
            'inactive' => 'Không hoạt động',
            'active' => 'Hoạt động'
        ),
        'action' => route('room-type.index')
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
                                <th class="column-title">Tên loại phòng</th>
                                <th class="column-title">Hình ảnh</th>
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
                            @if(!empty($roomTypes))
                                @foreach ( $roomTypes as $type )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records" value="{{$type->id}}">
                                        </td>
                                        <td class="td-content">{{$type->name}}</td>
                                        <td class="td-content gallery-rebox">
                                            <a href="{{ asset('public/upload/images/room-type/' . $type->image) }}">
                                                <img alt="{{ $type->name  }}"
                                                     src="{{ asset('public/upload/images/room-type/75x50/' . $type->image) }}"
                                                     class="thumb"/>
                                            </a>
                                        </td>
                                        <td class="td-content">
                                            <?php $labelStatus = ($type->status == 'active') ? 'success' : 'danger'; ?>
                                            <?php $toStatus = ($type->status == 'active') ? 'to-inactive' : 'to-active'; ?>
                                            <button onclick="changeStatusByIds('{{$type->id}}', '{{$toStatus}}')" type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo ($type->status == 'active') ? "Kích hoạt" : "Không kích hoạt";?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('room-type.edit', $type->id)}}" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Chỉnh sửa thông tin">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>
                                            <a href="javascript:deleteByIds('{{$type->id}}')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" data-original-title="Xóa phần tử">
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

@section('js_content')

@endsection