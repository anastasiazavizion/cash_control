import {ArcElement, Chart as ChartJS, Legend, Tooltip} from "chart.js";
import {ref} from "vue";
import priceFormat from "./priceFormat.js";

export function createDoughnutChart(data, total, labelKey, dataKey, colorKey){
    ChartJS.register(ArcElement, Tooltip, Legend)

    // Helper function to get nested properties
    function getNestedProperty(obj, key) {
        return key.split('.').reduce((acc, part) => acc && acc[part], obj);
    }

    const labels = [];
    const dataItems = [];
    const backgrounds = [];
    const dataForChart = ref([]);

    if(data.length){
        data.map(function (item){
            // Dynamically access the properties using the provided keys
            const label = getNestedProperty(item, labelKey) + ' (' + priceFormat(getNestedProperty(item, dataKey)) + ')';
            const dataValue = getNestedProperty(item, dataKey);
            const backgroundColor = getNestedProperty(item, colorKey);
            labels.push(label);
            dataItems.push(dataValue);
            backgrounds.push(backgroundColor);
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
                text: '$ '+total,
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
    return { chartOptions: ref(chartOptions), dataForChart };
}
