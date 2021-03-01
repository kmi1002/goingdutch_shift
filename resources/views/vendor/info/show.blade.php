@extends('vendor.include.app')

@section('main')

    <admin-title-box
            :show-calendar="false"
            @update-date-range="updateDateRange">

        <template slot="header">
            <span class="title-box__title">정보</span>
        </template>
    </admin-title-box>

    <div class="table-box">
        <table class="popup-table">
            <tr>
                <th>대표이미지</th>
                <td>
                    <img src="/img/sample-store-001.jpg" style="max-width: 200px">
                    <img src="/img/sample-store-002.jpg" style="max-width: 200px">
                </td>
            </tr>
            <tr>
                <th>코드</th>
                <td>{{ $vendor->user->email }}</td>
            </tr>
            <tr>
                <th>상호명</th>
                <td>{{ $vendor->company }}</td>
            </tr>
            <tr>
                <th>이름</th>
                <td>{{ $vendor->user->nick_name }}</td>
            </tr>
            <tr>
                <th>이메일</th>
                <td>{{ $vendor->email }}</td>
            </tr>
            <tr>
                <th>주소</th>
                <td>{{$vendor->address }}</td>
            </tr>
            <tr>
                <th>카파라이트</th>
                <td>{{ $vendor->crn }}</td>
            </tr>
            <tr>
                <th>링크</th>
                <td>
                    <span>
                        @if ($vendor->home_url)
                            <a href="{{ $vendor->home_url }}" target="_blank" rel="noopener">
                            <i class="ico-home-on"></i>
                        </a>
                        @else
                            <i class="ico-home-off" v-else></i>
                        @endif
                    </span>
                        <span>
                        @if ($vendor->youtube_url)
                                <a href="{{ $vendor->youtube_url }}" target="_blank" rel="noopener">
                            <i class="ico-youtube-on"></i>
                            </a>
                            @else
                                <i class="ico-youtube-off" v-else></i>
                            @endif
                    </span>
                        <span>
                        @if ($vendor->facebook_url)
                                <a href="{{ $vendor->facebook_url }}" target="_blank" rel="noopener">
                            <i class="ico-facebook-on"></i>
                            </a>
                            @else
                                <i class="ico-facebook-off" v-else></i>
                            @endif
                    </span>
                        <span>
                        @if ($vendor->instagram_url)
                                <a href="{{ $vendor->instagram_url }}" target="_blank" rel="noopener">
                            <i class="ico-instagram-on"></i>
                            </a>
                            @else
                                <i class="ico-instagram-off" v-else></i>
                            @endif
                    </span>
                        <span>
                        @if ($vendor->naver_url)
                                <a href="{{ $vendor->naver_url }}" target="_blank" rel="noopener">
                            <i class="ico-naver-on"></i>
                            </a>
                            @else
                                <i class="ico-naver-off" v-else></i>
                            @endif
                    </span>

                        <span>
                        @if ($vendor->kakaoplus_url)
                                <a href="{{ $vendor->kakaoplus_url }}" target="_blank" rel="noopener">
                            <i class="ico-kakaoplus-on"></i>
                            </a>
                            @else
                                <i class="ico-kakaoplus-off" v-else></i>
                            @endif
                    </span>
                </td>
            </tr>
            <tr>
                <th>소개</th>
                <td>{{ $vendor->introduce }}</td>
            </tr>
        </table>
        <div class="table__addition">
            <div>
            </div>
            <div>
            </div>
            <div>
                <button type="button" class="btn-blue" @click="editVendor">수정</button>
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
                    },
                    menus: [],
                    vendor_id: "{{ $vendor->id }}",
                    filter: {
                        per_page: 10,
                        type: '',
                        start_date: '',
                        end_date: '',
                        search_text: '',
                        recommend: ''
                    },
                    paginate: {
                        current_page: 1,
                        from: null,
                        last_page: 1,
                        path: null,
                        per_page: 10,
                        to: null,
                        total: 1
                    }
                };
            },
            created() {
                this.paginate.per_page = this.filter.per_page;

                this.ajax({{ Request::get('page') }});
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
                fetch: function (page = 1) {
                    location.href = '?page=' + page;
                },
                ajax(page = 1) {
                    let app = this;

                    axios.get(`/api/vendor/vendor/${this.vendor_id}/menu`, {
                        params: {
                            page: page,
                            type: this.filter.type,
                            per_page: this.filter.per_page,
                            start_date: this.filter.start_date,
                            end_date: this.filter.end_date,
                            search_text: this.filter.search_text,
                        }
                    })
                        .then(function (response) {
                            app.paginate = response.data.meta;
                            app.menus = response.data.data;
                        })
                        .catch(function (response) {
                            //console.log(response);
                        });
                },
                updateDateRange: function(start_date, end_date) {
                    this.filter.start_date = start_date;
                    this.filter.end_date = end_date;
                    this.fetch();
                },
                editVendor() {
                    // this.$modal.show('admin-vendor-modal-create', { apiUrl : '/api/admin/vendor' });
                },
                updateMenu(id) {
                    let user = this.users[id];
                    this.$modal.show('admin-vendor-modal-update', { apiUrl : '/api/admin/vendor', vendor : user  });
                },
                deleteMenu(id) {

                    let user = this.users[id];

                    if (confirm(user.vendor.vendor + ' 메뉴를 삭제하시겠습니까?')) {
                        let app = this;

                        axios.delete("/api/vendor/vendor/" + user.user.id)
                            .then(function (response) {
                                app.ajax(app.paginate.current_page)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                    }
                },
                recoveryMenu(id) {
                    let user = this.users[id];

                    if (confirm(user.vendor.vendor + ' 메뉴를 복구하시겠습니까?')) {
                        let app = this;

                        let form = new FormData()
                        form.append('id', user.user.id);
                        form.append('email', user.user.email);

                        axios.post("/api/vendor/vendor/recovery/email", form, {
                            headers: {
                                'X-HTTP-Method-Override': 'PUT'
                            }
                        })
                            .then(function (response) {
                                app.ajax(app.paginate.current_page)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                    }
                },
                updateActive(id, value) {
                    let app = this;

                    let menu = this.menus[id];
                    let menu_id = menu.id;

                    let form = new FormData()
                    form.append('active', value);

                    axios.post(`/api/vendor/vendor/${this.vendor_id}/menu/${menu_id}/active`, form, {
                            headers: {
                                'X-HTTP-Method-Override': 'PUT'
                            }
                        })
                        .then(function (response) {
                            let data = response.data.data;
                            menu.active = data.active;

                        })
                        .catch(function (response) {
                            app.error = response;
                        });
                },
                updateRecommend(id, value) {
                    let app = this;

                    let menu = this.menus[id];
                    let menu_id = menu.id;

                    let form = new FormData()
                    form.append('recommend', value);

                    axios.post(`/api/vendor/vendor/${this.vendor_id}/menu/${menu_id}/recommend`, form, {
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    })
                        .then(function (response) {
                            let data = response.data.data;
                            menu.recommend = data.recommend;

                        })
                        .catch(function (response) {
                            app.error = response;
                        });
                },
                updateSearch: function(search) {
                    this.filter.search_text = search;
                    this.fetch();
                },
                updateList() {

                },
                priceFormat(number) {
                    return new Intl.NumberFormat('ko-KR', { maximumSignificantDigits: 3 }).format(number) + '원';
                },
                percentFormat(number) {
                    return number + '%';
                },
                calcPrice(original_price, discount_price, discount_percent) {
                    if (discount_price > 0 && discount_percent > 0) {
                        return '오류!!';
                    }

                    if (discount_price) {
                        if (original_price < discount_price) {
                            return '오류!!';
                        }

                        return this.priceFormat(original_price - discount_price);
                    }

                    if (discount_percent) {
                        let discount_price = original_price * (discount_percent / 100);
                        if (original_price < discount_price) {
                            return '오류!!';
                        }

                        return this.priceFormat(original_price - discount_price);
                    }
                }
            }
        });
    </script>

@endsection