@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="page-title">
        <div class="title_left">
            <h3>Chỉnh sửa đơn hàng</h3>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'PUT',
            'url'=> route('bill.update', $data->id)
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Thông tin khách hàng</label>
                            <div class="col-md-10" style="padding-top: 8px">
                                <div class="row">
                                    <div class="col-md-2"><p>Họ tên:</p></div>
                                    <div class="col-md-10"><strong>{{ $data->full_name }}</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><p>Điện thoại:</p></div>
                                    <div class="col-md-10"><strong>{{ $data->phone }}</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><p>Email:</p></div>
                                    <div class="col-md-10"><strong>{{ $data->email }}</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><p>Địa chỉ:</p></div>
                                    <div class="col-md-10"><strong>{{ $data->address }}</strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><p>Tiền khuyến mãi:</p></div>
                                    <div class="col-md-10"><strong>{{ number_format($data->price_sale) }} đ</strong>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tình trạng đơn hàng</label>
                            <div class="col-md-2" style="padding-top: 1px">
                                <select id="status" name="status"
                                        class='select2 form-control'>
                                    <option {{ $data->status == 'process'?'selected':'' }} value="process">Đang xử lí
                                    </option>
                                    <option {{ $data->status == 'success'?'selected':'' }} value="success">Đã giao
                                    </option>
                                    <option {{ $data->status == 'cancel'?'selected':'' }} value="cancel">Hủy</option>
                                </select>

                            </div>
                        </div>
                        <div class="clearfix"></div>


                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('admin.blocks.box.submit')
            </div>
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Hình Ảnh</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th class="text-center">Số Lượng</th>
                                    <th class="text-right">Giá cũ</th>
                                    <th class="text-right">Giá khuyến mãi</th>
                                    <th class="text-right">Tổng Đơn giá</th>
                                </tr>
                                </thead>
                                <tbody>
                                <span style="display: none">{{ $stt = 0 }}</span>
                                <span style="display: none">{{ $total = 0 }}</span>
                                @foreach($dataDetail as $key => $value)
                                    <span style="display: none">{{ $total+= $value->qty *$value->price  }}</span>
                                    <tr>
                                        <td class="text-center">{{ ++$stt }}</td>
                                        <td class="text-center"><img
                                                    src="{{ asset('/public/upload/images/product/75x50/'.$value->product->image) }}"
                                                    alt=""></td>
                                        <td>{{ $value->product->name }}</td>
                                        <td class="text-center">{{ $value->qty }}</td>
                                        <td class="text-right">{{ number_format($value->product->price_old) }} đ</td>
                                        <td class="text-right">{{ number_format($value->price) }}</td>
                                        <td class="text-right">{{ number_format($value->qty *$value->price)  }} đ</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-6 text-right"><p
                                                        style="font-size: 18px;font-weight: 600">Tổng tạm
                                                    tính:</p></div>
                                            <div class="col-md-6 text-right"><strong
                                                        style="font-size: 18px">{{ number_format($total) }} đ</strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-right"><p
                                                        style="font-size: 18px; font-weight: 600">Giá khuyến
                                                    mãi:</p></div>
                                            <div class="col-md-6 text-right"><strong
                                                        style="font-size: 18px">{{ number_format($data->price_sale) }}
                                                    đ</strong></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-right"><p
                                                        style="font-size: 18px;font-weight: 600; color: red">Tổng
                                                    cộng:</p></div>
                                            <div class="col-md-6 text-right"><strong
                                                        style="font-size: 18px; color: red">{{ $total - $data->price_sale < 0 ? 0:number_format($total - $data->price_sale) }}
                                                    đ</strong></div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection

@section('js_content')
    <script>
        $(document).ready(function () {
            $('#start_date').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_2",
                minDate: 0,
                locale: {
                    format: 'YYYY-MM-DD'
                },
            }, function (start, end, label) {
            });

            $('#end_date').daterangepicker({
                singleDatePicker: true,
                singleClasses: "picker_2",
                minDate: 0,
                locale: {
                    format: 'YYYY-MM-DD'
                },
            }, function (start, end, label) {
            });
        });
    </script>
@endsection
