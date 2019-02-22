@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Danh sách yêu thích</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ url('/san-pham.html') }}">Sản phẩm</a></li>
                    <li class="active">Danh sách yêu thích</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE -->
        <section class="page-section color no-padding-bottom">
            <div class="container">

                <div class="row wishlist" id="list-product">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá tiền</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="table-wishlist-product">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- /PAGE -->

        <!-- PAGE -->
    @include('frontend.blocks.box.feture')
    <!-- /PAGE -->

    </div>
    <script id="templateHtml" type="text/x-handlebars-template">
        <tr>
            <td class="image">
                <div class="thumbnail-img-small">
                    <a class="media-link" href="{link}"><img  src="{image}" alt="{name}"/></a>
                </div>
            </td>
            <td class="description">
                <h4><a href="{link}">{name}</a></h4>
            </td>
            <td class="price">{price} VNĐ</td>
            <td class="total"><a href="javascript:void(0)" onclick="removeWishlistProduct('{id}')"><i
                            class="fa fa-close"></i></a></td>
        </tr>
    </script>
@endsection

@section('js_customer')
    <script>
        Number.prototype.format = function (n, x, s, c) {
            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = this.toFixed(Math.max(0, ~~n));
            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
        };

        $(document).ready(function () {
            var obj = [];
            objProductFavorite = JSON.parse(localStorage.getItem("favoriteProduct"));
            console.log(objProductFavorite.length);
            if (objProductFavorite.length === 0) {
                $('#list-product').empty();
                $('#list-product').append(`<h1 class="text-center" style="margin-bottom: 50px;">Vẫn chưa có sản phẩm yêu thích nào</h1>`);
                return false;
            }
            else {
                objProductFavorite.map((item) => {
                    obj.push(item.id);
                });

                $.ajax({
                    type: "POST",
                    url: "<?php echo route('get-wishlist-product');?>",
                    headers: {'X-CSRF-TOKEN': token},
                    data: {
                        ids: obj
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.data.length !== 0) {
                            $.each(response.data, (index, value) => {
                                let htmlMore = $(templateHtml).html();
                                let image = "public/upload/images/product/" + value.image;
                                let link = '/san-pham/' + value.slug + '-' + value.id + '.html';
                                let price = parseInt(value.price).format();
                                htmlMore = htmlMore.replace(/{id}/g, value.id);
                                htmlMore = htmlMore.replace(/{name}/g, value.name);
                                htmlMore = htmlMore.replace(/{price}/g, price);
                                htmlMore = htmlMore.replace(/{image}/g, image);
                                htmlMore = htmlMore.replace(/{link}/g, link);
                                $('#table-wishlist-product').append(htmlMore);
                            });
                        }
                    }
                });
            }
        });
    </script>
@endsection
