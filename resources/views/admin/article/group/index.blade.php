@extends('admin.include.app')

@section('main')

    <admin-title-box
            :show-calendar="true"
            @update-date-range="updateDateRange">
        <template slot="header">
            <span class="title-box__title">{{ $title.' 그룹' }}</span>
        </template>
    </admin-title-box>

    <admin-condition-box
            :search="filter.search_text"
            @update-search="updateSearch"
            v-if="filter.group">
        <template slot="filter">
            <select v-model="filter.group_code" @change="filterChange">
                <option value="">메인 그룹</option>
                @foreach ($groups as $_group)
                    <option value="{{ $_group->code }}">{{ $_group->title }}</option>
                @endforeach
            </select>
        </template>
    </admin-condition-box>

    <div class="table-box">
        <div class="table__responsive">
            <table class="table__list">
                <thead>
                <tr>
                    <th>제목</th>
                    <th>코드</th>
                    <th class="mx_100">플랫폼</th>
                    <th class="mx_100">언어</th>
                    <th class="mx_150">생성일</th>
                    <th class="mx_150">수정일</th>
                    <th class="mx_200">관리</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="_group in groups">
                    <td v-text="lineText(_group.depth, _group.title)" style="text-align:left; padding-left: 10px"></td>
                    <td v-text="_group.code"></td>
                    <td v-text="_group.platform"></td>
                    <td v-text="_group.language"></td>
                    <td v-text="_group.created_at"></td>
                    <td v-text="_group.updated_at"></td>
                    <td class="btn__list">
                        <button type="button" class="btn__item" @click="updateSupport(_group.id)">수정</button>
                        <button type="button" class="btn__item--red" @click="deleteSupport(_group.id)">삭제</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="table__addition">
            <div>
            </div>
            <div class="paging">
            </div>
            <div>
                <button type="button" class="btn-red" @click="createSupport">추가</button>
            </div>
        </div>
    </div>

    <!-- Dialogs -->
    <admin-article-group-create
            @update-list="updateList">
    </admin-article-group-create>

@endsection

@section('bottom_scripts')

    <script>

        new Vue({
            el: '#wrap',
            data() {
                return {
                    groups: '',
                    filter: {
                        start_date: '',
                        end_date: '',
                        search_text: '',
                        group_code: "{{ $code }}"
                    }
                };
            },
            created() {
                if (this.filter.group_code) {
                    this.ajax();
                }
            },
            computed: {
            },
            methods: {
                filterChange: function () {
                    this.ajax();
                },
                fetch: function (page = 1) {
                    location.href = '?page=' + page;
                },
                ajax(page = 1) {
                    let app = this;
                    axios.get("{{ route('api.admin.article.group.index') }}", {
                        params: {
                            page: page,
                            start_date: this.filter.start_date,
                            end_date: this.filter.end_date,
                            search_text: this.filter.search_text,
                            group_code: this.filter.group_code,
                        }
                    })
                        .then(function (response) {
                            app.groups = response.data.data;
                        })
                        .catch(function (response) {
                            console.log(response);
                        });
                },
                updateDateRange: function (start_date, end_date) {
                    this.filter.start_date = start_date;
                    this.filter.end_date = end_date;
                    this.fetch();
                },
                createSupport() {
                    this.$modal.show('admin-article-group-create', { mode : 'create', apiUrl : '/api/admin/article/group', parent_id: "{{ $parentId }}" });
                },
                updateSupport(id) {
                    this.$modal.show('admin-article-group-create', { mode : 'update', apiUrl : '/api/admin/article/group', id : id });
                },
                deleteSupport(id) {
                    if (confirm('게시물을 삭제할까요?')) {
                        let app = this;

                        axios.delete("/api/admin/article/group/" + id)
                            .then(function (response) {
                                window.location.reload();
                            })
                            .catch(function (response) {
                            });
                    }
                },
                updateSearch: function (search) {
                    this.filter.search_text = search;
                    this.fetch();
                },
                updateList(group) {
                    if (group.parent_id) {
                        this.ajax();
                    } else {
                        window.location.reload();
                    }
                },
                lineText(depth, title) {
                    var ret = '';

                    for (var i = 0; i < depth; ++i) {
                        ret += '-';
                    }

                    return ret + ' ' + title;
                }
            }
        });

    </script>
@endsection