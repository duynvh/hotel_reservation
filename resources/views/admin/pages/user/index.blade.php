@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Người dùng </h3>
    </div>
    @include('admin.blocks.notify.notify_notice')
@endsection

@section('content')
    @include('admin.layouts.partial.button', array(
        'router_add' => route('user.create'),
        'total_active' => '',
        'total_inactive' => '',
        'router_status' => route('user.status'),
        'router_delete' => route('user.delete'),
        'router_confirm' => route('user.indexConfirm')
    ))

    @include('admin.layouts.partial.filter', array(
        'status' => array(
            'all' => 'Lọc theo tình trạng',
            'inactive' => 'Không hoạt động',
            'active' => 'Hoạt động'
        ),
        'group'  => $groups,
        'action' => route('user.index')
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
                                <th class="column-title">Tên người dùng</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Nhóm quyền</th>
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
                            @if(!empty($users))
                                @foreach ( $users as $user )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records"
                                                   value="{{$user->id}}">
                                        </td>
                                        <td class="td-content">{{$user->name}}</td>
                                        <td class="td-content">
                                            <p>{{$user->email}}</p>
                                        </td>
                                        <td class="td-content">
                                            <p>{{$user->group->name}}</p>
                                        </td>
                                        <td class="td-content">
                                            <?php $labelStatus = ($user->status == 'active') ? 'success' : 'danger'; ?>
                                            <?php $toStatus = ($user->status == 'active') ? 'to-inactive' : 'to-active'; ?>
                                            <button onclick="changeStatusByIds('{{$user->id}}', '{{$toStatus}}')"
                                                    type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo ($user->status == 'active') ? "Kích hoạt" : "Không kích hoạt";?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            @if($user->email !== 'admin@gmail.com')
                                                <a href="{{route('user.edit', $user->id)}}" class="btn btn-info btn-xs"
                                                   data-toggle="tooltip" data-placement="bottom"
                                                   data-original-title="Chỉnh sửa thông tin">
                                                    <i class="fa fa-pencil"></i> Sửa
                                                </a>
                                                <a href="javascript:deleteByIds('{{$user->id}}')"
                                                   class="btn btn-danger btn-xs" data-toggle="tooltip"
                                                   data-placement="bottom" data-original-title="Xóa phần tử">
                                                    <i class="fa fa-trash-o"></i> Xoá
                                                </a>
                                            @endif
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