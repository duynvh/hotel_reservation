@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Đặt hàng</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản Phẩm</a></li>
                    <li class="active">Đặt hàng</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">
                <h3 class="block-title alt"><i class="fa fa-info"></i>Thông tin đơn hàng</h3>
                <div class="row orders">
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Hình</th>
                                <th>Số lượng</th>
                                <th>Tên sản phẩm</th>
                                <th>Tổng</th>
                            </tr>
                            </thead>
                            <tbody>
                            <span style="display: none">{{ $total = 0 }}</span>
                            @foreach($products as $key => $value)
                                <span style="display: none">{{ $total += $value->price * $dataCart[$value->id] }}</span>
                                <tr class="tr-product-{{ $value->id }}">
                                    <td class="image">
                                        <div class="div-img-cart"><a class="media-link" href="#">
                                                <img src=" {{ asset('public/upload/images/product/'.$value->image) }}"
                                                     alt=""/></a>
                                        </div>
                                    </td>
                                    <td class="quantity">x{{ $dataCart[$value->id] }}</td>
                                    <td class="description">
                                        <h4><a href="#">{{ $value->name }}</a></h4>
                                    </td>
                                    <td class="total">{{ number_format($value->price * $dataCart[$value->id]) }} đ<a
                                                href="#"></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h3 class="block-title"><span>Tổng đơn hàng</span></h3>
                        <div class="shopping-cart">
                            <table>
                                <tr>
                                    <td>Tổng giá trị:</td>
                                    <td class="toal-cart total-bill {{$total}}">{{ number_format($total) }} đ</td>
                                </tr>
                                <tr>
                                    <td>Giảm giá:</td>
                                    @if($coupon !== NULL)
                                        @if($coupon->amount_type == 'amount')
                                            <td>{{ number_format($coupon->amount) }} đ</td>
                                        @else
                                            <td>{{ number_format($total*$coupon->amount/100) }} đ</td>
                                        @endif
                                    @else
                                        <td>0 đ</td>
                                    @endif
                                </tr>
                                <tfoot>
                                <tr>
                                    <td>Tổng cộng:</td>
                                    @if($coupon !== NULL)
                                        @if($coupon->amount_type == 'amount')
                                            <td class="paytotal {{ $total - session('coupon')->amount }}">{{ number_format($total - $coupon->amount) }}
                                                đ
                                            </td>
                                        @else
                                            <td class="paytotal {{ $total - ($total*session('coupon')->amount/100) }}">{{ number_format($total - ($total*$coupon->amount/100)) }}
                                                đ
                                            </td>
                                        @endif
                                    @else
                                        <td class="paytotal {{ $total }}">{{ number_format($total) }} đ</td>
                                    @endif
                                </tr>
                                </tfoot>
                            </table>
                            <div class="form-group">
                                <p>*Đơn hàng chưa bao gồm phí vận chuyển</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="block-title alt"><i class="fa fa-user"></i>Thông tin khách hàng</h3>
                {!! Form::open(['method' => 'POST' ,'class' => '111','id' => 'form-info','url' => route('cart.paying')]) !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group"><input class="form-control" name="full_name" type="text" value="{{ Auth::guard('customer')->user()->name }}" placeholder="Họ và tên">
                            {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><input class="form-control" name="phone" type="text" value="{{ Auth::guard('customer')->user()->phone }}" placeholder="Số điện thoại">
                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"><input class="form-control" name="email" type="email" value="{{ Auth::guard('customer')->user()->email }}" placeholder="Email">
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group"><input class="form-control" name="address" value="{{ Auth::guard('customer')->user()->address }}" type="text"
                                                       placeholder="Địa chỉ nhận hàng"></div>
                        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="col-md-12">
                        <div class="form-group"><textarea class="form-control" placeholder="Ghi chú thêm"
                                                          name="name" id="id" cols="30" rows="10">{{ old('note') }}</textarea></div>
                    </div>
                </div>
                <div class="">
                    <a class="btn btn-theme btn-theme-dark" href="#"><i class="fa fa-toggle-left"></i> Kiểm tra lại</a>
                    {{--<a class="btn btn-theme pull-right" href="#"><i class="fa fa-check"></i> Xác nhận đặt</a>--}}
                    <button type="submit" id="btn-submit-bill" class="btn btn-theme pull-right">Xác nhận đặt</button>
                </div>
                {!! Form::close() !!}
            </div>
        </section>
        <!-- /PAGE -->

        <!-- PAGE -->
        <section class="page-section">
            <div class="container">
                <div class="row blocks shop-info-banners">
                    <div class="col-md-4">
                        <div class="block">
                            <div class="media">
                                <div class="pull-right"><i class="fa fa-gift"></i></div>
                                <div class="media-body">
                                    <h4 class="media-heading">Buy 1 Get 1</h4>
                                    Proin dictum elementum velit. Fusce euismod consequat ante.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block">
                            <div class="media">
                                <div class="pull-right"><i class="fa fa-comments"></i></div>
                                <div class="media-body">
                                    <h4 class="media-heading">Call to Free</h4>
                                    Proin dictum elementum velit. Fusce euismod consequat ante.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block">
                            <div class="media">
                                <div class="pull-right"><i class="fa fa-trophy"></i></div>
                                <div class="media-body">
                                    <h4 class="media-heading">Money Back!</h4>
                                    Proin dictum elementum velit. Fusce euismod consequat ante.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /PAGE -->

    </div>
@stop
@section('js_content')
    <script>
        $(document).ready(function () {
            // $('#btn-submit-bill').click(function () {
            //     $('#form-info').submit();
            // })
        });
    </script>
@endsection