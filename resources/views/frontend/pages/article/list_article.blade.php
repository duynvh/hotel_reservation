@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Bài viết</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="#">Trang chủ</a></li>
                    <li class="active">Bài viết</li>
                </ul>
            </div>
        </section>
        <!-- /BREADCRUMBS -->

        <!-- PAGE WITH SIDEBAR -->
        <section class="page-section with-sidebar">
            <div class="container">
                <div class="row">
                    <!-- SIDEBAR -->
                    <aside class="col-md-3 sidebar" id="sidebar">
                        @include('frontend.blocks.box.sidebar_left_article')
                    </aside>
                    <!-- /SIDEBAR -->
                    <!-- CONTENT -->
                    <div class="col-md-9 content" id="content">
                        @if(count($articles) > 0)
                            @foreach($articles as $key => $value)
                                <article class="post-wrap">
                                    <div class="post-media">
                                        <a href="{{ url('/bai-viet/'.$value->slug.'-'.$value->id.'.html') }}"
                                           data-gal="prettyPhoto"><img
                                                    src="{{ asset('public/upload/images/article/' . $value->image) }}"
                                                    alt="{{ $value->name }}"></a>
                                    </div>
                                    <div class="post-header">
                                        <h2 class="post-title"><a href="#">{{ $value->name }}</a></h2>
                                        <div class="post-meta">
                                            Đăng ngày: {{ date('d/m/Y',strtotime($value->updated_at))}}
                                        </div>
                                    </div>
                                    <div class="post-body">
                                        <div class="post-excerpt">
                                            <p>
                                                {{ $value->description }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="post-footer">
                                        <span class="post-read-more"><a
                                                    href="{{ url('/bai-viet/'.$value->slug.'-'.$value->id.'.html') }}"
                                                    class="btn btn-theme btn-theme-transparent btn-icon-left"><i
                                                        class="fa fa-file-text-o"></i>Xem chi tiết</a></span>
                                    </div>
                                </article>
                            @endforeach
                                <div class="pagination-wrapper">
                                    <div class="div-pagination">
                                        {{ $articles->appends(request()->except('page'))->links() }}
                                    </div>
                                </div>
                        @else
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <h2 class="text-center"> Không có bài viết</h2>
                            </div>

                    @endif

                    <!-- Blog posts -->
                    </div>
                    <!-- /CONTENT -->

                </div>
            </div>
        </section>
        <!-- /PAGE WITH SIDEBAR -->

        @include('frontend.blocks.box.feture')

    </div>
@endsection