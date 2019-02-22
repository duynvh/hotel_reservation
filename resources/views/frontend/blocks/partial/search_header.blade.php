<div class="col-md-9 col-lg-6 order-lg-2 order-1">
    <!--Header Top Search Start-->
    <div class="header-top-search">
        <div class="search-categories">
            {!! Form::open(['method' => 'GET' ,'class' => '111','id' => 'form' ,'url' => route('sanpham.search')]) !!}
            <div class="search-form-input">
                <input id="search" type="text" name="q" placeholder="Từ khóa tìm kiếm..." autocomplete="off">
                <button class="top-search-btn" type="submit"><i
                            class="ion-ios-search-strong"></i></button>
            </div>
            <div class="tt-menu">
                <div class="tt-dataset tt-dataset-search">
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!--Header Top Search End-->
</div>