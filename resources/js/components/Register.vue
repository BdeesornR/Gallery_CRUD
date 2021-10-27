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

export default {
    name: 'Signup',
    data: () => ({
        form: {
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }
    }),
    methods: {
        formSubmit(event){
            event.preventDefault();
            axios.post('http://127.0.0.1/register', this.form)
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