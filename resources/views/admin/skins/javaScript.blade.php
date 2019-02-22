<script>var baseURL = '{{ url('/') }}';</script>
{!! Html::script('st-admin/vendors/jquery/dist/jquery.min.js') !!}
{!! Html::script('st-admin/vendors/bootstrap/dist/js/bootstrap.min.js') !!}
<script>var token = $('meta[name="csrf_token"]').attr("content");</script>
@yield('footer_js')
{!! Html::script('st-admin/vendors/fastclick/lib/fastclick.js') !!}
{!! Html::script('st-admin/vendors/nprogress/nprogress.js') !!}
{!! Html::script('st-admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') !!}
{!! Html::script('st-admin/vendors/moment/min/moment.min.js') !!}
{!! Html::script('st-admin/vendors/bootstrap-daterangepicker/daterangepicker.js') !!}
{!! Html::script('st-admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
{!! Html::script('st-admin/vendors/iCheck/icheck.min.js') !!}
{!! Html::script('st-admin/vendors/select2/dist/js/select2.full.min.js') !!}
{!! Html::script('st-admin/vendors/starrr/dist/starrr.js') !!}
{!! Html::script('st-admin/vendors/raphael/raphael.min.js') !!}
{!! Html::script('st-admin/vendors/morris.js/morris.min.js') !!}
{!! Html::script('st-admin/js/bootstrap-notify.min.js') !!}
{!! Html::script('st-admin/js/jquery.popupoverlay.js') !!}

{!! Html::script('st-admin/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') !!}
{!! Html::script('st-admin/vendors/jquery.hotkeys/jquery.hotkeys.js') !!}
{!! Html::script('st-admin/vendors/google-code-prettify/src/prettify.js') !!}

{!! Html::script('st-admin/js/bootbox.min.js') !!}
{!! Html::script('st-admin/js/sweetalert.min.js') !!}
{!! Html::script('st-admin/js/rebox.js') !!}
{!! Html::script('st-admin/vendors/jquery.tagsinput/src/jquery.tagsinput.js') !!}
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
{!! Html::script('st-admin/js/custom.min.js') !!}
{!! Html::script('st-admin/js/my-script.js') !!}
@yield('js_content')
<!-- Autosize -->
@yield('js_customer')
@yield('js_button')
@include('admin.blocks.notify.notify_notice')