require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router/dist/vue-router.js';
import YmapPlugin from 'vue-yandex-maps'

Vue.use(YmapPlugin)
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
// Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name=_token]').attr('content');

const Example = Vue.component('example', require('./components/ExampleComponent.vue'));
const App = Vue.component('app', require('./components/App.vue'));

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path:"/example", name:'example', component: Example},
    ]
});

const app = new Vue({
    el: '#app',
    router,
});