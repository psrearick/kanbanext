require('./bootstrap');
import Vue from "vue";
import App from "./components/App.vue";
import VueAxios from 'vue-axios';
import VModal from 'vue-js-modal'

Vue.use(VModal);
Vue.prototype.axios = window.axios;
Vue.prototype.bus= new Vue();

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
