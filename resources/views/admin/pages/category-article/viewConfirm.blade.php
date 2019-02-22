@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Kiểm duyệt loại sản phẩm</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'post',
            'url'=> route('category-article.confirm', $data->id)
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="color: red">Kiểm tra nội dung
                            @if($data->confirm_action == "update")
                                <ul class="nav nav-tabs">
                                    <li><a data-toggle="tab" href="#old">Cũ</a></li>
                                    <li class="active"><a data-toggle="tab" href="#new">Mới</a></li>
                                </ul>
                            @endif
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    if ($data->confirm_action == "update") {
                        $class['old'] = '';
                        $class['new'] = 'in active';
                    } else {
                        $class['old'] = 'in active';
                        $class['new'] = '';
                    }
                    ?>
                    <div class="tab-content">
                        <div id="old" class="tab-pane fade {{ $class['old'] }}">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Danh mục cha <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <?php
                                        if ($category['old'] === '') {
                                            $categoryNameOld = 'Không xác định';
                                        } else if ($category['old']->name === 'Root') {
                                            $categoryNameOld = "Mục gốc";
                                        } else {
                                            $categoryNameOld = $category['old']->name;
                                        }
                                        ?>
                                        {!! Form::text('category', $categoryNameOld, array('class' => 'form-control', 'placeholder' => 'Slug', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên danh mục <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', $data->name, array('class' => 'form-control', 'placeholder' => 'Tên danh mục', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Slug <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('slug', $data->slug, array('class' => 'form-control', 'placeholder' => 'Slug', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mô tả <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('description', $data->description, array('class' => 'form-control', 'rows' => "3", 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="new" class="tab-pane fade {{$class['new']}}">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Danh mục cha <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <?php
                                        if ($category['new'] === '') {
                                            $categoryNameNew = '';
                                        } else if ($category['new']->name === 'Root') {
                                            $categoryNameNew = "Mục gốc";
                                        } else {
                                            $categoryNameNew = $category['new']->name;
                                        }
                                        ?>
                                        {!! Form::text('category', $categoryNameNew, array('class' => 'form-control', 'placeholder' => 'Slug','readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên danh mục <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', $dataNew[0]['name'], array('class' => 'form-control', 'placeholder' => 'Tên danh mục','readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Slug <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('slug', $dataNew[0]['slug'], array('class' => 'form-control', 'placeholder' => 'Slug','readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mô tả <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('description', $dataNew[0]['description'], array('class' => 'form-control', 'rows' => "3",'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $status = $dataNew[0]['status']!==null?$dataNew[0]['status']:$data->status;
                    $id = $data->id;
                @endphp
                @include('admin.blocks.box.confirm',['route_cancel'=> route('category-article.confirmActionCancel', $data->id), 'route_apply'=> route('category-article.confirmActionApply', $data->id)])
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
