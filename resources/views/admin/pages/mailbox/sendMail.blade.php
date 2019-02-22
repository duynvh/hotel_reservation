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
                            @include('admin.blocks.notify.notify_error')

                            {!! Form::open(['method' => 'POST' ,'id' => 'form' ,'url' => route('mailbox.sendMail')]) !!}

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Đọc thư</h3>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="panel-body">
                                    <div class="x_content">
                                        <div class="form-group">
                                            <label style="margin-top: 5px" class="col-md-2 control-label text-right">Trả
                                                lời đến </label>
                                            <div class="col-md-10">
                                                {!! Form::email('toEmail', '', array('class' => 'form-control','placeholder' => 'Nhập email người nhận')) !!}
                                            </div>
                                        </div>
                                        <div style="margin-top: 10px" class="form-group">
                                            <label style="margin-top: 5px" class="col-md-2 control-label text-right">Chủ
                                                đề </label>
                                            <div class="col-md-10">
                                                {!! Form::text('subject','', array('class' => 'form-control', 'placeholder' => 'Nhập chủ đề')) !!}
                                            </div>
                                        </div>
                                        <div style="margin-top: 10px" class="form-group">
                                            <label style="margin-top: 5px" class="col-md-2 control-label text-right">Nội
                                                dung </label>
                                            <div class="col-md-10">
                                                <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
                                                <textarea class="ckeditor form-control" name="content" id="content"
                                                          rows="1"></textarea>
                                                <script>
                                                    CKEDITOR.replace('content', {
                                                        height: '500px',
                                                        customConfig: '{{asset("/ckeditor/config-article.js")}}',
                                                        filebrowserBrowseUrl: '{{ asset("/ckfinder/ckfinder.html") }}',
                                                        filebrowserImageBrowseUrl: '{{ asset("/ckfinder/ckfinder.html?type=Images") }}',
                                                        filebrowserFlashBrowseUrl: '{{ asset("/ckfinder/ckfinder.html?type=Flash") }}',
                                                        filebrowserUploadUrl: '{{ asset("/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files") }}',
                                                        filebrowserImageUploadUrl: '{{ asset("/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images") }}',
                                                        filebrowserFlashUploadUrl: '{{ asset("/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash") }}'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div style="margin-top: 20px" class="form-group">
                                            <label style="margin-top: 5px"
                                                   class="col-md-2 control-label text-right"></label>

                                            <div class="col-md-10">
                                                <button style="margin-top: 10px" type="submit"
                                                        class="btn btn-success col-md-2">Gửi
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}

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
            var mail_reading = jQuery('#delete-mail-reading');
            mail_reading.click(function () {
                bootbox.confirm({
                    message: "Bạn muốn xóa thư này vào thùng rác?",
                    buttons: {
                        confirm: {
                            label: 'Đồng ý',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Không',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if (result === true) {
                            var url = baseURL + "/admin/mailbox/moveMailToTrash";
                            var token = jQuery("input[name='_token']").attr('value');
                            var stringClass = mail_reading.attr('class').split(' ');
                            id = stringClass[stringClass.length - 1];

                            data = {"_token": token, "id": id};

                            jQuery.ajax({
                                url: url,
                                type: 'post',
                                cache: false,
                                data: data,
                                success: function (result) {
                                    bootbox.alert("Đã chuyển mail vào thùng rác!");
                                    window.location.href = baseURL + '/admin/mailbox';
                                },
                                error: function () {
                                    bootbox.alert("Đã có lỗi xảy ra, xin thử lại!");
                                }
                            });
                        }
                    }
                });
            })


        });
    </script>
@endsection