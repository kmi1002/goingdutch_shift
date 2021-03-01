@extends('vendor.include.app')

@section('main')

    <admin-title-box
            :show-calendar="false">
        <template slot="header">
            <span class="title-box__title">Web Pos</span>
        </template>
    </admin-title-box>

    <div class="table-box">
        <div class="table__responsive">
            <div  class="table__list">
                <ul class="tab" style="display: flex; justify-content: space-between;">
                    <li class="current" data-tab="tab1"><a href="{{ route('vendor.pos.prepare') }}">대기</a></li>
                    <li data-tab="tab2"><a href="{{ route('vendor.pos.approve') }}">승인</a></li>
                    <li data-tab="tab3"><a href="{{ route('vendor.pos.completed') }}">완료</a></li>
                </ul>
                <div class="item-list ready-box">
                    <div class="invoice invoice-admin">
                        <div class="invoice-admin-inner" v-for="(_payment, index) in payments">
                            <div class="invoice__body">
                                <div class="invoice__section" v-if="_payment.address">
                                    <div class="invoice__row">
                                        <p>테이블 번호</p>
                                        <p v-text="_payment.table_no"></p>
                                    </div>
                                </div>
                                <div class="invoice__section" v-else>
                                    <div class="invoice__row">
                                        <p>테이블 번호</p>
                                        <p v-text="_payment.table_no"></p>
                                    </div>
                                </div>
                                <div class="invoice__section">
                                    <div class="invoice__row">
                                        <p style="margin-top: 5px">메뉴</p>
                                        <div style="flex: 1; margin-left:15px">
                                            <div v-for="_item in _payment.items">
                                                <div class="cart__content-header">
                                                    <p class="cart__content-title" v-text="_item.title"></p>
                                                </div>
                                                <div class="cart__content-body">
                                                    <p class="cart__content-options" v-text="_item.options"></p>
                                                    <p class="cart__content-price" v-text="_item.price"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice__section">
                                    <div class="invoice__row invoice__row--middle">
                                        <p>결제 금액</p>
                                        <p v-text="_payment.price"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice__addition menu-detail">
                                @if ($type == 'ready')
                                    <div class="order__action-list">
                                        <button type="button" class="order__action-item" @click="refund(index)">결제취소</button>
                                        <button type="button" class="order__action-item" @click="status(index, 'approve')">결제승인</button>
                                    </div>
                                @elseif ($type == 'approve')
                                    <div class="order__action-list">
                                        <button type="button" class="order__action-item" @click="status(index, 'completed')">주문오나료</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
                    vendor_id: '{{ $vendor_id }}',
                    payments: [],
                    filter: {
                        pay_status: '{{ $type }}',
                        per_page: 10,
                    },
                    paginate: {
                        current_page: 1,
                        from: null,
                        last_page: 1,
                        path: null,
                        per_page: 10,
                        to: null,
                        total: 1
                    },
                };
            },
            created() {
                this.paginate.per_page = this.filter.per_page;

                this.fetch();
            },
            computed: {
                isObject() {
                    return (this.paginate !== undefined) && (this.paginate != null) && (this.paginate.total > 0);
                }
            },
            methods: {
                pageNo: function (index) {
                    if (this.isObject) {
                        return this.paginate.total - this.paginate.from - index + 1
                    }

                    return 0;
                },
                filterChange: function() {
                    this.fetch();
                },
                fetch: function (pageNum = 1) {
                    let app = this;

                    axios.get(`/api/vendor/${this.vendor_id}/pos`, {
                        params: {
                            page: pageNum,
                            pay_status: this.filter.pay_status,
                        }
                    })
                        .then(function (response) {
                            app.paginate = response.data.meta;
                            app.payments = response.data.data;
                        })
                        .catch(function (response) {
                        });
                },
                refund(index, result) {
                    let payment = this.payments[index];


                    let app = this;

                    let form = new FormData()
                    form.append('vendor_id', this.vendor_id);
                    form.append('order_no', payment.order_no);
                    form.append('message', '재료 부족');

                    axios.post(`/api/vendor/${this.vendor_id}/pos/refund`, form, {
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                        .then(function (response) {
                            app.payments[index] = response.data.data;
                        })
                        .catch(function (response) {
                        });
                },
                status(index, result) {
                    let payment = this.payments[index];


                    let app = this;

                    let form = new FormData()
                    form.append('vendor_id', this.vendor_id);
                    form.append('order_no', payment.order_no);
                    form.append('result', result);

                    axios.post(`/api/vendor/${this.vendor_id}/pos/change`, form, {
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                        .then(function (response) {
                            app.payments[index] = response.data.data;
                        })
                        .catch(function (response) {
                        });
                },
            }
        });
    </script>

@endsection