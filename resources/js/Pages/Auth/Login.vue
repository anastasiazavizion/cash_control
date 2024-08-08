<template>
    <Header>Login</Header>
    <Card>
        <form @submit.prevent="login" method="post">
            <div>
                <label for="email">Email</label>
                <input type="text" v-model="auth.email" name="email" id="email">
                <Errors :errors="errors.email"/>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" v-model="auth.password" name="password" id="password">
            </div>

            <!--
                       <div><PrimaryButton type="submit">Login</PrimaryButton></div>
            -->


            <div>
                <div>
                    <button @click="useAuthProvider('google', null)">auth Google</button>
                </div>
                <div>
                    <button @click="useAuthProvider('github', null)">auth Github</button>
                </div>

                <!--               <div>
                                   <button @click="useAuthProvider('facebook', null)">auth Facebook</button>
                               </div>-->
            </div>


            <div>

                <button type="button"
                        class="px-5 py-3 inline-flex items-center rounded-lg text-[#333] text-base tracking-wider font-semibold border-none outline-none shadow-lg bg-gray-50 hover:bg-gray-100 active:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22px" fill="#fff" class="inline mr-3"
                         viewBox="0 0 512 512">
                        <path fill="#fbbd00"
                              d="M120 256c0-25.367 6.989-49.13 19.131-69.477v-86.308H52.823C18.568 144.703 0 198.922 0 256s18.568 111.297 52.823 155.785h86.308v-86.308C126.989 305.13 120 281.367 120 256z"
                              data-original="#fbbd00"/>
                        <path fill="#0f9d58"
                              d="m256 392-60 60 60 60c57.079 0 111.297-18.568 155.785-52.823v-86.216h-86.216C305.044 385.147 281.181 392 256 392z"
                              data-original="#0f9d58"/>
                        <path fill="#31aa52"
                              d="m139.131 325.477-86.308 86.308a260.085 260.085 0 0 0 22.158 25.235C123.333 485.371 187.62 512 256 512V392c-49.624 0-93.117-26.72-116.869-66.523z"
                              data-original="#31aa52"/>
                        <path fill="#3c79e6"
                              d="M512 256a258.24 258.24 0 0 0-4.192-46.377l-2.251-12.299H256v120h121.452a135.385 135.385 0 0 1-51.884 55.638l86.216 86.216a260.085 260.085 0 0 0 25.235-22.158C485.371 388.667 512 324.38 512 256z"
                              data-original="#3c79e6"/>
                        <path fill="#cf2d48"
                              d="m352.167 159.833 10.606 10.606 84.853-84.852-10.606-10.606C388.668 26.629 324.381 0 256 0l-60 60 60 60c36.326 0 70.479 14.146 96.167 39.833z"
                              data-original="#cf2d48"/>
                        <path fill="#eb4132"
                              d="M256 120V0C187.62 0 123.333 26.629 74.98 74.98a259.849 259.849 0 0 0-22.158 25.235l86.308 86.308C162.883 146.72 206.376 120 256 120z"
                              data-original="#eb4132"/>
                    </svg>
                    Continue with Google
                </button>


                <button type="button"
                        class="px-5 py-3 inline-flex items-center rounded-lg text-[#333] text-base tracking-wider font-semibold border-none outline-none shadow-lg bg-gray-50 hover:bg-gray-100 active:bg-gray-50">
                     <span class="[&>svg]:h-5 [&>svg]:w-5 mr-3">
                      <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="currentColor"
                          viewBox="0 0 496 512">
                        <path
                            d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3 .3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5 .3-6.2 2.3zm44.2-1.7c-2.9 .7-4.9 2.6-4.6 4.9 .3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3 .7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3 .3 2.9 2.3 3.9 1.6 1 3.6 .7 4.3-.7 .7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3 .7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3 .7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/>
                      </svg>
                    </span>
                    Continue with GitHub
                </button>

            </div>

            <div v-if="errorsAuth" class="text-red-600 font-bold">
                Something is wrong...
            </div>
        </form>
    </Card>
</template>

<script setup>
import {useStore} from 'vuex'
import {computed, ref} from "vue";
import {useRouter} from "vue-router";
import Errors from "@/Components/Errors.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";

const router = useRouter();
const store = useStore();

const auth = ref({
    email: "",
    password: ""
});
const errors = ref([]);
const errorsAuth = ref(false);


function loginWith(provider) {
    axios.get(`/test/${provider}`)
        .then(response => {
            console.log(response.data);
            // Redirect to the social provider for authentication
            //window.location.href = response.data.redirectUrl;
        })
        .catch(error => {
            console.error('Authentication error:', error);
        });
}


const login = async () => {
    errorsAuth.value = false;
    errors.value = [];
    try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/login', auth.value);
        await store.dispatch('auth/login');
        const user = await store.getters['auth/user'];
        router.push('/home');
    } catch (error) {
        if (error.response && (error.response.status === 422)) {
            errors.value = error.response.data.errors;
        } else if (error.response.status === 401) {
            errorsAuth.value = true;
        } else {
            console.error('An error occurred during the login process:', error);
        }
    }
};


import {getCurrentInstance} from 'vue'
import {Providers} from 'universal-social-auth'

const globalProperties = getCurrentInstance()
const box = globalProperties.appContext.config.globalProperties

const perData = {provider: '', code: ''}

const responseData = ref(perData)
const hash = ref('')
const data = ref({tok: ''})

// Below are the functions to use inside you export default be `Vue3 Setup()` or `Vue2 data()` or other `Framework`

function useAuthProvider(provider, proData) {
    const ProData = proData || Providers[provider]
    box.$Oauth
        .authenticate(provider, ProData)
        .then((response) => {
            console.log('success');
            const rsp = response
            if (rsp.code) {
                responseData.value.code = rsp.code
                responseData.value.provider = provider
                useSocialLogin()
            }
        })
        .catch((err) => {
            console.log('errors=');
            console.log(err)
        })
}

async function useLoginFirst(e) {


    await store.dispatch('auth/login');
    const user = await store.getters['auth/user'];
    router.push('/home');


}

function useSocialLogin() {
    console.log('useSocialLogin');
    // otp from input Otp form
    // hash user data in your backend with Cache or save to database
    const pdata = {code: responseData.value.code, otp: data.value.tok, hash: hash.value}
    console.log('pdata: ', pdata)
    box.$axios
        .post('http://localhost:8097/auth/' + responseData.value.provider + '/callback', pdata)
        .then(async (response) => {
            console.log('yes');
            if (response.data.status === 444) {
                hash.value = response.data.hash
            } else if (response.data.status === 445) {
                // do something Optional
            } else {
                await useLoginFirst(response.data.u)
            }
        })
        .catch((err) => {
            console.log(err)
        })
}


</script>
