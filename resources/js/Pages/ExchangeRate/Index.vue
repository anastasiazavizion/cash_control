<script setup>
import {onMounted, ref} from "vue";
import {useStore} from "vuex";

const rates = ref([]);
const store = useStore();

onMounted(async () => {
    await store.dispatch('exchangeRate/getRates');
    rates.value = store.getters['exchangeRate/rates'];
    console.log(rates.value);
}
)

</script>

<template>

    <div>


        <table class="tableWithBorder">
            <thead>
            <tr>
                <th>Currency</th>
                <th>Buy</th>
                <th>Sale</th>
            </tr>
            </thead>
            <tbody>
            <tr :key="rate.ccy" v-for="rate in rates">

                <td>
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

<style scoped>

</style>
