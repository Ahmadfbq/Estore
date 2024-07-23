<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        default: false,
    },
    value: {
        type: String,
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>


<template>
    <input
        v-model="proxyChecked"
        type="checkbox"
        :value="value"
        class="rounded light:bg-gray-900 border-gray-300 light:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 light:focus:ring-indigo-600 light:focus:ring-offset-gray-800"
    >
</template>
