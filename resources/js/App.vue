<script setup>
import {useStore} from "vuex";
const store = useStore();
import {useRouter} from "vue-router";
import {computed} from "vue";
const router = useRouter();

const logout = async () => {
    try {
        const { data } = await axios.post('/logout');
        store.dispatch('auth/logout');
        router.push('/auth/login');
    } catch (error) {
        console.error(error);
    }
};

const user =  computed(()=>{
    return store.getters['auth/user']
})

console.log(user.value);

const authenticated = computed(()=>{
    return store.getters['auth/authenticated']
})
</script>

<template>
Main template

<router-link to="/home">Home link</router-link>
    <router-link v-if="!authenticated" to="/auth/login">Login</router-link>
    <router-link  v-if="!authenticated" to="/auth/register">Register</router-link>

    <h1>{{user.name}}</h1>

<router-view></router-view>
</template>

<style scoped>

</style>
