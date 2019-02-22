<!-- PAGE -->
<section class="page-section no-padding slider">
    <div class="container full-width">
        <div class="main-slider">
            <div class="owl-carousel" id="main-slider">
                @foreach($slider as $key => $value)
                    <div class="item slide1">
                        {{--1700x500--}}
                        <a href="#"><img class="slide-img"
                                        src="{{ asset('public/upload/images/banner/'.$value->image) }}"
                                        alt=""/></a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
<!-- /PAGE -->