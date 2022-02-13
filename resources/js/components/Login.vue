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
                    <div :class="this.errMsg.divEmail"></div>
                    <label for="password">Password</label>
                </div>
                <div class="form-right">
                    <input
                        :class="this.errMsg.errInputEmail"
                        id="email"
                        type="email"
                        v-model="form.email"
                        @blur="inputChangeHandler"
                    />
                    <div :class="this.errMsg.divEmail">
                        {{ this.errMsg.errEmail }}
                    </div>
                    <input
                        :class="this.errMsg.errInputPassword"
                        id="password"
                        type="password"
                        v-model="form.password"
                        @blur="inputChangeHandler"
                    />
                    <div v-if="this.errMsg.errPassword" class="msg err-msg">
                        {{ this.errMsg.errPassword }}
                    </div>
                    <div
                        style="
                            display: flex;
                            align-content: center;
                            margin-top: 8px;
                        "
                    >
                        <input
                            id="persist"
                            type="checkbox"
                            v-model="form.persist"
                            value="persist"
                            style="margin-right: 8px"
                        />
                        <label for="persist">Remember Me</label>
                    </div>
                    <div style="display: flex; align-items: center">
                        <button v-on:click="formSubmit" class="btn">
                            Login
                        </button>
                        <p style="color: #90c4e5">Forgot Your Password ?</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { inputValidation, responseErrorsHandler } from "../formValidation";

export default {
    data: () => ({
        errMsg: {
            divEmail: "msg",
            divPassword: "msg",
            errEmail: null,
            errPassword: null,
            errInputEmail: "",
            errInputPassword: "",
        },
        form: {
            email: "",
            password: "",
            persist: false,
        },
    }),
    methods: {
        inputChangeHandler(e) {
            this.errMsg = inputValidation(
                this.errMsg,
                e.target.id,
                e.target.value
            );
        },
        formSubmit(event) {
            event.preventDefault();
            axios
                .get("sanctum/csrf-cookie")
                .then((res) => {
                    axios
                        .post("/api/login", this.form)
                        .then((res) => {
                            this.$store.commit("setState", [
                                res.data["user_id"],
                                res.data["username"],
                            ]);
                            this.$router.replace({ name: "home" });
                        })
                        .catch((err) => {
                            if (err.response.data.errors) {
                                this.errMsg = responseErrorsHandler(
                                    this.errMsg,
                                    err
                                );
                            } else {
                                this.errMsg.errEmail = null;
                                this.errMsg.errPassword = null;
                                this.errMsg.divEmail = "msg";
                                this.errMsg.errInputEmail = "";
                                this.errMsg.errInputPassword = "";
                                alert(
                                    "The email address or password is incorrect. Please retry..."
                                );
                            }
                        });
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
