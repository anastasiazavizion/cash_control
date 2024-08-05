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
        }else if(error.response.status === 401){
            errorsAuth.value = true;
        }else {
            console.error('An error occurred during the login process:', error);
        }
    }
};





import { getCurrentInstance } from 'vue'
import { Providers } from 'universal-social-auth'

const globalProperties = getCurrentInstance()
const box = globalProperties.appContext.config.globalProperties

const perData = { provider: '', code: '' }

const responseData = ref(perData)
const hash = ref('')
const data = ref({ tok: '' })

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
    const pdata = { code: responseData.value.code, otp: data.value.tok, hash: hash.value }
    console.log('pdata: ', pdata)
    box.$axios
        .post('http://localhost:8097/auth/' + responseData.value.provider+'/callback', pdata)
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
