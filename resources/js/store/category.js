import axios from 'axios';

const state = {
    categories: [],
};

const getters = {
    categories: state => state.categories,
};

const mutations = {
    setCategories (state, value) {
        state.categories = value;
    },
};

const actions = {
    async getCategories({ commit }) {
        try {
            const response = await axios.get(route('category.index'));
            commit('setCategories', response.data);

        } catch (error) {
            commit('setCategories', []);
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
