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
            clientId: import.meta.env.VITE_GOOGLE_CLIENT_ID,
            redirectUri: import.meta.env.VITE_GOOGLE_REDIRECT_URL
        },

        github: {
            clientId: import.meta.env.VITE_GITHUB_CLIENT_ID,
            redirectUri: import.meta.env.VITE_GITHUB_REDIRECT_URI
        },

        facebook: {
            clientId: import.meta.env.VITE_FACEBOOK_CLIENT_ID,
            redirectUri: import.meta.env.VITE_FACEBOOK_REDIRECT_URI
        },
    }
};

// Initialize UniversalSocialauth
const Oauth = new UniversalSocialauth(axios, options);

import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import { Ziggy } from './ziggy';

import i18n from './i18n/index'; // import your i18n instance

const app = createApp(App)
.use(Toast, {
        toastClassName:'custom-toast'
    })
.use(router)
.use(store)
.use(Ziggy)
.use(LaravelPermissionToVueJS)
.use(i18n)

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$Oauth = Oauth;

app.mount('#app')
