<?php
$total = $pagination->total();
if ($pagination->perPage() > $pagination->total()) {
    $totalItemsShow = $pagination->total();
} else {
    $totalItemsShow = $pagination->perPage();
}

$currentPage = $pagination->currentPage();
$lastPage = $pagination->lastPage();
?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Phân trang</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-6">
                        <p>Số lượng hiển thị trên trang:
                            <b>{{$currentPage}}</b> của
                            <span class="label label-success" style="font-size: 85%">{{$lastPage}} trang</span>
                        </p>
                        <p>
                            Đang hiển thị
                            <b>{{$totalItemsShow * ($currentPage - 1) + 1 }}</b> đến
                            <b> {{$totalItemsShow * $currentPage}} </b> của
                            <b> {{$total}}</b>
                            mục
                        </p>
                    </div>
                    <div class="col-sm-6 pull-right">
                        {!! $pagination->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
