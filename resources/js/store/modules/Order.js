import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";

export const namespaced = true;

export const state = {
    orders: [],
    recipients: [],
};

export const getters = {
    recipients: (state) => {
        return state.recipients;
    },
}

export const mutations = {
    SET_ORDERS(state, orders) {
        state.orders = orders
    },
    SET_RECIPIENTS(state, recipients) {
        state.recipients = recipients
    },
}

export const actions = {
    async fetchRecipients({commit}) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchRecipients();
            commit("SET_RECIPIENTS", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async fetchOrder({commit}, id) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchOrder(id);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async fetchOrders({commit}, params = {}) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchOrders(params);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
}