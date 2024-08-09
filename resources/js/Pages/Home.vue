<script setup>
import {useStore} from "vuex";
import {onMounted, ref} from "vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

import PaymentsByCategoryChart from "./Payment/PaymentsByCategoryChart.vue";
import PaymentsByCategory from "./Payment/PaymentsByCategory.vue";
import AddNewPaymentDialog from "./Payment/AddNewPaymentDialog.vue";
import {PlusIcon, CurrencyDollarIcon}  from '@heroicons/vue/24/solid'
import {Doughnut} from "vue-chartjs";

const store = useStore();

const categories = ref([]);
const paymentTypes = ref([]);
const currencies = ref([]);
const summaries = ref([]);
const total = ref(0);
const totalSum = ref(0);
const loaded = ref(false);
const paymentsByCategory = ref([]);

async function getPaymentsByTypeId(id) {
    paymentsByCategory.length = 0;
    loaded.value = false;
    await store.dispatch('payment/getPayments', {'payment_type_id': id});
    summaries.value = store.getters['payment/payments'];
    total.value = store.getters['payment/total'];
    totalSum.value = store.getters['payment/totalSum'];
    paymentsByCategory.value = await store.getters['payment/paymentsByCategory'];
    loaded.value = true;
}

onMounted(async () => {
    await store.dispatch('category/getCategories');

    categories.value = store.getters['category/categories'];

    await store.dispatch('paymentType/getPaymentTypes');
    paymentTypes.value = store.getters['paymentType/paymentTypes'];


    await store.dispatch('currency/getCurrencies');
    currencies.value = store.getters['currency/currencies'];


    paymentTypes.value = paymentTypes.value.map((item, index)=>{
        return {
            ...item,
            is_active : index === 0
        }
    })

    const defaultPaymentTypeId = paymentTypes.value[0].id;

    await getPaymentsByTypeId(defaultPaymentTypeId);

    loaded.value = true;
})

const paymentForm = ref({
    amount:0,
    category_id:null,
    payment_date:null,
    description:null,
    payment_type_id:1,
    payment_currency_id:1,
})


const openDialog = ref(false);

function openAddPaymentModal(paymentTypeId){
    console.log(paymentTypeId);
    openDialog.value = true;

}

function savePayment(form){
   store.dispatch('payment/savePayment', form);
    getPaymentsByTypeId(form.payment_type_id);
   openDialog.value = false;
}

async function setActivePaymentType(id) {
    paymentForm.value.payment_type_id = id;
    paymentTypes.value = paymentTypes.value.map((item, index) => {
        return {
            ...item,
            is_active: item.id === id
        }
    })
    await getPaymentsByTypeId(id);
}
</script>

<template>
    <AddNewPaymentDialog @save-payment="savePayment" :payment-form="paymentForm"  :open-dialog="openDialog"/>

    <div>
        <CurrencyDollarIcon class="h-6"></CurrencyDollarIcon> Total {{totalSum}}
    </div>
    <TabGroup>
        <TabList class="text-center grid grid-cols-2">
            <Tab class="mr-4" @click="setActivePaymentType(paymentType.id)" :key="paymentType.id" v-for="paymentType in paymentTypes">
                <button
                    :class="[
              'w-full rounded-lg p-4 text-base font-medium leading-5',
              'focus:outline-none',
              paymentType.is_active
                ? 'bg-white text-blue-700 shadow'
                : '',
            ]"
                >
                    {{paymentType.name}}
                </button>
            </Tab>

        </TabList>
        <TabPanels class="mt-4">

            <div>
               <TabPanel :key="paymentType.id" v-for="paymentType in paymentTypes">
                    <PlusIcon @click="openAddPaymentModal(paymentType.id)"  class="h-8 cursor-pointer bg-black text-white rounded-md"></PlusIcon>

                   <div>
                       <PaymentsByCategoryChart  :total="total" :paymentsByCategory="paymentsByCategory" v-if="loaded"></PaymentsByCategoryChart>
                   </div>
                   <div class="mt-4">
                       <PaymentsByCategory v-if="loaded" :payments="paymentsByCategory"></PaymentsByCategory>
                   </div>
                </TabPanel>
            </div>
        </TabPanels>
    </TabGroup>


<!--    <div>
        <CurrencyDollarIcon class="h-8"/> Total {{total}}
    </div>-->


    <!--
        <div v-if="summaries.length > 0" class="bg-gray-600 p-4 text-white">
            <div :key="summary.payment_currency_id" v-for="summary in summaries">
                <div>{{summary.currency.name}}</div>
                <div>{{summary.total_amount}}</div>
            </div>
        </div>
    -->
</template>
