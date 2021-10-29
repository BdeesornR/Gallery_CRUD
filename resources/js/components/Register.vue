<template>
    <div class="card">
        <div class="card-header">
            <p class="header-text">Register</p>
        </div>
        <div class="card-body">
            <form ref="form">
                <div class="formGroup">
                    <label for="name">Name</label>
                    <input id="name" type="text" v-model="form.name">
                </div>
                <div class="formGroup">
                    <label for="email">E-Mail Address</label>
                    <input id="email" type="email" v-model="form.email">
                </div>
                <div class="formGroup">
                    <label for="password">Password</label>
                    <input id="password" type="text" v-model="form.password">
                </div>
                <div class="formGroup">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="text" v-model="form.password_confirmation">
                </div>
                <div class="formGroup">
                    <button v-on:click="formSubmit">Register</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import store from "../store";

export default {
    name: 'Signup',
    data: () => ({
        form: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }
    }),
    methods: {
        formSubmit(event){
            event.preventDefault();
            axios.get('sanctum/csrf-cookie')
                .then(() => {
                    axios.post('/api/register', this.form)
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