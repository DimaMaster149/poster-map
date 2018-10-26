require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router/dist/vue-router.js';
import YmapPlugin from 'vue-yandex-maps'
import {store} from './store/index'

Vue.use(YmapPlugin)
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
// Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name=_token]').attr('content');

const Example = Vue.component('example', require('./components/ExampleComponent.vue'));
const App = Vue.component('app', require('./components/App.vue'));
const Yandex = Vue.component('yandex', require('./components/Yandex.vue'));

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path:"/example", name:'example', component: Example},
        { path:"/yandex", name:'yandex', component: Yandex},
    ]
});

const app = new Vue({
    el: '#app',
    router,
    store,
});