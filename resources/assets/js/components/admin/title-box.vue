<template>
    <div class="title-box">
        <div class="title-box__left">
            <slot name="header">Header</slot>
        </div>
        <div class="title-box__right" v-if="showCalendar">
            <ul class="date-search">
                <li class="date-search__range">
                    <span v-bind:class="{on : isSelectedToday}" v-on:click="rangeClick('today')" v-text="txtRangeToday"></span>
                </li>
                <li class="date-search__range responsive--hidden">
                    <span v-bind:class="{on : isSelectedWeek}" v-on:click="rangeClick('week')" v-text="txtRangeWeek"></span>
                </li>
                <li class="date-search__range  responsive--hidden">
                    <span v-bind:class="{on : isSelectedMonth}" v-on:click="rangeClick('month')" v-text="txtRangeMonth"></span>
                </li>
                <li class="date-search__range">
                    <span v-bind:class="{on : isSelectedAll}" v-on:click="rangeClick('all')" v-text="txtRangeAll"></span>
                </li>
                <li class="date-search__calander">
                    <input type="text" v-model="start_date" class="date-search__calander-datepicker" readonly>
                    <span class="date-search__calander-divider">~</span>
                    <input type="text" v-model="end_date" class="date-search__calander-datepicker" readonly>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: "title-box",
        props: {
            showCalendar: {
                type: Boolean,
                defulat: true,
            },
            txtRangeToday: {
                type: String,
                default: '오늘'
            },
            txtRangeWeek: {
                type: String,
                default: '1주일'
            },
            txtRangeMonth: {
                type: String,
                default: '1개월'
            },
            txtRangeAll: {
                type: String,
                default: '전체'
            },
        },
        data() {
            return {
                start_date: '',
                end_date: '',
                search_range: 'all',
                first: true,
            };
        },
        created() {
        },
        mounted() {
            if (this.showCalendar) {
                this.updateRange();
            }
        },
        computed: {
            isSelectedAll: function() {
                return this.search_range === 'all';
            },
            isSelectedMonth: function() {
                return this.search_range === 'month';
            },
            isSelectedWeek: function() {
                return this.search_range === 'week';
            },
            isSelectedToday: function() {
                return this.search_range === 'today';
            }
        },
        methods: {
            updateRange: function() {

                if (this.search_range === 'today') {
                    this.start_date = this.addDay();
                    this.end_date = this.addDay();
                } else if (this.search_range === 'week') {
                    this.start_date = this.addDay(-7);
                    this.end_date = this.addDay();
                } else if (this.search_range === 'month') {
                    this.start_date = this.addMonth(-1);
                    this.end_date = this.addDay();
                } else if (this.search_range === 'all') {
                    this.start_date = '2017-02-01';
                    this.end_date = this.addDay();
                }

                if (!this.first) {
                    // this.$emit("update-date-range", this.start_date, this.end_date)
                }
                this.first = false;
            },
            rangeClick: function(range) {
                this.search_range = range;
                this.updateRange();
            },
            addDay: function(day = 0) {
                return this.$moment(new Date()).add(day, 'days').format('YYYY-MM-DD');
            },
            addMonth: function(month = 0) {
                return this.$moment(new Date()).add(month, 'months').format('YYYY-MM-DD');
            }
        }
    }
</script>

<style scoped>

</style>