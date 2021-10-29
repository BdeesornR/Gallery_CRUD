import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";
import Home from './components/Home';
import Gallery from './components/Gallery';
import Login from './components/Login';
import Register from './components/Register';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: (to, from, next) => {
                if (store.state.email) {
                    next('/home')
                } else {
                    next()
                }
            },
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            beforeEnter: (to, from, next) => {
                if (store.state.email) {
                    next('/home')
                } else {
                    next()
                }
            },
        },
        {
            path: '/home',
            name: 'home',
            component: Home,
            beforeEnter: (to, from, next) => {
                if (!store.state.email) {
                    next('/login')
                } else {
                    next()
                }
            },
        },
        {
            path: '/gallery',
            name: 'gallery',
            component: Gallery,
            beforeEnter: (to, from, next) => {
                if (!store.state.email) {
                    next('/login')
                } else {
                    next()
                }
            },
        },
        {
            path: '*',
            redirect: store.state.email ? '/home' : '/login'
        }
    ]
})

export default router;
