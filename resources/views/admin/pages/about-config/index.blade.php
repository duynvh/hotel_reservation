@extends('admin.admin_master')
@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Cấu hình giới thiệu</h3>
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
                        'url'=> route('about-config.save')
                    )) !!}
                    <div class="form-group">
                        <label style="margin-bottom: 10px;" class="col-md-12 pull-left">Nội dung <span class="required">*</span></label>
                        <div class="col-md-12">
                            <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
                            <textarea class="ckeditor form-control" name="content" id="content" rows="1">{!! $aboutConfig['content'] !!}</textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button onclick="saveAboutConfig()" type="button" class="btn btn-success">Lưu dữ liệu </button>
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
            
        });

        function saveAboutConfig(){
            const content = CKEDITOR.instances['content'].getData();
            $.ajax({
                type 	: "POST",
                url		: "<?php echo route('about-config.save');?>",
                headers : {'X-CSRF-TOKEN': token},
                data 	: {
                    content
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