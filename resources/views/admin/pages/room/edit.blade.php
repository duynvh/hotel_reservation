@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="page-title">
        <div class="title_left">
            <h3>Chỉnh sửa phòng</h3>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'PUT',
            'url'=> route('room.update', $data->id),
            'enctype' => 'multipart/form-data'
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nhập thông tin phòng</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Loại phòng</label>
                            <div class="col-md-10">
                                {!! Form::select('room_type_id',
                                    $roomTypes,
                                    $data->room_type_id,
                                    array( 'class' => 'form-control select-category' )
                                ) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Số phòng <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('room_number', $data->room_number, array('class' => 'form-control', 'placeholder' => 'Số phòng')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên phòng <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('name', $data->name, array('class' => 'form-control', 'placeholder' => 'Tên phòng')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Số tiền <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::number('price', $data->price, array('class' => 'form-control', 'min' => 1000)) !!}
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

