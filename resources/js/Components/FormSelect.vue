<template>
    <select class="form-select border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
             :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        <slot/>
    </select>
</template>

<script setup>
    import {defineProps} from 'vue';

    defineProps({
        modelValue: Number,
    });

</script>

<style scoped>

</style>