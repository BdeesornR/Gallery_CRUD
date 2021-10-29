require('./bootstrap');
window.Vue = require('vue').default;

import Vue from "vue";
import Layout from './layout/Layout';
import '../css/app.css';
import store from "./store";
import router from "./routes";

const app = new Vue({
    el: '#app',
    store: store,
    router: router,
    render: h => h(Layout),
});

export default app;