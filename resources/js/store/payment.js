import axios from 'axios';

const state = {
    total: 0,
    totalSum: 0,
    paymentsByCategory: [],
    errors:[],
};

const getters = {
    total: state => state.total,
    totalSum: state => state.totalSum,
    paymentsByCategory: state => state.paymentsByCategory,
    errors: state => state.errors,
};

const mutations = {
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

    async getTotalSum({ commit },payload) {
        try {
            const response = await axios.get(route('payment.totalSum'), {params:payload});
            commit('setTotalSum', response.data);
        } catch (error) {

        }
    },

    async getPaymentsByType({ commit }, payload) {
        try {
            const response = await axios.get(route('payment.getPaymentsByType'), {params:payload});
            commit('setTotal', response.data.total);
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
