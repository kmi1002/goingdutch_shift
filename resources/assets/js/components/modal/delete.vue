<template>
    <section class="modal">
        <header class="modal-header">
            <slot name="header">
                Header
            </slot>
            <button type="button" class="modal-header__close" @click="close">
                <i class="ico-modal-close"></i>
            </button>
        </header>
        <div class="modal-body">
            <slot name="body">
                body
            </slot>
        </div>
        <footer class="modal-footer">
            <button type="button" class="modal-footer__button--ok" v-text="textOk" @click="ok"></button>
            <button type="button" class="modal-footer__button--cancel" v-text="textCancel" @click="cancel"></button>
        </footer>
    </section>
</template>

<script>
    export default {
        name: 'modal-delete',
        props: {
            text: {
                type: String,
                default: '제목'
            },
            textOk: {
                type: String,
                default: '삭제'
            },
            textCancel: {
                type: String,
                default: '취소'
            },
        },
        mounted() {
        },
        methods: {
            close() {
                this.$emit('modal-close');
            },
            ok() {
                this.$emit('modal-ok');
            },
            cancel() {
                this.close();
            }
        },
    }
</script>

<style >


</style>