<template>
    <modal
            name="admin-article-group-create"
            width="500"
            height="auto"
            @before-open="beforeOpened"
            @before-close="beforeClosed">
        <modal-create
                @modal-ok="modalOk"
                @modal-close="modalClose">
            <template slot="header">
                게시물 그룹
            </template>
            <template slot="body">
                <table class="popup-table">
                    <colgroup>
                        <col width="114px" />
                    </colgroup>
                    <tr>
                        <th>그룹</th>
                        <td>
                            <select v-model="group.parent_id" v-if="group.parent_id">
                                <option v-for="(_group, _index) in groups" :value="_group.id" :selected="_index === group.parent_id" v-text="lineText(_group.depth, _group.title)"></option>
                            </select>
                            <select v-else>
                                <option value="">그룹</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>플랫폼</th>
                        <td>
                            <select v-model="group.platform">
                                <option value="">플랫폼</option>
                                <option value="web">Web</option>
                                <option value="ios">iOS</option>
                                <option value="android">Android</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>언어</th>
                        <td>
                            <select v-model="group.language">
                                <option value="">언어</option>
                                <option value="en">영어</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>제목</th>
                        <td><input type="text" placeholder="제목을 입력하세요" v-model="group.title"></td>
                    </tr>
                    <tr>
                        <th>코드</th>
                        <td><input type="text" placeholder="코드를 입력하세요" v-model="group.code"></td>
                    </tr>
                </table>
            </template>
        </modal-create>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                apiUrl: '',
                error: null,
                mode: '',
                group: {
                    id : 0,
                    title: '',
                    code: '',
                    platform: '',
                    language: '',
                    parent_id: null
                },
                categories: [],
                groups: [],
                old: {
                    title: '',
                    code: '',
                    parent_id: null,
                },
            };
        },
        created() {
        },
        mounted() {
        },
        computed: {
            apiCreateUrl() {
                return this.apiUrl;
            },
            apiSelectUrl() {
                let id = this.group.id;
                if (id == 0) {
                    return '';
                }

                return this.apiUrl + '/' + id;
            },
            apiUpdateUrl() {
                let id = this.group.id;
                if (id == 0) {
                    return '';
                }

                return this.apiUrl + '/' + id;
            },
            apiTreeUrl() {
                return this.apiUrl + '/tree';
            }
        },
        methods: {
            beforeOpened (event) {
                let app = this;

                this.apiUrl     = event.params.apiUrl;
                this.mode       = event.params.mode;
                this.group.id   = event.params.id;
                this.group.parent_id   = event.params.parent_id;

                this.categories = [];
                this.groups     = [];

                this.old.parent_id  = null;
                this.old.title      = '';
                this.old.code       = '';

                if (this.mode == 'create') {
                    // 전체 트리 구조 가져오기
                    this.filterChange();
                } else {
                    this.select(function() {
                        // 해당 그룹의 트리 구조 가져오기
                        app.filterChange();
                    });
                }
            },
            beforeClosed (event) {
                this.apiUrl = '';
                this.mode   = '';

                this.group.id           = 0;
                this.group.title        = '';
                this.group.code         = '';
                this.group.parent_id    = null;

                this.old.title      = '';
                this.old.code       = '';
                this.old.parent_id  = null;
            },
            modalOk: function() {
                let app = this;

                if (this.group.platform == '') {
                    alert('플랫폼을 선택하세요.');
                    return;
                }

                if (this.group.language == '') {
                    alert('언어를 선택하세요.');
                    return;
                }

                if (this.group.title == '') {
                    alert('제목을 입력하세요.');
                    return;
                }

                if (this.group.code == '') {
                    alert('내용을 입력하세요.');
                    return;
                }

                let form = new FormData();
                form.append('parent_id', this.group.parent_id);
                form.append('platform', this.group.platform);
                form.append('language', this.group.language);
                form.append('title', this.group.title);
                form.append('code', this.group.code);

                if (this.mode == 'create') {
                    this.create(form);
                } else if (this.mode == 'update') {
                    this.update(form);
                }
            },
            modalClose: function() {
                this.$modal.hide('admin-article-group-create');
            },
            create(form) {
                let app = this;

                axios.post(this.apiCreateUrl, form)
                    .then(function (response) {

                        if (response.status == 201) {
                            app.$modal.hide('admin-article-group-create');
                            app.$emit("update-list", response.data.data);
                        } else {
                            alert('code가 중복되었습니다.');
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            select(callback = null) {
                let app = this;

                axios.get(this.apiSelectUrl)
                    .then(function (response) {

                        app.group           = response.data.data;

                        app.old.title       = app.group.title;
                        app.old.code        = app.group.code;
                        app.old.parent_id   = app.group.parent_id;

                        callback();
                    })
                    .catch(function (response) {
                        app.error = response;

                        callback();
                    });
            },
            update(form) {

                if (this.old.parent_id  == this.group.parent_id &&
                    this.old.platform   == this.group.platform &&
                    this.old.language   == this.group.language &&
                    this.old.title      == this.group.title &&
                    this.old.code       == this.group.code) {

                    alert('이전 데이터랑 값이 같습니다.')

                    return;
                }

                let app = this;

                axios.post(this.apiUpdateUrl, form, {
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                    .then(function (response) {

                        if (response.status == 200) {
                            app.$modal.hide('admin-article-group-create');
                            app.$emit("update-list", response.data.data);
                        } else {
                            alert('code가 중복되었습니다.');
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            filterChange() {

                let app = this;

                axios.get(this.apiTreeUrl, {
                    params: {
                        parent_id: this.group.parent_id,
                    }
                })
                    .then(function (response) {

                        app.groups = response.data.data;
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            lineText(depth, title) {
                var ret = '';

                for (var i = 0; i < depth; ++i) {
                    ret += '-';
                }

                return ret + ' ' + title;
            }
        }
    }
</script>

<style scoped>

</style>