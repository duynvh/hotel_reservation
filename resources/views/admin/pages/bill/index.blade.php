@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Đơn hàng </h3>
    </div>
@endsection

@section('content')
    @include('admin.layouts.partial.button', array(
        'router_add' => route('bill.create'),
        'total_active' => '',
        'total_inactive' => '',
        'router_status' => route('bill.status'),
        'router_delete' => route('coupon.delete')
    ))

    @include('admin.layouts.partial.filter', array(
        'status' => array(
          'all' => 'Lọc theo loại',
            'process' => 'Đang xử lí',
            'success' => 'Đã giao',
            'cancel' => 'Hủy'
        ),
        'action' => route('bill.index')
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
                                <th class="column-title">Tên khách hàng</th>
                                <th class="column-title">Thông tin khách hàng</th>
                                <th class="column-title">Tổng tiền</th>
                                <th class="column-title">Thời gian</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="column-title">Quản lý</th>
                                <th class="bulk-actions" colspan="8">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($bills))
                                @foreach ( $bills as $bill )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records"
                                                   value="{{$bill->id}}">
                                        </td>
                                        <td class="a-center td-content">
                                            <p>{{$bill->full_name}}</p>
                                        </td>
                                        <td class="td-content">
                                            <p><b>SĐT: </b>{{$bill->phone}}</p>
                                            <p><b>Email: </b>{{$bill->email}}</p>
                                            <p><b>Địa chỉ: </b>{{$bill->address}}</p>
                                        </td>
                                        <td style="font-size: 14px; font-weight: 900; color: #e22222"  class="td-content">
                                            <p>{{ number_format($bill->amount) }} đ</p>
                                        </td>
                                        <td class="td-content">
                                            <p>{{date('H:i:s  - d/m/Y', strtotime($bill->created_at))}} </p>
                                        </td>
                                        <td class="td-content">
                                            <?php
                                            if ($bill->status == 'process') {
                                                $labelStatus = 'warning';
                                                $valueView = "Đang xử lí";
                                            } elseif ($bill->status == 'success') {
                                                $labelStatus = 'success';
                                                $valueView = "Đã giao";
                                            } elseif ($bill->status == 'cancel') {
                                                $labelStatus = 'danger';
                                                $valueView = "Hủy";
                                            }
                                            ?>
                                            <?php $toStatus = ($bill->status == 'active') ? 'to-inactive' : 'to-active'; ?>
                                            <button type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo $valueView ?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('bill.edit', $bill->id)}}" class="btn btn-info btn-xs"
                                               data-toggle="tooltip" data-placement="bottom"
                                               data-original-title="Chỉnh sửa thông tin">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="pointer">
                                    <td class="td-content" colspan="8">Không có dữ liệu nào</td>
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