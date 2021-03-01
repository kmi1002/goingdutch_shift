@extends('vendor.include.app')

@section('main')

    <?php
        $search_type = Request::get('type');

        $title = "";
        switch ($search_type) {
            case 'card_auth_pay': $title = "카드 인증"; break;
            case 'card_safe_pay': $title = "카드 안전"; break;
            case 'kakao_pay': $title = "카카오 페이"; break;
            case 'naver_pay': $title = "네이버 페이"; break;
            case 'card_easy_pay': $title = "이지 페이"; break;
            default: $title = "전체"; break;
        }
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
            <select v-model="filter.pay_type" @change="filterChange">
                <option value="">결제 방식</option>
                <option value="card_auth_pay">카드 인증 결제</option>
                <option value="card_safe_pay">카드 안전 결제</option>
                <option value="kakao_pay">카카오 페이 결제</option>
                <option value="naver_pay">네이버 페이 결제</option>
                <option value="easy_pay">이지 페이 결제</option>
            </select>
            <select v-model="filter.pay_status" @change="filterChange">
                <option value="">결제 결과</option>
                <option value="success">성공</option>
                <option value="fail">실패</option>
                <option value="cancel">취소</option>
            </select>
        </template>
    </admin-condition-box>

    <div class="table-box">
        <div class="table__responsive">
            <div  class="table__list">
                <table>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>등록일</th>
                            <th>주문자</th>
                            <th>코드</th>
                            <th>방식</th>
                            <th>주문번호</th>
                            <th>메뉴명</th>
                            <th>개수</th>
                            <th>가격</th>
                            <th>IP</th>
                            <th>결제기기</th>
                            <th class="last mx_190">상태</th>
                        </tr>
                    </thead>
                    <tbody v-if="isObject">
                        <tr v-for="(_user, index) in users">
                            <td>@{{ pageNo(index) }}</td>
                            <td>@{{ _user.channel }}</td>
                            <td><a :href="'/admin/vendor/' + _user.id">@{{ _user.name }}</a></td>
                            <td>@{{ _user.gender }}</td>
                            <td>@{{ _user.email }}</td>
                            <td>@{{ _user.log_count }}</td>
                            <td>@{{ _user.created_at }}</td>
                            <td>@{{ _user.logined_at }}</td>
                            <td>@{{ _user.activated }}</td>
                            <td>정상</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="12">데이터가 없습니다.</td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="9">데이터가 없습니다.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table__addition">
            <div class="table__addition--left"></div>
            <div class="dot-paging">
                <paginate
                        v-model="paginate.current_page"
                        :page-count="paginate.last_page"
                        :page-range="5"
                        :click-handler="fetch"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'pagination'">
                </paginate>
            </div>
            <div class="table__addition--right">
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
                    users: [],
                    filter: {
                        pay_type: '',
                        pay_status: '',
                        per_page: 10,
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
                    {{--let app = this;--}}

                    {{--axios.get("{{ route('api.backend.user.index') }}", {--}}
                        {{--params: {--}}
                            {{--page: pageNum,--}}
                            {{--search: this.search,--}}
                            {{--start_date: this.start_date,--}}
                            {{--end_date: this.end_date,--}}
                            {{--type: this.type,--}}
                            {{--channel: this.filter.channel,--}}
                            {{--gender: this.filter.gender,--}}
                            {{--status: this.filter.status--}}
                        {{--}--}}
                    {{--})--}}
                        {{--.then(function (response) {--}}
                            {{--//console.log(response);--}}
                            {{--app.paginate = response.data.meta;--}}
                            {{--app.users = response.data.data;--}}
                        {{--})--}}
                        {{--.catch(function (response) {--}}
                            {{--//console.log(response);--}}
                        {{--});--}}
                },
                updateDateRange: function(start_date, end_date) {
                    this.filter.start_date = start_date;
                    this.filter.end_date = end_date;
                    this.fetch();
                },
                updateSearch: function(search) {
                    this.filter.search_text = search;
                    this.fetch();
                },
            }
        });
    </script>

@endsection