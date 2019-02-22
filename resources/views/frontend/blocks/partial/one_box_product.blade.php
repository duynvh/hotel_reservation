@foreach($productList as $key => $value)
    <div class="col-md-12">
        <!--Single Product Start-->
        <div class="single-product">
            <div class="product-img H200">
                <a  href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                    <img class="first-img H200" src="{{ asset('public/upload/images/product/'.$value->image)}}"
                         alt="{{ $value->name }}">
                    <img class="hover-img H200" src="{{ asset('public/upload/images/product/'.$value->image)}}"
                         alt="{{ $value->name }}">
                </a>
                <span class="sticker">Mới</span>
                @if($value->price != $value->price_old)
                    <span class="sticker sticker_sale">Giảm giá</span>
                @endif
                <div class="product-action">
                    <ul>
                        <li><a href="javascript:void(0)"
                               onclick="copyToClipboard('{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}')"><i
                                        class="ion-ios-copy-outline"></i></a></li>
                        <li><a href="javascript:void(0)" onclick="addFavorite('{{ $value->id }}')"><i
                                        class="icon ion-ios-heart"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="product-content">
                <h4><a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">{{ $value->name }}</a></h4>
                <div class="product-price">
                    @if($value->price != $value->price_old)
                        <span class="regular-price">{{ $value->price_old }} đ</span>
                    @endif
                    <span class="price">{{ number_format($value->price) }} đ</span>
                </div>
            </div>
        </div>
        <!--Single Product End-->
    </div>

@endforeach
