@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"> Chỉnh sửa banner</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'PUT',
            'enctype' => 'multipart/form-data',
            'url'=> route('banner.update', $data->id)
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nhập thông tin banner</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <strong style="color: red">Kích thước
                                    chuẩn : ( Slider: 1700px - 500px ) - ( Banner: 555px - 190px )</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tên banner <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('name', $data->name, array('class' => 'form-control', 'placeholder' => 'Tên banner')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">URL <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::text('url', $data->url, array('class' => 'form-control', 'placeholder' => 'URL')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Loại <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!!
                                    Form::select('type', [
                                        0 => 'Normal',
                                        1 => 'Slide'
                                    ],
                                    $data->type,
                                    array('class' => 'form-control')
                                    )
                                 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $status = $data->status;
                    $image = 'banner/' . $data->image;
                @endphp
                @include('admin.blocks.box.submit')
                @include('admin.blocks.box.edit.image')
                @include('admin.blocks.box.edit.status')
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
