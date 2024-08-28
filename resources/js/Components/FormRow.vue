<script setup>
defineProps({
    label:{
        required:true,
        type:String
    },
    name:{
        required:true,
        type:String
    },
})
</script>

<template>
    <div class="flex flex-col gap-2 mb-2">
        <div class="text-sm font-bold">
            <label :for="name">{{label}}</label>
        </div>
        <div>
            <slot></slot>
        </div>
    </div>
</template>
