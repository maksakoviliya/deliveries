import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";

export const namespaced = true;

export const state = {
    orders: [],
    recipients: [],
    allOrders: []
};

export const getters = {
    recipients: (state) => {
        return state.recipients;
    },
    orders: (state) => {
        return state.orders;
    },
    allOrders: (state) => {
        return state.allOrders;
    },
}

export const mutations = {
    SET_ORDERS(state, orders) {
        state.orders = orders
    },
    SET_RECIPIENTS(state, recipients) {
        state.recipients = recipients
    },
    SET_ALL_ORDERS(state, allOrders) {
        state.allOrders = allOrders
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
    async fetchRecipientsForUser({commit}, id) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchRecipientsForUser(id);
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
            commit("SET_ORDERS", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async fetchAllOrders({commit}, params = {}) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchAllOrders(params);
            commit("SET_ALL_ORDERS", response.data.data);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async setOrderStatus({commit}, params) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.setOrderStatus(params.order_id , params);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async setOrderCourier({commit}, params) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.setOrderCourier(params.order_id , params);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
}