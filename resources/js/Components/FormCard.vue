<script setup>
import Header from "./Header.vue";
defineProps({
    header:String
})
</script>

<template>
    <div class="form-card flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <Header>{{header}}</Header>
        </div>

        <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-sm">
            <slot></slot>
        </div>
    </div>
</template>
