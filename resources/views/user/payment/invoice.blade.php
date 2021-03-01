@extends('user.include.app')

@section('custom_style')
    <style>
        .tmp_1 {
            position: relative;
        }

        .tmp_2 {
            position: absolute;
            top: 25px;
            font-size: 20px;
        }

        .tmp_3 {
            position: absolute;
            top: 80px;
            font-size: 40px;
        }

        .tmp_4 {
            position: absolute;
            top: 130px;
        }

        .temp_5 {
            text-align: center;
        }
    </style>
@endsection

@section('main')

    @if ($status == 'cancel')
        <div class="invoice">
            <div ref="printMe" style="width: 320px; margin: 0 auto; padding: 30px;">
                <div class="invoice__header">
                    <div class="invoice__section">
                        <p class="invoice__header--title">결제 실패</p>
                        <p class="invoice__header--description">000로 결제 실패하였습니다</p>
                    </div>
                </div>
{{--                <div class="invoice__body">--}}
{{--                    <div class="invoice__section">--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="invoice__addition menu-detail">
                    <div class="order__action-list">
                        <button type="button" class="order__action-item order__action-item--cart" @click="home">홈으로</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="invoice">
            <div ref="printMe" style="width: 320px; margin: 0 auto; padding: 30px;">
                <div class="invoice__header">
                    @if ($status == 'success')
                    <div class="invoice__section">
                        <p class="invoice__header--title">결제 완료</p>
                        <p class="invoice__header--description">주문 접수가 완료되었습니다.<br>메뉴가 완성되면 테이블의 진동벨로 알려드리겠습니다</p>
                    </div>
                    @else
                    <div class="invoice__section">
                        <p class="invoice__header--title">영수증</p>
                        <p class="invoice__header--description">현금(소득공제)</p>
                    </div>
                    @endif
                </div>
                <div class="invoice__body">
                    <div class="invoice__section">
                        <div class="invoice__row invoice__row--week">
                            <p>{{ $vendor->company }}</p>
                            <p>{{ $vendor->address }}</p>
                        </div>
                        <div class="invoice__row invoice__row--week">
                            <p>{{ $vendor->user->nick_name }}</p>
                            <p>전화번호 (지원하지 않음)</p>
                        </div>
                        <div class="invoice__row invoice__row--week">
                            <p>POS기기 번호 (지원하지 않음)</p>
                            <p>{{ $payment->created_at }}</p>
                        </div>
                    </div>
                    <div class="invoice__section">
                        <div class="invoice__row invoice__row--strong">
                            <p>{{ $payment->today_no }}</p>
                        </div>
                    </div>
                    <div class="invoice__section">
                        <div class="invoice__row">
                            <p style="margin-top: 5px">메뉴</p>
                            <div style="flex: 1; margin-left:15px">
                                @foreach ($payment->paymentItems as $item)
                                    <div>
                                        <div class="cart__content-header">
                                            <p class="cart__content-title">{{ $item->title }}</p>
                                        </div>
                                        <div class="cart__content-body">
                                            <p class="cart__content-options">{{ $item->optionString() }}</p>
                                            <p class="cart__content-price">{{ number_format(round($item->price)) }}원</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="invoice__section">
                        <div class="invoice__row">
                            <p>합계</p>
                            <p>-></p>
                            <p>{{ number_format(round($payment->price)) }}원</p>
                        </div>
                    </div>
                    <div class="invoice__section">
                        <div class="invoice__row invoice__row--middle">
                            <p>결제 금액</p>
                            <p>{{ number_format(round($payment->price)) }}원</p>
                        </div>
                        <div class="invoice__row">
                            <p>(부가세 포함)</p>
                            <p>{{ number_format(round($payment->price)) }}원</p>
                        </div>
                    </div>
                    <div class="invoice__section">
                        <div class="invoice__row">
                            <p>현금영수증 발급</p>
                            <p>전화번호 (지원하지 않음)</p>
                        </div>
                        <div class="invoice__row">
                            <p>승인금액</p>
                            <p>(잘 모르겠음. 지원하지 않음)</p>
                        </div>
                        <div class="invoice__row">
                            <p>승인번호</p>
                            <p>(잘 모르겠음. 지원하지 않음)</p>
                        </div>
                    </div>
                    @if ($status == 'success')
                    <div class="invoice__section">
                        <div class="invoice__row invoice__row--center">
                            <p>결제수단 변경은 구입하신 매장에서<br>전체쉬소/재결제로 가능하며, 반드시<br>구매영수증을 소지 하셔야 합니다.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="invoice__footer">
                <div class="invoice__section">
                    @if ($status == 'success')
                    <div class="invoice__row tmp_1">
                        <img src="/img/sample-coupon.png" @click="getEvent">
                        <p class="tmp_2">{{ $coupon['item']->title }}</p>
                        <p class="tmp_3">{{ $coupon['item']->discount() }}</p>
                        <p class="tmp_4">{{ $coupon['history']->expired_at }} 까지</p>
                    </div>
                    @else
                        <p class="temp_5">이미 쿠폰이 발급되었습니다.</p>
                    @endif
                </div>
            </div>
            <div class="invoice__addition menu-detail">
                <div class="order__action-list">
                    <button type="button" class="order__action-item order__action-item--cart" @click="home">홈으로</button>
                    <button type="button" class="order__action-item order__action-item--sell" @click="save">저장하기</button>
                </div>
            </div>

            <div v-if="output">
                <hr>
                <p style="text-align: center; font-size:16px">이미지를 저장하세요.</p>
                <img :src="output" style="display: block; width: 320px; margin: 0 auto;">
            </div>
        </div>
    @endif

@endsection

@section('bottom_scripts')
    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    output: null
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
                home() {
                    location.href = "{{ route('user.menu.index', ['vendor' => $vendor->id]) }}";
                },
                async save() {
                    try {
                        const el = this.$refs.printMe;
                        // add option type to get the image version
                        // if not provided the promise will return
                        // the canvas.
                        const options = {
                            type: 'dataURL',
                            width: 320,
                            // height: 1200
                        }

                        this.output = await this.$html2canvas(el, options);
                    }
                    catch (rejectedValue) {
                        // …
                    }
                },
                getEvent() {
                    alert('(테스트용)\n쿠폰을 발급 받았습니다.');
                },
            }
        });
    </script>

@endsection