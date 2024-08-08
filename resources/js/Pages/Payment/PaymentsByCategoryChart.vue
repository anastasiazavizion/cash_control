<script setup>
import {computed, ref} from "vue";

const props = defineProps({
    paymentsByCategory:Array
})

import {Doughnut} from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
ChartJS.register(ArcElement, Tooltip, Legend)

const labels = [];
const dataItems = [];
const backgrounds = [];

const dataForChart = ref([]);

if(props.paymentsByCategory.length){

    console.log('yes...');
    props.paymentsByCategory.map(function (item){
        labels.push(item.category.name);
        dataItems.push(item.total_amount);
        backgrounds.push(item.category.icon.color);
    });

    dataForChart.value = {
        labels:labels,
        datasets: [
            {
                backgroundColor: backgrounds,
                data: dataItems
            }
        ]
    };

}

const isEmpty = computed(()=>{
    return props.paymentsByCategory.length > 0;
})

console.log(dataForChart);
console.log(isEmpty.value);


</script>

<template>

    <Doughnut v-if="isEmpty" :style="{height : dataForChart ? '300px' : '0px'}" :data="dataForChart" />

</template>
