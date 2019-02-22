@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Kiểm duyệt người dùng</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'post',
            'url'=> route('user.confirm', $data->id)
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="color: red">Kiểm tra nội dung
                            <ul class="nav nav-tabs">
                                <li><a data-toggle="tab" href="#old">Cũ</a></li>
                                <li class="active"><a data-toggle="tab" href="#new">Mới</a></li>
                            </ul>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="tab-content">
                        <div id="old" class="tab-pane fade  ">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên hiển thị<span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', $data->name, array('class' => 'form-control', 'placeholder' => 'Tên hiển thị', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email<span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('email', $data->email, array('class' => 'form-control', 'placeholder' => 'Tên hiển thị', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Quyền sử dụng<span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <select id="status" name="group_id"
                                                class='select2 form-control' disabled="true">
                                            @foreach($groups as $key => $value)
                                                <option {{ $data->group_id == $key?'selected':'' }} value="{{ $key }}">{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="new" class="tab-pane fade in active">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên hiển thị<span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', $dataNew['name'], array('class' => 'form-control', 'placeholder' => 'Tên hiển thị', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email<span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('email', $dataNew['email'], array('class' => 'form-control', 'placeholder' => 'Tên hiển thị', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Quyền sử dụng<span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <select id="status" name="group_id"
                                                class='select2 form-control' disabled="true">
                                            @foreach($groups as $key => $value)
                                                <option {{ $dataNew['group_id'] == $key?'selected':'' }} value="{{ $key }}">{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $status = $dataNew!==null?$dataNew['status']:$data->status;
                    $id = $data->id;
                @endphp
                @include('admin.blocks.box.confirm',['route_cancel'=> route('user.confirmActionCancel', $data->id), 'route_apply'=> route('user.confirmActionApply', $data->id)])
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Tình trạng</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <?php
                            if ($status == 'active') {
                                $inactive = '';
                                $active = 'checked';
                            } else {
                                $inactive = 'checked';
                                $active = '';
                            }
                            $hidden = ($status == 'inactive');
                            $show = ($status == 'active');
                            ?>
                            <div class="radio">
                                <label>{{ Form::radio('status','active', $show, ['class' => 'flat','disabled'=>'true']) }}
                                    Hoạt
                                    động</label>
                            </div>
                            <div class="radio">
                                <label>{{ Form::radio('status','inactive', $hidden, ['class' => 'flat','disabled'=>'true']) }}
                                    Không hoạt
                                    động</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
