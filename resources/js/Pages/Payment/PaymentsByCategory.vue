<script setup>
import * as HeroIcons from "@heroicons/vue/24/solid/index.js";

defineProps({
    payments:Array
})
</script>

<template>
    <div class="p-2 text-white grid grid-cols-3 mb-4 rounded-md" :style="{ backgroundColor: payment.category.icon.color}" :key="payment.category_id" v-for="payment in payments">
       <div class="col-span-2">
           <component :style="{'backgroundColor':payment.category.icon.color}"
                      :is="HeroIcons[payment.category.icon.icon]"
                      class="h-8 cursor-pointer text-white rounded-md">
           </component>
           <span class="ml-2">{{payment.category.name}}</span>
          </div>

        <div class="col-span-1">
            <div class="flex justify-between">
                <div>{{payment.percent}}%</div>
                <div>{{payment.total_amount}}</div>
            </div>
        </div>


    </div>

</template>

<style scoped>

</style>
