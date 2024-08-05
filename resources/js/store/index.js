import { createStore } from 'vuex';
import auth from './auth.js';
import category from './category.js';
import createPersistedState from "vuex-persistedstate";
const store = createStore({
    modules: {
        auth,
        category,
    },
    plugins:[
        createPersistedState()
    ]
});

export default store;
