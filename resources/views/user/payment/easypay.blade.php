@extends('user.include.app')

@section('main')

    <div class="cart">
        <div class="cart__row">
            <div class="cart__header">
                <div class="cart__header-left">
                    <p class="cart__header-text">주문 정보</p>
                </div>
            </div>
            <div class="cart__body">
                <div class="cart-order__count">
                    <p class="cart-order__count-text">주문 메뉴 수</p>
                    <div class="cart-order__count-value">{{ $count }}</div>
                </div>
                <div class="cart-order__count">
                    <p class="cart-order__count-text">총 결제 금액</p>
                    <div class="cart-order__count-value" v-text="priceFormat({{ $price }})"></div>
                </div>
            </div>
        </div>

        <div class="card-info">
            <div class="card-info__row">
                <div class="card-info__title"><span>카드 유형</span></div>
                <div class="card-info__content">
                    <input type="radio" name="cardtype" id="person" @click="cardType = 'person'" checked/>
                    <label for="person">개인</label>
                    <input type="radio" name="cardtype" id="company" @click="cardType = 'company'"/>
                    <label for="company">법인</label>
                </div>
            </div>
            <div class="card-info__row">
                <div class="card-info__title"><span>카드번호</span></div>
                <div class="card-info__content"><input type="text" v-model="cardName" pattern="[0-9]*" size="20" maxlength="16" inputmode="numeric" class="card-info__input"></div>
            </div>
            <div class="card-info__row">
                <div class="card-info__title"><span>유효기간 (월/년)</span></div>
                <div class="card-info__content">
                    <input id="exp_month" v-model="exp_month" type="text"  pattern="[0-9]*" size="2" maxlength="2/" class="card-info__input--half"> &nbsp;/
                    <input id="exp_year" v-model="exp_year" type="text" pattern="[0-9]*" size="2" maxlength="2/" class="card-info__input--half">
                </div>
            </div>
            <div class="card-info__row installments">
                <div class="card-info__title"><span>할부</span></div>
                <div class="card-info__content">
                    <select name="installment" @change="checkInstallment">
                        <option value="" selected>일시불</option>
                        <option value="2">2개월</option>
                        <option value="3">3개월</option>
                        <option value="4">4개월</option>
                        <option value="5">5개월</option>
                        <option value="6">6개월</option>
                        <option value="7">7개월</option>
                        <option value="8">8개월</option>
                        <option value="9">9개월</option>
                        <option value="10">10개월</option>
                        <option value="11">11개월</option>
                        <option value="12">12개월</option>
                    </select>
                </div>
            </div>
            <div class="card-info__row" v-if="cardType == 'person'">
                <div class="card-info__title"><span id="birth_text">주민번호</span></div>
                <div class="card-info__content">
                    <input id="birth" v-model="birth" type="text" pattern="[0-9]*" size="6" maxlength="6" class="card-info__input--half"><span id="birth_back">&nbsp;-&nbsp;●●●●●●●</span>
                </div>
            </div>
            <div class="card-info__row" v-else>
                <div class="card-info__title"><span id="birth_text">사업자등록번호</span></div>
                <div class="card-info__content">
                    <input id="birth" v-model="birth" type="text" pattern="[0-9]*" size="10" maxlength="10" class="card-info__input--half">
                </div>
            </div>
            <div class="card-info__row card_pw">
                <div class="card-info__title"><span>비밀번호 앞 두자리</span></div>
                <div class="card-info__content">
                    <input id="passwd" type="password" v-model="passwd"  pattern="[0-9]*" size="4" maxlength="2" class="card-info__input--half"><span>●●</span>
                </div>
            </div>
            <div class="menu-detail">
                <div class="order__action-list">
                    <button type="button" class="order__action-item order__action-item--cart" @click="ok">확인</button>
                    <button type="button" class="order__action-item order__action-item--sell" @click="cancel">취소</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('bottom_scripts')
    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    cardType: 'person',
                    cardName: '',
                    exp_month: '',
                    exp_year: '',
                    birth: '',
                    passwd: ''
                };
            },
            components: {
            },
            created() {
            },
            computed: {

            },
            mounted(){

            },
            methods: {
                priceFormat(number) {
                    return new Intl.NumberFormat('ko-KR', { maximumSignificantDigits: 3 }).format(number) + '원';
                },
                cancel() {
                    // window.location = document.referrer
                },
                ok() {

                    if (this.cardName == '') {
                        alert('카드 번호를 입력해주세요.');
                        return;
                    }

                    if (this.exp_month == '') {
                        alert('유효기간(월)을 입력해주세요.');
                        return;
                    }

                    if (this.exp_year == '') {
                        alert('유효기간(년)을 입력해주세요.');
                        return;
                    }

                    if (this.birth == '') {
                        if (this.cardType == 'person') {
                            alert('주민번호를 입력해주세요.');
                        } else {
                            alert('사업자등록번호를 입력해주세요.');
                        }
                        return;
                    }

                    if (this.passwd == '') {
                        alert('비밀번호를 입력해주세요.');
                        return;
                    }

                    let form = new FormData()
                    form.append('order_no', '{{ $order_no }}');
                    form.append('vendor_id', '{{ $vendor->id }}');
                    form.append('store_id', '{{ $store_id }}');
                    form.append('currency_type', '{{ $currency_type }}');
                    form.append('order_number', '{{ $order_number }}');
                    form.append('interest_type', '{{ $interest_type }}');
                    form.append('count', '{{ $count }}');
                    form.append('amount', '{{ $amount }}');
                    form.append('good_name', '{{ $good_name }}');
                    form.append('order_name', '{{ $order_name }}');
                    form.append('email', '{{ $email }}');
                    form.append('phone_no', '{{ $phone_no }}');
                    form.append('card_type', this.cardType);
                    form.append('card_name', this.cardName);
                    form.append('exp_month', this.exp_month);
                    form.append('exp_year', this.exp_year);
                    form.append('birth', this.birth);
                    form.append('passwd', this.passwd);

                    let app = this;
                    axios.post("{{ route('api.v1.vendor.payment.easypay') }}", form)
                        .then(function (response) {

                            app.tmpSuccess(response.data.order_no);
                        })
                        .catch(function (response) {
                            console.log(response);
                        });
                },
                checkInstallment() {
                },
                tmpSuccess(order_no) {

                    let form = new FormData()
                    form.append('vendor_id', this.vendorId);
                    form.append('order_no', order_no);

                    let app = this;
                    axios.post("{{ route('api.v1.vendor.payment.success') }}", form)
                        .then(function (response) {

                            location.href = "/{{ $vendor->id }}" + '/payment/invoice/' + order_no;
                        })
                        .catch(function (response) {
                            console.log(response);
                        });
                },
            }
        });
    </script>
@endsection