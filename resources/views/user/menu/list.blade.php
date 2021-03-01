@extends('user.include.app')

@section('main')

    <div class="vendor">
        <p class="vendor__info">{{ $vendor->introduce }}</p>
        <div class="vendor__hero">
            <div class="swiper-container">
                <swiper :options="swiperOption" class="swiper-wrapper vendor__hero-list">
                    @if ($vendor->id == 1)
                    <swiper-slide class="swiper-slide vendor__hero-item">
                        <img src="/img/sample-store-001.jpg" class="vendor__hero-img">
                    </swiper-slide>
                    <swiper-slide class="swiper-slide vendor__hero-item">
                        <img src="/img/sample-store-002.jpg" class="vendor__hero-img">
                    </swiper-slide>
                    @else
                    <swiper-slide class="swiper-slide vendor__hero-item">
                        <img src="/img/sample-store-003.jpg" class="vendor__hero-img">
                    </swiper-slide>
                    @endif
                    <div class="swiper-pagination swiper-pagination-bullets" slot="pagination"></div>
                </swiper>
            </div>
        </div>
        <div class="vendor__sns">
            <ul class="vendor__sns-list">
                @if ($vendor->sns())
                    <li class="vendor__sns-item">
                        <a href="{{ $vendor->sns() }}" target="_blank" rel="noopener" class="vendor__sns-link"><i class="ico-facebook"></i></a>
                    </li>
                @endif
                @if ($vendor->home_url)
                    <li class="vendor__sns-item">
                        <a href="{{ $vendor->home_url }}" target="_blank" rel="noopener" class="vendor__sns-link"><i class="ico-homepage"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    @foreach ($groups as $g_index => $group)
    <div class="menu">
        <div class="menu__header">
            <div class="menu__header-left">
                <p class="menu__header-text">{{ $group->title }}</p>
            </div>
{{--            <div class="menu__header-right">--}}
{{--                <button class="menu__header-button">--}}
{{--                    <i class="ico-menu-type-tile"></i>--}}
{{--                    <span>타일형</span>--}}
{{--                </button>--}}
{{--            </div>--}}
        </div>
        <div class="menu__body">
            <ul class="menu__list">
                @foreach ($group->menuItem as $index => $menu)
                <li class="menu__item">
                    <div class="menu__item-inner">
                        <a href="{{ route('user.menu.show', ['vendor' => $vendor->id, 'menu' => $menu->id]) }}">
                            @if ($vendor->id == 1)
                            <img src="/img/sample-menu-00{{$index + 1}}.jpg" class="menu__item-img">
                            @else
                            <img src="/img/sample-menu-007.jpg" class="menu__item-img">
                            @endif
                            <div class="menu__summary">
                                <p class="menu__summary-hot">best</p>
                                <p class="menu__summary-title">{{ $menu->title }}</p>
                                <p class="menu__summary-subtitle">{{ $menu->sub_title }}t</p>
                            </div>
                        </a>
                        <div class="quick-order">
                            <div class="quick-order__price">
                                <p>{{ number_format(round($menu->original_price)) }}원</p>
                            </div>
                            <div class="quick-order__count">
                                <div class="dropdown">
                                    <select class="dropdown-select" ref="{{ $index }}">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>
                                <button type="button" class="quick-order__count-cart" @click="cart({{ $index }}, {{ $menu->id }})">
                                    <i class="ico-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="menu__footer">
            <button class="menu__more" @click="more">더보기</button>
        </div>
    </div>
    @endforeach

@endsection

@section('bottom_scripts')
    <script>
        new Vue ({
            el: '#wrap',
            data() {
                return {
                    swiperOption: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                            renderBullet(index, className) {
                                return `<span class="${className} swiper-pagination-bullet-custom"></span>`
                            }
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        }
                    }
                };
            },
            methods: {
                more: function() {
                    alert('더보기');
                },
                cart(ref_id, menu_id) {
                    let select = this.$refs[ref_id];

                    if (select.value == 0) {
                        return;
                    }

                    let form = new FormData()
                    form.append('vendor_id', {{ $vendor->id }});
                    form.append('order_count', select.value);
                    form.append('menu_id', menu_id);

                    let app = this;
                    axios.post("{{ route('api.v1.vendor.cart.quick') }}", form)
                        .then(function (response) {

                            select.value = 0;
                            alert('장바구니에 추가했습니다');
                        })
                        .catch(function (response) {
                            console.log(response);
                        });
                }
            }
        });

    </script>
@endsection