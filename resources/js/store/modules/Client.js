import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";

export const namespaced = true;

export const state = {
    clients: [],
};

export const getters = {
    clients: (state) => {
        return state.clients;
    },
}

export const mutations = {
    SET_CLIENTS(state, clients) {
        state.clients = clients;
    },
}

export const actions = {
    async fetchClients({commit}) {
        commit("SET_LOADING", true, { root: true });
        try {
            const response = await ApiService.getClients();
            commit("SET_CLIENTS", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async fetchClient({commit}, id) {
        commit("SET_LOADING", true, { root: true });
        try {
            const response = await ApiService.getClient(id);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    }
}