@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Người dùng </h3>
    </div>
    @include('admin.blocks.notify.notify_notice')
@endsection

@section('content')
    @include('admin.layouts.partial.filter', array(
        'status' => array(
            'all' => 'Lọc theo tình trạng',
            'inactive' => 'Không hoạt động',
            'active' => 'Hoạt động'
        ),
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
                                <th class="column-title">Điện thoại</th>
                                <th class="column-title">Email</th>
                                <th class="column-title">Địa chỉ</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="bulk-actions" colspan="6">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($customers))
                                @foreach ( $customers as $customer )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records"
                                                   value="{{$customer->id}}">
                                        </td>
                                        <td class="td-content">{{$customer->name}}</td>
                                        <td class="td-content">{{$customer->phone}}</td>
                                        <td class="td-content">
                                            <p>{{$customer->email}}</p>
                                        </td>
                                        <td class="td-content">{{$customer->address}}</td>
                                        <td class="td-content">
                                            <?php $labelStatus = ($customer->status == 'active') ? 'success' : 'danger'; ?>
                                            <?php $toStatus = ($customer->status == 'active') ? 'to-inactive' : 'to-active'; ?>
                                            <button onclick="changeStatusByIds('{{$customer->id}}', '{{$toStatus}}')"
                                                    type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo ($customer->status == 'active') ? "Kích hoạt" : "Không kích hoạt";?>
                                            </button>
                                        </td>
                                        {{--<td class="td-content" role="gridcell" aria-describedby="jqgrid_act">--}}
                                            {{--@if($customer->email !== 'admin@gmail.com')--}}
                                                {{--<a href="{{route('customer.edit', $customer->id)}}" class="btn btn-info btn-xs"--}}
                                                       {{--data-toggle="tooltip" data-placement="bottom"--}}
                                                   {{--data-original-title="Chỉnh sửa thông tin">--}}
                                                    {{--<i class="fa fa-pencil"></i> Sửa--}}
                                                {{--</a>--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
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