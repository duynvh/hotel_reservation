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
            'url'=> route('coupon.confirm', $data->id)
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
                                    <label class="col-md-2 control-label">Tên hiển thị<span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('coupon_code', $data->coupon_code, array('class' => 'form-control', 'placeholder' => 'Tên hiển thị', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Loại giá trị <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <select id="amount_type" name="amount_type"
                                                class='select2 form-control' disabled="true">
                                            <option {{ $data->amount_type == 'percent'?'selected':'' }} value="percent">
                                                Theo phần trăm
                                            </option>
                                            <option {{ $data->amount_type == 'amount'?'selected':'' }} value="amount">
                                                Theo giá tiền
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Số tiền <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::number('amount', $data->amount, array('class' => 'form-control', 'min' => 1,'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Ngày bắt đầu <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input readonly value="{{ date("d-m-Y", strtotime($data->start_date))  }}" name="start_date" type="text"
                                               class="form-control has-feedback-left" id="start_date"
                                               aria-describedby="input_start_date">
                                        <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                        <span id="input_start_date" class="sr-only">(success)</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Ngày hết hạn <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input readonly value="{{ date("d-m-Y", strtotime($data->end_date))  }}" name="end_date" type="text"
                                               class="form-control has-feedback-left" id="end_date"
                                               aria-describedby="input_end_date">
                                        <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                        <span id="input_end_date" class="sr-only">(success)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="new" class="tab-pane fade {{$class['new']}}">
                            <div class="x_content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tên hiển thị<span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::text('coupon_code', $dataNew['coupon_code'], array('class' => 'form-control', 'placeholder' => 'Tên hiển thị', 'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Loại giá trị <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <select disabled="true" id="amount_type" name="amount_type"
                                                class='select2 form-control'>
                                            <option {{ $dataNew['amount_type'] == 'percent'?'selected':'' }} value="percent">
                                                Theo phần trăm
                                            </option>
                                            <option {{ $dataNew['amount_type'] == 'amount'?'selected':'' }} value="amount">
                                                Theo giá tiền
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Số tiền <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        {!! Form::number('amount', $dataNew['amount'], array('class' => 'form-control', 'min' => 1,'readonly'=>'readonly')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Ngày bắt đầu <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input readonly value="{{ date("d-m-Y", strtotime($data->start_date))  }}" name="start_date" type="text"
                                               class="form-control has-feedback-left" id="start_date"
                                               aria-describedby="input_start_date">
                                        <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                        <span id="input_start_date" class="sr-only">(success)</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Ngày hết hạn <span
                                                class="required">*</span></label>
                                    <div class="col-md-10">
                                        <input readonly value="{{ date("d-m-Y", strtotime($data->end_date))  }}" name="end_date" type="text"
                                               class="form-control has-feedback-left" id="end_date"
                                               aria-describedby="input_end_date">
                                        <span class="fa fa-calendar-o form-control-feedback left"
                                              aria-hidden="true"></span>
                                        <span id="input_end_date" class="sr-only">(success)</span>
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
                @include('admin.blocks.box.confirm',['route_cancel'=> route('coupon.confirmActionCancel', $data->id), 'route_apply'=> route('coupon.confirmActionApply', $data->id)])
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
