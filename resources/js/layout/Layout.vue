<template>
    <div class="layout">
        <nav class="navbar">
            <div class="left">
                <p class="app-title">Simple Image Gallery</p>
                <router-link v-if="this.$store.state.email" :to="{ name: 'home' }">Home</router-link>
                <router-link v-if="this.$store.state.email" :to="{ name: 'gallery' }">Gallery</router-link>
            </div>
            <div class="right">
                <div>
                    <router-link v-if="!this.$store.state.email" :to="{ name: 'login' }">Login</router-link>
                    <router-link v-if="!this.$store.state.email" :to="{ name: 'register' }">Register</router-link>
                    <div v-if="this.$store.state.email">
                        <button v-on:click="logout">{{ this.$store.state.username }}</button>
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

    export default {
        methods: {
            logout(){
                axios.post('/api/logout', {'email': this.$store.state.email})
                    .then(() => {
                        this.$store.commit('flushState');
                        this.$router.replace('/login');
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>