<script setup>
import { ref, onMounted } from 'vue';
import { useOrderStore } from '@/store/order';

const orderStore = useOrderStore();
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

onMounted(async () => {
  try {
    // Extract and fetch unique users
    const userIds = orderStore.orders.value.map(order => order.user_id);
    const uniqueUserIds = [...new Set(userIds)];

    if (uniqueUserIds.length > 0) {
      const usersResponse = await axios.get('/api/users', {
        params: { ids: uniqueUserIds.join(',') }
      });
      users.value = usersResponse.data.reduce((acc, user) => {
        acc[user.id] = user;
        return acc;
      }, {});
    }
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});


const viewOrder = (orderId) => {
  // Handle order detail view
  console.log(`Viewing details for order ${orderId}`);
};
</script>

<template>
    <div class="container mx-auto mt-10">
      <h1 class="text-3xl font-bold mb-5">My Orders</h1>
      <div v-if="orderStore.orders.length" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        <div v-for="order in orderStore.orders" :key="order.id" class="bg-white p-6 rounded-lg shadow-md">
          <h2 class="text-xl font-semibold mb-2">Order ID: {{ order.id }}</h2>
          <p class="text-gray-700">Date: {{ formatDate(order.created_at) }}</p>
          <p class="text-gray-700">Status: <span :class="statusClass(order.status)">{{ order.status }}</span></p>
          <p class="text-gray-700">Total: {{ formatCurrency(order.total_price) }}</p>
          <button @click="viewOrder(order.id)" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            View Details
          </button>
        </div>
      </div>
      <div v-else class="text-center py-20">
        <p class="text-lg text-gray-500">You have no orders yet.</p>
      </div>
    </div>
  </template>