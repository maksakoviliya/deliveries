import {createStore} from "vuex";
import * as auth from "./modules/Auth"

export default createStore({
    state: {},
    mutations: {},
    actions: {},
    // modules: {
    //    Auth
    // },
    modules: {
        auth
    }
});
