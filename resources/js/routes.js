import Home from './components/Home';
import Gallery from './components/Gallery';
import Login from './components/Login';
import Register from './components/Register';

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
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
            path: '/gallery',
            name: 'gallery',
            component: Gallery,
        }
    ]
}