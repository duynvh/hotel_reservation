<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.skins.meta')
    @include('frontend.skins.styleSheet')
</head>
<body id="home" class="wide">
<!-- PRELOADER -->
{{--<div id="preloader">--}}
    {{--<div id="preloader-status">--}}
        {{--<div class="spinner">--}}
            {{--<div class="rect1"></div>--}}
            {{--<div class="rect2"></div>--}}
            {{--<div class="rect3"></div>--}}
            {{--<div class="rect4"></div>--}}
            {{--<div class="rect5"></div>--}}
        {{--</div>--}}
        {{--<div id="preloader-title">Loading</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div class="wrapper">
    @include('frontend.layouts.popup_cart')
    @include('frontend.layouts.header_top')
    @include('frontend.layouts.header')
    @yield('contents')
    @include('frontend.layouts.footer')
    <div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=525321117947258&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@include('frontend.skins.javaScript')
</body>
</html>