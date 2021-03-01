<header class="header">
    <div class="header__container">
        <div class="header__left">
            <button type="button" class="hamburger-menu js-hamburger-menu"><i class="ico-hamburger-menu"></i></button>
            <span class="">{{ \Auth::guard('vendor')->user()->getUserName() }}</span> 님 환영합니다.
        </div>
        <div class="header__right">
            <a href="{{ route('vendor.auth.logout') }}">로그아웃</a>
        </div>
    </div>
</header>