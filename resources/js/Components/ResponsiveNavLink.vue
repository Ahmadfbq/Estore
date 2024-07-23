<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-green-400 light:border-green-600 text-start text-base font-medium text-green-700 light:text-green-300 bg-green-50 light:bg-green-900/50 focus:outline-none focus:text-green-800 light:focus:text-green-200 focus:bg-green-100 light:focus:bg-green-900 focus:border-green-700 light:focus:border-green-300 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-green-600 light:text-green-400 hover:text-green-800 light:hover:text-green-200 hover:bg-green-50 light:hover:bg-green-700 hover:border-green-300 light:hover:border-green-600 focus:outline-none focus:text-green-800 light:focus:text-green-200 focus:bg-green-50 light:focus:bg-green-700 focus:border-green-300 light:focus:border-green-600 transition duration-150 ease-in-out';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-start">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
            <slot />
        </Link>
    </div>
</template>
