require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router/dist/vue-router.js';
import YmapPlugin from 'vue-yandex-maps'
import {store} from './store/index'
import moment from 'vue-moment';
import swal from 'sweetalert';


Vue.use(moment);
Vue.use(YmapPlugin);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
// Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name=_token]').attr('content');

const Example = Vue.component('example', require('./components/ExampleComponent.vue'));
const App = Vue.component('app', require('./components/App.vue'));
const Yandex = Vue.component('yandex', require('./components/Yandex.vue'));
const Propose = Vue.component('propose', require('./components/Propose.vue'));
const Admin = Vue.component('admin', require('./components/Admin.vue'));

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path:"/example", name:'example', component: Example},
        { path:"/yandex", name:'yandex', component: Yandex},
        { path:"/propose", name:'propose', component: Propose},
        { path:"/admin", name:'admin', component: Admin},
    ]
});

const app = new Vue({
    el: '#app',
    router,
    store,
});