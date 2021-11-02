<template>
    <div class="card">
        <div class="card-header">
            <p class="header-text">Register</p>
        </div>
        <div class="card-body">
            <form ref="form">
                <div class="form-left">
                    <label for="name">Name</label>
                    <div class="invalid-feedback"></div>
                    <label for="email">E-Mail Address</label>
                    <div class="invalid-feedback"></div>
                    <label for="password">Password</label>
                    <div class="invalid-feedback"></div>
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="form-right">
                    <input id="name" type="text" v-model="form.name" max="8" required>
                    <div class="invalid-feedback"></div>
                    <input id="email" type="email" v-model="form.email" required>
                    <div class="invalid-feedback"></div>
                    <input id="password" type="text" v-model="form.password" min="6" required>
                    <div class="invalid-feedback"></div>
                    <input id="password_confirmation" type="text" v-model="form.password_confirmation" min="6" required>
                    <div class="invalid-feedback"></div>
                    <button v-on:click="formSubmit" class="btn">Register</button>
                </div>
                <!-- change br to flex & padding -->
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