@extends('frontend.frontend_master')
@section('contents')
    <div class="content-area">

        <!-- BREADCRUMBS -->
        <section class="page-section breadcrumbs">
            <div class="container">
                <div class="page-header">
                    <h1>Giới thiệu</h1>
                </div>
                <ul class="breadcrumb"></ul>
            </div>
        </section>
        <section class="page-section color">
            <div class="container black-text">
                {!! $content !!}
                <hr class="page-divider"/>
            </div>
        </section>
        @include('frontend.blocks.box.top-seller-new')
    </div>
@stop