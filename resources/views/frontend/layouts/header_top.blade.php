<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <ul class="list-inline">
                @if(Auth::guard('customer')->check())
                    <li class="icon-user"><a href="{{ url('/tai-khoan.html') }}"><img src="{{ asset('public/frontend/assets/img/icon-1.png') }}" alt=""/>
                        <span>Chào bạn: {{ Auth::guard('customer')->user()->name }}</span></a>
                    </li>
                @else
                    <li class="icon-user"><a href="/dang-nhap.html"><img src="{{ asset('public/frontend/assets/img/icon-1.png') }}" alt=""/>
                        <span>Đăng nhập</span></a>
                    </li>
                        @endif
                <li><i class="fa fa-phone"></i> <span>{{ $contactConfig->phone }}</span>
                </li>
                <li><a href="mailto:support@yourdomain.com"><i class="fa fa-envelope"></i> <span>{{ $contactConfig->email }}</span></a>
                </li>
            </ul>
        </div>
        <div class="top-bar-right">
            <ul class="list-inline">
                @if(Auth::guard('customer')->check())
                    <li class="icon-user"><a href="/doi-mat-khau.html"><img src="assets/img/icondoi-1.png" alt=""/>
                            <span>Đổi mật khẩu</span></a>
                    </li>
                    <li class="icon-user"><a href="/dang-xuat.html"><img src="assets/img/icon-1.png" alt=""/>
                        <span>Đăng xuất</span></a>
                    </li>
                @endif
                <li class="hidden-xs"><a href="san-pham-yeu-thich.html">Sản phẩm yêu thích</a></li>
            </ul>
        </div>
    </div>
</div>