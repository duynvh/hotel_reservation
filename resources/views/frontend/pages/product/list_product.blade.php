@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Sản phẩm</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="active">Sản phảm</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE WITH SIDEBAR -->
        <section class="page-section with-sidebar">
            <div class="container">
                <div class="row">
                    <!-- SIDEBAR -->
                    <aside class="col-md-3 sidebar" id="sidebar">
                        @include('frontend.blocks.box.sidebar_left_product')
                    </aside>
                    <!-- /SIDEBAR -->
                    <!-- CONTENT -->
                    <div class="col-md-9 content" id="content">
                        <!-- shop-sorting -->
                        <div class="shop-sorting">
                            <div class="row">
                                <div class="col-sm-8">
                                    @include('frontend.blocks.partial.sort_product')
                                </div>
                                @if(isset($query) && $query != "")
                                    <div class="col-sm-4 text-right-sm">
                                        <span>Kết quả tìm kiếm: "{{ $query }}"</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- /shop-sorting -->

                        <!-- Products grid -->
                        <div class="row products grid">
                            @foreach($products as $key => $value)
                                <div class="col-md-4 col-sm-6">
                                    <div class="thumbnail no-border no-padding align-img-center product-item-{{ $value->id }} {{ $value->check_item === "active"?"true":"false" }}">
                                        <div class="media thumbnail-img img-center">
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
                                                <span class="icon-view">
                                                        <strong><i class="fa fa-eye"></i></strong>
                                                    </span>
                                            </a>
                                        </div>
                                        <div class="caption text-center">
                                            <a href="{{ url('/san-pham/'.$value->slug.'-'.$value->id.'.html') }}">
                                                <p class="caption-title title-product-60 title-product-3-line">{{ $value->name }}</p>
                                            </a>
                                            <div class="price">
                                                <ins>{{ number_format($value->price)  }} đ</ins>
                                                @if($value->price !== $value->price_old)
                                                    <del>{{ number_format($value->price_old)  }} đ</del>
                                                @endif
                                            </div>
                                            <div class="buttons">
                                                <a class="btn btn-theme btn-theme-transparent btn-wish-list btn-add-wishlist"
                                                   href="#"><i
                                                            class="fa fa-heart"></i></a>
                                                <a class="btn btn-theme btn-theme-transparent btn-icon-left btn-add-cart {{ $value->id }}"
                                                   href="#"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- /Products grid -->

                        <div class="pagination-wrapper">
                            <div class="div-pagination">
                                {{ $products->appends(request()->except('page'))->links() }}
                            </div>
                        </div>

                    </div>
                    <!-- /CONTENT -->

                </div>
            </div>
        </section>
        @include('frontend.blocks.box.feture')
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
@stop
@section('js_content')
    <script>
        $(document).ready(function () {
            var baseURL = window.location.origin;
            $('.btn-add-cart').click(function () {
                // get id, checkItem product
                var stringId = $(this).attr('class').split(' ');
                var id = stringId[stringId.length - 1];
                var checkProductString = $('.product-item-' + id).attr('class').split(' ');
                var checkProduct = checkProductString[checkProductString.length - 2];
                if (checkProduct === "false") {
                    errorMsg("Thêm vào giỏ thất bại");
                } else {
                    var url = baseURL + "/gio-hang/them-san-pham";
                    var token = jQuery("input[name='_token']").attr('value');
                    data = {
                        "_token": token,
                        "id": id,
                        "qty": 1,
                    };
                    jQuery.ajax({
                        url: url,
                        type: 'post',
                        cache: false,
                        data: data,
                        success: function (result) {
                            if (result.type === 'empty') {
                                var totalNew = parseInt(result.qty) * parseInt(result.price);
                                var totalNewText = totalNew.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + " đ";
                                var resultPriceText = result.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + " đ";
                                $('.cart-items-inner').prepend('<div class="media">' +
                                    '                                <span style="display: none">' + totalNewText + '</span>' +
                                    '                                <a class="pull-left" href="#"><img class="media-object item-image"' +
                                    '                                                                   src="' + baseURL + '/public/upload/images/product/' + result.image + '"' +
                                    '                                                                   alt="">' +
                                    '                                </a>' +
                                    '                                <p class="pull-right item-price price-product-' + id + '">' + resultPriceText + ' đ</p>' +
                                    '                                <div class="media-body">' +
                                    '                                    <h4 class="media-heading item-title"><a href="#" class="count-qty qty-name-' + id + ' ' + result.qty + '"><strong style="color: red">' + result.qty + '</strong>' +
                                    '                                            x' + ' ' + result.name + '</a></h4>' +
                                    '                                </div>' +
                                    '                            </div>');


                                var divTotal = '<div class="media div-total">' +
                                    '                            <p class="pull-right item-price total-price ' + totalNew + '">' + totalNewText + ' đ</p>' +
                                    '                            <div class="media-body">' +
                                    '                                <h4 class="media-heading item-title summary">Tổng cộng</h4>' +
                                    '                            </div>' +
                                    '                        </div>';
                                $('.btn-popup-cart').before(divTotal);
                            } else {

                                var total = $('.total-price').attr('class').split(' ');
                                total = total[total.length - 1];

                                var priceNew = parseInt(result.price);
                                var priceNewText = priceNew.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + " đ";
                                var totalNew = parseInt(total) + (parseInt(result.qty) * priceNew);
                                var totalNewText = totalNew.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + " đ";

                                var tagPTotal = $('.total-price');

                                if (result.type === 'old') {
                                    var qty_name = $('.qty-name-' + id);
                                    var qty = qty_name.attr('class').split(' ');
                                    qty = qty[qty.length - 1];
                                    var qtyNew = parseInt(qty) + parseInt(result.qty);
                                    // alert(qtyNew);
                                    // return false;

                                    qty_name.html('<strong style="color: red">' + qtyNew + '</strong> X ' + result.name + '');
                                    qty_name.removeClass().addClass('count-qty qty-name-' + id + ' ' + qtyNew);

                                    tagPTotal.removeClass().addClass('pull-right item-price total-price ' + totalNew + '');
                                    tagPTotal.text(totalNewText + ' đ');
                                } else if (result.type === 'new') {
                                    var divProductNew = '<div class="media">' +
                                        '                                <span style="display: none">' + totalNewText + '</span>' +
                                        '                                <a class="pull-left" href="#"><img class="media-object item-image"' +
                                        '                                                                   src="' + baseURL + '/public/upload/images/product/' + result.image + '"' +
                                        '                                                                   alt="">' +
                                        '                                </a>' +
                                        '                                <p class="pull-right item-price price-product-' + id + '">' + priceNewText + ' đ</p>' +
                                        '                                <div class="media-body">' +
                                        '                                    <h4 class="media-heading item-title"><a href="#" class="count-qty qty-name-' + id + ' ' + result.qty + '"><strong style="color: red">' + result.qty + '</strong>' +
                                        '                                            x' + ' ' + result.name + '</a></h4>' +
                                        '                                </div>' +
                                        '                            </div>';
                                    tagPTotal.removeClass().addClass('pull-right item-price total-price ' + totalNew + '');
                                    tagPTotal.text(totalNewText + ' đ');
                                    $('.div-total').before(divProductNew);
                                }
                            }
                            var countItem = 0;
                            $('.count-qty').each(function () {
                                var number = $(this).attr('class').split(' ');
                                number = number[number.length - 1];
                                countItem = parseInt(countItem) + parseInt(number);
                            });
                            var spanCount = $('.span-count-item');
                            spanCount.text(countItem + ' item(s)');
                            successMsg('Thêm vào giỏ hàng thành công');
                        },
                        error: function () {
                            // alert("fail");
                            errorMsg("Thêm vào giỏ thất bại");
                        }
                    });
                }
            })

        });
    </script>
@endsection