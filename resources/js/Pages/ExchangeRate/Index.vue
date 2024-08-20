<script setup>
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
const rates = ref([]);
const store = useStore();
onMounted(async () => {
    async function getRates() {
        await store.dispatch('exchangeRate/getRates');
        rates.value = store.getters['exchangeRate/rates'];
    }
await getRates();

 setInterval(async function () {
     await getRates();
 }, 3600000);
}
)
import {CurrencyEuroIcon, CurrencyDollarIcon} from "@heroicons/vue/24/solid";

</script>
<template>
    <div>
        <table class="tableWithBorder text-sm">
            <tbody>
            <tr :key="rate.ccy" v-for="rate in rates">
                <td>
                    <CurrencyEuroIcon class="h-4" v-if="rate.ccy === 'EUR'"></CurrencyEuroIcon>
                    <CurrencyDollarIcon class="h-4" v-else></CurrencyDollarIcon>
                    {{rate.ccy}}
                </td>
                <td>
                    {{rate.buy}}
                </td>

                <td>
                    {{rate.sale}}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
