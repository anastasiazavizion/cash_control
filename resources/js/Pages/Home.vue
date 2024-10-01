<script setup>
import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue'
import listenLimitEvents from '../hooks/listenLimitEvents.js'

import PaymentsByCategoryChart from "./Payment/PaymentsByCategoryChart.vue";
import PaymentsByCategory from "./Payment/PaymentsByCategory.vue";
import AddNewPaymentDialog from "./Payment/AddNewPaymentDialog.vue";
import {CurrencyDollarIcon} from '@heroicons/vue/24/solid'
import {Menu, MenuButton, MenuItems, MenuItem} from '@headlessui/vue'
import Price from "../Components/Price.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";
import VueDatePicker from '@vuepic/vue-datepicker';

import {useI18n} from "vue-i18n";

const {t} = useI18n();

const store = useStore();

const categories = computed(() => {
    return store.getters['category/categories'];
})

const paymentTypes = computed(() => {
    return store.getters['paymentType/paymentTypes'].map((item, index) => {
        return {
            ...item,
            is_active: index === 0
        }
    });
})


const total = computed(() => {
    return store.getters['payment/total'];
})

const totalSum = computed(() => {
    return store.getters['payment/totalSum'];
})

const paymentsByCategory = computed(() => {
    return store.getters['payment/paymentsByCategory'];
})

const loaded = ref(false);

const filters = ref({
    categories:[],
    date_from:null,
    date_to:null,
});

async function getPaymentsByTypeId(id) {
    loaded.value = false;

    await store.dispatch('payment/getPaymentsByType', {...filters.value, 'payment_type_id': id});

    await store.dispatch('payment/getTotalSum', filters.value);
    loaded.value = true;
}

const activePaymentType = ref(0);

async function loadData() {
    await store.dispatch('payment/clearErrors');

    const defaultPaymentTypeId = paymentTypes.value[0].id;
    activePaymentType.value = defaultPaymentTypeId;

    await getPaymentsByTypeId(defaultPaymentTypeId);
}
onMounted(async () => {

    await store.dispatch('category/getCategories');

    await store.dispatch('paymentType/getPaymentTypes');

    await loadData();

    loaded.value = true;
})

const paymentForm = ref({
    amount: 0,
    category_id: null,
    payment_date: null,
    description: null,
    payment_type_id: 1,
    payment_currency_id: 1,
})

const openDialog = ref(false);

function closeDialog() {
    openDialog.value = false;
}

const errors = computed(() => {
    return store.getters['payment/errors'];
})

async function savePayment(form) {
    await store.dispatch('payment/savePayment', form);
    if (Object.keys(errors.value).length === 0) {
        await getPaymentsByTypeId(form.payment_type_id);
        closeDialog();
    }
}

async function setActivePaymentType(id) {
    paymentForm.value.payment_type_id = id;
    activePaymentType.value = id;
    await getPaymentsByTypeId(id);
}

onMounted(() => {
    listenLimitEvents();
})

async function removePayment(id) {
    loaded.value = false;
    await store.dispatch('payment/removePayment', id)
    await getPaymentsByTypeId(activePaymentType.value);
    loaded.value = true;
}

const visibleCategories = ref([]);

function saveVisibleCategories(categories) {
    visibleCategories.value = categories;
}

function makeReport(type) {
    axios.get(route('report'), {
        params: {type: type},
        responseType: 'blob'
    }).then(response => {
        if(response.data){
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'report.' + type);
            document.body.appendChild(link);
            link.click();
            link.remove(); // Clean up the DOM after download
        }
    }).catch(error => {
        alert(t('There was an error downloading the file'), error);
    });
}

const reportLinks = [
    {label: 'Pdf', type: 'pdf'},
    {label: 'Excel', type: 'xlsx'},
]


const showFilters = ref(false);

function applyFilters() {
    console.log('applyFilters');
    loadData();
}

function setFilterCategories(id){
    if(!isInFiltersCategories(id)){
        filters.value.categories.push(id);
    }else{
        filters.value.categories.splice(filters.value.categories.indexOf(id),1);
    }
}

