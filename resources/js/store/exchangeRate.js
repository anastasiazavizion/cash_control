const state = {
    rates: [],
};

const getters = {
    rates: state => state.rates,
};

const mutations = {
    setRates (state, value) {
        state.rates = value;
    },
};

const actions = {
    async getRates({ commit }) {
        try {
            const response = await axios.get(route('exchangeRate'));
            commit('setRates', response.data);

        } catch (error) {
            commit('setRates', []);
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
