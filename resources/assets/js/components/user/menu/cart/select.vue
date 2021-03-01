<template>
    <modal
            name="user-menu-cart-modal-select"
            width="320"
            height="auto"
    >
        <modal-none
                v-on:modal-close="modalClose">
            <template slot="body">
                <p style="color: #505050; text-align: center; line-height: 30px; font-size: 16px; font-weight: bold">선택하신 메뉴가 장바구니에 담겼습니다<br>장바구니를 확인하시겠습니까?</p>
                <div class="cart__type mt-15" style="text-align: center">
                    <button type="button" class="cart__type-item cart__type-item--shopping" @click="shopping">메뉴 더보기</button>
                    <button type="button" class="cart__type-item cart__type-item--cart" @click="cart">확인</button>
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
                this.$modal.hide('user-menu-cart-modal-select');
            },
            shopping: function() {
                this.$modal.hide('user-menu-cart-modal-select');
                this.$emit('select-cart-type', 'shopping');
            },
            cart: function() {
                this.$modal.hide('user-menu-cart-modal-select');
                this.$emit('select-cart-type', 'cart');
            }
        }
    }
</script>

<style scoped>

</style>