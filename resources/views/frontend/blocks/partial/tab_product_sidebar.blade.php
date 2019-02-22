<div class="widget widget-tabs">
    <div class="widget-content">
        <ul id="tabs" class="nav nav-justified">
            <li><a href="#tab-s1" data-toggle="tab">Xem nhiều</a></li>
            <li class="active"><a href="#tab-s2" data-toggle="tab">Giảm giá</a></li>
            <li><a href="#tab-s3" data-toggle="tab">Mới</a></li>
        </ul>
        <div class="tab-content">
            <!-- tab 1 -->
            <div class="tab-pane fade" id="tab-s1">
                <div class="product-list">
                    @foreach($productViewHigher as $key => $value)
                        <div class="media">
                            <a class="pull-left media-link" href="#">
                                <div class="image-s-small-frames">
                                    <img class="media-object"
                                         src="{{ asset('public/upload/images/product/'.$value->image) }}" alt="">
                                </div>
                            </a>
                            <div class="media-body">
                                <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                    <p class="media-heading title-product-2-line">{{ $value->name }}</p>
                                </a>
                                <div class="price">
                                    <ins class="display-block">{{ number_format($value->price)  }} đ</ins>
                                    @if($value->price !== $value->price_old)
                                        <del>{{ number_format($value->price_old)  }} đ</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- tab 2 -->
            <div class="tab-pane fade in active" id="tab-s2">
                <div class="product-list">
                    @foreach($productSale as $key => $value)
                        <div class="media">
                            <a class="pull-left media-link" href="#">
                                <div class="image-s-small-frames">
                                    <img class="media-object"
                                         src="{{ asset('public/upload/images/product/'.$value->image) }}" alt="">
                                </div>
                            </a>
                            <div class="media-body">
                                <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                    <p class="media-heading title-product-2-line">{{ $value->name }}</p>
                                </a>
                                <div class="price">
                                    <ins class="display-block">{{ number_format($value->price)  }} đ</ins>
                                    @if($value->price !== $value->price_old)
                                        <del>{{ number_format($value->price_old)  }} đ</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- tab 3 -->
            <div class="tab-pane fade" id="tab-s3">
                <div class="product-list">
                    @foreach($productNew as $key => $value)
                        <div class="media">
                            <a class="pull-left media-link" href="#">
                                <div class="image-s-small-frames">
                                    <img class="media-object"
                                         src="{{ asset('public/upload/images/product/'.$value->image) }}" alt="">
                                </div>
                            </a>
                            <div class="media-body">
                                <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                    <p class="media-heading title-product-2-line">{{ $value->name }}</p>
                                </a>
                                <div class="price">
                                    <ins class="display-block">{{ number_format($value->price)  }} đ</ins>
                                    @if($value->price !== $value->price_old)
                                        <del>{{ number_format($value->price_old)  }} đ</del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>