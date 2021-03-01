    <div class="panel">
        <div class="panel__container">
            <div class="panel__header">
               <a href="{{ route('vendor.dashboard.index') }}">
                   점주용
               </a>
            </div>
            <nav class="panel__navigation">
                <ul>
                    <li class="menu03">
                        <a href="{{ route('vendor.pos.prepare') }}">Web POS</a>
                    </li>
                    <li class="menu01">
                        <a href="{{ route('vendor.info.show') }}">정보</a>
                    </li>
                    <li class="menu02">
                        <a href="{{ route('vendor.menu.index') }}">기본 메뉴</a>
                    </li>
                    <li class="menu02">
                        <a href="{{ route('vendor.qr.index') }}">QR 메뉴</a>
                    </li>
                    <li class="menu03">
                        <a href="{{ route('vendor.payment.index') }}">통계</a>
                    </li>
                    @role('vendor_administrator|vendor_manager')
                    <li class="menu05">
                        <a href="{{ route('vendor.manager.index') }}">관리자</a>
                    </li>
                    @endrole
                </ul>
            </nav>
        </div>
        <button type="button" class="panel--close js-hamburger-menu"><i class="ico-modal-close"></i></button>
    </div>
