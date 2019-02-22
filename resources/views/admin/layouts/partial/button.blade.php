<div class="row">
    <div class="col-md-12">
        <div class="row text-center">
            @if(!empty($router_add))
                <a class="btn btn-app btn-fix-bg" href="{{$router_add}}"><i class="fa fa-plus-square-o"></i>Thêm</a>
            @endif

            <a data-status="update-active" class="update-status btn btn-app btn-fix-bg">
                <i class="fa fa-check-circle-o"></i> Kích hoạt
                <span class="badge bg-green btn-show-total">{{$total_active}}</span>
            </a>

            <a data-status="update-inactive" class="update-status btn btn-app btn-fix-bg">
                <i class="fa fa-circle-o"></i> Không kích hoạt
                <span class="badge bg-red btn-show-total">{{$total_inactive}}</span>
            </a>

            @if(!empty($router_add))
                <a id="delete-items" class="btn btn-app btn-fix-bg">
                    <i class="fa fa-minus-square-o"></i> Xoá
                    <span class="badge bg-green btn-show-total"></span>
                </a>
            @endif

            @if(!empty($router_send))
                <a id="send-items" class="btn btn-app btn-fix-bg">
                    <i class="fa fa-paper-plane"></i> Send
                    <span class="badge bg-green btn-show-total"></span>
                </a>
            @endif
            @can('admin')
                @if(isset($dataHidden) && count($dataHidden)>0)
                    @if(!empty($router_confirm))
                        <a style="color: red" class="btn btn-app btn-fix-bg" href="{{$router_confirm}}"><i
                                    style="color: red"
                                    class="fa fa-bullseye"></i>Kiểm duyệt</a>
                    @endif
                @endif
            @endcan
        </div>
    </div>
</div>

@section('js_button')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.update-status ').click(function () {
                var ids = [], is_check = false;
                $('input[name="table_records"]:checked').map(function (_, el) {
                    ids.push($(el).val());
                    is_check = true;
                }).get();

                if (is_check == false) {
                    bootbox.alert('<span class="msg-bootbox">Vui lòng chọn phần tử muốn thay đổi trạng thái!</span>');
                } else {
                    if ($(this).data('status') == 'update-active') {
                        changeStatusByIds(ids, 'to-active');
                    } else {
                        changeStatusByIds(ids, 'to-inactive');
                    }
                }
            })

            $('#delete-items').click(function () {
                var ids = [], is_check = false;
                $('input[name="table_records"]:checked').map(function (_, el) {
                    ids.push($(el).val());
                    is_check = true;
                }).get();

                if (is_check == false) {
                    bootbox.alert('<span class="msg-bootbox">Vui lòng chọn phần tử muốn xoá!</span>');
                } else {
                    deleteByIds(ids);
                }
            })
        });

        function changeStatusByIds(ids, type) {
            var statusString = (type == 'to-active') ? 'Kích hoạt' : 'Không kích hoạt';
            bootbox.confirm('Các phần tử đã chọn chuyển trạng thái sang <strong class="red">' + statusString + '</strong>?', function (result) {
                if (result) {
                    $.ajax({
                        url: "{{$router_status}}",
                        headers: {'X-CSRF-TOKEN': token},
                        data: {
                            ids: ids,
                            type: type
                        },
                        success: function (response) {
                            response = $.parseJSON(response);
                            if (response.status == 1) {
                                successMsg(response.msg);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                errorMsg(response.msg);
                            }
                        }
                    });
                }
            });
        }

        function deleteByIds(ids) {
            bootbox.confirm('Các phần tử đã chọn sẽ bị <strong class="red">Xoá</strong> khỏi hệ thống', function (result) {
                if (result) {
                    $.ajax({
                        url: "{{$router_delete}}",
                        headers: {'X-CSRF-TOKEN': token},
                        data: {
                            ids: ids
                        },
                        success: function (response) {
                            response = $.parseJSON(response);
                            if (response.status == 1) {
                                successMsg(response.msg);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                errorMsg(response.msg);
                            }
                        }
                    });
                }
            });
        }

        function moveNode(id, type, route) {
            const url = route == 'category-article' ? 'category-article/move-node' : 'category-product/move-node';
            bootbox.confirm('Các phần tử đã chọn sẽ bị <strong class="red">thay đổi vị trí</strong>', function (result) {
                if (result) {
                    $.ajax({
                        url: url,
                        headers: {'X-CSRF-TOKEN': token},
                        data: {
                            id: id,
                            type: type
                        },
                        success: function (response) {
                            response = $.parseJSON(response);
                            if (response.status == 1) {
                                successMsg(response.msg);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                errorMsg(response.msg);
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection