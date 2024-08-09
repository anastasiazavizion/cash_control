<script setup>

import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'
import {ref} from "vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import axios from "axios";

const form = ref({
    day_limit:null,
    month_limit:null,
});

async function saveSettings() {
    const response = await axios.post('/user_setting', form.value);


}


</script>

<template>

    <form @submit.prevent="saveSettings" method="POST" action="#">
        <div class="space-y-12">

            <div class="pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Settings</h2>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">

                    <div class="">
                        <label for="day_limit" class="block text-sm font-medium leading-6 text-gray-900">Max amount per day</label>
                        <p class="text-sm text-slate-400 ">You will receive notification if it is limit</p>
                        <div class="mt-2">
                            <input v-model="form.day_limit" type="text" name="day_limit" id="day_limit" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>


                    <div class="">
                        <label for="month_limit" class="block text-sm font-medium leading-6 text-gray-900">Max amount per month</label>
                        <p class="text-sm text-slate-400 ">You will receive notification if it is limit</p>
                        <div class="mt-2">
                            <input v-model="form.month_limit" type="text" name="month_limit" id="month_limit" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div>
                        <PrimaryButton type="submit">Save</PrimaryButton>
                    </div>



                </div>
            </div>


        </div>


    </form>
</template>


<style scoped>

</style>
