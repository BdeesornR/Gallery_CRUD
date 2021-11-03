<template>
    <div class="card">
        <div class="card-header">
            <p class="header-text">Register</p>
        </div>
        <div class="card-body">
            <form ref="form">
                <div class="form-left">
                    <label for="name">Name</label>
                    <div :class="this.errMsg.divName"></div>
                    <label for="email">E-Mail Address</label>
                    <div :class="this.errMsg.divEmail"></div>
                    <label for="password">Password</label>
                    <div :class="this.errMsg.divPassword"></div>
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="form-right">
                    <input id="name" type="text" v-model="form.name" @blur="inputChangeHandler">
                    <div :class="this.errMsg.divName">{{ this.errMsg.errName }}</div>
                    <input id="email" type="email" v-model="form.email" @blur="inputChangeHandler">
                    <div :class="this.errMsg.divEmail">{{ this.errMsg.errEmail }}</div>
                    <input id="password" type="text" v-model="form.password" @blur="inputChangeHandler">
                    <div :class="this.errMsg.divPassword">{{ this.errMsg.errPassword }}</div>
                    <input id="password_confirmation" type="text" v-model="form.password_confirmation" @blur="inputChangeHandler">
                    <div :class="this.errMsg.divConfirm">{{ this.errMsg.errConfirmPassword }}</div>
                    <button v-on:click="formSubmit" class="btn">Register</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { inputValidation, responseErrorsHandler } from "../formValidation";

export default {
    name: 'Signup',
    data: () => ({
        errMsg: {
            divName: 'msg',
            divEmail: 'msg',
            divPassword: 'msg',
            divConfirm: 'msg',
            errName: null,
            errEmail: null,
            errPassword: null,
            errConfirmPassword: null,
            errInputName: '',
            errInputEmail: '',
            errInputPassword: '',
            errInputConfirmPassword: '',
        },
        form: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }
    }),
    methods: {
        inputChangeHandler(e){
            if (e.target.id !== 'password_confirmation') {
                this.errMsg = inputValidation(this.errMsg, e.target.id, e.target.value);
            } else {
                if (e.target.value.length === 0) {
                    this.errMsg.errConfirmPassword = 'Password Confirmation is required';
                    this.errMsg.errInputConfirmPassword = 'err-msg';
                    this.errMsg.divConfirm = 'msg err-msg';
                } else if (e.target.value !== this.form.password) {
                    this.errMsg.errConfirmPassword = 'Passwords are not matched';
                    this.errMsg.errInputConfirmPassword = 'err-msg';
                    this.errMsg.divConfirm = 'msg err-msg';
                } else {
                    this.errMsg.errConfirmPassword = null;
                    this.errMsg.errInputConfirmPassword = '';
                    this.errMsg.divConfirm = 'msg';
                }
            }
        },
        formSubmit(event){
            event.preventDefault();
            axios.get('sanctum/csrf-cookie')
                .then(() => {
                    axios.post('/api/register', this.form)
                        .then((res) => {
                            this.$store.commit('setState', [res.data.email, res.data.username]);
                            this.$router.replace({name: 'home'});
                        })
                        .catch(err => {
                            if (err.response.data.errors) {
                                this.errMsg = responseErrorsHandler(this.errMsg, err);
                            } else {
                                console.log(err);
                            }
                        })
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
</script>