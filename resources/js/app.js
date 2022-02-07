import axios from "axios";

require('./bootstrap');
window.Vue = require('vue').default;

import Vue from "vue";
import Vuex from "vuex";
import VueRouter from "vue-router";
import VueCookies from "vue-cookies";
import Layout from './layout/Layout';
import '../css/app.css';
import Login from "./components/Login";
import Register from "./components/Register";
import Home from "./components/Home";
import Gallery from "./components/Gallery";

import {
    FontAwesomeIcon
} from "@fortawesome/vue-fontawesome";
import {
    library
} from "@fortawesome/fontawesome-svg-core";
import {
    faCloudUploadAlt
} from "@fortawesome/free-solid-svg-icons";

library.add(faCloudUploadAlt);

Vue.component("font-awesome-icon", FontAwesomeIcon);

Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(VueCookies);
Vue.use(VueRouter);

const store = new Vuex.Store({
    state: {
        userId: null,
        username: null,
    },
    mutations: {
        setState(state, [userId, username]) {
            state.userId = userId;
            state.username = username;
        },
        flushState(state) {
            state.userId = null;
            state.username = null;
        },
    },
    actions: {
        fetchUser() {
            return axios.get('/api/get-user');
        }
    }
});

const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
        },
        {
            path: '/gallery',
            name: 'gallery',
            component: Gallery,
        },
        {
            path: '*',
            redirect: store.state.email ? '/home' : '/login'
        }
    ]
});

const routerGuardRules = () => (
    router.beforeEach((to, from, next) => {
        if (store.state.username && (to.name === 'login' || to.name === 'register')) {
            next('/home');
        } else next();
        if (!store.state.username && (to.name === 'home' || to.name === 'gallery')) {
            next('/login');
        } else next();
    })
);

const renderApplication = () => (
    new Vue({
        el: '#app',
        store: store,
        router: router,
        render: h => h(Layout),
    })
);

store.dispatch('fetchUser').then((res) => {
    store.commit('setState', [res.data['user_id'], res.data['username']]);
    routerGuardRules();
    renderApplication();
}).catch((err) => {
    console.log(err);
    store.commit('flushState');
    routerGuardRules();
    renderApplication();
});
