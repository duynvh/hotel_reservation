@extends('admin.admin_master')
@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Cấu hình social</h3>
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
                        <li><a class="refresh-link" data-toggle="tooltip" data-placement="bottom"
                               data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up" data-toggle="tooltip"
                                                        data-placement="bottom" data-original-title="Show/Hide"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {!! Form::open(array(
                        'id' => 'submit_form',
                        'class' => 'form-horizontal form-label-left',
                        'method' => 'POST',
                        'url'=> route('social-config.save')
                    )) !!}
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Facebook URL<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="facebook_url" name="facebook_url"
                                   value="{{ $socialConfig['facebook_url'] }}" placeholder="Để # nếu không có" required="required"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Shopee URL<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="shopee_url" name="shopee_url"
                                   value="{{ $socialConfig['shopee_url'] }}" placeholder="Để # nếu không có" required="required"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Zalo URL<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="zalo_url" name="zalo_url" placeholder="Để # nếu không có" value="{{ $socialConfig['zalo_url'] }}"
                                   required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Lazada URL<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="lazada_url" name="lazada_url" placeholder="Để # nếu không có"
                                   value="{{ $socialConfig['lazada_url'] }}" required="required"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button onclick="saveSocialConfig()" type="button" class="btn btn-success">Lưu dữ liệu
                            </button>
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
        $(document).ready(function () {
            $("#meta_keywords").tagsInput({
                width: "auto",
                defaultText: 'add words',
            });
        });

        function saveSocialConfig() {
            const facebook_url = $("#facebook_url").val();
            const shopee_url = $("#shopee_url").val();
            const zalo_url = $("#zalo_url").val();
            const lazada_url = $("#lazada_url").val();
            $.ajax({
                type: "POST",
                url: "<?php echo route('social-config.save');?>",
                headers: {'X-CSRF-TOKEN': token},
                data: {
                    facebook_url,
                    shopee_url,
                    zalo_url,
                    lazada_url
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