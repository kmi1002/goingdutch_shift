<template>
    <modal
            name="modal-qr"
            width="256"
            height="auto"
            @before-open="beforeOpened"
            @before-close="beforeClosed">
        <qr-code :text=url></qr-code>
    </modal>
</template>

<script>
    import VueQRCodeComponent from 'vue-qrcode-component';

    export default {
        components: {
            'qr-code' : VueQRCodeComponent
        },
        props: {
            text: {
                type: String,
                default: '제목'
            },
        },
        data() {
            return {
                url: '',
                error: null,
            };
        },
        mounted() {
        },
        methods: {
            beforeOpened (event) {
                let app = this;
                this.url = event.params.url;
            },
            beforeClosed (event) {
                this.apiUrl = '';
                this.file   = '';
            },
        },
    }
</script>

<style lang="scss">


</style>