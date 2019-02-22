@extends('frontend.frontend_master')
@section('contents')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h1 class="breadmome-name">Kết quả của từ khóa: "{{ $query }}"</h1>
                        <ul>
                            <li><a href=".">Trang chủ</a></li>
                            <li class="active">Sản Phẩm</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop-area mt-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop-layout">
                        <!--Grid & List View Start-->
                        <div class="shop-topbar-wrapper mb-30 d-md-flex justify-content-md-between align-items-center">
                            <div class="grid-list-option">
                            </div>
                            <!--Toolbar Short Area Start-->
                            <div class="toolbar-short-area d-md-flex align-items-center">
                                @include('frontend.blocks.partial.sort_product')
                            </div>
                            <!--Toolbar Short Area End-->
                        </div>
                        <!--Grid & List View End-->
                        <!--Shop Product Start-->
                        <div class="shop-product">
                            <div id="myTabContent-2" class="tab-content">
                                <div id="grid" class="tab-pane fade show active">
                                    <div class="product-grid-view">
                                        <div class="row">
                                            @foreach($products as $key => $value)
                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <!--Single Product Start-->
                                                    <div class="single-product mb-30">
                                                        <div class="product-img H200">
                                                            <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                                                <img class="first-img H200"
                                                                     src="{{ asset('public/upload/images/product/'.$value->image)}}"
                                                                     alt="">
                                                                <img class="hover-img H200"
                                                                     src="{{ asset('public/upload/images/product/'.$value->image)}}"
                                                                     alt="">
                                                            </a>
                                                            <span class="sticker">Mới</span>
                                                            @if($value->price != $value->price_old)
                                                                <span class="sticker sticker_sale">Giảm giá</span>
                                                            @endif
                                                            <div class="product-action">
                                                                <ul>
                                                                    <li><a href="javascript:void(0)" onclick="copyToClipboard('{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}')"><i
                                                                                    class="ion-ios-copy-outline"></i></a>
                                                                    </li>
                                                                    <li><a href="javascript:void(0)" onclick="addFavorite('{{ $value->id }}')"><i
                                                                                    class="icon ion-ios-heart"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <h4>
                                                                <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">{{ $value->name }}</a>
                                                            </h4>
                                                            <div class="product-price">
                                                                @if($value->price != $value->price_old)
                                                                    <span class="regular-price">{{ $value->price_old }}
                                                                        đ</span>
                                                                @endif
                                                                <span class="price">{{ number_format($value->price) }}
                                                                    đ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Single Product End-->
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div id="list" class="tab-pane fade">
                                    <div class="product-list-view">
                                        @foreach($products as $key => $value)
                                            <div class="product-list-item mb-40">
                                                <div class="row">
                                                    <!--Single List Product Start-->
                                                    <div class="col-md-4">
                                                        <div class="single-product">
                                                            <div class="product-img H200">
                                                                <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                                                    <img class="first-img H200"
                                                                         src="{{ asset('public/frontend/img/product/product6.jpg') }}"
                                                                         alt="{{ $value->name }}">
                                                                    <img class="hover-img H200"
                                                                         src="{{ asset('public/frontend/img/product/product7.jpg') }}"
                                                                         alt="{{ $value->name }}">
                                                                </a>
                                                                <span class="sticker">Mới</span>
                                                                @if($value->price != $value->price_old)
                                                                    <span class="sticker sticker_sale">Giảm giá</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="product-content shop-list">
                                                            <h4>
                                                                <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">Adams
                                                                    Men's Dunbar</a></h4>
                                                            <div class="product-price">
                                                                @if($value->price != $value->price_old)
                                                                    <span class="regular-price">{{ $value->price_old }}
                                                                        đ</span>
                                                                @endif
                                                                <span class="price">{{ number_format($value->price) }}
                                                                    đ</span>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>{{ $value->description }} Giày cao gót, giày công sở
                                                                    giá cực kỳ rẻ 249k👍👍 nhưng chất lượng không hề
                                                                    rẻ👍👍. Gót trụ 7 phân, da bóng, lót mềm, đi rất êm
                                                                    chân.
                                                                    54564</p>
                                                            </div>
                                                            <div class="product-list-action">
                                                                <ul>
                                                                    <li><a class="pro-add-btn" href="#"><i
                                                                                    class="ion-bag"></i>Add to cart</a>
                                                                    </li>
                                                                    <li><a href="#open-modal" data-toggle="modal"><i
                                                                                    class="ion-eye"></i></a></li>
                                                                    <li><a href="#"><i class="ion-ios-copy-outline"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Single List Product End-->
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!--Pagination Start-->
                                <div class="pagination-product d-md-flex justify-content-md-center align-items-center">
                                    <div>
                                        {{ $products->appends(request()->except('page'))->links() }}
                                    </div>
                                </div>
                                <!--Pagination End-->
                            </div>
                        </div>
                        <!--Shop Product End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop