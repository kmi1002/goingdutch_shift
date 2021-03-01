<template>
    <modal
            name="user-menu-order-modal-select"
            width="320"
            height="auto">
        <modal-none
                v-on:modal-close="modalClose"
        style="text-align: center"
        >
            <template slot="body">
                <p style="color: #505050; text-align: center; line-height: 30px; font-size: 16px; font-weight: bold">주문유형 선택</p>
                <div class="order__type">
                    <button type="button" class="order__type--receive" @click="receive"><i class="ico-receive"></i>매장주문</button>
                    <button type="button" class="order__type--delivery" @click="delivery"><i class="ico-delivery"></i>배달주문</button>
                </div>
            </template>
        </modal-none>
    </modal>
</template>

<script>
    export default {
        props: {
        },
        data() {
            return {
                role: '',
                email: ''
            };
        },
        created() {
        },
        mounted() {
        },
        methods: {
            modalClose: function() {
                this.$modal.hide('user-menu-order-modal-select');
            },
            receive: function() {
                this.$modal.hide('user-menu-order-modal-select');
                this.$emit('select-order-type', 'receive');
            },
            delivery: function() {
                this.$modal.hide('user-menu-order-modal-select');
                this.$emit('select-order-type', 'delivery');
            }
        }
    }
</script>

<style scoped>

</style>