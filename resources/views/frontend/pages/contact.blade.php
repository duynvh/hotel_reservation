@extends('frontend.frontend_master')
@section('contents')
    {{--<div class="contact-us-area mt-80">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-lg-3 col-md-4">--}}
                    {{--<div class="store-information">--}}
                        {{--<div class="store-title">--}}
                            {{--<h4>Thông tin liên hệ</h4>--}}
                            {{--<div class="communication-info">--}}
                                {{--<!--Single Communication Start-->--}}
                                {{--<div class="single-communication">--}}
                                    {{--<div class="communication-icon">--}}
                                        {{--<i class="fa fa-map-marker"></i>--}}
                                    {{--</div>--}}
                                    {{--<div class="communication-text">--}}
                                        {{--<span>{{ $contactConfig->address }}</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!--Single Communication End-->--}}
                                {{--<!--Single Communication Start-->--}}
                                {{--<div class="single-communication">--}}
                                    {{--<div class="communication-icon">--}}
                                        {{--<i class="fa fa-phone"></i>--}}
                                    {{--</div>--}}
                                    {{--<div class="communication-text">--}}
                                        {{--<span>Điện thoại: <br><a--}}
                                                    {{--href="tel:{{ $contactConfig->phone }}">{{ $contactConfig->phone }}</a></span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!--Single Communication End-->--}}
                                {{--<!--Single Communication Start-->--}}
                                {{--<div class="single-communication">--}}
                                    {{--<div class="communication-icon">--}}
                                        {{--<i class="fa fa-envelope"></i>--}}
                                    {{--</div>--}}
                                    {{--<div class="communication-text">--}}
                                        {{--<span>Email: <br><a--}}
                                                    {{--href="mailto:{{ $contactConfig->email }}">{{ $contactConfig->email }}</a></span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<!--Single Communication End-->--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="store-information">--}}
                        {{--<div class="store-title">--}}
                            {{--<h4>Bản đồ</h4>--}}
                            {{--<div class="communication-info">--}}
                                {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5550587634457!2d106.62883821530102!3d10.768733792326803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752e9fb3efbab7%3A0xe676d14d2586afa4!2zMTkgSG_DoG5nIFh1w6JuIEhvw6BuaCwgVMOibiBUaOG7m2kgSG_DoCwgVMOibiBQaMO6LCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1543977729996"--}}
                                        {{--width="400" height="300" frameborder="0" style="border:0"--}}
                                        {{--allowfullscreen></iframe>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-lg-9 col-md-8">--}}
                    {{--<div class="content-wrapper">--}}
                        {{--<div class="page-content">--}}
                            {{--<div class="contact-form">--}}
                                {{--<div class="contact-form-title">--}}
                                    {{--<h3>Gửi liên hệ</h3>--}}
                                {{--</div>--}}
                                {{--{!! Form::open(['method' => 'POST' ,'class' => '111','id' => 'form' ,'url' => route('lien-he')]) !!}--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-lg-4">--}}
                                        {{--<div class="contact-form-style mb-20">--}}
                                            {{--<input name="full_name" placeholder="Họ và tên" type="text"--}}
                                                   {{--value="{{old('full_name')}}">--}}
                                            {{--{!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-4">--}}
                                        {{--<div class="contact-form-style mb-20">--}}
                                            {{--<input name="email" placeholder="Email" type="email" value="{{old('email')}}">--}}
                                            {{--{!! $errors->first('email', '<p class="help-block">:message</p>') !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-4">--}}
                                        {{--<div class="contact-form-style mb-20">--}}
                                            {{--<input name="phone" placeholder="Điện thoại" type="text"--}}
                                                   {{--value="{{old('phone')}}">--}}
                                            {{--{!! $errors->first('phone', '<p class="help-block">:message</p>') !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-12">--}}
                                        {{--<div class="contact-form-style mb-20">--}}
                                            {{--<input name="subject" placeholder="Tiêu đề" type="text" value="{{old('phone')}}">--}}
                                            {{--{!! $errors->first('subject', '<p class="help-block">:message</p>') !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-12">--}}
                                        {{--<div class="contact-form-style">--}}
                                            {{--<textarea name="message" placeholder="Nội dung">{{old('message')}}</textarea>--}}
                                            {{--{!! $errors->first('message', '<p class="help-block">:message</p>') !!}--}}
                                            {{--<button class="default-btn" type="submit"><span>Gửi ngay</span>--}}
                                            {{--</button>--}}
                                        {{--</div>--}}
                                        {{--@if(Session::has('noticeMassage'))--}}
                                            {{--<div class="alert alert-info"--}}
                                                 {{--role="alert">{{ session('noticeMassage') }}</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Liên hệ</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="#">Trang chủ</a></li>
                    <li class="active">Liên hệ với cửa hàng</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE -->
        <section class="page-section color">
            <div class="container">

                <div class="row">

                    <div class="col-md-4">
                        <div class="contact-info">

                            <h2 class="block-title"><span>Liên hệ với cửa hàng</span></h2>

                            <div class="media-list">
                                <div class="media">
                                    <i class="pull-left fa fa-home"></i>
                                    <div class="media-body">
                                        <strong>Địa chỉ:</strong><br>
                                        {{ $contactConfig->address }}
                                    </div>
                                </div>
                                <div class="media">
                                    <i class="pull-left fa fa-phone"></i>
                                    <div class="media-body">
                                        <strong>Số điện thoại:</strong><br>
                                        {{ $contactConfig->phone }}
                                    </div>
                                </div>
                                <div class="media">
                                    <i class="pull-left fa fa-envelope-o"></i>
                                    <div class="media-body">
                                        <strong>Email:</strong><br>
                                        {{ $contactConfig->email }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-8 text-left">

                        <h2 class="block-title"><span>Form liên hệ</span></h2>

                        <!-- Contact form -->
                        {!! Form::open(['method' => 'POST' ,'class' => 'contact-form','id' => 'form' ,'url' => route('lien-he')]) !!}
                        @if(Session::has('noticeMassage'))
                            <div class="alert alert-info"
                                 role="alert">{{ session('noticeMassage') }}</div>
                        @endif
                            <div class="outer required">
                                <div class="form-group af-inner">
                                    <label class="sr-only" for="name">Họ và tên</label>
                                    <input name="full_name" placeholder="Họ và tên" type="text"
                                           class="form-control placeholder"
                                           value="{{old('full_name')}}">
                                    {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div class="outer required">
                                <div class="form-group af-inner">
                                    <label class="sr-only" for="email">Email</label>
                                    <input name="email" placeholder="Email" type="email" value="{{old('email')}}" class="form-control placeholder">
                                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div class="outer required">
                                <div class="form-group af-inner">
                                    <label class="sr-only" for="subject">Số điện thoại</label>
                                    <input class="form-control placeholder" name="phone" placeholder="Số điện thoại" type="text" value="{{old('phone')}}">
                                    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div class="outer required">
                                <div class="form-group af-inner">
                                    <label class="sr-only" for="subject">Tiêu đề</label>
                                    <input class="form-control placeholder" name="subject" placeholder="Tiêu đề" type="text" value="{{old('subject')}}">
                                    {!! $errors->first('subject', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div class="form-group af-inner">
                                <label class="sr-only" for="input-message">Nội dung</label>
                                <textarea class="form-control placeholder" name="message" placeholder="Nội dung">{{old('message')}}</textarea>
                                {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
                            </div>

                            <div class="outer required">
                                <div class="form-group af-inner">
                                    <input type="submit" name="submit" class="form-button form-button-submit btn btn-theme btn-theme-dark" id="submit_btn" value="Gửi liên hệ" />
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <!-- /Contact form -->

                    </div>

                </div>

            </div>
        </section>
        <!-- /PAGE -->

        <!-- PAGE -->
        <section class="page-section no-padding no-bottom-space">
            <div class="container">

                <!-- Google map -->
                <div class="google-map">
                    <div id="map-canvas">
                        <div class="communication-info">
                            {!!  $contactConfig->map  !!}
                        </div>
                    </div>
                </div>
                <!-- /Google map -->

            </div>
        </section>
        <!-- /PAGE -->

    </div>
@stop
@section('js_content')
    <script>
        $(document).ready(function () {
            jQuery.each(jQuery(".span-notify-error"), function () {
                if (jQuery(this).text().length == 0) {
                    jQuery(this).parent().hide();
                } else {
                    jQuery(this).parent().show();
                }
            })
        });
    </script>
@endsection