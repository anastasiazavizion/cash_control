import './bootstrap';

import App from "./App.vue";
import { createApp } from 'vue'
import router from "./router/index.js";
import store from "./store/index.js";

import UniversalSocialauth from 'universal-social-auth';

// Define options for UniversalSocialauth
const options = {
    providers: {
        google: {
            clientId: '976566120631-43ed403u1stn13kbj5gcectmko0fnr78.apps.googleusercontent.com',
            redirectUri: 'http://localhost:8097/api/auth/google/callback'
        },

        github: {
            clientId: 'Ov23lijwCeMFb7HjYrYy',
            redirectUri: 'http://localhost:8097/api/auth/github/callback'
        },

        facebook: {
            clientId: '1897919367389385',
            redirectUri: 'http://localhost:8097/api/auth/facebook/callback'
        },
    }
};

// Initialize UniversalSocialauth
const Oauth = new UniversalSocialauth(axios, options);

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const app = createApp(App)
.use(Toast)
.use(router)
.use(store)
.use(ZiggyVue)
.use(LaravelPermissionToVueJS)

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$Oauth = Oauth;

app.mount('#app')
