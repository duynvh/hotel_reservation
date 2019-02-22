<!-- widget search -->
<div class="widget">
    <div class="widget-search">
        <form action="{{ url('tim-kiem.html') }}" method="get">
            <input class="form-control" name="q" type="text" placeholder="Nhập từ khóa">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>
<!-- /widget search -->
<!-- widget shop categories -->
<div class="widget shop-categories">
    <h4 class="widget-title text-center">Danh mục sản phẩm</h4>
    <div class="widget-content">
        <ul>
            @foreach($categoriesProduct as $key => $value)
                <li><a href="{{ url('/'.$value->slug.'-'.$value->id.'.html') }}">- {{ $value->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
{{--<div class="widget widget-filter-price">--}}
{{--<h4 class="widget-title">Price</h4>--}}
{{--<div class="widget-content">--}}
{{--<div id="slider-range"></div>--}}
{{--<input type="text" id="amount" readonly/>--}}
{{--<button class="btn btn-theme">Filter</button>--}}
{{--</div>--}}
{{--</div>--}}
@include('frontend.blocks.partial.tab_product_sidebar')