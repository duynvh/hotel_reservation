<?php
if ($couponHeader !== "" && $couponHeader !== null) {
    $couponHeaderPrice = $couponHeader->amount;
    if ($couponHeader->amount_type == 'percent') {
        $couponHeaderPrice = $couponHeaderPrice / 100;
    }
} else {
    $couponHeaderPrice = 0;
}
?>
<div class="header-cart">
    <ul class="cart-items">
        @if($productsHeader !== NULL && $dataCartHeader !== "")
            <span style="display: none">{{ $total = 0 }}</span>
            <span style="display: none">{{ $count = 0 }}</span>
            @foreach($dataCartHeader as $key1 => $cartDetail)
                @foreach($cartDetail as $key2 => $value)
                    <span style="display: none">{{ $total += $productsHeader[$key1]->price * $value['qty'] }}</span>
                    <li class="single-cart-item">
                        <div class="cart-img">
                            <a href="{{ url('/gio-hang.html') }}"><img class="img-in-cart"
                                                                       src="{{ asset('public/upload/images/product/'.$productsHeader[$key1]->image) }}"
                                                                       alt="{{$productsHeader[$key1]->name}}"></a>
                            <span class="cart-sticker">{{ $value['qty'] }}</span>
                        </div>
                        <div class="cart-content">
                            <h5 class="product-name"><a
                                        href="{{ url('/san-pham/'.$productsHeader[$key1]->slug.'-'.$productsHeader[$key1]->id.'.html') }}">{{ $productsHeader[$key1]->name }}</a>
                            </h5>
                            @if($productsHeader[$key1]->price != $productsHeader[$key1]->price_old)
                                <span class="product-price">{{number_format($productsHeader[$key1]->price_old * $value['qty']) }}
                                    đ</span>
                            @else
                                <span class="product-price">{{number_format($productsHeader[$key1]->price * $value['qty']) }}
                                    đ</span>
                            @endif
                            <span class="product-size"><span>Size</span>: {{ $value['size'] }}</span>
                            <span class="product-color"><span>Color</span>: {{ $value['color'] }}</span>
                        </div>
                        {{--<div class="cart-item-remove">--}}
                        {{--<a title="Remove" href="#"><i class="fa fa-trash"></i></a>--}}
                        {{--</div>--}}
                    </li>
                @endforeach
            @endforeach
        @endif
    </ul>
    <div class="cart-total">
        @if($productsHeader !== "" && $dataCartHeader !== "")
            <h5>Tổng <span class="float-right">{{ number_format($total) }} đ</span></h5>
            @if($couponHeaderPrice<=1 && $couponHeaderPrice>=0)
                <h5>Giảm giá <span class="float-right">{{ number_format($total * $couponHeaderPrice) }} đ</span></h5>
                <h5>Thanh toán <span class="float-right">{{ number_format($total - $total * $couponHeaderPrice) }} đ</span></h5>
            @else
                <h5>Giảm giá <span class="float-right">{{ number_format($couponHeaderPrice) }} đ</span></h5>
                <h5>Thanh toán <span class="float-right">{{ number_format($total - $couponHeaderPrice) }} đ</span></h5>
            @endif
        @else
            <h5>Thanh toán <span class="float-right">0 đ</span></h5>
        @endif
    </div>
    <div class="checkout">
        <a href="{{ url('/gio-hang.html') }}">Giỏ Hàng</a>
    </div>
</div>
