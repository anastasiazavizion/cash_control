<script setup>
import * as HeroIcons from '@heroicons/vue/24/solid'
import {PlusCircleIcon, CheckIcon}  from '@heroicons/vue/24/solid'
import {useStore} from "vuex";
import {computed, onMounted, reactive, ref} from "vue";

const store = useStore();

const categories = ref([]);
const paymentTypes = ref([]);
const currencies = ref([]);
const summaries = ref([]);
const total = ref(0);
const loaded = ref(false);
const activeCategory = ref(null);

const paymentsByCategory = ref([]);

async function getPaymentsByTypeId(id) {
    paymentsByCategory.length = 0;
    loaded.value = false;
    await store.dispatch('payment/getPayments', {'payment_type_id': id});
    summaries.value = store.getters['payment/payments'];
    total.value = store.getters['payment/total'];
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

/*function setIsOpen(value) {
    isOpen.value = value;
    if(!value){
        paymentForm.value.amount = 0;
        paymentForm.value.category_id = null;
        paymentForm.value.payment_date = null;
        paymentForm.value.description = null;
        paymentForm.value.payment_type_id = 1;
        paymentForm.value.payment_currency_id = 1;
    }
}*/

const openDialog = ref(false);

function openAddPaymentModal(paymentTypeId){
    console.log(paymentTypeId);
    openDialog.value = true;

}



function setCategory(categoryId){
    paymentForm.value.category_id = categoryId;
}

function setPaymentDate(date){
    paymentForm.value.payment_date = date;
}

function savePayment(){
    console.log(paymentForm.value);

    store.dispatch('payment/savePayment', paymentForm.value);

}

function formatDate(date) {
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const day = String(date.getDate()).padStart(2, '0');
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}


const today = new Date();
const yesterday = new Date(today);
yesterday.setDate(today.getDate() - 1);
const twoDaysAgo = new Date(today);
twoDaysAgo.setDate(today.getDate() - 2);

const todayDate = formatDate(today);
const yesterdayDate = formatDate(yesterday);
const twoDaysAgoDate = formatDate(twoDaysAgo);

paymentForm.value.payment_date = todayDate;

console.log(paymentForm.value.payment_date );

const defaultDates = [
    {'date':todayDate, label:'today'},
    {'date':yesterdayDate, label:'yesterday'},
    {'date':twoDaysAgoDate, label:'2 days ago'},
];


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


import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


import { CurrencyDollarIcon} from '@heroicons/vue/20/solid'
import PrimaryButton from "../Components/PrimaryButton.vue";


import PaymentsByCategoryChart from "./Payment/PaymentsByCategoryChart.vue";
import {Dialog,DialogPanel, DialogTitle, RadioGroup, RadioGroupOption} from "@headlessui/vue";
import FormRow from "../Components/FormRow.vue";

const datepicker = ref(null);

function checkActiveDate(date){

    console.log('checkActiveDate');
    console.log(date);
    return paymentForm.value.payment_date === date;
}

import moment from 'moment';
function customFormatter(date){
    return date;
    return moment(date).format('DD/MM/yyyy');
}

</script>

<template>


    <Dialog :open="openDialog" @close="openDialog = false" class="relative z-50 dialog">
        <div class="fixed inset-0 bg-black/30" aria-hidden="true" />
        <div class="fixed inset-0 flex w-screen items-center justify-center p-4">
            <DialogPanel class="w-full max-w-xl rounded bg-white dialog-panel">
                <DialogTitle class="dialog-title">Add new transaction</DialogTitle>

                <form @submit.prevent="savePayment">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <input  class="text-center border-b-2 border-t-0 border-r-0 border-l-0 border-gray-300  focus:outline-none p-2" required type="text" v-model="paymentForm.amount">
                        </div>

                        <div class="col-span-1">

                            <RadioGroup v-model="paymentForm.payment_currency_id">
                                <RadioGroupOption
                                    class="radio-group-option"
                                    :key="currency.id"
                                    v-for="currency in currencies"
                                    :value="currency.id"
                                    as="template"
                                    v-slot="{ active, checked }"
                                >
                                    <div class="flex gap-4"
                                    >
                                        {{currency.name}}
                                        <CheckIcon class="h-4" v-show="checked" />
                                    </div>
                                </RadioGroupOption>
                            </RadioGroup>
                        </div>

                    </div>

                    <FormRow name="description" label="Description">
                        <textarea id="description" name="description" placeholder="Description" class="w-full rounded-md border-slate-300" v-model="paymentForm.description"></textarea>
                    </FormRow>


                    <FormRow name="date" label="Date">
                        <div class="flex gap-4 justify-between  items-center">
                            <div @click="setPaymentDate(date.date)" :key="date.date" v-for="date in defaultDates"
                                 class="cursor-pointer text-center p-1"  :class="{'active-date': customFormatter(paymentForm.payment_date) === date.date}">
                                <div>
                                    {{date.date}}
                                    <div class="text-sm">
                                        {{date.label}}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <VueDatePicker  dark class="w-4 small-datepicker" :enable-time-picker="false" v-model="paymentForm.payment_date"></VueDatePicker>
                            </div>
                        </div>
                    </FormRow>


                    <FormRow name="categories" label="Categories">
                        <div class="flex flex-row flex-wrap gap-4">
                            <div @click="setCategory(category.id)" :key="category.id" v-for="category in categories">
                                <div :style="{ backgroundColor: activeCategory === category.id ? category.icon.color : ''}"
                                     :class="{'text-white' : activeCategory === category.id}"
                                     class="p-2 rounded-md cursor-pointer" @click="activeCategory = category.id">
                                    {{category.name}}
                                    <component :style="{'backgroundColor':category.icon.color}"
                                               :is="HeroIcons[category.icon.icon]"
                                               class="h-8 cursor-pointer text-white rounded-md">
                                    </component>
                                </div>
                            </div>
                        </div>
                    </FormRow>


                    <div>
                        <PrimaryButton type="submit">ADD</PrimaryButton>
                    </div>

                </form>

            </DialogPanel>
        </div>
    </Dialog>



    <div>
        <CurrencyDollarIcon class="h-8"/> Total {{total}}
    </div>

    <div class="flex gap-4 ">
        <div :class="{'underline': paymentType.is_active}"  class="cursor-pointer bg-gray-500 text-white" @click="setActivePaymentType(paymentType.id)" :key="paymentType.id" v-for="paymentType in paymentTypes">
            {{paymentType.name}}
        </div>
    </div>

    <div>
        <PaymentsByCategoryChart :paymentsByCategory="paymentsByCategory" v-if="loaded"></PaymentsByCategoryChart>
    </div>


    <div v-if="summaries.length > 0" class="bg-gray-600 p-4 text-white">
        <div :key="summary.payment_currency_id" v-for="summary in summaries">
            <div>{{summary.currency.name}}</div>
            <div>{{summary.total_amount}}</div>
        </div>
    </div>


    <div>
        <div :key="paymentType.id" v-for="paymentType in paymentTypes">
          <div  v-if="paymentType.is_active">
              <PlusCircleIcon @click="openAddPaymentModal(paymentType.id)"  class="h-12 cursor-pointer"></PlusCircleIcon>
          </div>
        </div>


    </div>
</template>
