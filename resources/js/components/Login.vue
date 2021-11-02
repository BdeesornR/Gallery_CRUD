<!--onCreated send post to see if remember token match one in cookie-->

<template>
    <div class="card">
        <div class="card-header">
            <p class="header-text">Login</p>
        </div>
        <div class="card-body">
            <form ref="form">
                <div class="form-left">
                    <label for="email">E-Mail Address</label>
                    <label for="password">Password</label>
                </div>
                <div class="form-right">
                    <input id="email" type="email" v-model="form.email">
                    <input id="password" type="text" v-model="form.password">
                    <div style="display: flex; align-content: center">
                        <input id="persist" type="checkbox" v-model="form.persist" value="persist" style="margin-right: 8px">
                        <label for="persist">Remember Me</label>
                    </div>
                    <div style="display: flex; align-items: center">
                        <button v-on:click="formSubmit" class="btn">Login</button>
                        <p style="color: #90c4e5">Forgot Your Password ?</p>
                    </div>
                </div>
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
                .then((res) => {
                    axios.post('/api/login', this.form)
                        .then((res) => {
                            store.commit('setState', [res.data.email, res.data.username]);
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