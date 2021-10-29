<template>
    <div class="layout">
        <nav class="navbar">
            <div class="left">
                <p>Simple Image Gallery</p>
                <router-link :to="{ name: 'home' }">Home</router-link>
                <router-link :to="{ name: 'gallery' }">Gallery</router-link>
            </div>
            <div class="right">
                <router-link :to="{ name: 'login' }">Login</router-link>
                <router-link :to="{ name: 'register' }">Register</router-link>
                <button v-on:click="logout">Logout</button>
            </div>
        </nav>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import store from "../store";

    export default {
        methods: {
            logout(){
                axios.post('/api/logout')
                    .then(() => {
                        store.commit('flushEmail');
                        this.$router.push('/login');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>