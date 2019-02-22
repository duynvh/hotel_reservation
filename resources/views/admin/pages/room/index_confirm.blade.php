@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Món hàng </h3>
    </div>
@endsection

@section('content')
    @include('admin.layouts.partial.filter', array(
        'confirm_action' => array(
            'all' => 'Lọc theo hành động',
            'add' => 'Thêm',
            'update' => 'Chỉnh sửa',
            'delete' => 'Xóa',
        ),
        'action' => route('item.indexConfirm')
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
                                <th class="column-title">Số phòng</th>
                                <th class="column-title">Tên phòng</th>
                                <th class="column-title">Loại phòng</th>
                                <th class="column-title">Giá trị</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="column-title">Quản lý</th>
                                <th class="bulk-actions" colspan="7">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($rooms))
                                @foreach ( $rooms as $room )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records"
                                                   value="{{$room->id}}">
                                        </td>
                                        <td class="td-content">{{$room->room_number}}</td>
                                        <td class="td-content">{{$room->name}}</td>
                                        <td class="td-content">
                                            <p>{{$room->roomType->name}}</p>
                                        </td>
                                        <td class="td-content">
                                            <p>{{$room->price}}</p>
                                        </td>
                                        <td class="td-content">
                                            <?php
                                            if ($room->confirm_action == 'add') {
                                                $labelAction = 'primary';
                                            } elseif ($room->confirm_action == 'update') {
                                                $labelAction = 'warning';
                                            } elseif ($room->confirm_action == 'delete') {
                                                $labelAction = 'danger';
                                            }
                                            ?>
                                            <button type="button" class="btn btn-<?php echo $labelAction; ?> btn-xs">
                                                <?php
                                                if ($room->confirm_action == 'add') {
                                                    echo "Thêm";
                                                } elseif ($room->confirm_action == 'update') {
                                                    echo "Sửa";
                                                } elseif ($room->confirm_action == 'delete') {
                                                    echo "Xóa";
                                                }
                                                ?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('room.confirm', $room->id)}}" class="btn btn-info btn-xs"
                                               data-toggle="tooltip" data-placement="bottom"
                                               data-original-title="Chỉnh sửa thông tin">
                                                <i class="glyphicon glyphicon-eye-open"></i> Xem
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="pointer">
                                    <td class="td-content" colspan="7">Không có dữ liệu nào</td>
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
