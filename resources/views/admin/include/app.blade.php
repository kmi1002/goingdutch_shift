<!doctype html>
<html>
<head>
    {{-- 헤드 영역 --}}
    @include('admin.include.head')

    {{-- 추가 스타일 영역(디버그용) --}}
    @yield('custom_style')
</head>
<body>
    <div id="wrap">
        {{-- 패널 영역 --}}
        @include('admin.include.panel')
    
        {{-- 콘텐츠 영역 --}}
        <div class="content-wrap">
    
            {{-- 상단 영역 --}}
            @component('admin.components.view.header.header') @endcomponent
    
            {{-- 메인 영역 --}}
            <main class="main">
    
                {{-- 본문 영역 --}}
                @yield('main')
    
            </main>
    
            {{-- 하단 영역 --}}
            @include('admin.include.footer')
        </div>
    </div>

    {{-- 스크립트 영역 --}}
    @include('admin.include.script')

    {{-- 추가 스크립트 영역 --}}
    @yield('bottom_scripts')
</body>
</html>