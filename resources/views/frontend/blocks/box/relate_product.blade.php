<section class="page-section">
    <div class="container">
        <h2 class="section-title section-title-lg"><span>Sản phẩm liên quan</span></h2>
        <div class="featured-products-carousel">
            <div class="owl-carousel" id="featured-products-carousel">
                @foreach($productRelated as $key => $value)
                    <div class="thumbnail no-border no-padding product-item-{{ $value->id }} {{ $value->check_item === "active"?"true":"false" }}">
                        <div class="badges label-product">
                            @if($value->new === "active")
                                <div class="hot item-hot text-center">Hot</div>
                            @endif
                            @if($value->price !== $value->price_old)
                                <div class="new item-new text-center item-sale">Sale</div>
                            @endif
                        </div>
                        <div class="media thumbnail-img">
                            <a class="media-link" data-gal="prettyPhoto"
                               href="{{ asset('public/upload/images/product/'.$value->image) }}">
                                <img src=" {{ asset('public/upload/images/product/'.$value->image) }}"
                                     alt=""/>
                                <span class="icon-view">
                                                <strong><i class="fa fa-eye"></i></strong>
                                            </span>
                            </a>
                        </div>
                        <div class="caption text-center">
                            <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                <p class="caption-title title-product-3-line title-product-60">{{ $value->name }}</p>
                            </a>
                            <div class="price">
                                <ins>{{ number_format($value->price)  }} đ</ins>
                                @if($value->price !== $value->price_old)
                                    <del>{{ number_format($value->price_old)  }} đ</del>
                                @endif
                            </div>
                            <div class="buttons">
                                <a class="btn btn-theme btn-theme-transparent btn-wish-list btn-add-wishlist" href="javascript:void(0)" onclick="addFavorite('{{ $value->id }}')"><i
                                            class="fa fa-heart"></i></a>
                                <a class="btn btn-theme btn-theme-transparent btn-icon-left btn-add-cart {{ $value->id }}" href="#"><i
                                            class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr class="page-divider half"/>
    </div>
</section>
<!-- /PAGE -->