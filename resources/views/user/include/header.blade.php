<header class="header">
    <div class="header__container">
        <div class="header__left">
            @if (\Route::currentRouteName() == 'user.menu.index')
                <a href="#" class="header__info"><i class="ico-info"></i></a>
            @elseif (\Route::currentRouteName() == 'user.payment.invoice')
                <a href="{{ route('user.menu.index', ['vendor' => $vendor->id]) }}" class="header__info"><i class="ico-back"></i></a>
            @else
                <a href="{{ url()->previous() }}" class="header__info"><i class="ico-back"></i></a>
            @endif
        </div>
        <div class="header__center">
            <a href="{{ route('user.menu.index', ['vendor' => $vendor->id]) }}" class="header__title">
                <h1 class="header__title-text">{{ $vendor->company }}</h1>
            </a>
        </div>
        <div class="header__right">
            <a href="{{ route('user.cart.index', ['vendor' => $vendor->id]) }}" class="header__cart"><i class="ico-cart"></i></a>
        </div>
    </div>
</header>

