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
})

export default router;
