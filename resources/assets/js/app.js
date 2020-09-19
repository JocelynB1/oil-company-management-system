import VueAxios from 'vue-axios';
import axios from 'axios';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./jquery-ui.min');
var Chart=require('chart.js');

window.Vue = require('vue');
Vue.use(VueAxios, axios);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('product-sales-from-total-litres', require('./components/ProductSalesFromTotalLitres.vue'));
Vue.component('product-sales-per-type', require('./components/ProductSalesPerType.vue'));
Vue.component('product-sales-per-date', require('./components/ProductSalesPerDate.vue'));
Vue.component('outstanding-inventory', require('./components/OutstandingInventory.vue'));

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
