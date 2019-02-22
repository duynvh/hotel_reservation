@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Giỏ Hàng</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href=".">Trang chủ</a></li>
                    <li><a href="#">Shop</a></li>
                    <li class="active">Giỏ hàng</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">
                @if($products === NULL || $products === "")
                    <h2 class="text-center">Giỏ hàng trống</h2>
                    <hr>
                    <a href="{{ url('san-pham.html') }}"><button class="btn btn-warning center-block">Mua sắm tiếp</button></a>
                @else
                    <h3 class="block-title alt"><i class="fa fa-eye"></i>Thông tin đơn hàng</h3>
                    {!! Form::open(['method' => 'POST' ,'class' => '111' ,'url' => route('cart.update')]) !!}
                    <div class="row orders">
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Hình</th>
                                    <th>Số lượng</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Tổng</th>
                                    <th class="text-right">Xóa</th>
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
                                        <td class="quantity"><input type="number" style="width: 60px; height: 40px"
                                                                    min="0"
                                                                    value="{{ $dataCart[$value->id] }}"
                                                                    name="qty[{{ $value->id }}]">
                                        </td>
                                        <td class="description">
                                            <h4><a href="#">{{ $value->name }}</a></h4>
                                        </td>
                                        <td class="total">{{ number_format($value->price * $dataCart[$value->id]) }} đ<a
                                                    href="#"></a></td>
                                        <td class="total"><a href="#"
                                                             class="btn-remove-product {{ $value->id }} {{  $value->price * $dataCart[$value->id] }}"><i
                                                        class="fa fa-close"></i></a></td>
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
                                    <input name='coupon' class="form-control" type="text"
                                           value="{{ $coupon == NULL?"":$coupon->coupon_code }}"
                                           placeholder="Điền mã khuyến mãi"/>
                                </div>
                                <button type="submit" class="btn btn-theme btn-theme-dark btn-block">Áp dụng</button>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-theme btn-theme-dark btn-block">Cập nhật giỏ hàng
                            </button>

                        </div>
                    </div>
                {!! Form::close() !!}
                <div class="overflowed">
                    <a class="btn btn-theme btn-theme-dark" href="#">Trang chủ</a>
                    <a class="btn btn-theme pull-right" href="{{ url('/dat-hang.html') }}">Tiến hành đặt hàng</a>
                </div>
                @endif
            </div>
        </section>

        @include('frontend.blocks.box.feture')

    </div>
@stop
@section('js_content')
    <script>
        $(document).ready(function () {
            var baseURL = window.location.origin;

            $('.btn-remove-product').click(function () {
                //get id remove
                var infoInClass = $(this).attr('class');

                infoInClass = infoInClass.split(' ');

                var id = infoInClass[1];
                var amount = infoInClass[2];
                if (amount > 0) {

                    //change amount total
                    var subtotal = $('.total-bill');
                    var stringClassSub = subtotal.attr('class').split(' ');
                    var subtotalNumber = stringClassSub[2];
                    subtotalNumber -= amount;
                    var subtotalText = subtotalNumber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + " đ";
                    subtotal.removeClass().addClass("toal-cart total-bill " + subtotalNumber);
                    if (subtotalNumber <= 0) {
                        subtotal.text("0 đ");
                    } else {
                        subtotal.text(subtotalText);
                    }

                    //change amount paying
                    var paytotal = $('.paytotal');
                    var stringClassPay = paytotal.attr('class').split(' ');
                    var paytotalNumber = stringClassPay[1];
                    paytotalNumber -= amount;
                    var paytotalText = paytotalNumber.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + " đ";
                    paytotal.removeClass().addClass("paytotal " + paytotalNumber);
                    if (subtotalNumber <= 0) {
                        paytotal.text("0 đ");
                    } else {
                        paytotal.text(paytotalText);
                    }

                    // remove div by id
                    $('tr.tr-product-' + id).hide("puff", function () {
                        jQuery(this).remove();
                    });

                    var url = baseURL + "/gio-hang/xoa-san-pham";
                    var token = jQuery("input[name='_token']").attr('value');
                    data = {"_token": token, "id": id};
                    jQuery.ajax({
                        url: url,
                        type: 'post',
                        cache: false,
                        data: data,
                        success: function (result) {
                        },
                        error: function () {
                            console.log("Có lỗi xảy ra trong quá trình cập nhật");
                        }
                    });
                }
            })
        });
    </script>
@endsection