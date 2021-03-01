@extends('admin.include.app')

@section('main')

    <admin-title-box
            :show-calendar="true"
            @update-date-range="updateDateRange">
        <template slot="header">
            <span class="title-box__title">메뉴 카테고리</span>
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
            <select v-model="filter.recommend" @change="filterChange">
                <option value="">추천 여부</option>
                <option value="1">추천</option>
                <option value="0">비추천</option>
            </select>
        </template>
    </admin-condition-box>

    <div class="table-box">
        <table class="table__list">
            <thead>
                <tr>
                    <th class="mx_50">번호</th>
                    <th class="mx_150">카테고리</th>
                    <th>설명</th>
                    <th class="mx_50">사용</th>
                    <th class="mx_100">우선순위</th>
                    <th class="mx_150">등록일</th>
                    <th class="mx_150">관리</th>
                </tr>
            </thead>
            <tbody v-if="isObject">
                <tr v-for="(_group, index) in groups">
                    <td v-text="pageNo(index)"></td>
                    <td class="left">@{{ _group.title }}</td>
                    <td class="left">@{{ _group.descriptino }}</td>
                    <td>
                        <button type="button" class="btn-red" @click="updateActive(index, false)" v-if="_group.active">On</button>
                        <button type="button" class="btn-white" @click="updateActive(index, true)" v-else>Off</button>
                    </td>
                    <td>
                        0
                    </td>
                    <td v-text="_group.created_at"></td>
                    <td class="btn__list" v-if="_group.deleted_at">
                        <button type="button" class="btn__item--red" @click="recoveryMenu(index)">복구</button>
                    </td>
                    <td class="btn__list" v-else>
                        <button type="button" class="btn__item" @click="updateMenu(index)">수정</button>
                        <button type="button" class="btn__item btn__item--red" @click="deleteMenu(index)">삭제</button>
                    </td>
                </tr>
            </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="7">데이터가 없습니다.</td>
                </tr>
            </tbody>
        </table>
        <div class="table__addition">
            <div>
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
                    <button type="button" class="btn-blue" @click="createCategory">추가</button>
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
                    vendor_id: "{{ $vendor_id }}",
                    groups: [],
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

                    axios.get(`/api/admin/vendor/${this.vendor_id}/menu/group`, {
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
                            app.groups = response.data.data;

                            console.log(app.groups);
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
                createCategory() {
{{--                    location.href = "{{ route('menu-group', ['vendor_id' => $vendor_id]) }} ";--}}
                },
                updateMenu(id) {
                    let menu = this.groups[id];

                    location.href = `/admin/vendor/${this.vendor_id}/menu/group/${menu.id}/edit`;
                },
                deleteMenu(id) {

                    let menu = this.groups[id];

                    if (confirm(`'${menu.title}' 메뉴를 삭제하시겠습니까?`)) {
                        let app = this;

                        axios.delete(`/api/admin/vendor/${this.vendor_id}/menu/group/${menu.id}`)
                            .then(function (response) {
                                app.ajax(app.paginate.current_page)
                            })
                            .catch(function (response) {
                                console.log(response);
                            });
                    }
                },
                recoveryMenu(id) {
                    let menu = this.groups[id];

                    if (confirm(`'${menu.title}' 메뉴를 복구하시겠습니까?`)) {
                        let app = this;

                        let form = new FormData()
                        form.append('id', menu.id);

                        axios.post(`/api/admin/vendor/${this.vendor_id}/menu/group/${menu.id}/recovery`, form, {
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

                    let menu = this.groups[id];
                    let menu_id = menu.id;

                    let form = new FormData()
                    form.append('active', value);

                    axios.post(`/api/admin/vendor/${this.vendor_id}/menu/group/${menu_id}/active`, form, {
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

                    let menu = this.groups[id];
                    let menu_id = menu.id;

                    let form = new FormData()
                    form.append('recommend', value);

                    axios.post(`/api/admin/vendor/${this.vendor_id}/menu/group/${menu_id}/recommend`, form, {
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
            }
        });
    </script>

@endsection