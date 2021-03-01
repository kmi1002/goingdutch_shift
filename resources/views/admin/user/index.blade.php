@extends('admin.include.app')

@section('main')

    <?php
    $search_type = Request::get('type');

    $title = "";
    switch ($search_type) {
        case 'withdrawal': $title = "탈퇴 회원"; break;
        default: $title = "회원"; break;
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
            <select v-model="filter.per_page" @change="filterChange">
                <option value="">개수</option>
                <option value="10">10개</option>
                <option value="30">30개</option>
                <option value="50">50개</option>
                <option value="100">100개</option>
            </select>
            <select v-model="filter.channel" @change="filterChange">
                <option value="">가입방법</option>
                <option value="email">email</option>
                <option value="facebook">facebook</option>
                <option value="google">google</option>
                <option value="kakao">kakao</option>
                <option value="naver">naver</option>
            </select>
            <select v-model="filter.gender" @change="filterChange">
                <option value="">성별</option>
                <option value="male">남자</option>
                <option value="female">여자</option>
            </select>
            <select v-model="filter.status" @change="filterChange">
                <option value="">상태</option>
                <option value="">정상</option>
                <option value="">메일 미인증</option>
                <option value="">7일 정지</option>
                <option value="">30일 정지</option>
                <option value="">영구 정지</option>
            </select>
        </template>
    </admin-condition-box>

    <div class="table-box">
        <div class="table__responsive">
            <table class="table__list">
                <thead>
                    <tr>
                        <th>번호</th>
                        <th>가입</th>
                        <th>이름</th>
                        <th>성별</th>
                        <th>이메일</th>
                        <th>방문수</th>
                        <th>가입일</th>
                        <th>접속일</th>
                        <th>인증</th>
                        <th>신고</th>
                        <th class="last">상태</th>
                    </tr>
                </thead>
                <tbody v-if="isObject">
                    <tr v-for="(_user, index) in users">
                        <td v-text="pageNo(index)"></td>
                        <td v-text="_user.channel"></td>
                        <td ><a :href="'/admin/user/' + _user.id" v-text="_user.name" ></a></td>
                        <td v-text="_user.gender"></td>
                        <td v-text="_user.email"></td>
                        <td v-text="_user.log_count"></td>
                        <td v-text="_user.created_at"></td>
                        <td v-text="_user.logined_at"></td>
                        <td v-text="_user.activated"></td>
                        <td>0</td>
                        <td>정상</td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="11">데이터가 없습니다.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table__addition">
            <div>
            </div>
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
            <div>
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
                        type: '{{ $search_type }}',
                        per_page: 10,
                        start_date: '',
                        end_date: '',
                        search_text: '',
                        channel: '',
                        gender: '',
                        status: ''
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
                    start_date: '',
                    end_date: '',
                    search: '',
                };
            },
            created() {
                this.paginate.per_page = this.filter.per_page;

                this.ajax({{ Request::get('page') }});
            },
            computed: {
                isObject() {
                    return (this.users !== undefined) && (this.users != null) && (this.users.length > 0);
                }
            },
            mounted(){

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

                    axios.get("{{ route('api.admin.user.index') }}", {
                        params: {
                            page: page,
                            type: this.filter.type,
                            per_page: this.filter.per_page,
                            start_date: this.filter.start_date,
                            end_date: this.filter.end_date,
                            search_text: this.filter.search_text,
                            channel: this.filter.channel,
                            gender: this.filter.gender,
                            status: this.filter.status,
                        }
                    })
                        .then(function (response) {
                            app.paginate = response.data.meta;
                            app.users = response.data.data;
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
                updateSearch: function(search) {
                    this.filter.search_text = search;
                    this.fetch();
                }
            }
        });
    </script>

@endsection