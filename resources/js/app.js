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
            clientId: '976566120631-k6rjlsmvebqai111ih6bkr3v37rme1i3.apps.googleusercontent.com',
            redirectUri: 'http://localhost:8097/auth/google/callback'
        },

        github: {
            clientId: 'Ov23lijwCeMFb7HjYrYy',
            redirectUri: 'http://localhost:8097/auth/github/callback'
        },

        facebook: {
            clientId: '1897919367389385',
            redirectUri: 'http://localhost:8097/auth/facebook/callback'
        },
    }
};

// Initialize UniversalSocialauth
const Oauth = new UniversalSocialauth(axios, options);

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
const app = createApp(App)
.use(Toast)
.use(router)
.use(store)
.use(LaravelPermissionToVueJS)

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$Oauth = Oauth;

app.mount('#app')
