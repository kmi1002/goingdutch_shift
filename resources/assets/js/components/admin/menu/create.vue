<template>
    <modal
            name="admin-menu-modal-create"
            width="425"
            height="auto"
            @before-open="beforeOpened"
            @before-close="beforeClosed">
        <modal-create
                @modal-ok="modalOk"
                @modal-close="modalClose">
            <template slot="header">
                메뉴 등록
            </template>
            <template slot="body">
                <table class="popup-table">
                    <colgroup>
                        <col width="114px" />
                    </colgroup>
                    <tr>
                        <th>이름(한글)</th>
                        <td><input type="text" class="popup-table__input" v-model="menu.title"></td>
                    </tr>
                    <tr>
                        <th>이름(영문)</th>
                        <td><input type="text" class="popup-table__input" v-model="menu.sub_title"></td>
                    </tr>
                    <tr>
                        <th>소개</th>
                        <td><textarea class="textarea" v-model="menu.description"></textarea></td>
                    </tr>
                    <tr>
                        <th>유의사항</th>
                        <td><textarea class="textarea" v-model="menu.caution"></textarea></td>
                    </tr>
                    <tr>
                        <th>이미지</th>
<!--                        <td><input type="file" id="input-file" class="upload-hidden" name="file[]"></td>-->
                        <td>
                        <div class="file-form">
                            <input type="text" class="file-form__name" v-model="menu.fileName" disabled="disabled">
                            <label for="input-file">업로드</label>
                            <input type="file" ref="file" id="input-file" class="upload-hidden" accept="image/jpeg, image/png" v-on:change="handleFileUpload()">
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <th>메뉴 카테고리</th>
                        <td>
                            <select class="w_130" v-model="menu.group_id" @change="changeGroup">
                                <option v-for="(_group, _index) in groups" :value="_group.id" :selected="_group.id === menu.group_id">{{ _group.title }}</option>
                            </select>
                        </td>
                    </tr>
<!--                    <tr>-->
<!--                        <th>옵션 카테고리</th>-->
<!--                        <td>-->
<!--                            <select class="w_130" name="item_category_idx">-->
<!--                                <option v-for="(_option, _index) in options" :value="_option.id" :selected="_group.id === parentId">{{ _group.title }}</option>-->
<!--                            </select>-->
<!--                        </td>-->
<!--                    </tr>-->
                    <tr>
                        <th>원본 가격</th>
                        <td><input type="text" class="popup-table__input" v-model="menu.original_price"></td>
                    </tr>
                    <tr>
                        <th>할인 가격</th>
                        <td><input type="text" class="popup-table__input" v-model="menu.discount_price"></td>
                    </tr>
                    <tr>
                        <th>할인 퍼센트(%)</th>
                        <td><input type="text" class="popup-table__input" v-model="menu.discount_percent"></td>
                    </tr>
                    <tr>
                        <th>최종 가격</th>
                        <td>{{ calcPrice(menu.original_price, menu.discount_price, menu.discount_percent) }}</td>
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
                vendor_id: 0,
                apiUrl: '',
                groupApiUrl: '',
                optionApiUrl: '',
                error: null,
                id: 0,
                mode: '',
                menu: {},
                groups: {},
                options: {},
                old: {},
                file: '',
                fileName: '파일선택',
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
                let id = this.id;

                if (id == 0) {
                    return '';
                }

                return this.apiUrl + '/' + id;
            },
            apiUpdateUrl() {
                let id = this.id;
                if (id == 0) {
                    return '';
                }

                return this.apiUrl + '/' + id;
            },
        },
        methods: {
            beforeOpened (event) {
                let app = this;

                this.apiUrl         = event.params.apiUrl;
                this.groupApiUrl    = event.params.groupApiUrl;
                this.optionApiUrl   = event.params.optionApiUrl;
                this.mode           = event.params.mode;

                this.vendor_id      = event.params.vendor_id;
                this.id             = event.params.id;
                this.old            = {};

                this.groupSelect();
                this.optionSelect();

                if (this.mode != 'create') {
                    this.select();
                }
            },
            beforeClosed (event) {
                this.apiUrl = '';
                this.mode   = '';

                this.menu = {};
                this.old = {};
            },
            modalOk: function() {
                let app = this;

                // if (this.file == '') {
                //     alert('파일을 선택하세요.');
                //     return;
                // }

                let form = new FormData()
                form.append('vendor_id', this.vendor_id);
                form.append('title', this.menu.title);
                form.append('sub_title', this.menu.sub_title);
                form.append('description', this.menu.description);
                form.append('caution', this.menu.caution);
                form.append('original_price', this.menu.original_price);
                form.append('discount_price', this.menu.discount_price);
                form.append('discount_percent', this.menu.discount_percent);
                form.append('group_id', this.menu.group_id);

                if (this.mode == 'create') {
                    this.create(form);
                } else if (this.mode == 'update') {
                    this.update(form);
                }
            },
            modalClose: function() {
                this.$modal.hide('admin-menu-modal-create');
            },
            create(form) {
                let app = this;

                axios.post(this.apiCreateUrl, form)
                    .then(function (response) {

                        if (response.status == 201) {
                            app.$modal.hide('admin-menu-modal-create');
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
                        app.menu = response.data.data;
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            groupSelect() {
                let app = this;

                axios.get(this.groupApiUrl)
                    .then(function (response) {
                        console.log(response);
                        app.groups = response.data.data;
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            optionSelect() {
                // let app = this;
                //
                // axios.get(this.optionApiUrl)
                //     .then(function (response) {
                //         console.log(response);
                //
                //     })
                //     .catch(function (response) {
                //         app.error = response;
                //     });
            },
            update(form) {

                if (this.menu === this.old) {
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
                            app.$modal.hide('admin-menu-modal-create');
                            app.$emit("update-list");
                        } else {
                            alert('이메일이 중복되었습니다');
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                    });
            },
            modalClose: function() {
                this.$modal.hide('admin-menu-modal-create');
                app.$emit("update-list");
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
                this.fileName = this.file.name;
            },
            changeGroup: function() {
            },
        }
    }
</script>

<style scoped>

</style>