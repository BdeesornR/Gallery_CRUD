<template>
    <div class="layout">
        <nav class="navbar">
            <div class="left">
                <p class="app-title">Simple Image Gallery</p>
                <router-link v-if="$store.state.email" :to="{ name: 'home' }">Home</router-link>
                <router-link v-if="$store.state.email" :to="{ name: 'gallery' }">Gallery</router-link>
            </div>
            <div class="right">
                <div>
                    <router-link v-if="!$store.state.email" :to="{ name: 'login' }">Login</router-link>
                    <router-link v-if="!$store.state.email" :to="{ name: 'register' }">Register</router-link>
                    <div v-if="$store.state.email">
                        <button v-on:click="logout">{{ $store.state.username }}</button>
                    </div>
                </div>
            </div>
        </nav>
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import router from "../routes";
    import store from "../store";

    export default {
        created() {
            axios.get('/api/get-user')
                .then((res) => {
                    store.commit('setState', [res.data.email, res.data.username]);
                })
                .catch(err => {
                    console.log(err)
                })
        },
        methods: {
            logout(){
                axios.post('/api/logout', {'email': store.state.email})
                    .then(() => {
                        store.commit('flushState');
                        router.push('/login');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>