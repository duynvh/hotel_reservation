<div class="widget widget-tabs alt">
    <div class="widget-content">
        <ul id="tabs" class="nav nav-justified">
            <li><a href="#tab-s1" data-toggle="tab">Xem nhiều</a></li>
            <li class="active"><a href="#tab-s2" data-toggle="tab">Mới nhất</a></li>
        </ul>
        <div class="tab-content">
            <!-- tab 1 -->
            <div class="tab-pane fade" id="tab-s1">
                <div class="recent-post">
                    @foreach($articleViewHigher as $key => $value)
                        <div class="media">
                            <a class="pull-left media-link" href="#">
                                <div class="image-s-small-frames">
                                    <img class="media-object"
                                         src="{{ asset('public/upload/images/article/'.$value->image) }}"
                                         alt="">
                                </div>
                            </a>
                            <div class="media-body">
                                <div class="media-meta">
                                    <i>{{ date('d/m/Y',strtotime($value->updated_at))}}</i>
                                </div>
                                <a href="{{ url('/bai-viet/'.$value->slug.'-'.$value->id.'.html') }}">
                                    <p class="media-heading title-product-2-line">{{ $value->name }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- tab 2 -->
            <div class="tab-pane fade in active" id="tab-s2">
                <div class="recent-post">
                    @foreach($articleNew as $key => $value)
                        <div class="media">
                            <a class="pull-left media-link" href="#">
                                <div class="image-s-small-frames">
                                    <img class="media-object"
                                         src=" {{ asset('public/upload/images/article/'.$value->image) }}"
                                         alt="">
                                </div>
                            </a>
                            <div class="media-body">
                                <div class="media-meta">
                                    <i>{{ date('d/m/Y',strtotime($value->updated_at))}}</i>
                                </div>
                                <a href="{{ url('/bai-viet/'.$value->slug.'-'.$value->id.'.html') }}">
                                    <p class="media-heading title-product-2-line">{{ $value->name }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</div>