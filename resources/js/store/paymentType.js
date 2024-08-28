const state = {
    paymentTypes: [],
};

const getters = {
    paymentTypes: state => state.paymentTypes,
};

const mutations = {
    setPaymentTypes (state, value) {
        state.paymentTypes = value;
    },
};

const actions = {
    async getPaymentTypes({ commit }) {
        try {
            const response = await axios.get('/paymentType');
            commit('setPaymentTypes', response.data);

        } catch (error) {
            commit('setPaymentTypes', []);
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
