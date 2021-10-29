import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        email: null,
    },
    mutations: {
        setEmail (state, email) {
            state.email = email;
        },
        flushEmail (state) {
            state.email = null;
        }
    }
});

export default store;