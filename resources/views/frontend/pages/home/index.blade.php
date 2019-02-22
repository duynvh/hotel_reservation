@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        @include('frontend.blocks.box.slider')
        @include('frontend.blocks.box.banner')
        @include('frontend.blocks.box.new_product')
        <section class="page-section">
            <div class="container">
                <div class="message-box">
                    <div class="message-box-inner">
                        <h2>Sản phẩm xem nhiều tại thek-box</h2>
                    </div>
                </div>
            </div>
        </section>
        @include('frontend.blocks.box.high_view_product')
        {{--@include('frontend.blocks.box.new_post')--}}
        @include('frontend.blocks.box.brand')
        @include('frontend.blocks.box.top-seller-new')
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