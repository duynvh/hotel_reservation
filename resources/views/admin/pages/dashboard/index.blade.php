@extends('admin.admin_master')

@section('content')
    <div class="row">
        <div class="dashboard-count col-md-3 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="count_top"><i class="fa fa-user"></i> Danh mục sản phẩm </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="count-number green">{{ number_format($data['totalCategoryProduct']) }}</div>
                    <small>Tổng số danh mục sản phẩm</small>
                    <a href="{{ route('product.index') }}" class="pull-right">Chi tiết</a>
                </div>
            </div>
        </div>
        <div class="dashboard-count col-md-3 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="count_top"><i class="fa fa-user"></i> Sản phẩm </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="count-number green">{{ number_format($data['totalProduct']) }}</div>
                    <small>Tổng số sản phẩm</small>
                    <a href="{{ route('product.index') }}" class="pull-right">Chi tiết</a>
                </div>
            </div>
        </div>
        {{--<div class="dashboard-count col-md-3 col-sm-4 col-xs-12">--}}
            {{--<div class="x_panel">--}}
                {{--<div class="x_title">--}}
                    {{--<h2 class="count_top"><i class="fa fa-user"></i> Người dùng </h2>--}}
                    {{--<div class="clearfix"></div>--}}
                {{--</div>--}}
                {{--<div class="x_content">--}}
                    {{--<div class="count-number green">{{ number_format($data['totalUser']) }}</div>--}}
                    {{--<small>Tổng số người dùng</small>--}}
                    {{--<a href="{{ route('user.index') }}" class="pull-right">Chi tiết</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="dashboard-count col-md-3 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="count_top"><i class="fa fa-user"></i> Hộp thư liên hệ </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="count-number green">{{ number_format($data['totalMailbox']) }}</div>
                    <small>Tổng số thư liên hệ</small>
                    <a href="{{ route('mailbox.index') }}" class="pull-right">Chi tiết</a>
                </div>
            </div>
        </div>
    </div>
    {{--List--}}
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh sách - Các đơn hàng được đặt vào hôm nay</h2>
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
                                <th class="column-title">Họ và tên khách hàng</th>
                                <th class="column-title">Thông tin khách </th>
                                <th class="column-title">Tổng tiền</th>
                                <th class="column-title">Thời gian</th>
                                <th class="column-title">Tình trạng</th>
                                <th class="column-title">Quản lý</th>
                                <th class="bulk-actions" colspan="6">
                                    <a class="antoo" style="color:#fff; font-weight:500;">
                                        Tổng số ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                                    </a>
                                </th>
                            </tr>
                            </thead>

                            @if(!empty($data['billToday']) && count($data['billToday']) > 0)
                                @foreach ( $data['billToday'] as $bill)
                                    <tr>
                                        <td class="a-center td-content">
                                            <p>{{$bill->full_name}}</p>
                                        </td>
                                        <td class="td-content">
                                            <p><b>SĐT: </b>{{$bill->phone}}</p>
                                            <p><b>Email: </b>{{$bill->email}}</p>
                                            <p><b>Địa chỉ: </b>{{$bill->address}}</p>
                                        </td>
                                        <td style="font-size: 14px; font-weight: 900; color: #e22222" class="td-content">
                                            <p>{{ number_format($bill->amount) }} đ</p>
                                        </td>
                                        <td class="td-content">
                                            <p>{{date('H:i:s  - d/m/Y', strtotime($bill->created_at))}} </p>
                                        </td>
                                        <td class="td-content">
                                            <?php
                                            if ($bill->status == 'receive') {
                                                $labelStatus = 'primary';
                                                $valueView = "Đã nhận";
                                            } elseif ($bill->status == 'process') {
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
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tbody>
                                <tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Không có đơn hàng được đặt vào hôm nay</td></tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! $data['chart']->html() !!}
        </div>
    </div>
@endsection
@section('js_content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    {!! $data['chart']->script() !!}
@endsection