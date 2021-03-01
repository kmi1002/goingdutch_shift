    <div class="panel">
        <div class="panel__header">
           <a href="{{ route('vendor.dashboard.index') }}">
               점주용
           </a>
        </div>
        <nav class="panel__navigation">
            <ul>
                <li class="menu01">
                    <a href="{{ route('vendor.vendor.show') }}">정보</a>
                </li>
                <li class="menu02">
                    <a href="{{ route('vendor.menu.index') }}">메뉴</a>
                </li>
                <li class="menu03">
                    <a href="{{ route('vendor.payment.index') }}">통계</a>
                </li>
{{--                <li class="menu04 arrow">--}}
{{--                    <a href="javascript:void(0);">고객센터</a>--}}
{{--                    <ul>--}}
{{--                        <li><a href="{{ route('vendor.article.group.index') }}">그룹</a></li>--}}
{{--                        <li><a href="{{ route('vendor.support.single.index', ['type' => 'introduce']) }}">소개</a></li>--}}
{{--                        <li><a href="{{ route('vendor.support.single.index', ['type' => 'terms']) }}">이용약관</a></li>--}}
{{--                        <li><a href="{{ route('vendor.support.single.index', ['type' => 'privacy']) }}">개인정보취급방침</a></li>--}}
{{--                        <li><a href="{{ route('vendor.support.multiple.index', ['type' => 'notice']) }}">공지사항</a></li>--}}
{{--                        <li><a href="{{ route('vendor.support.multiple.index', ['type' => 'faq']) }}">도움말</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                @role('vendor_administrator|vendor_manager')
                <li class="menu05">
                    <a href="{{ route('vendor.manager.index') }}">관리자</a>
                </li>
                @endrole
            </ul>
        </nav>
    </div>
