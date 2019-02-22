<div class="modal fade popup-cart" id="popup-cart" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="container">
            <div class="cart-items">
                <div class="cart-items-inner">
                    @if($productsHeader !== NULL && $dataCartHeader !== "")
                        <span style="display: none">{{ $total = 0 }}</span>
                        @foreach($dataCartHeader as $key => $value)
                            <div class="media">
                                <span style="display: none">{{ $total += $productsHeader[$key]->price * $value }}</span>
                                <a class="pull-left" href="#"><img class="media-object item-image"
                                                                   src="{{ asset('public/upload/images/product/'.$productsHeader[$key]->image) }}"
                                                                   alt="">
                                </a>
                                <p class="pull-right item-price price-product-{{$key}}">{{ number_format($productsHeader[$key]->price) }} đ</p>
                                <div class="media-body">
                                    <h4 class="media-heading item-title"><a href="#" class="count-qty qty-name-{{$key}} {{ $value }}"><strong style="color: red">{{ $value }}</strong>
                                            x {{ $productsHeader[$key]->name }}</a></h4>
                                </div>
                            </div>

                        @endforeach
                        <div class="media div-total">
                            <p class="pull-right item-price total-price {{ $total }}">{{ number_format($total) }} đ</p>
                            <div class="media-body">
                                <h4 class="media-heading item-title summary">Tổng cộng</h4>
                            </div>
                        </div>
                    @endif

                    <div class="media btn-popup-cart">
                        <div class="media-body">
                            <div>
                                <a href="#" class="btn btn-theme btn-theme-dark" data-dismiss="modal">Đóng</a><!--
                                            --><a href="{{ url('/gio-hang.html') }}"
                                                  class="btn btn-theme btn-theme-transparent btn-call-checkout">Đặt hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
