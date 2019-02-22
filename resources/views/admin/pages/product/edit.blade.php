@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Chỉnh sửa sản phẩm</h3>
        </div>
    </div>
@endsection

@section('content')
    <section id="widget-grid" class="">
        {!! Form::open(array(
            'id' => 'submit_form',
            'class' => 'form-horizontal ',
            'method' => 'PUT',
            'url'=> route('product.update', $data->id),
            'enctype' => 'multipart/form-data'
        )) !!}
        @include('admin.blocks.notify.notify_error')
        <div class="row">
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Nhập thông tin bài viết</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Danh mục</label>
                            <div class="col-md-10">
                                {!! Form::select('category_product_id',
                                $categories,
                                $data->category_product_id,
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
                                {!! Form::text('slug', $data->slug, array('class' => 'form-control', 'placeholder' => 'Slug', 'readonly' => 'readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Giá tiền <span class="required">*</span></label>
                            <div class="col-md-10">
                                {!! Form::number('price', $data->price, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Giá tiền cũ <span class="required"></span></label>
                            <div class="col-md-10">
                                {!! Form::number('price_old', $data->price_old, array('class' => 'form-control')) !!}
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
                                <textarea class="ckeditor form-control" name="content" id="content"
                                          rows="1">{{ $data->content }}</textarea>
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
                                            <img src="{{ asset('/upload/images/product/'.$value) }}" width="200px"/>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Thêm hình ảnh bổ sung<span
                                        class="required"></span></label>
                            <div class="col-md-10">
                                <input type="file" multiple name="image_detail[]" id="image-detail"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div id="list-img-detail" class="col-md-10 thumb-output">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $status = $data->status;
                    $check_item = $data->check_item;
                    $new = $data->new;
                    $image = "product/" . $data->image;
                @endphp
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Lưu dữ liệu</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <button type="button" class="btn btn-default" onclick="window.history.back();">
                                <i class="fa fa-repeat"></i> Quay về
                            </button>
                            <button type="button" class="btn btn-primary btn-save-edit-product"><i
                                        class="fa fa-save"></i> Lưu
                            </button>
                        </div>
                    </div>
                </div>
                @include('admin.blocks.box.edit.image')
                @include('admin.blocks.box.edit.status')
                @include('admin.blocks.box.edit.new')
                @include('admin.blocks.box.edit.checkItem')
            </div>
        </div>
        {!! Form::close() !!}
    </section>
@endsection

@section('js_content')
    <script>
        $(document).ready(function () {

            $("input[name='name']").keyup((event) => {
                $("input[name='slug']").val(string_to_slug(event.target.value));
            });

            $("#color").tagsInput({
                width: "auto",
                defaultText: 'add words',
            });

            $("#size").tagsInput({
                width: "auto",
                defaultText: 'add words',
            });

            //get image detail
            var array_image_remove = [];
            jQuery(".btn-remove-image-old").click(function () {
                if (confirm("Bạn thực sự muốn xoá ảnh này?") === true) {
                    var path_image = jQuery(this).next().attr("src").split("/", 9);
                    var name_image = path_image[path_image.length - 1];
                    array_image_remove.push(name_image);
                    jQuery(this).parent(".item-image-preview-old").remove();

                }
            });
            // ajax delete image)detail
            var baseURL = window.location.origin;
            jQuery(".btn-save-edit-product").click(function () {
                var url = baseURL + "/admin/product/edit/remove-image";
                var emptyItem = "true";
                if (array_image_remove.length !== 0) {
                    emptyItem = "false";
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    }
                });

                data = {"arrayImage": "" + array_image_remove, "emptyItem": emptyItem};
                jQuery.ajax({
                    url: url,
                    type: 'post',
                    cache: false,
                    data: data,
                    success: function (result) {
                        console.log(result);
                        array_image_remove = [];

                        jQuery("#submit_form").submit();
                    },
                    error: function () {
                        alert('Có lỗi xảy ra trong lúc cập nhật. Xin thử lại1');
                    }
                });
            });

            //ajax load image_detail
            jQuery(".thumb-output").hide();
            $('#image-detail').on('change', function () { //on file input change
                jQuery(".thumb-output").show();
                var countImg = parseInt(jQuery("#image-detail")[0].files.length);
                if (countImg <= 10) {
                    if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                    {
                        $('.thumb-output').html(''); //clear html of output element
                        var data = $(this)[0].files; //this file data

                        var position = 1;
                        $.each(data, function (index, file) { //loop though each file
                            if (/(\.|\/)(gif|jpeg|png)$/i.test(file.type)) { //check supported file type
                                var fRead = new FileReader(); //new filereader
                                fRead.onload = (function (file) { //trigger function on successful read
                                    return function (e) {
                                        $('#list-img-detail').append('<div class="col-xs-3 img-detail-' + position + '"' + '></div>');
                                        var img = $('<img/>').addClass('item-image-preview').attr({
                                            'src': e.target.result,
                                            width: 200 + 'px',
                                        }); //create image element
                                        $('.img-detail-' + position).append(img); //append image to output element
                                        position += 1;
                                    };
                                })(file);
                                fRead.readAsDataURL(file); //URL representing the file's data.
                            }
                        });

                    } else {
                        alert("Your browser doesn't support File API!"); //if File API is absent
                    }
                } else {
                    alert("Số lượng hình tối đa là 10");
                }
            });
        });
    </script>
@endsection
