@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">
        <section class="page-section">
            <div class="wrap container">
                <div class="row">
                    <!--start main contain of page-->
                    <div class="col-md-12">
                        <div class="information-title">Your Order History</div>
                        <div class="details-wrap">
                            <div class="details-box orders">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Qty</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Order ID</th>
                                        <th>Delivered on</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="image"><a href="#" class="media-link"><i class="fa fa-plus"></i><img
                                                        alt="" src="assets/img/preview/shop/order-1.jpg"></a></td>
                                        <td class="quantity">x3</td>
                                        <td class="description">
                                            <h4><a href="#">Standard Product Name Header Here</a></h4>
                                            by Category Name
                                        </td>
                                        <td class="total">$150</td>
                                        <td class="order-id"> OD31207</td>
                                        <td class="diliver-date"> 12th Dec'13</td>
                                        <td class="order-status"><a href="return.html"
                                                                    class="btn btn-theme btn-theme-dark">Return
                                                Order</a> <a href="#" class="btn btn-theme btn-theme-dark">Re Order</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="image"><a href="#" class="media-link"><i class="fa fa-plus"></i><img
                                                        alt="" src="assets/img/preview/shop/order-1.jpg"></a></td>
                                        <td class="quantity">x3</td>
                                        <td class="description">
                                            <h4><a href="#">Standard Product Name Header Here</a></h4>
                                            by Category Name
                                        </td>
                                        <td class="total">$250</td>
                                        <td class="order-id"> OD31207</td>
                                        <td class="diliver-date"> 12th Dec'13</td>
                                        <td class="order-status"><a href="return.html"
                                                                    class="btn btn-theme btn-theme-dark">Return
                                                Order</a> <a href="#" class="btn btn-theme btn-theme-dark">Re Order</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="image"><a href="#" class="media-link"><i class="fa fa-plus"></i><img
                                                        alt="" src="assets/img/preview/shop/order-1.jpg"></a></td>
                                        <td class="quantity">x3</td>
                                        <td class="description">
                                            <h4><a href="#">Standard Product Name Header Here</a></h4>
                                            by Category Name
                                        </td>
                                        <td class="total">$350</td>
                                        <td class="order-id"> OD31207</td>
                                        <td class="diliver-date"> 12th Dec'13</td>
                                        <td class="order-status"><span class="return-request"> You requested </br> this order for return </span>
                                            <a href="#" class="btn btn-theme btn-theme-dark">Re Order</a></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div>
                                    <a href="accountinformation.html" class="btn btn-theme"> Back To Account </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end main contain of page-->
                </div>
            </div>
        </section>
    </div>
@stop