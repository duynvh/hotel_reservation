@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-user"></i> Khuyến mãi </h3>
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
        'amountType' => array(
            'all' => 'Lọc theo loại',
            'percent' => 'Theo phần trăm',
            'amount' => 'Theo giá trị'
        ),
        'action' => route('coupon.indexConfirm')
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
                                <th class="column-title">Mã khuyến mãi</th>
                                <th class="column-title">Giá trị</th>
                                <th class="column-title">Loại</th>
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
                            @if(!empty($coupons))
                                @foreach ( $coupons as $coupon )
                                    <tr class="pointer">
                                        <td class="a-center td-content">
                                            <input type="checkbox" class="flat" name="table_records"
                                                   value="{{$coupon->id}}">
                                        </td>
                                        <td class="td-content">{{$coupon->coupon_code}}</td>
                                        <td class="td-content">
                                            <p>{{$coupon->amount}}</p>
                                        </td>
                                        <td class="td-content">
                                            <?php $labelStatus = ($coupon->amount_type == 'percent') ? 'success' : 'danger'; ?>
                                            <button type="button" class="btn btn-<?php echo $labelStatus; ?> btn-xs">
                                                <?php echo ($coupon->amount_type == 'percent') ? "Phần trăm" : "Tiền mặt";?>
                                            </button>
                                        </td>
                                        <td class="td-content">
                                            <p>{{date("d-m-Y", strtotime($coupon->start_date))}}
                                                - {{date("d-m-Y", strtotime($coupon->end_date))}}</p>
                                        </td>
                                        <td class="td-content">
                                            <?php
                                            if ($coupon->confirm_action == 'add') {
                                                $labelAction = 'primary';
                                            } elseif ($coupon->confirm_action == 'update') {
                                                $labelAction = 'warning';
                                            } elseif ($coupon->confirm_action == 'delete') {
                                                $labelAction = 'danger';
                                            }
                                            ?>
                                            <button type="button" class="btn btn-<?php echo $labelAction; ?> btn-xs">
                                                <?php
                                                if ($coupon->confirm_action == 'add') {
                                                    echo "Thêm";
                                                } elseif ($coupon->confirm_action == 'update') {
                                                    echo "Sửa";
                                                } elseif ($coupon->confirm_action == 'delete') {
                                                    echo "Xóa";
                                                }
                                                ?>
                                            </button>
                                        </td>
                                        <td class="td-content" role="gridcell" aria-describedby="jqgrid_act">
                                            <a href="{{route('coupon.confirm', $coupon->id)}}" class="btn btn-info btn-xs"
                                               data-toggle="tooltip" data-placement="bottom"
                                               data-original-title="Chỉnh sửa thông tin">
                                                <i class="glyphicon glyphicon-eye-open"></i> Xem
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