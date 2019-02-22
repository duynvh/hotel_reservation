<!-- PAGE -->
<section class="page-section">
    <div class="container">
        <h2 class="section-title"><span>Sản phẩm mới</span></h2>
        <div class="top-products-carousel">
            <div class="owl-carousel" id="top-products-carousel">
                @foreach($productNew as $key => $value)
                    <div class="thumbnail no-border no-padding align-img-center product-item-{{ $value->id }} {{ $value->check_item === "active"?"true":"false" }}">
                        <div class="media thumbnail-img-small img-center">
                            <div class="badges label-product">
                                @if($value->new === "active")
                                    <div class="hot item-hot text-center">Hot</div>
                                @endif
                                @if($value->price !== $value->price_old)
                                    <div class="new item-new text-center item-sale">Sale</div>
                                @endif
                            </div>
                            <a class="media-link" data-gal="prettyPhoto"
                               href="{{ asset('public/upload/images/product/'.$value->image) }}">
                                <img src="{{ asset('public/upload/images/product/'.$value->image) }}"
                                     alt=""/>
                                <span class="icon-view"><strong><i class="fa fa-eye"></i></strong></span>
                            </a>
                        </div>
                        <div class="caption text-center">
                            <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                <p class="caption-title title-product-60 title-product-3-line">{{ $value->name  }}</p>
                            </a>
                            <div class="price">
                                <ins class="display-block">{{ number_format($value->price)  }} đ</ins>
                                @if($value->price !== $value->price_old)
                                    <del>{{ number_format($value->price_old)  }} đ</del>
                                @endif
                            </div>
                            <div class="buttons">
                                <a class="btn btn-theme btn-theme-transparent btn-wish-list btn-add-wishlist"
                                   href="javascript:void(0)" onclick="addFavorite('{{ $value->id }}')"><i
                                            class="fa fa-heart"></i></a><!--
                                            --><a
                                        class="btn btn-theme btn-theme-transparent btn-add-cart {{ $value->id }}"
                                        href="#">Thêm vào giỏ</a><!--
                                            -->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /PAGE -->