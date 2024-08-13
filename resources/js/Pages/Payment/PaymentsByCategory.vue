<script setup>
import * as HeroIcons from "@heroicons/vue/24/solid/index.js";

const props = defineProps({
    categories: Array
})

function showPayments(id){
    const category  = props.categories.find((item)=>item.category_id === id);
    category.show_payments = !category.show_payments;
}


</script>

<template>
    <div class="cursor-pointer"
         :key="category.category_id"
         v-for="category in categories">

        <div @click="showPayments(category.category_id)"  :style="{ backgroundColor: category.category.icon.color}"  class="grid grid-cols-3 my-2 text-white p-2 mb-4 rounded-md">
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

        <div class="last:border-b-0 border-b-2" v-if="category.show_payments" :key="payment.id" v-for="payment in category.payments">

            <div class="flex justify-between  py-2">

                <div>
                    <div>{{payment.amount}}</div>
                    <span class="text-slate-400" v-if="payment.description">{{payment.description}}</span>

                </div>
                <div>{{payment.payment_date}}</div>

            </div>

        </div>


    </div>

<!--
    <div :key="category.category_id"
         v-for="payment in categories">


    </div>
-->

</template>
