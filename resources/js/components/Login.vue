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

export default {
    name: 'Login',
    data: () => ({
        form: {
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            email: '',
            password: '',
            persist: '',
        }
    }),
    methods: {
        formSubmit(event){
            event.preventDefault();
            axios.post('http://127.0.0.1/login', this.form)
                .then(res => {
                    this.$router.replace({ name: 'home' });
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
</script>