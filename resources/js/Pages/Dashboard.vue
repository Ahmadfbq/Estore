<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Dashboard from '@/Components/Dashboard.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white light:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <Dashboard />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
