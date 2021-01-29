require('./bootstrap');
import Vue from "vue";
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import App from "./components/App.vue";
import VueAxios from 'vue-axios';
import {routes} from './routes';

Vue.prototype.axios = window.axios;

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App)
});
