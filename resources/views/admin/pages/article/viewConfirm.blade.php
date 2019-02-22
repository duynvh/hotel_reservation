@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Kiểm duyệt mã giảm giá</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'post',
            'url'=> route('banner.confirm', $data->id)
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
                                    <label class="col-md-2 control-label">Danh mục</label>
                                    <div class="col-md-10">
                                        {!! Form::select('category_article_id',
                                            $categories,
                                            $data->category_article_id,
                                            array( 'class' => 'form-control select-category' )
                                        ) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên bài viết <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', $data->name, array('class' => 'form-control', 'placeholder' => 'Tên bài viết')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Slug <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('slug', $data->slug, array('class' => 'form-control', 'placeholder' => 'Slug')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mô tả <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('description', $data->description, array('class' => 'form-control', 'rows' => "3")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Nội dung <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
                                        <textarea class="ckeditor form-control" name="content" id="content" rows="1">{{ $data->content }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="new" class="tab-pane fade {{$class['new']}}">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Danh mục</label>
                                    <div class="col-md-10">
                                        {!! Form::select('category_article_id',
                                            $categories,
                                            $dataNew['category_article_id'],
                                            array( 'class' => 'form-control select-category' )
                                        ) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên bài viết <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('name', $dataNew['name'], array('class' => 'form-control', 'placeholder' => 'Tên bài viết')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Slug <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('slug', $dataNew['slug'], array('class' => 'form-control', 'placeholder' => 'Slug')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mô tả <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('description', $dataNew['description'], array('class' => 'form-control', 'rows' => "3")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Nội dung <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
                                        <textarea class="ckeditor form-control" name="content" id="content" rows="1">{{ $dataNew['content'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $status = $dataNew['status']!==null?$dataNew['status']:$data->status;
                    $id = $data->id;
                @endphp
                @include('admin.blocks.box.confirm',['route_cancel'=> route('article.confirmActionCancel', $data->id), 'route_apply'=> route('article.confirmActionApply', $data->id)])
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
                @if($dataNew['image'] !== null)
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Hình ảnh mới</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group">
                                <img id="imagePreview"
                                     src="{{ asset('public/upload/images/article/' . $dataNew['image']) }}"
                                     alt="image preview"
                                     style="width: 100%"/>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
