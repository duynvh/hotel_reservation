@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Chỉnh sửa người dùng</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'post',
            'url'=> route('user.updatePass', $data->id)
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Thay đổi mật khảu</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mật khẩu mới <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Nhập mật khẩu mới']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mật khẩu mới <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::password('re_password', ['class' => 'form-control','placeholder' => 'Nhập lại mật khẩu']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('admin.blocks.box.submit')
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
