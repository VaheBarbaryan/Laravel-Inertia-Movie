<script setup>
    const emit = defineEmits(['update:checked']);

    const props = defineProps({
        checked: {
            type: Number,
            default: 0,
        },
    });

    const handleChange = (event) => {
        const isChecked = event.target.checked;
        this.$emit('update:checked', isChecked ? 1 : 0);
    }
</script>


<template>
    <input
            :checked="checked === 1"
            type="checkbox"
            @change="handleChange"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    >
</template>
