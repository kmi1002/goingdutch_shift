@extends('admin.include.app')

@section('main')

    <admin-title-box
            :show-calendar="true"
            @update-date-range="updateDateRange">
        <template slot="header">
            <span class="title-box__title">관리자</span>
            <span class="title-box__total">전체 : <i class="title-box__total--number" v-text="paginate.total"></i></span>
            <span class="title-box__today">( {{ \App\Helpers\StringHelper::statistics($roles) }} )</span>
        </template>
    </admin-title-box>

    <admin-condition-box
            :search="filter.search_text"
            @update-search="updateSearch">
        <template slot="filter">
            <select v-model="filter.per_page" @change="filterChange">
                <option value="">개수</option>
                <option value="10">10개</option>
                <option value="30">30개</option>
                <option value="50">50개</option>
                <option value="100">100개</option>
            </select>
            <select v-model="filter.role" @change="filterChange">
                <option value="">권한</option>
                <option value="administrator">최고 관리자</option>
                <option value="manager">관리자</option>
                <option value="operator">운영자</option>
                <option value="analyst">분석자</option>
            </select>
        </template>
    </admin-condition-box>

    <div class="table-box">
        <div class="table__responsive">
            <table class="table__list">
                <thead>
                    <tr>
                        <th class="mx_50">번호</th>
                        <th class="mx_100">권한</th>
                        <th>이메일</th>
                        <th>이름</th>
                        <th class="mx_50">방문수</th>
                        <th class="mx_150">가입일</th>
                        <th class="mx_150">접속일</th>
                        <th class="mx_150">삭제일</th>
                        <th class="mx_100">인증</th>
                        <th class="mx_150">상태</th>
                    </tr>
                </thead>
                <tbody v-if="isObject">
                    <tr v-for="(_user, index) in users">
                        <td v-text="pageNo(index)"></td>
                        <td v-text="_user.role_name"></td>
                        <td v-text="_user.email"></td>
                        <td v-text="_user.name"></td>
                        <td v-text="_user.log_count"></td>
                        <td v-text="_user.created_at"></td>
                        <td v-text="_user.logined_at ? _user.logined_at : '-' "></td>
                        <td v-text="_user.deleted_at ? _user.deleted_at : '-' "></td>
                        <td v-text="_user.activated"></td>
                        <td class="btn__list" v-if="_user.role == 'administrator' || _user.id == '{{ \Auth::guard('admin')->user()->id }}'">-</td>
                        <td class="btn__list" v-else-if="_user.deleted_at">
                            <button type="button" class="btn__item btn__item--red" @click="recoveryManager(_user.id, _user.email)">복구</button>
                        </td>
                        <td class="btn__list" v-else>
                            <button type="button" class="btn__item" @click="updateManager(_user.id)">수정</button>
                            <button type="button" class="btn__item btn__item--red" @click="deleteManager(_user.id)">삭제</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="10">데이터가 없습니다.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table__addition">
            <div></div>
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
                <button type="button" class="btn-blue" @click="createManager">관리자 추가</button>
            </div>
        </div>
    </div>

    <!-- Dialogs -->
    <admin-manager-modal-create
            @update-list="updateList">
    </admin-manager-modal-create>

@endsection

@section('bottom_scripts')

    <script>
        new Vue({
            el: '#wrap',
            data() {
                return {
                    users: [],
                    filter: {
                        per_page: 10,
                        start_date: '',
                        end_date: '',
                        search_text: '',
                        role: ''
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
            components: {
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

                    axios.get("{{ route('api.admin.manager.index') }}", {
                            params: {
                                page: page,
                                per_page: this.filter.per_page,
                                start_date: this.filter.start_date,
                                end_date: this.filter.end_date,
                                search_text: this.filter.search_text,
                                role: this.filter.role
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
                },
                createManager () {
                    this.$modal.show('admin-manager-modal-create', { mode : 'create', apiUrl : '/api/admin/manager' });
                },
                updateManager(id) {
                    this.$modal.show('admin-manager-modal-create', { mode : 'update', apiUrl : '/api/admin/manager', id : id });
                },
                deleteManager(id) {
                    if (confirm('관리자를 삭제하시겠습니까?')) {
                        let app = this;

                        axios.delete("/api/admin/manager/" + id)
                            .then(function (response) {
                                app.ajax(app.paginate.current_page)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                    }
                },
                recoveryManager(id, email) {
                    if (confirm('관리자를 복구하시겠습니까?')) {
                        let app = this;

                        let form = new FormData()
                        form.append('id', id);
                        form.append('email', email);

                        axios.post("/api/admin/manager/recovery/email", form, {
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

                updateList() {
                    this.ajax({{ Request::get('page') }});
                },
            }
        });
    </script>

@endsection