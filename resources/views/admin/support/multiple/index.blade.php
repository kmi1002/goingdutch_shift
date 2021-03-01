@extends('admin.include.app')

@section('custom_style')
    <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

    <!-- Include Editor style. -->
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.3/css/froala_style.min.css' rel='stylesheet' type='text/css' />

@endsection

@section('main')

    <?php
    $type = Request::get('type') ?? 'notice';

    $title = "";
    switch ($type) {
        case 'faq': $title = "도움말"; break;
        default:    $title = "공지사항"; break;
    }
    ?>

    <admin-title-box
            :show-calendar="true"
            @update-date-range="updateDateRange">
        <template slot="header">
            <span class="title-box__title">{{ $title }}</span>
        </template>
    </admin-title-box>

    <admin-condition-box
            @update-search="updateSearch">

        @if ($type == 'faq')
            <template slot="filter">
                <select>
                    <option value="">가입방법</option>
                    <option value="email">email</option>
                    <option value="facebook">facebook</option>
                    <option value="google">google</option>
                    <option value="kakao">kakao</option>
                    <option value="naver">naver</option>
                </select>
            </template>
        @endif
    </admin-condition-box>

    <div class="table-box">
        <div class="table__responsive">
            <table class="table__list">
                <thead>
                    <tr>
                        <th class="mx_50">번호</th>
                        <th>제목</th>
                        <th class="mx_150">작성자</th>
                        <th class="mx_150">생성일</th>
                        <th class="mx_150">수정일</th>
                        <th class="mx_150">관리</th>
                    </tr>
                </thead>
                <tbody v-if="isObject">
                    <tr v-for="(_article, index) in articles">
                        <td v-text="pageNo(index)"></td>
                        <td class="left"><a :href="'/admin/support/multiple/' + _article.id" v-text="_article.title" ></a></td>
                        <td v-text="_article.name"></td>
                        <td v-text="_article.created_at"></td>
                        <td v-text="_article.updated_at"></td>
                        <td class="btn__list">
                            <button type="button" class="btn__item" @click="updateSupport(_article.id)">수정</button>
                            <button type="button" class="btn__item btn__item--red" @click="deleteSupport(_article.id)">삭제</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="6">데이터가 없습니다.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table__addition">
            <div>
                @if ($type == 'faq')
                <button type="button" class="btn-white" @click="groupManager">그룹 관리</button>
                @endif
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
                <button type="button" class="btn-blue" @click="createSupport">추가</button>
            </div>
        </div>
    </div>

    <!-- Dialogs -->
    <modals-container />

@endsection


@section('bottom_scripts')

    <script>

        new Vue({
            el: '#wrap',
            data() {
                return {
                    filter: {
                        group: "{{ $type }}",
                        platform: 'web',
                        language: 'ko',
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
                    articles: ''
                };
            },
            created() {
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
                filterChange: function () {
                    this.fetch();
                },
                fetch: function (page = 1) {
                    location.href = '?page=' + page;
                },
                ajax(page = 1) {
                    let app = this;

                    axios.get("{{ route('api.admin.support.index') }}", {
                        params: {
                            page: page,
                            per_page: this.paginate.per_page,
                            group: this.filter.group,
                            platform: this.filter.platform,
                            language: this.filter.language
                        }
                    })
                        .then(function (response) {
                            app.paginate = response.data.meta;
                            app.articles = response.data.data;
                        })
                        .catch(function (response) {
                            //console.log(response);
                        });
                },
                updateDateRange: function (start_date, end_date) {
                    this.filter.start_date = start_date;
                    this.filter.end_date = end_date;
                    this.fetch();
                },
                createSupport() {
                    location.href = "/admin/support/multiple/create?type=" + this.filter.group + "&platform=" + this.filter.platform + "&language=" + this.filter.language;
                },
                updateSupport(id) {
                    location.href = "/admin/support/multiple/" + id + "/edit?type=" + this.filter.group + "&platform=" + this.filter.platform + "&language=" + this.filter.language;
                },
                deleteSupport(id) {
                    if (confirm('게시물을 삭제할까요?')) {
                        let app = this;

                        axios.delete("/api/admin/support/" + id)
                            .then(function (response) {
                                app.ajax(app.paginate.current_page)
                            })
                            .catch(function (response) {
                                //console.log(response);
                            });
                    }
                },
                updateSearch: function (search) {
                    this.filter.search_text = search;
                    this.fetch();
                },
                groupManager: function () {
                    location.href = '/admin/article/group';
                }
            }
        });

    </script>
@endsection