@extends('user.include.app')

@section('main')

    <div class="menu">
        <form ref="form" method="post" action="{{ route('user.payment.ready', ['id' => $vendor->id]) }}">
            {{ csrf_field() }}
            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
            <input type="hidden" name="order_type" v-model="orderType">
            <input type="hidden" name="order_items" v-model="orderItems">
            <input type="hidden" name="order_price" v-model="orderPrice">
            <input type="hidden" name="type" value="menu">
            <div class="menu__row">
                <div class="menu__info">
                    <img src="/img/sample-menu-00{{ $menu['menu']->id }}.jpg" class="menu__info-img">
                    <p class="menu__info-title">{{ $menu['menu']->title }}</p>
                    <p class="menu__info-subtitle">{{ $menu['menu']->sub_title }}</p>
                    <p class="menu__info-description">{{ $menu['menu']->description }}</p>
                </div>
            </div>
{{--            @if ($menu['menu']->optionGroups->count() > 0)--}}
            <div class="menu__row">
                <div class="order__count">
                    <button type="button" class="order__count-minus" @click="countMinus">
                        <i class="ico-order-minus"></i>
                    </button>
                    <span class="order__count-number" v-text="orderCount"></span>
                    <button type="button" class="order__count-plus" @click="countPlus">
                        <i class="ico-order-plus"></i>
                    </button>
                </div>
            </div>
            <div class="menu__row">
                <div class="order__option">
                    <label class="input-field__group">
                        <input type="checkbox" name="report-option" v-model="isDifferent" id="report-other" @change="changeOption">
                        <span class="order__option-different">서로 다른 옵션으로 주문할 경우 선택해주세요</span>
                    </label>
                </div>
                <ul class="option__list" v-for="_item in items">
                    <li class="option__item" v-for="_item in _item.options">
                        <p class="option__item--title" v-text="_item.title"></p>
                        <div class="option__item--value">
                            <select v-model="_item.select">
                                <option v-for="_value in _item.values" :value="_value.id" v-text="_value.value"></option>
                            </select>
                        </div>
                    </li>
                </ul>
            </div>
{{--            @endif--}}
            <div class="menu__row">
                <div class="menu__notice">
                    <p class="menu__notice-title">공통설명 / 유의사항</p>
                    <p class="menu__notice-description">결제 취소는 업장에서 사장님 혹은 직원분께 신청하시면 됩니다.<br/>고잉더치는 결제정보의 중개서비스 또는 통신판매중개시스템의 제공자로서,<br/>통신판매의 당사자가 아니며, 주문 및 배송, 환불등과 관련한 의무와 책임은 각 영업점에 있습니다.</p>
                </div>
            </div>
            <div class="menu__row">
                <div class="order__price">
                    <p class="order__price-text">총 결제 금액</p>
                    <div class="order__price-value">
                        <p v-text="totalPrice()"></p>
                    </div>
                </div>
            </div>
            <div class="menu__row">
                <div class="order__action-list">
                    <button type="button" class="order__action-item order__action-item--cart" @click="cart">장바구니</button>
                    <button type="button" class="order__action-item order__action-item--sell" @click="sell">바로 주문</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Dialogs -->
    <user-menu-order-modal-select
            @select-order-type="selectOrderType">
    </user-menu-order-modal-select>

    <user-menu-cart-modal-select
            @select-cart-type="selectCartType">
    </user-menu-cart-modal-select>

@endsection

@section('bottom_scripts')
    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    menuId: '{{ $menu['menu']->id }}',
                    vendorId: '{{ $vendor->id }}',
                    orderType: '',
                    isDifferent: false,
                    orderCount: 1,
                    originalPrice: '{{ $menu['menu']->original_price }}',
                    discountPrice: '{{ $menu['menu']->discount_price }}',
                    discountPercent: '{{ $menu['menu']->discount_percent }}',
                    items: [],
                    orderItems: [],
                    orderPrice: 0
                };
            },
            components: {
            },
            created() {
                // Deep Copy는 JSON.parse('{!! json_encode($menu['items']) !!}')게~
                this.items.push(JSON.parse('{!! json_encode($menu['items']) !!}'));
            },
            computed: {
            },
            mounted(){

            },
            methods: {
                countPlus() {

                    this.orderCount = Math.min(this.orderCount + 1, 10);

                    if (this.isDifferent && this.items.length < 10) {
                        this.items.push(JSON.parse('{!! json_encode($menu['items']) !!}'));
                    }
                },
                countMinus() {
                    this.orderCount = Math.max(this.orderCount - 1, 1);

                    if (this.isDifferent && this.items.length > 1) {
                        this.items.pop();
                    }
                },
                cart() {
                    this.$modal.show('user-menu-cart-modal-select');
                },
                selectCartType(type) {

                    let retItems = [];
                    if (this.isDifferent) {
                        retItems = this.items;
                    } else {
                        for (var i = 0; i < this.orderCount; ++i) {
                            retItems.push(this.items[0]);
                        }
                    }

                    this.orderItems = JSON.stringify(retItems);

                    let form = new FormData()
                    form.append('vendor_id', this.vendorId);
                    form.append('items', this.orderItems);

                    let app = this;
                    axios.post("{{ route('api.v1.vendor.cart.store') }}", form)
                        .then(function (response) {


                            if (type == 'cart') {
                                location.href = "{{ route('user.cart.index', ['vendor' => $vendor->id]) }}";
                            } else {
                                location.href = "{{ route('user.menu.index', ['id' => $vendor->id]) }}";
                            }
                        })
                        .catch(function (response) {
                            console.log(response);
                        });
                },
                sell() {
                    this.$modal.show('user-menu-order-modal-select');
                },
                selectOrderType(type) {

                    this.orderType = type;

                    let retItems = [];
                    if (this.isDifferent) {
                        retItems = this.items;
                    } else {
                        for (var i = 0; i < this.orderCount; ++i) {
                            retItems.push(this.items[0]);
                        }
                    }

                    this.orderItems = JSON.stringify(retItems);


                    var app = this;
                    setTimeout(function () {
                        app.$refs.form.submit()
                    }, 500);
                },
                changeOption() {

                    this.options = [];

                    this.items = [];
                    let count = this.isDifferent ? this.orderCount : 1;
                    for (var i = 0; i < count; ++i) {
                        this.items.push(JSON.parse('{!! json_encode($menu['items']) !!}'));
                    }
                },
                totalPrice() {
                    this.orderPrice = this.orderCount * this.calcPrice(this.originalPrice, this.discountPrice, this.discountPercent);
                    return this.priceFormat(this.orderPrice);
                },
                priceFormat(number) {
                    return new Intl.NumberFormat('ko-KR', { maximumSignificantDigits: 3 }).format(number) + '원';
                },
                percentFormat(number) {
                    return number + '%';
                },
                calcPrice(original_price, discount_price, discount_percent) {
                    if (discount_price > 0 && discount_percent > 0) {
                        return '오류!!1';
                    }

                    if (discount_price > 0) {
                        if (original_price < discount_price) {
                            return '오류!!2';
                        }

                        return original_price - discount_price;
                    }

                    if (discount_percent > 0) {
                        let discount_price = original_price * (discount_percent / 100);
                        if (original_price < discount_price) {
                            return '오류!!3';
                        }

                        return original_price - discount_price;
                    }


                    return original_price;
                }
            }
        });
    </script>
@endsection