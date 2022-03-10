import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";

export const namespaced = true;

export const state = {
   couriers: [],
};

export const getters = {
    couriers: (state) => {
        return state.couriers;
    },
}

export const mutations = {
    SET_COURIERS(state, couriers) {
        state.couriers = couriers
    },
}

export const actions = {
    async fetchCouriers({commit}, params = {}) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchCouriers(params);
            commit("SET_COURIERS", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async fetchCourier({commit}, id) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchCourier(id);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
}