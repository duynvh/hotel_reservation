<div class="banner-area mt-55">
    <div class="container">
        <div class="row">
            @foreach($banner as $key => $value)
                <div class="col-md-6">
                    <div class="banner-inner mb-30">
                        <a href="{{ $value->url }}"><img src="{{ asset('public/upload/images/banner/'.$value->image) }}" alt=""></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>