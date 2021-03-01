@extends('admin.include.app')

@section('main')

    <?php
    $search_type = Request::get('type');
    $title = "점주";
    ?>

    <admin-title-box
            :show-calendar="true"
            @update-date-range="updateDateRange">
        <template slot="header">
            <span class="title-box__title">{{ $title }}</span>
            <span class="title-box__total">전체 : <i class="title-box__total--number">0</i></span>
            <span class="title-box__today">오늘 : <i class="title-box__today--number">0</i></span>
        </template>
    </admin-title-box>

    <admin-condition-box
            @update-search="updateSearch">
        <template slot="filter">
            <select v-model="filter.per_page" @change="filterChange">
                <option value="">개수</option>
                <option value="10">10개</option>
                <option value="30">30개</option>
                <option value="50">50개</option>
                <option value="100">100개</option>
            </select>
            {{--<select v-model="filter.gender" @change="filterChange">--}}
                {{--<option value="">성별</option>--}}
                {{--<option value="mobile">남자</option>--}}
                {{--<option value="f">여자</option>--}}
            {{--</select>--}}
        </template>
    </admin-condition-box>

    <div class="table-box">
        <div class="table__responsive">
            <table class="table__list">
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>매장명</th>
                        <th>아이디</th>
                        <th>링크</th>
                        <th class="mx_50">방문수</th>
                        <th class="mx_150">접속일</th>
                        <th class="mx_150">가입일</th>
                        <th class="mx_150">탈퇴일</th>
                        <th class="mx_150">관리</th>
                    </tr>
                </thead>
                <tbody v-if="isObject">
                    <tr v-for="(_vendor, index) in vendors">
                        <td v-text="pageNo(index)"></td>
                        <td class="left"><a :href="'/admin/vendor/' + _vendor.id" v-text="_vendor.company"></a></td>
                        <td v-text="_vendor.user.email"></td>
                        <td>
                            <span>
                                <a :href="_vendor.home_url" target="_blank" rel="noopener" v-if="_vendor.home_url">
                                    <i class="ico-home-on"></i>
                                </a>
                                <i class="ico-home-off" v-else></i>
                            </span>
                            <span>
                                <a :href="_vendor.naver_url" target="_blank" rel="noopener" v-if="_vendor.naver_url">
                                    <i class="ico-naver-on"></i>
                                </a>
                                <i class="ico-naver-off" v-else></i>
                            </span>
                            <span>
                                <a :href="_vendor.facebook_url" target="_blank" rel="noopener" v-if="_vendor.facebook_url">
                                    <i class="ico-facebook-on"></i>
                                </a>
                                <i class="ico-facebook-off" v-else></i>
                            </span>
                            <span>
                                <a :href="_vendor.kakaoplus_url" target="_blank" rel="noopener" v-if="_vendor.kakaoplus_url">
                                    <i class="ico-kakao-on"></i>
                                </a>
                                <i class="ico-kakao-off" v-else></i>
                            </span>
                        </td>
                        <td v-text="_vendor.user.log_count"></td>
                        <td v-text="_vendor.user.logined_at ? _vendor.user.logined_at : '-' "></td>
                        <td v-text="_vendor.user.created_at"></td>
                        <td v-text="_vendor.user.deleted_at ? _vendor.user.deleted_at : '-' "></td>
                        <td class="btn__list" v-if="_vendor.user.deleted_at">
                            <button type="button" class="btn__item btn__item--red" @click="recoveryVendor(index)">복구</button>
                        </td>
                        <td class="btn__list" v-else>
                            <button type="button" class="btn__item" @click="updateVendor(index)">수정</button>
                            <button type="button" class="btn__item btn__item--red" @click="deleteVendor(index)">삭제</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="9">데이터가 없습니다.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table__addition">
            <div>
                <button type="button" class="btn-blue" @click="downloadSample">샘플 다운로드</button>
            </div>
            <div class="dot-paging">
                <paginate
                        v-model="paginate.current_page"
                        :page-count="paginate.last_page"
                        :page-range="10"
                        :click-handler="fetch"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'pagination'">
                </paginate>
            </div>
            <div>
                <button type="button" class="btn-blue" @click="createVendor">추가</button>
            </div>
        </div>
    </div>

    <!-- Dialogs -->
    <admin-vendor-modal-create
            @update-list="updateList">
    </admin-vendor-modal-create>

@endsection

@section('bottom_scripts')
    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    vendors: [],
                    filter: {
                        per_page: 10,
                        type: '{{ $search_type }}',
                        start_date: '',
                        end_date: '',
                        search_text: '',
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
                    this.ajax();
                },
                fetch: function (page = 1) {
                    location.href = '?page=' + page;
                },
                ajax(page = 1) {
                    let app = this;

                    axios.get("{{ route('api.admin.vendor.index') }}", {
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
                            app.vendors = response.data.data;
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
                createVendor () {
                    this.$modal.show('admin-vendor-modal-create', { apiUrl : '/api/admin/vendor' });
                },
                updateVendor(index) {
                    let vendor = this.vendors[index];

                    location.href = `/admin/vendor/${vendor.id}/edit`;
                },
                deleteVendor(index) {

                    let vendor = this.vendors[index];

                    if (confirm(vendor.company + ' 점주를 삭제하시겠습니까?')) {
                        let app = this;

                        axios.delete("/api/admin/vendor/" + vendor.id)
                            .then(function (response) {
                                app.ajax(app.paginate.current_page)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                    }
                },
                recoveryVendor(index) {
                    let vendor = this.vendors[index];

                    if (confirm(vendor.company + ' 점주를 복구하시겠습니까?')) {
                        let app = this;

                        let form = new FormData()
                        form.append('id', vendor.id);

                        axios.post("/api/admin/vendor/recovery/email", form, {
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
                updateSearch(search) {
                    this.filter.search_text = search;
                    this.fetch();
                },
                updateList() {
                    this.fetch();
                },
                downloadSample() {
                    window.location.href = "https://s3.ap-northeast-2.amazonaws.com/goingdutch/samples/vendor_sample.xlsx";
                }
            }
        });
    </script>

@endsection