@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">
        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="block-title"><span>Đăng ký tài khoản</span></h3>
                        {!! Form::open(array(
                            'id' => 'submit_form',
                            'method' => 'POST',
                            'url'=> route('taikhoan.register.post'),
                            'class' => 'create-account'
                        )) !!}
                        @if(Session::has('noticeMessage'))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-success">
                                        {{ Session::get('noticeMessage') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <input type="hidden" value="{{ csrf_token() }}"/>
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
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input value="{{ old('address') }}" class="form-control" type="text"
                                       placeholder="Địa chỉ" name="address">
                                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-block btn-theme btn-theme-dark btn-create" type="submit">Đăng
                                    ký
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
        <!-- /PAGE -->
        @include('frontend.blocks.box.feture')

    </div>
@stop