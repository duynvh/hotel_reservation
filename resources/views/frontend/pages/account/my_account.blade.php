@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">
        <section class="page-section">
            <div class="wrap container">
                <div class="row">
                    <!--start main contain of page-->
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="information-title">Thông tin tài khoản</div>
                        <div class="details-wrap">
                            <div class="block-title alt"> <i class="fa fa-angle-down"></i> Thay đổi thông tin</div>
                            <div class="details-box">
                                <form class="form-delivery" action="#">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input value="{{ old('email') }}" class="form-control" type="text"
                                                       placeholder="Email" name="email">
                                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input value="{{ old('password') }}" class="form-control" type="password"
                                                   placeholder="Mật khẩu" name="password">
                                            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="col-md-6">
                                            <input value="{{ old('name') }}" class="form-control" type="text"
                                                   placeholder="Họ và tên" name="name">
                                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="col-md-6">
                                            <input value="{{ old('phone') }}" class="form-control" type="text"
                                                   placeholder="Số điện thoại" name="phone">
                                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="col-md-12">
                                            <input value="{{ old('address') }}" class="form-control" type="text"
                                                   placeholder="Địa chỉ" name="address">
                                            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <button class="btn btn-theme btn-theme-dark" type="submit"> Cập nhật </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('frontend.blocks.box.sidebar_right_acount')
                </div>

            </div>
        </section>
    </div>
@stop