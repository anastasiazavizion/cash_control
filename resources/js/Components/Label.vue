<script setup>
defineProps({
    name:String
})
</script>

<template>
    <label :for="name" class="block text-sm font-medium leading-6 text-gray-900"><slot></slot></label>
</template>
