<script setup>
import {Dialog,DialogPanel, DialogTitle, RadioGroup, RadioGroupOption} from "@headlessui/vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

import * as HeroIcons from "@heroicons/vue/24/solid/index.js";
import {CheckIcon}  from '@heroicons/vue/24/solid'
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import FormRow from "../../Components/FormRow.vue";

const currencies = ref([]);
const categories = ref([]);
const activeCategory = ref(null);


const store = useStore();


onMounted(async () => {
    await store.dispatch('category/getCategories');
    categories.value = store.getters['category/categories'];

    await store.dispatch('currency/getCurrencies');
    currencies.value = store.getters['currency/currencies'];
})

const props = defineProps({
    paymentForm:Object,
    openDialog:{
        type:Boolean,
        default:false
    }
})

const emits = defineEmits(['save-payment'])
function savePayment(){
    emits('save-payment', props.paymentForm);
}

function setPaymentDate(date){
    props.paymentForm.payment_date = date;
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

props.paymentForm.payment_date = todayDate;

const defaultDates = [
    {'date':todayDate, label:'today'},
    {'date':yesterdayDate, label:'yesterday'},
    {'date':twoDaysAgoDate, label:'2 days ago'},
];


import moment from 'moment';
import PrimaryButton from "../../Components/PrimaryButton.vue";
function customFormatter(date){
    return date;
    return moment(date).format('DD/MM/yyyy');
}

function setCategory(categoryId){
    props.paymentForm.category_id = categoryId;
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

</template>

<style scoped>

</style>
