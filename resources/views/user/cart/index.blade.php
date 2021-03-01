@extends('user.include.app')

@section('main')

    <div class="cart">
        <form ref="form"  method="post" action="{{ route('user.payment.ready', ['id' => $vendor->id]) }}">
            {{ csrf_field() }}
            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
            <input type="hidden" name="order_type" v-model="orderType">
            <input type="hidden" name="order_items" v-model="orderItems">
            <input type="hidden" name="order_price" v-model="orderPrice">

            <div class="cart__row">
                <div class="cart__header">
                    <div class="cart__header-left">
                        <p class="cart__header-text">주문정보</p>
                    </div>
                    <div class="cart__header-right">
                        <label for="cart-all" class="cart__header-checkbox">
                            <input type="checkbox" id="cart-all" checked @change="allChange" v-model="allCheck">
                            전체 선택
                        </label>
                    </div>
                </div>
                <div class="cart__body">
                    <ul class="cart__list">
                        <li class="cart__item" v-for="(_items , index) in order.items">
                            <input type="checkbox" v-model="selects[index]" class="cart__checkbox" @change="checkChange">
                            <div class="cart__photo">
                                <a :href="'/{{ $vendor->id }}/' + _items.info.id">
                                    <img src="/img/sample_americano.png">
                                </a>
                            </div>
                            <div class="cart__content">
                                <div class="cart__content-header">
                                    <a :href="'/{{ $vendor->id }}/' + _items.info.id">
                                        <p class="cart__content-title" v-text="_items.info.title"></p>
                                    </a>
                                    <button class="cart__content-delete" type="button" @click="deleteCart(index)"><i class="ico-close"></i></button>
                                </div>
                                <div class="cart__content-body">
                                    <p class="cart__content-options" v-text="_items.info.options"></p>
                                    <p class="cart__content-price" v-text="currentPrice(_items.info.price)"></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cart__row">
                <div class="cart__header">
                    <div class="cart__header-left">
                        <p class="cart__header-text">결제정보</p>
                    </div>
                </div>
                <div class="cart__body">
                    <div class="cart-order__count">
                        <p class="cart-order__count-text">총 주문메뉴</p>
                        <div class="cart-order__count-value">
                            <p v-text="orderCount"></p>
                        </div>
                    </div>
                    <div class="cart-order__price">
                        <p class="cart-order__price-text">총 결제 금액</p>
                        <div class="cart-order__price-value">
                            <p v-text="totalPrice()"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart__row">
                <div class="order__action-list">
                    <button type="button" class="order__action-item order__action-item--cart" @click="deleteCart1">삭제</button>
                    <button type="button" class="order__action-item order__action-item--sell" @click="sell">주문</button>
                </div>
            </div>
        </form>
    </div>


    <!-- Dialogs -->
    <user-menu-order-modal-select
            @select-order-type="selectOrderType">
    </user-menu-order-modal-select>

@endsection

@section('bottom_scripts')
    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    orderType: '',
                    orderPrice: '{{ $order_price }}',
                    orderCount: '{{ $order_count }}',
                    orderItems: [],
                    order: {
                        items: JSON.parse('{!! json_encode($order_items) !!}'),
                    },
                    selects: [],
                    allCheck: true
                };
            },
            components: {
            },
            created() {
                for (var i = 0; i < this.totalCount(); ++i) {
                    this.selects.push(true);
                }
            },
            computed: {

            },
            mounted(){

            },
            methods: {
                currentPrice(price) {
                    return this.priceFormat(price);
                },
                totalPrice() {
                    let tmpPrice = 0;
                    for (var i = 0; i < this.totalCount(); ++i) {
                        if (this.selects[i]) {
                            tmpPrice += this.order.items[i].info.price;
                        }
                    }

                    this.orderPrice = tmpPrice;
                    return this.priceFormat(this.orderPrice);
                },
                priceFormat(number) {
                    return new Intl.NumberFormat('ko-KR', { maximumSignificantDigits: 3 }).format(number) + '원';
                },
                options() {

                },
                deleteCart(index) {
                    let item = this.order.items[index];


                    if (confirm(item.info.title + ' 메뉴를 삭제하시겠습니까?')) {
                        let app = this;

                        axios.delete('/api/vendor/cart/' + item.id)
                            .then(function (response) {
                                location.href = '?';
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                    }
                },
                totalCount() {
                    return this.order.items.length;
                },
                selectCount() {
                    this.orderCount = 0;
                    for (var i = 0; i < this.totalCount(); ++i) {
                        if (this.selects[i]) {
                            this.orderCount++;
                        }
                    }

                    if (this.orderCount == this.totalCount()) {
                        this.allCheck = true;
                    } else {
                        this.allCheck = false;
                    }
                },
                sell() {
                    if (this.totalCount() == 0) {
                        alert('주문할 메뉴가 없습니다.');
                        return;
                    }

                    if (this.orderCount == 0) {
                        alert('메뉴를 선택해주세요');
                        return;
                    }


                    this.$modal.show('user-menu-order-modal-select');
                },
                selectOrderType(type) {
                    this.orderType = type;

                    var ret = [];
                    for (var i = 0; i < this.totalCount(); ++i) {
                        if (this.selects[i]) {
                            ret.push(this.order.items[i]);
                        }
                    }

                    this.orderItems = JSON.stringify(ret);

                    var app = this;
                    setTimeout(function () {
                        app.$refs.form.submit()
                    }, 500);
                },
                allChange() {
                    for (var i = 0; i < this.totalCount(); ++i) {
                        this.selects[i] = this.allCheck;
                    }

                    this.selectCount();
                    this.totalPrice();
                },
                checkChange() {
                    this.selectCount();
                    this.totalPrice();
                },
                deleteCart1() {
                    if (this.totalCount() == 0) {
                        alert('삭제할 메뉴가 없습니다.');
                        return;
                    }

                    var tmpSelect = [];
                    var tmpIndex = -1;
                    for (var i = 0; i < this.totalCount(); ++i) {
                        if (this.selects[i]) {
                            tmpSelect.push(this.order.items[i].id);

                            if (tmpIndex < 0) {
                                tmpIndex = i;
                            }
                        }
                    }

                    let count = tmpSelect.length;
                    if (count == 1) {
                        this.deleteCart(tmpIndex);
                    } else {

                        let tmp = this.order.items[tmpIndex].info.title;

                        let aaa = tmp + ' 포함 (' + count + ')' + '개의 메뉴를 삭제하시겠습니까?';

                        if (confirm(aaa)) {
                            let app = this;

                            axios.post('/api/vendor/cart/all', { ids: tmpSelect })
                                .then(function (response) {

                                    location.href = '?';
                                })
                                .catch(function (response) {
                                    console.log(response);
                                });
                        }
                    }
                }

            }
        });
    </script>
@endsection