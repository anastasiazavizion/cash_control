import axios from 'axios';

const state = {
    currencies: [],
    payments: [],
    total: 0,
    totalSum: 0,
    paymentsByCategory: [],
    errors:[],
};

const getters = {
    currencies: state => state.currencies,
    payments: state => state.payments,
    total: state => state.total,
    totalSum: state => state.totalSum,
    paymentsByCategory: state => state.paymentsByCategory,
    errors: state => state.errors,
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

    setErrors (state, value) {
        state.errors = value;
    },

    setTotalSum (state, value) {
        state.totalSum = value;
    },
    setPaymentsByCategory (state, value) {
        state.paymentsByCategory = value;
    },
};

const actions = {
    async savePayment({ commit, dispatch}, payload) {
        try {
             await axios.post(route('payment.store'),payload);
             dispatch('clearErrors');
        } catch (error) {
            if(error.response.status === 422){
                commit('setErrors',error.response.data.errors);
            }
        }
    },

    async removePayment({ commit }, payload) {
        try {
            const respnse = await axios.delete(route('payment.destroy', payload));
        } catch (error) {
        }
    },

    async clearErrors({ commit }) {
        commit('setErrors', []);
    },

    async getPayments({ commit }, payload) {
        try {
            const response = await axios.get(route('payment.index'),{params:payload});
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
