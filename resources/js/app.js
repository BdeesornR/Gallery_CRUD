import Vue from 'vue';
import VueRouter from "vue-router";
import routes from './routes';
import Layout from './layout/Layout';
import '../css/app.css';

Vue.use(VueRouter);

let app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    render: h => h(Layout),
});