function isInFiltersCategories(id){
    return filters.value.categories.indexOf(id) !== -1;
}
</script>

<template>
    <div>
        <AddNewPaymentDialog :errors="errors" @close-dialog="closeDialog" @save-payment="savePayment"
                             :payment-form="paymentForm" :open-dialog="openDialog"/>

        <div class="flex gap-4">
            <Menu as="div" class="relative inline-block text-left">
                <MenuButton @click="showFilters = false" class="primary-btn">{{$t('Create report')}}</MenuButton>
                <MenuItems
                    class="absolute left-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                    <MenuItem
                        as="template"
                        @click="makeReport(link.type)"
                        v-for="link in reportLinks"
                        :key="link.type"
                        class="cursor-pointer hover:bg-slate-100 ui-active:bg-blue-500 ui-active:text-white ui-not-active:bg-white ui-not-active:text-black  text-gray-900 group flex w-full items-center  px-2 py-2 text-sm"
                    >
                        <div>{{ link.label }}</div>
                    </MenuItem>

                </MenuItems>
            </Menu>
            <PrimaryButton @click="showFilters = !showFilters">{{$t('Filter')}}</PrimaryButton>
        </div>

        <div v-if="showFilters" class="absolute w-full p-4 bg-white rounded-lg shadow-md mt-4">
            <form class="product-filter-form" @submit.prevent="applyFilters">
                <div class="mb-4">
                    <div class="font-bold">{{$t('Categories')}}</div>
                    <div class="flex flex-col gap-2">
                        <div :key="category.id" v-for="category in categories">
                            <div class="items-center flex gap-1">
                                <input type="checkbox" @click="setFilterCategories(category.id)">
                                <div class="inline-block shadow-sm  w-4 h-4 rounded-full" :style="{'backgroundColor': category.icon.color}"></div>
                                <span>{{category.name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sm:flex sm:gap-4 sm:items-center">
                    <div class="font-bold">{{$t('Date From')}}</div>
                    <div>
                        <VueDatePicker format="dd/MM/yyyy" :enable-time-picker="false" v-model="filters.date_from"></VueDatePicker>
                    </div>
                    <div class="font-bold">{{$t('Date To')}}</div>
                    <div>
                        <VueDatePicker format="dd/MM/yyyy" :enable-time-picker="false" v-model="filters.date_to"></VueDatePicker>
                    </div>
                </div>
                <div class="mb-4">
                    <PrimaryButton>{{$t('Apply Filters')}}</PrimaryButton>
                </div>
            </form>
        </div>

        <div class="mb-4 mt-4 text-center">
            <CurrencyDollarIcon class="h-6"></CurrencyDollarIcon>
            {{$t('Total')}}
            <Price>{{ totalSum }}</Price>
        </div>

        <TabGroup>
            <TabList class="text-center grid grid-cols-2 mt-8">
                <Tab :class="[activePaymentType === (id+1) ? 'active-tab' : '']" class="mr-4 tab"
                     @click="setActivePaymentType(paymentType.id)" :key="paymentType.id"
                     v-for="(paymentType,id) in paymentTypes">
                    {{ paymentType.name }}
                </Tab>
            </TabList>

            <TabPanels class="mt-4 min-h-40 sm:min-h-80">
                <div>
                    <TabPanel :key="paymentType.id" v-for="paymentType in paymentTypes">

                        <PrimaryButton class="mb-4" @click="openDialog = true">
                            {{$t('Add new transaction')}}
                        </PrimaryButton>

                        <div>
                            <PaymentsByCategoryChart :total="total" :paymentsByCategory="paymentsByCategory" v-if="loaded"/>
                        </div>
                        <div class="mt-4">
                            <PaymentsByCategory @save-visible-categories="saveVisibleCategories"
                                                @remove-payment="removePayment" v-if="loaded"
                                                :categories="paymentsByCategory"
                                                :visibleCategories="visibleCategories"
                            />
                        </div>
                    </TabPanel>
                </div>
            </TabPanels>
        </TabGroup>
    </div>
</template>
