<script setup>
import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

import listenLimitEvents from '../hooks/listenLimitEvents.js'

import PaymentsByCategoryChart from "./Payment/PaymentsByCategoryChart.vue";
import PaymentsByCategory from "./Payment/PaymentsByCategory.vue";
import AddNewPaymentDialog from "./Payment/AddNewPaymentDialog.vue";
import {PlusIcon, CurrencyDollarIcon}  from '@heroicons/vue/24/solid'

const store = useStore();

const categories = computed(()=>{
    return  store.getters['category/categories'];
})

const currencies = computed(()=>{
    return store.getters['currency/currencies'];
})

const paymentTypes = computed(()=>{
    return store.getters['paymentType/paymentTypes'].map((item, index)=>{
        return {
            ...item,
            is_active : index === 0
        }
    });
})



const total = computed(()=>{
    return store.getters['payment/total'];
})

const totalSum = computed(()=>{
    return store.getters['payment/totalSum'];
})

const paymentsByCategory = computed(()=>{
    return store.getters['payment/paymentsByCategory'];
})

const loaded = ref(false);

async function getPaymentsByTypeId(id) {
    loaded.value = false;

    await store.dispatch('payment/getPaymentsByType', {'payment_type_id': id});

    await store.dispatch('payment/getTotalSum');
    loaded.value = true;
}

const activePaymentType = ref(0);

onMounted(async () => {

    await store.dispatch('payment/clearErrors');

    await store.dispatch('category/getCategories');

    await store.dispatch('paymentType/getPaymentTypes');

    await store.dispatch('currency/getCurrencies');


    const defaultPaymentTypeId = paymentTypes.value[0].id;
    activePaymentType.value = defaultPaymentTypeId;

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

function closeDialog(){
    openDialog.value = false;
}


const errors = computed(()=>{
    return store.getters['payment/errors'];
})


async function savePayment(form) {
    await store.dispatch('payment/savePayment', form);

    if(Object.keys(errors.value).length === 0){
        await getPaymentsByTypeId(form.payment_type_id);
        closeDialog();
    }
}

async function setActivePaymentType(id) {
    paymentForm.value.payment_type_id = id;
    activePaymentType.value = id;
    await getPaymentsByTypeId(id);
}

onMounted(()=>{
    listenLimitEvents();
})

async function removePayment(id) {
    loaded.value = false;
    await store.dispatch('payment/removePayment', id)
    await getPaymentsByTypeId(activePaymentType.value);
    loaded.value = true;
}

const visibleCategories = ref([]);

function saveVisibleCategories(categories){
    visibleCategories.value = categories;
}

function makeReport(type){
    axios.get('/report', {
        params:{type:type},
        responseType: 'blob'
    }).then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'report.'+type);
        document.body.appendChild(link);
        link.click();
        link.remove(); // Clean up the DOM after download
    }).catch(error => {
        alert('There was an error downloading the file!', error);
    });
}

import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import Price from "../Components/Price.vue";
const reportLinks = [
    { label: 'Pdf', type:'pdf'},
    { label: 'Excel', type:'xlsx' },
]

</script>

<template>
    <div>
    <AddNewPaymentDialog :errors="errors" @close-dialog="closeDialog" @save-payment="savePayment" :payment-form="paymentForm"  :open-dialog="openDialog"/>

    <div class="relative mb-4">
        <Menu>
            <MenuButton class="primary-btn">Create report</MenuButton>
            <MenuItems class="absolute left-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                <MenuItem
                    as="template"
                    @click="makeReport(link.type)"
                    v-for="link in reportLinks"
                    :key="link.type"
                    class="cursor-pointer ui-active:bg-blue-500 ui-active:text-white ui-not-active:bg-white ui-not-active:text-black  text-gray-900 group flex w-full items-center rounded-md px-2 py-2 text-sm"
                >
                    <div>{{link.label }}</div>
                </MenuItem>

            </MenuItems>
        </Menu>
    </div>

    <div class="mb-4 text-center">
        <CurrencyDollarIcon class="h-6"></CurrencyDollarIcon> Total <Price>{{totalSum}}</Price>
    </div>

    <TabGroup>
        <TabList class="text-center grid grid-cols-2">
            <Tab  :class="[activePaymentType === (id+1) ? 'active-tab' : '']" class="mr-4 tab" @click="setActivePaymentType(paymentType.id)" :key="paymentType.id" v-for="(paymentType,id) in paymentTypes">
                {{paymentType.name}}
            </Tab>
        </TabList>

        <TabPanels class="mt-4">
            <div>
               <TabPanel :key="paymentType.id" v-for="paymentType in paymentTypes">
                    <PlusIcon @click="openDialog = true"  class="h-8 cursor-pointer bg-black text-white rounded-md"></PlusIcon>

                   <div>
                       <PaymentsByCategoryChart :total="total" :paymentsByCategory="paymentsByCategory" v-if="loaded"></PaymentsByCategoryChart>
                   </div>
                   <div class="mt-4">
                       <PaymentsByCategory @save-visible-categories="saveVisibleCategories"
                                           @remove-payment="removePayment" v-if="loaded"
                                           :categories="paymentsByCategory"
                                           :visibleCategories="visibleCategories"
                       >
                       </PaymentsByCategory>
                   </div>
                </TabPanel>
            </div>
        </TabPanels>
    </TabGroup>
    </div>
</template>
