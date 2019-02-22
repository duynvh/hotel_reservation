@extends('frontend.frontend_master')
@section('contents')

    <div class="error-404-area mt-40">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="error-wrapper text-center">
                        <div class="error-text">
                            <h1>Xin cảm ơn</h1>
                            <h2>Quý Khách Đã Đặt Hàng Thành Công</h2>
                            <p>Chúng tôi sẽ kiểm tra và liên hệ sớm nhất có thể.</p>
                        </div>
                        <a href="{{ url('/san-pham.html') }}"><button class="btn btn-warning center-block">Mua sắm tiếp</button></a>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection