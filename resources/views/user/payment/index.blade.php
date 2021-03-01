@extends('user.include.app')

@section('main')

    <div class="cart">
        <template v-if="payType == 'card_auth_pay'">
            <form name=KSPayWeb  ref="form" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="sndStoreid"          value="2999199999"> <!-- dev : 2999199999, prod : 2557200003 -->
                <input type="hidden" name="sndCurrencytype"     value="WON" size=30 maxlength=3 >
                <input type="hidden" name="sndOrdernumber"      :value="order.dpt_code" size=30 maxlength=30 >
                <input type="hidden" name="sndInstallmenttype"  value="0:2:3:4:5:6:7:8:9:10:11:12" size=30 maxlength=30 >
                <input type="hidden" name="sndInteresttype"     value="NONE" size=30 maxlength=30 >
                <input type="hidden" name="sndReply"            value="{{ route('user.payment.card.kspay_wh_rcv', ['id' => $vendor->id]) }}">       <!-- Callback URL -->
                <input type="hidden" name="sndPaymethod"        value="1000000000" class="sndPaymethod">
                <input type="hidden" name="sndStoreName"        value="{{ env('APP_NAME') }}">
                <input type="hidden" name="sndStoreNameEng"     value="{{ env('APP_NAME_EN') }}">
                <input type="hidden" name="sndStoreDomain"      value="{{ env('APP_URL') }}">
                <input type="hidden" name="sndRtApp"            value="">
                <input type="hidden" name="sndAllregid"         value="" size=30 maxlength=13>
                <input type="hidden" name="sndEscrow"           value="0">                                          <!--에스크로적용여부-- 0: 적용안함, 1: 적용함 -->
                <input type="hidden" name="sndShowcard"         value="I,M" size=30 maxlength=30>
                <input type="hidden" name="sndGoodname"         :value="order.no" size=30 maxlength=30 >
                <input type="hidden" name="sndAmount"           :value='order.price' size=30 maxlength=9>
                <input type="hidden" name="sndVirExpDt"         value="">                                           <!-- 마감일시 -->
                <input type="hidden" name="sndVirExpTm"         value="">                                           <!-- 마감시간 -->
                <input type="hidden" name="sndGoodType"         value="1">                                          <!--실물(1) / 디지털(2) -->
                <input type="hidden" name="sndUseBonusPoint"    value="">                                           <!-- 포인트거래시 60 -->
                <input type="hidden" name="sndOrdername"        :value="order.name">
                <input type="hidden" name="sndEmail"            :value="order.email">
                <input type="hidden" name="sndMobile"           :value="order.tel">
                <input type="hidden" name="table_no"            :value="order.tableNo">
                <input type="hidden" name="address"             :value="order.address">
                <input type="hidden" name="vendor_id"           :value="vendorId">
                <input type="hidden" name="order_no"             :value="order.no">
                <input type="hidden" name="reCommConId"         value="">   <!-- 결과데이타: 승인이후 자동으로 채워집니다. (*변수명을 변경하지 마세요) -->
                <input type="hidden" name="reCommType"          value="">   <!-- 결과데이타: 승인이후 자동으로 채워집니다. (*변수명을 변경하지 마세요) -->
                <input type="hidden" name="reHash"              value="">   <!-- 결과데이타: 승인이후 자동으로 채워집니다. (*변수명을 변경하지 마세요) -->
            </form>
        </template>
        <template v-else-if="payType == 'card_safe_pay'">
            <form ref="form" method="post" action="{{ route('user.payment.easy_pay', ['vendor' => $vendor->id]) }}">
                {{ csrf_field() }}
                <input type="hidden" name="storeid"             value="2999199999" maxlength="10">
                <input type="hidden" name="currencytype"        value="WON">
                <input type="hidden" name="ordernumber"         :value="order.dpt_code" maxlength="50">
                <input type="hidden" name="interesttype"        value="NONE" maxlength="25">
                <input type="hidden" name="count"               :value="order.count">
                <input type="hidden" name="amount"              :value="order.price" maxlength="9">
                <input type="hidden" name="goodname"            :value="order.no" maxlength="25">
                <input type="hidden" name="ordername"           :value="order.name" maxlength="25">
                <input type="hidden" name="email"               :value="order.email" maxlength="25">
                <input type="hidden" name="phoneno"             :value="order.tel" maxlength="25">
                <input type="hidden" name="table_no"            :value="order.tableNo">
                <input type="hidden" name="address"             :value="order.address">
                <input type="hidden" name="vendor_id"           :value="vendorId">
                <input type="hidden" name="order_no"            :value="order.no">
            </form>
        </template>

            <div class="cart__row">
                <div class="cart__header">
                    <div class="cart__header-left">
                        <p class="cart__header-text">주문정보</p>
                    </div>
                </div>
                <div class="cart__body">
                    <ul class="cart__list">
                        <li class="cart__item" v-for="(_items , index) in order.items">
                            @if ($vendor->id == 1)
                                <div class="cart__photo"><img src="/img/sample_americano.png"></div>
                            @else
                                <div class="cart__photo"><img src="/img/sample-menu-007.jpg"></div>
                            @endif
                            <div class="cart__content">
                                <div class="cart__content-header">
                                    <p class="cart__content-title" v-text="_items.info.title"></p>
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
                        <p class="cart-order__count-text">총 주문 수</p>
                        <div class="cart-order__count-value">
                            <p v-text="order.count"></p>
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

            @if ($order_type == 'receive')
            <div class="cart__row">
                <div class="cart__header">
                    <div class="cart__header-left">
                        <p class="cart__header-text">주문자 정보</p>
                    </div>
                </div>
                <div class="cart__body">
                    <div class="cart-order__count">
                        <p class="cart-order__count-text">테이블 번호</p>
                        <div class="cart-order__count-value">
                            <input type="text" placeholder="테이블 번호를 입력하세요" class="popup-table__input" v-model="order.tableNo">
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="cart__row">
                <div class="cart__header">
                    <div class="cart__header-left">
                        <p class="cart__header-text">주문자 정보</p>
                    </div>
                </div>
                <div class="cart__body">
                    <div class="cart-order__count">
                        <p class="cart-order__count-text">주문자명</p>
                        <div class="cart-order__count-value">
                            <input type="text" placeholder="이름 입력하세요" class="popup-table__input" v-model="order.name">
                        </div>
                    </div>
                    <div class="cart-order__count">
                        <p class="cart-order__count-text">이메일</p>
                        <div class="cart-order__count-value">
                            <input type="email" placeholder="이메일 입력하세요" class="popup-table__input" v-model="order.email">
                        </div>
                    </div>
                    <div class="cart-order__count">
                        <p class="cart-order__count-text">전화번호</p>
                        <div class="cart-order__count-value">
                            <input type="text" placeholder="(-)없이 전화번호를 입력하세요" class="popup-table__input" v-model="order.tel" :keyup="formatPhone()">
                        </div>
                    </div>
                    <div class="cart-order__count">
                        <p class="cart-order__count-text">주소</p>
                        <div class="cart-order__count-value">
                            <input type="text" placeholder="주소를 입력하세요" class="popup-table__input" v-model="order.address">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="cart__row">
                <div class="cart__header">
                    <div class="cart__header-left">
                        <p class="cart__header-text">유의사항</p>
                    </div>
                </div>
                <div class="cart__body">
                    <p class="order-detail__notice-description">주문상태가 상품준비중일 경우 주문취소가 불가능하며, 주문상품의 하자 등 사유가 발생하였을 경우 고객센터를 통해 주문취소 신청을 하실 수 있으시며, 카드 및 휴대폰 결제의 승인취소는 카드사 및 통신사의 사정에 따라 2~3일 및 그 이상의 시일이 다소 소요될 수 있습니다.<br>(단, 휴대폰 결제의 경우 결제월과 취소월이 다른 경우에는 결제취소가 불가능합니다.)</p>
                </div>
            </div>
            <div class="cart__row pt-10">
                <label class="input-field__group">
                    <input type="checkbox" name="report-option" v-model="isAgree" id="report-other">
                    <span class="order__option-different"><strong class="order__option-different--red">주문하실 상품 및 결제 정보를 확인</strong>하였으며 이에 동의합니다</span>
                </label>
                <div class="purchase-btn__list pt-10">
                    <button type="button" class="purchase-btn__item" @click="purchase('card_auth_pay')">카드 안전 결제</button>
                    <button type="button" class="purchase-btn__item" @click="purchase('card_safe_pay')">카드 인증 결제</button>
                    <button type="button" class="purchase-btn__item" @click="purchase('naver_pay')">N Pay</button>
                    <button type="button" class="purchase-btn__item" @click="purchase('kakao_pay')">Kakao Pay</button>
                </div>
            </div>
    </div>

@endsection

@section('bottom_scripts')
    <script language="javascript">
        function goResult(rcid, rctype, rhash){
            document.KSPayWeb.target            = "";
            document.KSPayWeb.action            = "{{ route('user.payment.card.ksnetCallback', ['id' => $vendor->id]) }}";
            document.KSPayWeb.reCommConId.value = rcid;
            document.KSPayWeb.reCommType.value  = rctype;
            document.KSPayWeb.reHash.value 	    = rhash;
            document.KSPayWeb.submit();
        }
    </script>

    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    isAgree: false,
                    vendorId: '{{ $vendor->id }}',
                    payType: '',
                    order: {
                        no: '',
                        dpt_code: 'KP1607121Y',
                        type: '{{ $order_type }}',
                        count: '{{ $order_count }}',
                        items: JSON.parse('{!! json_encode($order_items) !!}'),
                        price: '{{ $order_price }}',
                        tableNo: '',
                        name: "{{ $order_type == 'receive' ? $vendor->company : '' }}",
                        email: "{{ $order_type == 'receive' ? $vendor->email : '' }}",
                        tel: "{{ $order_type == 'receive' ? '000-000-0000' : '' }}",
                        address: '1',
                    },
                };
            },
            components: {
            },
            created() {
                this.options = this.rawOptions;
            },
            computed: {

            },
            mounted(){

            },
            methods: {
                purchase(type) {
                    if (!this.isAgree) {
                        alert('결제정보 확인에 동의하셔야 결제가 가능합니다');
                        return;
                    }

                    if (this.order.type == 'delivery')  {

                        if (this.order.name == '') {
                            alert('주문자명을 입력해주세요.');
                            return;
                        }

                        if (this.order.tel == '') {
                            alert('전화번호를 입력해주세요.');
                            return;
                        }

                    } else {
                        if (this.order.tableNo == '') {
                            alert('테이블 번호를 입력해주세요.');
                            return;
                        }
                    }

                    let form = new FormData()
                    form.append('order_type', this.order.type);
                    form.append('vendor_id', this.vendorId);
                    form.append('pay_type', type);
                    form.append('name', this.order.name);
                    form.append('email', this.order.email);
                    form.append('tel', this.order.tel);
                    form.append('address', this.order.address);
                    form.append('table_no', this.order.tableNo);
                    form.append('price', this.order.price);
                    form.append('items', JSON.stringify(this.order.items));

                    this.payType = type;

                    let app = this;
                    axios.post("{{ route('api.v1.vendor.payment.store') }}", form)
                        .then(function (response) {
                            if (response.status == 201) {
                                app.order.no = response.data.order_no

                                if (type == 'card_auth_pay') {
                                    // PC 용
                                    var width_	= 500;
                                    var height_	= 568;
                                    var left_	= screen.width;
                                    var top_	= screen.height;

                                    left_ = left_/2 - (width_/2);
                                    top_ = top_/2 - (height_/2);

                                    var op = window.open('about:blank','AuthFrmUp',
                                        'height='+height_+',width='+width_+',status=yes,scrollbars=no,resizable=no,left='+left_+',top='+top_+'');

                                    if (op == null)
                                    {
                                        alert("팝업이 차단되어 결제를 진행할 수 없습니다.");
                                        return false;
                                    }

                                    app.$refs.form.target = 'AuthFrmUp';
                                    @if (Browser::isDesktop())
                                        app.$refs.form.action ='https://kspay.ksnet.to/store/KSPayFlashV1.3/KSPayPWeb.jsp?sndCharSet=utf-8';
                                    @else
                                        app.$refs.form.action ='http://kspay.ksnet.to/store/mb2/KSPayPWeb_utf8.jsp';
                                    @endif

                                    app.$refs.form.submit();
                                } else {
                                    app.$refs.form.submit();
                                }
                            } else {
                                console.log(response);
                            }
                        })
                        .catch(function (response) {
                            console.log(response);
                        });
                },
                currentPrice(price) {
                    return this.priceFormat(price);
                },
                totalPrice() {
                    return this.priceFormat({{ $order_price }});
                },
                priceFormat(number) {
                    return new Intl.NumberFormat('ko-KR', { maximumSignificantDigits: 3 }).format(number) + '원';
                },
                formatPhone() {
                    var tel = this.order.tel;
                    var number = tel.replace(/[^0-9]/g, "");

                    var length = (number.substring(0, 2).indexOf('02') == 0) ? 10 : 11;
                    this.order.tel = number.substr(0, Math.min(number.length, length)).replace(/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/,"$1-$2-$3");
                }
            }
        });
    </script>
@endsection