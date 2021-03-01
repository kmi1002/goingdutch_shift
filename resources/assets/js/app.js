
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// vue ie11 대응 (https://lovemewithoutall.github.io/it/vue-ie-support-with-es6-promise/)
import 'es6-promise/auto';
import 'babel-polyfill';

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#wrap'
// });


/**
 * 외부 라이브러리
 */

// swiper (https://github.com/surmon-china/vue-awesome-swiper)
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
Vue.use(VueAwesomeSwiper, /* { default global options } */)

// date (https://github.com/brockpetrie/vue-moment)
import VueMoment from 'vue-moment'
Vue.use(VueMoment)

// paginate (https://github.com/lokyoung/vuejs-paginate)
import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)

// modal (https://github.com/euvl/vue-js-modal)
import VModal from 'vue-js-modal'
Vue.use(VModal, { dynamic: true, injectModalsContainer: true })

// Froala (https://github.com/froala/vue-froala-wysiwyg)
import VueFroala from 'vue-froala-wysiwyg'
Vue.use(VueFroala)


// Vue I18n(http://kazupon.github.io/vue-i18n/introduction.html)
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)


import 'es6-promise/auto'
import 'babel-polyfill'

import VueHtml2Canvas from 'vue-html2canvas';
Vue.use(VueHtml2Canvas);


import VueElementLoading from 'vue-element-loading';
Vue.component('VueElementLoading', VueElementLoading);

import priceHelper from './components/mixins/price';
Vue.mixin(priceHelper);


/**
 * 모달 (상속 받아서 사용하면 된다)
 */

Vue.component('modal-alert', require('./components/modal/alert.vue').default);
Vue.component('modal-create', require('./components/modal/create.vue').default);
Vue.component('modal-read', require('./components/modal/read.vue').default);
Vue.component('modal-update', require('./components/modal/update.vue').default);
Vue.component('modal-delete', require('./components/modal/delete.vue').default);
Vue.component('modal-none', require('./components/modal/none.vue').default);

Vue.component('layout-box', require('./components/layout/layout-box.vue').default);


Vue.component('modal-qr', require('./components/common/qr/show.vue').default);


/**
 * 관리자
 */
Vue.component('admin-title-box', require('./components/admin/title-box.vue').default);
Vue.component('admin-condition-box', require('./components/admin/condition-box.vue').default);
Vue.component('admin-condition-revision-box', require('./components/admin/condition-revision-box.vue').default);
Vue.component('admin-manager-modal-create', require('./components/admin/manager/create.vue').default);
Vue.component('admin-vendor-modal-create', require('./components/admin/vendor/create.vue').default);
Vue.component('admin-menu-modal-create', require('./components/admin/menu/create.vue').default);
Vue.component('admin-article-group-create', require('./components/admin/article/group/create.vue').default);

Vue.component('user-menu-cart-modal-select', require('./components/user/menu/cart/select.vue').default);
Vue.component('user-menu-order-modal-select', require('./components/user/menu/order/select.vue').default);
