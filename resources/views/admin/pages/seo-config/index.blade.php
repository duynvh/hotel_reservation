@extends('admin.admin_master')
@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Cấu hình seo</h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Config</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="refresh-link" data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up" data-toggle="tooltip" data-placement="bottom" data-original-title="Show/Hide"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {!! Form::open(array(
                        'id' => 'submit_form',
                        'class' => 'form-horizontal form-label-left',
                        'method' => 'POST',
                        'url'=> route('seo-config.save')
                    )) !!}
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta title<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="meta_title" name="meta_title" value="{{ $seoConfig->meta_title }}" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta keywords<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $seoConfig->meta_keywords }}" type="text" id="meta_keywords" name="meta_keywords" required="required" class="tags form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta description<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="meta_description" name="meta_description" class="form-control col-md-7 col-xs-12">{{ $seoConfig->meta_description }}</textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button onclick="saveSeoConfig()" type="button" class="btn btn-success">Lưu dữ liệu </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_content')
    <script>
        $(document).ready(function(){
            $("#meta_keywords").tagsInput({
                width: "auto",
                defaultText:'add words',
            });
        });

        function saveSeoConfig(){
            const meta_title = $("#meta_title").val();
            const meta_keywords = $("#meta_keywords").val();
            const meta_description = $("#meta_description").val();
            $.ajax({
                type 	: "POST",
                url		: "<?php echo route('seo-config.save');?>",
                headers : {'X-CSRF-TOKEN': token},
                data 	: {
                    meta_title,
                    meta_description,
                    meta_keywords
                },
                success: function (response) {
                    var Obj = $.parseJSON(response);

                    if (Obj.status == 1) {
                        swal("Good job!", Obj.msg, "success");
                    } else {
                        swal("Oops!", Obj.msg, "error");
                    }
                }
            });
        }
    </script>
@endsection