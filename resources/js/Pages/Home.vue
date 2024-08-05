<template>
<!--
    <component :is="icons[iconName]" class="h-18" />
-->

<!--
    <component v-for="icon in HeroIcons" :is="icon" class="h-24"></component>
-->

<!--    <component :is="HeroIcons[iconName]" class="h-24"></component>-->


<!--
    <component v-for="icon in HeroIcons" :is="icon" class="h-24"></component>
-->


    <div :key="category.id" v-for="category in categories">
        {{category.name}}
        <component :is="HeroIcons[category.icon.icon]" class="h-24"></component>
    </div>

</template>

<script setup>
import { BeakerIcon, BellIcon } from '@heroicons/vue/24/solid'
import * as HeroIcons from '@heroicons/vue/24/solid'
import {useStore} from "vuex";
import {onMounted, ref} from "vue";

const icons = {
    BeakerIcon,
    BellIcon
}


const iconName = 'AcademicCapIcon' // Change this to render different icons

const store = useStore();

const categories = ref([]);

onMounted(async () => {

    await store.dispatch('category/getCategories');

    categories.value = store.getters['category/categories'];

})

</script>
