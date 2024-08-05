import axios from 'axios';

const state = {
    currencies: [],
};

const getters = {
    currencies: state => state.currencies,
};

const mutations = {
    setCurrencies (state, value) {
        state.currencies = value;
    },
};

const actions = {
    async savePayment({ commit }, payload) {
        try {
            const response = await axios.post('payment',payload);


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
