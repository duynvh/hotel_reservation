<section class="page-section">
    <div class="container">
        <h2 class="section-title"><span>Hợp tác cùng</span></h2>
        <div class="partners-carousel">
            <div class="owl-carousel" id="partners">
                @foreach($partners as $key => $value)
                    <div><a href="#" class="padding-10"><img
                                    src="{{ asset('public/upload/images/partner/'.$value->image) }}"
                                    alt="{{$value->name}}"/></a></div>
                @endforeach
            </div>
        </div>
    </div>
</section>