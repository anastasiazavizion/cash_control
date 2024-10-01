<script setup>
import {onMounted, ref} from "vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";

const form = ref({
    day_limit: null,
    month_limit: null,
});

onMounted(async () => {
    const response = await axios.get(route('user_setting.index'));
    form.value.day_limit = response.data.day_limit;
    form.value.month_limit = response.data.month_limit;
})

async function saveSettings() {
    await axios.post(route('user_setting.store'), form.value);
}

</script>
<template>
    <div>
        <form @submit.prevent="saveSettings" method="POST" action="#">
            <h2 class="text-base font-semibold leading-7 text-gray-900">{{$t('Personal Settings')}}</h2>
            <div class="mt-4 flex flex-col gap-4">
                <div class="">
                    <label for="day_limit" class="block text-sm font-medium leading-6 text-gray-900">{{$t('Max amount per day')}}</label>
                    <p class="text-sm text-slate-400">{{$t('You will receive notification if it is limit')}}</p>
                    <div class="mt-2">
                        <input v-model="form.day_limit" type="text" name="day_limit" id="day_limit" class="form-control"/>
                    </div>
                </div>
                <div class="">
                    <label for="month_limit" class="block text-sm font-medium leading-6 text-gray-900">{{$t('Max amount per month')}}</label>
                    <p class="text-sm text-slate-400 ">{{$t('You will receive notification if it is limit')}}</p>
                    <div class="mt-2">
                        <input v-model="form.month_limit" type="text" name="month_limit" id="month_limit" class="form-control"/>
                    </div>
                </div>
                <div>
                    <PrimaryButton type="submit">{{$t('Save')}}</PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>
