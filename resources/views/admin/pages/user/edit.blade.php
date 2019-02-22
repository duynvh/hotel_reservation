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
            'method' => 'PUT',
            'url'=> route('user.update', $data->id)
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Thay đổi quyền hạn người dùng</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Avatar<span class="required">*</span></label>
                            <div class="col-md-10">
                                <img id="imagePreview" src="{{ asset('public/upload/images/user/' . $data->image) }}"
                                     alt="Avatar"
                                     style="width: 20%; height: auto;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Email<span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::email('email', $data->email, array('class' => 'form-control', 'placeholder' => 'Tên hiển thị')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên hiển thị<span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('name', $data->name, array('class' => 'form-control', 'placeholder' => 'Tên hiển thị')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Quyền sử dụng<span class="required">*</span></label>
                            <div class="col-md-10">
                                <select id="status" name="group_id"
                                        class='select2 form-control'>
                                    @foreach($groups as $key => $value)
                                        <option {{ $data->group_id == $key?'selected':'' }} value="{{ $key }}">{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $status = $data->status;
                @endphp
                @include('admin.blocks.box.submit')
                @include('admin.blocks.box.edit.status')
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
