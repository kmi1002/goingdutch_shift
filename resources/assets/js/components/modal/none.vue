<template>
    <section class="modal">
        <div class="modal-body">
            <slot name="body">
                Body
            </slot>
        </div>
    </section>
</template>

<script>
    export default {
        name: 'modal-none',
        props: {
            text: {
                type: String,
                default: '제목'
            },
        },
        mounted() {
        },
        methods: {
            close() {
                this.$emit('modal-close');
            },
        },
    }
</script>

<style lang="scss">


</style>