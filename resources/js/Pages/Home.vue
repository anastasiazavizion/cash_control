<script setup>
import { BeakerIcon, BellIcon, PlusCircleIcon } from '@heroicons/vue/24/solid'
import * as HeroIcons from '@heroicons/vue/24/solid'
import {useStore} from "vuex";
import {onMounted, ref} from "vue";

const icons = {
    BeakerIcon,
    BellIcon
}

const store = useStore();

const categories = ref([]);
const paymentTypes = ref([]);
const currencies = ref([]);

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

})



import {
    Dialog,
    DialogPanel,
    DialogTitle,
    DialogDescription,
} from '@headlessui/vue'

const isOpen = ref(false)

function setIsOpen(value) {
    isOpen.value = value
}



function openAddPaymentModal(paymentTypeId){
    console.log(paymentTypeId);

    setIsOpen(true);

}

const paymentForm = ref({
    amount:0,
    category_id:null,
    payment_date:null,
    description:null,
    payment_type_id:1,
    payment_currency_id:1,
})

const activeCategory = ref(null);


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
    return `${month}/${day}`;
}

const today = new Date();
const yesterday = new Date();
yesterday.setDate(today.getDate() - 1);
const twoDaysAgo = new Date();
twoDaysAgo.setDate(today.getDate() - 2);

const todayDate = formatDate(today);
const yesterdayDate = formatDate(yesterday);
const twoDaysAgoDate = formatDate(twoDaysAgo);

const defaultDates = [
    {'date':todayDate, label:'today'},
    {'date':yesterdayDate, label:'yesterday'},
    {'date':twoDaysAgoDate, label:'2 days ago'},
];


function setActivePaymentType(id){

    paymentForm.value.payment_type_id = id;

    paymentTypes.value = paymentTypes.value.map((item, index)=>{
        return {
            ...item,
            is_active : item.id === id
        }
    })

}


import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


import {
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue'
import { CheckIcon } from '@heroicons/vue/20/solid'

</script>

<template>


    <Dialog :open="isOpen" @close="setIsOpen" class="relative z-50">
        <div class="fixed inset-0 bg-black/30" aria-hidden="true" />

        <div class="fixed inset-0 flex w-screen items-center justify-center p-4">
            <DialogPanel class="w-full max-w-sm rounded bg-white">

                <DialogTitle>Deactivate account</DialogTitle>
                <DialogDescription>
                    This will permanently deactivate your account
                </DialogDescription>

                <form @submit.prevent="savePayment">
                    <div>
                        Amount:
                        <input required type="text" v-model="paymentForm.amount">
                    </div>

                    <div>
                        Currency:


                        <RadioGroup v-model="paymentForm.payment_currency_id">
                            <RadioGroupLabel>Currency</RadioGroupLabel>

                            <RadioGroupOption
                                :key="currency.id"
                                v-for="currency in currencies"
                                :value="currency.id"
                                as="template"
                                v-slot="{ active, checked }"
                            >
                                <div
                                    :class="{
          'bg-blue-500 text-white': active,
          'bg-white text-black': !active,
        }"

                                    class="flex gap-4"
                                >
                                    {{currency.name}}
                                    <CheckIcon class="h-4" v-show="checked" />
                                </div>
                            </RadioGroupOption>


                        </RadioGroup>




                    </div>

                    <div>
                        Description:
                        <textarea v-model="paymentForm.description"></textarea>
                    </div>

                    <div>
                        Date:

                        <div class="flex gap-4">
                            <div @click="setPaymentDate(date.date)" :key="date.date" v-for="date in defaultDates"
                                 class="cursor-pointer bg-green-500 text-white ">
                                <div>
                                    {{date.date}}
                                    <div>
                                        {{date.label}}
                                    </div>
                                </div>
                            </div>

                            <VueDatePicker :enable-time-picker="false" v-model="paymentForm.payment_date"></VueDatePicker>


                        </div>
                    </div>

                    <div class="flex flex-row flex-wrap gap-4">
                        <div @click="setCategory(category.id)" :key="category.id" v-for="category in categories">
                            <div :style="{ backgroundColor: activeCategory === category.id ? category.icon.color : ''}"
                                 :class="{'text-white' : activeCategory === category.id}"
                                 class="p-2" @click="activeCategory = category.id">
                                {{category.name}}
                                <component :style="{'backgroundColor':category.icon.color}"  :is="HeroIcons[category.icon.icon]"
                                           class="h-8 cursor-pointer text-white rounded-md"></component>
                            </div>
                        </div>
                    </div>

                    <div>
                        <button type="submit">ADD</button>
                    </div>

                </form>


                <button @click="setIsOpen(false)">Cancel</button>
                <!-- ... -->
            </DialogPanel>


        </div>
    </Dialog>


    <div class="flex gap-4 ">
        <div :class="{'underline': paymentType.is_active}"  class="cursor-pointer bg-gray-500 text-white" @click="setActivePaymentType(paymentType.id)" :key="paymentType.id" v-for="paymentType in paymentTypes">
            {{paymentType.name}}
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
