export default {
    name: 'tmpLayout',
    data() {
        return {
        };
    },
    methods: {
        priceFormat(number) {
            return new Intl.NumberFormat('ko-KR', { maximumSignificantDigits: 3 }).format(number) + '원';
        },
        percentFormat(number) {
            return number + '%';
        },
        calcPrice(original_price, discount_price, discount_percent) {
            if (discount_price > 0 && discount_percent > 0) {
                return '오류!!';
            }

            if (discount_price) {
                if (original_price < discount_price) {
                    return '오류!!';
                }

                return this.priceFormat(original_price - discount_price);
            }

            if (discount_percent) {
                let discount_price = original_price * (discount_percent / 100);
                if (original_price < discount_price) {
                    return '오류!!';
                }

                return this.priceFormat(original_price - discount_price);
            }

            return this.priceFormat(original_price);
        },
    }
}
