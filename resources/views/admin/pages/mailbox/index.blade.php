@extends('admin.admin_master')

@section('breadcrumbs_no_url')
    <div class="page-title">
        <div class="title_left">
            <h3 class="txt-color-blueDark"><i class="fa-fw fa fa-envelope"></i> Hộp thư </h3>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                    @include('admin.blocks.box.btnMailbox')

                    <!-- /MAIL LIST -->

                        <!-- CONTENT MAIL -->
                        <div class="col-sm-9 mail_view">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Danh sách thư</h3>
                                </div>
                                <div class="panel-body">
                                    <div>
                                        <div class="btn-group">
                                        <span class="btn btn-default checkbox-toggle"><input id="check-all"
                                                                                             type="checkbox"></span>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" id="move-trash" class="btn btn-default btn-md"><i
                                                        class="fa fa-trash-o"></i></button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data_table as $key => $value)
                                            <tr class="{{ $value->id }}">
                                                <td><input class="choose mail-{{ $value->id }}" type="checkbox"></td>
                                                <td>
                                                    <a href="{{ route('mailbox.show',$value->id)  }}">{!! $value->status == 0 ? "<b>".$value->subject."</b>" : $value->subject !!}</a>
                                                </td>
                                                <td>
                                                    {!! $value->status == 0 ? "<b>".$value->full_name."</b>" : $value->full_name !!}
                                                </td>
                                                <td>{!! $value->status == 0 ? "<b>".$value->email."</b>" : $value->email !!}</td>
                                                <td>{!! $value->status == 0 ? "<b>".$value->phone."</b>" : $value->phone !!}</td>
                                                <td>{!! $value->status == 0 ? "<b>".$value->created_at->diffForHumans()."</b>" : $value->created_at->diffForHumans() !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /CONTENT MAIL -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-after-javascript')
    <div class="compose col-md-6 col-xs-12">
        {!! Form::open(array(
                'id' => 'submit_form',
                'class' => 'form-horizontal ',
                'method' => 'POST',
                'url'=> route('group.store')
            )) !!}
        <div class="compose-header">
            Tin nhắn mới
            <button type="button" class="close compose-close">
                <span>×</span>
            </button>
        </div>

        <div class="compose-body">
            <div id="alerts"></div>

            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b
                                class="caret"></b></a>
                    <ul class="dropdown-menu">
                    </ul>
                </div>

                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i
                                class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a data-edit="fontSize 5">
                                <p style="font-size:17px">Huge</p>
                            </a>
                        </li>
                        <li>
                            <a data-edit="fontSize 3">
                                <p style="font-size:14px">Normal</p>
                            </a>
                        </li>
                        <li>
                            <a data-edit="fontSize 1">
                                <p style="font-size:11px">Small</p>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="btn-group">
                    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                    <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i
                                class="fa fa-strikethrough"></i></a>
                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                    <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i
                                class="fa fa-dedent"></i></a>
                    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i
                                class="fa fa-align-left"></i></a>
                    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i
                                class="fa fa-align-center"></i></a>
                    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i
                                class="fa fa-align-right"></i></a>
                    <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i
                                class="fa fa-align-justify"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i
                                class="fa fa-link"></i></a>
                    <div class="dropdown-menu input-append">
                        <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
                        <button class="btn" type="button">Add</button>
                    </div>
                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                </div>

                <div class="btn-group">
                    <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i
                                class="fa fa-picture-o"></i></a>
                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage"/>
                </div>

                <div class="btn-group">
                    <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                    <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                </div>
            </div>
            <div id="to">
                <input type="email" required name="email" class="form-control" placeholder="Email nhận"/>
            </div>
            <div id="subject">
                <input type="text" required name="subject" class="form-control" placeholder="Chủ đề"/>
            </div>
            <div id="editor" class="editor-wrapper"></div>
        </div>

        <div class="compose-footer">
            <button id="send" class="btn btn-sm btn-success" type="submit">Gửi</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
@section('js_content')
    <script>
        $(document).ready(function () {
            //choose mail
            var choose_mail = jQuery('.choose');
            var check_all = jQuery('#check-all');
            var move_trash = jQuery('#move-trash');
            var delete_trash = jQuery('#delete-trash');
            var array_mail_choosed = [];

            choose_mail.click(function () {
                var info = jQuery(this).attr("class").split(" ", 2);
                var id = info[1].split("-", 2);
                if (jQuery(this).is(':checked')) {
                    array_mail_choosed.push(id[1]);
                }
                else {
                    array_mail_choosed = jQuery.grep(array_mail_choosed, function (value) {
                        return value !== id[1];
                    });
                }

            });
            //choose all mail
            check_all.click(function () {
                var checked = jQuery(this);
                if (checked.is(':checked')) {
                    jQuery('.choose').prop("checked", true);
                    jQuery('.choose').each(function () {
                        var info = jQuery(this).attr("class").split(" ", 2);
                        var id = info[1].split("-", 2);

                        array_mail_choosed.push(id[1]);
                    });
                }
                else {
                    jQuery('.choose').prop("checked", false);
                    jQuery('.choose').each(function () {
                        var info = jQuery(this).attr("class").split(" ", 2);
                        var id = info[1].split("-", 2);

                        array_mail_choosed = jQuery.grep(array_mail_choosed, function (value) {
                            return value !== id[1];
                        });
                    });
                }

            });

            //move ajax
            move_trash.click(function () {

                var url = baseURL + "/admin/mailbox/moveMailToTrash";
                var token = jQuery("input[name='_token']").attr('value');

                data = {"_token": token, "id": array_mail_choosed};

                jQuery.ajax({
                    url: url,
                    type: 'post',
                    cache: false,
                    data: data,
                    success: function (result) {
                        if (jQuery.trim(result) === 'true') {
                            for (i = 0; i < array_mail_choosed.length; i++) {
                                jQuery('.' + array_mail_choosed[i]).remove();
                            }
                        }
                        bootbox.alert("Đã chuyển mail vào thùng rác!");
                    },
                    error: function () {
                        bootbox.alert("Đã có lỗi xảy ra, xin thử lại!");
                    }
                });
            });

        });
    </script>
@endsection