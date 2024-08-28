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
    async getCurrencies({ commit }) {
        try {
            const response = await axios.get(route('currency.index'));
            commit('setCurrencies', response.data);

        } catch (error) {
            commit('setCurrencies', []);
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
