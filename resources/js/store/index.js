import {createStore} from "vuex";
import * as auth from "./modules/Auth"
import * as order from "./modules/Order"
import * as client from "./modules/Client"

export default createStore({
    state: {
        loading: false,
        error: null
    },
    mutations: {
        SET_LOADING(state, loading) {
            state.loading = loading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {},
    modules: {
        auth,
        order,
        client
    }
});
