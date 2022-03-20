import ApiService from "../../services/ApiService";
import {getError} from "../../utils/helpers";
import router from '../../router'

export const namespaced = true;

export const state = {
    orders: [],
    recipients: [],
    selectedOrders: [],
    ordersMeta: {},
};

export const getters = {
    recipients: (state) => {
        return state.recipients;
    },
    orders: (state) => {
        console.log('getter orders' ,state.orders)
        return state.orders;
    },
    selectedOrders: (state) => {
        return state.selectedOrders;
    },
    ordersMeta: (state) => {
        return state.ordersMeta;
    },
}

export const mutations = {
    SET_ORDERS(state, orders) {
        console.log('before SET_ORDERS')
        state.orders = orders
        console.log('after SET_ORDERS')
    },
    SET_RECIPIENTS(state, recipients) {
        state.recipients = recipients
    },
    SET_SELECTED_ORDERS(state, selectedOrders) {
        state.selectedOrders = selectedOrders
    },
    SET_ORDERS_META(state, ordersMeta) {
        state.ordersMeta = ordersMeta
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
    async fetchOrders({commit}) {
        console.log('router.currentRoute')
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.fetchOrders(router.currentRoute.value.query);
            console.log('fetched')
            commit("SET_ORDERS", response.data.data);
            console.log('SET_ORDERS')
            commit("SET_ORDERS_META", response.data.meta);
            console.log('SET_ORDERS_META')
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
    async setOrderPayment({commit}, params) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.setOrderPayment(params.order_id , params);
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    },
    async ordersPay({commit}, params) {
        commit("SET_LOADING", true, { root: true });
        try {
            let response = await ApiService.ordersPay(params);
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
    selectOrder({commit, state}, order) {
        let selected = state.selectedOrders
        let index = selected.findIndex(item => item.id === order.id)
        if (index >= 0) {
            selected.splice(index, 1)
        } else {
            selected.push(order)
        }
        commit('SET_SELECTED_ORDERS', selected)
    },
    async fetchOrdersAnalytics({commit}) {
        commit("SET_LOADING", true, { root: true });
        try {
            console.log('asd')
            let response = await ApiService.fetchOrdersAnalytics();
            return response.data.data;
        } catch (error) {
            commit("SET_ERROR", getError(error), { root: true });
            throw error
        } finally {
            commit("SET_LOADING", false, { root: true });
        }
    }
}