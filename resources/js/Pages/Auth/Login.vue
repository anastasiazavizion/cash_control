<template>
    <FormCard header="Sign in to your account">
        <form @submit.prevent="login" class="space-y-6" action="#" method="POST">

            <FormDiv>
                <template #label><Label name="email">Email</Label></template>
                <input v-model="auth.email" id="email" name="email" type="email" autocomplete="email" required="" />
                <Errors v-if="errors" :errors="errors.email"/>
            </FormDiv>

            <FormDiv>
                <template #label><Label name="password">Password</Label></template>
                <input v-model="auth.password" id="password" name="password" type="password" autocomplete="current-password" required="" />
            </FormDiv>

            <div class="text-right">
                <PrimaryButton>Sign in</PrimaryButton>
            </div>
        </form>

        <div>
            <button @click="useAuthProvider('google', null)" type="button"
                    class="social-btn">
                <GoogleIcon/>
                Continue with Google
            </button>

            <button @click="useAuthProvider('github', null)" type="button"
                    class="social-btn">
                <GithubIcon/>
                Continue with GitHub
            </button>
        </div>
    </FormCard>
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
import Label from "../../Components/Label.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import FormCard from "../../Components/FormCard.vue";
import FormDiv from "../../Components/FormDiv.vue";

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
