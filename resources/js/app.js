import axios from "axios";

require('./bootstrap');
window.Vue = require('vue').default;

import Vue from "vue";
import Vuex from "vuex";
import VueRouter from "vue-router";
import Layout from './layout/Layout';
import '../css/app.css';
import Login from "./components/Login";
import Register from "./components/Register";
import Home from "./components/Home";
import Gallery from "./components/Gallery";

Vue.use(Vuex);
Vue.use(VueRouter);

const store = new Vuex.Store({
    state: {
        email: null,
        username: null,
    },
    mutations: {
        setState (state, [email, username]) {
            state.email = email;
            state.username = username;
        },
        flushState (state) {
            state.email = null;
            state.username = null;
        },
    },
    actions: {
        fetchData () {
            return axios.get('/api/get-user')
        }
    }
});

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
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
            redirect: store.state.email ? '/login' : '/home'
        }
    ]
});

const routerGuardRules = () => (
    router.beforeEach((to, from, next) => {
        if (to.name === 'login' && store.state.email) {
            next ('/home');
        } else next();
        if (to.name === 'register' && store.state.email) {
            next ('/home');
        } else next();
        if (to.name === 'home' && !store.state.email) {
            next ('/login');
        } else next();
        if (to.name === 'gallery' && !store.state.email) {
            next ('/login');
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

store.dispatch('fetchData').then((res) => {
    store.commit('setState', [res.data.email, res.data.username]);
    routerGuardRules();
    renderApplication();
}).catch((err) => {
    routerGuardRules();
    renderApplication();
})