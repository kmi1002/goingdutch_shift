<template>
    <modal
            name="admin-vendor-modal-create"
            width="425"
            height="auto"
            @before-open="beforeOpened"
            @before-close="beforeClosed">
        <modal-create
                @modal-ok="modalOk"
                @modal-close="modalClose">
            <template slot="header">
                매장 등록
            </template>
            <template slot="body">
                <div class="file-form">
                    <input type="text" class="file-form__name" v-model="fileName" disabled="disabled">
                    <label for="input-file">업로드</label>
                    <input type="file" ref="file" id="input-file" class="upload-hidden" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" multiple="" v-on:change="handleFileUpload()">
                </div>
                <div class="file-desc">
                    <p>양식을 내려 받은 다음, 내용을 채워서 업로드 해주세요</p>
                    <p>양식과 다른 경우 등록이 되지 않습니다</p>
                </div>
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
            }
        },
        methods: {
            beforeOpened (event) {
                let app = this;

                this.apiUrl = event.params.apiUrl;
            },
            beforeClosed (event) {
                this.apiUrl = '';
                this.file   = '';
            },
            modalOk: function() {

                if (this.file == '') {
                    alert('파일을 선택하세요.');
                    return;
                }

                let app = this;

                let form = new FormData()
                form.append('file', this.file);

                axios.post(this.apiCreateUrl, form, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {

                        if (response.status == 200) {
                            app.$modal.hide('admin-vendor-modal-create');
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
                this.$modal.hide('admin-vendor-modal-create');
                app.$emit("update-list");
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
                this.fileName = this.file.name;
            },
        }
    }
</script>

<style scoped>

</style>