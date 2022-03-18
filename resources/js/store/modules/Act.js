import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";

export const namespaced = true;

export const state = {
    acts: [],
    actsMeta: {}
};

export const getters = {
    acts: (state) => {
        return state.acts;
    },
    actsMeta: (state) => {
        return state.actsMeta;
    },
}

export const mutations = {
    SET_ACTS(state, acts) {
        state.acts = acts
    },
    SET_ACTS_META(state, actsMeta) {
        state.actsMeta = actsMeta
    },
}

export const actions = {
    async fetchActs({commit}) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchActs();
            commit("SET_ACTS", response.data.data)
            commit("SET_ACTS_META", response.data.meta);
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
    },
    async downloadAct({commit}, id) {
        commit("SET_LOADING", true, { root: true });
        try {
            return await ApiService.downloadAct(id);
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    }
}