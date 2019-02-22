@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="block-title"><span>Đăng nhập</span></h3>
                        {!! Form::open(array(
                            'id' => 'submit_form',
                            'method' => 'POST',
                            'url'=> route('taikhoan.login.post'),
                            'class' => 'create-account'
                        )) !!}
                        @if ($errors->any() && $errors->first('login_fail'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            <input type="hidden" value="{{ csrf_token() }}" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input value="{{ old('phone') }}" class="form-control" type="text" placeholder="Số điện thoại" name="phone">
                                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input value="{{ old('password') }}" class="form-control" type="password" placeholder="Mật khẩu" name="password">
                                    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-block btn-theme btn-theme-dark btn-create" type="submit">Đăng nhập</button>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-block btn-theme btn-theme-dark btn-create" href="/dang-ky.html">Đăng ký</a>
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