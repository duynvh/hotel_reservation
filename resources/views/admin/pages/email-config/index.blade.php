@extends('admin.admin_master')
@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Cấu hình email</h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="clearfix"></div>
    {!! Form::open(array(
        'id' => 'submit_form',
        'class' => 'form-horizontal form-label-left',
        'method' => 'POST',
        'url'=> route('email-config-save')
    )) !!}
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Email gửi</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="refresh-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up" data-toggle="tooltip" data-placement="bottom" data-original-title="Show/Hide"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $emailConfig['email'] }}" type="text" id="email" name="email" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $emailConfig['password'] }}" type="password" id="password" name="password" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Nhận thông báo</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="refresh-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up" data-toggle="tooltip" data-placement="bottom" data-original-title="Show/Hide"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-horizontal form-label-left">
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nhận Email khi đăng kí</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{ $emailConfig['email_register'] }}" name="email_register" id="email_register" type="text" class="tags form-control" value="email1@gmail.com, email2@gmail.com, email3@gmail.com" />
                                <div id="suggestions-container" class="email-tag"></div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nhận Email khi liên hệ</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="{{ $emailConfig['email_contact'] }}" name="email_contact" id="email_contact" type="text" class="tags form-control" value="email1@gmail.com, email2@gmail.com, email3@gmail.com" />
                                <div id="suggestions-container" class="email-tag"></div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button onclick="saveEmailConfig()" type="button" class="btn btn-success">Lưu dữ liệu</button>
                                <button class="btn btn-info" type="button">Huỷ bỏ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('js_content')
    <script>
        $(document).ready(function(){
            $("#email_register").tagsInput({
                width: "auto",
                defaultText:'add email',
            });

            $("#email_contact").tagsInput({
                width: "auto",
                defaultText:'add email'
            });
        });

        function saveEmailConfig(){
            const email = $("#email").val();
            const password = $("#password").val();
            const email_register = $("#email_register").val();
            const email_contact = $("#email_contact").val();
            $.ajax({
                type 	: "POST",
                url		: "<?php echo route('email-config-save');?>",
                headers : {'X-CSRF-TOKEN': token},
                data 	: {
                    email,
                    password,
                    email_register,
                    email_contact
                },
                success: function (response) {
                    var Obj = $.parseJSON(response);

                    if (Obj.status == 1) {
                        swal("Good job!", Obj.msg, "success");
                    } else {
                        swal("Oops!", Obj.msg, "error");
                    }
                }
            });
        }
    </script>
@endsection