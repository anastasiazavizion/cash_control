import axios from 'axios';

const state = {
    currencies: [],
    payments: [],
    total: 0,
    totalSum: 0,
    paymentsByCategory: [],
};

const getters = {
    currencies: state => state.currencies,
    payments: state => state.payments,
    total: state => state.total,
    totalSum: state => state.totalSum,
    paymentsByCategory: state => state.paymentsByCategory,
};

const mutations = {
    setCurrencies (state, value) {
        state.currencies = value;
    },
    setPayments (state, value) {
        state.payments = value;
    },

    setTotal (state, value) {
        state.total = value;
    },

    setTotalSum (state, value) {
        state.totalSum = value;
    },
    setPaymentsByCategory (state, value) {
        state.paymentsByCategory = value;
    },
};

const actions = {
    async savePayment({ commit }, payload) {
        try {
            const response = await axios.post('payment',payload);
        } catch (error) {
        }
    },

    async removePayment({ commit }, payload) {
        try {
            const response = await axios.delete('payment/'+payload);
        } catch (error) {
        }
    },



    async getPayments({ commit }, payload) {
        try {
            const response = await axios.get('payment',{params:payload});
            commit('setPayments', response.data.summaries);
            commit('setTotal', response.data.total);
            commit('setTotalSum', response.data.totalSum);
            commit('setPaymentsByCategory', response.data.categories);

        } catch (error) {

        }
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
