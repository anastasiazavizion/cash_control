<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="login" class="space-y-6" action="#" method="POST">
                <div>
                    <div class="flex items-center justify-between">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="auth.email" id="email" name="email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <Errors v-if="errors" :errors="errors.email"/>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input v-model="auth.password" id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                </div>
            </form>

            <div>
                <button @click="useAuthProvider('google', null)" type="button"
                        class="w-full mb-2 mt-4 px-5 py-3 inline-flex items-center rounded-lg text-[#333] text-base tracking-wider font-semibold border-none outline-none shadow-lg bg-gray-50 hover:bg-gray-100 active:bg-gray-50">
                    <GoogleIcon/>
                    Continue with Google
                </button>

                <button @click="useAuthProvider('github', null)" type="button"
                        class="w-full mb-2 mt-4 px-5 py-3 inline-flex items-center rounded-lg text-[#333] text-base tracking-wider font-semibold border-none outline-none shadow-lg bg-gray-50 hover:bg-gray-100 active:bg-gray-50">
                    <GithubIcon/>
                    Continue with GitHub
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useStore} from 'vuex'
import {computed, onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import Errors from "@/Components/Errors.vue";
import {getCurrentInstance} from 'vue'
import {Providers} from 'universal-social-auth'
import GoogleIcon from "../../Components/Icons/GoogleIcon.vue";
import GithubIcon from "../../Components/Icons/GithubIcon.vue";

const router = useRouter();
const store = useStore();

onMounted(()=>{
    store.dispatch('auth/clearErrors');
})

const auth = ref({
    email: "",
    password: ""
});

const errors = computed(()=>{
    return store.getters['auth/errors'];
})

async function redirectToHome() {
    if (!errors.value) {
        await router.push('/home');
    }
}

async function loginF(data) {
    await store.dispatch('auth/login', data);
    await redirectToHome();
}

const login = async () => {
    await axios.get('/sanctum/csrf-cookie');
    await loginF(auth.value);
};

const globalProperties = getCurrentInstance()
const box = globalProperties.appContext.config.globalProperties

const perData = {provider: '', code: ''}

const responseData = ref(perData)
const hash = ref('')
const data = ref({tok: ''})

function useAuthProvider(provider, proData) {
    const ProData = proData || Providers[provider]
    box.$Oauth
        .authenticate(provider, ProData)
        .then((response) => {
            const rsp = response
            if (rsp.code) {
                responseData.value.code = rsp.code
                responseData.value.provider = provider
                useSocialLogin()
            }
        })
        .catch((err) => {
            console.log(err)
        })
}

function useSocialLogin() {
    const pdata = {code: responseData.value.code, otp: data.value.tok, hash: hash.value}
    box.$axios
        .post(route('auth.social.callback',responseData.value.provider), pdata)
/*
        .post('http://localhost:8097/api/auth/' + responseData.value.provider + '/callback', pdata)
*/
        .then(async (response) => {
            if (response.data.status === 444) {
                hash.value = response.data.hash
            } else if (response.data.status === 445) {
                // do something Optional
            } else {
                await store.dispatch('auth/getUser');
                await redirectToHome();
            }
        })
        .catch((err) => {
            console.log(err)
        })
}
</script>
