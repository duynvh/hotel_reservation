@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Thêm mới người dùng</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'POST',
            'url'=> route('user.store')
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nhập thông tin người dùng</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nhóm người dùng</label>
                            <div class="col-md-10">
                                {!! Form::select('group_id',
                                    $groups,
                                    '',
                                    array( 'class' => 'form-control' )
                                ) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên người dùng <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Tên người dùng')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Email <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Email')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mật khẩu <span class="required">*</span></label>
                            <div class="col-md-10">
                                <input type="password" name='password' class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('admin.blocks.box.submit')
                @include('admin.blocks.box.add.status')
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
