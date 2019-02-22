@extends('admin.admin_master')
@section('breadcrumbs_no_url')
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-users"></i> Cấu hình liên hệ</h3>
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
                        'url'=> route('contact-config.save')
                    )) !!}
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="email" name="email" value="{{ $contactConfig->email }}"
                                   required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Số điện thoại<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="phone" name="phone" value="{{ $contactConfig->phone }}"
                                   required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Địa chỉ<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="address" name="address" value="{{ $contactConfig->address }}"
                                   required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Bản đồ<span
                                    class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="map" name="map" value="{{ $contactConfig->map }}" required="required"
                                   class="form-control col-md-7 col-xs-12">
                            {!!  $contactConfig->map  !!}
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                            <button onclick="saveContactConfig()" type="button" class="btn btn-success">Lưu dữ liệu
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

        });

        function saveContactConfig() {
            const email = $("#email").val();
            const phone = $("#phone").val();
            const address = $("#address").val();
            const map = $("#map").val();
            $.ajax({
                type: "POST",
                url: "<?php echo route('contact-config.save');?>",
                headers: {'X-CSRF-TOKEN': token},
                data: {
                    email,
                    phone,
                    address,
                    map
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