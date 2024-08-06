import { createStore } from 'vuex';
import auth from './auth.js';
import category from './category.js';
import currency from './currency.js';
import payment from './payment.js';
import paymentType from './paymentType.js';
import exchangeRate from './exchangeRate.js';
import createPersistedState from "vuex-persistedstate";
const store = createStore({
    modules: {
        auth,
        category,
        payment,
        currency,
        paymentType,
        exchangeRate,
    },
    plugins:[
        createPersistedState()
    ]
});

export default store;
