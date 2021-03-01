<!doctype html>
<html>
<head>
    {{-- 헤드 영역 --}}
    @include('user.include.head')

    {{-- 추가 스타일 영역(디버그용) --}}
    @yield('custom_style')
</head>
<body>
    <div id="wrap">
        {{-- 메인 영역 --}}
        <main class="main">
            <div class="main__container">
                @yield('main')
            </div>
        </main>

        {{-- 하단 영역 --}}
        @include('user.include.footer-service')
    </div>

    {{-- 스크립트 영역 --}}
    @include('user.include.script')

    {{-- 추가 스크립트 영역 --}}
    @yield('bottom_scripts')
</body>
</html>
