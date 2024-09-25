<script setup>
import {computed} from "vue";
import {Doughnut} from "vue-chartjs";

const props = defineProps({
    paymentsByCategory:Array,
    total:Number
})

const isEmpty = computed(()=>{
    return props.paymentsByCategory.length > 0;
})
import priceFormat from "../../hooks/priceFormat.js";

import { createDoughnutChart } from '../../hooks/doughnutChart.js'

const {chartOptions, dataForChart} = createDoughnutChart(props.paymentsByCategory, priceFormat(props.total),'name','total_amount',
    'icon.color');

</script>

<template>
    <Doughnut  class="text-center" :options="chartOptions" v-if="isEmpty" :style="{height : dataForChart ? '300px' : '0px'}" :data="dataForChart" />
</template>
