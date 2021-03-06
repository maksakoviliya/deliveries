import {createStore} from "vuex";
import * as auth from "./modules/Auth"
import * as order from "./modules/Order"
import * as client from "./modules/Client"
import * as courier from "./modules/Courier"
import * as act from "./modules/Act"

export default createStore({
    state: {
        load: false,
        error: null
    },
    mutations: {
        SET_LOADING(state, loading) {
            state.load = loading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {},
    modules: {
        auth,
        order,
        client,
        courier,
        act
    }
});
