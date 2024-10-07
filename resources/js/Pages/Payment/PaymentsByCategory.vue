<script setup>
import * as HeroIcons from "@heroicons/vue/24/solid/index.js";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import {ref} from "vue";
import Price from "@/Components/Price.vue";
import swal from 'sweetalert';

import {useI18n} from "vue-i18n";

const {t} = useI18n();

const props = defineProps({
    categories: Array,
    visibleCategories: Array
})

const visibleCategories = ref([]);
const emits = defineEmits(['remove-payment', 'save-visible-categories']);

function showPayments(id) {
    const category = props.categories.find((item) => item.id === id);
    category.show_payments = !category.show_payments;
    if(category.show_payments){
        visibleCategories.value.push(id);
    }else{
        visibleCategories.value = visibleCategories.value.filter((item) => item !== id)
    }
    emits('save-visible-categories', visibleCategories.value);
}

async function removePayment(id) {
    swal({
        title: t('Are you sure') + '?',
        text: t('Are you sure that you want to delete this payment')+'?',
        icon: "warning",
        dangerMode: true,
    })
        .then(willDelete => {
            if (willDelete) {
                emits('remove-payment', id);
            }
        });
}

function isVisibleCategory(id) {
    return props.visibleCategories.includes(id);
}
</script>

<template>
    <div
         :key="category.id"
         v-for="category in categories">
        <div @click="showPayments(category.id)" :style="{ backgroundColor: category.icon.color}"
             class="cursor-pointer grid grid-cols-3 my-2 text-white p-2 mb-4 rounded-md">
            <div class="col-span-2">
                <component :style="{'backgroundColor':category.icon.color}"
                           :is="HeroIcons[category.icon.icon]"
                           class="h-8 text-white rounded-md">
                </component>
                <span class="ml-2">{{ category.name }}</span>
            </div>
            <div class="col-span-1">
                <div class="flex justify-between">
                    <div>{{ category.percent }}%</div>
                    <div><Price>{{ category.total_amount }}</Price></div>
                </div>
            </div>
        </div>

        <div class="last:border-b-0 border-b-2" v-if="category.show_payments || isVisibleCategory(category.id)"
             :key="payment.id" v-for="payment in category.payments">
            <div class="grid grid-cols-3  py-2">
                <div class="col-span-2">
                    <div><Price>{{ payment.amount }}</Price></div>
                    <span class="text-slate-400" v-if="payment.description">{{ payment.description }}</span>
                </div>
                <div class="col-span-1">
                    <div class="flex justify-between">
                        <div>{{ payment.payment_date }}</div>
                        <div title="Delete payment" class="text-slate-500">
                            <XMarkIcon @click="removePayment(payment.id)" class="w-8 cursor-pointer"></XMarkIcon>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
</template>
