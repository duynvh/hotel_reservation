@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">
        <section class="page-section">
            <div class="wrap container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8">
                        <div class="information-title">Thay đổi mật khẩu</div>
                        <div class="details-wrap">
                            <div class="block-title alt"> <i class="fa fa-angle-down"></i> Đổi mật khẩu của bạn</div>
                            @if(Session::has('noticeMessage'))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-success">
                                            {{ Session::get('noticeMessage') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="details-box">
                                {!! Form::open(array(
                                    'method' => 'POST',
                                    'url'=> route('taikhoan.change-password.post'),
                                    'class' => 'form-delivery'
                                )) !!}
                                    <input type="hidden" value="{{ csrf_token() }}" />
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input name="password" type="password" placeholder="Mật khẩu" class="form-control">
                                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input name="password_confirmation" type="password" placeholder="Xác nhận mật khẩu" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <button class="btn btn-theme btn-theme-dark" type="submit"> Cập nhật </button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    @include('frontend.blocks.box.sidebar_right_acount')
                </div>

            </div>
        </section>
    </div>
@stop