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
            'url'=> route('product.confirm', $data->id)
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
                                    <label class="col-md-2 control-label">Tên bài viết <span
                                                class="required">*</span></label>
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
                                    <label class="col-md-2 control-label">Giá tiền <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::number('price', $data->price, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Giá tiền cũ <span
                                                class="required"></span></label>
                                    <div class="col-md-10">
                                        {!! Form::number('price_old', $data->price_old, array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Màu sản phẩm <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input value="{{ $data->color }}" type="text" id="color" name="color"
                                               required="required" class="tags form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Size sản phẩm <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input value="{{ $data->size }}" type="text" id="size" name="size"
                                               required="required"
                                               class="tags form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mô tả <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('description', $data->description, array('class' => 'form-control', 'rows' => "3")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Nội dung <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
                                        <textarea class="ckeditor form-control" name="content" id="content"
                                                  rows="1">{!! $data->content !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Hình ảnh bổ sung<span class="required"></span></label>
                                    <div class="col-md-10">
                                        @if($image_detail != null)
                                            @foreach($image_detail as $key => $value)
                                                <div class="col-xs-3 item-image-preview-old">
                                                    <button type="button" class="btn-remove-image-old">X
                                                    </button>
                                                    <img src="{{ asset('/upload/images/product/'.$value) }}"
                                                         width="200px"/>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="new" class="tab-pane fade in active">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên bài viết <span
                                                class="required">*</span></label>
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
                                    <label class="col-md-2 control-label">Giá tiền <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::number('price', $dataNew['price'], array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Giá tiền cũ <span
                                                class="required"></span></label>
                                    <div class="col-md-10">
                                        {!! Form::number('price_old', $dataNew['price_old'], array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Màu sản phẩm <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input value="{{ $dataNew['color'] }}" type="text" id="color" name="color"
                                               required="required" class="tags form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Size sản phẩm <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input value="{{ $dataNew['size'] }}" type="text" id="size" name="size"
                                               required="required"
                                               class="tags form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Mô tả <span class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::textarea('description', $dataNew['description'], array('class' => 'form-control', 'rows' => "3")) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Nội dung <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
                                        <textarea class="ckeditor form-control" name="content" id="content"
                                                  rows="1">{!!  $dataNew['content']  !!}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Hình ảnh bổ sung<span class="required"></span></label>
                                    <div class="col-md-10">
                                        @if($image_detail_new != null)
                                            @foreach($image_detail_new as $key => $value)
                                                <div class="col-xs-3 item-image-preview-old">
                                                    <button type="button" class="btn-remove-image-old">X
                                                    </button>
                                                    <img src="{{ asset('/upload/images/product/'.$value) }}"
                                                         width="200px"/>
                                                </div>
                                            @endforeach
                                        @endif
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
                @include('admin.blocks.box.confirm',['route_cancel'=> route('product.confirmActionCancel', $data->id), 'route_apply'=> route('product.confirmActionApply', $data->id)])
                <div class="tab-content">
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
                                     src="{{ asset('public/upload/images/product/' . $dataNew['image']) }}"
                                     alt="image preview"
                                     style="width: 100%"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection
