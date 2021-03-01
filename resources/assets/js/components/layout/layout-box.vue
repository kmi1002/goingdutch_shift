<template>
    <div class="l-box">
        <header class="l-box__header">
            <div class="l-box__header-left">
                <h2 class="l-box__title">{{ title }}</h2>
            </div>
            <div class="l-box__header-right">
                <ul class="l-box__filter">
                    <slot name="filter" v-if="isMoreUrlEmpty">
                        Filter
                    </slot>
                    <li class="l-box__filter__more">
                        <a :href="moreUrl">
                            <span>{{ moreTitle }}</span>
                            <i class="ico-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <div class="l-box__body">
            <vue-element-loading
                    :active="isLoading"
                    spinner="bar-fade-scale">
            </vue-element-loading>
            <slot name="body">
                Body
                <slot name="empty">
                    <ul class="empty__list">
                        <li class="empty__item">{{ emptyText }}</li>
                    </ul>
                </slot>
            </slot>
            <slot name="more">
                <div class="ranking__more">
                    <a :href="moreUrl" class="ranking__more--red" v-if="moreUrl">{{ moreTitle }}</a>
                    <button class="ranking__more--button-red" @click="more" v-if="!moreUrl && isNext">{{ moreTitle }}</button>
                </div>
            </slot>
        </div>
        <div class="l-box__footer">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                default: ''
            },
            emptyList: {
                type: String,
                default: ''
            },
            moreUrl: {
                type: String,
                default: ''
            },
            isLoading: {
                type: Boolean,
                default: false
            },
            emptyText: {
                type: String,
                default: 'empty'
            }
        },
        computed: {
            isEmpty() {
                return (this.users === undefined) && (this.users === null) && (this.users.length === 0);
            },
            isMoreUrlEmpty() {
                return (this.moreUrl === undefined) || (this.moreUrl == null) || (this.moreUrl == '');
            },
            isNext() {
                return this.paginate.total > 0 && this.paginate.current_page < this.paginate.last_page;
            },
            hrefTarget() {
                return (!this.moreUrl && this.isNext ? "_blank" : "_self");
            },
            noopener() {
                return (!this.moreUrl && this.isNext ? "noopener" : "");
            }
        },
    }
</script>

<style scoped>

</style>