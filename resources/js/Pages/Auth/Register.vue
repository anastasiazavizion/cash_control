<script setup>
import {useStore} from 'vuex'
import {computed, onMounted, ref} from 'vue'
import {useRouter} from "vue-router";
import Errors from "@/Components/Errors.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Label from "@/Components/Label.vue";
import FormCard from "@/Components/FormCard.vue";
import FormDiv from "@/Components/FormDiv.vue";

const form = ref({
    name: "",
    lastname: "",
    password: "",
    password_confirmation: "",
    phone: "",
    email: "",
    birthday:""
});

const router = useRouter();
const store = useStore();

const errors = computed(()=>{
    return store.getters['auth/errors'];
})

const register = async () => {
    await store.dispatch('auth/register', form.value);
    if(Object.keys(errors.value).length === 0){
        await router.push('/home');
    }
};

onMounted(()=>{
    store.dispatch('auth/clearErrors');
});
</script>
<template>
    <FormCard :header="$t('Register new account')">
        <form @submit.prevent="register" class="space-y-6" action="#" method="POST">
            <FormDiv>
                <template #label><Label name="name">{{$t('Name')}}</Label></template>
                <input v-model="form.name" id="name" name="name" type="text"/>
                <Errors v-if="errors"  :errors="errors.name"/>
            </FormDiv>

            <FormDiv>
                <template #label><Label name="email">{{$t('Email')}}</Label></template>
                <input v-model="form.email" id="email" name="email" type="email" autocomplete="email"/>
                <Errors v-if="errors" :errors="errors.email"/>
            </FormDiv>

            <FormDiv>
                <template #label><Label name="password">{{$t('Password')}}</Label></template>
                <input v-model="form.password" id="password" name="password" type="password" autocomplete="current-password"/>
                <Errors v-if="errors" :errors="errors.password"/>
            </FormDiv>

            <FormDiv>
                <template #label><Label name="password_confirmation">{{$t('Confirm Password')}}</Label></template>
                <input v-model="form.password_confirmation" id="password_confirmation" name="password_confirmation" type="password" autocomplete="current-password" />
            </FormDiv>

            <div class="text-right">
                <PrimaryButton>{{$t('Register')}}</PrimaryButton>
            </div>
        </form>
    </FormCard>

</template>
