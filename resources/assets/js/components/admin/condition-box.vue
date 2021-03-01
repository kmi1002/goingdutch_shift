<template>
    <div class="condition-box">
        <div class="condition-box__left">
            <slot name="filter"></slot>
        </div>
        <div class="condition-box__right search-box">
            <form v-on:submit.prevent="filterChange" class="search-box-form">
                <input type="text" class="search-box-form__input" :placeholder="txtPlaceholderSearch" v-model="tmpSearch">
                <button class="search-box-form__button">
                    <i class="ico-search"></i>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            txtPlaceholderSearch: {
                type: String,
                default: '검색'
            },
            search: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                tmpSearch: this.search
            };
        },
        created() {
        },
        mounted() {
        },
        methods: {
            filterChange: function () {
                this.$emit("update-search", this.tmpSearch)
            }
        }
    }
</script>

<style scoped>

</style>