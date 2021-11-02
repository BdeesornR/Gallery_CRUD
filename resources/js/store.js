import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        email: null,
        username: null,
    },
    mutations: {
        setState (state, [email, username]) {
            state.email = email;
            state.username = username;
        },
        flushState (state) {
            state.email = null;
            state.username = null;
        },
    }
});

export default store;