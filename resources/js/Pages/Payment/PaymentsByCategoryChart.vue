<script setup>
import {computed, ref} from "vue";
import {Doughnut} from "vue-chartjs";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'

const props = defineProps({
    paymentsByCategory:Array,
    total:Number
})
ChartJS.register(ArcElement, Tooltip, Legend)

const labels = [];
const dataItems = [];
const backgrounds = [];
const dataForChart = ref([]);

if(props.paymentsByCategory.length){
    props.paymentsByCategory.map(function (item){
        labels.push(item.category.name + ' ('+item.total_amount+')');
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

const chartOptions =  {
    plugins: {
        datalabels: {
            display: false,
        },
        legend: {
            display: false,
        },
        tooltip: {
            callbacks: {
                label: function() {
                    return '';
                },
            },
        },
        // Custom plugin for center text
        centerText: {
            text: props.total,
                color: '#000',
                font: {
                size: 18,
                    weight: 'bold',
            },
        },
    },
    // Make sure the chart is responsive
    responsive: true,
}

ChartJS.register({
    id: 'centerText',
    beforeDraw(chart) {
        const ctx = chart.ctx;
        const { width, height, options } = chart;
        const { text, color, font } = options.plugins.centerText;

        // Set the text styling
        ctx.save();
        ctx.font = `${font.weight} ${font.size}px Arial`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = color;

        // Draw the text in the center
        ctx.fillText(text, width / 2, height / 2);
        ctx.restore();
    },
});


</script>

<template>
    <Doughnut  class="text-center" :options="chartOptions" v-if="isEmpty" :style="{height : dataForChart ? '300px' : '0px'}" :data="dataForChart" />
</template>
