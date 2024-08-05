<template>
<!--
    <component :is="icons[iconName]" class="h-18" />
-->

<!--
    <component v-for="icon in HeroIcons" :is="icon" class="h-24"></component>
-->

<!--    <component :is="HeroIcons[iconName]" class="h-24"></component>-->


    <component v-for="icon in HeroIcons" :is="icon" class="h-24"></component>

</template>

<script setup>
import { BeakerIcon, BellIcon } from '@heroicons/vue/24/solid'
import * as HeroIcons from '@heroicons/vue/24/solid'

const icons = {
    BeakerIcon,
    BellIcon
}


const iconName = 'AcademicCapIcon' // Change this to render different icons


</script>
