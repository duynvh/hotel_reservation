<section class="page-section">
    <div class="container">
        <div class="row">
            @foreach($banner as $key => $value)
                <div class="col-md-6">
                    <div class="thumbnail no-border no-padding thumbnail-banner size-1x3">
                        <div class="media">
                            <a class="media-link" href="{{ $value->url }}">
                                <div class="img-bg"
                                     style="background-image: url('{{ asset('public/upload/images/banner/'.$value->image) }}')"></div>
                                <div class="caption">
                                    <div class="caption-wrapper div-table">
                                        <div class="caption-inner div-cell">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>