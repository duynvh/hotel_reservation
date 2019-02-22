<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/admin/dashboard') }}" class="site_title"><i class="fa fa-paw"></i> <span>KBOX</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                {!! Html::image('upload/images/user/'.Auth::user()->image, 'me', array('class' =>'img-circle profile_img')) !!}
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo Auth::user()->name ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br/>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu menu_fixed">
                    <li>
                        <a href="{{ route('dashboard')  }}">
                            <i class="fa fa-home"></i>
                            Thống kê
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bill.index')  }}">
                            <i class="fa fa-shopping-cart"></i>
                            Đơn hàng
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.index')  }}">
                            <i class="fa fa-users"></i>
                            Khách hàng
                        </a>
                    </li>
                    <li class="{{ Active::checkRoute(['banner.*', 'coupon.*'], 'active', '') }}"><a><i
                                    class="fa fa-bars"></i> Quản lí nội dung <span
                                    class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu"
                            style="display: {{ Active::checkRoute(['banner.*', 'coupon.*'], 'block', 'none') }};">
                            <li class="{{ Active::checkRoute(['banner.*'], 'active', '') }}"><a
                                        href="{{ route('banner.index') }}">Banner</a></li>
                            <li class="{{ Active::checkRoute(['coupon.*'], 'active', '') }}"><a
                                        href="{{ route('coupon.index') }}">Mã khuyến mãi</a></li>
                            <li class="{{ Active::checkRoute(['partner.*'], 'active', '') }}"><a
                                        href="{{ route('partner.index') }}">Đối tác</a></li>
                        </ul>
                    </li>
                    <li class="{{ Active::checkRoute(['category-article.*', 'article.*'], 'active', '') }}"><a><i
                                    class="fa fa-newspaper-o"></i> Quản lí bài viết <span
                                    class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu"
                            style="display: {{ Active::checkRoute(['category-article.*', 'article.*'], 'block', 'none') }};">
                            <li class="{{ Active::checkRoute(['category-article.*'], 'active', '') }}"><a
                                        href="{{ route('category-article.index') }}">Danh mục</a></li>
                            <li class="{{ Active::checkRoute(['article.*'], 'active', '') }}"><a
                                        href="{{ route('article.index') }}">Bài viết</a></li>
                        </ul>
                    </li>
                    <li class="{{ Active::checkRoute(['attribute-config.*', 'category-product.*', 'product.index'], 'active', '') }}">
                        <a><i class="fa fa-book"></i> Quản lí sản phẩm <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu"
                            style="display: {{ Active::checkRoute(['attribute-config.*', 'category-product.*', 'product.index'], 'block', 'none') }};">
                            <li class="{{ Active::checkRoute(['category-product.*'], 'active', '') }}"><a
                                        href="{{ route('category-product.index') }}">Danh mục</a></li>
                            <li class="{{ Active::checkRoute(['product.*'], 'active', '') }}"><a
                                        href="{{ route('product.index') }}">Sản phẩm</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('mailbox.index')  }}">
                            <i class="fa fa-envelope"></i>
                            Quản lí hộp thư
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.index')  }}">
                            <i class="fa fa-user"></i>
                            Quản lí người dùng
                        </a>
                    </li>
                    <li><a><i class="fa fa-cog"></i> Cấu hình<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('seo-config.index') }}">SEO</a></li>
                            <li><a href="{{ route('social-config.index') }}">Social Media</a></li>
                            <li><a href="{{ route('contact-config.index') }}">Liên hệ</a></li>
                            <li><a href="{{ route('about-config.index') }}">Giới thiệu</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        {!! Html::image('upload/images/user/'.Auth::user()->image, 'me') !!}
                        <?php echo Auth::user()->name ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{ route('user.changeInfo') }}">Cập nhật thông tin</a></li>
                        <li><a href="{{ route('user.changePass') }}">Đổi mật khẩu</a></li>
                        <li><a href="{{route('admin.logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->