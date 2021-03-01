<template>
    <div class="condition-box">
        <div class="condition-box__left">
            <select v-model="filter.platform" @change="changeFilter">
                <option value="">플랫폼</option>
                <option value="web">Web</option>
                <option value="ios">iOS</option>
                <option value="android">Android</option>
            </select>
            <select v-model="filter.language" @change="changeFilter">
                <option value="">언어</option>
                <option value="ko">한국어</option>
            </select>
            <select v-model="filter.revision" @change="changeRevision">
                <option value="0">리비전</option>
                <option v-for="(_revision, _index) in revisions" :value="_revision.id" :selected="_index === filter.revision" v-text="_revision.version"></option>
            </select>
        </div>
        <div class="condition-box__right">
            <button type="button" class="btn-blue" @click="ok" v-text="txtOk"></button>
            <button type="button" class="btn-blue" @click="cancel" v-text="txtCancel" v-if="createMode"></button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'condition-revision-box',
        props: {
            apiUrl: {
                type: String,
                default: null
            },
            createMode: {
                type: Boolean,
                default: false
            },
            groupCode: {
                type: String,
                default: ''
            },
            platform: {
                type: String,
                default: ''
            },
            language: {
                type: String,
                default: ''
            },
            txtOk: {
                type: String,
                default: '만들기'
            },
            txtCancel: {
                type: String,
                default: '취소'
            }
        },
        data() {
            return {
                filter: {
                    group_code: this.groupCode,
                    platform: this.platform,
                    language: this.language,
                    revision: 0
                },
                revisions:[],
                error: null,
            };
        },
        created() {
            this.fetch();
        },
        mounted() {
        },
        methods: {
            fetch: function() {
                let app = this;

                if (this.createMode) {
                    return;
                }

                if (this.apiUrl == null) {
                    alert('API URL 잘못되었습니다. 개발자에게 문의하세요.');
                    return;
                }

                if (this.filter.platform == '' || this.filter.language == '') {
                    return;
                }

                axios.get(this.apiUrl, {
                    params: {
                        group_code: this.filter.group_code,
                        platform: this.filter.platform,
                        language: this.filter.language,
                    }
                })
                    .then(function (response) {

                        app.revisions = response.data.data;
                        app.filter.revision = 0;

                        if (app.revisions.length > 0) {
                            app.filter.revision = app.revisions[0].id;

                            app.$emit('change-revision', app.filter.revision);
                        }
                    })
                    .catch(function (response) {
                        app.error = response;
                        console.log('condition-revision-box error : ' + response);
                    });
            },
            changeFilter: function() {
                this.fetch();

                this.$emit('change-filter', this.filter.platform, this.filter.language);
            },
            changeRevision: function() {
                this.$emit('change-revision', this.filter.revision);
            },
            ok: function () {
                this.$emit('revision-ok');
            },
            cancel: function () {
                this.$emit('revisoon-cancel');
            }
        }
    }
</script>

<style scoped>

</style>