<template>
    <modal
            name="admin-manager-modal-create"
            width="425"
            height="auto"
            @before-open="beforeOpened"
            @before-close="beforeClosed">
        <modal-create
                @modal-ok="modalOk"
                @modal-close="modalClose">
            <template slot="header">
                관리자 등록
            </template>
            <template slot="body">
                <table class="popup-table">
                    <colgroup>
                        <col width="114px" />
                    </colgroup>
                    <tr>
                        <th>권한</th>
                        <td>
                            <select class="w_130" v-model="manager.role">
                                <option value="">권한</option>
                                <option value="manager">관리자</option>
                                <option value="operator">운영자</option>
                                <option value="analyst">분석자</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>아이디</th>
                        <td>
                            <div class="search-box">
                                <div class="search-box-form">
                                    <input type="text" class="search-box-form__input" placeholder="이메일을 입력하세요" v-model="manager.email">
                                    <button type="button" class="search-box-form__button" @click="checkEmail">
                                        <i class="ico-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>이름</th>
                        <td><input type="text" class="popup-table__input" placeholder="이름을 입력하세요" v-model="manager.name"></td>
                    </tr>
                </table>
            </template>
        </modal-create>
    </modal>
</template>

<script>
    export default {
        props: {

        },
        data() {
            return {
                apiUrl: '',
                error: null,
                mode: '',
                manager: {
                    id : 0,
                    role: '',
                    email: '',
                    name: ''
                },
                old: {
                    role: '',
                    email: '',
                    name: ''
                },
            };
        },
        mounted() {
        },
        computed: {
            apiCreateUrl() {
                return this.apiUrl;
            },
            apiSelectUrl() {
                let id = this.manager.id;
                if (id == 0) {
                    return '';
                }

                return this.apiUrl + '/' + id;
            },
            apiUpdateUrl() {
                let id = this.manager.id;
                if (id == 0) {
                    return '';
                }

                return this.apiUrl + '/' + id;
            },
            apiEmailCheckUrl() {
                return this.apiUrl + '/check' +  '/' + this.manager.email;
            }
        },
        methods: {
            beforeOpened (event) {
                let app = this;

                this.apiUrl     = event.params.apiUrl;
                this.mode       = event.params.mode;
                this.manager.id = event.params.id;

                this.old.role   = '';
                this.old.email  = '';
                this.old.name   = '';

                if (this.mode != 'create') {
                    this.select();
                }
            },
            beforeClosed (event) {
                this.apiUrl = '';
                this.mode   = '';

                this.manager.id     = 0;
                this.manager.role   = '';
                this.manager.email  = '';
                this.manager.name   = '';

                this.old.role   = '';
                this.old.email  = '';
                this.old.name   = '';
            },
            checkEmail: function () {
                if (this.manager.email == '') {
                    alert('이메일을 입력하세요.');
                    return;
                }

                let app = this;

                axios.get(this.apiEmailCheckUrl)
                    .then(function (response) {
                        if (response.status == 202) {
                            alert('사용 가능한 이메일입니다.');
                        } else {
                            alert('이미 가입된 이메일입니다.');
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            modalOk: function() {
                let app = this;

                if (this.manager.role == '') {
                    alert('권한을 선택하세요.');
                    return;
                }

                if (this.manager.email == '') {
                    alert('이메일을 입력하세요.');
                    return;
                }

                if (this.manager.name == '') {
                    alert('이름을 입력하세요.');
                    return;
                }

                let form = new FormData()
                form.append('role', this.manager.role);
                form.append('email', this.manager.email);
                form.append('name', this.manager.name);

                if (this.mode == 'create') {
                    this.create(form);
                } else if (this.mode == 'update') {
                    this.update(form);
                }
            },
            modalClose: function() {
                this.$modal.hide('admin-manager-modal-create');
            },
            create(form) {
                let app = this;

                axios.post(this.apiCreateUrl, form)
                    .then(function (response) {

                        if (response.status == 201) {
                            app.$modal.hide('admin-manager-modal-create');
                            app.$emit("update-list");
                        } else {
                            alert('이메일이 중복되었습니다');
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            select() {
                let app = this;

                axios.get(this.apiSelectUrl)
                    .then(function (response) {

                        app.manager     = response.data.data;

                        app.old.role    = app.manager.role;
                        app.old.email   = app.manager.email;
                        app.old.role    = app.manager.role;
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            update(form) {

                if (this.old.role   == this.manager.role &&
                    // this.old.email  == this.manager.email &&
                    this.old.name   == this.manager.name) {

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
                            app.$modal.hide('admin-manager-modal-create');
                            app.$emit("update-list");
                        } else {
                            alert('이메일이 중복되었습니다');
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
        }
    }
</script>

<style scoped>

</style>