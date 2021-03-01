<!DOCTYPE html>
<html lang="ko">
    <head>
        @include('user.include.head')
    </head>
    <body>
        <div class="wrap">
            <div class="error">
                <div class="error__container">
                    <p><img @yield('imageAttribute', '') alt="" title="" class="error__img"></p>
                    <h1 class="error__title">
                        @yield('h1Text', '')
                    </h1>
                    <h2 class="error__description">
                        @yield('h2Text', '')
                    </h2>
                    <div class="error__actions">
                        <a href="#" class="error__btn--red">홈으로</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>