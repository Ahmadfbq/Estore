<script setup>
import { ref, computed } from 'vue';
import { useOrderStore } from '@/store/order';
import OrderView from './OrderView.vue';


const UserID = computed(() => {
  return window.$page.props.auth?.user?.id;
});

const orderStore = useOrderStore();
const authUserId = ref(null);

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

const formatCurrency = (amount) => {
  return `SAR ${amount.toFixed(2)}`;
};

const statusClass = (status) => {
  switch (status) {
    case 'Shipped':
      return 'text-blue-500';
    case 'Pending':
      return 'text-yellow-500';
      case 'Confirmed':
        return 'text-red-500'
    case 'Delivered':
      return 'text-green-500';
    default:
      return 'text-gray-500';
  }
};

const userOrders = computed(() => {
  if (!UserID.value || !orderStore.orders) return [];
  return orderStore.orders.filter(order => order.user_id === UserID.value);
});
</script>

<template>
    <div class="container mx-auto mt-10 mb-10">
      <h1 class="text-3xl font-bold mb-5">My Orders</h1>
      <div v-if="userOrders.length" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="order in userOrders" :key="order.id" class="bg-gray-100 p-6 rounded-lg shadow-md">
          <h2 class="text-xl font-semibold mb-2">Order ID: {{ order.id }}</h2>
          <p class="text-gray-700">Date: {{ formatDate(order.created_at) }}</p>
          <p class="text-gray-700">Status: <span :class="statusClass(order.status)">{{ order.status }}</span></p>
          <p class="text-gray-700">Total: {{ formatCurrency(order.total_price) }}</p>
          <OrderView :order="order" />
        </div>
      </div>
      <div v-else class="text-center py-20">
        <p class="text-lg text-gray-500">You have no orders yet.</p>
      </div>
    </div>
  </template>