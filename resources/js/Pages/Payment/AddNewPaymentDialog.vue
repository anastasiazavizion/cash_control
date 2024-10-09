<script setup>
import {Dialog,DialogPanel, DialogTitle} from "@headlessui/vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import * as HeroIcons from "@heroicons/vue/24/solid/index.js";
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import FormRow from "../../Components/FormRow.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import Errors from "../../Components/Errors.vue";
import {XMarkIcon} from "@heroicons/vue/24/solid";

const categories = computed(()=>{
    return store.getters['category/categories'];
});

const activeCategory = ref(null);

const store = useStore();

onMounted(async () => {
    await store.dispatch('category/getCategories');
})

const props = defineProps({
    paymentForm:Object,
    errors:Object,
    openDialog:{
        type:Boolean,
        default:false
    }
})

const emits = defineEmits(['save-payment', 'close-dialog'])
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

props.paymentForm.payment_date = today;

const defaultDates = [
    {'date':today, 'formated_date':todayDate, label:'today'},
    {'date':yesterday, 'formated_date':yesterdayDate, label:'yesterday'},
    {'date':twoDaysAgo, 'formated_date':twoDaysAgoDate, label:'2 days ago'},
];

function setCategory(categoryId){
    props.paymentForm.category_id = categoryId;
}

function compareDates(date1, date2){
    return (
        date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() && // Months are 0-indexed, so January is 0
        date1.getDate() === date2.getDate()
    );
}
</script>

<template>
    <Dialog :open="openDialog" @close="emits('close-dialog')" class="relative z-50 dialog">
        <div class="fixed inset-0 bg-black/30" aria-hidden="true" />
        <div class="fixed inset-0 flex w-screen items-center justify-center p-4">
            <DialogPanel class="w-full max-w-xl rounded bg-white dialog-panel">
                <div class="relative">
                    <XMarkIcon @click="emits('close-dialog')" class="icon right-position"/>
                </div>
                <DialogTitle class="dialog-title">{{$t('Add new transaction')}}</DialogTitle>
                <form @submit.prevent="savePayment">
                    <FormRow name="amount" :label="$t('Amount')">
                        <input  class="form-control" required type="text" v-model="paymentForm.amount">
                        <Errors v-if="errors" :errors="errors.amount"/>
                    </FormRow>

                    <FormRow name="description" :label="$t('Description')">
                        <textarea id="description" name="description" placeholder="Description" class="form-control" v-model="paymentForm.description"></textarea>
                    </FormRow>

                    <FormRow name="date" :label="$t('Date')">
                        <div class="flex justify-between gap-8">
                            <div class="flex flex-col w-1/2 gap-2">
                                <div @click="setPaymentDate(date.date)" :key="date.date" v-for="date in defaultDates"
                                     class="cursor-pointer text-center p-1 w-full"  :class="{'active-date': compareDates(paymentForm.payment_date, date.date)}">
                                    <div>
                                        {{date.formated_date}}
                                        <div class="text-sm">
                                            {{date.label}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <VueDatePicker format="dd/MM/yyyy" class="w-full small-datepicker" :enable-time-picker="false" v-model="paymentForm.payment_date"></VueDatePicker>
                            </div>
                        </div>
                    </FormRow>

                    <FormRow name="categories" :label="$t('Categories')">
                        <div class="flex flex-row flex-wrap gap-4">
                            <div @click="setCategory(category.id)" :key="category.id" v-for="category in categories">
                                <div :style="{ backgroundColor: activeCategory === category.id ? category.icon.color : ''}"
                                     :class="{'text-white' : activeCategory === category.id}"
                                     class="p-2 rounded-md cursor-pointer" @click="activeCategory = category.id">
                                    {{category.name}}
                                    <component :style="{'backgroundColor':category.icon.color}"
                                               :is="HeroIcons[category.icon.icon]"
                                               class="category-icon-component">
                                    </component>
                                </div>
                            </div>
                        </div>
                        <Errors v-if="errors" :errors="errors.category_id"/>
                    </FormRow>

                    <div class="flex">
                        <PrimaryButton class="ml-auto" type="submit">{{$t('ADD')}}</PrimaryButton>
                    </div>
                </form>
            </DialogPanel>
        </div>
    </Dialog>
</template>
