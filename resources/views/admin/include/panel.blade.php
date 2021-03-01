    <div class="panel">
        <div class="panel__container">
            <div class="panel__header">
               <a href="{{ route('admin.dashboard.index') }}">
                   관리자용
               </a>
            </div>
            <nav class="panel__navigation">
                <ul>
                    <li class="menu01 arrow">
                        <a href="javascript:void(0);">점주</a>
                        <ul>
                            <li><a href="{{ route('admin.vendor.index') }}">점주</a></li>

                            @if (!empty(\Session::get('vendor_id')))
                            <li><a href="{{ route('admin.vendor.menu.index', ['vendor_id' => \Session::get('vendor_id')]) }}">메뉴</a></li>
                            <li><a href="{{ route('admin.vendor.menu.group.index', ['vendor_id' => \Session::get('vendor_id')]) }}">메뉴 그룹</a></li>
{{--                            <li><a href="{{ route('admin.vendor.menu.option.item.index', ['vendor_id' => \Session::get('vendor_id')]) }}">옵션</a></li>--}}
                            <li><a href="{{ route('admin.vendor.menu.option.index', ['vendor_id' => \Session::get('vendor_id')]) }}">옵션</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="menu02">
                        <a href="{{ route('admin.user.index') }}">회원</a>
                    </li>
                    <li class="menu03">
                        <a href="{{ route('admin.payment.index') }}">통계</a>
                    </li>
                    <li class="menu04 arrow">
                        <a href="javascript:void(0);">고객센터</a>
                        <ul>
                            <li><a href="{{ route('admin.article.group.index', ['type' => 'support']) }}">그룹</a></li>
                            <li><a href="{{ route('admin.support.single.index', ['type' => 'introduce']) }}">소개</a></li>
                            <li><a href="{{ route('admin.support.single.index', ['type' => 'terms']) }}">이용약관</a></li>
                            <li><a href="{{ route('admin.support.single.index', ['type' => 'privacy']) }}">개인정보취급방침</a></li>
                            <li><a href="{{ route('admin.support.multiple.index', ['type' => 'notice']) }}">공지사항</a></li>
                            <li><a href="{{ route('admin.support.multiple.index', ['type' => 'faq']) }}">도움말</a></li>
                        </ul>
                    </li>
                    @role('administrator|manager')
                    <li class="menu05">
                        <a href="{{ route('admin.manager.index') }}">관리자</a>
                    </li>
                    @endrole
                </ul>
            </nav>
        </div>
        <button type="button" class="panel--close js-hamburger-menu"><i class="ico-modal-close"></i></button>
    </div>
