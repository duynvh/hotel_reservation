@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Chi tiết bài viết</h1>
                </div>
                <ul class="breadcrumb">
                    <li><a href="#">Trang chủ</a></li>
                    <li class="active">Chi tiết bài viết</li>
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

                        <!-- Blog post -->
                        <article class="post-wrap post-single">
                            <div class="post-media">
                                <a href="{{ asset('public/upload/images/article/' . $articleSingle->image) }}"
                                   data-gal="prettyPhoto"><img
                                            src="{{ asset('public/upload/images/article/' . $articleSingle->image) }}"
                                            alt="{{ $articleSingle->name }}"></a>
                            </div>
                            <div class="post-header">
                                <h2 class="post-title"><a href="#">{{ $articleSingle->name }}</a></h2>
                                <div class="post-meta">
                                    Ngày đăng: {{ date('d/m/Y',strtotime($articleSingle->updated_at)) }}
                                </div>
                            </div>
                            <div class="post-body">
                                <div class="post-excerpt">
                                    {!! $articleSingle->content !!}
                                </div>
                            </div>
                        </article>
                        <!-- /Blog post -->


                        <!-- PAGE -->
                        <section class="page-section no-padding-bottom">
                            <h4 class="block-title"><span>Bình luận </span></h4>
                            <!-- Comments -->
                            <div class="comments">
                                <div data-width="100%" class="fb-comments" data-href="{{ $url }}"
                                     data-numposts="5"></div>
                            </div>
                            <!-- /Comments -->
                        </section>
                        <!-- /PAGE -->

                    </div>
                    <!-- /CONTENT -->

                </div>
            </div>
        </section>
        <!-- /PAGE WITH SIDEBAR -->

        @include('frontend.blocks.box.feture')

    </div>
@endsection