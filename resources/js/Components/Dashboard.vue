<script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import OrderAdminView from './OrderAdminView.vue';
  
  const orders = ref([]);
  const users = ref([]);
  const statistics = ref({
    ordersThisWeek: 0,
    ordersThisMonth: 0,
    revenueThisMonth: 0
  });
  const topProducts = ref([]);
  
  const fetchDashboardData = async () => {
    try {
      // Fetch orders
      const ordersResponse = await axios.get('/api/orders');
      orders.value = ordersResponse.data;

      // Extract user IDs from orders and fetch user details
    const userIds = orders.value.map(order => order.user_id);
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
      
      // Fetch statistics
      const statsResponse = await axios.get('/api/statistics');
      statistics.value = statsResponse.data;
  
      // Fetch top products
      const productsResponse = await axios.get('/api/top-products');
      topProducts.value = productsResponse.data;
    } catch (error) {
      console.error('Error fetching dashboard data:', error);
    }
  };
  
  onMounted(() => {
    fetchDashboardData();
  });

  const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };
  return date.toLocaleString(undefined, options);
};
  </script>

<template>
    <div class="dashboard p-6">
      <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
      
      <!-- Orders Section -->
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Customer Orders</h2>
        <div v-if="orders.length">
          <ul>
            <li v-for="order in orders" :key="order.id" class="border-b py-2">
              <div class="flex justify-between items-center">
                <div>
                  <span class="font-medium">Order #{{ order.id }}</span> - {{ users[order.user_id]?.name || 'User not found' }} - SAR {{ order.total_price }}
                  <span class="text-gray-500 text-sm">({{ formatDate(order.created_at) }})</span>
                </div>
                <OrderAdminView :order="order" />
              </div>
            </li>
          </ul>
        </div>
        <div v-else>
          <p class="text-gray-500">No orders to display.</p>
        </div>
      </div>
      
      <!-- Statistics Section -->
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Statistics</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
          <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-medium">Orders This Week</h3>
            <p class="text-2xl font-bold">{{ statistics.ordersThisWeek }}</p>
          </div>
          <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-medium">Orders This Month</h3>
            <p class="text-2xl font-bold">{{ statistics.ordersThisMonth }}</p>
          </div>
          <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-medium">Total Revenue This Month</h3>
            <p class="text-2xl font-bold">SAR {{ statistics.revenueThisMonth.toFixed(2) }}</p>
          </div>
        </div>
      </div>
      
      <!-- Highest Demand Products Section -->
      <div>
        <h2 class="text-xl font-semibold mb-2">Highest Demand Products</h2>
        <div v-if="topProducts.length">
          <ul>
            <li v-for="product in topProducts" :key="product.id" class="border-b py-2">
              <span class="font-medium">{{ product.name }}</span> - {{ product.quantitySold }} sold
            </li>
          </ul>
        </div>
        <div v-else>
          <p class="text-gray-500">No data available.</p>
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .dashboard {
    max-width: 1200px;
    margin: auto;
  }
  
  .bg-white {
    background-color: #ffffff;
  }
  
  .shadow {
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  </style>
  