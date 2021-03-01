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
            <button type="button" class="modal-footer__button--done" v-text="textDone" @click="done"></button>
        </footer>
    </section>
</template>

<script>
    export default {
        name: 'modal-alert',
        props: {
            text: {
                type: String,
                default: '제목'
            },
            textDone: {
                type: String,
                default: '확인'
            }
        },
        mounted() {
        },
        methods: {
            close() {
                this.$emit('modal-close');
            },
            done() {
                this.$emit('modal-ok');
            },
        },
    }
</script>

<style >


</style>