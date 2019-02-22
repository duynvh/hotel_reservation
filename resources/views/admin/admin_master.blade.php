<!DOCTYPE html>
<html lang="en-us">
    <head>
        @include('admin.skins.meta')
        @include('admin.skins.styleSheet')
    </head>
    <body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- END NAVIGATION -->
        @include('admin.layouts.sidebar')

        <!-- MAIN PANEL -->
            <div class="right_col" role="main">
                <?php $nameRoute = Request::route()->getName();?>
                @yield('breadcrumbs_no_url')
                @yield('content')
            </div>

            <footer><!-- footer content -->
                <div class="pull-right">Administrator - Bản quyền của Nguyễn Võ Hoàng Duy </div>
                <div class="clearfix"></div>
            </footer> <!-- /footer content -->
        </div> <!-- main_container -->
    </div> <!-- container body -->
    @include('admin.skins.javaScript')

    @yield('content-after-javascript')
    </body>
</html>