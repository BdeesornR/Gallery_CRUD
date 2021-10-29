<!--onCreated send post to see if remember token match one in cookie-->

<template>
    <div class="card">
        <div class="card-header">
            <p class="header-text">Login</p>
        </div>
        <div class="card-body">
            <form ref="form">
                <div class="formGroup">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="email" v-model="form.email">
                </div>
                <div class="formGroup">
                    <label for="password">Password</label>
                    <input id="password" type="text" v-model="form.password">
                </div>
                <div class="formGroup">
                    <input id="persist" type="checkbox" v-model="form.persist" value="persist">
                    <label for="persist">Remember Me</label>
                </div>
                <div class="formGroup">
                    <button v-on:click="formSubmit">Login</button>
                </div>
                <p>Forgot Your Password ?</p>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import store from "../store";

export default {
    name: 'Login',
    data: () => ({
        form: {
            email: '',
            password: '',
            persist: false,
        }
    }),
    methods: {
        formSubmit(event){
            event.preventDefault();
            axios.get('sanctum/csrf-cookie')
                .then(() => {
                    axios.post('/api/login', this.form)
                        .then((res) => {
                            store.commit('setEmail', res.data.email);
                            this.$router.replace({name: 'home'});
                        })
                        .catch(err => {
                            console.log(err);
                        })
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
</script>