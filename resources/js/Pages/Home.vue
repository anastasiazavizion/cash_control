<script setup>
import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'

import PaymentsByCategoryChart from "./Payment/PaymentsByCategoryChart.vue";
import PaymentsByCategory from "./Payment/PaymentsByCategory.vue";
import AddNewPaymentDialog from "./Payment/AddNewPaymentDialog.vue";
import {PlusIcon, CurrencyDollarIcon}  from '@heroicons/vue/24/solid'

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

    console.log(paymentsByCategory.value);


    loaded.value = true;
}

const activePaymentType = ref(0);

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

function savePayment(form){
   store.dispatch('payment/savePayment', form);
    getPaymentsByTypeId(form.payment_type_id);
    closeDialog();
}

async function setActivePaymentType(id) {
    paymentForm.value.payment_type_id = id;
    paymentTypes.value = paymentTypes.value.map((item, index) => {
        return {
            ...item,
            is_active: item.id === id
        }
    })
    activePaymentType.value = id;
    await getPaymentsByTypeId(id);
}

import { useToast } from "vue-toastification";

const user =  computed(()=>{
    return store.getters['auth/user']
})

onMounted(()=>{
    window.Echo.private('payment_per_day_limit_channel_'+user.value.id)
        .listen('PaymentPerDayLimitEvent', (e) => {
            const toast = useToast();
            toast("You have exceeded your daily limit " + e.limit + "!");
        });

    window.Echo.private('payment_per_month_limit_channel_'+user.value.id)
        .listen('PaymentPerMonthLimitEvent', (e) => {
            const toast = useToast();
            toast("You have exceeded your month limit " + e.limit + "!");
        });
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
        console.error('There was an error downloading the file!', error);
    });
}

import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
const reportLinks = [
    { label: 'Pdf', type:'pdf'},
    { label: 'Excel', type:'xlsx' },
]

</script>

<template>
    <AddNewPaymentDialog @close-dialog="closeDialog" @save-payment="savePayment" :payment-form="paymentForm"  :open-dialog="openDialog"/>

    <div class="relative mb-4">
        <Menu>
            <MenuButton class="inline-flex justify-center rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75">Create report</MenuButton>
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
</template>
