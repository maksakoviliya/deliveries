import router from "../../router";
import {getError} from "../../utils/helpers";
import ApiService from "../../services/ApiService";

export const namespaced = true;

export const state = {
    user: null,
    loading: false,
    error: null,
};

export const mutations = {
    SET_USER(state, user) {
        state.user = user;
    },
    SET_LOADING(state, loading) {
        state.loading = loading;
    },
    SET_ERROR(state, error) {
        state.error = error;
    },
    SET_COMPANY(state, payload) {
        state.user.company = payload
    }
};

export const actions = {
    logout({commit, dispatch}) {
        return ApiService.logout()
            .then(() => {
                commit("SET_USER", null);
                dispatch("setGuest", {value: "isGuest"});
                if (router.currentRoute.name !== "login")
                    router.push({path: "/login"});
            })
            .catch((error) => {
                commit("SET_ERROR", getError(error));
            });
    },
    async getAuthUser({commit}) {
        commit("SET_LOADING", true);
        try {
            const response = await ApiService.getAuthUser();
            commit("SET_USER", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_USER", null);
            commit("SET_ERROR", getError(error));
        } finally {
            commit("SET_LOADING", false);
        }
    },
    setGuest(context, {value}) {
        window.localStorage.setItem("guest", value);
    },
    async setCompany({commit, getters}, data) {
        commit("SET_LOADING", true);
        try {
            let response = null;
            console.log('start')
            console.log('data', data)
            if (getters.company) {
                response = await ApiService.updateCompany(data);
            } else {
                response = await ApiService.createCompany(data);
            }
            console.log('finish')
            console.log('response', response)
            commit("SET_COMPANY", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error));
            console.log('errr herer')
            throw error
        } finally {
            commit("SET_LOADING", false);
        }
    }
};

export const getters = {
    authUser: (state) => {
        return state.user;
    },
    isAdmin: (state) => {
        return state.user ? state.user.isAdmin : false;
    },
    error: (state) => {
        return state.error;
    },
    loading: (state) => {
        return state.loading;
    },
    loggedIn: (state) => {
        return !!state.user;
    },
    guest: () => {
        const storageItem = window.localStorage.getItem("guest");
        if (!storageItem) return false;
        if (storageItem === "isGuest") return true;
        if (storageItem === "isNotGuest") return false;
    },
    company: (state) => {
        return state.user.company
    }
};
