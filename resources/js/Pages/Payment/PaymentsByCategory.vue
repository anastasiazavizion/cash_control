<script setup>
import * as HeroIcons from "@heroicons/vue/24/solid/index.js";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import {ref} from "vue";

const props = defineProps({
    categories: Array,
    visibleCategories: Array
})

const visibleCategories = ref([]);
const emits = defineEmits(['remove-payment', 'save-visible-categories']);

function showPayments(id) {
    const category = props.categories.find((item) => item.category_id === id);
    category.show_payments = !category.show_payments;
    if(category.show_payments){
        visibleCategories.value.push(id);
    }else{
        visibleCategories.value = visibleCategories.value.filter((item) => item !== id)
    }
    emits('save-visible-categories', visibleCategories.value);
}

function removePayment(id) {
    emits('remove-payment', id);
}

function isVisibleCategory(id) {
    return props.visibleCategories.includes(id);
}
</script>

<template>
    <div class="cursor-pointer"
         :key="category.category_id"
         v-for="category in categories">

        <div @click="showPayments(category.category_id)" :style="{ backgroundColor: category.category.icon.color}"
             class="grid grid-cols-3 my-2 text-white p-2 mb-4 rounded-md">
            <div class="col-span-2">
                <component :style="{'backgroundColor':category.category.icon.color}"
                           :is="HeroIcons[category.category.icon.icon]"
                           class="h-8 text-white rounded-md">
                </component>
                <span class="ml-2">{{ category.category.name }}</span>
            </div>
            <div class="col-span-1">
                <div class="flex justify-between">
                    <div>{{ category.percent }}%</div>
                    <div>{{ category.total_amount }}</div>
                </div>
            </div>
        </div>

        <div class="last:border-b-0 border-b-2" v-if="category.show_payments || isVisibleCategory(category.category_id)"
             :key="payment.id" v-for="payment in category.payments">
            <div class="grid grid-cols-3  py-2">
                <div class="col-span-2">
                    <div>{{ payment.amount }}</div>
                    <span class="text-slate-400" v-if="payment.description">{{ payment.description }}</span>
                </div>
                <div class="col-span-1">
                    <div class="flex justify-between">
                        <div>{{ payment.payment_date }}</div>
                        <div title="Delete payment" class="text-slate-500">
                            <XMarkIcon @click="removePayment(payment.id)" class="w-8"></XMarkIcon>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
</template>
