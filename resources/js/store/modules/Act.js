import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";

export const namespaced = true;

export const state = {
    acts: [],
};

export const getters = {
    acts: (state) => {
        return state.acts;
    },
}

export const mutations = {
    SET_ACTS(state, acts) {
        state.acts = acts
    },
}

export const actions = {
    async fetchActs({commit}) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchActs();
            commit("SET_ACTS", response.data.data)
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async createAct({commit}, params) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.createAct(params);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    }
}