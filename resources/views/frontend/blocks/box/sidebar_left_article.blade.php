
    <!-- /widget shop categories -->
    <div class="widget shop-categories">
        <h4 class="widget-title text-center">Danh mục bài viết</h4>
        <div class="widget-content">
            <ul>
                @foreach($categoriesArticle as $key => $value)
                    <li><a href="{{ url('/loai-bai-viet/'.$value->slug.'-'.$value->id.'.html') }}">- {{ $value->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- widget tabs -->
    @include('frontend.blocks.partial.tab_article_sidebar')
    <!-- /widget tabs -->
    <!-- widget tag cloud -->
    <div class="widget widget-tag-cloud">
        <h4 class="widget-title"><span></span></h4>
        <ul>

        </ul>
    </div>
    <!-- /widget tag cloud -->
