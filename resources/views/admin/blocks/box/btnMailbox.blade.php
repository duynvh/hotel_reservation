<div class="col-sm-3 mail_list_column">
    <a href="{{ route('mailbox.viewSend') }}"><button  class="btn btn-sm btn-warning btn-block" type="button">Soạn thư
    </button></a>
    <ul class="nav nav-pills nav-stacked">
        <li class="">
            <a href="{{ route('mailbox.index') }}"><i class="fa fa-inbox"></i> Hộp thư
                <span class="label label-primary pull-right"></span>
            </a>
        </li>
        <li class=""><a href="{{ url('/admin/mailbox/trash') }}"><i class="fa fa-trash-o"></i>
                Thùng rác</a></li>
    </ul>
</div>
