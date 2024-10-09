<script setup>
import {useStore} from "vuex";
const store = useStore();
import {useRouter} from "vue-router";
import {computed, onMounted, ref} from "vue";
const router = useRouter();
import ExchangeRate from "@/Pages/ExchangeRate/Index.vue";
import {
    Dialog, DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue'
import { Bars3Icon, XMarkIcon, UserIcon,  InformationCircleIcon} from '@heroicons/vue/24/outline'
import Footer from "./Layouts/Footer.vue";
import Locale from "./Layouts/Locale.vue";
import {useI18n} from "vue-i18n";

const logout = async () => {
    await store.dispatch('auth/logout');
    await router.push('/auth/login');
};

const user =  computed(()=>{
    return store.getters['auth/user']
})

const authenticated = computed(()=>{
    return store.getters['auth/authenticated']
})

const logoSrc = ref('');

async function getLogo() {
    try {
        const response = await axios.get(route('getLogo'));
        logoSrc.value = response.data;
    } catch (error) {
        console.error('Error fetching logo:', error);
    }
}

onMounted(()=>{
    getLogo();
})

const {locale, t} = useI18n();

const navigation = computed(()=>{
    return [
        { name: t('Home'), href: '/home', visible:authenticated.value },
        { name: t('Logout'), href: '/logout', visible:authenticated.value},
        { name: t('Login'), href: '/auth/login', visible:!authenticated.value },
        { name: t('Register'), href: '/auth/register', visible:!authenticated.value},
    ];
})

const visibleNavigation = computed(()=>{
    return navigation.value.filter((item)=> item.visible);
})

function navigate(href){
    if(href === '/logout'){
        logout();
    }
}

const showRate = ref(false);

const appName = import.meta.env.VITE_APP_NAME;

</script>

<template>
    <div class="min-h-screen flex flex-col">
        <nav>
            <Dialog :open="showRate" @close="showRate = false" class="relative z-50 dialog">
                <div class="fixed inset-0 bg-black/30" aria-hidden="true" />
                <div class="fixed inset-0 flex w-screen items-center justify-center p-4">
                    <DialogPanel class="w-full max-w-xl rounded bg-white dialog-panel">
                        <ExchangeRate></ExchangeRate>
                    </DialogPanel>
                </div>
            </Dialog>
            <Disclosure as="nav" v-slot="{ open }">
                <div class="mx-auto max-w-7xl menu-padding">
                    <div class="relative flex h-16 items-center justify-between">
                        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <!-- Mobile menu button-->
                            <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="absolute -inset-0.5" />
                                <span class="sr-only">{{$t('Open main menu')}}</span>
                                <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                                <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                            </DisclosureButton>
                        </div>

                        <div class="flex items-center justify-center sm:items-stretch sm:justify-start mr-8">
                            <div class="flex flex-shrink-0 items-center pl-12 sm:pl-0">
                               <router-link :to="{name:'home'}"><img v-if="logoSrc" class="logo" :src="logoSrc" :alt="appName"/></router-link>
                            </div>
                            <div class="hidden sm:ml-6 sm:block">
                                <div class="flex space-x-4">
                                    <router-link
                                        v-for="item in visibleNavigation"
                                        :key="item.name"
                                        :to="item.href"
                                        class="rounded-md px-3 py-2 text-sm font-medium  hover:text-white"
                                        @click="navigate(item.href)"
                                    >
                                        {{ item.name }}
                                    </router-link>
                                </div>
                            </div>
                        </div>

                        <div class="absolute inset-y-0 right-0 flex gap-4 items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <ExchangeRate class="hidden sm:inline text-white"></ExchangeRate>

                            <InformationCircleIcon @click="showRate = true" class="sm:hidden text-white h-8 cursor-pointer"></InformationCircleIcon>

                            <Menu v-if="authenticated" as="div" class="relative">
                                <div class="flex gap-4 items-center text-white \">
                                    <span class="hidden sm:inline">{{user.name}}</span>
                                    <MenuButton  class="text-white relative items-center gap-4  flex rounded-full  text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="absolute -inset-1.5" />
                                        <img v-if="user.avatar" class="h-8 w-8 rounded-full" :src="user.avatar" alt="" />
                                        <UserIcon class="h-6 w-6 rounded-full" v-else/>
                                    </MenuButton>
                                </div>
                                <MenuItems class="menu-items absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem class="sm:hidden">
                                        <span>{{user.name}}</span>
                                    </MenuItem>
                                    <MenuItem>
                                        <router-link class="rounded-md px-3 py-2 text-sm font-medium" :to="{name:'settings'}">{{$t('Settings')}}</router-link>
                                    </MenuItem>
                                </MenuItems>
                            </Menu>
                            <Locale></Locale>
                        </div>
                    </div>
                </div>
                <DisclosurePanel class="sm:hidden menu-padding">
                    <div class="flex flex-col gap-2">
                        <DisclosureButton v-for="item in visibleNavigation" :key="item.name" as="a" :href="item.href">{{ item.name }}</DisclosureButton>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </nav>

        <div class="container default-component flex-grow">
            <main>
                <router-view></router-view>
            </main>
        </div>
        <Footer/>
    </div>
</template>
